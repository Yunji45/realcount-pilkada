<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            // $user = User::where('email', $request->email)->first();
            $user = User::where('nik', $request->nik)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->status !== 'Aktif') {
                    session()->flash('error', 'Akun Anda belum aktif. Silakan hubungi admin.');
                    return null;
                }

                return $user;
            }

            return null;
        });
    }
}
