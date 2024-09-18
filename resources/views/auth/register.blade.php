@extends('layouts.auth.app')

@section('title')
    Pilkada | Register
@endsection

@section('content')
    <!-- TABS CONTENT SIGNUP -->

    <div class="logo-container" style="text-align: center; margin-bottom: 25px;">
        <img src="{{ asset('template/assets/img/logo.png') }}" alt="Logo" class="login-logo" style="width: 250px">
    </div>
    <div id="signup-tab-content" class="active">
        <h1
            style="margin-bottom: 60px; color: #555555; font-weight: bold; font-family: 'Arial Black', sans-serif; font-size: 2rem; text-align: center; text-transform: uppercase; letter-spacing: 2px; -webkit-text-stroke: 1px #877E56; text-stroke: 1px #877E56;">
            Pendaftaran
        </h1>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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

            @if (session('success'))
                <script>
                    toastr.success('{{ session('success') }}');
                </script>
            @endif

            @if (session('error'))
                <script>
                    toastr.error('{{ session('error') }}');
                </script>
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
                autocomplete="Password Baru" placeholder="Konfirmasi Password">

            <div class="form-row">
                <div class="form-group gender-group">
                    <label>Gender:</label>
                    <label>
                        <input type="radio" name="gender" value="Pria" required> Pria
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Wanita" required> Wanita
                    </label>
                </div>

                <div class="form-group role-group">
                    <select name="role" class="input select-box" required autofocus required>
                        <option selected disabled>Pilih Akses Anda</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <input type="file" id="ktp" name="ktp" accept="image/*" onchange="previewFile()" hidden required>
                <button type="button" class="upload-btn" onclick="document.getElementById('ktp').click();">
                    Upload KTP
                </button>
                <span id="file-name" class="file-name" style="font-weight: bold">Belum ada foto KTP</span>
                <img id="ktpPreview" class="img-preview" src="#" alt="Preview KTP" style="display: none;">
            </div>

            <br>

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
