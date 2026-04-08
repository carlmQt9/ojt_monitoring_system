<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_years', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('student_school_ids', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('school_years', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('student_school_ids', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
