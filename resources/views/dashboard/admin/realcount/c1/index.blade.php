@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables {{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
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
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add {{ $title }}</h4>
                            <a href="{{ route('file-c1.create') }}" class="btn btn-primary btn-round ms-auto mt-3">
                                <i class="fa fa-plus"></i>
                                {{ $title }}
                            </a>

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="tableTps" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama TPS</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>RW</th>
                                        <th>Filename</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama TPS</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>RW</th>
                                        <th>Filename</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

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
                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('tps.import') }}"
                                        enctype="multipart/form-data" novalidate>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedLength = parseInt(localStorage.getItem('selectedLength')) || 10; // Default ke 10 jika tidak ada nilai di localStorage
            var lastPage = parseInt(localStorage.getItem('lastPage')) || 0; // Default ke 0 jika tidak ada nilai di localStorage (halaman pertama)
    
            var table = $('#tableTps').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('file-c1.index') }}", // URL untuk request data
                    type: 'GET',
                    data: function(d) {
                        d.start = d.start; // Baris awal (untuk paginasi)
                        d.length = parseInt(selectedLength); // Panjang (jumlah baris per halaman dari localStorage)
                        d.draw = d.draw; // Nomor draw
                    },
                    dataSrc: function(json) {
                        console.log(json); // Cek struktur data yang dikembalikan server
                        return json.data; // Data yang dikembalikan dari server
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            var start = table.page.info().start;
                            return start + meta.row + 1;
                        }
                    },
                    { data: 'tpsrealcount.name' },
                    { data: 'tpsrealcount.kecamatan.name' },
                    { data: 'tpsrealcount.kelurahan.name' },
                    { data: 'tpsrealcount.rw' },
                    {
                        data: 'file',
                        render: function(data, type, row) {
                            return `<a href="${data}" target="_blank"><b>Lihat File Disini</b></a>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="form-button-action">
                                    <form action="/file-c1/${row.id}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this TPS?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>`;
                        }
                    }
                ],
                paging: true,
                pageLength: selectedLength, // Panjang halaman dari localStorage
                lengthMenu: [5, 10, 25, 50, 100], // Pilihan jumlah data yang ditampilkan
                displayStart: lastPage * selectedLength, // Memulai dari halaman terakhir yang tersimpan
                order: [[1, 'asc']]
            });
    
            // Ketika panjang data diubah, simpan ke localStorage dan refresh tabel
            $('#tableTps').on('length.dt', function(e, settings, len) {
                localStorage.setItem('selectedLength', len);
                table.page.len(len).draw(false); // Reload tabel dengan jumlah baris yang baru
            });
    
            // Simpan halaman terakhir yang diakses ke localStorage setiap kali pagination berubah
            $('#tableTps').on('page.dt', function() {
                var info = table.page.info();
                localStorage.setItem('lastPage', info.page);
            });
    
            // Custom search input
            $('#tableSearch').on('keyup', function() {
                table.search(this.value).draw(); // Pencarian otomatis saat mengetik
            });
        });
    </script>
    
@endsection
