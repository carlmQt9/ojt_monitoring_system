<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyNarrative extends Model
{
    use HasFactory;

    protected $table = 'daily_narratives';

    protected $fillable = [
        'student_id',
        'report_date',
        'day_number',
        'description',
        'photo_path',
    ];

    protected $casts = [
        'report_date' => 'date',
        'day_number'  => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }
}
