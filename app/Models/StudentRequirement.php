<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRequirement extends Model
{
    use HasFactory;

    protected $table = 'student_requirements';

    protected $fillable = [
        'student_id',
        'title',
        'description',
        'file_path',
        'file_paths',
        'status',
        'feedback',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'file_paths'  => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
}
