<?php

use Illuminate\Support\Str;

if (!function_exists('getTextDirection')) {
    function getTextDirection($text)
    {
        // Detect Arabic, Urdu, Persian, Hebrew characters
        if (preg_match('/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{0590}-\x{05FF}]/u', $text)) {
            return 'right';
        }
        return 'left';
    }
}

if (!function_exists('blogThumbMeta')) {
    function blogThumbMeta($blog): array
    {
        $default = asset('images/blog-default.svg');
        $hasThumb = $blog->thumb && file_exists(public_path('storage/' . $blog->thumb));

        return [
            'url' => $hasThumb ? asset('storage/' . $blog->thumb) : $default,
            'is_default' => ! $hasThumb,
            'default' => $default,
        ];
    }
}

if (!function_exists('blogExcerpt')) {
    function blogExcerpt(?string $content, int $limit = 120): string
    {
        return Str::limit(html_entity_decode(strip_tags((string) $content)), $limit);
    }
}

if (!function_exists('blogReadTime')) {
    function blogReadTime(?string $content): int
    {
        $words = str_word_count(strip_tags((string) $content));

        return max(1, (int) ceil($words / 200));
    }
}

if (!function_exists('userPhotoUrl')) {
    function userPhotoUrl($user = null, ?string $fallbackPhoto = null): string
    {
        $default = asset('images/default.svg');
        $photo = null;

        if (is_object($user) && ! empty($user->photo)) {
            $photo = (string) $user->photo;
        } elseif (is_string($user) && $user !== '') {
            $photo = $user;
        } elseif ($fallbackPhoto) {
            $photo = $fallbackPhoto;
        }

        if (! $photo || trim($photo) === '') {
            return $default;
        }

        $photo = trim($photo);

        if (Str::startsWith($photo, ['http://', 'https://'])) {
            return $photo;
        }

        $placeholderValues = [
            'default.png',
            'default.svg',
            'images/default.png',
            'images/default.svg',
        ];

        if (in_array($photo, $placeholderValues, true) || str_contains($photo, 'default.png')) {
            return $default;
        }

        $path = str_starts_with($photo, 'images/') ? $photo : 'images/' . ltrim($photo, '/');

        return file_exists(public_path($path)) ? asset($path) : $default;
    }
}

if (!function_exists('profileBlogReturnUrl')) {
    function profileBlogReturnUrl(?\Illuminate\Http\Request $request = null, $blog = null): string
    {
        $request ??= request();
        $locale = app()->getLocale();

        $fallback = route('localized.profile-draft-blogs', ['lang' => $locale]);

        if ($blog && is_object($blog) && isset($blog->status)) {
            $fallback = match ($blog->status) {
                'published' => route('localized.profile-published-blogs', ['lang' => $locale]),
                'request' => route('localized.profile-request-blogs', ['lang' => $locale]),
                'rejected' => route('localized.profile-rejected-blogs', ['lang' => $locale]),
                default => $fallback,
            };
        }

        $candidate = $request->query('return') ?: url()->previous();

        if (! is_string($candidate) || $candidate === '' || $candidate === url()->current()) {
            return $fallback;
        }

        $appRoot = url('/');

        if (! str_starts_with($candidate, $appRoot) && ! str_starts_with($candidate, '/')) {
            return $fallback;
        }

        if (preg_match('#/(create-blog|/admin/blog/\d+/edit)(\?|$)#', $candidate)) {
            return $fallback;
        }

        return $candidate;
    }
}
