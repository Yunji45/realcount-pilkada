@extends('layouts.auth.app')

@section('content')
    <!-- TABS CONTENT SIGNUP -->
    <div id="signup-tab-content" class="active">
        <h1
            style="margin-bottom: 60px; color: #555555; font-weight: bold; font-family: 'Arial Black', sans-serif; font-size: 2rem; text-align: center; text-transform: uppercase; letter-spacing: 2px; -webkit-text-stroke: 1px #877E56; text-stroke: 1px #877E56;">
            Pendaftaran
        </h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="text" class="input" autocomplete="off" placeholder="NIK" name="nik"
                value="{{ old('nik') }}">
            <input type="text" class="input @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap">
            <input type="text" class="input" autocomplete="off" placeholder="Alamat Lengkap" name="address"
                value="{{ old('address') }}">
            <input type="text" class="input" autocomplete="off" placeholder="Alamat Email" name="email"
                value="{{ old('email') }}">
            <input id="password" type="password" class="input" name="password" required autocomplete="Password"
                placeholder="Password">
            <input id="password-confirm" type="password" class="input" name="password_confirmation" required
                autocomplete="Password Baru" placeholder="Password Baru">

                <select name="gender" class="input" data-placeholder="Pilih Gender" required autofocus>
                    <option selected disabled>Pilih Gender</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>

                </select>
                <select name="role" class="input" data-placeholder="Pilih Akses" required autofocus>
                    <option selected disabled>Pilih Akses Anda</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            <br><br>
            <button type="submit" class="btn btn-primary"
                style="background-color: #877E56; border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease;font-weight:bold;border-radius:10px">
                {{ __('Daftar') }}
            </button>
        </form>
        {{-- <div class="help-action">
                            <p>By signing up, you agree to our</p>
                            <p><i class="fa fa-arrow-left" aria-hidden="true"></i><a class="agree" href="#">Terms
                                    of service</a></p>
                        </div> --}}
        <div class="tabs">
            <br>
            <a href="#">
                <p class="signin" style="text-align: center;font-size:18px">Sudah punya akun ? <a
                        href="{{ route('login') }}" style="color: #317ff3">Login Disini</a> </p>
            </a>
        </div>
    </div>
@endsection
