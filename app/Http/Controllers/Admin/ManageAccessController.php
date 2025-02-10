<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAccessController extends Controller
{
    public function index()
    {
        if (! auth()->user()->can('others:manage_admins')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',

            ];
            return redirect()->back()->with($notification);
        }

        $users = Admin::whereNotIn('email', ['ashok@drebba.com','kartavya@drebba.com'])->get();

        return view('admin.access.index', compact('users'));
    }

    public function create()
    {
        if (! auth()->user()->can('others:manage_admins')) {
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

        return view('admin.access.create', compact('permissions', 'roles', 'permissionMap'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('others:manage_admins')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'permissions' => 'required|array',
            'location'=>'required'
        ]);

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'location_id' => $request->location

        ]);

        $user->syncPermissions($request->permissions);


        return redirect()->route('admin.access.index');
    }

    public function edit($id)
    {
        if (! auth()->user()->can('others:manage_admins')) {
            abort(403);
        }

        $user = Admin::findOrFail($id);
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

        return view('admin.access.edit', compact('user', 'permissions', 'roles', 'permissionMap'));
    }

    public function update(Request $request, $id)
    {

        if (! auth()->user()->can('others:manage_admins')) {
           abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'permissions' => 'nullable|array',
            'location' => 'required',

        ]);

        $user = Admin::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
           'location_id' => $request->location

        ]);

        // if ($request->role) {
        //     $roles = Role::whereIn('name', $request->roles)->get();
        //     $user->assignRole($roles);
        // }

        $user->syncPermissions($request->permissions);

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (! auth()->user()->can('others:manage_admins')) {
            abort(403);
        }

        $user = Admin::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.access.index');
    }
}
