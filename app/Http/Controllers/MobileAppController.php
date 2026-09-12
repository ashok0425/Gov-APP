<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Business;
use App\Models\Category;
use App\Models\Cms;
use App\Models\Notice;
use App\Models\Organization;
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
        // Home is a teaser: the four newest posts, title only, marked with
        // the icon of the organization each was filed under. The full list
        // lives behind the categories and search.
        $blogs = Blog::latest()
            ->where('status', 1)
            ->select('id', 'title', 'category_id', 'slug')
            ->with(['category:id,organization_id', 'category.organization:id,thumbnail'])
            ->take(4)
            ->get();

        return view('mobile.home', [
            'banners' => $this->banners(1, 1),
            'breaking' => $this->breakingBlogs(),
            'organizations' => $this->menuOrganizations(),
            'blogs' => $blogs,
            'locationText' => optional(Cms::settings())->location_text,
        ]);
    }

    public function notifications()
    {
        // The bell shows exactly what its badge counts: the posts published
        // in the last 24 hours. Older ones live on in their categories.
        return view('mobile.notifications', [
            'blogs' => Blog::latest()
                ->where('status', 1)
                ->where('created_at', '>=', now()->subDay())
                ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
                ->take(50)
                ->get(),
        ]);
    }

    public function notice($id)
    {
        $notice = Notice::published()->findOrFail($id);

        return view('mobile.notice', [
            'notice' => $notice,
            'body' => $this->prepareHtml($notice->description),
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

    /** The whole top of the menu — the same organization grid home shows. */
    public function categories()
    {
        return view('mobile.categories', [
            'organizations' => $this->menuOrganizations(),
        ]);
    }

    /** One organization's own menu: the main categories filed under it. */
    public function organization($id)
    {
        $organization = Organization::where('status', 1)->findOrFail($id);

        return view('mobile.organization', [
            'organization' => $organization,
            'categories' => $organization->mainCategories()->where('status', 1)->get(),
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

        // One screen for every level: whatever sits under this category, and
        // then the posts filed anywhere beneath it. A leaf simply has no grid
        // to draw, and a category nobody has posted under has no list.
        $children = $category->children()->where('status', 1)->ordered()->get();

        // Under a parent the posts are only a taste of what the children
        // hold, so the roll-up stops at the three newest. A leaf is the
        // actual list, and keeps its full paginated infinite scroll.
        if ($children->isNotEmpty()) {
            return view('mobile.category-news', [
                'category' => $category,
                'subcategories' => $children,
                'title' => $category->name,
                'listUrl' => route('m.category', $category->id),
                'blogs' => $this->categoryBlogQuery($category->id)->limit(3)->get(),
            ]);
        }

        $blogs = $this->categoryBlogQuery($category->id)->paginate(25);

        return $this->newsResponse($request, $blogs, [
            'category' => $category,
            'subcategories' => $children,
            'title' => $category->name,
            'listUrl' => route('m.category', $category->id),
        ]);
    }

    // -------------------------------------------------------------- search

    /**
     * Searches everything the app shows: organizations, every level of the
     * menu, and every published post. Latin terms are also matched against
     * their Devanagari spelling, so "sifaris" finds सिफारिस.
     */
    public function search(Request $request, NepaliTransliterator $transliterator)
    {
        $term = trim((string) $request->query('q', ''));
        $blogs = null;
        $organizations = collect();
        $categories = collect();
        $nepaliPattern = null;

        if (mb_strlen($term) >= 2) {
            if (! $transliterator->isDevanagari($term)) {
                $nepaliPattern = $transliterator->toRegex($term);
            }

            $nameMatches = function ($query) use ($term, $nepaliPattern) {
                $query->where('name', 'LIKE', '%'.$term.'%');

                if ($nepaliPattern) {
                    $query->orWhere('name', 'REGEXP', $nepaliPattern);
                }
            };

            // The menu matches come whole, not paged — they are a short list
            // on top of the news, which is what scrolls.
            if (! $request->wantsJson()) {
                $organizations = Organization::where('status', 1)
                    ->where($nameMatches)
                    ->ordered()
                    ->limit(20)
                    ->get();

                $categories = Category::where('status', 1)
                    ->where($nameMatches)
                    ->with('parent.parent.parent')
                    ->ordered()
                    ->limit(30)
                    ->get();
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
            'organizations' => $organizations,
            'categories' => $categories,
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
    protected function menuOrganizations()
    {
        return Organization::where('status', 1)->ordered()->get();
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

    /** Posts ticked "Breaking news" in the admin — the सूचना ticker line. */
    protected function breakingBlogs()
    {
        return Blog::latest()
            ->where('status', 1)
            ->where('is_breaking', 1)
            ->select('id', 'title', 'thumbnail', 'slug')
            ->take(10)
            ->get();
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
