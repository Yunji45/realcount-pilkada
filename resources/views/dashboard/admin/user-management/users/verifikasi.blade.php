@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | Data User
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $title }}</h3>
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
                                            <th>Office</th>
                                            <th>Nik</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td><input type="checkbox" name="selected_ids[]" value="{{ $user->id }}"
                                                        class="selectBox"></td>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                                                <td>{{ $user->nik }}</td>
                                                <td>
                                                    <form action="{{ route('user.status', $user->id) }}" method="POST"
                                                        id="statusForm_{{ $user->id }}">
                                                        @csrf
                                                        <div class="custom-select-wrapper">
                                                            <select name="status" class="custom-select"
                                                                id="statusSelect_{{ $user->id }}">
                                                                <option value="Aktif"
                                                                    {{ $user->status == 'Aktif' ? 'selected' : '' }}>
                                                                    Aktif
                                                                </option>
                                                                <option value="Pending"
                                                                    {{ $user->status == 'Pending' ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                                <option value="Tidak Aktif"
                                                                    {{ $user->status == 'Tidak Aktif' ? 'selected' : '' }}>
                                                                    Tidak Aktif</option>
                                                            </select>
                                                        </div>
                                                    </form>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="confirmModal_{{ $user->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmModalLabel_{{ $user->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="confirmModalLabel_{{ $user->id }}">
                                                                        Konfirmasi
                                                                        Ubah Status</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin mengubah status menjadi
                                                                    <strong id="status-name-{{ $user->id }}"></strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="confirmButton_{{ $user->id }}">Ya, Ubah
                                                                        Status</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Toast Notification -->
                                                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                                        <div id="statusToast" class="toast" role="alert"
                                                            aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                                            <div class="toast-header">
                                                                <strong class="me-auto">Notifikasi</strong>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="toast" aria-label="Close"></button>
                                                            </div>
                                                            <div class="toast-body">
                                                                Status user berhasil diperbarui!
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        document.getElementById('statusSelect_{{ $user->id }}').addEventListener('change', function() {
                                                            let selectedOption = this.options[this.selectedIndex];
                                                            let statusName = selectedOption.text;
                                                            let statusForm = document.getElementById('statusForm_{{ $user->id }}');

                                                            // Set status name in modal
                                                            document.getElementById('status-name-{{ $user->id }}').textContent = statusName;

                                                            // Show modal
                                                            var myModal = new bootstrap.Modal(document.getElementById('confirmModal_{{ $user->id }}'));
                                                            myModal.show();

                                                            // On confirm button click
                                                            document.getElementById('confirmButton_{{ $user->id }}').onclick = function() {
                                                                // Send form using AJAX
                                                                $.ajax({
                                                                    url: statusForm.action,
                                                                    type: 'POST',
                                                                    data: $(statusForm).serialize(),
                                                                    success: function(response) {
                                                                        // Close modal
                                                                        myModal.hide();

                                                                        // Show toast notification
                                                                        var toastElement = document.getElementById('statusToast');
                                                                        var toast = new bootstrap.Toast(toastElement);
                                                                        toast.show();
                                                                    },
                                                                    error: function(xhr) {
                                                                        alert('Terjadi kesalahan, silakan coba lagi.');
                                                                    }
                                                                });
                                                            };
                                                        });
                                                    </script>
                                                </td>

                                                <td>
                                                    <div class="form-button-action">
                                                        <!-- Tombol Edit dengan ikon pensil berwarna putih -->
                                                        {{-- <a href="{{ route('user.verifikasi', $user->id) }}" title="Verifikasi"
                                                        class="btn btn-success btn-sm" style="margin-right:10px">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a> --}}
                                                        <form action="{{ route('user.verifikasi', $user->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                style="margin-right:10px">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </form>


                                                        <!-- Tombol Delete dengan ikon tong sampah -->
                                                        <form action="{{ route('user.destroy', $user->id) }}"
                                                            method="POST" style="display:inline-block;" title="Delete">
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

    <!-- Tambahkan jQuery dan Bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

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
