<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'total_hours_required',
        'hours_completed',
        'hours_remaining',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hours_completed' => 'float',
        'hours_remaining' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function dailyLogs()
    {
        return $this->hasMany(DailyHourLog::class, 'student_id', 'student_id');
    }

    public function getProgressPercentageAttribute()
    {
        if (!$this->total_hours_required || $this->total_hours_required <= 0) {
            return 0;
        }
        return ($this->hours_completed / $this->total_hours_required) * 100;
    }
}
