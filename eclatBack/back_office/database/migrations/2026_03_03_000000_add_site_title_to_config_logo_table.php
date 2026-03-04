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
        if (!Schema::hasColumn('config_logo', 'site_title')) {
            Schema::table('config_logo', function (Blueprint $table) {
                $table->string('site_title', 255)->default('EPI - Eclat pro Ivoire')->after('alt_text');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('config_logo', 'site_title')) {
            Schema::table('config_logo', function (Blueprint $table) {
                $table->dropColumn('site_title');
            });
        }
    }
};
