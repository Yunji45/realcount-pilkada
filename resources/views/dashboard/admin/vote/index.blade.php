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
                        @can('Create Vote')
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data {{ $title }}</h4>
                                <a href="{{ route('vote.create') }}" class="btn btn-primary btn-round ms-auto mt-3">
                                    <i class="fa fa-plus"></i>
                                    {{ $title }}
                                </a>
                            </div>
                        @endcan
                        {{-- <a href="" class="btn btn-danger btn-round ms-auto mt-3" data-bs-toggle="modal"
                            data-bs-target="#kt_customers_export_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <rect fill="#000000" opacity="0.3"
                                        transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000)"
                                        x="11" y="2" width="2" height="12" rx="1" />
                                    <path
                                        d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z"
                                        fill="#000000" fill-rule="nonzero"
                                        transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000)" />
                                </g>
                            </svg>
                            Import
                        </a> --}}
                        {{-- <a href="{{ route('vote.create') }}" class="btn btn-primary btn-round ms-auto mt-3">
                            <i class="fa fa-plus"></i>
                            {{ $title }}
                        </a> --}}
                    </div>
                    <div class="card-body">
                        <form id="massDeleteForm" action="{{ route('vote.massDelete') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table id="tableVote" class="display table table-striped table-hover">
                                    @can('Delete Vote')
                                    <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px" id="massDelete" disabled>
                                        Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                                    </button>
                                    @endcan
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll"> <!-- Checkbox untuk select all -->
                                            </th>
                                            <th>No</th>
                                            <th>ID TPS</th>
                                            <th>Nama Candidat</th>
                                            <th>Nama TPS</th>
                                            <th>Nama Partai</th>
                                            <th>Nama Pemilu</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Vote</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Data di-load melalui DataTables --}}
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        $(document).ready(function() {
                            var table = $('#tableVote').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: "{{ route('vote.index') }}", // URL untuk memuat data dari server
                                columns: [
                                    {   // Checkbox untuk setiap baris
                                        data: null,
                                        render: function(data, type, row) {
                                            return `<input type="checkbox" class="vote-checkbox" value="${row.id}" name="ids[]">`;
                                        }
                                    },
                                    {   // Nomor urut
                                        data: null,
                                        render: function(data, type, row, meta) {
                                            var start = table.page.info().start;
                                            return start + meta.row + 1;
                                        }
                                    },
                                    { data: 'polling_place_id' },
                                    { data: 'candidate.name' },
                                    { data: 'polling_place.name' },
                                    { data: 'candidate.partai.name' },
                                    { data: 'candidate.election.name' },
                                    { data: 'polling_place.kecamatan.name' },
                                    { data: 'polling_place.kelurahan.name' },
                                    { data: 'vote_count' },
                                    {   // Tombol Aksi untuk Edit dan Hapus
                                        data: null,
                                        render: function(data, type, row) {
                                            return `
                                                <div class="form-button-action">
                                                    @can('Edit Vote')
                                                    <a href="/vote/${row.id}/edit" class="btn btn-warning btn-sm" style="margin-right:10px">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('Delete Vote')
                                                    <form action="/vote/${row.id}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Vote?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>`;
                                        }
                                    }
                                ]
                            });

                            // Event listener untuk checkbox select all
                            $('#selectAll').on('click', function() {
                                var rows = table.rows({ 'search': 'applied' }).nodes();
                                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                                toggleBulkDeleteButton();
                            });

                            // Event listener untuk checkbox per baris
                            $('#tableVote tbody').on('change', 'input[type="checkbox"]', function() {
                                if (!this.checked) {
                                    var el = $('#selectAll').get(0);
                                    if (el && el.checked && ('indeterminate' in el)) {
                                        el.indeterminate = true;
                                    }
                                }
                                toggleBulkDeleteButton();
                            });

                            // Aktifkan/nonaktifkan tombol bulk delete
                            function toggleBulkDeleteButton() {
                                var selected = [];
                                $('#tableVote tbody input[type="checkbox"]:checked').each(function() {
                                    selected.push($(this).val());
                                });

                                if (selected.length > 0) {
                                    $('#massDelete').prop('disabled', false);
                                } else {
                                    $('#massDelete').prop('disabled', true);
                                }
                            }

                            // Konfirmasi penghapusan massal
                            $('#massDelete').on('click', function() {
                                var selectedIds = [];
                                $('#tableVote tbody input[type="checkbox"]:checked').each(function() {
                                    selectedIds.push($(this).val());
                                });

                                if (selectedIds.length === 0) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Votes Selected',
                                        text: 'Please select at least one vote to delete.',
                                        confirmButtonText: 'OK'
                                    });
                                    return;
                                }

                                // Konfirmasi SweetAlert2
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
                                        // Kirim permintaan AJAX ke server
                                        $.ajax({
                                            url: "{{ route('vote.massDelete') }}",
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                selected_ids: selectedIds
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Deleted!',
                                                    text: response.message,
                                                    confirmButtonText: 'OK'
                                                }).then(() => {
                                                    location.reload(); // Refresh halaman
                                                });
                                            },
                                            error: function(xhr) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error!',
                                                    text: xhr.responseJSON.message,
                                                    confirmButtonText: 'OK'
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    </script>


                    <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Import Excel</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                                        data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                    fill="#000000">
                                                    <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                        rx="1" />
                                                    <rect fill="#000000" opacity="0.5"
                                                        transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                        x="0" y="7" width="16" height="2" rx="1" />
                                                </g>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->

                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('vote.import') }}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-bold form-label mb-3">Masukan file berformat xlsx</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control" type="file" name="your_file" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="reset" id="kt_customers_export_cancel"
                                                class="btn btn-white me-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                                                <span class="indicator-label">Submit</span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
