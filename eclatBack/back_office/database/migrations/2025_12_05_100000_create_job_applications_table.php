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
        if (!Schema::hasTable('job_applications')) {
            Schema::create('job_applications', function (Blueprint $table) {
                $table->id();
                $table->string('civilite', 20);
                $table->string('nom_complet', 255);
                $table->string('telephone', 20);
                $table->string('email', 255);
                $table->text('adresse');
                $table->string('poste', 255);
                $table->string('cv_path', 255)->nullable();
                $table->string('lettre_motivation_path', 255)->nullable();
                $table->timestamp('submitted_at')->useCurrent();
                $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};