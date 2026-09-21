<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_cannot_access_school_year_management(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'is_approved' => true,
        ]);

        $this->withSession(['user_id' => $user->id, 'user' => $user])
            ->get('/api/school-years')
            ->assertStatus(403);
    }

    public function test_coordinator_cannot_access_school_year_management(): void
    {
        $user = User::factory()->create([
            'role' => 'coordinator',
            'is_approved' => true,
        ]);

        $this->withSession(['user_id' => $user->id, 'user' => $user])
            ->get('/api/school-years')
            ->assertStatus(403);
    }

    public function test_ccit_head_can_access_school_year_management(): void
    {
        $user = User::factory()->create([
            'role' => 'ccit_head',
            'is_approved' => true,
        ]);

        $this->withSession(['user_id' => $user->id, 'user' => $user])
            ->get('/api/school-years')
            ->assertStatus(200);
    }
}
