<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSchoolId extends Model
{
    protected $fillable = ['school_id_number', 'school_year', 'is_used'];
}
