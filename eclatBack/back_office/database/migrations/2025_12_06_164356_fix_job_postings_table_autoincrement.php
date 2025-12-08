<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the id column to be auto increment and primary key
        DB::statement('ALTER TABLE job_postings MODIFY id INT NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE job_postings MODIFY id INT NOT NULL, DROP PRIMARY KEY');
    }
};