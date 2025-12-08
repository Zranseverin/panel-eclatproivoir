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
        if (!Schema::hasTable('hero_content')) {
            Schema::create('hero_content', function (Blueprint $table) {
                $table->id();
                $table->string('headline', 255);
                $table->string('subheading', 255)->nullable();
                $table->string('primary_button_text', 50)->nullable();
                $table->string('primary_button_link', 255)->nullable();
                $table->string('secondary_button_text', 50)->nullable();
                $table->string('secondary_button_link', 255)->nullable();
                $table->string('background_image_url', 255)->nullable();
                $table->string('background_color', 20)->default('#009900');
                $table->string('text_color', 20)->default('#ffffff');
                $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('hero_content');
    }
};