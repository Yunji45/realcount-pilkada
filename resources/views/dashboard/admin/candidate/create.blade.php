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
                    <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Nama Kandidat</label>
                                        <input type="text" name="name" class="form-control" id="name" required />
                                    </div>
                                </div>

                                <!-- Partai -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="partai_id">Partai</label>
                                        <select name="partai_id" class="form-control" id="partai_id" required>
                                            <option value="" selected disabled>Pilih partai</option>
                                            @foreach ($partais as $partai)
                                                <option value="{{ $partai->id }}">{{ $partai->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Pemilu -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="election_id">Nama Pemilu</label>
                                        <select name="election_id" class="form-control" id="election_id" required>
                                            <option value="" selected disabled>Pilih pemilu</option>
                                            @foreach ($elections as $election)
                                                <option value="{{ $election->id }}">{{ $election->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Visi -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="vision">Visi</label>
                                        <textarea name="vision" class="form-control" id="vision" rows="4" required></textarea>
                                    </div>
                                </div>

                                <!-- Misi -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="mision">Misi</label>
                                        <textarea name="mision" class="form-control" id="mision" rows="4" required></textarea>
                                    </div>
                                </div>

                                <!-- Foto Kandidat -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="photo">Foto Kandidat (Opsional)</label>
                                        <input type="file" name="photo" class="form-control" id="photo" />
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
@endsection
