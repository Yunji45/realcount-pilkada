@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $type }} {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $type }} {{ $title }}</h3>
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
                    <a href="{{ route('vote.index') }}">{{ $type }}</a>
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
                        <div class="card-title">Form {{ $type }} {{ $title }}</div>
                    </div>
                    {{-- <form action="{{ route('vote.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Vote</label>
                                        <input type="text" name="vote_count" class="form-control" id="vote_count" required />
                                    </div>
                                </div>

                                <!-- Partai -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="partai_id">Candidat</label>
                                        <select name="candidate_id" class="form-control" id="candidate_id" required>
                                            <option value="" selected disabled>Pilih Candidate</option>
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Pemilu -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="election_id">Nama TPS</label>
                                        <select name="polling_place_id" class="form-control" id="polling_place_id" required>
                                            <option value="" selected disabled>Pilih TPS</option>
                                            @foreach ($pollingPlaces as $polling)
                                                <option value="{{ $polling->id }}">{{ $polling->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('candidate.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form> --}}
                    <form action="{{ route('vote.update', $vote->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="vote_count">Vote</label>
                                        <input type="text" name="vote_count" class="form-control" id="vote_count"
                                            value="{{ old('vote_count', $vote->vote_count) }}" />
                                    </div>
                                </div>

                                <!-- Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="candidate_id">Candidat</label>
                                        <select name="candidate_id" class="form-control" id="candidate_id">
                                            <option value="{{ $vote->candidate_id }}" selected disabled>
                                                {{ $vote->candidate->partai->name }}</option>
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }} /
                                                    {{ $candidate->partai->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Provinsi -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="provinsi_id">Provinsi</label>
                                        <select name="provinsi_id" class="form-control" id="provinsi">
                                            <option value="" selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kabupaten_id">Kabupaten</label>
                                        <select name="kabupaten_id" class="form-control" id="kabupaten">
                                            <option value="" selected disabled>Pilih Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kecamatan_id">Kecamatan</label>
                                        <select name="kecamatan_id" class="form-control" id="kecamatan">
                                            <option value="" selected disabled>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kelurahan_id">Kelurahan</label>
                                        <select name="kelurahan_id" class="form-control" id="kelurahan">
                                            <option value="" selected disabled>Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- TPS -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="polling_place_id">Nama TPS</label>
                                        <select name="polling_place_id" class="form-control" id="polling_place">
                                            <option value="" selected disabled>Pilih TPS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('vote.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>

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

            $('#kelurahan').change(function() {
                var kelurahanId = $(this).val();
                $('#polling_place').empty().append('<option value="">Pilih TPS</option>');
                if (kelurahanId) {
                    $.ajax({
                        url: '/get-polling-places/' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#polling_place').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
