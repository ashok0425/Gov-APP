<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.cms.edit', compact('cms'));
    }

    public function update(Request $request, Cms $cms)
    {
        Cache::forget('cms');
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
        $cms->logo = $request->file('logo')?->store('drebba/uploads/logo', ['disk' => 's3']) ?? $cms->logo;
        $cms->fevicon = $request->file('fevicon')?->store('drebba/uploads/fevicon', ['disk' => 's3']) ?? $cms->fevicon;
        $cms->save();
        Cache::remember('cms', 86400, function () use ($cms){
            return $cms->fresh();
        });

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
