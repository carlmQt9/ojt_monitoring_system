<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('certificate_awarded_at')->nullable()->after('is_approved');
            $table->string('certificate_awarded_by')->nullable()->after('certificate_awarded_at'); // supervisor name
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['certificate_awarded_at', 'certificate_awarded_by']);
        });
    }
};
