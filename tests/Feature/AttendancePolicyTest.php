<?php

namespace Tests\Feature;

use App\Helpers\AttendanceHelper;
use App\Models\StudentHours;
use App\Models\StudentRequirement;
use App\Models\TimeInRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendancePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_morning_session_auto_times_out_at_noon(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'status' => 'pending',
        ]);

        AttendanceHelper::processAutoTimeoutsAndDenials($student->id);

        $record->refresh();

        $this->assertSame('12:00', $record->time_out);
        $this->assertSame(5.0, round((float) $record->regular_hours, 2));
        $this->assertSame(0.0, round((float) $record->ot_hours, 2));
    }

    public function test_ot_hours_only_count_after_ot_letter_submission(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'regular_hours' => 5,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '19:30',
            'status' => 'approved',
            'regular_hours' => 5,
        ]);

        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 27, 2026',
            'description' => 'Late overtime',
            'status' => 'pending',
            'file_path' => null,
            'created_at' => '2026-09-27 18:00:00',
            'updated_at' => '2026-09-27 18:00:00',
        ]);

        $summary = AttendanceHelper::computeDailyTotalsForStudent($student->id, '2026-09-27');

        $this->assertSame(8.0, round((float) $summary['regular_hours'], 2));
        $this->assertSame(1.5, round((float) $summary['ot_hours'], 2));
    }

    public function test_ot_hours_are_not_counted_when_ot_letter_is_denied(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-28',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'regular_hours' => 5,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-28',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '19:30',
            'status' => 'approved',
            'regular_hours' => 5,
        ]);

        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 28, 2026',
            'description' => 'Late overtime',
            'status' => 'denied',
            'file_path' => null,
            'created_at' => '2026-09-28 18:00:00',
            'updated_at' => '2026-09-28 18:00:00',
        ]);

        $summary = AttendanceHelper::computeDailyTotalsForStudent($student->id, '2026-09-28');

        $this->assertSame(8.0, round((float) $summary['regular_hours'], 2));
        $this->assertSame(0.0, round((float) $summary['ot_hours'], 2));
    }

    public function test_pending_dtr_hours_are_excluded_until_approval(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        StudentHours::create([
            'student_id' => $student->id,
            'total_hours_required' => 600,
            'hours_completed' => 10,
            'hours_remaining' => 590,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-30',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'verified' => true,
            'regular_hours' => 5,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-30',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '17:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 4,
        ]);

        session(['user_id' => $coordinator->id, 'user' => $coordinator]);

        $response = $this->get('/generate-dtr/' . $student->id);

        $response->assertOk();
        $response->assertSeeText('Pending');
        $response->assertSeeText('5.00');
        $response->assertDontSeeText('10.00');
    }

    public function test_dtr_excludes_weekend_days_monday_to_friday_only(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-26',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'verified' => true,
            'regular_hours' => 5,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-28',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'verified' => true,
            'regular_hours' => 5,
        ]);

        session(['user_id' => $coordinator->id, 'user' => $coordinator]);

        $response = $this->get('/generate-dtr/' . $student->id);

        $response->assertOk();
        $response->assertSeeText('September 28, 2026');
        $response->assertDontSeeText('September 26, 2026');
    }

    public function test_ot_letter_approval_updates_time_record_status_and_dtr_totals(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        $requirement = StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 27, 2026',
            'description' => 'Late overtime',
            'status' => 'pending',
            'file_path' => null,
            'created_at' => '2026-09-27 18:00:00',
            'updated_at' => '2026-09-27 18:00:00',
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 5,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '19:30',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 5,
            'ot_hours' => 1.5,
            'ot_status' => 'pending',
        ]);

        $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->post('/approve-requirement/' . $requirement->id, ['feedback' => 'Approved.'])
            ->assertRedirect();

        $this->assertDatabaseHas('time_in_records', [
            'student_id' => $student->id,
            'date' => '2026-09-27 00:00:00',
            'session' => 'afternoon',
            'status' => 'approved',
            'ot_status' => 'approved',
            'verified' => 1,
        ]);

        $summary = AttendanceHelper::computeDailyTotalsForStudent($student->id, '2026-09-27');
        $this->assertSame(8.0, round((float) $summary['regular_hours'], 2));
        $this->assertSame(1.5, round((float) $summary['ot_hours'], 2));
    }

    public function test_approving_one_session_does_not_approve_the_other_session_on_same_date(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        $morning = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 5,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '17:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 4,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->post('/approve-time-in/' . $morning->id)
            ->assertRedirect();

        $morning->refresh();
        $afternoon = TimeInRecord::where('student_id', $student->id)
            ->where('session', 'afternoon')
            ->whereDate('date', '2026-09-27')
            ->first();

        $this->assertSame('approved', $morning->status);
        $this->assertSame('pending', $afternoon->status);
        $this->assertSame(5.0, round((float) $morning->regular_hours, 2));
    }

    public function test_denying_one_session_does_not_deny_the_other_session_on_same_date(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        $morning = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 5,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        $afternoon = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '17:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 4,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->from('/dashboard')
            ->post('/deny-time-in/' . $afternoon->id, ['reason' => 'Incorrect time-in'])
            ->assertRedirect();

        $morning->refresh();
        $afternoon->refresh();

        $this->assertSame('pending', $morning->status);
        $this->assertSame('denied', $afternoon->status);
    }

    public function test_approving_one_session_keeps_the_daily_log_pending_until_all_sessions_are_approved(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);

        $morning = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'morning',
            'time_in' => '07:00',
            'time_out' => '12:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 5,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        $afternoon = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-27',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '17:00',
            'status' => 'pending',
            'verified' => false,
            'regular_hours' => 4,
            'ot_hours' => 0,
            'ot_status' => null,
        ]);

        \App\Models\DailyHourLog::create([
            'student_id' => $student->id,
            'log_date' => '2026-09-27',
            'hours_logged' => 9,
            'is_overtime' => false,
            'status' => 'pending',
        ]);

        $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->post('/approve-time-in/' . $morning->id)
            ->assertRedirect();

        $morning->refresh();
        $afternoon->refresh();
        $dailyLog = \App\Models\DailyHourLog::where('student_id', $student->id)
            ->whereDate('log_date', '2026-09-27')
            ->first();

        $this->assertSame('approved', $morning->status);
        $this->assertSame('pending', $afternoon->status);
        $this->assertSame('pending', $dailyLog->status);
    }
}
