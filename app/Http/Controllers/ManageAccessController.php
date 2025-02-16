<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAccessController extends Controller
{
    public function index()
    {
        if (! auth()->user()->can('others:manage_users')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',

            ];
            return redirect()->back()->with($notification);
        }

        $users = User::whereNotIn('email', ['ashok@drebba.com','kartavya@drebba.com'])->get();

        return view('access.index', compact('users'));
    }

    public function create()
    {
        if (! auth()->user()->can('others:manage_users')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',

            ];
            return redirect()->back()->with($notification);
        }

        $permissions = Permission::orderBy('name')->get();

        $permissionMap = [
            'others' => [],
        ];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, ':')) {
                $exploded = explode(':', $permission->name);
                $permissionMap[$exploded[0]] = array_merge((isset($permissionMap[$exploded[0]])
                    ? $permissionMap[$exploded[0]] : []), [$permission->name]);
            } else {
                array_push($permissionMap['other'], $permission->name);
            }
        }
        $roles = Role::orderBy('name')->get();

        return view('access.create', compact('permissions', 'roles', 'permissionMap'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('others:manage_users')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'permissions' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);

        $user->syncPermissions($request->permissions);


        return redirect()->route('access.index');
    }

    public function edit($id)
    {
        if (! auth()->user()->can('others:manage_users')) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $roles = Role::orderBy('name')->get();

        $permissions = Permission::orderBy('name')->get();

        $permissionMap = [
            'others' => [],
        ];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, ':')) {
                $exploded = explode(':', $permission->name);
                $permissionMap[$exploded[0]] = array_merge((isset($permissionMap[$exploded[0]])
                    ? $permissionMap[$exploded[0]] : []), [$permission->name]);
            } else {
                array_push($permissionMap['others'], $permission->name);
            }
        }

        // appending others to the end of the $permissionMap
        $otherPermissions = Arr::pull($permissionMap, 'others');
        $permissionMap['others'] = $otherPermissions;

        return view('access.edit', compact('user', 'permissions', 'roles', 'permissionMap'));
    }

    public function update(Request $request, $id)
    {

        if (! auth()->user()->can('others:manage_users')) {
           abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'permissions' => 'nullable|array',

        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'phone' => $request->phone,
        ]);

        $user->syncPermissions($request->permissions);

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (! auth()->user()->can('others:manage_users')) {
            abort(403);
        }

        $user = Admin::findOrFail($id);
        $user->delete();

        return redirect()->route('access.index');
    }

    public function password($user_id)
    {
        return view('user.password', compact('user_id'));
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
}
