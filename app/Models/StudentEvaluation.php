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
        'evaluation_date', 'period_from', 'period_to', 'job_title',
        'quality_of_work_rating', 'quality_of_work_comment',
        'quantity_of_work_rating', 'quantity_of_work_comment',
        'job_knowledge_rating', 'job_knowledge_comment',
        'working_relationships_rating', 'working_relationships_comment',
        'attendance_dependability_rating', 'attendance_dependability_comment',
        'specific_achievements_rating', 'specific_achievements_comment',
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
