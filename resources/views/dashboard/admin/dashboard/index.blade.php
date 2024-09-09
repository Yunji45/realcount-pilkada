@extends('layouts.dashboard.app')
@section('title')
    Pilkada | Dashboard
@endsection

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />


    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
            </div>
        </div>
        <div class="row row-card-no-pd">
            <!-- Struktur Partai -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Struktur Partai</b></h6>
                                <p class="text-muted">xxx Orang</p>
                            </div>
                            <h4 class="text-info fw-bold">170</h4>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Change</p>
                            <p class="text-muted mb-0">75%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pasukan Khusus -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Pasukan Khusus</b></h6>
                                <p class="text-muted">xxx Orang</p>
                            </div>
                            <h4 class="text-success fw-bold">120</h4>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-25" role="progressbar" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Change</p>
                            <p class="text-muted mb-0">25%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relawan -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Relawan</b></h6>
                                <p class="text-muted">xxx Orang</p>
                            </div>
                            <h4 class="text-danger fw-bold">15</h4>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Change</p>
                            <p class="text-muted mb-0">50%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simpatisan 1 -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Simpatisan</b></h6>
                                <p class="text-muted">xxx Orang</p>
                            </div>
                            <h4 class="text-secondary fw-bold">122</h4>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary w-25" role="progressbar" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Change</p>
                            <p class="text-muted mb-0">25%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simpatisan 2 -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Lain-Lain</b></h6>
                                <p class="text-muted">xxx Orang</p>
                            </div>
                            <h4 class="text-secondary fw-bold">12</h4>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary w-25" role="progressbar" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Change</p>
                            <p class="text-muted mb-0">25%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Chart 1</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="doughnutChart1" style="width: 50%; height: 50%"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Chart 2</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="doughnutChart2" style="width: 50%; height: 50%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Bar Multi</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="multipleBarChart" style="width: 50%; height: 50%"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="card-title">Bar Chart</div>
                </div>
                <div class="card-body">
                  <div class="chart-container">
                    <canvas id="barChart"></canvas>
                  </div>
                </div>
              </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Peta Persebaran</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="map" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
    <script src="{{ asset('json_wilayah/tesmap.js') }}"></script>
@endsection
