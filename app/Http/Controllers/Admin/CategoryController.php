<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can('category:view')){
            abort(403);
        }
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        if(!Auth::user()->can('category:create')){
            abort(403);
        }
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('category:create')){
            abort(403);
        }
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
        ]);

        $category = new Category;
        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? null;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $thumbnail;
        $category->save();
         Cache::forget('categories');
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category  Added',
        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Category $category)
    {
        if(!Auth::user()->can('category:edit')){
            abort(403);
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if(!Auth::user()->can('category:edit')){
            abort(403);
        }
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? $category->thumbnail;

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $thumbnail;
        $category->status = $request->status;
        $category->save();
        Cache::forget('categories');

        $notification = [
            'alert-type' => 'success',
            'message' => 'Category  updated',

        ];

        return redirect()->route('admin.categories.index')->with($notification);
    }

    public function show(Category $category) {}

    public function destroy(Category $category) {}
}
