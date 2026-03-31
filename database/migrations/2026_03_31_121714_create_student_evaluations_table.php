<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('supervisor_id');
            // Overall rating 1-5
            $table->tinyInteger('rating')->default(0);
            // Competency ratings 1-5
            $table->tinyInteger('attendance')->default(0);
            $table->tinyInteger('communication')->default(0);
            $table->tinyInteger('collaboration')->default(0);
            $table->tinyInteger('problem_solving')->default(0);
            $table->tinyInteger('work_ethics')->default(0);
            $table->tinyInteger('time_management')->default(0);
            $table->tinyInteger('job_skills')->default(0);
            $table->tinyInteger('employability')->default(0);
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_evaluations');
    }
};
