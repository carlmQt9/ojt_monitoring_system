<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_school_ids', function (Blueprint $table) {
            $table->id();
            $table->string('school_id_number')->unique();
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('school_id_number')->nullable()->after('email');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_school_ids');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('school_id_number');
        });
    }
};
