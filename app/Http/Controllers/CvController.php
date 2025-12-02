<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvTemplate;
use Illuminate\Support\Facades\File;

class CvController extends Controller
{
    /**
     * Show CV template gallery
     */
    public function index()
    {
        // Get all ACTIVE templates from database (primary source - managed from admin panel)
        $dbTemplates = CvTemplate::where('is_active', true)->get();
        
        $templatesPath = resource_path('views/cv/templates');
        $templateFolders = [];
        
        // Process each active template from database ONLY
        // Gallery will ONLY show templates managed from admin panel
        foreach ($dbTemplates as $dbTemplate) {
            $templateSlug = $dbTemplate->slug;
            $templateFolder = $templatesPath . '/' . $templateSlug;
            
            // Get preview path from database (admin panel managed)
            $previewPath = null;
            if ($dbTemplate->preview_path) {
                $previewPath = asset($dbTemplate->preview_path);
            } else {
                // Fallback: check filesystem for preview image (if not uploaded via admin)
                $previewExtensions = ['webp', 'png', 'jpg', 'jpeg'];
                foreach ($previewExtensions as $ext) {
                    $previewFile = public_path('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                    if (File::exists($previewFile)) {
                        $previewPath = asset('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                        break;
                    }
                }
            }
            
            // Use database data (from admin panel) as source of truth
            // Show template even if folder doesn't exist (admin can create template first, then add files)
            $templateFolders[] = [
                'slug' => $dbTemplate->slug,
                'name' => $dbTemplate->name,
                'description' => $dbTemplate->description ?? 'Professional CV template',
                'preview_path' => $previewPath,
                'folder_exists' => File::exists($templateFolder) // For debugging/warnings
            ];
        }
        
        return view('cv.index', compact('templateFolders'));
    }
    
    /**
     * Show CV builder with selected template
     */
    public function builder($lang, $slug)
    {
        // Load template from database first (admin panel managed)
        $template = CvTemplate::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$template) {
            abort(404, 'Template not found or inactive');
        }
        
        // Try to load config from database first, then fallback to filesystem
        $config = null;
        if ($template->config && is_array($template->config)) {
            $config = $template->config;
        } else {
            // Fallback: Load config from filesystem
            $templatePath = resource_path('views/cv/templates/' . $slug);
            $configPath = $templatePath . '/config.json';
            
            if (File::exists($configPath)) {
                $config = json_decode(File::get($configPath), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $config = null;
                }
            }
        }
        
        // If no config found, create a basic one
        if (!$config) {
            $config = [
                'name' => $template->name,
                'slug' => $template->slug,
                'description' => $template->description ?? 'CV Template',
                'sections' => [
                    'required' => ['header'],
                    'optional' => ['summary', 'experience', 'education', 'skills']
                ],
                'layout' => [
                    'type' => 'single-column'
                ],
                'styling' => [
                    'primary_color' => '#2563eb',
                    'font_family' => 'Arial, sans-serif'
                ]
            ];
        }
        
        // Check if template blade file exists (required for rendering)
        $templatePath = resource_path('views/cv/templates/' . $slug);
        $templateBladePath = $templatePath . '/template.blade.php';
        $templateExists = File::exists($templateBladePath);
        
        // Dummy data for preview (Phase 1)
        $dummyData = [
            'name' => 'Zahra Al-Khalil',
            'email' => 'zahra@thefazli.com',
            'phone' => '+966 59 230 4816',
            'summary' => 'Experienced E-commerce Seller managing online stores on Amazon, Shopify, and TikTok.',
            'experience' => [
                [
                    'title' => 'E-Commerce Specialist',
                    'company' => 'Tech Company Inc.',
                    'period' => '2020 - Present',
                    'description' => 'Experienced E-commerce Seller managing online stores on Amazon, Shopify, and TikTok.'
                ]
            ],
            'education' => [
                [
                    'degree' => 'Bachelor of Science',
                    'institution' => 'University Name',
                    'period' => '2016 - 2020'
                ]
            ]
        ];
        
        return view('cv.builder', [
            'templateSlug' => $slug,
            'lang' => $lang,
            'config' => $config,
            'template' => $template,
            'templateExists' => $templateExists,
            'data' => $dummyData
        ]);
    }
} 