<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class SchoolYear extends Model
{
    use SoftDeletes;

    protected $fillable = ['label', 'is_active'];

    protected static function booted(): void
    {
        // Guard against missing deleted_at column on servers where migration hasn't run
        if (!Schema::hasColumn('school_years', 'deleted_at')) {
            static::addGlobalScope('no_soft_delete', function ($builder) {
                $builder->withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class);
            });
        }
    }

    public function students()
    {
        return User::where('role', 'student')->where('school_year', $this->label);
    }
}
