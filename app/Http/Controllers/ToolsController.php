<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class ToolsController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        $tools = $this->tools($locale);

        return view('site.tools', compact('locale', 'tools'));
    }

    private function tools(string $locale): array
    {
        $items = [
            [
                'icon' => 'document',
                'title' => 'Create Your Resume',
                'description' => 'Home create resume card description',
                'route' => 'localized.resume.gallery',
                'badge' => 'New',
                'coming_soon' => false,
            ],
            [
                'icon' => 'envelope',
                'title' => 'Bulk Email Sender',
                'description' => 'Home bulk email description',
                'route' => null,
                'badge' => 'Coming soon',
                'coming_soon' => true,
            ],
            [
                'icon' => 'briefcase',
                'title' => 'Send Your CV',
                'description' => 'Home send cv card description',
                'route' => null,
                'badge' => 'Coming soon',
                'coming_soon' => true,
            ],
            [
                'icon' => 'rss',
                'title' => 'Read or Post Blogs',
                'description' => 'Home blogs card description',
                'route' => 'localized.blogs',
                'badge' => null,
                'coming_soon' => false,
            ],
            [
                'icon' => 'magnifying-glass',
                'title' => 'Explore Jobs',
                'description' => 'Tools explore jobs description',
                'route' => 'localized.jobs',
                'badge' => null,
                'coming_soon' => false,
            ],
        ];

        foreach ($items as &$item) {
            $item['url'] = $item['route']
                ? route($item['route'], ['lang' => $locale])
                : null;
        }
        unset($item);

        return $items;
    }
}
