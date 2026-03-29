<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('time_in_records', function (Blueprint $table) {
            if (!Schema::hasColumn('time_in_records', 'session')) {
                $table->string('session')->default('morning')->after('date');
            }
        });

        \DB::statement('ALTER TABLE time_in_records DROP FOREIGN KEY time_in_records_student_id_foreign');
        \DB::statement('ALTER TABLE time_in_records DROP INDEX time_in_records_student_id_date_unique');
        \DB::statement('ALTER TABLE time_in_records ADD UNIQUE KEY time_in_records_student_id_date_session_unique (student_id, date, session)');
        \DB::statement('ALTER TABLE time_in_records ADD CONSTRAINT time_in_records_student_id_foreign FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down(): void
    {
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'date', 'session']);
            $table->dropColumn('session');
            $table->unique(['student_id', 'date']);
        });
    }
};
