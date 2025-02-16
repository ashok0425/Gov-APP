<?php

namespace App\Http\Controllers;


use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate();

        return view('page.index', compact('pages'));
    }

    public function create()
    {
        return view('page.create');
    }

    public function store(Request $request)
    {
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
        return view('page.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
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
        $page->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Page  Deleted',
        ];

        return redirect()->route('pages.index')->with($notification);
    }
}
