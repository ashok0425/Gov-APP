<?php

namespace App\Http\Controllers\API;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Cms;
use App\Models\Page;
use App\Models\Website;

class HomeController extends Controller
{
    public function wards(Request $request)
    {
        if ($request->palika) {
            $business = Business::orderBy('business_order', 'asc')->where('status', 1)->where('id', 22)->where('status', 1)->paginate(25);
        } else {
            $business = Business::orderBy('business_order', 'asc')->where('id', '!=', 22)->where('status', 1)->paginate(25);
        }

        return response()->json(
            [
                'success' => true,
                'data' => $business,
            ],
            200,
        );
    }
    public function palika()
    {
        $business = Business::orderBy('business_order', 'asc')->where('id', 22)->where('status', 1)->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $business,
            ],
            200,
        );
    }

    public function category(Request $request)
    {
       if ($request->ward_id) {
        $business = Business::find($request->ward_id);

        $categories = $business?->categories()
            ->where('status', 1)
            ->orderBy('pivot_position') // if you track order in pivot
            ->get() ?? collect([]);
    } else {
        $categories = Category::where('status', 1)->get();
    }

        return response()->json(
            [
                'success' => true,
                'data' => $categories,
            ],
            200,
        );
    }

    public function blogs($isMain = null)
    {
        $blog = Blog::latest()->where('status', 1)->select('id', 'title', 'thumbnail', 'slug', 'short_description')->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $blog,
            ],
            200,
        );
    }

    public function blogDetail($id)
    {
        $blog = Blog::where('id', $id)->where('status', 1)->firstOrFail();

         /*   $html = preg_replace('/style="[^"]*"/i', '', $blog->long_description);

    // Remove fixed width/height attributes
    $html = preg_replace('/(width|height)="[^"]*"/i', '', $html);

    // Wrap <table> in a scrollable div
    $html = preg_replace_callback('/<table.*?>.*?<\/table>/is', function ($matches) {
        return '<div style="overflow-x:auto;">' . $matches[0] . '</div>';
    }, $html);

    $blog->long_description=$html;
    */


        return response()->json(
            [
                'success' => true,
                'data' => $blog,
            ],
            200,
        );
    }

    public function blogByWard(Request $request, $id)
    {
        $blog = Blog::latest()
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->where('status', 1)
            ->where('business_id', $id)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
            ->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $blog,
            ],
            200,
        );
    }

    public function blogByCategory(Request $request, $id)
    {
        $blog = Blog::latest()
            ->where('status', 1)
            ->when($request->ward_id, function ($query) use ($request) {
                $query->where('business_id', $request->ward_id);
            })
            ->where('category_id', $id)
            ->select('id', 'title', 'thumbnail', 'slug', 'short_description')
            ->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $blog,
            ],
            200,
        );
    }

    public function banner($type, $is_homepage_banner = null)
    {
        $banners = Banner::where('business_id', null)
            ->where('status', 1)
            ->select('id', 'thumbnail', 'title')
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($is_homepage_banner, function ($query) use ($is_homepage_banner) {
                $query->where('is_homepage_banner', $is_homepage_banner);
            })
            ->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $banners,
            ],
            200,
        );
    }

    public function bannerbyWard($id, $type)
    {
        $banners = Banner::where('business_id', $id)
            ->where('status', 1)
            ->select('id', 'thumbnail', 'title')
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->paginate(25);
        return response()->json(
            [
                'success' => true,
                'data' => $banners,
            ],
            200,
        );
    }

    public function contact()
    {
        $data = Cms::first();
        return response()->json(
            [
                'success' => true,
                'data' => $data,
            ],
            200,
        );
    }

    public function page(Request $request)
    {
        $data = Page::where('slug', $request->page)->first();
        return response()->json(
            [
                'success' => true,
                'data' => $data,
            ],
            200,
        );
    }

      public function notification(Request $request)
    {
        $blogs = Blog::whereDate('created_at', today())->latest()->get();
        return response()->json(
            [
                'success' => true,
                'data' => $blogs,
            ],
            200,
        );
    }
}
