@extends('layouts.dashboard.app')

@section('title', 'Pilkada |  Kegiatan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Kegiatan</h3>
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
                <a href="#">{{ $type }}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Kegiatan</div>
                </div>
                <form action="{{  route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($kegiatan))
                        @method('PUT')
                    @endif
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
                                        value=""
                                        placeholder="Enter Nama Kegiatan"
                                    />
                                    @error('nama_kegiatan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="waktu">Waktu</label>
                                    <input
                                        type="date"
                                        name="waktu"
                                        class="form-control"
                                        id="waktu"
                                        value=""
                                        placeholder="Enter Waktu"
                                    />
                                    @error('waktu')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea
                                        name="deskripsi"
                                        class="form-control"
                                        id="deskripsi"
                                        placeholder="Enter Deskripsi"
                                    ></textarea>
                                    @error('deskripsi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input
                                        type="file"
                                        name="photo"
                                        class="form-control"
                                        id="photo"
                                    />
                                    @error('photo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                                        value=""
                                        placeholder="Enter Longitude"
                                    />
                                    @error('longitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input
                                        type="text"
                                        name="latitude"
                                        class="form-control"
                                        id="latitude"
                                        value=""
                                        placeholder="Enter Latitude"
                                    />
                                    @error('latitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
