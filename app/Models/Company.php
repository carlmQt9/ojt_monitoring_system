<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'industry',
        'location',
        'contact_person',
        'contact_email',
        'contact_phone',
        'description',
    ];

    protected static function booted(): void
    {
        if (!Schema::hasColumn('companies', 'deleted_at')) {
            static::addGlobalScope('no_soft_delete', function ($builder) {
                $builder->withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class);
            });
        }
    }

    public function students()
    {
        return $this->hasMany(User::class, 'company_id')->where('role', 'student');
    }

    public function getInternCountAttribute()
    {
        return $this->students()->count();
    }
}
