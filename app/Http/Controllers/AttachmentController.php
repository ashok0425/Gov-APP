<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Category;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AttachmentController extends Controller
{
    public function index()
    {

        $attachments = Attachment::latest()->paginate(20);

        return view('attachment.index', compact('attachments'));
    }

    public function create()
    {
        return view('attachment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $attachment = new Attachment();
        $thumbnail = $request->file('thumbnail')?->store('uploads/attachment', 'public') ?? null;
        $attachment->title = $request->title;
        $attachment->slug = Str::slug($request->title).'-'.rand(1,10000000000);
        $attachment->attachment = $thumbnail;
        $attachment->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Attachment  Added',
        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Attachment $attachment)
    {

        return view('attachment.edit', compact('attachment'));
    }

    public function update(Request $request, Attachment $attachment)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

         $thumbnail = $request->file('thumbnail')?->store('uploads/attachment', 'public') ?? null;
        $attachment->title = $request->title;
        $attachment->slug = Str::slug($request->title).'-'.rand(1,10000000000);
        $attachment->attachment = $thumbnail;
        $attachment->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Attachment  updated',

        ];

        return redirect()->route('categories.index')->with($notification);
    }

    public function show(Category $category) {}

    public function destroy(Attachment $attachment) {
        $attachment->delete();
        $notification = [
          'alert-type' => 'success',
          'message' => 'Attachment   Deleted',
      ];

      return redirect()->back()->with($notification);
    }
}
