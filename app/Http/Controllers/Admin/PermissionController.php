<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Permissions';
        $type = 'User Management';
        $permissions = Permission::all();

        return view('dashboard.admin.user-management.permissions.index', compact('permissions', 'title', 'type'));
    }

    public function create()
    {
        $title = 'Create Permissions';
        $type = 'User Management';
        $permission = Permission::pluck('name', 'name')->all();
        return view('dashboard.admin.user-management.permissions.create', compact('permission', 'title', 'type'));
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

            $input = $request->all();
            Permission::create($input);

            DB::commit();
            return redirect('permission')->with('success', 'Permission created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Permission created failed');
        }
    }

    public function edit($id)
    {
        $title = 'Edit Permissions';
        $type = 'User Management';
        $permission = Permission::find($id);

        return view('dashboard.admin.user-management.permissions.edit', compact('permission', 'title', 'type'));
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

            $input = $request->all();

            $permission = Permission::find($id);
            $permission->update($input);

            DB::commit();
            return redirect('permission')->with('success', 'Permission updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Permission updated failed');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Permission::find($id)->delete();

            DB::commit();
            return redirect('permission')->with('success', 'Permission deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return back()->with('error', 'Permission deleted successfully');
        }
    }

    public function massDelete(Request $request)
    {
        $ids = $request->input('selected_ids'); // Fetch selected IDs

        if ($ids) {
            try {
                // Delete Permissions by selected IDs
                Permission::whereIn('id', $ids)->delete();
                return redirect()->back()->with('success', 'Selected permissions deleted successfully.');
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    return redirect()->back()->with('error', 'Some permissions cannot be deleted because they are associated with other records.');
                }
                // Handle other exceptions if necessary
                return redirect()->back()->with('error', 'An unexpected error occurred while deleting permissions.');
            }
        }

        return redirect()->back()->with('error', 'No permissions selected for deletion.');
    }

}
