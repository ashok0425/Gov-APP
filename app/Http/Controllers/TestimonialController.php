<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->get();

        return view('testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required',
            'feedback' => 'required',


        ]);

        $testimonial = new Testimonial();

        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/testimonial', ['disk' => 's3']) ?? null;
        $logo = $request->file('logo')?->store('drebba/uploads/testimonial', ['disk' => 's3']) ?? null;

        $testimonial->name = $request->name;
        $testimonial->position = $request->position;
        $testimonial->feedback = $request->feedback;
        $testimonial->thumbnail = $thumbnail;
        $testimonial->logo = $logo;
        $testimonial->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Testimonial  Added',

        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Testimonial $testimonial)
    {
        return view('testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required',
            'feedback' => 'required',


        ]);


        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/testimonial', ['disk' => 's3']) ?? $testimonial->thumbnail;
        $logo = $request->file('logo')?->store('drebba/uploads/testimonial', ['disk' => 's3']) ??  $testimonial->logo;

        $testimonial->name = $request->name;
        $testimonial->position = $request->position;
        $testimonial->feedback = $request->feedback;
        $testimonial->thumbnail = $thumbnail;
        $testimonial->logo = $logo;
        $testimonial->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Testimonial  updated',

        ];

        return redirect()->back()->with($notification);
    }

    public function show(Blog $blog) {}

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Testimonial  Deleted',
        ];

        return redirect()->route('testimonials.index')->with($notification);
    }
}
