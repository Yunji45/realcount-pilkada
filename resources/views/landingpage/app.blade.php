<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My Gerindra</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="icon" href="{{ asset('template/assets/img/icon.svg') }}" type="image/x-icon" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing/css/bootstrap.mins.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">

    <style>
/* General styling for carousel and container */
.carousel-item img {
    width: 100%;
    height: auto;
}

.carousel-caption {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    background-color: rgba(255, 255, 255, 0);
    padding: 20px;
    box-sizing: border-box;
}

/* Styling for captions and text elements */
.carousel-caption h5 {
    font-size: 2rem;
    color: #877E56;
    font-weight: bold;
}

.carousel-caption p {
    font-size: 1.2rem;
    color: #877E56;
    line-height: 1.5;
    text-align: justify;
}

/* Hide background image on small screens */
@media (max-width: 768px) {
    .carousel-item img {
        display: none;
    }

    .carousel-caption {
        top: 70%;
    }

    .carousel-caption h5 {
        font-size: 1.8rem;
    }

    .carousel-caption p {
        font-size: 1rem;
    }
}

/* Additional fine-tuning for even smaller devices */
@media (max-width: 576px) {
    .carousel-caption h5 {
        font-size: 1.5rem;
    }

    .carousel-caption p {
        font-size: 0.9rem;
        text-align: left;
    }
}

/* Larger screen adjustments */
@media (min-width: 768px) {
    .carousel-caption h5 {
        font-size: 3rem;
    }

    .carousel-caption p {
        font-size: 1.5rem;
    }
}

    </style>

    <style>
        .col-lg-12 h5 {
            color: #000;
            /* Warna teks */
            font-size: 30px;
            margin-bottom: 25%;
        }

        .btn-custom {
            background-color: #877E56;
            /* warna hijau */
            border-radius: 5px;

        }

        .btn-custom:hover {
            background-color: #d4c581;
            /* warna hijau lebih gelap saat dihover */
        }
    </style>


    <style>
        /* Style for Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 40px;
            width: 100%;
            height: 100%;
            background-color: transparent;
            /* Make background transparent */
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 3% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 80%;
            max-width: 900px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            font-size: 1.1rem;
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style to prevent scrolling */
        .no-scroll {
            overflow: hidden;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .modal-content {
                width: 95%;
                margin: 5% auto;
                font-size: 1rem;
            }
        }
    </style>



</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt text-primary me-2"></i>
                    Jl. Talaga Bodas No. 37 Bandung</small>
                <small class="ms-6" style="margin-left: 20px"><i class="fa fa-clock text-primary me-2"></i>8 AM - 5 PM
                    | Hari libur (Tutup)</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small><i class="fa fa-envelope text-primary me-2"></i>adminpc@gerindrakotabandung.com</small>
                <small class="ms-4"><i class="fa fa-phone-alt text-primary me-2"></i>0852-9816-5808</small>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="display-5 text-primary m-0"></h1>
                <img src="{{ asset('template/assets/img/logo.png') }}" alt="Logo" class="login-logo"
                    style="width: 200px;margin-left:30px">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="{{ route('landingpage') }}" class="nav-item nav-link active">Home</a>
                    <a href="#container" class="nav-item nav-link">Profile</a>
                    <a href="{{ route('berita.all') }}" class="nav-item nav-link">Berita</a>
                    <a href="#footer" class="nav-item nav-link">Kontak</a>
                    <a href="/login" class="nav-item nav-link btn-custom"
                        style="color: white;font-weight: bold;">Login</a>

                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn btn-light btn-sm-square rounded-circle ms-3" href="">
                        <small class="fab fa-facebook-f text-primary"></small>
                    </a>
                    <a class="btn btn-light btn-sm-square rounded-circle ms-3" href="">
                        <small class="fab fa-twitter text-primary"></small>
                    </a>
                    <a class="btn btn-light btn-sm-square rounded-circle ms-3" href="">
                        <small class="fab fa-linkedin-in text-primary"></small>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5" id="footer">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">DPC Partai Gerindra Kota Bandung</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>DPC Partai Gerindra Kota Bandung <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jl. Talaga Bodas No.37 Bandung</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0852-9816-5808</p>
                    <p class="mb-2"><i class="fa fa-envelope me-1"></i>admin@gerindrakotabandung.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">Services</h4>
                    <a class="btn btn-link" href="#header-carousel">Home</a>
                    <a class="btn btn-link" href="#container">Profile</a>
                    <a class="btn btn-link" href="#news">Berita</a>
                </div>
                {{-- <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-white border-0 w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Your email">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Distributed by DPC Gerindra.</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Copyright © 2024 DPC Partai Gerindra Kota Bandung. All rights reserved.
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    {{-- Modal Skrip --}}
    <script>
        // Function to toggle scroll
        function toggleScroll(enable) {
            if (enable) {
                document.body.classList.remove('no-scroll');
            } else {
                document.body.classList.add('no-scroll');
            }
        }

        // Function to open a modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
            toggleScroll(false); // Disable scrolling
        }

        // Function to close a modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
            toggleScroll(true); // Enable scrolling
        }

        // Get all buttons that open modals
        var openButtons = document.querySelectorAll("[data-open-modal]");

        // Add click event to all buttons to open the corresponding modal
        openButtons.forEach(function(button) {
            button.onclick = function() {
                var modalId = this.getAttribute("data-open-modal");
                openModal(modalId);
            };
        });

        // Get all <span> elements that close the modals
        var closeButtons = document.querySelectorAll(".close");

        // Add click event to all close buttons
        closeButtons.forEach(function(span) {
            span.onclick = function() {
                var modalId = this.getAttribute("data-modal");
                closeModal(modalId);
            };
        });

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            var modals = document.querySelectorAll(".modal");
            modals.forEach(function(modal) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    toggleScroll(true); // Enable scrolling
                }
            });
        };
    </script>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing/js/main.js') }}"></script>
</body>

</html>
