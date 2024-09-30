@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Edit TPS')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Leaflet Control Geocoder -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Data TPS {{ $tps_realcount->name }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tps.index') }}">TPS</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $tps_realcount->name }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit {{ $tps_realcount->name }}</div>
                        </div>
                        <form action="{{ route('tps-realcount.update',$tps_realcount->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nama TPS</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ $tps_realcount->name }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <select class="form-select" name="provinsi_id" id="provinsi">
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsi as $prov)
                                                    <option value="{{ $prov->id }}" {{ $tps_realcount->provinsi_id == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
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
                                            <label for="rw">RW</label>
                                            <input type="text" name="rw" class="form-control" id="rw" value="{{ $tps_realcount->rw }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="DPT">DPT</label>
                                            <input type="text" name="DPT" class="form-control" id="DPT" value="{{ $tps_realcount->DPT }}" />
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-lg-6">

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-select" name="status" id="status">
                                                <option value="Aktif" {{ $tps_realcount->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Non-aktif" {{ $tps_realcount->status == 'Non-aktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="periode">Periode</label>
                                            <input type="date" name="periode" class="form-control" id="periode" value="{{ $tps_realcount->periode }}" />
                                        </div>

                                        <div class="form-group">
                                            <label for="location-search">Cari Daerah:</label>
                                            <div id="map" style="height: 400px;"></div>
                                            <input type="hidden" name="latitude" id="latitude" value="{{ $tps_realcount->latitude }}">
                                            <input type="hidden" name="longitude" id="longitude" value="{{ $tps_realcount->longitude }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('tps-realcount.index') }}" class="btn btn-danger">Cancel</a>
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
            // Load Kabupaten, Kecamatan, and Kelurahan on page load based on selected values
            var selectedKabupaten = "{{ $tps_realcount->kabupaten_id }}";
            var selectedKecamatan = "{{ $tps_realcount->kecamatan_id }}";
            var selectedKelurahan = "{{ $tps_realcount->kelurahan_id }}";

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
                            if (selectedKabupaten) {
                                $('#kabupaten').val(selectedKabupaten).trigger('change');
                            }
                        }
                    });
                }
            }).trigger('change');

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
                            if (selectedKecamatan) {
                                $('#kecamatan').val(selectedKecamatan).trigger('change');
                            }
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
                            if (selectedKelurahan) {
                                $('#kelurahan').val(selectedKelurahan);
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([{{ $tps_realcount->latitude ?? '-6.200000' }}, {{ $tps_realcount->longitude ?? '106.816666' }}], 13);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Inisialisasi marker
        var marker = L.marker([{{ $tps_realcount->latitude ?? '-6.200000' }}, {{ $tps_realcount->longitude ?? '106.816666' }}], {draggable: true}).addTo(map);

        // Update koordinat saat marker digeser
        marker.on('dragend', function(e) {
            var latlng = marker.getLatLng();
            $('#latitude').val(latlng.lat);
            $('#longitude').val(latlng.lng);
        });

        // Geocoder untuk mencari lokasi
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function(e) {
            var latlng = e.geocode.center;
            marker.setLatLng(latlng).update();
            map.setView(latlng, 16);
            $('#latitude').val(latlng.lat);
            $('#longitude').val(latlng.lng);
        }).addTo(map);
    </script>
@endsection
