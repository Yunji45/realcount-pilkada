@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | {{ $type }} {{ $title }}')

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
                    <a href="{{ route('election.index') }}">{{ $title }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $type }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form {{ $type }} {{ $title }}</div>
                    </div>
                    <form action="{{ route('election.update', $election->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Gunakan method PUT untuk update data -->

                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama Partai</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ $election->name }}" required />
                                    </div>
                                </div>

                                <!-- Jenis Pemilu -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Jenis Pemilu</label>
                                        <select class="form-select" name="type" id="type" required>
                                            <option value="" disabled {{ old('type', $election->type) === '' ? 'selected' : '' }}>
                                                Pilih Jenis Pemilu</option>
                                            <option value="Perorang"
                                                {{ old('type', $election->type) === 'Perorang' ? 'selected' : '' }}>Perorang</option>
                                            <option value="Partai" {{ old('type', $election->type) === 'Partai' ? 'selected' : '' }}>
                                                Partai</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ $election->start_date }}" required />
                                    </div>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            value="{{ $election->end_date }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('election.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
