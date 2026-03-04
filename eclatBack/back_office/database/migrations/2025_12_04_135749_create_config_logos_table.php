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
        // Check if the table already exists
        if (!Schema::hasTable('config_logo')) {
            Schema::create('config_logo', function (Blueprint $table) {
                $table->id();
                $table->string('logo_path', 255);
                $table->string('alt_text', 255)->default('Logo');
                $table->string('site_title', 255)->default('EPI - Eclat pro Ivoire');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_logo');
    }
};