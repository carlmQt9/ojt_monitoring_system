<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_evaluations', function (Blueprint $table) {
            // Numeric score (1-5) per PRMSU performance factor
            $table->unsignedTinyInteger('quality_of_work_score')->nullable()->after('quality_of_work_comment');
            $table->unsignedTinyInteger('quantity_of_work_score')->nullable()->after('quantity_of_work_comment');
            $table->unsignedTinyInteger('job_knowledge_score')->nullable()->after('job_knowledge_comment');
            $table->unsignedTinyInteger('working_relationships_score')->nullable()->after('working_relationships_comment');
            $table->unsignedTinyInteger('attendance_dependability_score')->nullable()->after('attendance_dependability_comment');
            $table->unsignedTinyInteger('specific_achievements_score')->nullable()->after('specific_achievements_comment');
            // Computed average score (stored for quick display)
            $table->decimal('average_score', 4, 2)->nullable()->after('specific_achievements_score');
        });
    }

    public function down(): void
    {
        Schema::table('student_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'quality_of_work_score',
                'quantity_of_work_score',
                'job_knowledge_score',
                'working_relationships_score',
                'attendance_dependability_score',
                'specific_achievements_score',
                'average_score',
            ]);
        });
    }
};
