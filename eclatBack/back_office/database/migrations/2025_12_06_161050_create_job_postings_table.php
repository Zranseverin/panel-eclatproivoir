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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('employment_type', 50)->nullable();
            $table->text('description')->nullable();
            $table->text('mission')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('profile_requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->string('badge_text', 50)->nullable();
            $table->string('badge_class', 50)->default('bg-success');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};