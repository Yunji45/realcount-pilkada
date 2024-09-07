@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Kegiatan List')

@section('content')
<div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">DataTables.{{ $title }}</h3>
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
          <a href="#">{{ $type }}</a>
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
              <div class="d-flex align-items-center">
                <h4 class="card-title">Add {{ $title }}</h4>
                <a href="{{ route('kegiatan.create') }}"
                  class="btn btn-primary btn-round ms-auto"
                >
                  <i class="fa fa-plus"></i>
                  {{ $title }}
                </a>
              </div>
            </div>
            <div class="card-body">                

              <div class="table-responsive">
                <table
                  id="add-row"
                  class="display table table-striped table-hover"
                >
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu</th>
                        <th>Deskripsi</th>
                        <th>Photo</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu</th>
                        <th>Deskripsi</th>
                        <th>Photo</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($kegiatans as $kegiatan)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $kegiatan->nama_kegiatan }}</td>
                            <td>{{ $kegiatan->waktu }}</td>
                            <td>{{ $kegiatan->deskripsi }}</td>
                            <td>
                                @if($kegiatan->photo)
                                  <img src="{{ asset('storage/' . $kegiatan->photo) }}" alt="{{ $kegiatan->nama_kegiatan }}" width="100">
                                @else
                                  No image
                                @endif
                            </td>
                            <td>{{ $kegiatan->longitude }}</td>
                            <td>{{ $kegiatan->latitude }}</td>
                            <td>
                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
        
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
  </div>
</div>
@endsection
