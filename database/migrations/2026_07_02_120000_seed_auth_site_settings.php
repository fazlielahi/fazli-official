<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $defaults = [
            'session_lifetime_minutes' => (string) max(5, min(10080, (int) env('SESSION_LIFETIME', 120))),
            'remember_me_days' => (string) max(1, min(365, (int) env('REMEMBER_ME_DAYS', 30))),
            'session_expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false) ? '1' : '0',
        ];

        foreach ($defaults as $key => $value) {
            if (DB::table('site_settings')->where('key', $key)->exists()) {
                continue;
            }

            DB::table('site_settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        DB::table('site_settings')->whereIn('key', [
            'session_lifetime_minutes',
            'remember_me_days',
            'session_expire_on_close',
        ])->delete();
    }
};
