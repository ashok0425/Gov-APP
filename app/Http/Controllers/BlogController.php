<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Concerns\ReturnsToList;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class BlogController extends Controller
{
    use ReturnsToList;

    public function index(Request $request)
    {
        if (! Auth::user()->can('post:view')) {
            abort(403);
        }

        $posts = Blog::query()
              ->accessibleBy(Auth::user())
            ->when($request->status!=''||$request->status,function($query) use ($request){
           $query->where('status',$request->status);
            })
            // The cascade sends one id per level; the deepest one picked is
            // what to match, and inCategory() catches that node and everything
            // filed below it.
            ->when($this->deepestOf($request),function($query, $categoryId){
                $query->inCategory($categoryId);
            })
            // An organization picked with no category narrows to every post
            // filed anywhere under that organization's menu.
            ->when($request->organization && ! $this->deepestOf($request), function ($query) use ($request) {
                $query->whereIn('category_id', Category::where('organization_id', $request->organization)->pluck('id'));
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

        return view('blog.index', [
            'posts' => $posts,
            'categoryTree' => Category::treeFor(Auth::user()),
            'selectedTrail' => $this->selectedTrail($request),
            'organizations' => Organization::ordered()->get(),
            'selectedOrganization' => $request->organization,
        ]);
    }

    public function create()
    {
        if (! Auth::user()->can('post:create')) {
            abort(403);
        }

        return view('blog.create', [
            'categoryTree' => Category::treeFor(Auth::user()),
            'organizations' => Organization::ordered()->get(),
            'selectedOrganization' => $this->pinnedOrganization(),
        ]);
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can('post:create')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'long_description' => 'required',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
            'child' => 'nullable|exists:categories,id',
            'grandchild' => 'nullable|exists:categories,id',
        ]);
        $this->guardTrail($request);

        $post = new Blog;
        $category=Category::find($request->category);

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $category->thumbnail;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? null;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->short_description = $request->short_description ?? '';
        $post->long_description = $request->long_description;
        $post->forceFill($this->trailFor($request));
        $post->is_breaking = $request->boolean('is_breaking');
        $post->status = $request->status??$post->status;
        $post->thumbnail = $thumbnail;
        $post->business_id = Auth::user()->business_id ?? 0;
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
        if (! Auth::user()->can('post:edit')) {
            abort(403);
        }

        if(!Blog::accessibleby(Auth::user())->where('id',$post->id)->first()){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];
            return redirect()->route('blogs.index')->with($notification);
        }
        return view('blog.edit', [
            'post' => $post,
            'categoryTree' => Category::treeFor(Auth::user()),
            'selectedTrail' => $post->only(\App\Models\Blog::TRAIL_COLUMNS),
            'organizations' => Organization::ordered()->get(),
            // The post's own organization: whatever its root category names.
            'selectedOrganization' => optional($post->category)->organization_id,
        ]);
    }

    public function update(Request $request, Blog $post)
    {
        if (! Auth::user()->can('post:edit')) {
            abort(403);
        }

        if (! Blog::accessibleBy(Auth::user())->where('id', $post->id)->exists()) {
            return redirect()->route('blogs.index')->with([
                'alert-type' => 'error',
                'message' => 'unauthorized Request',
            ]);
        }

        $request->validate([
            'title' => 'required',
            'long_description' => 'required',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
            'child' => 'nullable|exists:categories,id',
            'grandchild' => 'nullable|exists:categories,id',
        ]);
        $this->guardTrail($request);
        // if(!Auth::user()->can('can:do-anything') && $post->business_id!=Auth::user()->business_id){
        //     $notification = [
        //         'alert-type' => 'error',
        //         'message' => 'unauthorized Request',

        //     ];

        //     return redirect()->route('blogs.index')->with($notification);
        // }
        // "Remove current image" clears it; a fresh upload still wins.
        if ($request->boolean('remove_thumbnail')) {
            \Storage::disk('public')->delete((string) $post->thumbnail);
            $post->thumbnail = null;
        }

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $post->thumbnail;
        $cover = $request->file('cover')?->store('uploads', 'public') ?? $post->thumbnail;

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->short_description = $request->short_description ?? '';
        $post->long_description = $request->long_description;
        $post->thumbnail = $thumbnail;
        $post->status = $request->status??$post->status;
        $post->forceFill($this->trailFor($request));
        $post->is_breaking = $request->boolean('is_breaking');
        $post->business_id = Auth::user()->business_id ?? 0;
        $post->cover = $cover;

        $post->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Post  updated',

        ];

        return redirect()->to($this->returnUrl($request, 'blogs.index'))->with($notification);
    }

    public function show(Blog $post) {
        if (! Auth::user()->can('post:view')) {
            abort(403);
        }

        if(!Auth::user()->can('do:anything')){
            if($post->business_id!=Auth::user()->business_id){
                return redirect()->back()->with('error','You are not allowed to delete this blog');
                }

        }

        return view('blog.show', compact('post'));
    }

    public function destroy(Blog $post)
    {
        if (! Auth::user()->can('post:delete')) {
            abort(403);
        }

          if(!Blog::accessibleby(Auth::user())->where('id',$post->id)->first()){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];
            return redirect()->route('blogs.index')->with($notification);
        }

        $post->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Post  Deleted',
        ];

        return redirect()->route('blogs.index')->with($notification);
    }

    /**
     * The organization a pinned employee's post form should open on — when
     * every node they hold sits under the same one. Otherwise they choose.
     */
    protected function pinnedOrganization()
    {
        $organizations = Auth::user()->scopedCategories()
            ->map(fn ($scope) => ($scope->ancestors()->first() ?? $scope)->organization_id)
            ->unique();

        return $organizations->count() === 1 ? $organizations->first() : null;
    }

    /**
     * The deepest node the form picked has to sit inside what this user may
     * file under. Ancestors the cascade only passes through are not valid
     * targets, and neither is anything outside the employee's nodes.
     */
    protected function guardTrail(Request $request)
    {
        $deepest = $this->deepestOf($request);

        if ($deepest && ! Category::accessibleBy(Auth::user())->where('id', $deepest)->exists()) {
            throw ValidationException::withMessages([
                'category' => 'You can only file posts under your own category.',
            ]);
        }
    }

    /** The four ids the cascade holds, deepest last. */
    protected function selectedTrail(Request $request)
    {
        return collect($this->cascadeFields())
            ->map(fn ($field) => $request->input($field))
            ->values()
            ->all();
    }

    /** The deepest level the cascade actually has a pick for. */
    protected function deepestOf(Request $request)
    {
        return collect(array_reverse($this->cascadeFields()))
            ->map(fn ($field) => $request->input($field))
            ->first(fn ($value) => filled($value));
    }

    /**
     * A post records its whole filing trail. Rather than trust the four ids
     * the form sent, walk up from the deepest one — that way the columns are
     * always a real path through the menu, whatever the browser posted.
     */
    protected function trailFor(Request $request)
    {
        $columns = array_fill_keys(\App\Models\Blog::TRAIL_COLUMNS, null);
        $deepest = $this->deepestOf($request);
        $category = $deepest ? Category::find($deepest) : null;

        if (! $category) {
            return $columns;
        }

        $trail = $category->ancestors()->push($category)->values();

        foreach (array_keys($columns) as $index => $column) {
            $columns[$column] = $trail->get($index)?->id;
        }

        return $columns;
    }

    /** One form field per level, top first. */
    protected function cascadeFields()
    {
        return array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, Category::MAX_DEPTH);
    }
}
