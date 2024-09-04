@extends('layouts.auth.app')

@section('content')
    <link href="{{ asset('template/assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <!-- TERMS -->
            <div class="terms">
                <h2>dp Terms of Service</h2>
                <p class="small">Last modified: September 23, 2017</p>
                <h3>Welcome to dp</h3>
            </div>

            <!-- RECOVERY -->
            <div class="recovery">
                <h2>Password Recovery</h2>
                <p>Enter either the <strong>email address</strong> or <strong>username</strong> on the account and
                    <strong>click Submit</strong>
                </p>
                <p>We'll email instructions on how to reset your password.</p>
                <form class="recovery-form" action="" method="post">
                    <input type="text" class="input" id="user_recover" placeholder="Enter Email or Username Here">
                    <input type="submit" class="button" value="Submit">
                </form>
                <p class="mssg">An email has been sent to you with further instructions.</p>
            </div>

            <!-- SLIDER -->
            <div class="content">
                <!-- LOGO -->
                {{-- <div class="logo">
                    <a href="#"><img src="http://res.cloudinary.com/dpcloudinary/image/upload/v1506186248/logo.png"
                            alt=""></a>
                </div> --}}
                <!-- SLIDESHOW -->
                <div id="slideshow">
                    <div class="one">
                        <h2>
                            <img src="{{ asset('template/assets/img/logo.png') }}" width="370px" height="130px">
                        </h2>
                    </div>
                </div>
            </div>
            <!-- LOGIN FORM -->
            <div class="user">
                <div class="form-wrap">

                    <!-- TABS CONTENT -->
                    <div class="tabs-content">
                        <!-- TABS CONTENT LOGIN -->
                        <div id="login-tab-content" class="active">
                            <h2 class="signup-tab" style="text-align: center;margin-bottom:30px"><a class="sign-up"><span>DPC Kota Bandung</span></a>
                            </h2>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="text" class="input" name="email" autocomplete="off"
                                    placeholder="Username">
                                <input type="password" class="input"id="password" name="password" autocomplete="off"
                                    placeholder="Password">
                                <input type="checkbox" class="checkbox" checked id="remember_me">
                                <label for="remember_me" style="color: white">Remember me</label>
                                <button type="submit" class="button">
                                    {{ __('Login') }}
                                </button>
                            </form>
                            {{-- <div class="help-action">
                                <p><i class="fa fa-arrow-left" aria-hidden="true"></i><a class="forgot"
                                        href="#">Forgot your password?</a></p>
                            </div> --}}
                            <div class="tabs">
                                <br>
                                <h3 class="signup-tab" style="white-space: nowrap;font-size:17px"> <a class="sign-up"
                                        href="#signup-tab-content">Belum punya akun? daftar disini</a>
                                </h3>
                            </div>
                        </div>

                        <!-- TABS CONTENT SIGNUP -->
                        <div id="signup-tab-content">
                            <h2 class="signup-tab" style="text-align: center;margin-bottom:25px"><a class="sign-up"><span>Pendaftaran</span></a>
                            </h2>
                            <form class="signup-form" action="" method="post">
                                <input type="text" class="input" id="user_email" autocomplete="off" placeholder="NIK">
                                <input type="text" class="input" id="user_name" autocomplete="off"
                                    placeholder="Nama Lengkap">
                                <input type="text" class="input" autocomplete="off" placeholder="Alamat Lengkap">
                                <input type="text" class="input" autocomplete="off" placeholder="Alamat Email">
                                <input type="text" class="input" autocomplete="off" placeholder="Password">
                                <textarea type="text" class="input" autocomplete="off" placeholder="Struktur Partai/ Pasukan Khusus/ Relawan/ Simpatisan/ Saksi/ lain-lain(Optional"></textarea>
                                <input type="submit" class="button" value="Daftar">
                            </form>
                            {{-- <div class="help-action">
                                <p>By signing up, you agree to our</p>
                                <p><i class="fa fa-arrow-left" aria-hidden="true"></i><a class="agree" href="#">Terms
                                        of service</a></p>
                            </div> --}}
                            <div class="tabs">
                                <br>
                                <h3 class="login-tab" style="white-space: nowrap;font-size:17px"><a class="log-in"
                                        href="#login-tab-content">Sudah punya akun? Masuk disini</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
