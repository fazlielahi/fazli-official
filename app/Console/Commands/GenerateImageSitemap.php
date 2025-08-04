<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\App;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Tags\Image;
use App\Models\Blog; // Change this if your model is named differently

class GenerateImageSitemap extends Command
{
    protected $signature = 'sitemap:image';
    protected $description = 'Generate image-sitemap.xml';

    public function handle()
    {
        $baseUrl = 'https://thefazli.com';
        $locale = app()->getLocale();

        $sitemap = Sitemap::create();

        $blogs = Blog::all(); // Adjust this to your actual model

        foreach ($blogs as $blog) {
            $url = Url::create("{$baseUrl}/{$locale}/blog/{$blog->slug}");

            // If your image path is stored like 'uploads/blogs/image.jpg'
            $imageFullPath = "{$baseUrl}/storage/{$blog->image}";

            $url->addImage($imageFullPath);

            $sitemap->add($url);
        }

        $sitemap->writeToFile(public_path('image-sitemap.xml'));

        $this->info('image-sitemap.xml generated successfully.');
    }
}
