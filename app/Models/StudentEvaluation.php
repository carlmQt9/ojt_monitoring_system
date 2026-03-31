<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    protected $fillable = [
        'student_id', 'supervisor_id', 'rating',
        'attendance', 'communication', 'collaboration',
        'problem_solving', 'work_ethics', 'time_management',
        'job_skills', 'employability', 'feedback',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function getMeanScoreAttribute(): float
    {
        $fields = ['attendance','communication','collaboration','problem_solving','work_ethics','time_management','job_skills','employability'];
        $scores = array_filter(array_map(fn($f) => $this->$f, $fields));
        return count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0;
    }
}
