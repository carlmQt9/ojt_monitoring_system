<?php

namespace Tests\Feature;

use App\Models\StudentRequirement;
use App\Models\StudentSchoolId;
use App\Models\TimeInRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserArchiveDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permanent_user_delete_removes_related_data_and_releases_school_id(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'ccit_head']);
        $student = User::factory()->create([
            'role' => 'student',
            'school_id_number' => '23-1-2-0136',
        ]);
        $schoolId = StudentSchoolId::create([
            'school_id_number' => $student->school_id_number,
            'school_year' => '2026-2027',
            'is_used' => true,
        ]);
        TimeInRecord::create([
            'student_id' => $student->id,
            'date' => '2026-09-29',
            'session' => 'afternoon',
            'time_in' => '13:00',
            'time_out' => '17:00',
        ]);

        Storage::disk('public')->put('requirements/letter.pdf', 'file-content');
        Storage::disk('public')->put('requirements/extra.pdf', 'file-content');
        StudentRequirement::create([
            'student_id' => $student->id,
            'title' => 'OT Letter',
            'file_path' => 'requirements/letter.pdf',
            'file_paths' => ['requirements/extra.pdf'],
            'status' => 'pending',
        ]);
        $student->delete();
        $schoolId->delete();

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->delete('/api/users/' . $student->id . '/force')
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $student->id]);
        $this->assertDatabaseMissing('time_in_records', ['student_id' => $student->id]);
        $this->assertDatabaseMissing('student_requirements', ['student_id' => $student->id]);
        $this->assertFalse($schoolId->fresh()->trashed());
        $this->assertFalse((bool) $schoolId->fresh()->is_used);
        $this->assertFalse(Storage::disk('public')->exists('requirements/letter.pdf'));
        $this->assertFalse(Storage::disk('public')->exists('requirements/extra.pdf'));

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->getJson('/api/school-ids')
            ->assertOk()
            ->assertJsonPath('school_ids.0.is_used', 0);
    }

    public function test_archived_school_id_delete_permanently_removes_the_id_row(): void
    {
        $admin = User::factory()->create(['role' => 'ccit_head']);
        $schoolId = StudentSchoolId::create([
            'school_id_number' => '23-1-2-0137',
            'school_year' => '2026-2027',
            'is_used' => false,
        ]);
        $schoolId->delete();

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->delete('/api/school-ids/' . $schoolId->id . '/force')
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('student_school_ids', ['id' => $schoolId->id]);
    }

    public function test_restoring_an_archived_school_id_does_not_restore_its_archived_user(): void
    {
        $admin = User::factory()->create(['role' => 'ccit_head']);
        $student = User::factory()->create([
            'role' => 'student',
            'school_id_number' => '23-1-2-0138',
        ]);
        $schoolId = StudentSchoolId::create([
            'school_id_number' => $student->school_id_number,
            'school_year' => '2026-2027',
            'is_used' => true,
        ]);
        $student->delete();
        $schoolId->delete();

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->post('/api/school-ids/' . $schoolId->id . '/restore')
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSoftDeleted('users', ['id' => $student->id]);
        $this->assertNotNull(StudentSchoolId::find($schoolId->id));
        $this->assertTrue((bool) $schoolId->fresh()->is_used);
    }

    public function test_archived_users_api_is_restricted_to_ccit_head(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->withSession(['user_id' => $student->id, 'user' => $student])
            ->getJson('/api/users/archived')
            ->assertForbidden();
    }

    public function test_ccit_head_can_load_archived_users_for_the_archive_modal(): void
    {
        $admin = User::factory()->create(['role' => 'ccit_head']);
        $archived = User::factory()->create(['role' => 'student']);
        $archived->delete();

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->getJson('/api/users/archived')
            ->assertOk()
            ->assertJsonPath('users.0.id', $archived->id);
    }

    public function test_force_delete_endpoint_only_deletes_archived_users(): void
    {
        $admin = User::factory()->create(['role' => 'ccit_head']);
        $active = User::factory()->create(['role' => 'student']);

        $this->withSession(['user_id' => $admin->id, 'user' => $admin])
            ->delete('/api/users/' . $active->id . '/force')
            ->assertNotFound();

        $this->assertDatabaseHas('users', ['id' => $active->id]);
    }
}
