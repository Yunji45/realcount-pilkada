<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $title = 'User';
        $type = 'User Management';
        $users = User::all();

        return view('dashboard.admin.user-management.users.index', compact('users','title','type'));
    }


    public function create(Request $request)
    {
        $title = 'Create User';
        $type = 'User Management';
        // $roles = Role::pluck('name', 'name')->all();
        $roles = Role::all();

        return view('dashboard.admin.user-management.users.create', compact('roles','title','type'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'nik' => ['required', 'numeric', 'unique:users,nik'],
                'date_of_birth' => ['required', 'date'],
                'gender' => ['required', 'string'],
                'password' => ['required'],
                'photo' => ['required', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            ], [
                'password.confirmed' => 'The password confirmation does not match.',
                'photo.image' => 'The photo must be an image.',
                'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
                'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file1 = $request->file('photo');
            $pathPublic1 = null;

            // if (!empty($file1)) {
            //     $nama_file = time() . "_" . $file1->getClientOriginalName();
            //     $nama_folder = 'file/photo_profiles';
            //     $file1->move($nama_folder, $nama_file);
            //     $pathPublic1 = $nama_folder . "/" . $nama_file;
            // }
            if ($file1 && $file1->isValid()) {
                $pathPublic1 = $file1->store('file/photo_profiles', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'photo' => $pathPublic1,
                'address' => $request->address,
                'status' => 'Aktif'
            ]);

            $user->assignRole($request->input('roles'));

            DB::commit();
            // return response()->json([
            //     'success' => true,
            //     'message' => 'User created successfully',
            //     'data' => $user,
            // ], 201);

            return redirect('/user')->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return response()->json([
            //     'success' => false,
            //     'message' => 'User creation failed',
            //     'error' => $th->getMessage(),
            // ], 500);

            return back()->with(['error' => 'User creation failed.']);
        }
    }

    public function edit($id)
    {
        $title = 'Edit User';
        $type = 'User Management';
        $user = User::find($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.admin.user-management.users.edit', compact('user', 'roles', 'userRole','title','type'));
    }

    // public function update(Request $request, User $user)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'name' => ['sometimes|required', 'string'],
    //             'email' => ['sometimes|required', 'email', 'unique:users,email,' . $user->id],
    //             'nik' => ['sometimes|required', 'numeric', 'unique:users,nik,' . $user->id],
    //             'date_of_birth' => ['sometimes|required', 'date'],
    //             'gender' => ['sometimes|required', 'string'],
    //             'password' => ['sometimes|required'],
    //             'address' => ['sometimes|required'],
    //             'photo' => ['sometimes|required', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
    //         ], [
    //             'password.confirmed' => 'The password confirmation does not match.',
    //             'photo.image' => 'The photo must be an image.',
    //             'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
    //             'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
    //         ]);

    //         if ($validator->fails()) {
    //             return back()->withErrors($validator)->withInput();
    //         }

    //         $file = $request->file('photo');
    //         $path = $user->photo;

    //         if ($file && $file->isValid()) {
    //             $nama_file = time() . "-" . $file->getClientOriginalName();
    //             $folder = 'file/photo_profiles';
    //             $file->move($folder, $nama_file);
    //             $path = $folder . "/" . $nama_file;

    //             if ($user->photo && file_exists($user->photo)) {
    //                 File::delete($user->photo);
    //             }
    //         }

    //         $input = $request->except('password', 'photo');
    //         $input['photo'] = $path;

    //         if (!empty($request->password)) {
    //             $input['password'] = Hash::make($request->password);
    //         }

    //         $user->update($input);

    //         DB::table('model_has_roles')
    //             ->where('model_id', $user->id)
    //             ->delete();
    //         $user->assignRole($request->input('roles'));

    //         DB::commit();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User created successfully',
    //             'data' => $user,
    //         ], 201);

    //         // return redirect('user')->with('success', 'User updated successfully');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User creation failed',
    //             'error' => $th->getMessage(),
    //         ], 500);

    //         // return back()->with(['error' => 'User update failed.']);
    //     }
    // }
    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            // $validator = Validator::make($request->all(), [
            //     'name' => ['sometimes', 'required', 'string'],
            //     'email' => ['sometimes', 'required', 'email', 'unique:users,email,' . $user->id],
            //     'nik' => ['sometimes', 'required', 'numeric', 'unique:users,nik,' . $user->id],
            //     'date_of_birth' => ['sometimes', 'required', 'date'],
            //     'gender' => ['sometimes', 'required', 'string'],
            //     'password' => ['sometimes', 'nullable', 'confirmed'],
            //     'address' => ['sometimes', 'required', 'string'],
            //     'photo' => ['sometimes', 'nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            // ], [
            //     'password.confirmed' => 'The password confirmation does not match.',
            //     'photo.image' => 'The photo must be an image.',
            //     'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
            //     'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            // ]);

            // if ($validator->fails()) {
            //     return back()->withErrors($validator)->withInput();
            // }

            $file = $request->file('photo');
            $path = $user->photo;

            // if ($file && $file->isValid()) {
            //     $nama_file = time() . "-" . $file->getClientOriginalName();
            //     $folder = 'file/photo_profiles';
            //     $file->move($folder, $nama_file);
            //     $path = $folder . "/" . $nama_file;

            //     if ($user->photo && file_exists(public_path($user->photo))) {
            //         File::delete(public_path($user->photo));
            //     }
            // }
            if ($file && $file->isValid()) {
                $path = $file->store('file/photo_profiles', 'public');
                    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }
            }

            $input = $request->except(['password', 'photo']);
            $input['photo'] = $path;

            if (!empty($request->password)) {
                $input['password'] = Hash::make($request->password);
            }

            $user->update($input);

            // Update roles
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($request->input('roles'));

            DB::commit();
            // return response()->json([
            //     'success' => true,
            //     'message' => 'User updated successfully',
            //     'data' => $user,
            // ], 200);

            return redirect('user')->with('success', 'User updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return response()->json([
            //     'success' => false,
            //     'message' => 'User update failed',
            //     'error' => $th->getMessage(),
            // ], 500);

            return back()->with(['error' => 'User update failed.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if ($user) {
                $user->delete();
                DB::commit();
                return redirect('user')->with('success', 'User deleted successfully');
            } else {
                DB::rollBack();
                return back()->with('error', 'User not found');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'User deletion failed');
        }
    }

    public function verifikasi($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Aktif';
        $user->save();
        session()->flash('success', 'Pengguna berhasil diverifikasi.');
        return redirect()->back();

    }
}
