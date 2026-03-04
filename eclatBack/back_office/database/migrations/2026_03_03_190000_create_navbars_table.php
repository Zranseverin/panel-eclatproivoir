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
        Schema::create('navbars', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Display text (e.g., "Accueil", "A propos")
            $table->string('url'); // Link URL (e.g., "index.php", "about.php")
            $table->string('route_name')->nullable(); // Laravel route name if applicable
            $table->integer('order')->default(0); // Menu item order
            $table->boolean('is_active')->default(true); // Whether menu item is visible
            $table->unsignedBigInteger('parent_id')->nullable(); // For dropdown items
            $table->timestamps();

            // Foreign key for parent dropdown
            $table->foreign('parent_id')->references('id')->on('navbars')->onDelete('cascade');
            
            // Index for faster lookups
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbars');
    }
};
