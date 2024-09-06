@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Permissions')

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
                        <h4 class="card-title">Permissions List</h4>
                        <a href="{{ route('permission.create') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Add Permission
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
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
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
