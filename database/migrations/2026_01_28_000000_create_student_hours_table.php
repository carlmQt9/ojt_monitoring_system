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
        // Create student hours tracking table
        Schema::create('student_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_hours_required')->default(600);
            $table->integer('hours_completed')->default(0);
            $table->integer('hours_remaining')->default(600);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Create daily hours log table
        Schema::create('daily_hour_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('log_date');
            $table->integer('hours_logged')->default(0);
            $table->boolean('is_overtime')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_hour_logs');
        Schema::dropIfExists('student_hours');
    }
};
