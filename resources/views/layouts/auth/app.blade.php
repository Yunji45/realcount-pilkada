<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('template/assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div id="app">
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
    /* Styling yang lebih simpel untuk tombol dan nama file */
    .upload-btn {
        background-color: #877E56;
        /* Warna dasar */
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .upload-btn:hover {
        background-color: #6e6946;
    }

    .file-name {
        margin-left: 10px;
        font-size: 14px;
        color: #333;
    }

    .img-preview {
        width: 320px;
        height: auto;
        margin-top: 10px;
        border: 2px solid #ddd;
        border-radius: 10px;
        margin-top: 30px;
    }

    .custom-label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }


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
        background-color: #877E56;
        /* Base color */
        border: 0;
        color: #ffffff;
        /* White text for contrast */
        border-radius: 0.5em;
        font-size: 1.35rem;
        padding: 0.375em 1em;
        font-weight: 600;
        text-shadow: 0 0.0625em 0 rgba(0, 0, 0, 0.1);
        /* Subtle text shadow */
        box-shadow: inset 0 0.0625em 0 0 #a3926b,
            /* Lighter shades for inner shadows */
            0 0.0625em 0 0 #9f8c63,
            0 0.125em 0 0 #99865b,
            0 0.25em 0 0 #8e7a4e,
            0 0.3125em 0 0 #8b764b,
            0 0.375em 0 0 #8a7448,
            0 0.425em 0 0 #7d6841,
            0 0.425em 0.5em 0 #7f6b43;
        /* Slightly darker for outer shadows */
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
            0 0.225em 0.375em 0 #7f6b43;
        /* Adjusted shadow colors */
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

    /* Media Query untuk layar kecil */
    @media only screen and (max-width: 768px) {
        .login-logo {
            display: block;
            /* Tampilkan logo */
            width: 150px;
            /* Sesuaikan ukuran logo */
            height: auto;
            margin: 0 auto;
            /* Logo berada di tengah */
        }
    }

    /* Media Query untuk layar besar */
    @media only screen and (min-width: 769px) {
        .login-logo {
            display: none;
        }
    }
</style>


<script>
    function previewFile() {
        const file = document.getElementById('ktp').files[0];
        const preview = document.getElementById('ktpPreview');
        const fileNameSpan = document.getElementById('file-name');

        if (file) {
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block'; // Tampilkan preview KTP
                fileNameSpan.textContent = file.name; // Tampilkan nama file
            };

            reader.readAsDataURL(file); // Ubah file menjadi URL untuk ditampilkan
        } else {
            preview.src = '#';
            preview.style.display = 'none'; // Sembunyikan preview jika tidak ada gambar
            fileNameSpan.textContent = 'Belum ada foto KTP'; // Reset nama file
        }
    }
</script>

</html>
