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
        Schema::create('navbar_brands', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable(); // Path to logo image
            $table->string('logo_alt')->nullable(); // Alt text for logo
            $table->string('brand_name')->nullable(); // Brand/company name
            $table->string('brand_url')->default('index.php'); // Brand link URL
            $table->integer('logo_height')->default(100); // Logo height in pixels
            $table->boolean('is_active')->default(true); // Whether brand is visible
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbar_brands');
    }
};
