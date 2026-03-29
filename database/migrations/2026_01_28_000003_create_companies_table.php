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
        // Create companies table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('industry')->nullable();
            $table->string('location')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Add company_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
        });

        Schema::dropIfExists('companies');
    }
};
