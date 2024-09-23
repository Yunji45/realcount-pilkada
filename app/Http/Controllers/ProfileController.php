<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan profil dan form edit dalam satu view
    public function index(Request $request)
    {
        $title = "Profile";
        $user = auth()->user(); // Mendapatkan pengguna yang sedang login
        $editMode = $request->has('edit') && $request->edit == true; // Cek apakah sedang dalam mode edit

        return view('dashboard.profile', compact('title', 'user', 'editMode'));
    }

    // Update profil
    public function update(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi
        try {
            $user = auth()->user(); // Ambil user yang sedang login

            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'address' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|confirmed|min:8', // Password validation, confirmed ensures it matches the password_confirmation field
            ]);

            // Update data user
            $input = $request->except(['password', 'photo']);
            if (!empty($request->password)) {
                $input['password'] = Hash::make($request->password); // Hash the new password if provided
            }

            // Handle upload foto profil baru
            if ($request->hasFile('photo')) {
                // Simpan file ke disk 'public' di folder 'profile_pictures'
                $path = $request->file('photo')->store('profile_pictures', 'public');

                // Hapus foto lama jika ada
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                // Update path foto baru
                $input['photo'] = $path;
            }

            // Update user data
            $user->update($input);

            DB::commit(); // Commit jika berhasil

            return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback jika terjadi kesalahan

            return back()->with('error', 'Failed to update profile: ' . $th->getMessage());
        }
    }


}

