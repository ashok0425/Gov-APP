<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }

        )->orderBy('id', 'desc')->get();

        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create');
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
        $blog->business_id = Auth::user()->business_id;
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
        return view('blog.edit', compact('blog'));
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
