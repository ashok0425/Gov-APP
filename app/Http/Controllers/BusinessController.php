<?php

namespace App\Http\Controllers;


use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $business = Business::orderBy('business_order','asc')
        ->when($request->id,function($query) use ($request){
            $query->where('id',$request->id);
        })
        ->when(!$request->id,function($query) use ($request){
            $query->where('id','!=',22);
        })
        ->paginate(10);
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
        $input = $request->category;
        $category = explode(',', $input[0]);
        $business = new Business();
        $business->name = $request->name;
        $business->phone = $request->phone;
        $business->address = $request->address;
        $business->email = $request->email;
        $business->phone = $request->phone;
        $business->facebook = $request->facebook;
        $business->whatsapp = $request->whatsapp;
        $business->other = $request->other;
        $business->category_ids = $category;
        $business->messanger = $request->messanger;
        $business->business_order = 1;
        $business->status = $request->status;

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
        $input = $request->category;
        $category = explode(',', $input[0]);
        $business->name = $request->name;
        $business->phone = $request->phone;
        $business->address = $request->address;
        $business->category_ids = $category;
        $business->email = $request->email;
        $business->phone = $request->phone;
        $business->facebook = $request->facebook;
        $business->whatsapp = $request->whatsapp;
        $business->status = $request->status;
        $business->messanger = $request->messanger;


        $business->other = $request->other;
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

    public function show() {}

    public function reorder() {
        $business = Business::orderBy('business_order','asc')->paginate(10);

        return view('business.drag', compact('business'));
    }

    public function reorderStore(Request $request){
        $orders=$request->order;
        foreach ($orders as $key => $order) {
            $business=Business::find($order['id']);
            $business->business_order=$order['position'];
            $business->save();
        }
    }

    public function destroy(Business $business) {
          $business->delete();
          $notification = [
            'alert-type' => 'success',
            'message' => 'Ward   Deleted',
        ];

        return redirect()->back()->with($notification);
    }





}
