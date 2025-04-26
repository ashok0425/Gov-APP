<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAccessController extends Controller
{
    public function index()
    {
        if (! auth()->user()->can('user:view')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',

            ];
            return redirect()->back()->with($notification);
        }

        $users = User::whereNotIn('email', ['ashok@drebba.com','kartavya@drebba.com'])
        ->when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }
        )->get();

        return view('access.index', compact('users'));
    }

    public function create()
    {
        if (! auth()->user()->can('user:create')) {
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
        if (! auth()->user()->can('user:create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|integer|unique:users,phone',
            'password' => 'required',
            'permissions' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'business_id'=>$request->business_id,
            'status'=>$request->status
            ]);

            if ($request->is_owner==1) {
             $user->business()->update([
                'owner_id' => $user->id,
             ]);
            }

        $user->syncPermissions($request->permissions);

        $notification = [
            'alert-type' => 'success',
            'message' => 'updated successfully',

        ];
        return redirect()->route('access.index')->with($notification);
    }

    public function edit($id)
    {
        if (! auth()->user()->can('user:edit')) {
            abort(403);
        }

        $user = User::when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }

        )->where('id',$id)->firstOrFail();
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

        if (! auth()->user()->can('user:edit')) {
           abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|integer|unique:users,phone,'.$id,
            'permissions' => 'nullable|array',

        ]);

        $user = User::when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }

        )->where('id',$id)->firstOrFail();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status'=>$request->status,
            'business_id'=>$request->business_id
        ]);

        if($request->password){
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $user->syncPermissions($request->permissions);

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (! auth()->user()->can('user:delete')) {
            abort(403);
        }

        $user = User::when(
            !Auth::user()->can('do:anything'),function($query){
               $query->where('business_id',Auth::user()->business_id);
            }

        )->where('id',$id)->firstOrFail();
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


    public function users()
    {
        if (! auth()->user()->can('can:do_anything')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',

            ];
            return redirect()->back()->with($notification);
        }

        $users=User::where('is_user',1)->latest()->paginate(20);
        return view('user.index',compact('users'));

    }
}
