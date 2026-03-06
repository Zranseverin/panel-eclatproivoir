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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->string('feature1_icon')->nullable();
            $table->string('feature1_title')->nullable();
            $table->string('feature2_icon')->nullable();
            $table->string('feature2_title')->nullable();
            $table->string('feature3_icon')->nullable();
            $table->string('feature3_title')->nullable();
            $table->string('feature4_icon')->nullable();
            $table->string('feature4_title')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
