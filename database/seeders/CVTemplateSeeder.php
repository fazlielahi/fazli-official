<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CvTemplate;
use Illuminate\Support\Facades\File;

class CVTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all template folders
        $templatesPath = resource_path('views/cv/templates');
        
        if (!File::exists($templatesPath)) {
            $this->command->warn('Templates directory not found: ' . $templatesPath);
            return;
        }
        
        $templateFolders = File::directories($templatesPath);
        
        foreach ($templateFolders as $folder) {
            $templateSlug = basename($folder);
            $configPath = $folder . '/config.json';
            
            // Skip if config.json doesn't exist
            if (!File::exists($configPath)) {
                $this->command->warn("Config file not found for template: {$templateSlug}");
                continue;
            }
            
            // Read and decode config.json
            $configContent = File::get($configPath);
            $config = json_decode($configContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->command->error("Invalid JSON in config file for template: {$templateSlug}");
                continue;
            }
            
            // Check if preview image exists
            $previewPath = null;
            $previewExtensions = ['webp', 'png', 'jpg'];
            
            foreach ($previewExtensions as $ext) {
                $previewFile = public_path('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                if (File::exists($previewFile)) {
                    $previewPath = 'cv-templates/previews/' . $templateSlug . '-preview.' . $ext;
                    break;
                }
            }
            
            // Create or update template in database
            CvTemplate::updateOrCreate(
                ['slug' => $templateSlug],
                [
                    'name' => $config['name'] ?? ucfirst($templateSlug),
                    'description' => $config['description'] ?? 'Professional CV template',
                    'preview_path' => $previewPath,
                    'config' => $config,
                    'is_active' => true,
                ]
            );
            
            $this->command->info("Template seeded: {$templateSlug}");
        }
        
        $this->command->info('CV Templates seeding completed!');
    }
}

