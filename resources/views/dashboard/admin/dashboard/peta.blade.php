@extends('layouts.dashboard.app')
@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
    <!-- Tambahkan di bagian <head> HTML -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        /* Style untuk card partai */
        .party-card {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .party-card i {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .party-card span {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        /* Style untuk legenda */
        .info.legend {
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .info.legend h4 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .info {
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .location-details {
        font-size: 14px;
    }

    .popup-content {
        font-family: Arial, sans-serif;
    }

    .party-card {
        display: flex;
        align-items: center;
        margin: 5px 0;
    }

    .party-card i {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border-radius: 3px;
    }

    .info.legend {
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    </style>

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
            <!-- Role Koordinator -->
            <div class="col-12 col-sm-6 col-md-3 col-lg-2" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0"><b>Koordinator</b></h6>
                            </div>
                            @php
                                $totalKoordinator = $koordinatorAktif + $koordinatorNonaktif;
                                $aktifPercentage =
                                    $totalKoordinator > 0 ? round(($koordinatorAktif / $totalKoordinator) * 100) : 0;
                            @endphp
                            <h4 class="text-info fw-bold mb-0">{{ $totalKoordinator }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $aktifPercentage }}%"
                                aria-valuenow="{{ $aktifPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $aktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Role Pemilih --}}
            <div class="col-12 col-sm-6 col-md-3 col-lg-2" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0"><b>Pemilih</b></h6>
                            </div>
                            @php
                                $totalPemilih = $pemilihAktif + $pemilihNonaktif;
                                $pemilihAktifPercentage =
                                    $totalPemilih > 0 ? round(($pemilihAktif / $totalPemilih) * 100) : 0;
                            @endphp
                            <h4 class="text-success fw-bold mb-0">{{ $totalPemilih }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $pemilihAktifPercentage }}%" aria-valuenow="{{ $pemilihAktifPercentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $pemilihAktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Saksi -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0"><b>Saksi</b></h6>
                            </div>
                            @php
                                $totalSaksi = $saksiAktif + $saksiNonaktif;
                                $saksiAktifPercentage = $totalSaksi > 0 ? round(($saksiAktif / $totalSaksi) * 100) : 0;
                            @endphp
                            <h4 class="text-warning fw-bold mb-0">{{ $totalSaksi }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $saksiAktifPercentage }}%" aria-valuenow="{{ $saksiAktifPercentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $saksiAktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relawan RDW -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Relawan RDW</b></h6>
                            </div>
                            @php
                                $totalRelawanRdw = $relawanRdwAktif + $relawanRdwNonaktif;
                                $relawanRdwAktifPercentage =
                                    $totalRelawanRdw > 0 ? round(($relawanRdwAktif / $totalRelawanRdw) * 100) : 0;
                            @endphp
                            <h4 class="text-primary fw-bold mb-0">{{ $totalRelawanRdw }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $relawanRdwAktifPercentage }}%"
                                aria-valuenow="{{ $relawanRdwAktifPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $relawanRdwAktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simpatisan -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Simpatisan</b></h6>
                            </div>
                            @php
                                $totalSimpatisan = $simpatisanAktif + $simpatisanNonaktif;
                                $simpatisanAktifPercentage =
                                    $totalSimpatisan > 0 ? round(($simpatisanAktif / $totalSimpatisan) * 100) : 0;
                            @endphp
                            <h4 class="text-danger fw-bold mb-0">{{ $totalSimpatisan }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $simpatisanAktifPercentage }}%"
                                aria-valuenow="{{ $simpatisanAktifPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $simpatisanAktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lain-lain -->
            <div class="col-12 col-sm-6 col-md-3 col-lg" style="flex: 1;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><b>Lain-lain</b></h6>
                            </div>
                            @php
                                $totalLainLain = $lainLainAktif + $lainLainNonaktif;
                                $lainLainAktifPercentage =
                                    $totalLainLain > 0 ? round(($lainLainAktif / $totalLainLain) * 100) : 0;
                            @endphp
                            <h4 class="text-secondary fw-bold mb-0">{{ $totalLainLain }}</h4>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-secondary" role="progressbar"
                                style="width: {{ $lainLainAktifPercentage }}%"
                                aria-valuenow="{{ $lainLainAktifPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Aktif</p>
                            <p class="text-muted mb-0">{{ $lainLainAktifPercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Filter TPS (Partai)</div>
                <!-- Filter Form -->
                <style>
                    .filter-form {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 1rem;
                        align-items: center;
                    }

                    .form-group {
                        margin: 0;
                        flex: 1;
                    }

                    .form-select {
                        width: 100%;
                    }

                    /* Responsive Chart */
                    .chart-container {
                        position: relative;
                        width: 100%;
                        height: auto;
                        overflow-x: auto;
                    }

                    /* Ensure that chart fits within the card */
                    @media (max-width: 768px) {
                        .card {
                            width: 100%;
                        }

                        .chart-container canvas {
                            max-width: 100%;
                        }
                    }
                </style>
                <form id="filter-form" action="{{ route('dashboard.peta') }}" method="GET" class="filter-form">
                    <div class="form-group">
                        <label for="kabupaten">Kabupaten:</label>
                        <select class="form-select" name="kabupaten_id" id="kabupaten">
                            <option value="">Pilih Kabupaten</option>
                            <!-- Add options dynamically here -->
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan:</label>
                        <select class="form-select" name="kecamatan_id" id="kecamatan">
                            <option value="">Pilih Kecamatan</option>
                            <!-- Add options dynamically here -->
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="kelurahan">Kelurahan:</label>
                        <select class="form-select" name="kelurahan_id" id="kelurahan">
                            <option value="">Pilih Kelurahan</option>
                            <!-- Add options dynamically here -->
                        </select>
                    </div>
                
                    <div class="form-group" id="rw-group">
                        <label for="rw">RW:</label>
                        <select class="form-select" name="rw_id" id="rw">
                            <option value="">Pilih RW</option>
                            <!-- Add options dynamically here -->
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="election">Pemilu:</label>
                        <select class="form-select" name="election_id" id="election">
                            <option value="">Pilih Pemilu</option>
                            @foreach ($electionsPartais as $electionPartai)
                                <option value="{{ $electionPartai->id }}"
                                    {{ request('election_id') == $electionPartai->id ? 'selected' : '' }}>
                                    {{ $electionPartai->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                </form>
                
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Peta Persebaran</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="map" style="width: 100%; height: 800px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // ID provinsi Jawa Barat (ubah sesuai dengan database Anda)
            var jawaBaratId = 9; // Misalnya ID Jawa Barat adalah 9

            // Fungsi untuk memuat Kabupaten berdasarkan ID Provinsi
            function loadKabupaten(provinsiId) {
                $('#kabupaten').empty().append('<option value="">Pilih Kabupaten</option>');
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                $('#rw').empty().append('<option value="">Pilih RW</option>'); // Clear RW options

                if (provinsiId) {
                    $.ajax({
                        url: '/get-kabupaten/' + provinsiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kabupaten').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching Kabupaten data:', error);
                        }
                    });
                }
            }

            // Set Provinsi secara otomatis ke Jawa Barat dan load Kabupaten
            var provinsiSelect = $('#provinsi');
            var provinsiId = provinsiSelect.val(); // Ambil nilai saat ini di dropdown provinsi

            if (!provinsiId) {
                // Jika provinsi belum dipilih, otomatis set ke Jawa Barat
                provinsiSelect.val(jawaBaratId).trigger('change');
                loadKabupaten(jawaBaratId); // Panggil fungsi untuk load Kabupaten berdasarkan Jawa Barat
            } else if (provinsiId == jawaBaratId) {
                // Jika Provinsi sudah dipilih Jawa Barat, langsung load Kabupaten
                loadKabupaten(jawaBaratId);
            }

            // Handle Provinsi change secara manual
            $('#provinsi').change(function() {
                var selectedProvinsiId = $(this).val();
                loadKabupaten(selectedProvinsiId);
            });

            // Handle Kabupaten change
            $('#kabupaten').change(function() {
                var kabupatenId = $(this).val();
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                $('#rw').empty().append('<option value="">Pilih RW</option>'); // Clear RW options

                if (kabupatenId) {
                    $.ajax({
                        url: '/get-kecamatan/' + kabupatenId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Handle Kecamatan change
            $('#kecamatan').change(function() {
                var kecamatanId = $(this).val();
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                $('#rw').empty().append('<option value="">Pilih RW</option>'); // Clear RW options

                if (kecamatanId) {
                    $.ajax({
                        url: '/get-kelurahan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kelurahan').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Handle Kelurahan change and fetch RW data
            $('#kelurahan').change(function() {
                var kelurahanId = $(this).val();
                $('#rw').empty().append('<option value="">Pilih RW</option>'); // Clear previous RW options

                if (kelurahanId) {
                    // Fetch RW data via AJAX
                    $.ajax({
                        url: '/get-rw/' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#rw').append('<option value="' + value.rw + '">' + value.rw + '</option>');
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching RW data:', error);
                        }
                    });
                }
            });
        });
    </script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
    <!-- Tambahkan sebelum tag penutup </body> HTML -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="{{ asset('json_wilayah/map.js') }}"></script>
@endsection
