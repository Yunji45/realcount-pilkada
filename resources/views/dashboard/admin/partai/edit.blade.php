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
                    <a href="{{ route('partai.index') }}">{{ $title }}</a>
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
                    <form action="{{ route('partai.update', $partai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Gunakan method PUT untuk update data -->

                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama Partai</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ $partai->name }}" required />
                                    </div>
                                </div>

                                <!-- Pemimpin Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="leader">Pemimpin Partai</label>
                                        <input type="text" name="leader" class="form-control" id="leader"
                                            value="{{ $partai->leader }}" required />
                                    </div>
                                </div>

                                <!-- Warna Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="color">Warna Partai</label>
                                        <input type="color" name="color" class="form-control" id="color"
                                            value="{{ $partai->color }}" required />
                                    </div>
                                </div>

                                <!-- Logo Partai -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="logo">Logo Partai (Opsional)</label>
                                        <input type="file" name="logo" class="form-control" id="logo" />
                                        @if ($partai->logo)
                                            <small>Logo saat ini:</small><br>
                                            <img src="{{ asset('storage/' . $partai->logo) }}"
                                                alt="Logo {{ $partai->name }}" style="width: 100px; height: 100px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('partai.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
