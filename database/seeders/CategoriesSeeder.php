<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Web Development',
            'Projects & Case Studies',
            'Learning Resources',
            'AI & Automation',
            'Career Tips',
            'Tech News & Trends',
            'APIs & Integrations',
            'Resume & Portfolio Tips',
            'UI/UX Design',
            'Hosting & Deployment',
            // General categories
            'Sports',
            'Politics',
            'Entertainment',
            'Science',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
} 