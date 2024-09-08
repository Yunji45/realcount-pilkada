@extends('layouts.dashboard.app')

@section('title')
    Pilkada | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables {{ $title }}</h3>
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
                            <a href="{{ route('candidate.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                {{ $title }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Kandidat</th>
                                        <th>Nama Partai</th>
                                        <th>Nama Pemilu</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Kandidat</th>
                                        <th>Nama Partai</th>
                                        <th>Nama Pemilu</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($candidates as $candidate)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="storage/{{ $candidate->photo }}" alt="Candidate" height="100px" >
                                            </td>
                                            <td>{{ $candidate->name }}</td>
                                            <td>{{ $candidate->partai->name }}</td>
                                            <td>{{ $candidate->election->name }}</td>
                                            <td>{{ $candidate->vision }}</td>
                                            <td>{{ $candidate->mision }}</td>

                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol Edit dengan ikon pensil -->
                                                    <a href="{{ route('candidate.edit', $candidate->id) }}" class="btn btn-warning btn-sm" style="margin-right:10px">
                                                        <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                                    </a>

                                                    <!-- Tombol Delete dengan ikon tong sampah -->
                                                    <form action="{{ route('candidate.destroy', $candidate->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Candidate?')">
                                                            <i class="fas fa-trash-alt"></i> <!-- Ikon Delete -->
                                                        </button>
                                                    </form>
                                                </div>
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
