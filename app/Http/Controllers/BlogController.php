<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::query()
              ->with('business')
              ->when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            })
            ->when($request->status!=''||$request->status,function($query) use ($request){
           $query->where('status',$request->status);
            })
            ->when($request->category,function($query) use ($request){
                $query->whereIn('category_id',$request->category);
            })
            ->when($request->business,function($query) use ($request){
                $query->whereIn('business_id',$request->business);
            })
            ->when($request->keyword,function($query) use ($request){
                $query->where(function($q) use ( $request){
                $q->where('title','LIKE',"%".$request->keyword. "%")
                ->orwhere('long_description','LIKE',"%".$request->keyword. "%");
                });
            })
            ->when($request->dates, function($query) use ($request) {
                $dates = explode(' - ', $request->dates);
                if (count($dates) === 2) {
                    try {
                        $start = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                        $end = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();

                        $query->whereBetween('created_at', [$start, $end]);
                    } catch (\Exception $e) {
                        // Optionally log the error or ignore invalid dates
                    }
                }
            })
        ->orderBy('id', 'desc')->paginate(20);

        $categories=Category::when(!Auth::user()->can('do:anything'),function($query){
            $query->whereIn('id',Auth::user()->business->category_ids??[]);
        })->get();
        $businesses=Business::all();
        // dd($request->all());
        return view('blog.index', compact('blogs','categories','businesses'));
    }

    public function create()
    {
        $categories=Category::when(!Auth::user()->can('do:anything'),function($query){
        $query->whereIn('id',Auth::user()->business->category_ids??[]);
    })->get();
    $businesses=Business::all();
        return view('blog.create',compact('categories','businesses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);

        $blog = new Blog;

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? null;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? null;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->category_id = $request->category;
        $blog->status = $request->status??$blog->status;
        $blog->thumbnail = $thumbnail;
        $blog->business_id = $request->business_id??Auth::user()->business_id;
        $blog->cover = $cover;
        $blog->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  Added',

        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Blog $blog)
    {
        if(!Auth::user()->can('can:do-anything') && $blog->business_id!=Auth::user()->business_id){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];
            return redirect()->route('blogs.index')->with($notification);
        }
        $categories=Category::when(!Auth::user()->can('do:anything'),function($query){
        $query->whereIn('id',Auth::user()->business->category_ids??[]);
        })->get();
        $businesses=Business::all();
        return view('blog.edit', compact('blog','businesses','categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);
        if(!Auth::user()->can('can:do-anything') && $blog->business_id!=Auth::user()->business_id){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];

            return redirect()->route('blogs.index')->with($notification);
        }
        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $blog->thumbnail;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? $blog->thumbnail;

        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->thumbnail = $thumbnail;
        $blog->status = $request->status??$blog->status;
        $blog->category_id = $request->category;
        $blog->business_id = $request->business_id??Auth::user()->business_id;
        $blog->cover = $cover;

        $blog->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  updated',

        ];

        return redirect()->route('blogs.index')->with($notification);
    }

    public function show(Blog $blog) {}

    public function destroy(Blog $blog)
    {
        if(!Auth::user()->can('do:anything')){
            if($blog->business_id!=Auth::user()->business_id){
                return redirect()->back()->with('error','You are not allowed to delete this blog');
                }

        }

        $blog->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  Deleted',
        ];

        return redirect()->route('blogs.index')->with($notification);
    }
}
