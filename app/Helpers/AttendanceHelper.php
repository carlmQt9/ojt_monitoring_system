<?php

namespace App\Helpers;

use App\Models\TimeInRecord;
use App\Models\DailyHourLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceHelper
{
    /**
     * Calculates approved hours for a student on a given date.
     *
     * @param int $studentId
     * @param string $date
     * @return array{regular_hours: float, ot_hours: float, total_hours: float}
     */
    public static function computeDailyTotalsForStudent(int $studentId, string $date): array
    {
        $targetDate = Carbon::parse($date)->toDateString();

        $records = TimeInRecord::where('student_id', $studentId)
            ->whereDate('date', $targetDate)
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('status', 'verified');
            })
            ->get();

        $otLetterExists = \App\Models\StudentRequirement::where('student_id', $studentId)
                ->whereDate('created_at', $targetDate)
                ->whereIn('status', ['pending', 'approved'])
                ->where(function ($query) {
                    $query->where('title', 'like', '%OT%')
                        ->orWhere('title', 'like', '%overtime%')
                        ->orWhere('title', 'like', '%over time%');
                })
                ->exists();

        $regularHours = 0.0;
        $otHours = 0.0;

        foreach ($records as $record) {
            $regularHours += (float) ($record->regular_hours ?? 0);

            $recordOtHours = (float) ($record->ot_hours ?? 0);
            if ($recordOtHours > 0) {
                $otHours += $recordOtHours;
                continue;
            }

            if (!$otLetterExists || !$record->time_in || !$record->time_out) {
                continue;
            }

            $inTime = Carbon::parse($record->time_in);
            $outTime = Carbon::parse($record->time_out);
            if ($outTime->lte($inTime)) {
                $outTime->addDay();
            }

            $workedHours = max(0, $inTime->diffInMinutes($outTime) / 60);
            $inferredOtHours = max(0, round($workedHours - (float) ($record->regular_hours ?? 0), 2));
            if ($inferredOtHours > 0) {
                $otHours += $inferredOtHours;
            }
        }

        $regularHours = min($regularHours, 8.0);
        $totalHours = $regularHours + $otHours;

        return [
            'regular_hours' => round($regularHours, 2),
            'ot_hours' => round($otHours, 2),
            'total_hours' => round($totalHours, 2),
        ];
    }

    /**
     * Automatically handles expired records and lunch auto-timeout:
     * 1. ONLY afternoon sessions are denied when students forget to time out before end of day (date < today Manila).
     *    Morning hours are preserved and never denied.
     * 2. Morning sessions without timeout are auto-timed-out at 12:00 noon (both today past 12:00 PM and past dates).
     *
     * @param int|null $studentId Optional filter for a specific student
     * @return array Summary of processed records
     */
    public static function processAutoTimeoutsAndDenials(?int $studentId = null): array
    {
        $manilaTime = Carbon::now('Asia/Manila');
        $today      = $manilaTime->toDateString();
        $nowHour    = (int) $manilaTime->format('H');

        $deniedCount = 0;
        $morningAutoCount = 0;

        try {
            // ─────────────────────────────────────────────────────────────
            // 1. AUTO-DENY PAST UNCLOSED AFTERNOON SESSIONS ONLY (date < today)
            // As per policy: ONLY afternoon sessions are denied if the student
            // forgot to time out before the end of the day (exceed 12:00 AM midnight).
            // Morning hours are NEVER denied for this reason.
            // ─────────────────────────────────────────────────────────────
            $pastAfternoonQuery = TimeInRecord::whereDate('date', '<', $today)
                ->where('session', 'afternoon')
                ->whereNull('time_out')
                ->where('status', '!=', 'denied');

            if ($studentId) {
                $pastAfternoonQuery->where('student_id', $studentId);
            }

            $deniedCount = $pastAfternoonQuery->update([
                'time_out'      => '23:59',   // use end-of-day sentinel; '00:00' would display as 12:00 AM (confusing)
                'regular_hours' => 0,
                'ot_hours'      => 0,
                'ot_status'     => null,
                'status'        => 'denied',
                'denial_reason' => 'Auto-denied: student did not time out before end of day. Only morning hours are recorded.',
            ]);

            // ─────────────────────────────────────────────────────────────
            // 2. MORNING AUTO-TIMEOUT AT 12:00 NOON (NEVER DENIED)
            // If student forgot to time out before lunch:
            // - For TODAY: fires if current time is >= 12:00 PM
            // - For PAST DATES: caps any open morning session at 12:00 so morning hours are credited
            // ─────────────────────────────────────────────────────────────
            $morningQuery = TimeInRecord::where('session', 'morning')
                ->whereNull('time_out')
                ->where(function ($q) use ($today, $nowHour) {
                    $q->whereDate('date', '<', $today);
                    if ($nowHour >= 12) {
                        $q->orWhereDate('date', $today);
                    }
                });

            if ($studentId) {
                $morningQuery->where('student_id', $studentId);
            }

            $openMornings = $morningQuery->get();

            foreach ($openMornings as $openMorning) {
                $autoOut      = '12:00';
                $inTime       = Carbon::createFromTimeString($openMorning->time_in);
                $outTime      = Carbon::createFromTimeString($autoOut);
                $hoursWorked  = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);
                $regularHours = min($hoursWorked, 8.0);
                $otHours      = max(0, round($hoursWorked - 8.0, 2));

                $openMorning->update([
                    'time_out'      => $autoOut,
                    'regular_hours' => $regularHours,
                    'ot_hours'      => $otHours,
                    'status'        => 'pending',
                ]);

                $recDate = $openMorning->date ? $openMorning->date->toDateString() : $today;

                // Do NOT credit hours to StudentHours here — the record is pending and must
                // be approved by the supervisor/coordinator first, exactly like a manual time-out.
                // Create a pending DailyHourLog entry to match the manual time-out flow.
                $existingLog = DailyHourLog::where('student_id', $openMorning->student_id)
                    ->whereDate('log_date', $recDate)
                    ->where('is_overtime', false)
                    ->where('status', 'pending')
                    ->first();

                if (!$existingLog) {
                    DailyHourLog::create([
                        'student_id'   => $openMorning->student_id,
                        'log_date'     => $recDate,
                        'hours_logged' => $regularHours,
                        'is_overtime'  => false,
                        'status'       => 'pending',
                    ]);
                }

                $morningAutoCount++;
            }
        } catch (\Throwable $e) {
            Log::error('Error in AttendanceHelper::processAutoTimeoutsAndDenials: ' . $e->getMessage());
        }

        return [
            'denied_count' => $deniedCount,
            'morning_auto_timeout_count' => $morningAutoCount,
        ];
    }
}
