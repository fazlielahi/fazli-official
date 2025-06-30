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
            'name' => 'Mohammed Al-Fayez',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('12345678'),
            'type' => 'super_admin',
            'photo' => 'default.png',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        // Create 5 admin users with romanized Arabic names
        $admins = [
            [
                'name' => 'Ahmed Al-Abdullah',
                'email' => 'admin1@example.com',
            ],
            [
                'name' => 'Fatima Al-Zahra',
                'email' => 'admin2@example.com',
            ],
            [
                'name' => 'Abdulrahman Al-Qasim',
                'email' => 'admin3@example.com',
            ],
            [
                'name' => 'Noura Al-Harbi',
                'email' => 'admin4@example.com',
            ],
            [
                'name' => 'Sultan Al-Otaibi',
                'email' => 'admin5@example.com',
            ],
        ];

        foreach ($admins as $admin) {
            DB::table('users')->insert([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('12345678'),
                'type' => 'admin',
                'photo' => 'default.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
