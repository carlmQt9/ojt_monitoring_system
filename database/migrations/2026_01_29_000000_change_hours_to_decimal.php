<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change student_hours hours to decimal
        Schema::table('student_hours', function (Blueprint $table) {
            // Use decimal with 8 total digits and 2 decimals
            $table->decimal('hours_completed', 8, 2)->default(0)->change();
            $table->decimal('hours_remaining', 8, 2)->default(600)->change();
        });

        // Change daily_hour_logs.hours_logged to decimal
        Schema::table('daily_hour_logs', function (Blueprint $table) {
            $table->decimal('hours_logged', 5, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_hours', function (Blueprint $table) {
            $table->integer('hours_completed')->default(0)->change();
            $table->integer('hours_remaining')->default(600)->change();
        });

        Schema::table('daily_hour_logs', function (Blueprint $table) {
            $table->integer('hours_logged')->default(0)->change();
        });
    }
};
