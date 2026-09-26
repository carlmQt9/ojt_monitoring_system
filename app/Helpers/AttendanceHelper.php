<?php

namespace App\Helpers;

use App\Models\TimeInRecord;
use App\Models\StudentHours;
use App\Models\DailyHourLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceHelper
{
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
                'time_out'      => '00:00',
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

                $sh = StudentHours::where('student_id', $openMorning->student_id)
                    ->firstOrCreate(['student_id' => $openMorning->student_id], ['total_hours_required' => 600]);
                $newCompleted = round(max(0, ($sh->hours_completed ?? 0) + $regularHours), 2);
                $sh->update([
                    'hours_completed' => $newCompleted,
                    'hours_remaining' => round(max(0, ($sh->total_hours_required ?? 600) - $newCompleted), 2),
                ]);

                // Create or update daily hour log for that day
                $existingLog = DailyHourLog::where('student_id', $openMorning->student_id)
                    ->whereDate('log_date', $recDate)
                    ->where('is_overtime', false)
                    ->first();

                if (!$existingLog) {
                    DailyHourLog::create([
                        'student_id'   => $openMorning->student_id,
                        'log_date'     => $recDate,
                        'hours_logged' => $regularHours,
                        'is_overtime'  => false,
                        'status'       => 'approved',
                    ]);
                } else {
                    $existingLog->update([
                        'hours_logged' => round($existingLog->hours_logged + $regularHours, 2),
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
