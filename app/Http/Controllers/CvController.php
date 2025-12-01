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
        // Get all active templates from database
        $templates = CvTemplate::where('is_active', true)->get();
        
        // Also scan for templates in the filesystem and merge with database
        $templatesPath = resource_path('views/cv/templates');
        $templateFolders = [];
        
        if (File::exists($templatesPath)) {
            $folders = File::directories($templatesPath);
            foreach ($folders as $folder) {
                $templateName = basename($folder);
                $configPath = $folder . '/config.json';
                
                if (File::exists($configPath)) {
                    $config = json_decode(File::get($configPath), true);
                    
                    // Get template from database if exists
                    $dbTemplate = CvTemplate::where('slug', $templateName)->first();
                    
                    // Determine preview path - prioritize database, then check filesystem
                    $previewPath = null;
                    if ($dbTemplate && $dbTemplate->preview_path) {
                        $previewPath = asset($dbTemplate->preview_path);
                    } else {
                        // Check for preview images in multiple formats
                        $previewExtensions = ['webp', 'png', 'jpg', 'jpeg'];
                        foreach ($previewExtensions as $ext) {
                            $previewFile = public_path('cv-templates/previews/' . $templateName . '-preview.' . $ext);
                            if (File::exists($previewFile)) {
                                $previewPath = asset('cv-templates/previews/' . $templateName . '-preview.' . $ext);
                                break;
                            }
                        }
                    }
                    
                    $templateFolders[] = [
                        'slug' => $templateName,
                        'name' => $config['name'] ?? ucfirst($templateName),
                        'description' => $config['description'] ?? ($dbTemplate ? $dbTemplate->description : ''),
                        'preview_path' => $previewPath
                    ];
                }
            }
        }
        
        return view('cv.index', compact('templates', 'templateFolders'));
    }
    
    /**
     * Show CV builder with selected template
     */
    public function builder($lang, $slug)
    {
        // Load template config from filesystem
        $templatePath = resource_path('views/cv/templates/' . $slug);
        $configPath = $templatePath . '/config.json';
        
        if (!File::exists($configPath)) {
            abort(404, 'Template not found');
        }
        
        $config = json_decode(File::get($configPath), true);
        
        // Load template from database if exists
        $template = CvTemplate::where('slug', $slug)->first();
        
        // Dummy data for preview (Phase 1)
        $dummyData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1 234 567 8900',
            'summary' => 'Experienced professional with a passion for excellence.',
            'experience' => [
                [
                    'title' => 'Senior Developer',
                    'company' => 'Tech Company Inc.',
                    'period' => '2020 - Present',
                    'description' => 'Leading development teams and building innovative solutions.'
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
            'data' => $dummyData
        ]);
    }
} 