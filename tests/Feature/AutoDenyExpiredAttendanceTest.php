<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TimeInRecord;
use App\Models\DailyHourLog;
use App\Models\StudentHours;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoDenyExpiredAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_afternoon_records_are_auto_denied_when_timeout_is_forgotten(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'is_approved' => true,
        ]);

        $coordinator = User::factory()->create([
            'role' => 'coordinator',
            'is_approved' => true,
        ]);

        $pastDate = Carbon::now('Asia/Manila')->subDays(1)->toDateString();

        // Morning record: student forgot timeout before lunch
        $morningRecord = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $pastDate,
            'session' => 'morning',
            'time_in' => '08:00',
            'time_out' => null,
            'status' => 'pending',
        ]);

        // Afternoon record: student forgot timeout before midnight
        $afternoonRecord = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $pastDate,
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => null,
            'status' => 'pending',
        ]);

        // Coordinator views live counts or dashboard (student has NOT logged in)
        $response = $this->withSession(['user_id' => $coordinator->id, 'user' => $coordinator])
            ->get('/api/live-counts');

        $response->assertStatus(200);

        // Afternoon record MUST be denied
        $afternoonRecord->refresh();
        $this->assertEquals('denied', $afternoonRecord->status);
        $this->assertEquals('00:00', $afternoonRecord->time_out);
        $this->assertEquals(0, $afternoonRecord->regular_hours);
        $this->assertStringContainsString('Auto-denied', $afternoonRecord->denial_reason);

        // Morning record MUST NOT be denied — it should be auto-timed out to 12:00
        $morningRecord->refresh();
        $this->assertNotEquals('denied', $morningRecord->status);
        $this->assertEquals('12:00', $morningRecord->time_out);
        $this->assertEquals(4.0, $morningRecord->regular_hours);
    }

    public function test_artisan_command_auto_denies_past_afternoon_unclosed_records(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'is_approved' => true,
        ]);

        $yesterday = Carbon::now('Asia/Manila')->subDay()->toDateString();

        $record = TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $yesterday,
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => null,
            'status' => 'pending',
        ]);

        $this->artisan('attendance:auto-deny')
            ->assertSuccessful();

        $record->refresh();
        $this->assertEquals('denied', $record->status);
        $this->assertEquals(0, $record->regular_hours);
        $this->assertNotNull($record->denial_reason);
    }
}
