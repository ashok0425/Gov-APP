<?php

namespace App\Http\Controllers;


use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::latest()->paginate(10);

        return view('business.index', compact('business'));
    }

    public function create()
    {
        $categories=Category::all();
        return view('business.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|integer|unique:businesses,phone',
            'address' => 'required',
        ]);

        $business = new Business();
        $business->name = $request->name;
        $business->phone = $request->phone;
        $business->address = $request->address;
        $business->business_order = $request->order;
        $business->category_ids = $request->category;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('uploads', 'public');
            $business->thumbnail = $path;
        }

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image')->store('uploads', 'public');
            $business->cover_image = $cover_image;
        }

        $business->save();


        $notification = [
            'alert-type' => 'success',
            'message' => 'Ward created ',
        ];

        return redirect()->back()->with($notification);
    }

    public function edit(Business $business)
    {
        $categories=Category::all();
        return view('business.edit', compact('business','categories'));
    }

    public function update(Request $request, Business $business)
    {
        $request->validate([
            'name' => 'required|max:255',
         'phone' => 'required|integer',
            'address' => 'required',
        ]);

        $business->name = $request->name;
        $business->phone = $request->phone;
        $business->address = $request->address;
        $business->business_order = $request->order;
        $business->category_ids = $request->category;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('uploads', 'public');
            $business->thumbnail = $path;
        }
        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image')->store('uploads', 'public');
            $business->cover_image = $cover_image;
        }
        $business->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Ward updated ',
        ];
        return redirect()->back()->with($notification);
    }

    public function show(User $user) {}

    public function destroy(Business $business) {
          $business->delete();
          $notification = [
            'alert-type' => 'success',
            'message' => 'Ward   Deleted',
        ];

        return redirect()->back()->with($notification);
    }





}
