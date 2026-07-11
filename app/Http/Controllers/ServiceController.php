<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ServiceController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        $services = $this->services($locale);

        return view('site.services', compact('locale', 'services'));
    }

    public function serviceItems(string $locale): array
    {
        return $this->services($locale);
    }

    private function services(string $locale): array
    {
        $items = [
            [
                'slug' => 'web-design-development',
                'title' => 'Web Design & Development',
                'image' => 'web-development.jpg',
                'reviews' => '32 Reviews',
            ],
            [
                'slug' => 'corporate-identity',
                'title' => 'Corporate Identity',
                'image' => 'coorporate-identity.jpg',
                'reviews' => '25 Reviews',
            ],
            [
                'slug' => 'digital-marketing',
                'title' => 'Digital Marketing',
                'image' => 'digital-marketing.jpg',
                'reviews' => '30 Reviews',
            ],
            [
                'slug' => 'ecommerce-development',
                'title' => 'Ecommerce Development',
                'image' => 'ecommerce.jpg',
                'reviews' => '27 Reviews',
            ],
            [
                'slug' => 'social-media-marketing',
                'title' => 'Social Media Marketing',
                'image' => 'social-media-marketing.jpg',
                'reviews' => '24 Reviews',
            ],
            [
                'slug' => 'wordpress-development',
                'title' => 'WordPress Development',
                'image' => 'wordpress.jpg',
                'reviews' => '22 Reviews',
            ],
            [
                'slug' => 'seo-training',
                'title' => 'SEO Training',
                'image' => 'seo-training.jpg',
                'reviews' => '20 Reviews',
            ],
        ];

        foreach ($items as &$item) {
            $item['contact_url'] = route('localized.contact', [
                'lang' => $locale,
                'service' => $item['slug'],
            ]);
        }
        unset($item);

        return $items;
    }
}
