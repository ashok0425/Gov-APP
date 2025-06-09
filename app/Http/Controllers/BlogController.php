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
        $posts = Blog::query()
              ->with('business')
              ->accessibleBy(Auth::user())
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

        $categories=Category::accessibleBy(Auth::user())->get();
        $businesses=Business::all();
        // dd($request->all());
        return view('blog.index', compact('posts','categories','businesses'));
    }

    public function create()
    {
        $categories=Category::accessibleBy(Auth::user())->get();
    $businesses=Business::all();
        return view('blog.create',compact('categories','businesses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);

        $post = new Blog;
        $category=Category::find($request->category);

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $category->thumbnail;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? null;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->short_description = $request->short_description;
        $post->long_description = $request->long_description;
        $post->category_id = $request->category;
        $post->status = $request->status??$post->status;
        $post->thumbnail = $thumbnail;
        $post->business_id = $request->business_id??Auth::user()->business_id;
        $post->user_id =Auth::user()->id;
        $post->cover = $cover;
        $post->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Post  Added',

        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Blog $post)
    {
        if(!Blog::accessibleby(Auth::user())->first()){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];
            return redirect()->route('blogs.index')->with($notification);
        }
        $categories=Category::accessibleBy(Auth::user())->get();
        $businesses=Business::all();
        return view('blog.edit', compact('post','businesses','categories'));
    }

    public function update(Request $request, Blog $post)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);
        // if(!Auth::user()->can('can:do-anything') && $post->business_id!=Auth::user()->business_id){
        //     $notification = [
        //         'alert-type' => 'error',
        //         'message' => 'unauthorized Request',

        //     ];

        //     return redirect()->route('blogs.index')->with($notification);
        // }
        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $post->thumbnail;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? $post->thumbnail;

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->short_description = $request->short_description;
        $post->long_description = $request->long_description;
        $post->thumbnail = $thumbnail;
        $post->status = $request->status??$post->status;
        $post->category_id = $request->category;
        $post->business_id = $request->business_id??Auth::user()->business_id;
        $post->cover = $cover;

        $post->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Post  updated',

        ];

        return redirect()->route('blogs.index')->with($notification);
    }

    public function show(Blog $post) {
        if(!Auth::user()->can('do:anything')){
            if($post->business_id!=Auth::user()->business_id){
                return redirect()->back()->with('error','You are not allowed to delete this blog');
                }

        }

        return view('blog.show', compact('post'));
    }

    public function destroy(Blog $post)
    {
        if(!Auth::user()->can('do:anything')){
            if($post->business_id!=Auth::user()->business_id){
                return redirect()->back()->with('error','You are not allowed to delete this blog');
                }
        }

        $post->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Post  Deleted',
        ];

        return redirect()->route('blogs.index')->with($notification);
    }
}
