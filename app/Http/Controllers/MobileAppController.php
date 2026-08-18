<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Business;
use App\Models\Category;
use App\Models\Cms;
use App\Models\Page;
use App\Services\NepaliTransliterator;
use Illuminate\Http\Request;

/**
 * Mobile web app — a browser rendering of the Nagarpalika Flutter application.
 * Reads the same data the /api endpoints expose, straight through Eloquent.
 *
 * Palikas are stored in the legacy "businesses" table; there is no longer a
 * special row for the municipality — every published record is a palika.
 *
 * The menu is no longer partitioned per palika: home carries the category grid
 * itself, and a category is browsed by its own id however deep it sits.
 */
class MobileAppController extends Controller
{
    // ---------------------------------------------------------------- home

    public function home()
    {
        return view('mobile.home', [
            'banners' => $this->banners(1, 1),
            'breaking' => $this->breakingBlogs(),
            'categories' => $this->menuCategories(),
            'locationText' => optional(Cms::settings())->location_text,
            'blogs' => Blog::latest()
                ->where('status', 1)
                ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
                ->take(10)
                ->get(),
            'noticeCount' => $this->noticeCount(),
        ]);
    }

    public function notifications()
    {
        return view('mobile.notifications', [
            'blogs' => $this->todaysBlogs(),
            'noticeCount' => $this->noticeCount(),
        ]);
    }

    // ------------------------------------------------------------- palikas

    /** The Palika grid. */
    public function palikas()
    {
        return view('mobile.palikas', [
            'palikas' => $this->palikaList(),
        ]);
    }

    public function palika($id)
    {
        $palika = Business::where('status', 1)->findOrFail($id);

        return view('mobile.palika', [
            'palika' => $palika,
            'bannersOne' => $this->palikaBanners($palika->id, 1),
            'bannersTwo' => $this->palikaBanners($palika->id, 2),
            'blogs' => $this->blogsByPalika($palika->id)->take(3),
            'blogsHeading' => 'सूचना तथा जनकारी',
        ]);
    }

    // ---------------------------------------------------------- categories

    /** The whole top-level menu — the same grid home shows, on its own screen. */
    public function categories()
    {
        return view('mobile.categories', [
            'categories' => $this->menuCategories(),
        ]);
    }

    /**
     * One screen for every level of the menu: a category with children opens
     * as a grid of them, and one without drops straight to its post list. The
     * id alone says where we are, so the same action serves all three levels.
     */
    public function category(Request $request, $categoryId)
    {
        $category = Category::where('status', 1)->findOrFail($categoryId);

        $children = $category->children()->where('status', 1)->get();

        if ($children->isNotEmpty()) {
            return view('mobile.subcategories', [
                'category' => $category,
                'subcategories' => $children,
                'backRoute' => $this->categoryBackRoute($category),
            ]);
        }

        $blogs = $this->categoryBlogQuery($category->id)->paginate(25);

        return $this->newsResponse($request, $blogs, [
            'category' => $category,
            'backRoute' => $this->categoryBackRoute($category),
            'title' => $category->name,
            'listUrl' => route('m.category', $category->id),
        ]);
    }

    // -------------------------------------------------------------- search

    /**
     * Searches every published post. Latin terms are also matched against
     * their Devanagari spelling, so "sifaris" finds सिफारिस.
     */
    public function search(Request $request, NepaliTransliterator $transliterator)
    {
        $term = trim((string) $request->query('q', ''));
        $blogs = null;
        $nepaliPattern = null;

        if (mb_strlen($term) >= 2) {
            if (! $transliterator->isDevanagari($term)) {
                $nepaliPattern = $transliterator->toRegex($term);
            }

            $blogs = Blog::latest()
                ->where('status', 1)
                ->where(function ($query) use ($term, $nepaliPattern) {
                    $like = '%'.$term.'%';

                    $query->where('title', 'LIKE', $like)
                        ->orWhere('short_description', 'LIKE', $like)
                        ->orWhere('long_description', 'LIKE', $like);

                    // REGEXP is a scan, so keep it off the long HTML body.
                    if ($nepaliPattern) {
                        $query->orWhere('title', 'REGEXP', $nepaliPattern)
                            ->orWhere('short_description', 'REGEXP', $nepaliPattern);
                    }
                })
                ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
                ->paginate(25)
                ->withQueryString();

            if ($request->wantsJson()) {
                return response()->json([
                    'html' => view('mobile.partials.blog-rows', ['blogs' => $blogs])->render(),
                    'hasMore' => $blogs->hasMorePages(),
                ]);
            }
        }

        return view('mobile.search', [
            'term' => $term,
            'blogs' => $blogs,
            'matchedNepali' => (bool) $nepaliPattern,
        ]);
    }

    // -------------------------------------------------------------- detail

    public function blog($id)
    {
        $blog = Blog::where('id', $id)->where('status', 1)->firstOrFail();

        return view('mobile.blog', [
            'blog' => $blog,
            'body' => $this->prepareHtml($blog->long_description),
        ]);
    }

    // ------------------------------------------------------- hello / pages

    public function hello()
    {
        return view('mobile.hello', [
            'palikas' => $this->palikaList(),
            'noticeCount' => $this->noticeCount(),
        ]);
    }

    public function settings()
    {
        return view('mobile.settings');
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('mobile.page', [
            'page' => $page,
            'body' => $this->prepareHtml($page->description),
        ]);
    }

    // ------------------------------------------------------------ internals

    /** Every published palika — matches GET /api/wards. */
    protected function palikaList()
    {
        return Business::orderBy('business_order', 'asc')
            ->where('status', 1)
            ->get();
    }

    /** The published top-level menu, in the order the admin arranged it. */
    protected function menuCategories()
    {
        return Category::where('status', 1)->parents()->ordered()->get();
    }

    /** Up one level, or home when we are already at the top of the menu. */
    protected function categoryBackRoute(Category $category)
    {
        return $category->parent_id
            ? route('m.category', $category->parent_id)
            : route('m.home');
    }

    /** Infinite scroll asks for page 2+ as JSON, the way the Flutter list does. */
    protected function newsResponse(Request $request, $blogs, array $data)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'html' => view('mobile.partials.blog-rows', ['blogs' => $blogs])->render(),
                'hasMore' => $blogs->hasMorePages(),
            ]);
        }

        return view('mobile.category-news', $data + ['blogs' => $blogs]);
    }

    protected function banners($type, $isHomepage = null)
    {
        return Banner::whereNull('business_id')
            ->where('status', 1)
            ->select('id', 'thumbnail', 'title')
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($isHomepage, fn ($q) => $q->where('is_homepage_banner', $isHomepage))
            ->get();
    }

    protected function palikaBanners($palikaId, $type)
    {
        return Banner::where('business_id', $palikaId)
            ->where('status', 1)
            ->select('id', 'thumbnail', 'title')
            ->where('type', $type)
            ->get();
    }

    protected function blogsByPalika($palikaId)
    {
        return Blog::latest()
            ->where('status', 1)
            ->where('business_id', $palikaId)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
            ->take(25)
            ->get();
    }

    /** Every post filed at or under a category, newest first. */
    protected function categoryBlogQuery($categoryId)
    {
        return Blog::latest()
            ->where('status', 1)
            ->inCategory($categoryId)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description');
    }

    /** Posts ticked "Breaking news" in the admin — the home carousel. */
    protected function breakingBlogs()
    {
        return Blog::latest()
            ->where('status', 1)
            ->where('is_breaking', 1)
            ->select('id', 'title', 'thumbnail', 'slug')
            ->take(10)
            ->get();
    }

    /** Today's posts — the badge on the notifications tab counts these. */
    protected function todaysBlogs()
    {
        return Blog::whereDate('created_at', today())->latest()->get();
    }

    protected function noticeCount()
    {
        return Blog::whereDate('created_at', today())->count();
    }

    /**
     * Absolutise relative <img>/<a> targets so editor content pulled from the
     * admin panel resolves the same way it did inside the app's HTML widget.
     */
    protected function prepareHtml($html)
    {
        if (blank($html)) {
            return '';
        }

        $base = rtrim(config('app.url'), '/');

        return preg_replace_callback(
            '/(src|href)=(["\'])(?!https?:|mailto:|tel:|sms:|#|data:)([^"\']*)\2/i',
            function ($m) use ($base) {
                $path = $m[3];

                if (str_starts_with($path, '//')) {
                    return $m[1].'="https:'.$path.'"';
                }

                return $m[1].'="'.$base.'/'.ltrim($path, '/').'"';
            },
            $html
        );
    }
}
