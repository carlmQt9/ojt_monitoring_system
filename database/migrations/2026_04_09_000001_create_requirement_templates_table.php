<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('onboarding'); // onboarding | daily
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('max_files')->default(1);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_templates');
    }
};
