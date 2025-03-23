<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate();

        return view('banner.index', compact('banners'));
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = new Banner;

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? null;
        $banner->thumbnail=$thumbnail;
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->status = $request->status??1;
        $banner->type = $request->type??1;

        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner added successfully');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'type' => 'required|string|max:255',
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($banner->thumbnail) {
                Storage::delete(str_replace('/storage', 'public', $banner->thumbnail));
            }

            // Store new thumbnail
            $path = $request->file('thumbnail')->store('banners', 'public');
            $banner->thumbnail = Storage::url($path);
        }

        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $banner->type = $request->type;

        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);

        return view('banner.show', compact('banner'));
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete thumbnail
        if ($banner->thumbnail) {
            Storage::delete(str_replace('/storage', 'public', $banner->thumbnail));
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }
}
