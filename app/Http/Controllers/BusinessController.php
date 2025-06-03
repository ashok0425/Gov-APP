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
        $wards = Business::orderBy('business_order','asc')
        ->when($request->id,function($query) use ($request){
            $query->where('id',$request->id);
        })
        ->when(!$request->id,function($query) use ($request){
            $query->where('id','!=',22);
        })
        ->paginate(10);
        return view('business.index', compact('wards'));
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
        $category = [];
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
$business->google_map_link = $request->google_map_link;
        $business->owner_name = $request->owner_name;
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

    public function edit(Business $ward)
    {
        $categories=Category::all();
        return view('business.edit', compact('ward','categories'));
    }

    public function update(Request $request, Business $ward)
    {
        $request->validate([
            'name' => 'required|max:255',
         'phone' => 'required|integer',
            'address' => 'required',
        ]);
        $category = [];

        $ward->name = $request->name;
        $ward->phone = $request->phone;
        $ward->address = $request->address;
        $ward->category_ids = $category;
        $ward->email = $request->email;

        $ward->phone = $request->phone;
        $ward->facebook = $request->facebook;
        $ward->whatsapp = $request->whatsapp;
        $ward->status = $request->status;
        $ward->messanger = $request->messanger;
        $ward->google_map_link = $request->google_map_link;
        $ward->owner_name = $request->owner_name;
        $ward->other = $request->other;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('uploads', 'public');
            $ward->thumbnail = $path;
        }
        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image')->store('uploads', 'public');
            $ward->cover_image = $cover_image;
        }
        $ward->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Ward updated ',
        ];
        return redirect()->back()->with($notification);
    }

    public function show() {}

    public function reorder() {
        $wards = Business::orderBy('business_order','asc')->paginate(10);

        return view('business.drag', compact('wards'));
    }

    public function reorderStore(Request $request){
        $orders=$request->order;
        foreach ($orders as $key => $order) {
            $business=Business::find($order['id']);
            $business->business_order=$order['position'];
            $business->save();
        }
    }

    public function destroy(Business $ward) {
          $ward->delete();
          $notification = [
            'alert-type' => 'success',
            'message' => 'Ward   Deleted',
        ];

        return redirect()->back()->with($notification);
    }


public function editCategories($id)
{
    $ward = Business::findOrFail($id);
    $assignedCategories = $ward->categories;
    $assigned = $assignedCategories->pluck('id')->toArray();
    $allCategories = Category::all();

    return view('business.edit-categories', compact('ward', 'assigned', 'allCategories','assignedCategories'));
}

public function updateCategories(Request $request, $id)
{
     $business = Business::findOrFail($id);
    $ids = explode(',', $request->input('categories', ''));

    $syncData = [];
    foreach ($ids as $index => $categoryId) {
        if($categoryId){
        $syncData[$categoryId] = ['position' => $index + 1];
        }
    }
    $business->categories()->sync($syncData);

   $notification = [
            'alert-type' => 'success',
            'message' => 'Category sync successfully',
        ];

        return redirect()->back()->with($notification);
}


}
