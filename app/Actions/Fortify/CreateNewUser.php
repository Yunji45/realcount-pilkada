<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Redirect;
use App\Mail\RegistrasiEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nik' => ['required', 'string', 'max:255', Rule::unique(User::class, 'nik')], // Validasi NIK unik
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'exists:roles,name'], // Validasi role dari Spatie
            'ktp' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi file KTP
        ],
        [
            'ktp.required' => ['ukuran file maksimal 2 mb']
        ])->validate();

        DB::beginTransaction();
        try {
            // Handle KTP upload
            $ktpPath = null;

            // Check if KTP file exists in the request (use request() to fetch the file)
            if (request()->hasFile('ktp')) {
                $ktpPath = request()->file('ktp')->store('ktp', 'public'); // Store the file in the 'ktp' folder
            }

            $user = User::create([
                'nik' => $input['nik'],
                'name' => $input['name'],
                'address' => $input['address'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'status' => "Pending",
                'gender' => $input['gender'],
                'ktp' => $ktpPath,
            ]);

            $user->assignRole($input['role']);
            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'nik' => $user->nik,
                'address' => $user->address
            ];
            Mail::to($user->email)->send(new RegistrasiEmail($emailData));

            DB::commit();

            // Show success toast
            session()->flash('success', 'User berhasil dibuat.');
            throw new \Illuminate\Auth\AuthenticationException('User belum dapat akses login.');

            // return $user;
        } catch (\Exception $e) {
            // Show error toast in case of failure
            // session()->flash('error', 'Gagal membuat user. ' . $e->getMessage());
            DB::rollBack();
            // return redirect()->back();
            throw $e;
        }
    }
}
