<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAccessController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('user:view')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',
            ];
            return redirect()->back()->with($notification);
        }

        $users = User::with('categories.parent.parent.parent')->whereNotIn('email', ['ashok@drebba.com', 'kartavya@drebba.com'])
            ->when(!Auth::user()->can('do:anything'), function ($query) {
                $query->where('business_id', Auth::user()->business_id);
            })
            ->get();

        return view('access.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->can('user:create')) {
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
                $permissionMap[$exploded[0]] = array_merge(isset($permissionMap[$exploded[0]]) ? $permissionMap[$exploded[0]] : [], [$permission->name]);
            } else {
                array_push($permissionMap['others'], $permission->name);
            }
        }
        $roles = Role::orderBy('name')->get();

        return view('access.create', compact('permissions', 'roles', 'permissionMap') + [
            'categoryTree' => Category::treeFor(Auth::user()),
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('user:create')) {
            abort(403);
        }
        // dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|integer|unique:users,phone',
                'password' => 'required',
                'permissions' => 'nullable|array',
                'role' => 'required|integer',
                'category' => 'nullable|array',
                'category.*' => 'integer|exists:categories,id',
                'subcategory' => 'nullable|array',
                'subcategory.*' => 'integer|exists:categories,id',
                'child' => 'nullable|array',
                'child.*' => 'integer|exists:categories,id',
                'grandchild' => 'nullable|array',
                'grandchild.*' => 'integer|exists:categories,id',
            ],
        );

        $validator->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'status' => $request->status,
            'role' => $request->role ?? 2,
        ]);

        // if ($request->is_owner==1) {
        //  $user->business()->update([
        //     'owner_id' => $user->id,
        //  ]);
        // }

        $user->syncPermissions($request->permissions);
        $user->categories()->sync($this->assignedCategories($request));

        $notification = [
            'alert-type' => 'success',
            'message' => 'created successfully',
        ];
        return redirect()->route('access.index')->with($notification);
    }

    public function edit($id)
    {
        if (!auth()->user()->can('user:edit')) {
            abort(403);
        }

        $user = User::when(!Auth::user()->can('do:anything'), function ($query) {
            $query->where('business_id', Auth::user()->business_id);
        })
            ->where('id', $id)
            ->firstOrFail();
        $roles = Role::orderBy('name')->get();

        $permissions = Permission::orderBy('name')->get();

        $permissionMap = [
            'others' => [],
        ];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, ':')) {
                $exploded = explode(':', $permission->name);
                $permissionMap[$exploded[0]] = array_merge(isset($permissionMap[$exploded[0]]) ? $permissionMap[$exploded[0]] : [], [$permission->name]);
            } else {
                array_push($permissionMap['others'], $permission->name);
            }
        }

        // appending others to the end of the $permissionMap
        $otherPermissions = Arr::pull($permissionMap, 'others');
        $permissionMap['others'] = $otherPermissions;

        return view('access.edit', compact('user', 'permissions', 'roles', 'permissionMap') + [
            'categoryTree' => Category::treeFor(Auth::user()),
            'selectedLevels' => $this->selectedLevels($user),
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('user:edit')) {
            abort(403);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|integer',
                'permissions' => 'nullable|array',
                'role' => 'required|integer',
                'category' => 'nullable|array',
                'category.*' => 'integer|exists:categories,id',
                'subcategory' => 'nullable|array',
                'subcategory.*' => 'integer|exists:categories,id',
                'child' => 'nullable|array',
                'child.*' => 'integer|exists:categories,id',
                'grandchild' => 'nullable|array',
                'grandchild.*' => 'integer|exists:categories,id',
            ],
        );

        $validator->validate();

        $user = User::when(!Auth::user()->can('do:anything'), function ($query) {
            $query->where('business_id', Auth::user()->business_id);
        })
            ->where('id', $id)
            ->firstOrFail();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'role' => $request->role ?? 2,
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $user->syncPermissions($request->permissions);
        $user->categories()->sync($this->assignedCategories($request));

        $notification = [
            'alert-type' => 'success',
            'message' => 'updated successfully',
        ];
        return redirect()->route('access.index')->with($notification);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('user:delete')) {
            abort(403);
        }

        $user = User::when(!Auth::user()->can('do:anything'), function ($query) {
            $query->where('business_id', Auth::user()->business_id);
        })
            ->where('id', $id)
            ->firstOrFail();
        $user->delete();

        $notification = [
            'alert-type' => 'success',
            'message' => 'User Deleted',
        ];
        return redirect()->back()->with($notification);
        return redirect()->route('access.index');
    }

    public function password($user_id)
    {
        return view('user.password', compact('user_id'));
    }

    /**
     * The nodes the employee is pinned to. The picker sends every level's
     * picks; a pick with another pick beneath it was only the way down, so
     * the deepest pick on each branch is what counts. Each has to be
     * somewhere the current admin can reach. Nothing picked leaves the
     * employee unrestricted.
     */
    protected function assignedCategories(Request $request)
    {
        $ids = collect(['category', 'subcategory', 'child', 'grandchild'])
            ->flatMap(fn ($field) => (array) $request->input($field, []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return [];
        }

        $nodes = Category::with('parent.parent.parent')->whereIn('id', $ids)->get();
        $onTheWay = $nodes->flatMap(fn ($node) => $node->ancestors()->pluck('id'))->unique();
        $pinned = $nodes->reject(fn ($node) => $onTheWay->contains($node->id))->pluck('id');

        $reachable = Category::accessibleBy(Auth::user())->whereIn('id', $pinned)->count();

        if ($reachable !== $pinned->count()) {
            throw ValidationException::withMessages([
                'category' => 'You can only assign categories you have access to.',
            ]);
        }

        return $pinned->all();
    }

    /** The picker's preselection: each pinned node and its path, by level. */
    protected function selectedLevels(User $user)
    {
        $levels = array_fill(0, Category::MAX_DEPTH, []);

        foreach ($user->categories as $category) {
            foreach ($category->ancestors()->push($category)->values() as $depth => $node) {
                $levels[$depth][] = $node->id;
            }
        }

        return array_map(fn ($ids) => array_values(array_unique($ids)), $levels);
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
        if (!auth()->user()->can('can:do_anything')) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'You do not have sufficient permissions.',
            ];
            return redirect()->back()->with($notification);
        }

        $users = User::where('is_user', 1)->latest()->paginate(20);
        return view('user.index', compact('users'));
    }
}
