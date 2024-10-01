<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegistrasiEmail;
use App\Mail\VerifikasiEmail;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $title = 'User';
        $type = 'User Management';
        $roles = Role::all();
        // $users = User::all();
        $query = User::query();

        // Filter berdasarkan role
        if ($request->has('role') && $request->role) {
            $role = $request->role;
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $status = $request->status;
            $query->where('status', $status);
        }
        $users = $query->get();
        return view('dashboard.admin.user-management.users.index', compact('users', 'title', 'type', 'roles'));
    }

    public function pending()
    {
        $title = 'User';
        $type = 'User Management Pending';
        // $users = User::where('status', 'Pending')->get();
        $users = User::where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.admin.user-management.users.verifikasi', compact('title', 'type', 'users'));
    }


    public function create()
    {
        $title = 'Create User';
        $type = 'User Management';
        $roles = Role::all();
        $provinsis = Provinsi::all();

        return view('dashboard.admin.user-management.users.create', compact('roles', 'title', 'type', 'provinsis'));
    }

    // Method untuk mendapatkan Kabupaten berdasarkan Provinsi
    public function getKabupaten($provinsiId)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsiId)->get();
        return response()->json($kabupaten);
    }

    // Method untuk mendapatkan Kecamatan berdasarkan Kabupaten
    public function getKecamatan($kabupatenId)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kabupatenId)->get();
        return response()->json($kecamatan);
    }

    // Method untuk mendapatkan Kelurahan berdasarkan Kecamatan
    public function getKelurahan($kecamatanId)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)->get();
        return response()->json($kelurahan);
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
                'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
                'kelurahan_id' => ['nullable', 'exists:kelurahans,id'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Pengecekan apakah koordinator sudah ada di kelurahan
            $existingKoordinator = User::whereHas('roles', function ($q) {
                $q->where('name', 'koordinator');
            })->where('kelurahan_id', $request->kelurahan_id)->first();

            if ($existingKoordinator) {
                return back()->with(['error' => 'Koordinator sudah ada di kelurahan ini.'])->withInput();
            }

            // Proses upload file jika ada
            $pathPublic1 = null;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $pathPublic1 = $request->file('photo')->store('file/photo_profiles', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'photo' => $pathPublic1,
                'kelurahan_id' => $request->kelurahan_id,
                'address' => $request->address,
                'status' => 'Aktif'
            ]);

            $user->assignRole($request->input('roles'));
            // Mail::to($user->email)->send(new RegistrasiEmail([
            //     'name' => $user->name,
            //     'email' => $user->email,
            // ]));

            DB::commit();
            return redirect()->route('user.index')->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
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

        return view('dashboard.admin.user-management.users.edit', compact('user', 'roles', 'userRole', 'title', 'type'));
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
        $emailData = [
            'nik' => $user->nik,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
        ];
        Mail::to($user->email)->send(new VerifikasiEmail($emailData));

        session()->flash('success', 'Pengguna berhasil diverifikasi.');
        return redirect()->back();

    }

    public function status_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = $request->status;

        $user->save();

        return response()->json(['success' => 'Status User telah diubah.']);
    }


}
