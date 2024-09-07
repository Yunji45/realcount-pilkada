{{-- resources/views/layouts/dashboard.blade.php --}}
@extends('layouts.dashboard.app')

@section('content')
    @if (auth()->user()->hasRole('Admin'))
        @include('dashboard.admin.dashboard.index')
    @elseif (auth()->user()->hasRole('Relawan'))
        @include('dashboard.relawan.dashboard.index')
    @else
        @include('dashboard.superadmin.dashboard.index')
    @endif
@endsection
