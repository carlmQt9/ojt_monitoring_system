<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('time_in_records', function (Blueprint $table) {
            // Regular hours capped at 8 per day
            $table->decimal('regular_hours', 5, 2)->default(0)->after('time_out');
            // OT hours beyond 8 — only credited after OT letter approved
            $table->decimal('ot_hours', 5, 2)->default(0)->after('regular_hours');
            // null = no OT | 'pending' = OT letter submitted, waiting | 'approved' = OT credited | 'denied' = OT not credited
            $table->string('ot_status')->nullable()->after('ot_hours');
        });
    }

    public function down(): void {
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->dropColumn(['regular_hours', 'ot_hours', 'ot_status']);
        });
    }
};
