<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = ['label', 'is_active'];

    public function students()
    {
        return User::where('role', 'student')->where('school_year', $this->label);
    }
}
