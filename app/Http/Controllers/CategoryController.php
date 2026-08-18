<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * The menu tree, all three levels of it. One controller serves them all —
 * a row is a category, a subcategory or a child category purely by where its
 * parent sits, so the only thing that changes per level is which list you
 * land back on.
 */
class CategoryController extends Controller
{
    public function index()
    {
        if (! Auth::user()->can('category:view')) {
            abort(403);
        }

        // Paginate the top level only, so a category never gets separated
        // from its subcategories by a page break.
        $categories = Category::parents()->with('children')->paginate(15);

        return view('category.index', compact('categories'));
    }

    /** Level 2: everything whose parent is a top-level category. */
    public function subcategories(Request $request)
    {
        if (! Auth::user()->can('category:view')) {
            abort(403);
        }

        $subcategories = Category::subcategories()
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

    /** Level 3: everything whose grandparent is a top-level category. */
    public function childCategories(Request $request)
    {
        if (! Auth::user()->can('category:view')) {
            abort(403);
        }

        $childCategories = Category::childCategories()
            ->with('parent.parent')
            ->when($request->parent, function ($query) use ($request) {
                $query->where('parent_id', $request->parent);
            })
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // The filter lists subcategories — those are what a child hangs off.
        $parents = Category::subcategories()->with('parent')->orderBy('name')->get();

        return view('category.child-categories', compact('childCategories', 'parents'));
    }

    public function create(Request $request)
    {
        if (! Auth::user()->can('category:create')) {
            abort(403);
        }

        $parents = $this->parentOptions();
        // "Add Subcategory" / "Add Child Category" land here with the parent
        // already chosen.
        $parentId = $request->query('parent');

        return view('category.create', compact('parents', 'parentId'));
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can('category:create')) {
            abort(403);
        }

        $request->validate($this->rules($request));

        $category = new Category;
        $category->parent_id = $request->parent_id ?: null;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $request->file('thumbnail')?->store('uploads/category', 'public');
        $category->status = $request->status ?? 1;
        $this->fillContact($category, $request);
        $category->save();

        return redirect()
            ->route($this->listRouteFor($category))
            ->with([
                'alert-type' => 'success',
                'message' => $category->levelName().' Added',
            ]);
    }

    public function edit(Category $category)
    {
        if (! Auth::user()->can('category:edit')) {
            abort(403);
        }

        $parents = $this->parentOptions($category);

        return view('category.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        if (! Auth::user()->can('category:edit')) {
            abort(403);
        }

        $request->validate($this->rules($request, $category));

        $category->parent_id = $request->parent_id ?: null;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;

        if ($thumbnail = $request->file('thumbnail')?->store('uploads/category', 'public')) {
            $category->thumbnail = $thumbnail;
        }

        $this->fillContact($category, $request);
        $category->save();

        return redirect()
            ->route($this->listRouteFor($category))
            ->with([
                'alert-type' => 'success',
                'message' => $category->levelName().' updated',
            ]);
    }

    public function show(Category $category) {}

    public function destroy(Category $category)
    {
        if (! Auth::user()->can('category:delete')) {
            abort(403);
        }

        // Everything underneath goes too — a subcategory has nowhere to live
        // once its parent is gone, and neither has its own children.
        Category::whereIn('id', $category->descendantIds())->delete();
        $category->delete();

        return redirect()->back()->with([
            'alert-type' => 'success',
            'message' => 'Category Deleted',
        ]);
    }

    /**
     * The categories this one may be filed under: anything that still has room
     * beneath it for however many levels this record spans, minus itself and
     * its own descendants — a category cannot be moved inside itself.
     */
    protected function parentOptions(?Category $category = null)
    {
        $height = $category ? $category->height() : 1;
        $barred = $category
            ? $category->descendantIds()->push($category->id)
            : collect();

        return Category::with('parent.parent')
            ->get()
            ->reject(fn ($option) => $barred->contains($option->id))
            ->filter(fn ($option) => $option->level() + $height <= Category::MAX_DEPTH)
            ->sortBy(fn ($option) => $option->pathName())
            ->values();
    }

    /**
     * A name is unique among its siblings rather than everywhere: two wards may
     * each hold a "वडा सूचना". The parent has to be real, and it has to leave
     * room for this record underneath it.
     */
    protected function rules(Request $request, ?Category $category = null)
    {
        $parentId = $request->parent_id ?: null;
        $allowed = $this->parentOptions($category)->pluck('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category?->id)
                    ->where(fn ($q) => $q->where('parent_id', $parentId)),
            ],
            'parent_id' => ['nullable', Rule::in($allowed->all())],
            'thumbnail' => ['nullable', 'image'],
            'email' => ['nullable', 'email', 'max:255'],
            'google_map_link' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'messanger' => ['nullable', 'url', 'max:255'],
        ];
    }

    /** The contact card the app floats behind the phone button. */
    protected function fillContact(Category $category, Request $request)
    {
        $category->show_contact = $request->boolean('show_contact');

        foreach (['owner_name', 'address', 'google_map_link', 'email', 'phone', 'whatsapp', 'messanger', 'facebook', 'other'] as $field) {
            $category->{$field} = $request->input($field) ?: null;
        }
    }

    /** Land back on the list this record actually belongs to. */
    protected function listRouteFor(Category $category)
    {
        return [
            1 => 'categories.index',
            2 => 'subcategories.index',
            3 => 'childcategories.index',
        ][$category->level()] ?? 'categories.index';
    }
}
