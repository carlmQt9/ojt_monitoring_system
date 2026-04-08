<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_evaluations', function (Blueprint $table) {
            $table->date('evaluation_date')->nullable()->after('supervisor_id');
            $table->date('period_from')->nullable()->after('evaluation_date');
            $table->date('period_to')->nullable()->after('period_from');
            $table->string('job_title')->nullable()->after('period_to');
            // 6 performance factors: rating (string) + comment
            $table->string('quality_of_work_rating')->nullable()->after('feedback');
            $table->text('quality_of_work_comment')->nullable()->after('quality_of_work_rating');
            $table->string('quantity_of_work_rating')->nullable()->after('quality_of_work_comment');
            $table->text('quantity_of_work_comment')->nullable()->after('quantity_of_work_rating');
            $table->string('job_knowledge_rating')->nullable()->after('quantity_of_work_comment');
            $table->text('job_knowledge_comment')->nullable()->after('job_knowledge_rating');
            $table->string('working_relationships_rating')->nullable()->after('job_knowledge_comment');
            $table->text('working_relationships_comment')->nullable()->after('working_relationships_rating');
            $table->string('attendance_dependability_rating')->nullable()->after('working_relationships_comment');
            $table->text('attendance_dependability_comment')->nullable()->after('attendance_dependability_rating');
            $table->string('specific_achievements_rating')->nullable()->after('attendance_dependability_comment');
            $table->text('specific_achievements_comment')->nullable()->after('specific_achievements_rating');
        });
    }

    public function down(): void
    {
        Schema::table('student_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'evaluation_date','period_from','period_to','job_title',
                'quality_of_work_rating','quality_of_work_comment',
                'quantity_of_work_rating','quantity_of_work_comment',
                'job_knowledge_rating','job_knowledge_comment',
                'working_relationships_rating','working_relationships_comment',
                'attendance_dependability_rating','attendance_dependability_comment',
                'specific_achievements_rating','specific_achievements_comment',
            ]);
        });
    }
};
