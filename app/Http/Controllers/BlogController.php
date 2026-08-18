<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Blog::query()
              ->accessibleBy(Auth::user())
            ->when($request->status!=''||$request->status,function($query) use ($request){
           $query->where('status',$request->status);
            })
            ->when($request->category,function($query) use ($request){
                $query->whereIn('category_id',$request->category);
            })
            ->when($request->subcategory,function($query) use ($request){
                $query->whereIn('subcategory_id',$request->subcategory);
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

        $categories=Category::accessibleBy(Auth::user())->parents()->get();
        $subcategories=$this->subcategoriesOf($categories);
        return view('blog.index', compact('posts','categories','subcategories'));
    }

    public function create()
    {
        $categories=Category::accessibleBy(Auth::user())->parents()->get();
        $subcategoryMap=$this->subcategoryMap($categories);
        return view('blog.create',compact('categories','subcategoryMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
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
        $post->subcategory_id = $this->subcategoryFor($request->category, $request->subcategory);
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
        if(!Blog::accessibleby(Auth::user())->where('id',$post->id)->first()){
            $notification = [
                'alert-type' => 'error',
                'message' => 'unauthorized Request',

            ];
            return redirect()->route('blogs.index')->with($notification);
        }
        $categories=Category::accessibleBy(Auth::user())->parents()->get();
        $subcategoryMap=$this->subcategoryMap($categories);
        return view('blog.edit', compact('post','categories','subcategoryMap'));
    }

    public function update(Request $request, Blog $post)
    {
        $request->validate([
            'title' => 'required',
            'long_description' => 'required',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
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
        $post->subcategory_id = $this->subcategoryFor($request->category, $request->subcategory);
        $post->is_breaking = $request->boolean('is_breaking');
        $post->business_id = Auth::user()->business_id ?? 0;
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

    /** Every subcategory belonging to the given categories, as a flat list. */
    protected function subcategoriesOf($categories)
    {
        return Category::where('status', 1)
            ->with('parent')
            ->whereIn('parent_id', $categories->pluck('id'))
            ->orderBy('name')
            ->get();
    }

    /**
     * Subcategories keyed by parent id, so the form can swap the second
     * dropdown without a round trip.
     */
    protected function subcategoryMap($categories)
    {
        return $this->subcategoriesOf($categories)
            ->groupBy('parent_id')
            // String keys keep json_encode emitting an object, never a list.
            ->mapWithKeys(fn ($group, $parentId) => [
                (string) $parentId => $group->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])->values(),
            ]);
    }

    /** Ignore a subcategory that does not belong to the chosen category. */
    protected function subcategoryFor($categoryId, $subcategoryId)
    {
        if (! $subcategoryId) {
            return null;
        }

        $belongs = Category::where('id', $subcategoryId)
            ->where('parent_id', $categoryId)
            ->exists();

        return $belongs ? $subcategoryId : null;
    }
}
