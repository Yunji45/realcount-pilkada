<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pilkada | Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 3% auto; /* Reduce margin to make modal bigger */
        padding: 30px; /* Increase padding for better readability */
        border: 1px solid #888;
        width: 80%; /* Set to 80% of the screen width */
        max-width: 900px; /* Max width increased for XL size */
        max-height: 85vh; /* Limit modal height to 85% of the viewport */
        overflow-y: auto;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
        font-size: 1.1rem; /* Slightly larger text for better readability */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
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

    /* Add responsive design for smaller screens */
    @media (max-width: 600px) {
        .modal-content {
            width: 95%;
            margin: 5% auto;
            font-size: 1rem; /* Slightly reduce text size on smaller screens */
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
                    <a href="#header-carousel" class="nav-item nav-link active">Home</a>
                    <a href="#container" class="nav-item nav-link">Profile</a>
                    <a href="" class="nav-item nav-link">Berita</a>
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


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('landing/img/bg-tes.png') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content">
                                <div class="col-lg-12">
                                    <p style="color: black;font-weight:bold"></p>
                                    <h5 class="display-1 animated slideInDown" style="color:#877E56">
                                        DPC Gerindra Kota Bandung
                                        <br>
                                        <p style="font-size: 25px;font-weight:bold;color:#877E56">Partai Politik yang
                                            mampu menciptakan Kesejahteraan rakyat</p>
                                        <p
                                            style="font-size: 19px; text-align: justify; color:#877E56; line-height: 1.5;">
                                            Menegakkan Kedaulatan dan Tegaknya<br>
                                            Negara Kesatuan Republik Indonesia yang<br>
                                            Berdasarkan Pancasila dan Undang-Undang Dasar 1945<br>
                                            yang Ditetapkan pada Tanggal 18 Agustus 1945.
                                        </p>

                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="carousel-item">
                    <img class="w-100" src="{{ asset('landing/img/carousel-2.jpg')}}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <p
                                        class="d-inline-block border border-white rounded text-primary fw-semi-bold py-1 px-3 animated slideInDown">
                                        Welcome to Finanza</p>
                                    <h1 class="display-1 mb-4 animated slideInDown">True Financial Support For You</h1>
                                    <a href="" class="btn btn-primary py-3 px-5 animated slideInDown">Explore More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> --}}
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container" id="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img class="img-fluid rounded" src="{{ asset('landing/img/bg-2.png') }}"
                        style="margin-bottom: 90px">
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="display-5 mb-4">DPC Partai Gerindra Kota Bandung</h1>
                    <p class="mb-4">Partai Gerakan Indonesia Raya adalah partai rakyat yang mendambakan Indonesia
                        yang bangun jiwanya, dan bangun badannya.
                    </p>
                    <div class="border rounded p-4">
                        <nav>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link fw-semi-bold active" id="nav-story-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-story" type="button" role="tab"
                                    aria-controls="nav-story" aria-selected="true">Deklarasi</button>
                                <button class="nav-link fw-semi-bold" id="nav-mission-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-mission" type="button" role="tab"
                                    aria-controls="nav-mission" aria-selected="false">Sejarah</button>
                                <button class="nav-link fw-semi-bold" id="nav-vision-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-vision" type="button" role="tab"
                                    aria-controls="nav-vision" aria-selected="false">Visi dan misi</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-story" role="tabpanel"
                                aria-labelledby="nav-story-tab">
                                <p style="text-align: justify">Bismillahirrahmaanirrahiim
                                    Terwujudnya tatanan masyarakat Indonesia yang merdeka, berdaulat, bersatu,
                                    demokratis, adil dan makmur serta beradab dan berketuhanan  yang berlandaskan
                                    Pancasila, sebagaimana termaktub di dalam Pembukaan UUD 1945, merupakan cita-cita
                                    bersama dari seluruh rakyat Indonesia. Untuk mewujudkan cita-cita tersebut, hanya
                                    dapat dicapai dengan mempertahankan persatuan dan kesatuan bangsa, dengan landasan
                                    Pancasila.</p>

                                <a class="border-bottom" href="#" style="font-weight: bold">Selengkapnya</a>
                            </div>
                            <div class="tab-pane fade" id="nav-mission" role="tabpanel"
                                aria-labelledby="nav-mission-tab">
                                <p style="text-align: justify">Bermula dari Keprihatinan, Partai Gerindra lahir untuk
                                    mengangkat
                                    rakyat dari jerat kemelaratan, akibat permainan orang-orang yang tidak peduli pada
                                    kesejahteraan. Dalam sebuah perjalanan menuju Bandara Soekarno-Hatta, terjadi
                                    obrolan antara intelektual muda Fadli Zon dan pengusaha Hashim Djojohadikusumo.
                                    Ketika itu, November 2007, keduanya membahas politik terkini, yang jauh dari
                                    nilai-nilai demokrasi sesungguhnya.</p>

                                <a class="border-bottom" href="#" style="font-weight: bold">Selengkapnya</a>
                            </div>
                            <div class="tab-pane fade" id="nav-vision" role="tabpanel"
                                aria-labelledby="nav-vision-tab">
                                <p style="text-align: justify">Visi :
                                    Menjadi Partai Politik yang mampu menciptakan kesejahteraan rakyat, keadilan sosial
                                    dan tatanan politik negara yang melandaskan diri pada nilai-nilai nasionalisme dan
                                    religiusitas dalam wadah Negara Kesatuan Republik Indonesia yang berdasarkan pada
                                    Pancasila dan Undang-Undang Dasar 1945 yang senantiasa berdaulat di bidang politik,
                                    berkepribadian di bidang budaya dan berdiri diatas kaki sendiri dalam bidang
                                    ekonomi.</p>

                                <a class="border-bottom" href="#container" style="font-weight: bold"
                                    id="openModal">Selengkapnya</a>

                                <!-- The Modal -->
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h1 style="margin-bottom:20px"> Visi Dan Misi</h1>
                                        <p style="text-align: justify">
                                            Dalam sebuah perjalanan menuju Bandara Soekarno-Hatta, terjadi obrolan
                                            antara intelektual muda Fadli Zon dan pengusaha Hashim Djojohadikusumo.
                                            Ketika itu, November 2007, keduanya membahas politik terkini, yang jauh dari
                                            nilai-nilai demokrasi sesungguhnya. Demokrasi sudah dibajak oleh orang-orang
                                            yang tidak bertanggung jawab dan memiliki kapital besar. Akibatnya, rakyat
                                            hanya jadi alat. Bahkan, siapapun yang tidak memiliki kekuasaan ekonomi dan
                                            politik akan dengan mudah jadi korban. Kebetulan, salah satu korban itu
                                            adalah Hashim sendiri. Dia diperkarakan ke pengadilan dengan tudingan
                                            mencuri benda-benda purbakala dari Museum radya Pustaka, Solo, Jawa tengah.
                                            “Padahal Pak Hashim ingin melestarikan benda-benda cagar budaya,“ kata Fadli
                                            mengenang peristiwa itu. Bila keadaan ini dibiarkan, negara hanya akan
                                            diperintah oleh para mafia. Fadli Zon lalu mengutip kata-kata politisi
                                            inggris abad kedelapan belas, Edmund Burke: “The only thing necessary for
                                            the triumph [of evil] is for good men to do nothing.” Dalam terjemahan
                                            bebasnya, “kalau orang baik-baik tidak berbuat apa-apa, maka para penjahat
                                            yang akan bertindak.“ terinspirasi oleh kata-kata tersebut, Hashim pun
                                            setuju bila ada sebuah partai baru yang memberikan haluan baru dan harapan
                                            baru. Tujuannya tidak lain, agar negara ini bisa diperintah oleh manusia
                                            yang memerhatikan kesejahteraan rakyat, bukan untuk kepentingan golongannya
                                            saja. Sementara kondisi yang sedang berjalan, justru memaksakan demokrasi di
                                            tengah himpitan kemiskinan, yang hanya berujung pada kekacauan.

                                            <br><br>Gagasan pendirian partai pun kemudian diwacanakan di lingkaran orang-orang
                                            Hashim dan Prabowo. Rupanya, tidak semua setuju. Ada pula yang menolak,
                                            dengan alasan bila ingin ikut terlibat dalam proses politik sebaiknya ikut
                                            saja pada partai politik yang ada. Kebetulan, Prabowo adalah anggota Dewan
                                            Penasihat Partai Golkar, sehingga bisa mencalonkan diri maju menjadi ketua
                                            umum. Namun, ketika itu Ketua Umum Partai Golkar Jusuf Kalla adalah wakil
                                            presiden mendampingi Presiden Susilo Bambang Yudhoyono. “Mana mau Jusuf
                                            Kalla memberikan jabatan Ketua Umum Golkar kepada Prabowo?” kata Fadli.

                                            <br><br>Setelah perdebatan cukup panjang dan alot, akhirnya disepakati perlu ada
                                            partai baru yang benar-benar memiliki manifesto perjuangan demi
                                            kesejahteraan rakyat. Untuk mematangkan konsep partai, pada Desember 2007,
                                            di sebuah rumah, yang menjadi markas IPS (Institute for Policy Studies) di
                                            Bendungan Hilir, berkumpulah sejumlah nama. Selain Fadli Zon, hadir pula
                                            Ahmad Muzani, M. Asrian Mirza, Amran Nasution, Halida Hatta, Tanya Alwi,
                                            Haris Bobihoe, Sufmi Dasco Ahmad, Muchdi Pr, Widjono Hardjanto dan Prof
                                            Suhardi. Mereka membicarakan anggaran dasar dan anggaran rumah tangga
                                            (AD/ART) partai yang akan dibentuk. “Pembahasan dilakukan siang dan malam,”
                                            kenang Fadli. Karena padatnya jadwal pembuatan AD/ART , akhirnya fisik Fadli
                                            ambruk juga. Lelaki yang menjabat sebagai Direktur Eksekutif di IPS ini
                                            harus dirawat di rumah sakit selama dua minggu.


                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- About End -->

    <div class="container-xxl py-5">
        <div class="container" id="container">
            <section class="latest-articles" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Latest Articles</h2>
                <div class="articles-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @if($articles->isEmpty())
                        <p>No articles available.</p>
                    @else
                        @foreach ($articles as $article)
                            <div class="article-card" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image" style="max-width: 100%; height: auto; display: block; border-radius: 8px;">
                                <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                <p style="color: #555;">{!! Str::limit($article->content, 100) !!}</p>
                                <a href="{{ route('article.show', $article->id) }}" class="read-more" style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read More</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            <section class="categories" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Categories</h2>
                <div class="categories-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @if($categories->isEmpty())
                        <p>No categories available.</p>
                    @else
                        @foreach ($categories as $category)
                            {{-- <a href="{{ route('category.show', $category->category) }}" class="category-item" style="background-color: #3498db; color: #fff; padding: 10px 20px; border-radius: 5px;">{{ $category->category }}</a> --}}
                        @endforeach
                    @endif
                </div>
            </section>

            <!-- Trending Topics Section -->
            <section class="trending-topics" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Trending Topics</h2>
                <div class="trending-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    @if($trendingArticles->isEmpty())
                        <p>No trending articles available.</p>
                    @else
                        @foreach ($trendingArticles as $article)
                            <div class="trending-item" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                <p>{!! Str::limit($article->content, 50) !!}</p>
                                <a href="{{ route('article.show', $article->id) }}" class="read-more" style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read More</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>


        </div>
    </div>

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
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Function to toggle scroll
        function toggleScroll(enable) {
            if (enable) {
                document.body.classList.remove('no-scroll');
            } else {
                document.body.classList.add('no-scroll');
            }
        }

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
            toggleScroll(false); // Disable scrolling
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            toggleScroll(true); // Enable scrolling
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                toggleScroll(true); // Enable scrolling
            }
        }
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
