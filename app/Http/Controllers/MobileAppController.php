<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Business;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 * Mobile web app — a browser rendering of the Nagarpalika Flutter application.
 * Reads the same data the /api endpoints expose, straight through Eloquent.
 */
class MobileAppController extends Controller
{
    /** The Palika is stored as a business row like the wards are. */
    public const PALIKA_ID = 22;

    // ---------------------------------------------------------------- home

    public function home()
    {
        return view('mobile.home', [
            'banners' => $this->banners(1, 1),
            'wards' => $this->wardList(),
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

    // --------------------------------------------------------------- wards

    /** The "My Ward" grid. */
    public function wards()
    {
        return view('mobile.wards', [
            'wards' => $this->wardList(),
        ]);
    }

    public function ward($id)
    {
        $ward = Business::where('status', 1)->findOrFail($id);

        return view('mobile.ward', [
            'ward' => $ward,
            'bannersOne' => $this->wardBanners($ward->id, 1),
            'bannersTwo' => $this->wardBanners($ward->id, 2),
            'blogs' => $this->blogsByWard($ward->id)->take(3),
            'showStaffSlider' => true,
            'blogsHeading' => 'सूचना तथा जनकारी',
        ]);
    }

    /** Palika screen — the same layout as a ward, minus the staff slider. */
    public function palika()
    {
        $ward = Business::where('status', 1)->find(self::PALIKA_ID);

        // The app shows "No Data Available" rather than failing when the
        // Palika row is missing, so mirror that instead of 404ing.
        if (! $ward) {
            return view('mobile.empty', [
                'title' => 'Palika',
                'message' => 'No Data Available',
            ]);
        }

        return view('mobile.ward', [
            'ward' => $ward,
            'bannersOne' => $this->wardBanners($ward->id, 1),
            'bannersTwo' => collect(),
            'blogs' => $this->blogsByWard($ward->id),
            'showStaffSlider' => false,
            'blogsHeading' => 'सूचना तथा समाचार',
        ]);
    }

    // ---------------------------------------------------------- categories

    public function categories($id)
    {
        $ward = Business::where('status', 1)->findOrFail($id);

        $categories = $ward->categories()
            ->where('status', 1)
            ->orderBy('pivot_position')
            ->get();

        return view('mobile.categories', [
            'ward' => $ward,
            'categories' => $categories,
        ]);
    }

    public function categoryNews(Request $request, $id, $categoryId)
    {
        $ward = Business::where('status', 1)->findOrFail($id);
        $category = Category::where('status', 1)->findOrFail($categoryId);

        $blogs = $this->categoryBlogQuery($category->id, $ward->id)->paginate(25);

        // Infinite scroll asks for page 2+ as JSON, the way the Flutter list does.
        if ($request->wantsJson()) {
            return response()->json([
                'html' => view('mobile.partials.blog-rows', ['blogs' => $blogs])->render(),
                'hasMore' => $blogs->hasMorePages(),
            ]);
        }

        return view('mobile.category-news', [
            'ward' => $ward,
            'category' => $category,
            'blogs' => $blogs,
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
            'palika' => Business::where('status', 1)->find(self::PALIKA_ID),
            'wards' => $this->wardList(),
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

    /** Wards, excluding the Palika row — matches GET /api/wards. */
    protected function wardList()
    {
        return Business::orderBy('business_order', 'asc')
            ->where('id', '!=', self::PALIKA_ID)
            ->where('status', 1)
            ->get();
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

    protected function wardBanners($wardId, $type)
    {
        return Banner::where('business_id', $wardId)
            ->where('status', 1)
            ->select('id', 'thumbnail', 'title')
            ->where('type', $type)
            ->get();
    }

    protected function blogsByWard($wardId)
    {
        return Blog::latest()
            ->where('status', 1)
            ->where('business_id', $wardId)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
            ->take(25)
            ->get();
    }

    protected function categoryBlogQuery($categoryId, $wardId)
    {
        return Blog::latest()
            ->where('status', 1)
            ->when($wardId, fn ($q) => $q->where('business_id', $wardId))
            ->where('category_id', $categoryId)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description');
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
