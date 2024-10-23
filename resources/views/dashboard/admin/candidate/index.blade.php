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
                    <div class="card-header">
                        @can('Create Candidate')
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data {{ $title }}</h4>
                                <a href="{{ route('candidate.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    {{ $title }}
                                </a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('candidates.massDelete') }}" method="POST" id="mass-delete-form">
                                @csrf
                                @method('DELETE')
                                @can('Delete Candidate')
                                    <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px"
                                        id="deleteSelected" disabled>Delete Selected &nbsp;&nbsp;<i
                                            class="fas fa-trash-alt"></i></button>
                                @endcan

                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @can('Delete Candidate')
                                                <th><input type="checkbox" id="selectAll"></th>
                                            @endcan
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Kandidat</th>
                                            <th>Nama Partai</th>
                                            <th>Nama Pemilu</th>
                                            <th>Visi</th>
                                            <th>Misi</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Kandidat</th>
                                            <th>Nama Partai</th>
                                            <th>Nama Pemilu</th>
                                            <th>Visi</th>
                                            <th>Misi</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($candidates as $candidate)
                                            <tr>
                                                @can('Delete Candidate')
                                                    <td><input type="checkbox" name="selected_ids[]"
                                                            value="{{ $candidate->id }}" class="select-item"></td>
                                                @endcan
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="storage/{{ $candidate->photo }}" alt="Candidate"
                                                        height="100px"></td>
                                                <td>{{ $candidate->name }}</td>
                                                <td>{{ $candidate->partai->name }}</td>
                                                <td>{{ $candidate->election->name }}</td>
                                                <td>{{ $candidate->vision }}</td>
                                                <td>{{ $candidate->mision }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @can('Edit Candidate')
                                                            <a href="{{ route('candidate.edit', $candidate->id) }}"
                                                                class="btn btn-warning btn-sm" style="margin-right:10px">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('Delete Candidate')
                                                            <form action="{{ route('candidate.destroy', $candidate->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this Candidate?')">
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
                            </form>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteButton = document.getElementById('deleteSelected');
                            const checkboxes = document.querySelectorAll('.select-item');
                            const selectAll = document.getElementById('selectAll');
                            const form = document.getElementById('mass-delete-form');

                            // Toggle delete button based on selection
                            function toggleDeleteButton() {
                                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                                deleteButton.disabled = !anyChecked;
                            }

                            // Select all checkboxes
                            selectAll.addEventListener('change', function() {
                                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                                toggleDeleteButton();
                            });

                            // Monitor individual checkbox changes
                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', toggleDeleteButton);
                            });

                            // Delete selected action with SweetAlert2
                            deleteButton.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the form from submitting

                                var checkedBoxes = document.querySelectorAll('.select-item:checked'); // Get checked boxes

                                if (checkedBoxes.length === 0) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Candidates Selected',
                                        text: 'Please select at least one candidate to delete.',
                                        confirmButtonText: 'OK'
                                    });
                                    return;
                                }

                                // SweetAlert2 confirmation
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete them!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit(); // Proceed with form submission if confirmed
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection
