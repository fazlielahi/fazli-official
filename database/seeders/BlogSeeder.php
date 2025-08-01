<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('blogs')->insert([
            [
                'created_by' => 1,
                'category_id' => 2,
                'title' => 'Getting Started with Laravel',
                'slug' => Str::slug('Getting Started with Laravel'),
                'content' => 'This blog explains the basics of Laravel for beginners...',
                'image' => 'uploads/blogs/laravel-start.png',
                'thumb' => 'uploads/blogs/thumbs/laravel-start-thumb.png',
                'status' => 'published', // options: draft, pending, approved, rejected
                'created_at' => $now,
                'updated_at' => $now,
                'approved_by' => 2,
                'approved_at' => $now,
                'approval_message' => 'Looks great!',
                'rejection_message' => null,
                'rejected_by' => null
            ],
            [
                'created_by' => 1,
                'category_id' => 3,
                'title' => 'PHP 8.2 Features Overview',
                'slug' => Str::slug('PHP 8.2 Features Overview'),
                'content' => 'In this blog, we explore the latest features of PHP 8.2...',
                'image' => 'uploads/blogs/php82.png',
                'thumb' => 'uploads/blogs/thumbs/php82-thumb.png',
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
                'approved_by' => null,
                'approved_at' => null,
                'approval_message' => null,
                'rejection_message' => null,
                'rejected_by' => null
            ],
            // Add more blog entries if needed
        ]);
    }
}
