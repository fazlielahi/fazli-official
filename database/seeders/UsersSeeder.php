<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create super_admin user
        DB::table('users')->insert([
            'name' => 'TFC - The Fazli Community',
            'email' => 'info@thefazli.com',
            'password' => Hash::make('Tfc@5556'),
            'type' => 'super_admin',
            'photo' => 'default.png',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        // Create 5 admin users with romanized Arabic names
        $admins = [
            [
                'name' => 'Sofia',
                'email' => 'sofia@thefazli.com',
            ],
            [
                'name' => 'Fazli Elahi',
                'email' => 'admin@thefazli.com',
            ],
        ];

        foreach ($admins as $admin) {
            DB::table('users')->insert([
                'name' => $admin['name'],
                'email' => $admin['email'],
                $password = strtolower(explode(' ', $admin['name'])[0]) . '@2021',
                'type' => 'admin',
                'photo' => 'default.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
