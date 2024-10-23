@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
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
                    <a href="{{ route('election.index') }}">{{ $type }}</a>
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
                    <form action="{{ route('election.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Pemilu -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama Pemilu</label>
                                        <input type="text" name="name" class="form-control" id="name" required />
                                    </div>
                                </div>

                                <!-- Jenis Pemilu -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Jenis Pemilu</label>
                                        <select class="form-select" name="type" id="type" required>
                                            <option value="" selected disabled></option>
                                            <option value="Perorang">Perorang</option>
                                            <option value="Partai">Partai</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            required />
                                    </div>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('election.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
