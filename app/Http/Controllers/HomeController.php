<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str; //to use its static method str::random() without typing the full namespace eachtime
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Models\Likes;
use App\Models\CvTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        $blogs = \App\Models\Blog::where('status', 'published')->orderByDesc('id')->take(4)->get();
        
        // Get CV templates for home page (limit to 6)
        $dbTemplates = CvTemplate::where('is_active', true)->orderByDesc('id')->take(6)->get();
        $cvTemplates = [];
        
        foreach ($dbTemplates as $dbTemplate) {
            $templateSlug = $dbTemplate->slug;
            
            // Get preview path from database
            $previewPath = null;
            if ($dbTemplate->preview_path) {
                $previewPath = asset($dbTemplate->preview_path);
            } else {
                // Fallback: check filesystem for preview image
                $previewExtensions = ['webp', 'png', 'jpg', 'jpeg'];
                foreach ($previewExtensions as $ext) {
                    $previewFile = public_path('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                    if (File::exists($previewFile)) {
                        $previewPath = asset('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                        break;
                    }
                }
            }
            
            $cvTemplates[] = [
                'slug' => $dbTemplate->slug,
                'name' => $dbTemplate->name,
                'description' => $dbTemplate->description ?? 'Professional CV template',
                'preview_path' => $previewPath,
            ];
        }
        
        return view('site.index', compact('locale', 'blogs', 'cvTemplates'));
    }
}
