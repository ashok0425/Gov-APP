<?php

namespace App\Http\Controllers;


use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        if (! Auth::user()->can('page:view')) {
            abort(403);
        }

        $pages = Page::latest()->paginate();

        return view('page.index', compact('pages'));
    }

    public function create()
    {
        if (! Auth::user()->can('page:create')) {
            abort(403);
        }

        return view('page.create');
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can('page:create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            // 'title' => 'required',
        ]);

        $page = new Page;

        $page->title = $request->title;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->slug = $request->slug;
        $page->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Page  Added',

        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Page $page)
    {
        if (! Auth::user()->can('page:edit')) {
            abort(403);
        }

        return view('page.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        if (! Auth::user()->can('page:edit')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            // 'title' => 'required',
        ]);

        $page->title = $request->title;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->slug = $request->slug;
        $page->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Page  updated',

        ];

        return redirect()->back()->with($notification);
    }

    public function show(Page $page) {}

    public function destroy(Page $page)
    {
        if (! Auth::user()->can('page:delete')) {
            abort(403);
        }

        $page->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Page  Deleted',
        ];

        return redirect()->route('pages.index')->with($notification);
    }
}
