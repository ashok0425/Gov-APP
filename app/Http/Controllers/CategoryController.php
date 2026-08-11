<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can('category:view')){
            abort(403);
        }
        // Paginate the top level only, so a category never gets separated
        // from its subcategories by a page break.
        $categories = Category::parents()->with('children')->paginate(15);

        return view('category.index', compact('categories'));
    }

    /** Every subcategory across all parents, optionally filtered to one. */
    public function subcategories(Request $request)
    {
        if(!Auth::user()->can('category:view')){
            abort(403);
        }

        $subcategories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->when($request->parent, function ($query) use ($request) {
                $query->where('parent_id', $request->parent);
            })
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $parents = Category::parents()->orderBy('name')->get();

        return view('category.subcategories', compact('subcategories', 'parents'));
    }

    public function create(Request $request)
    {
        if(!Auth::user()->can('category:create')){
            abort(403);
        }

        $parents = Category::parents()->orderBy('name')->get();
        // "Add Subcategory" on a row lands here with the parent preselected.
        $parentId = $request->query('parent');

        return view('category.create', compact('parents', 'parentId'));
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('category:create')){
            abort(403);
        }
        $request->validate([
            'name' => [
                'required',
                'max:255',
                // Two parents may each have a "Notice" subcategory.
                Rule::unique('categories', 'name')->where(fn ($q) => $q->where('parent_id', $request->parent_id ?: null)),
            ],
            'parent_id' => ['nullable', Rule::exists('categories', 'id')->whereNull('parent_id')],
        ]);

        $category = new Category;
        $thumbnail = $request->file('thumbnail')?->store('uploads/category', 'public') ?? null;
        $category->parent_id = $request->parent_id ?: null;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $thumbnail;
        $category->save();
        $notification = [
            'alert-type' => 'success',
            'message' => $category->parent_id ? 'Subcategory  Added' : 'Category  Added',
        ];

        // Land back on the list the new record actually belongs to.
        return redirect()
            ->route($category->parent_id ? 'subcategories.index' : 'categories.index')
            ->with($notification);
    }

    public function edit(Category $category)
    {
        if(!Auth::user()->can('category:edit')){
            abort(403);
        }

        // A category with subcategories of its own cannot be nested under
        // another one — the menu is only two levels deep.
        $parents = Category::parents()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        $canHaveParent = $category->children()->count() === 0;

        return view('category.edit', compact('category', 'parents', 'canHaveParent'));
    }

    public function update(Request $request, Category $category)
    {
        if(!Auth::user()->can('category:edit')){
            abort(403);
        }

        $parentId = $request->parent_id ?: null;

        if ($category->children()->exists()) {
            $parentId = null;
        }

        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category->id)
                    ->where(fn ($q) => $q->where('parent_id', $parentId)),
            ],
            'parent_id' => [
                'nullable',
                Rule::notIn([$category->id]),
                Rule::exists('categories', 'id')->whereNull('parent_id'),
            ],
        ]);

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $category->thumbnail;
        $category->parent_id = $parentId;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $thumbnail;
        $category->status = $request->status;
        $category->save();

        $notification = [
            'alert-type' => 'success',
            'message' => $category->parent_id ? 'Subcategory  updated' : 'Category  updated',

        ];

        return redirect()
            ->route($category->parent_id ? 'subcategories.index' : 'categories.index')
            ->with($notification);
    }

    public function show(Category $category) {}

    public function destroy(Category $category) {
        if(!Auth::user()->can('category:delete')){
            abort(403);
        }

        // Subcategories have nowhere to live once the parent is gone.
        $category->children()->delete();
        $category->delete();

        $notification = [
          'alert-type' => 'success',
          'message' => 'category   Deleted',
      ];

      return redirect()->back()->with($notification);
    }
}
