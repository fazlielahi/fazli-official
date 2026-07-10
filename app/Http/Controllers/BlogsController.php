<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Likes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category_id');

        return $this->renderBlogsPage($request, $selectedCategory ? (int) $selectedCategory : null);
    }

    public function rejectedBlogs(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all();
        $selectedCategory = $request->input('category_id');
        $categoryId = $selectedCategory ? (int) $selectedCategory : null;

        $query = Blog::query()
            ->where('status', 'rejected')
            ->where('created_by', $user->id)
            ->with(['creater', 'category', 'rejected_by_user'])
            ->orderByDesc('rejected_at')
            ->orderByDesc('updated_at');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $blogs = $query->paginate(12)->withQueryString();

        return view('site.rejected_blogs', compact('blogs', 'user', 'categories', 'selectedCategory'));
    }

    public function category($locale, $slug)
    {
        $request = request();
        $selectedCategory = Category::where('slug', $slug)->firstOrFail();

        return $this->renderBlogsPage(
            $request,
            $selectedCategory->id,
            $selectedCategory->slug
        );
    }

    public function searchPreview(Request $request, $locale): JsonResponse
    {
        $search = trim((string) $request->input('q', ''));
        if (mb_strlen($search) < 2) {
            return response()->json([
                'total' => 0,
                'items' => [],
            ]);
        }

        $categoryId = $request->input('category_id');
        $categoryId = $categoryId ? (int) $categoryId : null;

        $query = $this->buildBlogQuery($request, $categoryId);
        $total = $query->count();
        $blogs = $this->buildBlogQuery($request, $categoryId)->limit(5)->get();

        return response()->json([
            'total' => $total,
            'items' => $blogs->map(function (Blog $blog) use ($locale) {
                $thumb = blogThumbMeta($blog);

                return [
                    'id' => $blog->id,
                    'title' => Str::limit(html_entity_decode(strip_tags($blog->title)), 70),
                    'thumb' => $thumb['url'],
                    'url' => route('localized.blog-details', ['lang' => $locale, 'slug' => $blog->slug]),
                ];
            })->values(),
        ]);
    }

    public function blogDetails($locale, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $popular_blogs = Blog::where('id', '!=', $blog->id)->where('status', 'published')->latest()->take(10)->get();
        $categories = Category::all();
        $selectedCategory = $blog->category_id;

        return view('site.blog-details', compact('blog', 'popular_blogs', 'categories', 'selectedCategory', 'locale'));
    }

    public function comment(Request $request, $locale, Blog $blog)
    {
        $request->validate([
            'comment' => 'required',
            'name' => 'nullable',
        ]);

        $token = $request->cookie('visiter_token');

        if (! $token) {
            $token = Str::random(60);
            Cookie::queue('visiter_token', $token, 60 * 24 * 365);
        }

        if (Auth::check()) {
            $user = Auth::user();

            $comment = Comment::create([
                'name' => $user->name,
                'blog_id' => $blog->id,
                'comment' => $request->comment,
                'user_id' => $user->id,
                'visiter_token' => $token,
            ]);
        } else {
            $existingComment = Comment::where('visiter_token', $token)->first();
            $name = $existingComment ? $existingComment->name : $request->name;

            $comment = Comment::create([
                'name' => $name,
                'blog_id' => $blog->id,
                'comment' => $request->comment,
                'visiter_token' => $token,
            ]);
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $user = $comment->user;
            $html = view('site.partials.comment', compact('comment', 'user'))->render();

            return response()->json([
                'success' => true,
                'message' => __('lang.Comment submitted successfully!'),
                'html' => $html,
            ]);
        }

        return redirect()->back();
    }

    public function like(Request $request, $locale, Blog $blog)
    {
        $token = $request->cookie('visiter_token');

        if (! $token) {
            $token = Str::random(60);
            Cookie::queue('visiter_token', $token, 60 * 24 * 365);
        }

        $existingLike = Likes::where('blog_id', $blog->id)
            ->where('visiter_token', $token)
            ->exists();

        if (! $existingLike) {
            Likes::create([
                'visiter_token' => $token,
                'blog_id' => $blog->id,
            ]);
        }

        if ($request->ajax()) {
            $blog->refresh();

            return new JsonResponse([
                'count' => $blog->likes()->count(),
            ]);
        }

        return redirect()->back();
    }

    private function renderBlogsPage(Request $request, ?int $categoryId = null, ?string $selectedCategorySlug = null)
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->input('q', ''));
        $sort = (string) $request->input('sort', 'newest');

        $categories = Category::query()
            ->withCount([
                'blog as published_count' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->orderBy('name')
            ->get();

        $totalPublishedCount = Blog::where('status', 'published')->count();

        $blogs = $this->buildBlogQuery($request, $categoryId)
            ->paginate(12)
            ->withQueryString();

        $visitorToken = $request->cookie('visiter_token');
        $likedBlogIds = $visitorToken
            ? Likes::where('visiter_token', $visitorToken)->pluck('blog_id')->all()
            : [];

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html' => view('site.partials.blogs-results', [
                    'blogs' => $blogs,
                    'likedBlogIds' => $likedBlogIds,
                    'search' => $search,
                ])->render(),
                'meta' => $blogs->total() > 0
                    ? __('lang.Blogs showing results', ['count' => $blogs->count(), 'total' => $blogs->total()])
                    : '',
            ]);
        }

        return view('site.blogs', [
            'blogs' => $blogs,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'selectedCategorySlug' => $selectedCategorySlug,
            'locale' => $locale,
            'search' => $search,
            'sort' => $sort,
            'totalPublishedCount' => $totalPublishedCount,
            'likedBlogIds' => $likedBlogIds,
        ]);
    }

    private function buildBlogQuery(Request $request, ?int $categoryId = null)
    {
        $query = Blog::query()
            ->where('status', 'published')
            ->with([
                'creater',
                'category',
                'comments' => fn ($commentQuery) => $commentQuery->latest(),
            ])
            ->withCount(['likes', 'comments']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $search = trim((string) $request->input('q', ''));
        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        switch ((string) $request->input('sort', 'newest')) {
            case 'liked':
                $query->orderByDesc('likes_count')->orderByDesc('created_at');
                break;
            case 'commented':
                $query->orderByDesc('comments_count')->orderByDesc('created_at');
                break;
            default:
                $query->latest();
                break;
        }

        return $query;
    }
}
