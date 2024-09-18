@extends('landingpage.app')

@section('title')
    Pilkada | Berita
@endsection


@section('content')
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
                                        <p style="font-size: 19px; text-align: justify; color:#877E56; line-height: 1.5;">
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
                    <img class="img-fluid rounded" src="{{ asset('landing/img/bg-2.png') }}" style="margin-bottom: 90px">
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
                                    data-bs-target="#nav-story" type="button" role="tab" aria-controls="nav-story"
                                    aria-selected="true">Deklarasi</button>
                                <button class="nav-link fw-semi-bold" id="nav-mission-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-mission" type="button" role="tab" aria-controls="nav-mission"
                                    aria-selected="false">Sejarah</button>
                                <button class="nav-link fw-semi-bold" id="nav-vision-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-vision" type="button" role="tab" aria-controls="nav-vision"
                                    aria-selected="false">Visi dan misi</button>
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

                                <a class="border-bottom" href="#container" style="font-weight: bold" id="openDeklarasi"
                                    data-open-modal="Deklarasi">Selengkapnya</a>

                                <!-- The Modal -->
                                <div id="Deklarasi" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h1 style="margin-bottom:20px">
                                            Deklarasi
                                        </h1>
                                        <p style="text-align: justify">
                                            Bismillahirrahmaanirrahiim

                                            Terwujudnya tatanan masyarakat Indonesia yang merdeka, berdaulat, bersatu,
                                            demokratis, adil dan makmur serta beradab dan berketuhanan  yang
                                            berlandaskan Pancasila, sebagaimana termaktub di dalam Pembukaan UUD 1945,
                                            merupakan cita-cita bersama dari seluruh rakyat Indonesia. Untuk mewujudkan
                                            cita-cita tersebut, hanya dapat dicapai dengan mempertahankan persatuan dan
                                            kesatuan bangsa, dengan landasan Pancasila.

                                            Budaya bangsa dan wawasan kebangsaan harus menjadi modal utama untuk
                                            mengeratkan persatuan dan kesatuan. Sehingga perbedaan di antara kita justru
                                            menjadi rahmat dan menjadi kekuatan bangsa Indonesia.

                                            Namun demikian, mayoritas rakyat masih berkubang dalam penderitaan, sistem
                                            politik kita tak kunjung mampu merumuskan dan melaksanakan perekonomian
                                            Nasional untuk mengangkat harkat dan martabat mayoritas rakyat Indonesia
                                            dari kemelaratan.

                                            Bahkan dalam upaya membangun bangsa, dalam perjalanannya kita telah terjebak
                                            sistem ekonomi pasar. Sistem ekonomi pasar telah memporak-porandakan
                                            perekonomian bangsa, yang menyebabkan situasi yang sulit bagi kehidupan
                                            rakyat dan bangsa. Hal itu berakibat menggelembungnya jumlah rakyat yang
                                            miskin dan menganggur. Pada situasi demikian, tidak ada pilihan lain bagi
                                            bangsa ini kecuali harus menciptakan suasana kemandirian bangsa dengan
                                            membangun sistem ekonomi kerakyatan.

                                            Terpanggil untuk memberikan amal baktinya kepada negara dan rakyat
                                            Indonesia, atas Rahmat Allah Yang Maha Esa, kami yang bertanda tangan di
                                            bawah ini MENDEKLARASIKAN BERDIRINYA PARTAI GERAKAN INDONESIA RAYA
                                            (GERINDRA).
                                            Partai Gerakan Indonesia Raya adalah partai rakyat yang mendambakan
                                            Indonesia yang bangun jiwanya, dan bangun badannya. Partai Gerakan Indonesia
                                            Raya adalah partai rakyat yang bertekad memperjuangkan kemakmuran dan
                                            keadilan di segala bidang.
                                            Jakarta, Pebruari 2008
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                <p style="text-align: justify">Bermula dari Keprihatinan, Partai Gerindra lahir untuk
                                    mengangkat
                                    rakyat dari jerat kemelaratan, akibat permainan orang-orang yang tidak peduli pada
                                    kesejahteraan. Dalam sebuah perjalanan menuju Bandara Soekarno-Hatta, terjadi
                                    obrolan antara intelektual muda Fadli Zon dan pengusaha Hashim Djojohadikusumo.
                                    Ketika itu, November 2007, keduanya membahas politik terkini, yang jauh dari
                                    nilai-nilai demokrasi sesungguhnya.</p>

                                <a class="border-bottom" href="#container" style="font-weight: bold" id="openSejarah"
                                    data-open-modal="Sejarah">Selengkapnya</a>

                                <!-- The Modal -->
                                <div id="Sejarah" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h1 style="margin-bottom:20px">
                                            Sejarah

                                        </h1>
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

                                            Gagasan pendirian partai pun kemudian diwacanakan di lingkaran orang-orang
                                            Hashim dan Prabowo. Rupanya, tidak semua setuju. Ada pula yang menolak,
                                            dengan alasan bila ingin ikut terlibat dalam proses politik sebaiknya ikut
                                            saja pada partai politik yang ada. Kebetulan, Prabowo adalah anggota Dewan
                                            Penasihat Partai Golkar, sehingga bisa mencalonkan diri maju menjadi ketua
                                            umum. Namun, ketika itu Ketua Umum Partai Golkar Jusuf Kalla adalah wakil
                                            presiden mendampingi Presiden Susilo Bambang Yudhoyono. “Mana mau Jusuf
                                            Kalla memberikan jabatan Ketua Umum Golkar kepada Prabowo?” kata Fadli.

                                            Setelah perdebatan cukup panjang dan alot, akhirnya disepakati perlu ada
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
                            <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                                <p style="text-align: justify">Visi :
                                    Menjadi Partai Politik yang mampu menciptakan kesejahteraan rakyat, keadilan sosial
                                    dan tatanan politik negara yang melandaskan diri pada nilai-nilai nasionalisme dan
                                    religiusitas dalam wadah Negara Kesatuan Republik Indonesia yang berdasarkan pada
                                    Pancasila dan Undang-Undang Dasar 1945 yang senantiasa berdaulat di bidang politik,
                                    berkepribadian di bidang budaya dan berdiri diatas kaki sendiri dalam bidang
                                    ekonomi.</p>

                                <a class="border-bottom" href="#container" style="font-weight: bold" id="openVisiMisi"
                                    data-open-modal="VisiMisi">Selengkapnya</a>

                                <!-- The Modal -->
                                <div id="VisiMisi" class="modal">
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

                                            <br><br>Gagasan pendirian partai pun kemudian diwacanakan di lingkaran
                                            orang-orang
                                            Hashim dan Prabowo. Rupanya, tidak semua setuju. Ada pula yang menolak,
                                            dengan alasan bila ingin ikut terlibat dalam proses politik sebaiknya ikut
                                            saja pada partai politik yang ada. Kebetulan, Prabowo adalah anggota Dewan
                                            Penasihat Partai Golkar, sehingga bisa mencalonkan diri maju menjadi ketua
                                            umum. Namun, ketika itu Ketua Umum Partai Golkar Jusuf Kalla adalah wakil
                                            presiden mendampingi Presiden Susilo Bambang Yudhoyono. “Mana mau Jusuf
                                            Kalla memberikan jabatan Ketua Umum Golkar kepada Prabowo?” kata Fadli.

                                            <br><br>Setelah perdebatan cukup panjang dan alot, akhirnya disepakati perlu
                                            ada
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
                <h2 style="font-size: 32px; margin-bottom: 20px;">Berita</h2>
                <div class="articles-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @if ($articles->isEmpty())
                        <p>No articles available.</p>
                    @else
                        @foreach ($articles as $article)
                            <div class="article-card"
                                style="background-color: #fff; padding: 0px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <!-- Image -->
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                    class="article-image"
                                    style="max-width: 100%; height: 200px; display: block; border-radius: 8px 8px 0 0;">

                                <!-- Title and meta info -->
                                <div class="article-content" style="padding: 20px;">
                                    <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                        {{ $article->title }}
                                    </h3>
                                    <div style="color: #888; font-size: 12px; margin-bottom: 10px;">
                                        {{ $article->created_at->format('d/m/Y') }} | No Comments
                                    </div>

                                    <!-- Short content -->
                                    <p style="color: #555; font-size: 14px; margin-bottom: 10px;">
                                        {!! Str::limit($article->content, 100) !!}
                                    </p>

                                    <!-- Read more link -->
                                    <a href="{{ route('berita.detail', $article->id) }}" class="read-more"
                                        style="font-size: 14px; font-weight: bold; color: #e74c3c; text-decoration: none;">
                                        SELENGKAPNYA »
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </section>
            <!-- Pagination -->
            <div style="margin-top: 50px;" class="text-start">
                {{ $articles->links() }}
            </div>

            {{-- <section class="categories" style="margin-top: 40px;">
                    <h2 style="font-size: 32px; margin-bottom: 20px;">Categories</h2>
                    <div class="categories-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @if ($categories->isEmpty())
                            <p>No categories available.</p>
                        @else
                            @foreach ($categories as $category)
                            @endforeach
                            @endif
                        </div>
                    </section> --}}
            {{-- <a href="{{ route('category.show', $category->category) }}" class="category-item" style="background-color: #3498db; color: #fff; padding: 10px 20px; border-radius: 5px;">{{ $category->category }}</a> --}}

            <!-- Trending Topics Section -->
            {{-- <section class="trending-topics" style="margin-top: 40px;">
                    <h2 style="font-size: 32px; margin-bottom: 20px;">Trending Topics</h2>
                    <div class="trending-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        @if ($trendingArticles->isEmpty())
                            <p>No trending articles available.</p>
                        @else
                            @foreach ($trendingArticles as $article)
                                <div class="trending-item"
                                    style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                    <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                    <p>{!! Str::limit($article->content, 50) !!}</p>
                                    <a href="{{ route('article.show', $article->id) }}" class="read-more"
                                        style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read
                                        More</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section> --}}
        </div>
    </div>
@endsection


{{-- @if ($articles->isEmpty())
    <p>No articles available.</p>
@else
    @foreach ($articles as $article)
        <div class="article-card"
            style="background-color: #fff; padding: 0px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <!-- Image -->
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image"
                style="max-width: 100%; height: 200px; display: block; border-radius: 8px 8px 0 0;">

            <!-- Title and meta info -->
            <div class="article-content" style="padding: 20px;">
                <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                    {{ $article->title }}
                </h3>
                <div style="color: #888; font-size: 12px; margin-bottom: 10px;">
                    {{ $article->created_at->format('d/m/Y') }} | No Comments
                </div>

                <!-- Short content -->
                <p style="color: #555; font-size: 14px; margin-bottom: 10px;">
                    {!! Str::limit($article->content, 100) !!}
                </p>

                <!-- Read more link -->
                <a href="{{ route('berita.all') }}" class="read-more"
                    style="font-size: 14px; font-weight: bold; color: #e74c3c; text-decoration: none;">
                    SELENGKAPNYA »
                </a>
            </div>
        </div>
    @endforeach
@endif --}}
