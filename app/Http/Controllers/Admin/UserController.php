<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\UserDiscount;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|integer|unique:users,phone',
            'email' => 'required|max:255',
            'location' => 'required',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = new User;
        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? null;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->profile_photo_path = $thumbnail;
        $user->location_id = $request->location;
        $user->password = Hash::make($request->password);
        $user->save();

        foreach (Subcategory::all() as $key => $item) {
            $discount=new UserDiscount();
            $discount->user_id=$user->id;
            $discount->subcategory_id=$item->id;
            $discount->discount_percentage=0;
            $discount->save();
        }

        $notification = [
            'alert-type' => 'success',
            'message' => 'User  Added',
        ];

        return redirect()->back()->with($notification);
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => "required|max:255|unique:users,phone,$user->id",
            'email' => 'required|max:255',
            'location' => 'required',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        $thumbnail = $request->file('thumbnail')?->store('drebba/uploads/category', ['disk' => 's3']) ?? $user->profile_photo_path;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->location_id = $request->location;
        $user->phone = $request->phone;

        $user->profile_photo_path = $thumbnail;
        $user->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'User  updated',
        ];

        return redirect()->back()->with($notification);
    }

    public function show(User $user) {}

    public function destroy(Category $category) {}

    public function password($user_id)
    {
        return view('admin.user.password', compact('user_id'));
    }

    public function updatePassword(Request $request, $user_id)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::find($user_id);
        $user->password = Hash::make($request->password);
        $user->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Password updated',
        ];

        return redirect()->back()->with($notification);
    }

    public function userlogin(Request $request){
        $user=User::find($request->id);
        Auth::guard('web')->login($user);
        session()->put('userLocationDetail', [
            'store_location' => $user->location->name,
            'store_id' => $user->location_id,
            'delivery_address' => $user->addresses()?->first()?->toString()??null,
            'delivery_address_id' => $user->addresses()?->first()?->id??null
        ]);
        return redirect()->route('home');
    }


    public function changeStatus(Request $request)
    {


        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        $notification = [
            'alert-type' => 'success',
            'message' => "User  status has been updated successfully.",

        ];

        return redirect()->back()->with($notification);
    }


    public function handleDiscount($id){
        $user=User::find($id);
        return view('admin.user.discount',compact('user'));
    }


    public function updateDiscount(Request $request,$id){
        $user=UserDiscount::find($id);
        $user->discount_percentage=$request->percentage;
        $user->type=$request->type;
        $user->save();
        $notification = [
            'alert-type' => 'success',
            'message' => "User  Discount has been updated successfully.",

        ];

        return redirect()->back()->with($notification);
    }


}
