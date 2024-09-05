@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Edit Kegiatan')

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
                                <div class="form-group">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <input
                                        type="text"
                                        name="nama_kegiatan"
                                        class="form-control"
                                        id="nama_kegiatan"
                                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
                                        placeholder="Masukkan Nama Kegiatan"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="waktu">Waktu</label>
                                    <input
                                        type="date"
                                        name="waktu"
                                        class="form-control"
                                        id="waktu"
                                        value="{{ old('waktu', $kegiatan->waktu) }}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea
                                        name="deskripsi"
                                        class="form-control"
                                        id="deskripsi"
                                        placeholder="Masukkan Deskripsi"
                                    >{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input
                                        type="file"
                                        name="photo"
                                        class="form-control"
                                        id="photo"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input
                                        type="text"
                                        name="longitude"
                                        class="form-control"
                                        id="longitude"
                                        value="{{ old('longitude', $kegiatan->longitude) }}"
                                        placeholder="Masukkan Longitude"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input
                                        type="text"
                                        name="latitude"
                                        class="form-control"
                                        id="latitude"
                                        value="{{ old('latitude', $kegiatan->latitude) }}"
                                        placeholder="Masukkan Latitude"
                                    />
                                </div>
                            </div>
                        </div>
                    </div> 
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
