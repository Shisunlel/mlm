<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminsExport;
use App\Http\Controllers\Controller;
use App\Imports\AdminsImport;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function dashboard()
    {
        $page_title = 'Dashboard';

        // User Info
        $widget['total_users'] = Admin::where('id', '!=', 1)->count();
        $widget['total_members'] = User::count();
        $widget['verified_members'] = User::where('status', 1)->count();

        // $widget['banned_users'] = User::where('status', 0)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
        $widget['banned_members'] = User::where('status', 0)->count();

        // Monthly Deposit & Withdraw Report Graph

        // $bv['bvLeft'] = UserExtra::sum('bv_left');
        // $bv['bvRight'] = UserExtra::sum('bv_right');
        // $bv['totalBvCut'] = BvLog::where('trx_type', '-')->sum('amount');

        $latestUser = User::latest()->limit(6)->get();

        return view('admin.dashboard', compact('page_title',
            'widget', 'latestUser'));
    }

    public function profile()
    {
        $page_title = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('page_title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, 'assets/admin/images/profile/', '400X400', $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $page_title = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('page_title', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        $notify[] = ['success', 'Password Changed Successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->paginate(getPaginate());
        $page_title = 'Notifications';
        return view('admin.notifications', compact('page_title', 'notifications'));
    }

    public function notificationRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }

    public function index()
    {
        $page_title = 'Users';
        $empty_message = 'No user found';
        $admins = Admin::where('id', '!=', 1)->paginate(getPaginate());
        $roles = Role::select('id', 'name')->where('name', '!=', 'superadmin')->get();
        return view('admin.admin.index', compact('admins', 'empty_message', 'page_title', 'roles'));
    }

    // user validation
    protected function validator(array $data)
    {

        $validate = Validator::make($data, [
            'name' => 'required|string|max:160',
            'email' => 'required|string|email|max:160|unique:admins',
            'password' => 'required|string|min:4',
            'username' => 'required|alpha_num|unique:admins|min:4',
        ]);

        return $validate;
    }

    // store user
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        if (Admin::whereEmail($request->email)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }

        if (Admin::where('username', $request->username)->count() > 0) {
            $notify[] = ['error', 'Username already exists.'];
            return back()->withNotify($notify);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'created_by' => auth('admin')->user()->id,
        ]);
        $admin->assignRole($request->role);
        $notify[] = ['success', 'User has been created'];
        return redirect()->route('admin.backend-users.all')->withNotify($notify);
    }

    // user detail
    public function detail($id)
    {
        $page_title = 'User Detail';
        $admin = Admin::where('id', $id)->first();
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return view('admin.admin.detail', compact('page_title', 'admin', 'roles'));
    }

    // update user
    public function update(Request $request, $id)
    {
        $user = Admin::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|string|unique:admins,username,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'role' => 'required',
        ]);

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, 'assets/admin/images/profile/', '400X400', $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->syncRoles($request->role);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    // remove user
    public function destroy()
    {
        $user = Admin::findOrFail(request()->id);
        if (!$user) {
            abort(404);
        }
        $user->delete();
        $notify[] = ['success', 'User has been deleted'];
        return redirect()->route('admin.backend-users.all')->withNotify($notify);
    }

    // search user
    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $admins = Admin::where(function ($user) use ($search) {
            $user->where('id', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->where('id', '!=', 1);
        });
        $users = $admins->paginate(getPaginate());
        $page_title = 'User Search - ' . $search;
        $empty_message = 'No search result found';
        $roles = Role::select('id', 'name')->where('name', '!=', 'superadmin')->get();
        return view('admin.admin.index', compact('page_title', 'search', 'scope', 'empty_message', 'admins', 'roles'));
    }

    // import user via xls
    public function importUsers(Request $request)
    {
        $this->validate($request, [
            'users_import' => 'required|mimes:xls,xlsx,csv|max:100',
        ]);
        if ($request->hasFile('users_import')) {
            $file = $request->file('users_import');
            Excel::import(new AdminsImport, $file);
            $notify[] = ['success', 'User has been created'];
            return redirect()->route('admin.backend-users.all')->withNotify($notify);
        }
    }

    // export all user by excels
    public function exportUsers()
    {
        return Excel::download(new AdminsExport, 'users.xls');
    }

    // assign role
    public function roles()
    {
        $page_title = 'Role';
        $roles = Role::where('name', '!=', 'superadmin')->paginate(getPaginate());
        $empty_message = 'No role found';
        return view('admin.role.index', compact('roles', 'empty_message', 'page_title'));
    }

    public function createRole()
    {
        $page_title = 'Create Role';
        $roles = Role::get();
        $permissions = Permission::get();
        return view('admin.role.create', compact('roles', 'permissions', 'page_title'));

    }

    public function storeRole(Request $request)
    {
        try {
            // if roles not exist
            $permissions = $request->permission;
            $count = Role::where('name', $request->name)->count();
            if ($count == 0) {
                $role = Role::create([
                    'name' => $request->name,
                    'guard_name' => 'admin',
                ]);

                // if permission not exist
                $this->__createPermissionIfNotExist($permissions);
                if (!empty($permissions)) {
                    $role->syncPermissions($permissions);
                }
                $notify[] = ['success', 'Role has been created'];
            } else {
                $notify[] = ['error', 'Role already exist'];
            }
        } catch (\Exception $e) {
            $notify[] = ['error', 'Something went wrong'];
        }
        return redirect()->route('admin.backend-users.roles')->withNotify($notify);
    }

    public function editRole($id)
    {
        $page_title = 'Edit Role';
        $role = Role::where('name', '!=', 'superadmin')->findOrFail($id);
        $role_permissions = [];
        foreach ($role->permissions as $role_perm) {
            $role_permissions[] = $role_perm->name;
        }
        return view('admin.role.edit', compact('role', 'role_permissions', 'page_title'));
    }

    public function updateRole($id, Request $request)
    {
        try {
            $permissions = $request->permission;
            $count = Role::where('name', $request->name)->where('id', '!=', $id)->count();
            if ($count == 0) {
                $role = Role::findOrFail($id);
                $role->name = $request->name;
                $role->save();
                if (!empty($permissions)) {
                    $role->syncPermissions($permissions);
                }
                $notify[] = ['success', 'Role have been updated'];
            } else {
                $notify[] = ['error', 'Role already exist'];
            }
        } catch (\Exception $e) {
            $notify[] = ['error', 'Something went wrong'];
        }
        return redirect()->route('admin.backend-users.roles')->withNotify($notify);
    }

    private function __createPermissionIfNotExist($permissions)
    {
        $exising_permissions = Permission::whereIn('name', $permissions)
            ->pluck('name')
            ->toArray();

        $non_existing_permissions = array_diff($permissions, $exising_permissions);

        if (!empty($non_existing_permissions)) {
            foreach ($non_existing_permissions as $new_permission) {
                Permission::create([
                    'name' => $new_permission,
                    'guard_name' => 'admin',
                ]);
            }
        }
    }

}
