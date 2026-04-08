<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class RequirementTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'description',
        'max_files',
        'sort_order',
    ];

    protected static function booted(): void
    {
        if (!Schema::hasColumn('requirement_templates', 'deleted_at')) {
            static::addGlobalScope('no_soft_delete', function ($builder) {
                $builder->withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class);
            });
        }
    }
}
