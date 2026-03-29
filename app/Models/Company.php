<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'industry',
        'location',
        'contact_person',
        'contact_email',
        'contact_phone',
        'description',
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'company_id')->where('role', 'student');
    }

    public function getInternCountAttribute()
    {
        return $this->students()->count();
    }
}
