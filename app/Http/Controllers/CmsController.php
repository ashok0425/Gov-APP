<?php

namespace App\Http\Controllers;


use App\Models\Cms;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CmsController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        $cms=Cms::find(1);
        return view('cms.edit', compact('cms'));
    }

    public function update(Request $request, Cms $cms)
    {
        // These land in public storage, so keep them to real images. GIF is
        // spelled out because the header banner is usually animated.
        $request->validate([
            'logo' => 'nullable|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'fevicon' => 'nullable|mimes:jpg,jpeg,png,webp,gif,ico|max:1024',
            'header_banner' => 'nullable|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $cms=Cms::find(1);
        $cms->meta_title = $request->meta_title;
        $cms->meta_keyword = $request->meta_keyword;
        $cms->meta_description = $request->meta_description;
        $cms->url = $request->url;
        $cms->phone1 = $request->phone1;
        $cms->phone2 = $request->phone2;
        $cms->email1 = $request->email1;
        $cms->email2 = $request->email2;
        $cms->address = $request->address;
        $cms->facebook = $request->facebook;
        $cms->twitter = $request->twitter;
        $cms->instagram = $request->instagram;
        $cms->linkedin = $request->linkedin;
        $cms->show_palika = $request->boolean('show_palika');
        $cms->logo = $request->file('logo')?->store('uploads', 'public') ?? $cms->logo;
        $cms->fevicon = $request->file('fevicon')?->store('uploads','public') ?? $cms->fevicon;
        $cms->header_banner = $request->file('header_banner')?->store('uploads', 'public') ?? $cms->header_banner;
        $cms->save();


        $notification = [
            'alert-type' => 'success',
            'message' => 'cms  updated',

        ];

        return redirect()->back()->with($notification);
    }

    public function show(Page $page) {}

    public function destroy(Page $page)
    {

    }
}
