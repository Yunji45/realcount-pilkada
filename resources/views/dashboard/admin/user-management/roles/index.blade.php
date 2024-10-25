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
                            <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px"
                                id="deleteSelected" disabled>
                                Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="massDeleteForm" action="{{ route('role.massDelete') }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th> <!-- Select All Checkbox -->
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Description</th>
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
                                                <td><input type="checkbox" class="selectItem" name="selected_ids[]"
                                                        value="{{ $role->id }}"></td>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @if ($role->permissions->isEmpty())
                                                        <span>No Permissions Assigned</span>
                                                    @else
                                                        <div class="permissions-container">
                                                            <ul class="list-group">
                                                                @foreach ($role->permissions as $permission)
                                                                    <li class="list-group-item">{{ $permission->name }}
                                                                    </li>
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

                                                        <form action="{{ route('role.destroy', $role->id) }}"
                                                            method="POST" style="display:inline-block;">
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
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const selectAllCheckboxFooter = document.getElementById('selectAllFooter');
            const checkboxes = document.querySelectorAll('.selectItem');
            const deleteSelectedBtn = document.getElementById('deleteSelected');
            const massDeleteForm = document.getElementById('massDeleteForm');

            // Select All functionality
            selectAllCheckbox.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleDeleteButton();
            });

            // Synchronize footer Select All checkbox
            selectAllCheckboxFooter.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                selectAllCheckbox.checked = this.checked;
                toggleDeleteButton();
            });

            // Toggle Delete button based on selected checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    toggleDeleteButton();
                });
            });

            function toggleDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                deleteSelectedBtn.disabled = !anyChecked;
            }

            // SweetAlert confirmation before mass delete
            deleteSelectedBtn.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            massDeleteForm.submit(); // Submit the form if confirmed
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'No items selected',
                        text: 'Please select at least one item to delete.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>

    <style>
        /* Style for permissions container */
        .permissions-container {
            max-height: 150px;
            /* Set a maximum height */
            overflow-y: auto;
            /* Add vertical scroll */
            margin-top: 5px;
            /* Add some margin */
        }

        /* Style for list items */
        .list-group-item {
            padding: 5px 10px;
            /* Reduce padding for better fit */
            border: none;
            /* Remove border */
        }

        /* Optional: Add hover effect */
        .list-group-item:hover {
            background-color: #f1f1f1;
            /* Light grey background on hover */
        }
    </style>
@endsection
