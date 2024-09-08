{{-- resources/views/layouts/dashboard.blade.php --}}
@extends('layouts.dashboard.app')

@section('content')
    @if (auth()->user()->hasRole('Admin'))
        @include('dashboard.admin.dashboard.index')
    @elseif (auth()->user()->hasRole('Super Admin'))
        @include('dashboard.superadmin.dashboard.index')
    @elseif (auth()->user()->hasRole('Relawan RDW'))
        @include('dashboard.relawan.dashboard.index')
    @elseif (auth()->user()->hasRole('Saksi'))
        @include('dashboard.saksi.dashboard.index')
    @elseif (auth()->user()->hasRole('Koordinator'))
        @include('dashboard.koordinator.dashboard.index')
    @elseif (auth()->user()->hasRole('Pimpinan'))
        @include('dashboard.pimpinan.dashboard.index')
    @elseif (auth()->user()->hasRole('Pemilih'))
        @include('dashboard.pemilih.dashboard.index')
    @elseif (auth()->user()->hasRole('Simpatisan'))
        @include('dashboard.simpatisan.dashboard.index')
    @elseif (auth()->user()->hasRole('Lain-lain'))
        @include('dashboard.lain-lain.dashboard.index')

    @else
        {{-- @include('dashboard.superadmin.dashboard.index') --}}
    @endif
@endsection
