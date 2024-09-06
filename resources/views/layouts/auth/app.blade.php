<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('template/assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <main class="py-4">
            <!-- LOGIN MODULE -->
            <div class="login">
                <div class="wrap">
                    <!-- TOGGLE -->
                    <div id="toggle-wrap">
                        <div id="toggle-terms">
                            <div id="cross">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDER -->
                    <div class="content">
                        <!-- SLIDESHOW -->
                        <div id="slideshow">
                            <div class="one">
                                <h2>
                                    <img src="{{ asset('template/assets/img/logo.png') }}" width="500px" height="180px"
                                        style="margin-top: 40%">
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- LOGIN FORM -->
                    <div class="user">
                        <div class="form-wrap">

                            <!-- TABS CONTENT -->
                            <div class="tabs-content">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>


<style>
    .alert {
        padding: 15px;
        background-color: #f44336;
        /* Merah terang */
        color: white;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .alert li {
        margin-bottom: 5px;
    }

    button {
    font: inherit;
    background-color: #877E56; /* Base color */
    border: 0;
    color: #ffffff; /* White text for contrast */
    border-radius: 0.5em;
    font-size: 1.35rem;
    padding: 0.375em 1em;
    font-weight: 600;
    text-shadow: 0 0.0625em 0 rgba(0, 0, 0, 0.1); /* Subtle text shadow */
    box-shadow: inset 0 0.0625em 0 0 #a3926b, /* Lighter shades for inner shadows */
        0 0.0625em 0 0 #9f8c63,
        0 0.125em 0 0 #99865b,
        0 0.25em 0 0 #8e7a4e,
        0 0.3125em 0 0 #8b764b,
        0 0.375em 0 0 #8a7448,
        0 0.425em 0 0 #7d6841,
        0 0.425em 0.5em 0 #7f6b43; /* Slightly darker for outer shadows */
    transition: 0.15s ease;
    cursor: pointer;
}

button:active {
    translate: 0 0.225em;
    box-shadow: inset 0 0.03em 0 0 #a3926b,
        0 0.03em 0 0 #9f8c63,
        0 0.0625em 0 0 #99865b,
        0 0.125em 0 0 #8e7a4e,
        0 0.125em 0 0 #8b764b,
        0 0.2em 0 0 #8a7448,
        0 0.225em 0 0 #7d6841,
        0 0.225em 0.375em 0 #7f6b43; /* Adjusted shadow colors */
}

</style>

<style>
    /* General styling for the form row */
    .form-row {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 20px;
        /* Adjust the spacing between Gender and Akses */
        margin-bottom: 15px;
    }

    /* Adjusting the layout for Gender */
    .gender-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Adjusting the layout for Akses select box */
    .role-group {
        display: flex;
        align-items: center;
    }

    .select-box {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
        appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml;base64,...');
        /* Adjust this if needed */
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Styling for radio buttons */
    input[type="radio"] {
        appearance: none;
        background-color: #fff;
        border: 1px solid #007bff;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
        margin-right: 5px;
        position: relative;
    }

    input[type="radio"]::after {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #007bff;
        position: absolute;
        top: 3px;
        left: 3px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    input[type="radio"]:checked::after {
        opacity: 1;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

</html>
