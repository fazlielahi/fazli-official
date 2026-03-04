<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CvTemplate;
use App\Models\UserCV;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

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
            'summary' => 'Experienced E-commerce Seller managing online stores on Amazon, Shopify, and TikTok.'
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
    
    /**
     * Save user's CV data
     * 
     * Now using Laravel Auth - middleware ensures user is authenticated
     */
    public function save(Request $request)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        // Validate request
        $request->validate([
            'template_slug' => 'required|string',
            'cv_data' => 'required|array',
            'title' => 'nullable|string|max:255',
        ]);
        
        try {
            // Create or update CV
            $cv = UserCV::updateOrCreate(
                [
                    'user_id' => $userId,
                    'template_slug' => $request->input('template_slug'),
                    'is_active' => true // For now, save as active
                ],
                [
                    'title' => $request->input('title') ?? 'My CV',
                    'cv_data' => $request->input('cv_data'),
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'CV saved successfully!',
                'cv_id' => $cv->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving CV: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get user's saved CVs
     * 
     * Now using Laravel Auth - middleware ensures user is authenticated
     */
    public function getSavedCVs(Request $request)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        try {
            $cvs = UserCV::where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get(['id', 'title', 'template_slug', 'created_at', 'updated_at']);
            
            return response()->json([
                'success' => true,
                'cvs' => $cvs
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading CVs: ' . $e->getMessage(),
                'cvs' => []
            ], 500);
        }
    }
    
    /**
     * Load a specific saved CV
     * 
     * Now using Laravel Auth - middleware ensures user is authenticated
     */
    public function loadCV(Request $request, $lang, $id)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        try {
            $cv = UserCV::where('id', $id)
                ->where('user_id', $userId)
                ->first();
            
            if (!$cv) {
                // Check if CV exists but belongs to different user
                $cvExists = UserCV::where('id', $id)->exists();
                if ($cvExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to access this CV'
                    ], 403);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'CV not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'cv' => [
                    'id' => $cv->id,
                    'title' => $cv->title,
                    'template_slug' => $cv->template_slug,
                    'cv_data' => $cv->cv_data
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading CV: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export CV as PDF
     * 
     * Now using Laravel Auth - middleware ensures user is authenticated
     */
    public function exportPDF(Request $request, $lang, $id)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        try {
            // Load CV from database
            $cv = UserCV::where('id', $id)
                ->where('user_id', $userId)
                ->first();
            
            if (!$cv) {
                abort(404, 'CV not found or you do not have permission to access it');
            }
            
            // Get template
            $template = CvTemplate::where('slug', $cv->template_slug)->where('is_active', true)->first();
            
            if (!$template) {
                abort(404, 'Template not found');
            }
            
            // Check if template blade file exists
            $templatePath = resource_path('views/cv/templates/' . $cv->template_slug);
            $templateBladePath = $templatePath . '/template.blade.php';
            
            if (!File::exists($templateBladePath)) {
                abort(404, 'Template file not found');
            }
            
            // Prepare data for template
            $data = $cv->cv_data ?? [];
            
            // Render the template to HTML
            $html = view('cv.templates.' . $cv->template_slug . '.template', [
                'data' => $data
            ])->render();
            
            // Get template CSS
            $cssPath = $templatePath . '/style.css';
            $cssContent = '';
            if (File::exists($cssPath)) {
                $cssContent = File::get($cssPath);
            }
            
            // Extract font imports from CSS and wrap in style tag
            $fonts = '';
            if (preg_match_all('/@import\s+url\([^)]+\);/', $cssContent, $fontMatches)) {
                $fonts = '<style>' . implode("\n    ", $fontMatches[0]) . '</style>';
                // Remove @import statements from CSS to avoid duplication
                $cssContent = preg_replace('/@import\s+url\([^)]+\);\s*/', '', $cssContent);
            }
            
            // Wrap remaining CSS in style tag
            $css = '<style>' . $cssContent . '</style>';
            
            // Combine HTML and CSS
            $fullHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - ' . htmlspecialchars($cv->title ?? 'My CV') . '</title>
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    ' . $fonts . '
    ' . $css . '
    <style>
        /* PDF-specific fixes - Force proper rendering */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            box-sizing: border-box !important;
        }
        @page {
            margin: 0 !important;
            margin-top: 10mm !important;
        }
        @page :first {
            margin-top: 0 !important;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm !important;
            background: white !important;
            overflow: visible !important;
        }
        /* Force grid layout for modern template in PDF */
        .cv-template.modern .cv-page {
            display: grid !important;
            grid-template-rows: auto 1fr !important;
            grid-template-areas: 
                "top-bar"
                "main" !important;
        }
        .cv-template.modern .top-green {
            display: grid !important;
            grid-template-columns: 57.2mm 0.3mm 1fr !important;
            grid-template-areas: "photo-container gap top-content-area" !important;
        }
        .cv-template.modern .main-content {
            display: grid !important;
            grid-template-columns: 57.2mm 6.3mm 1fr !important;
            grid-template-areas: "left-green gap right-content" !important;
        }
        /* Prevent sections from breaking across pages */
        .cv-template.modern section {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .section-content {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .experience-item,
        .cv-template.modern .education-item,
        .cv-template.modern .certification-item,
        .cv-template.modern .skill-item,
        .cv-template.modern .language-item,
        .cv-template.modern .reference-item {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        /* Remove spacing between name and subtitle in PDF */
        .cv-template.modern .name {
            margin: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.1 !important;
        }
        .cv-template.modern .subtitle {
            margin: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        /* Fix images */
        img {
            max-width: 100% !important;
            height: auto !important;
        }
        /* Remove page container styling for PDF export - page containers are editor-only */
        .cv-pages-wrapper,
        .cv-page-container {
            display: block !important;
            width: 100% !important;
            min-height: auto !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            overflow: visible !important;
            page-break-after: auto !important;
            break-after: auto !important;
        }
        .cv-page-container .cv-template {
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background: white; overflow: visible;">
    <div style="width: 210mm; margin: 0 auto; position: relative;">
    ' . $html . '
    </div>
</body>
</html>';
            
            // Generate PDF using Browsershot
            $pdf = Browsershot::html($fullHtml)
                ->format('A4')
                ->margins(0, 0, 0, 0, 'mm')
                ->showBackground()
                ->waitUntilNetworkIdle(false) // Don't wait for network idle (faster, handles large content better)
                ->timeout(120) // Increase timeout to 120 seconds for large CVs
                ->delay(3000) // Wait 3 seconds for fonts and images to load
                ->setOption('viewport', [
                    'width' => 794,  // A4 width in pixels at 96 DPI
                    'height' => 1123  // A4 height in pixels at 96 DPI
                ])
                ->setOption('preferCSSPageSize', false)
                ->setOption('printBackground', true)
                ->setOption('waitForSelector', null) // Don't wait for specific selectors
                ->pdf();
            
            // Generate filename
            $filename = str_replace(' ', '_', $cv->title ?? 'My_CV') . '_' . date('Y-m-d') . '.pdf';
            $filename = preg_replace('/[^A-Za-z0-9_.-]/', '', $filename);
            
            // Return PDF as download
            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cv_id' => $id,
                'template' => $cv->template_slug ?? 'unknown'
            ]);
            
            // Return a more user-friendly error message
            if (strpos($e->getMessage(), 'Timeout') !== false) {
                abort(500, 'PDF generation timed out. Your CV may be too large. Please try reducing the content or contact support.');
            }
            
            abort(500, 'Error generating PDF: ' . $e->getMessage());
        }
    }
    
    /**
     * Export current CV preview as PDF (without saving)
     */
    public function exportCurrentPDF(Request $request, $lang, $slug)
    {
        try {
            // Get cv_data - it might be a JSON string or an array
            $cvDataInput = $request->input('cv_data');
            
            // If it's a string (JSON), decode it
            if (is_string($cvDataInput)) {
                $data = json_decode($cvDataInput, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid CV data format'
                    ], 400);
                }
            } else {
                $data = $cvDataInput;
            }
            
            // Validate that we have data
            if (empty($data) || !is_array($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'CV data is required and must be valid'
                ], 400);
            }
            
            // Get template
            $template = CvTemplate::where('slug', $slug)->where('is_active', true)->first();
            
            if (!$template) {
                abort(404, 'Template not found');
            }
            
            // Check if template blade file exists
            $templatePath = resource_path('views/cv/templates/' . $slug);
            $templateBladePath = $templatePath . '/template.blade.php';
            
            if (!File::exists($templateBladePath)) {
                abort(404, 'Template file not found');
            }
            
            // Render the template to HTML
            $html = view('cv.templates.' . $slug . '.template', [
                'data' => $data
            ])->render();
            
            // Get template CSS
            $cssPath = $templatePath . '/style.css';
            $cssContent = '';
            if (File::exists($cssPath)) {
                $cssContent = File::get($cssPath);
            }
            
            // Extract font imports from CSS and wrap in style tag
            $fonts = '';
            if (preg_match_all('/@import\s+url\([^)]+\);/', $cssContent, $fontMatches)) {
                $fonts = '<style>' . implode("\n    ", $fontMatches[0]) . '</style>';
                // Remove @import statements from CSS to avoid duplication
                $cssContent = preg_replace('/@import\s+url\([^)]+\);\s*/', '', $cssContent);
            }
            
            // Wrap remaining CSS in style tag
            $css = '<style>' . $cssContent . '</style>';
            
            // Combine HTML and CSS
            $fullHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - ' . htmlspecialchars($data['name'] ?? 'My CV') . '</title>
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    ' . $fonts . '
    ' . $css . '
    <style>
        /* PDF-specific fixes - Force proper rendering */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            box-sizing: border-box !important;
        }
        @page {
            margin: 0 !important;
            margin-top: 10mm !important;
        }
        @page :first {
            margin-top: 0 !important;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm !important;
            background: white !important;
            overflow: visible !important;
        }
        /* Force grid layout for modern template in PDF */
        .cv-template.modern .cv-page {
            display: grid !important;
            grid-template-rows: auto 1fr !important;
            grid-template-areas: 
                "top-bar"
                "main" !important;
        }
        .cv-template.modern .top-green {
            display: grid !important;
            grid-template-columns: 57.2mm 0.3mm 1fr !important;
            grid-template-areas: "photo-container gap top-content-area" !important;
        }
        .cv-template.modern .main-content {
            display: grid !important;
            grid-template-columns: 57.2mm 6.3mm 1fr !important;
            grid-template-areas: "left-green gap right-content" !important;
        }
        /* Prevent sections from breaking across pages */
        .cv-template.modern section {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .section-content {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .experience-item,
        .cv-template.modern .education-item,
        .cv-template.modern .certification-item,
        .cv-template.modern .skill-item,
        .cv-template.modern .language-item,
        .cv-template.modern .reference-item {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        /* Remove spacing between name and subtitle in PDF */
        .cv-template.modern .name {
            margin: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.1 !important;
        }
        .cv-template.modern .subtitle {
            margin: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        /* Fix images */
        img {
            max-width: 100% !important;
            height: auto !important;
        }
        /* Remove page container styling for PDF export - page containers are editor-only */
        .cv-pages-wrapper,
        .cv-page-container {
            display: block !important;
            width: 100% !important;
            min-height: auto !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            overflow: visible !important;
            page-break-after: auto !important;
            break-after: auto !important;
        }
        .cv-page-container .cv-template {
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background: white; overflow: visible;">
    <div style="width: 210mm; margin: 0 auto; position: relative;">
    ' . $html . '
    </div>
</body>
</html>';
            
            // Generate PDF using Browsershot
            $pdf = Browsershot::html($fullHtml)
                ->format('A4')
                ->margins(0, 0, 0, 0, 'mm')
                ->showBackground()
                ->waitUntilNetworkIdle(false) // Don't wait for network idle (faster, handles large content better)
                ->timeout(120) // Increase timeout to 120 seconds for large CVs
                ->delay(3000) // Wait 3 seconds for fonts and images to load
                ->setOption('viewport', [
                    'width' => 794,  // A4 width in pixels at 96 DPI
                    'height' => 1123  // A4 height in pixels at 96 DPI
                ])
                ->setOption('preferCSSPageSize', false)
                ->setOption('printBackground', true)
                ->setOption('waitForSelector', null) // Don't wait for specific selectors
                ->pdf();
            
            // Generate filename
            $name = $data['name'] ?? 'My_CV';
            $filename = str_replace(' ', '_', $name) . '_' . date('Y-m-d') . '.pdf';
            $filename = preg_replace('/[^A-Za-z0-9_.-]/', '', $filename);
            
            // Return PDF as download
            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('PDF Generation Error (Current): ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'template' => $slug
            ]);
            
            // Return a more user-friendly error message
            $errorMessage = 'Error generating PDF: ' . $e->getMessage();
            if (strpos($e->getMessage(), 'Timeout') !== false) {
                $errorMessage = 'PDF generation timed out. Your CV may be too large. Please try reducing the content or contact support.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }
} 