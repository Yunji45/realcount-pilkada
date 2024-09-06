@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Edit TPS')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit {{ $title }}</h3>
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
                    <a href="#">{{ $type }}</a>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form {{ $title }}</div>
                    </div>
                    <form action="{{ route('tps.update', $tp->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama TPS</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $tp->name) }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="provinsi_id">Provinsi</label>
                                        <select class="form-select" name="provinsi_id" id="provinsi_id">
                                            @foreach ($provinsi as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ $tp->provinsi_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kabupaten_id">Kabupaten</label>
                                        <select class="form-select" name="kabupaten_id" id="kabupaten_id">
                                            @foreach ($kabupaten as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ $tp->kabupaten_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan_id">Kecamatan</label>
                                        <select class="form-select" name="kecamatan_id" id="kecamatan_id">
                                            @foreach ($kecamatan as $kec)
                                                <option value="{{ $kec->id }}"
                                                    {{ $tp->kecamatan_id == $kec->id ? 'selected' : '' }}>
                                                    {{ $kec->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kelurahan_id">Kelurahan</label>
                                        <select class="form-select" name="kelurahan_id" id="kelurahan_id">
                                            @foreach ($kelurahan as $kel)
                                                <option value="{{ $kel->id }}"
                                                    {{ $tp->kelurahan_id == $kel->id ? 'selected' : '' }}>
                                                    {{ $kel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ old('start_date', $tp->start_date) }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            value="{{ old('end_date', $tp->end_date) }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="start_time">Jam Buka</label>
                                        <input type="time" name="start_time" class="form-control" id="start_time"
                                            value="{{ old('start_time', $tp->start_time) }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="end_time">Jam Tutup</label>
                                        <input type="time" name="end_time" class="form-control" id="end_time"
                                            value="{{ old('end_time', $tp->end_time) }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="Aktif" {{ $tp->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="Non-aktif" {{ $tp->status == 'Non-aktif' ? 'selected' : '' }}>
                                                Nonaktif
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('tps.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load kabupaten when provinsi is selected
            $('#provinsi_id').on('change', function() {
                var provinsiID = $(this).val();
                if (provinsiID) {
                    $.ajax({
                        url: '/get-kabupaten/' + provinsiID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kabupaten_id').empty();
                            $('#kabupaten_id').append(
                                '<option value="">Pilih Kabupaten</option>');
                            $.each(data, function(key, value) {
                                $('#kabupaten_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kabupaten_id').empty();
                }
            });

            // Load kecamatan when kabupaten is selected
            $('#kabupaten_id').on('change', function() {
                var kabupatenID = $(this).val();
                if (kabupatenID) {
                    $.ajax({
                        url: '/get-kecamatan/' + kabupatenID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kecamatan_id').empty();
                            $('#kecamatan_id').append(
                                '<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kecamatan_id').empty();
                }
            });

            // Load kelurahan when kecamatan is selected
            $('#kecamatan_id').on('change', function() {
                var kecamatanID = $(this).val();
                if (kecamatanID) {
                    $.ajax({
                        url: '/get-kelurahan/' + kecamatanID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append(
                                '<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, value) {
                                $('#kelurahan_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                }
            });
        });
    </script>
@endsection
