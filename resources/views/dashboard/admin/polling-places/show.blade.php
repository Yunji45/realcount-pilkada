@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Detail TPS')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $tp->name }} - Detail TPS</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('home') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tps.index') }}">TPS</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $tp->name }}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Informasi TPS</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama TPS:</strong> {{ $tp->name }}</p>
                                <p><strong>Provinsi:</strong> {{ $tp->provinsi->name }}</p>
                                <p><strong>Kabupaten:</strong> {{ $tp->kabupaten->name }}</p>
                                <p><strong>Kecamatan:</strong> {{ $tp->kecamatan->name }}</p>
                                <p><strong>Kelurahan:</strong> {{ $tp->kelurahan->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Mulai:</strong>
                                    {{ \Carbon\Carbon::parse($tp->start_date)->format('d-m-Y') }}</p>
                                <p><strong>Tanggal Selesai:</strong>
                                    {{ \Carbon\Carbon::parse($tp->end_date)->format('d-m-Y') }}</p>
                                <p><strong>Jam Buka:</strong>
                                    {{ \Carbon\Carbon::parse($tp->start_time)->format('H:i') }}</p>
                                <p><strong>Jam Tutup:</strong>
                                    {{ \Carbon\Carbon::parse($tp->end_time)->format('H:i') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($tp->status) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('tps.edit', $tp->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tps.destroy', $tp->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('tps.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
