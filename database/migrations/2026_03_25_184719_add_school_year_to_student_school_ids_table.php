<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_school_ids', function (Blueprint $table) {
            $table->string('school_year')->nullable()->after('school_id_number');
        });
    }

    public function down(): void
    {
        Schema::table('student_school_ids', function (Blueprint $table) {
            $table->dropColumn('school_year');
        });
    }
};
