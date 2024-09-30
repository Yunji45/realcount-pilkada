@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Detail TPS')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $tps_realcount->name }} - Detail TPS</h3>
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
                    <a href="{{ route('tps-realcount.index') }}">TPS</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $tps_realcount->name }}</a>
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
                                <p><strong>Nama TPS:</strong> {{ $tps_realcount->name }}</p>
                                <p><strong>Provinsi:</strong> {{ $tps_realcount->provinsi->name }}</p>
                                <p><strong>Kabupaten:</strong> {{ $tps_realcount->kabupaten->name }}</p>
                                <p><strong>Kecamatan:</strong> {{ $tps_realcount->kecamatan->name }}</p>
                                <p><strong>Kelurahan:</strong> {{ $tps_realcount->kelurahan->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Mulai:</strong>
                                    {{ \Carbon\Carbon::parse($tps_realcount->start_date)->format('d-m-Y') }}</p>
                                <p><strong>Tanggal Selesai:</strong>
                                    {{ \Carbon\Carbon::parse($tps_realcount->end_date)->format('d-m-Y') }}</p>
                                <p><strong>Jam Buka:</strong>
                                    {{ \Carbon\Carbon::parse($tps_realcount->start_time)->format('H:i') }}</p>
                                <p><strong>Jam Tutup:</strong>
                                    {{ \Carbon\Carbon::parse($tps_realcount->end_time)->format('H:i') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($tps_realcount->status) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('tps-realcount.edit', $tps_realcount->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tps-realcount.destroy', $tps_realcount->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('tps-realcount.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
