@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Edit Kegiatan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Kegiatan</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Kegiatan</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ $type ?? 'Tambah' }}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Kegiatan</div>
                </div>
                <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <!-- Nama Kegiatan -->
                                <div class="form-group">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <input
                                        type="text"
                                        name="nama_kegiatan"
                                        class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                        id="nama_kegiatan"
                                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
                                        placeholder="Masukkan Nama Kegiatan"
                                    />
                                    @error('nama_kegiatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Waktu -->
                                <div class="form-group">
                                    <label for="waktu">Waktu</label>
                                    <input
                                        type="date"
                                        name="waktu"
                                        class="form-control @error('waktu') is-invalid @enderror"
                                        id="waktu"
                                        value="{{ old('waktu', $kegiatan->waktu) }}"
                                    />
                                    @error('waktu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea
                                        name="deskripsi"
                                        class="form-control @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi"
                                        placeholder="Masukkan Deskripsi"
                                    >{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Photo -->
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input
                                        type="file"
                                        name="photo"
                                        class="form-control @error('photo') is-invalid @enderror"
                                        id="photo"
                                    />
                                    @if($kegiatan->photo)
                                        <img src="{{ asset('storage/' . $kegiatan->photo) }}" alt="Current Photo" style="width: 150px; height: auto;">
                                    @endif
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <!-- Longitude -->
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input
                                        type="text"
                                        name="longitude"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude"
                                        value="{{ old('longitude', $kegiatan->longitude) }}"
                                        placeholder="Masukkan Longitude"
                                    />
                                    @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Latitude -->
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input
                                        type="text"
                                        name="latitude"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude"
                                        value="{{ old('latitude', $kegiatan->latitude) }}"
                                        placeholder="Masukkan Latitude"
                                    />
                                    @error('latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
