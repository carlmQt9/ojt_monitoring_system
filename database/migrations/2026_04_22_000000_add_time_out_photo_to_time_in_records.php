<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->string('time_out_photo_path')->nullable()->after('photo_path');
        });
    }

    public function down(): void
    {
        Schema::table('time_in_records', function (Blueprint $table) {
            $table->dropColumn('time_out_photo_path');
        });
    }
};
