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
        // Create time-in records table
        Schema::create('time_in_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('photo_path')->nullable(); // Path to the time-in photo
            $table->boolean('verified')->default(false); // Verified by coordinator/supervisor
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->string('session')->default('morning'); // morning | afternoon
            $table->boolean('is_lunch_break')->default(false);
            // Unique constraint: one record per student per day per session
            $table->unique(['student_id', 'date', 'session']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_in_records');
    }
};
