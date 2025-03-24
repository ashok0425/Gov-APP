<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }

        )->latest()->paginate();

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
        $banner->business_id = Auth::user()->business_id;
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
            'title' => 'nullable|string|max:255',
        ]);

        $banner = Banner::findOrFail($id);

        $thumbnail = $request->file('thumbnail')?->store('uploads', 'public') ?? $banner->thumbnail;
        $banner->thumbnail=$thumbnail;
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->status = $request->status??1;
        $banner->type = $request->type??1;

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
