@extends('layouts.auth.app')

@section('content')
    <br><br><br><br>
    <!-- TABS CONTENT LOGIN -->
    <div class="logo-container" style="text-align: center; margin-bottom: 25px;">
        <img src="{{ asset('template/assets/img/logo.png') }}" alt="Logo" class="login-logo" style="width: 250px">
    </div>
    <div id="login-tab-content" class="active">
        <h1
            style="margin-bottom: 60px; color: #555555; font-weight: bold; font-family: 'Arial Black', sans-serif; font-size: 2rem; text-align: center; text-transform: uppercase; letter-spacing: 2px; -webkit-text-stroke: 1px #877E56; text-stroke: 1px #877E56;">
            DPC Kota Bandung
        </h1>


        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" class="input" name="email" autocomplete="off" placeholder="Username"
                value="{{ old('name') }}">
            <input type="password" class="input" id="password" name="password" autocomplete="off" placeholder="Password">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <br><br>
            <button type="submit" class="btn btn-primary"
                style="background-color: #877E56; border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease;font-weight:bold;border-radius:10px">
                {{ __('Login') }}
            </button>

        </form>
        <div class="tabs">
            <br>

            <a href="#">
                <p class="signin" style="text-align: center;font-size:18px">Belum punya akun ? <a
                        href="{{ route('register') }}" style="color: #317ff3">Daftar Disini</a> </p>
            </a>
        </div>
    </div>

@endsection
