<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login')->with('message', 'error');
    }

    public function dashboard(Request $request)
    {

        return view('dashboard');
    }

    public function profile()
    {
        return view('profile');
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (! Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $notification = [
                'message' => 'Invalid username or password',
                'alert-type' => 'error',
            ];
            return redirect('/login')->with($notification);
        }

        if(!Auth::user()->status){
            $notification = [
                'message' => 'Your account has been block.Please contact administration',
                'alert-type' => 'error',
            ];
          Auth::logout();
            return redirect('/login')->with($notification);
        }

        return redirect()->route('dashboard');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'name' => 'required',
        ]);

        $admin = User::find(Auth::user()->id);
        $path = $request->file('file')?->store('uploads', 'public') ?? $admin->profile_phot_path;
        $admin->email = $request->email;
        $admin->name = $request->name;
        $admin->profile_photo_path=$path;
        $admin->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Profile  updated',

        ];

        return redirect()->back()->with($notification);

    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|min:8|max:16',
            'confirmpassword' => 'required|min:8|max:16',

        ]);

        if (Hash::check($request->currentpassword, Auth::user()->password)) {
            if ($request->newpassword === $request->confirmpassword) {
                $admin = User::find(Auth::user()->id);
                $admin->password = Hash::make($request->newpassword);
                $admin->save();
                session()->flush();
                $notification = [
                    'alert-type' => 'success',
                    'message' => 'Password updated',

                ];

                return redirect()->back()->with($notification);

            } else {
                $notification = [
                    'alert-type' => 'error',
                    'message' => 'Password not match',

                ];

                return redirect()->back()->with($notification);
            }
        } else {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Inccorect Password',

            ];

            return redirect()->back()->with($notification);
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flush();
        $notification = [
            'alert-type' => 'success',
            'message' => 'successfully logout !',

        ];

        return redirect()->route('login')->with($notification);

    }
}
