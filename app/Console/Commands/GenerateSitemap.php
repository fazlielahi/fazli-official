<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\App;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Blog;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://thefazli.com';
        $locale = app()->getLocale();
    
        // Create sitemap instance
        $sitemap = Sitemap::create()
            ->add(Url::create("{$baseUrl}/{$locale}"))
            ->add(Url::create("{$baseUrl}/{$locale}/about"))
            ->add(Url::create("{$baseUrl}/{$locale}/services"))
            ->add(Url::create("{$baseUrl}/{$locale}/blogs"))
            ->add(Url::create("{$baseUrl}/{$locale}/books"))
            ->add(Url::create("{$baseUrl}/{$locale}/jobs"))
            ->add(Url::create("{$baseUrl}/{$locale}/cv-create"))
            ->add(Url::create("{$baseUrl}/{$locale}/contact"));
    
        // Add dynamic blog URLs
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $sitemap->add(Url::create("{$baseUrl}/{$locale}/blog/{$blog->slug}"));
        }
    
        // Write to file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    
        $this->info('sitemap.xml generated successfully.');
    }
    
}
