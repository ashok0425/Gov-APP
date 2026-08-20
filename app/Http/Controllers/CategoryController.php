<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ReturnsToList;
use App\Models\Category;
use App\Models\Organization;
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
    use ReturnsToList;

    public function index(Request $request)
    {
        if (! Auth::user()->can('category:view')) {
            abort(403);
        }

        $categories = Category::parents()
            ->withCount('children')
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->orderBy('position')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('category.index', compact('categories'));
    }

    /** Level 2: everything whose parent is a top-level category. */
    public function subcategories(Request $request)
    {
        return $this->levelList($request, 2);
    }

    /** Level 3: everything whose grandparent is a top-level category. */
    public function childCategories(Request $request)
    {
        return $this->levelList($request, 3);
    }

    /** Level 4, the deepest the menu goes. */
    public function grandchildCategories(Request $request)
    {
        return $this->levelList($request, 4);
    }

    /**
     * One list for every level below the top. They differ only in what they
     * hang off and what they can hold, so they share a screen and a query.
     */
    protected function levelList(Request $request, $level)
    {
        if (! Auth::user()->can('category:view')) {
            abort(403);
        }

        $rows = Category::atLevel($level)
            ->with('parent.parent.parent')
            ->withCount('children')
            ->when($request->parent, function ($query) use ($request) {
                $query->where('parent_id', $request->parent);
            })
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->orderBy('parent_id')
            ->orderBy('position')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // The filter lists whatever this level hangs off.
        $parents = Category::atLevel($level - 1)
            ->with('parent.parent')
            ->orderBy('name')
            ->get();

        return view('category.level-list', [
            'rows' => $rows,
            'parents' => $parents,
            'level' => $level,
            'childRoute' => $this->listRoute($level + 1),
        ]);
    }

    public function create(Request $request)
    {
        if (! Auth::user()->can('category:create')) {
            abort(403);
        }

        // "Add Subcategory" / "Add Child Category" land here with the parent
        // already chosen, so the cascade opens on that branch. Which button
        // was pressed decides the level, and the form only asks for the
        // levels above it — Add Category asks for nothing at all.
        $parent = Category::find($request->query('parent'));

        $level = $parent
            ? min($parent->level() + 1, Category::MAX_DEPTH)
            : max(1, min((int) $request->query('level', 1), Category::MAX_DEPTH));

        return view('category.create', [
            'categoryTree' => $this->parentTree(),
            'parentTrail' => $this->trailOf($parent),
            'level' => $level,
            'organizations' => Organization::ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can('category:create')) {
            abort(403);
        }

        $request->validate($this->rules($request));

        $category = new Category;
        $category->parent_id = $this->parentFrom($request);
        // Only a main category names its organization; the levels below
        // belong to whatever organization their root does.
        $category->organization_id = $category->parent_id ? null : $request->input('organization');
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->thumbnail = $request->file('thumbnail')?->store('uploads/category', 'public');
        $category->top_image = $request->file('top_image')?->store('uploads/category-tops', 'public');
        $category->status = $request->status ?? 1;
        $category->show_cover = $request->boolean('show_cover');
        $this->fillContact($category, $request);
        $category->save();
        $this->syncCovers($category, $request);

        return redirect()
            ->to($this->returnUrl($request, $this->listRouteFor($category)))
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

        // The record keeps its level: like the create form, editing asks only
        // for the parents above it — a subcategory shows one Category picker,
        // nothing about deeper levels.
        return view('category.edit', [
            'category' => $category,
            'categoryTree' => $this->parentTree($category),
            'parentTrail' => $this->trailOf($category->parent),
            'level' => $category->level(),
            'organizations' => Organization::ordered()->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        if (! Auth::user()->can('category:edit')) {
            abort(403);
        }

        $request->validate($this->rules($request, $category));

        $category->parent_id = $this->parentFrom($request);
        $category->organization_id = $category->parent_id ? null : $request->input('organization');
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;

        if ($thumbnail = $request->file('thumbnail')?->store('uploads/category', 'public')) {
            $category->thumbnail = $thumbnail;
        }

        if ($request->boolean('remove_top_image')) {
            \Storage::disk('public')->delete((string) $category->top_image);
            $category->top_image = null;
        }

        if ($topImage = $request->file('top_image')?->store('uploads/category-tops', 'public')) {
            $category->top_image = $topImage;
        }

        $category->show_cover = $request->boolean('show_cover');
        $this->fillContact($category, $request);
        $category->save();
        $this->syncCovers($category, $request);

        return redirect()
            ->to($this->returnUrl($request, $this->listRouteFor($category)))
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

    /** Drag-and-drop order from a list: positions follow the given ids. */
    public function reorder(Request $request)
    {
        if (! Auth::user()->can('category:edit')) {
            abort(403);
        }

        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
            'start' => ['nullable', 'integer', 'min:0'],
        ]);

        $start = (int) $request->input('start', 0);

        foreach ($request->ids as $index => $id) {
            Category::where('id', $id)->update(['position' => $start + $index]);
        }

        return response()->json(['ok' => true]);
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
        $parentId = $this->parentFrom($request);
        $allowed = $this->parentOptions($category)->pluck('id')->all();

        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category?->id)
                    ->where(fn ($q) => $q->where('parent_id', $parentId)),
            ],
            'thumbnail' => ['nullable', 'image'],
            'top_image' => ['nullable', 'image'],
            'cover_images' => ['nullable', 'array'],
            'cover_images.*' => ['image'],
            'remove_covers' => ['nullable', 'array'],
            'remove_covers.*' => ['integer'],
            'email' => ['nullable', 'email', 'max:255'],
            'google_map_link' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'messanger' => ['nullable', 'url', 'max:255'],
        ];

        // Every level of the cascade has to name a category that may hold this
        // one; anything else is a browser posting its own ideas. On the create
        // form the level is fixed, so the parents above it are mandatory.
        $level = max(1, min((int) $request->input('level', 1), Category::MAX_DEPTH));

        foreach ($this->cascadeFields() as $index => $field) {
            $rules[$field] = [$index < $level - 1 ? 'required' : 'nullable', Rule::in($allowed)];
        }

        // A main category must say whose menu it belongs to.
        $rules['organization'] = $level === 1
            ? ['required', Rule::exists('organizations', 'id')]
            : ['nullable'];

        return $rules;
    }

    /** One form field per level of the parent cascade, top first. */
    protected function cascadeFields()
    {
        return array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, Category::MAX_DEPTH - 1);
    }

    /** The parent is the deepest level the cascade has a pick for. */
    protected function parentFrom(Request $request)
    {
        foreach (array_reverse($this->cascadeFields()) as $field) {
            if (filled($request->input($field))) {
                return (int) $request->input($field);
            }
        }

        return null;
    }

    /** A category and its ancestors, top first — what the cascade opens on. */
    protected function trailOf(?Category $category)
    {
        if (! $category) {
            return [];
        }

        return $category->ancestors()->push($category)->pluck('id')->all();
    }

    /**
     * The menu as nested arrays for the cascade, holding only the categories
     * this record may be filed under — see parentOptions().
     */
    protected function parentTree(?Category $category = null)
    {
        $allowed = $this->parentOptions($category)->keyBy('id');

        $build = function ($parentId) use (&$build, $allowed) {
            return $allowed
                ->where('parent_id', $parentId)
                ->sortBy('name')
                ->map(fn ($option) => [
                    'id' => $option->id,
                    'name' => $option->name,
                    'children' => $build($option->id),
                ])
                ->values();
        };

        return $build(null);
    }

    /**
     * The cover carousel: drop the slides the editor ticked for removal,
     * their files included, then append whatever was uploaded after the
     * ones already there.
     */
    protected function syncCovers(Category $category, Request $request)
    {
        $removed = $category->covers()
            ->whereIn('id', $request->input('remove_covers', []))
            ->get();

        foreach ($removed as $cover) {
            \Storage::disk('public')->delete($cover->thumbnail);
            $cover->delete();
        }

        $position = (int) $category->covers()->max('position');

        foreach ($request->file('cover_images', []) as $image) {
            $category->covers()->create([
                'thumbnail' => $image->store('uploads/category-covers', 'public'),
                'position' => ++$position,
            ]);
        }
    }

    /**
     * The contact card the app floats behind the phone button. Only levels
     * below the top carry one — a main category is a heading, not an office —
     * so a record saved at the top has its contact cleared.
     */
    protected function fillContact(Category $category, Request $request)
    {
        $isMain = $this->parentFrom($request) === null;

        $category->show_contact = ! $isMain && $request->boolean('show_contact');

        foreach (['owner_name', 'address', 'google_map_link', 'email', 'phone', 'whatsapp', 'messanger', 'facebook', 'other'] as $field) {
            $category->{$field} = $isMain ? null : ($request->input($field) ?: null);
        }
    }

    /** Land back on the list this record actually belongs to. */
    protected function listRouteFor(Category $category)
    {
        return $this->listRoute($category->level());
    }

    /** The admin screen that lists one level of the tree. */
    protected function listRoute($level)
    {
        return [
            1 => 'categories.index',
            2 => 'subcategories.index',
            3 => 'childcategories.index',
            4 => 'grandchildcategories.index',
        ][$level] ?? 'categories.index';
    }
}
