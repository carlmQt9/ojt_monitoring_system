<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeInRecord extends Model
{
    use HasFactory;

    protected $table = 'time_in_records';

    protected $fillable = [
        'student_id',
        'date',
        'session',
        'time_in',
        'time_out',
        'photo_path',
        'verified',
        'notes',
        'status',
        'denial_reason',
        'approved_by',
        'approved_at',
    ];

    // Returns total minutes worked for this record
    public function getMinutesWorkedAttribute(): float
    {
        if (!$this->time_in || !$this->time_out) return 0;
        return max(0, \Carbon\Carbon::parse($this->time_in)->diffInMinutes(\Carbon\Carbon::parse($this->time_out)));
    }

    // Returns hours worked rounded to 2 decimals
    public function getHoursWorkedAttribute(): float
    {
        return round($this->minutes_worked / 60, 2);
    }

    // Is this record overtime? (hours_worked > 8)
    public function getIsOvertimeSessionAttribute(): bool
    {
        return $this->hours_worked > 8;
    }

    protected $casts = [
        'date' => 'date',
        'verified' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }
}
