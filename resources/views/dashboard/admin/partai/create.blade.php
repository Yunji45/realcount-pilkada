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
                    <a href="{{ route('partai.index') }}">{{ $type }}</a>
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
                    <form action="{{ route('partai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama Partai</label>
                                        <input type="text" name="name" class="form-control" id="name" required />
                                    </div>
                                </div>

                                <!-- Pemimpin Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="leader">Pemimpin Partai</label>
                                        <input type="text" name="leader" class="form-control" id="leader" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="color">Warna Partai</label>
                                        <input type="color" name="color" class="form-control" id="color" required />
                                    </div>
                                </div>

                                <!-- Logo Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="logo">Logo Partai (Opsional)</label>
                                        <input type="file" name="logo" class="form-control" id="logo" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('partai.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
