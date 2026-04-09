<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use App\Models\StudentEvaluation;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Override SoftDeletes boot to only apply when the column actually exists.
     * This prevents crashes on environments where the migration hasn't run yet.
     */
    public static function bootSoftDeletes(): void
    {
        try {
            if (Schema::connection(config('database.default'))->hasColumn('users', 'deleted_at')) {
                static::addGlobalScope(new \Illuminate\Database\Eloquent\SoftDeletingScope());
            }
        } catch (\Throwable) {
            // DB unavailable during boot — skip soft deletes
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_year',
        'company_id',
        'is_active',
        'is_approved',
        'school_id_number',
        'certificate_awarded_at',
        'certificate_awarded_by',
        'certificate_image_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'certificate_awarded_at' => 'datetime',
        ];
    }

    /**
     * Check if user is CCIT Head
     */
    public function isCcitHead()
    {
        return $this->role === 'ccit_head';
    }

    /**
     * Check if user is Coordinator
     */
    public function isCoordinator()
    {
        return $this->role === 'coordinator';
    }

    /**
     * Check if user is Supervisor
     */
    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    /**
     * Check if user is Student
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * Company relationship
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');      
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function evaluations()
    {
        return $this->hasMany(\App\Models\StudentEvaluation::class, 'supervisor_id');
    }

    public function studentEvaluations()
    {
        return $this->hasMany(StudentEvaluation::class, 'student_id');
    }

    /**
     * Daily hour logs submitted by the student.
     */
    public function logs()
    {
        return $this->hasMany(\App\Models\DailyHourLog::class, 'student_id');
    }

    /**
     * Time-in records submitted by the student.
     */
    public function timeIns()
    {
        return $this->hasMany(\App\Models\TimeInRecord::class, 'student_id');
    }

    /**
     * Uploaded requirements by the student.
     */
    public function requirements()
    {
        return $this->hasMany(\App\Models\StudentRequirement::class, 'student_id');
    }
}

