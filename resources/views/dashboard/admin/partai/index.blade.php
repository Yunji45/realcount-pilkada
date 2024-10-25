@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard.perorangan') }}">
                        <i class="icon-home"></i>
                    </a>
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
                    @can('Create Partai')
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data {{ $title }}</h4>
                                <a href="{{ route('partai.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    {{ $title }}
                                </a>
                            </div>
                        </div>
                    @endcan

                    <div class="card-body">
                        <form id="massDeleteForm" action="{{ route('partai.massDelete') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                @can('Delete Partai')
                                    <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px"
                                        id="deleteSelected">
                                        Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan

                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @can('Delete Partai')
                                                <th><input type="checkbox" id="selectAll"></th> <!-- Checkbox for select all -->
                                            @endcan
                                            <th>No</th>
                                            <th>Logo</th>
                                            <th>Nama Partai</th>
                                            <th>Pimpinan</th>
                                            <th>Warna Partai</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Logo</th>
                                            <th>Nama Partai</th>
                                            <th>Pimpinan</th>
                                            <th>Warna Partai</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($partais as $partai)
                                            <tr>
                                                @can('Delete Partai')
                                                    <td><input type="checkbox" name="selected_ids[]" value="{{ $partai->id }}"
                                                            class="selectBox"></td> <!-- Checkbox for each entry -->
                                                @endcan
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ Storage::url($partai->logo) }}" alt="Partai Logo"
                                                        height="100px"
                                                        style="border-radius: 10px; width:100px; height:100px;">
                                                </td>
                                                <td>{{ $partai->name }}</td>
                                                <td>{{ $partai->leader }}</td>
                                                <td>
                                                    <div
                                                        style="width: 30px; height: 30px; background-color: {{ $partai->color }}; border: 1px solid #000;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @can('Edit Partai')
                                                            <a href="{{ route('partai.edit', $partai->id) }}"
                                                                class="btn btn-warning btn-sm" style="margin-right:10px">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('Delete Partai')
                                                            <form action="{{ route('partai.destroy', $partai->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this Partai?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
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

                </div>
            </div>
        </div>
    </div>
@endsection
