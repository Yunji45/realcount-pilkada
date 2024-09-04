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


    <!-- Scripts -->
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
            @yield('content')
        </main>
    </div>
</body>


<script>
    /* LOGIN - MAIN.JS - dp 2017 */

    // LOGIN TABS
    $(function() {
        var tab = $(".tabs h3 a");
        tab.on("click", function(event) {
            event.preventDefault();
            tab.removeClass("active");
            $(this).addClass("active");
            tab_content = $(this).attr("href");
            $('div[id$="tab-content"]').removeClass("active");
            $(tab_content).addClass("active");
        });
    });

    // SLIDESHOW
    // $(function() {
    //     $("#slideshow > div:gt(0)").hide();
    //     setInterval(function() {
    //         $("#slideshow > div:first")
    //             .fadeOut(1000)
    //             .next()
    //             .fadeIn(1000)
    //             .end()
    //             .appendTo("#slideshow");
    //     }, 3850);
    // });

    // CUSTOM JQUERY FUNCTION FOR SWAPPING CLASSES
    (function($) {
        "use strict";
        $.fn.swapClass = function(remove, add) {
            this.removeClass(remove).addClass(add);
            return this;
        };
    })(jQuery);

    // SHOW/HIDE PANEL ROUTINE (needs better methods)
    // I'll optimize when time permits.
    $(function() {
        $(".agree,.forgot, #toggle-terms, .log-in, .sign-up").on(
            "click",
            function(event) {
                event.preventDefault();
                var terms = $(".terms"),
                    recovery = $(".recovery"),
                    close = $("#toggle-terms"),
                    arrow = $(".tabs-content .fa");
                if (
                    $(this).hasClass("agree") ||
                    $(this).hasClass("log-in") ||
                    ($(this).is("#toggle-terms") && terms.hasClass("open"))
                ) {
                    if (terms.hasClass("open")) {
                        terms.swapClass("open", "closed");
                        close.swapClass("open", "closed");
                        arrow.swapClass("active", "inactive");
                    } else {
                        if ($(this).hasClass("log-in")) {
                            return;
                        }
                        terms.swapClass("closed", "open").scrollTop(0);
                        close.swapClass("closed", "open");
                        arrow.swapClass("inactive", "active");
                    }
                } else if (
                    $(this).hasClass("forgot") ||
                    $(this).hasClass("sign-up") ||
                    $(this).is("#toggle-terms")
                ) {
                    if (recovery.hasClass("open")) {
                        recovery.swapClass("open", "closed");
                        close.swapClass("open", "closed");
                        arrow.swapClass("active", "inactive");
                    } else {
                        if ($(this).hasClass("sign-up")) {
                            return;
                        }
                        recovery.swapClass("closed", "open");
                        close.swapClass("closed", "open");
                        arrow.swapClass("inactive", "active");
                    }
                }
            }
        );
    });

    // DISPLAY MSSG
    $(function() {
        $(".recovery .button").on("click", function(event) {
            event.preventDefault();
            $(".recovery .mssg").addClass("animate");
            setTimeout(function() {
                $(".recovery").swapClass("open", "closed");
                $("#toggle-terms").swapClass("open", "closed");
                $(".tabs-content .fa").swapClass("active", "inactive");
                $(".recovery .mssg").removeClass("animate");
            }, 2500);
        });
    });

    // DISABLE SUBMIT FOR DEMO
    $(function() {
        $(".button").on("click", function(event) {
            $(this).stop();
            event.preventDefault();
            return false;
        });
    });
</script>

</html>
