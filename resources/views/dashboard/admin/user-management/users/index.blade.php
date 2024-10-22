@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | Data User
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
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                {{ $title }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('user.index') }}" class="mb-4">
                            <div class="row g-0 align-items-center">
                                <!-- Ganti g-2 menjadi g-0 untuk menghilangkan jarak -->
                                <!-- Role Filter -->
                                <div class="col-md-3">
                                    <div class="form-group mb-0" style="width: 300px"> <!-- Hapus margin bawah -->
                                        <select name="role" id="role" class="form-control">
                                            <option value="">-- Semua Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ request('role') == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-3">
                                    <div class="form-group mb-0"> <!-- Hapus margin bawah -->
                                        <select name="status" id="status" class="form-control">
                                            <option value="">-- Semua Status --</option>
                                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                                Aktif
                                            </option>
                                            <option value="Tidak Aktif"
                                                {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-6 d-flex justify-content-end align-items-center">
                                    <!-- Tambahkan align-items-center -->
                                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <form id="massDeleteForm" action="{{ route('users.massDelete') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px"
                                    id="deleteSelected">
                                    Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                                </button>

                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Office</th>
                                            <th>Nik</th>
                                            <th>Status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Office</th>
                                            <th>Nik</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td><input type="checkbox" name="selected_ids[]"
                                                        value="{{ $user->id }}" class="selectBox"></td>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                                                <td>{{ $user->nik }}</td>
                                                <td>{{ $user->status }}</td>

                                                <td>
                                                    <div class="form-button-action">
                                                        <!-- Tombol Edit dengan ikon pensil berwarna putih -->
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="btn btn-warning btn-sm" style="margin-right:10px">
                                                            <i class="fas fa-edit"></i>
                                                            <!-- Ikon Edit berwarna putih -->
                                                        </a>

                                                        <!-- Tombol Delete dengan ikon tong sampah -->
                                                        <form action="{{ route('user.destroy', $user->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this Partai?')">
                                                                <i class="fas fa-trash-alt"></i> <!-- Ikon Delete -->
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
            event.preventDefault(); // Prevent automatic form submission

            var form = document.getElementById('massDeleteForm'); // Select the mass delete form
            var checkedBoxes = document.querySelectorAll('.selectBox:checked'); // Selected checkboxes

            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Partai Selected',
                    text: 'Please select at least one Partai to delete.',
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

        // Select or deselect all checkboxes
        document.getElementById('selectAll').addEventListener('change', function() {
            var allCheckboxes = document.querySelectorAll('.selectBox');
            allCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
