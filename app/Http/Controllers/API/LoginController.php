<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // API Register Method
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'address'  => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed', // needs password_confirmation
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422));
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'is_user'=>1,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Registration successful',
            'user'    => $user,
        ]);
    }

    // API Login Method
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422));
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function delete(){
        //    User::find(auth()->user()->id)->delete();
        return response()->json([
            'status'  => true,
            'message' => 'User Deleted successful',
        ]);
    }
}
