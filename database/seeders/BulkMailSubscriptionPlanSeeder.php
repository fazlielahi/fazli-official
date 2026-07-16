<?php

namespace Database\Seeders;

use App\Models\BulkMail\SubscriptionPlan;
use Illuminate\Database\Seeder;

class BulkMailSubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'monthly_email_limit' => 500,
                'daily_email_limit' => 50,
                'max_contacts' => 200,
                'max_lists' => 1,
                'price' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'monthly_email_limit' => 5000,
                'daily_email_limit' => 200,
                'max_contacts' => 2000,
                'max_lists' => 5,
                'price' => 9.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'monthly_email_limit' => 25000,
                'daily_email_limit' => 1000,
                'max_contacts' => 10000,
                'max_lists' => 20,
                'price' => 29.00,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::query()->updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
