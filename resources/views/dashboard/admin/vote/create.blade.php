@extends('layouts.dashboard.app')

@section('title', 'Pilkada | {{ $title }}')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $type }} {{ $title }}</h3>
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
                    <a href="{{ route('candidate.index') }}">{{ $type }}</a>
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
                    <form action="{{ route('vote.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="vote_count">Vote</label>
                                        <input type="text" name="vote_count" class="form-control" id="vote_count" required />
                                    </div>
                                </div>
                    
                                <!-- Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="candidate_id">Candidat</label>
                                        <select name="candidate_id" class="form-control" id="candidate_id" required>
                                            <option value="" selected disabled>Pilih Candidate</option>
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }} / {{ $candidate->partai->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                    
                                <!-- Provinsi -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="provinsi_id">Provinsi</label>
                                        <select name="provinsi_id" class="form-control" id="provinsi_id" required>
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
                                        <select name="kabupaten_id" class="form-control" id="kabupaten_id" required>
                                            <option value="" selected disabled>Pilih Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                    
                                <!-- Kecamatan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kecamatan_id">Kecamatan</label>
                                        <select name="kecamatan_id" class="form-control" id="kecamatan_id" required>
                                            <option value="" selected disabled>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                    
                                <!-- Kelurahan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kelurahan_id">Kelurahan</label>
                                        <select name="kelurahan_id" class="form-control" id="kelurahan_id" required>
                                            <option value="" selected disabled>Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                    
                                <!-- TPS -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="polling_place_id">Nama TPS</label>
                                        <select name="polling_place_id" class="form-control" id="polling_place_id" required>
                                            <option value="" selected disabled>Pilih TPS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('candidate.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('provinsi_id').addEventListener('change', function () {
            let provinsi_id = this.value;
            fetch(`/get-kabupatens/${provinsi_id}`)
                .then(response => response.json())
                .then(data => {
                    let kabupatenSelect = document.getElementById('kabupaten_id');
                    kabupatenSelect.innerHTML = '<option value="" selected disabled>Pilih Kabupaten</option>';
                    data.forEach(kabupaten => {
                        kabupatenSelect.innerHTML += `<option value="${kabupaten.id}">${kabupaten.name}</option>`;
                    });
                    document.getElementById('kecamatan_id').innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
                    document.getElementById('kelurahan_id').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
                    document.getElementById('polling_place_id').innerHTML = '<option value="" selected disabled>Pilih TPS</option>';
                });
        });
    
        document.getElementById('kabupaten_id').addEventListener('change', function () {
            let kabupaten_id = this.value;
            fetch(`/get-kecamatans/${kabupaten_id}`)
                .then(response => response.json())
                .then(data => {
                    let kecamatanSelect = document.getElementById('kecamatan_id');
                    kecamatanSelect.innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
                    data.forEach(kecamatan => {
                        kecamatanSelect.innerHTML += `<option value="${kecamatan.id}">${kecamatan.name}</option>`;
                    });
                    document.getElementById('kelurahan_id').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
                    document.getElementById('polling_place_id').innerHTML = '<option value="" selected disabled>Pilih TPS</option>';
                });
        });
    
        document.getElementById('kecamatan_id').addEventListener('change', function () {
            let kecamatan_id = this.value;
            fetch(`/get-kelurahans/${kecamatan_id}`)
                .then(response => response.json())
                .then(data => {
                    let kelurahanSelect = document.getElementById('kelurahan_id');
                    kelurahanSelect.innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
                    data.forEach(kelurahan => {
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}">${kelurahan.name}</option>`;
                    });
                    document.getElementById('polling_place_id').innerHTML = '<option value="" selected disabled>Pilih TPS</option>';
                });
        });
    
        document.getElementById('kelurahan_id').addEventListener('change', function () {
            let kelurahan_id = this.value;
            fetch(`/get-polling-places/${kelurahan_id}`)
                .then(response => response.json())
                .then(data => {
                    let pollingPlaceSelect = document.getElementById('polling_place_id');
                    pollingPlaceSelect.innerHTML = '<option value="" selected disabled>Pilih TPS</option>';
                    data.forEach(pollingPlace => {
                        pollingPlaceSelect.innerHTML += `<option value="${pollingPlace.id}">${pollingPlace.name}</option>`;
                    });
                });
        });
    </script>
@endsection
