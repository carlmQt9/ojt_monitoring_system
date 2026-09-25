<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('time_in_records', function (Blueprint $table) {
                if (!Schema::hasColumn('time_in_records', 'session')) {
                    $table->string('session')->default('morning')->after('date');
                }
            });

            return;
        }

        Schema::table('time_in_records', function (Blueprint $table) {
            if (!Schema::hasColumn('time_in_records', 'session')) {
                $table->string('session')->default('morning')->after('date');
            }
        });

        DB::statement('ALTER TABLE time_in_records DROP FOREIGN KEY IF EXISTS time_in_records_student_id_foreign');
        // Only drop the old unique index if it exists
        $indexExists = DB::select("SHOW INDEX FROM time_in_records WHERE Key_name = 'time_in_records_student_id_date_unique'");
        if (!empty($indexExists)) {
            DB::statement('ALTER TABLE time_in_records DROP INDEX time_in_records_student_id_date_unique');
        }
        // Only add the new unique key if it doesn't exist yet
        $newIndexExists = DB::select("SHOW INDEX FROM time_in_records WHERE Key_name = 'time_in_records_student_id_date_session_unique'");
        if (empty($newIndexExists)) {
            DB::statement('ALTER TABLE time_in_records ADD UNIQUE KEY time_in_records_student_id_date_session_unique (student_id, date, session)');
        }
        // Only add FK if it doesn't exist
        $fkExists = DB::select("SELECT * FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'time_in_records' AND CONSTRAINT_NAME = 'time_in_records_student_id_foreign'");
        if (empty($fkExists)) {
            DB::statement('ALTER TABLE time_in_records ADD CONSTRAINT time_in_records_student_id_foreign FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE');
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('time_in_records', function (Blueprint $table) {
                if (Schema::hasColumn('time_in_records', 'session')) {
                    $table->dropColumn('session');
                }
            });

            return;
        }

        Schema::table('time_in_records', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'date', 'session']);
            $table->dropColumn('session');
            $table->unique(['student_id', 'date']);
        });
    }
};
