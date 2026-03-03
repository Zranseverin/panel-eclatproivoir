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
        // Check if the id column is already auto increment
        $columnInfo = DB::select("SHOW COLUMNS FROM job_postings WHERE Field = 'id'");
        if (!empty($columnInfo) && strpos($columnInfo[0]->Type, 'auto_increment') === false) {
            // Modify the id column to be auto increment
            DB::statement('ALTER TABLE job_postings MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE job_postings MODIFY id INT NOT NULL, DROP PRIMARY KEY');
    }
};