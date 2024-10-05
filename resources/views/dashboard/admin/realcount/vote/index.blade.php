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
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data {{ $title }}</h4>
                            <a href="{{ route('vote-realcount.create') }}" class="btn btn-primary btn-round ms-auto mt-3">
                                <i class="fa fa-plus"></i>
                                {{ $title }}
                            </a>

                        </div>
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

                        <div class="table-responsive">
                            <table id="tableVote" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id tps</th>
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
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>id tps</th>
                                        <th>Nama Candidat</th>
                                        <th>Nama TPS</th>
                                        <th>Nama Partai</th>
                                        <th>Nama Pemilu</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Vote</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    {{-- @foreach ($votes as $vote)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vote->polling_place_id }}</td>
                                            <td>{{ $vote->candidate->name }}</td>
                                            <td>{{ $vote->polling_place->name }}</td>
                                            <td>{{ $vote->candidate->partai->name }}</td>
                                            <td>{{ $vote->candidate->election->name }}</td>
                                            <td>{{ $vote->polling_place->kecamatan->name }}</td>
                                            <td>{{ $vote->polling_place->kelurahan->name }}</td>
                                            <td>{{ $vote->vote_count }}</td>

                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol Edit dengan ikon pensil -->
                                                    <a href="{{ route('vote.edit', $vote->id) }}"
                                                        class="btn btn-warning btn-sm" style="margin-right:10px">
                                                        <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                                    </a>

                                                    <!-- Tombol Delete dengan ikon tong sampah -->
                                                    <form action="{{ route('vote.destroy', $vote->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this Vote?')">
                                                            <i class="fas fa-trash-alt"></i> <!-- Ikon Delete -->
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach --}}
                                </tbody>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ambil nilai lengthMenu dan halaman terakhir dari localStorage
            var selectedLength = localStorage.getItem('selectedLength') || 10; // Default ke 10 jika tidak ada nilai di localStorage
            var lastPage = localStorage.getItem('lastPage') || 0; // Default ke 0 jika tidak ada nilai di localStorage (halaman pertama)

            // Inisialisasi DataTable dengan server-side processing
            var table = $('#tableVote').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('vote-realcount.index') }}", // URL untuk request data
                    type: 'GET',
                    data: function(d) {
                        d.start = d.start; // Baris awal (untuk paginasi)
                        d.length = parseInt(selectedLength); // Panjang (jumlah baris per halaman dari localStorage)
                        d.draw = d.draw; // Nomor draw
                    },
                    dataSrc: function(json) {
                        return json.data; // Data yang dikembalikan dari server
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            // Nomor berurutan yang memperhitungkan halaman
                            var start = table.page.info().start;
                            return start + meta.row + 1;
                        }
                    },
                    { data: 'tps_realcount_id' },
                    { data: 'candidate.name' },
                    { data: 'tpsrealcount.name' },
                    { data: 'candidate.partai.name' },
                    { data: 'candidate.election.name' },
                    { data: 'tpsrealcount.kecamatan.name' },
                    { data: 'tpsrealcount.kelurahan.name' },
                    { data: 'real_count' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="form-button-action">
                                    <a href="/vote-realcount/${row.id}/edit" class="btn btn-warning btn-sm" style="margin-right:10px">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/vote-realcount/${row.id}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Vote?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>`;
                        }
                    }
                ],
                paging: true,
                pageLength: parseInt(selectedLength), // Panjang halaman dari localStorage
                lengthMenu: [5, 10, 25, 50, 100], // Pilihan jumlah data yang ditampilkan
                displayStart: parseInt(lastPage) * selectedLength, // Memulai dari halaman terakhir yang tersimpan
                order: [[1, 'asc']]
            });

            // Ketika panjang data diubah, simpan ke localStorage dan refresh tabel
            $('#tableVote').on('length.dt', function(e, settings, len) {
                localStorage.setItem('selectedLength', len);
                table.page.len(len).draw(false); // Reload tabel dengan jumlah baris yang baru
            });

            // Simpan halaman terakhir yang diakses ke localStorage setiap kali pagination berubah
            $('#tableVote').on('page.dt', function() {
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
