@extends('layouts.dashboard.app')

@section('title')
My Gerindra | Data Role
@endsection

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
                        <a href="{{ route('role.create') }}" class="btn btn-primary btn-round ms-auto">
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
                                    <th>Name</th>
                                    <th>Description</th> <!-- Or another attribute from Role -->
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($role->permissions->isEmpty())
                                            <span>No Permissions Assigned</span>
                                        @else
                                            <div class="permissions-container">
                                                <ul class="list-group">
                                                    @foreach($role->permissions as $permission)
                                                    <li class="list-group-item">{{ $permission->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('role.edit', $role->id) }}"
                                                class="btn btn-warning btn-sm" style="margin-right:10px">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this Partai?')">
                                                    <i class="fas fa-trash-alt"></i>
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

<style>
    /* Style for permissions container */
    .permissions-container {
        max-height: 150px; /* Set a maximum height */
        overflow-y: auto; /* Add vertical scroll */
        margin-top: 5px; /* Add some margin */
    }

    /* Style for list items */
    .list-group-item {
        padding: 5px 10px; /* Reduce padding for better fit */
        border: none; /* Remove border */
    }

    /* Optional: Add hover effect */
    .list-group-item:hover {
        background-color: #f1f1f1; /* Light grey background on hover */
    }
</style>
@endsection
