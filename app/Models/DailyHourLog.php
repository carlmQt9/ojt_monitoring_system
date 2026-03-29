<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyHourLog extends Model
{
    use HasFactory;

    protected $table = 'daily_hour_logs';

    protected $fillable = [
        'student_id',
        'log_date',
        'hours_logged',
        'is_overtime',
        'notes',
    ];

    protected $casts = [
        'log_date' => 'date',
        'is_overtime' => 'boolean',
        'hours_logged' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
