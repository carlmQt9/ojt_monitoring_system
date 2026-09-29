<?php

namespace Tests\Feature;

use App\Helpers\AttendanceHelper;
use App\Models\StudentRequirement;
use App\Models\DailyHourLog;
use App\Models\StudentHours;
use App\Models\TimeInRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OvertimeWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_renders_the_ot_gate_at_eight_daily_hours(): void
    {
        $now = Carbon::parse('2026-09-29 17:00:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'morning',
            'time_in' => '08:00',
            'time_out' => '12:00',
            'status' => 'approved',
            'regular_hours' => 4,
        ]);
        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'afternoon',
            'time_in' => '13:00',
            'status' => 'pending',
        ]);

        $this->withSession(['user_id' => $student->id, 'user' => $student])
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('id="otGatePrompt"', false)
            ->assertSeeText('You have reached 8 hours today!')
            ->assertSeeText('Time Out Now (8 hrs only');
    }

    public function test_student_dashboard_does_not_show_stale_hours_or_ot_for_equal_time_record(): void
    {
        $now = Carbon::parse('2026-09-29 21:28:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'afternoon',
            'time_in' => '21:28',
            'time_out' => '21:28',
            'status' => 'pending',
            'regular_hours' => 8,
            'ot_hours' => 18.07,
            'ot_status' => 'approved',
        ]);
        $this->assertSame(0.0, $record->minutes_worked);
        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'approved',
            'created_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
        ]);

        $response = $this->withSession(['user_id' => $student->id, 'user' => $student])
            ->get('/dashboard')
            ->assertOk();

        $this->assertSame(1, preg_match('/<button[^>]*id="otUploadBtn"[^>]*disabled[^>]*>/s', $response->getContent()));
        $response->assertDontSeeText('Pending Approval')
            ->assertDontSeeText('18.07 OT')
            ->assertDontSeeText('+8.00 hrs');
    }

    public function test_ot_letter_can_only_be_submitted_after_eight_hours_with_an_active_session(): void
    {
        $now = Carbon::parse('2026-09-29 16:59:00', 'Asia/Manila');
        $this->travelTo($now);
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'morning',
            'time_in' => '09:00',
            'status' => 'pending',
        ]);
        $session = ['user_id' => $student->id, 'user' => $student];
        $upload = UploadedFile::fake()->create('ot-letter.pdf', 10, 'application/pdf');

        $this->withSession($session)->post('/upload-requirement', [
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'file' => [$upload],
        ])->assertSessionHasErrors('title');

        $record->update(['time_in' => '08:59']);
        $upload = UploadedFile::fake()->create('ot-letter.pdf', 10, 'application/pdf');

        $this->withSession($session)->post('/upload-requirement', [
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'file' => [$upload],
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('student_requirements', [
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'pending',
        ]);
    }

    public function test_time_out_counts_overtime_from_the_ot_letter_submission_time(): void
    {
        $now = Carbon::parse('2026-09-29 18:30:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'morning',
            'time_in' => '08:00',
            'status' => 'pending',
        ]);
        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'pending',
            'created_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
        ]);

        $this->withSession(['user_id' => $student->id, 'user' => $student])
            ->post('/time-out', [
                'student_id' => $student->id,
                'date' => $now->toDateString(),
                'session' => 'morning',
            ])
            ->assertRedirect();

        $record->refresh();
        $this->assertSame(8.0, round((float) $record->regular_hours, 2));
        $this->assertSame(2.5, round((float) $record->ot_hours, 2));
        $this->assertSame('pending', $record->ot_status);
    }

    public function test_equal_time_in_and_time_out_cannot_create_a_24_hour_duration(): void
    {
        $now = Carbon::parse('2026-09-29 20:25:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'afternoon',
            'time_in' => '20:25',
            'status' => 'pending',
            // Mimic the bad legacy values shown in the screenshot.
            'regular_hours' => 5.93,
            'ot_hours' => 18.07,
            'ot_status' => 'approved',
        ]);
        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'approved',
            'created_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
        ]);

        $calculated = \App\Helpers\AttendanceHelper::calculateRecordHours($record);

        $this->assertSame(0.0, $record->hours_worked);
        $this->assertSame(0.0, $calculated['regular_hours']);
        $this->assertSame(0.0, $calculated['ot_hours']);
    }

    public function test_approving_legacy_equal_times_reconciles_false_ot_credit(): void
    {
        $now = Carbon::parse('2026-09-29 20:25:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        $coordinator = User::factory()->create(['role' => 'coordinator']);
        StudentHours::create([
            'student_id' => $student->id,
            'total_hours_required' => 600,
            'hours_completed' => 18.07,
            'hours_remaining' => 581.93,
        ]);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'afternoon',
            'time_in' => '20:25',
            'time_out' => '20:25',
            'status' => 'pending',
            'regular_hours' => 5.93,
            'ot_hours' => 18.07,
            'ot_status' => 'approved',
        ]);
        StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'approved',
            'created_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
        ]);
        DailyHourLog::create([
            'student_id' => $student->id,
            'log_date' => $now->toDateString(),
            'hours_logged' => 18.07,
            'is_overtime' => true,
            'status' => 'approved',
        ]);

        $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->post('/approve-time-in/' . $record->id)
            ->assertRedirect();

        $record->refresh();
        $this->assertSame(0.0, (float) $record->regular_hours);
        $this->assertSame(0.0, (float) $record->ot_hours);
        $this->assertDatabaseHas('student_hours', [
            'student_id' => $student->id,
            'hours_completed' => 0.0,
        ]);
        $this->assertDatabaseHas('daily_hour_logs', [
            'student_id' => $student->id,
            'hours_logged' => 0.0,
            'is_overtime' => 1,
            'status' => 'approved',
        ]);
    }

    public function test_regular_only_timeout_denies_the_ot_letter_and_records_no_ot(): void
    {
        $now = Carbon::parse('2026-09-29 17:00:00', 'Asia/Manila');
        $this->travelTo($now);
        $student = User::factory()->create(['role' => 'student']);
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $now->toDateString(),
            'session' => 'morning',
            'time_in' => '08:00',
            'status' => 'pending',
        ]);
        $letter = StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - Sep 29, 2026',
            'status' => 'pending',
            'created_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse('2026-09-29 16:00:00', 'Asia/Manila'),
        ]);

        $this->withSession(['user_id' => $student->id, 'user' => $student])
            ->post('/time-out', [
                'student_id' => $student->id,
                'date' => $now->toDateString(),
                'session' => 'morning',
                'regular_only' => '1',
            ])
            ->assertRedirect();

        $record->refresh();
        $letter->refresh();
        $this->assertSame(8.0, round((float) $record->regular_hours, 2));
        $this->assertSame(0.0, round((float) $record->ot_hours, 2));
        $this->assertSame('denied', $record->ot_status);
        $this->assertSame('denied', $letter->status);
    }

    public function test_forgetting_to_time_out_auto_denies_the_ot_letter(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $yesterday = Carbon::now('Asia/Manila')->subDay()->toDateString();
        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $yesterday,
            'session' => 'afternoon',
            'time_in' => '13:00',
            'status' => 'pending',
        ]);
        $letter = StudentRequirement::forceCreate([
            'student_id' => $student->id,
            'title' => 'OT Letter - yesterday',
            'status' => 'pending',
            'created_at' => Carbon::parse($yesterday . ' 17:00:00', 'Asia/Manila'),
            'updated_at' => Carbon::parse($yesterday . ' 17:00:00', 'Asia/Manila'),
        ]);

        AttendanceHelper::processAutoTimeoutsAndDenials($student->id);

        $record->refresh();
        $letter->refresh();
        $this->assertSame('denied', $record->status);
        $this->assertSame('denied', $letter->status);
        $this->assertStringContainsString('Auto-denied', $letter->feedback);
        $this->assertSame(0.0, (float) $record->ot_hours);
    }
}
