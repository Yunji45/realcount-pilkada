@extends('layouts.dashboard.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
        <h3 class="fw-bold mb-3">Realcount System</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
            <a href="#">
                <i class="icon-home"></i>
            </a>
            </li>
            <li class="separator">
            <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
            <a href="#">Base</a>
            </li>
            <li class="separator">
            <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
            <a href="#">Realcount System</a>
            </li>
        </ul>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center">HASIL PERHITUNGAN CEPAT</h4><br>
                <div class="row row-demo-grid">
                    <div class="col-sm-6 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Jumlah Suara</h5>
                                <p class="card-text text-center">8</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Jumlah Suara</h5>
                                <p class="card-text text-center">8</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Jumlah Suara</h5>
                                <p class="card-text text-center">8</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title text-center">Jumlah Suara</h5>
                              <p class="card-text text-center">8</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-demo-grid">
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #7FFF00;">
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #0e0f0f;">Suara Masuk : 6</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #FF00FF;">
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #0e0f0f;">TPS Masuk : 6</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #DAA520;">
                    <div class="card-body">
                        <h5 class="card-title text-center" style="color: #0e0f0f;">Candidate : 8</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #FF4500;">
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #0e0f0f;">Pukul : 18:00 WIB</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection