<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();

        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);

        $blog = new Blog;

        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? null;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->thumbnail = $thumbnail;

        $blog->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  Added',

        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',

        ]);
        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? $blog->thumbnail;

        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->thumbnail = $thumbnail;
        $blog->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  updated',

        ];

        return redirect()->route('admin.blogs.index')->with($notification);
    }

    public function show(Blog $blog) {}

    public function destroy(Blog $blog)
    {
        $blog->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Blog  Deleted',
        ];

        return redirect()->route('admin.blogs.index')->with($notification);
    }
}
