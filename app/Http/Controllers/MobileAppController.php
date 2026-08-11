<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Business;
use App\Models\Category;
use App\Models\Page;
use App\Services\NepaliTransliterator;
use Illuminate\Http\Request;

/**
 * Mobile web app — a browser rendering of the Nagarpalika Flutter application.
 * Reads the same data the /api endpoints expose, straight through Eloquent.
 *
 * Palikas are stored in the legacy "businesses" table; there is no longer a
 * special row for the municipality — every published record is a palika.
 */
class MobileAppController extends Controller
{
    // ---------------------------------------------------------------- home

    public function home()
    {
        return view('mobile.home', [
            'banners' => $this->banners(1, 1),
            'breaking' => $this->breakingBlogs(),
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

    public function categories($id)
    {
        $palika = Business::where('status', 1)->findOrFail($id);

        $categories = $palika->categories()
            ->where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('pivot_position')
            ->get();

        return view('mobile.categories', [
            'palika' => $palika,
            'categories' => $categories,
        ]);
    }

    /**
     * Tapping a category opens its subcategories when it has any, and drops
     * straight to the post list when it does not.
     */
    public function categoryNews(Request $request, $id, $categoryId)
    {
        $palika = Business::where('status', 1)->findOrFail($id);
        $category = Category::where('status', 1)->parents()->findOrFail($categoryId);

        $subcategories = $category->children()->where('status', 1)->get();

        if ($subcategories->isNotEmpty()) {
            return view('mobile.subcategories', [
                'palika' => $palika,
                'category' => $category,
                'subcategories' => $subcategories,
            ]);
        }

        $blogs = $this->categoryBlogQuery($palika->id, $category->id)->paginate(25);

        return $this->newsResponse($request, $blogs, [
            'palika' => $palika,
            'category' => $category,
            'backRoute' => route('m.categories', $palika->id),
            'title' => $category->name,
            'listUrl' => route('m.category.news', [$palika->id, $category->id]),
        ]);
    }

    public function subcategoryNews(Request $request, $id, $categoryId, $subcategoryId)
    {
        $palika = Business::where('status', 1)->findOrFail($id);
        $category = Category::where('status', 1)->parents()->findOrFail($categoryId);

        $subcategory = Category::where('status', 1)
            ->where('parent_id', $category->id)
            ->findOrFail($subcategoryId);

        $blogs = $this->categoryBlogQuery($palika->id, $category->id, $subcategory->id)->paginate(25);

        return $this->newsResponse($request, $blogs, [
            'palika' => $palika,
            'category' => $subcategory,
            'backRoute' => route('m.category.news', [$palika->id, $category->id]),
            'title' => $subcategory->name,
            'listUrl' => route('m.subcategory.news', [$palika->id, $category->id, $subcategory->id]),
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

    protected function categoryBlogQuery($palikaId, $categoryId, $subcategoryId = null)
    {
        return Blog::latest()
            ->where('status', 1)
            ->when($palikaId, fn ($q) => $q->where('business_id', $palikaId))
            ->where('category_id', $categoryId)
            ->when($subcategoryId, fn ($q) => $q->where('subcategory_id', $subcategoryId))
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
