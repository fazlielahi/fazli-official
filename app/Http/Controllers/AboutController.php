<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CvTemplate;
use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function aboutTfc(Request $request)
    {
        $locale = App::getLocale();
        $blogs = Blog::query()
            ->where('status', 'published')
            ->with([
                'creater',
                'category',
                'comments' => fn ($commentQuery) => $commentQuery->latest(),
            ])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('id')
            ->take(2)
            ->get();

        $visitorToken = $request->cookie('visiter_token');
        $likedBlogIds = $visitorToken
            ? Likes::where('visiter_token', $visitorToken)->pluck('blog_id')->all()
            : [];

        $services = app(ServiceController::class)->serviceItems($locale);
        $portfolioItems = $this->portfolioItems();
        $testimonialItems = $this->testimonialItems();
        
        // Preview a few CV templates; full gallery lives on /resume
        $dbTemplates = CvTemplate::where('is_active', true)->orderByDesc('id')->take(3)->get();
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
        
        return view('site.about-tfc', compact('locale', 'blogs', 'cvTemplates', 'likedBlogIds', 'services', 'portfolioItems', 'testimonialItems'));
    }

    private function testimonialItems(): array
    {
        return [
            [
                'name_key' => 'testimonial_majid_name',
                'title_key' => 'testimonial_majid_title',
                'text_key' => 'testimonial_majid_text',
                'image' => 'images/testimonial/majid-khan.jpg',
                'linkedin' => 'https://www.linkedin.com/in/mian-majid-khan-7a8b9c5d/',
            ],
            [
                'name_key' => 'testimonial_samad_name',
                'title_key' => 'testimonial_samad_title',
                'text_key' => 'testimonial_samad_text',
                'image' => 'images/testimonial/samad-khan.jpg',
                'linkedin' => 'https://www.linkedin.com/in/samad-khan-488a13232/',
            ],
            [
                'name_key' => 'testimonial_waleed_name',
                'title_key' => 'testimonial_waleed_title',
                'text_key' => 'testimonial_waleed_text',
                'image' => 'images/testimonial/waleed-zafar.jpg',
                'linkedin' => 'https://www.linkedin.com/in/samad-khan-488a13232/',
            ],
            [
                'name_key' => 'testimonial_hamza_name',
                'title_key' => 'testimonial_hamza_title',
                'text_key' => 'testimonial_hamza_text',
                'image' => 'images/default.svg',
                'linkedin' => 'https://www.linkedin.com/in/ameer-hamza-74648a366/',
            ],
        ];
    }

    private function portfolioItems(): array
    {
        return [
            [
                'image' => 'project/1.jpg',
                'image_alt' => 'PEC Engineering website project developed by TFC',
                'date_key' => 'Apr 25, 2025',
                'status_key' => 'Completed!',
                'title_key' => 'PEC Engineering Website',
                'desc_key' => 'PEC Engineering Website desc',
                'url' => 'https://pec.com.sa',
                'read_more' => false,
            ],
            [
                'image' => 'project/2.jpg',
                'image_alt' => 'Architecture portfolio website for mianmajid.arch designed by TFC',
                'date_key' => 'March 18, 2025',
                'status_key' => 'Ongoing!',
                'title_key' => 'Architecture Portfolio – mianmajid.arch',
                'desc_key' => 'Architecture Portfolio – mianmajid.arch desc',
                'url' => 'https://www.linkedin.com/in/fazlielahi/',
                'read_more' => false,
            ],
            [
                'image' => 'project/3.jpg',
                'image_alt' => '4Space Furniture website – Modern furniture and custom design project by TFC',
                'date_key' => 'Jan 01, 2025',
                'status_key' => 'Completed!',
                'title_key' => '4Space Furniture Website – Modern Furniture & Custom Design',
                'desc_key' => '4Space Furniture Website – Modern Furniture & Custom Design desc',
                'url' => 'https://4space.com.sa/',
                'read_more' => false,
            ],
            [
                'image' => 'project/4.jpg',
                'image_alt' => 'ERP system website project developed by TFC',
                'date_key' => 'August 25, 2024',
                'status_key' => 'Completed!',
                'title_key' => 'ERP System Website',
                'desc_key' => 'ERP System Website desc',
                'url' => 'https://new.tamakantech.com',
                'read_more' => true,
            ],
        ];
    }
}
