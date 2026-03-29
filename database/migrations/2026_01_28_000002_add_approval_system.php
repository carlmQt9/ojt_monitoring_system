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
        // Add approval/denial columns to daily_hour_logs
        Schema::table('daily_hour_logs', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending')->after('notes');
            $table->text('denial_reason')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('denial_reason');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });

        // Add approval columns to time_in_records
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending')->after('notes');
            $table->text('denial_reason')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('denial_reason');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });

        // Student requirements table
        Schema::create('student_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->text('feedback')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_requirements');
        
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->dropForeignIdFor('users', 'approved_by');
            $table->dropColumn(['status', 'denial_reason', 'approved_by', 'approved_at']);
        });

        Schema::table('daily_hour_logs', function (Blueprint $table) {
            $table->dropForeignIdFor('users', 'approved_by');
            $table->dropColumn(['status', 'denial_reason', 'approved_by', 'approved_at']);
        });
    }
};
