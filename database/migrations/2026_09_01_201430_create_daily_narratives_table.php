<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_narratives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('report_date');                     // the day this entry covers
            $table->unsignedSmallInteger('day_number');      // auto-computed: nth day of OJT
            $table->text('description');                     // "what did you do today"
            $table->string('photo_path')->nullable();        // uploaded photo for that day
            $table->timestamps();

            // one entry per student per day
            $table->unique(['student_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_narratives');
    }
};
