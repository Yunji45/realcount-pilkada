{{-- resources/views/layouts/dashboard.blade.php --}}
@extends('layouts.dashboard.app')

@section('content')
    @if (auth()->user()->hasRole('Admin'))
        @include('dashboard.admin.dashboard.index')
    @elseif (auth()->user()->hasRole('Super Admin'))
        @include('dashboard.superadmin.dashboard.index')
    {{-- @elseif (auth()->user()->hasRole('Relawan RDW'))
        @include('landingpage.index')
    @elseif (auth()->user()->hasRole('Saksi'))
        @include('landingpage.index') --}}
    @elseif (auth()->user()->hasRole('Koordinator'))
        @include('dashboard.koordinator.dashboard.index')
    @elseif (auth()->user()->hasRole('Pimpinan'))
        @include('dashboard.pimpinan.dashboard.index')
    {{-- @elseif (auth()->user()->hasRole('Pemilih'))
        @include('landingpage.index')
    @elseif (auth()->user()->hasRole('Simpatisan'))
        @include('landingpage.index')
    @elseif (auth()->user()->hasRole('Lain-lain'))
        @include('landingpage.index') --}}
    @else
        @include('landingpage.app')
    @endif
@endsection
