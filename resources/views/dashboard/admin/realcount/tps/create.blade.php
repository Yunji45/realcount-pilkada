@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $type }} {{ $title }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Leaflet Control Geocoder -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard.perorangan') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tps.index') }}">{{ $type }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form {{ $title }}</div>
                        </div>
                        <form action="{{ route('realcount-tps.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nama TPS</label>
                                            <input type="text" name="name" class="form-control" id="name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <select class="form-select" name="provinsi_id" id="provinsi">
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsi as $prov)
                                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kabupaten">Kabupaten</label>
                                            <select class="form-select" name="kabupaten_id" id="kabupaten">
                                                <option value="">Pilih Kabupaten</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <select class="form-select" name="kecamatan_id" id="kecamatan">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kelurahan">Kelurahan</label>
                                            <select class="form-select" name="kelurahan_id" id="kelurahan">
                                                <option value="">Pilih Kelurahan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kelurahan">RW</label>
                                            <input type="text" name="rw" class="form-control" id="rw" />
                                        </div>
                                        <div class="form-group">
                                            <label for="kelurahan">DPT</label>
                                            <input type="text" name="DPT" class="form-control" id="DPT" />
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="kelurahan">Periode</label>
                                            <input type="date" name="periode" class="form-control" id="periode" />
                                        </div>

                                        <div class="form-group">
                                            <label for="location-search">Cari Daerah:</label>
                                            <div id="map" style="height: 400px;"></div>
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ route('realcount-tps.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsiId = $(this).val();
                $('#kabupaten').empty().append('<option value="">Pilih Kabupaten</option>');
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (provinsiId) {
                    $.ajax({
                        url: '/get-kabupaten/' + provinsiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kabupaten').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#kabupaten').change(function() {
                var kabupatenId = $(this).val();
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (kabupatenId) {
                    $.ajax({
                        url: '/get-kecamatan/' + kabupatenId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#kecamatan').change(function() {
                var kecamatanId = $(this).val();
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (kecamatanId) {
                    $.ajax({
                        url: '/get-kelurahan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kelurahan').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([{{ $kegiatan->latitude ?? '-6.200000' }},
            {{ $kegiatan->longitude ?? '106.816666' }}
        ], 13);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker awal
        var marker = L.marker([{{ $kegiatan->latitude ?? '-6.200000' }}, {{ $kegiatan->longitude ?? '106.816666' }}])
            .addTo(map);

        // Fungsi untuk memperbarui marker dan koordinat
        function updateMarker(lat, lng) {
            marker.setLatLng([lat, lng]);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Pindahkan marker berdasarkan klik pada peta
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            updateMarker(lat, lng);
        });

        // Tambahkan Geocoder Control untuk pencarian langsung di dalam peta
        L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                map.setView(latlng, 13);
                updateMarker(latlng.lat, latlng.lng);
            })
            .addTo(map);
    </script>
    <script>
        document.getElementById('periode').addEventListener('change', function() {
            const dateValue = this.value; // Get the date value (format: yyyy-mm-dd)
            const year = new Date(dateValue).getFullYear(); // Extract the year
            console.log('Tahun yang dipilih:', year); // Output the year
            // Anda bisa menggunakan variabel `year` sesuai kebutuhan
        });
    </script>
@endsection
