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
                            <a href="{{ route('vote.create') }}" class="btn btn-primary btn-round ms-auto">
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
                                        <th>Nama Candidat</th>
                                        <th>Nama TPS</th>
                                        <th>Nama Partai</th>
                                        <th>Nama Pemilu</th>
                                        <th>Vote</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Candidat</th>
                                        <th>Nama TPS</th>
                                        <th>Nama Partai</th>
                                        <th>Nama Pemilu</th>
                                        <th>Vote</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($votes as $vote)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vote->candidate->name }}</td>
                                            <td>{{ $vote->polling_place->name }}</td>
                                            <td>{{ $vote->candidate->partai->name }}</td>
                                            <td>{{ $vote->candidate->election->name }}</td>
                                            <td>{{ $vote->vote_count }}</td>

                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol Edit dengan ikon pensil -->
                                                    <a href="{{ route('vote.edit', $vote->id) }}" class="btn btn-warning btn-sm" style="margin-right:10px">
                                                        <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                                    </a>

                                                    <!-- Tombol Delete dengan ikon tong sampah -->
                                                    <form action="{{ route('vote.destroy', $vote->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Vote?')">
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