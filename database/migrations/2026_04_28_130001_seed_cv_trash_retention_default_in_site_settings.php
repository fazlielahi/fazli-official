<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        if (DB::table('site_settings')->where('key', 'cv_trash_retention_days')->exists()) {
            return;
        }

        DB::table('site_settings')->insert([
            'key' => 'cv_trash_retention_days',
            'value' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        DB::table('site_settings')->where('key', 'cv_trash_retention_days')->delete();
    }
};
