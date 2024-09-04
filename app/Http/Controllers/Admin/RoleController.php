<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        //menampilkan semua data role
        $title = 'Role';
        $type = 'User Management';
        $roles = Role::all();

        $permission = Permission::paginate(6);
        return view('dashboard.admin.user-management.roles.index', compact('roles', 'permission','title','type'));
    }

    public function create()
    {
        $title = 'Create Role';
        $type = 'User Management';
        $permission = Permission::get();

        return view('dashboard.admin.user-management.roles.create', compact('permission','title','type'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'regex:/^[^0-9!@#$%^&*(),.?":{}|<>]+$/'],
            ], [
                'name.required' => 'The name field is required. or do not use characters',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions(array_map(fn($val) => (int) $val, $request->input('permission')));

            DB::commit();
            return redirect('role')->with('success', 'Role created successfully');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return back()->with('error', 'Role created failed');
        }
    }

    public function edit($id)
    {
        $title = 'Edit Role';
        $type = 'User Management';
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('dashboard.admin.user-management.roles.edit', compact('role', 'permission', 'rolePermissions','title','type'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'regex:/^[^0-9!@#$%^&*(),.?":{}|<>]+$/'],
            ], [
                'name.required' => 'The name field is required. or do not use characters',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            // $role->syncPermissions($request->input('permission'));
            $role->syncPermissions(array_map(fn($val) => (int) $val, $request->input('permission')));

            DB::commit();
            return redirect('role')->with('success', 'Role updated successfully');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return back()->with('error', 'Role updated failed');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table("roles")->where('id', $id)->delete();

            DB::commit();
            return redirect('role')->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return back()->with('success', 'Role deleted failed');
        }
    }
}
