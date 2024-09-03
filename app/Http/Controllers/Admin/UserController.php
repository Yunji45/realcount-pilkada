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
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();

        return view('dashboard.admin.user-management.users.index', compact('users'));
    }


    public function create(Request $request)
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('dashboard.admin.user-management.users.create', compact('roles'));
    }

    public function store(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'no_hp' => ['required', 'numeric'],
                'jk' => ['required', 'string'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'photo' => ['nullable', 'image', 'max:500', 'mimes:jpg,png,jpeg'],
            ], [
                'password.confirmed' => 'The password confirmation does not match.',
                'photo.image' => 'The photo must be an image.',
                'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
                'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 5120 kilobyte.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file1 = $request->file('photo');

            // Check if both files are empty
            if (empty($file1)) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'no_hp' => $request->no_hp,
                    'jk' => $request->jk,
                    'company_id' => $request->company_id,
                ]);
            } else {
                // Process the first file
                $nama_file = time() . "_" . $file1->getClientOriginalName();
                $nama_folder = 'file/photo_profiles';
                $file1->move($nama_folder, $nama_file);
                $pathPublic1 = $nama_folder . "/" . $nama_file;

                // Create user with file paths
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'no_hp' => $request->no_hp,
                    'jk' => $request->jk,
                    'company_id' => $request->company_id,
                    'photo' => $pathPublic1,
                ]);
            }

            // Assign roles
            $user->assignRole($request->input('roles'));

            DB::commit();
            return redirect('/user')->with('success', 'User created successfully');
        } catch (\Throwable $th) {

            DB::rollBack();
            return back()->with(['error' => 'User creation failed.']);
        }
    }


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.admin.user-management.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'no_hp' => ['required', 'numeric'],
                'jk' => ['required', 'string'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
                // 'nama_perusahaan' => ['required', 'string', 'regex:/^[^0-9!@#$%^&*(),?":{}|<>]+$/'],
            ], [
                // 'nama_perusahaan.required' => 'The Company name field is required.',
                // 'nama_perusahaan.regex' => 'The Company name field format is invalid.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file = $request->file('photo');

            if ($file && $file->isValid()) {
                $nama_file = time() . "-" . $file->getClientOriginalName();
                $folder = 'file/photo_profiles';
                $file->move($folder, $nama_file);
                $path = $folder . "/" . $nama_file;

                // Hapus foto yang sudah ada jika ada
                if ($user->photo && file_exists($user->photo)) {
                    File::delete($user->photo);
                }
            } else {
                $path = $request->pathfoto ?? null;
            }

            $input = $request->all();
            $input['photo'] = $path;

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            // Update informasi pengguna
            $user->update($input);

            // Hapus peran yang sudah ada dan tambahkan peran baru
            DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->delete();
            $user->assignRole($request->input('roles'));

            DB::commit();
            return redirect('user')->with('success', 'User updated successfully');
        } catch (\Throwable $th) {

            DB::rollBack();
            // dd($th->getMessage());
            return back()->with(['error' => 'Data gagal disimpan.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            DB::commit();
            return redirect('user')->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {

            DB::rollBack();
            return back()->with('error', 'User deleted failed');
        }
    }
}
