<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Default site settings (insert only if missing — does not overwrite admin changes).
     */
    public function run(): void
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
}
