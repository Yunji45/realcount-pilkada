@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Permissions')

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
                            <form id="massDeleteForm" action="{{ route('permissions.massDelete') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px" id="deleteSelected">
                                    Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                                </button>
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
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
                                                <td><input type="checkbox" name="selected_ids[]" value="{{ $permission->id }}" class="selectBox"></td>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-warning btn-sm" style="margin-right:10px">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE') <!-- This is for individual delete -->
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('deleteSelected').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default button behavior

            var form = document.getElementById('massDeleteForm'); // Get the form
            var checkedBoxes = document.querySelectorAll('.selectBox:checked'); // Get checked checkboxes

            if (checkedBoxes.length === 0) {
                // If no checkboxes are checked, show warning
                Swal.fire({
                    icon: 'warning',
                    title: 'No Permissions Selected',
                    text: 'Please select at least one permission to delete.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Confirm delete action with SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    </script>

@endsection
