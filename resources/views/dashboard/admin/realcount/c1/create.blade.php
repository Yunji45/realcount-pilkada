@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $type }} {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $type }} {{ $title }}</h3>
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
                    <a href="{{ route('file-c1.index') }}">{{ $type }}</a>
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
                        <div class="card-title">Form {{ $type }} {{ $title }}</div>
                    </div>
                    {{-- <form action="{{ route('vote.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Vote</label>
                                        <input type="text" name="vote_count" class="form-control" id="vote_count" required />
                                    </div>
                                </div>

                                <!-- Partai -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="partai_id">Candidat</label>
                                        <select name="candidate_id" class="form-control" id="candidate_id" required>
                                            <option value="" selected disabled>Pilih Candidate</option>
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Pemilu -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="election_id">Nama TPS</label>
                                        <select name="polling_place_id" class="form-control" id="polling_place_id" required>
                                            <option value="" selected disabled>Pilih TPS</option>
                                            @foreach ($pollingPlaces as $polling)
                                                <option value="{{ $polling->id }}">{{ $polling->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('candidate.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form> --}}
                    <form action="{{ route('file-c1.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Provinsi -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="provinsi_id">Provinsi</label>
                                        <select name="provinsi_id" class="form-control" id="provinsi" required>
                                            <option value="" selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="kabupaten_id">Kabupaten</label>
                                        <select name="kabupaten_id" class="form-control" id="kabupaten" required>
                                            <option value="" selected disabled>Pilih Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-md-6 col-lg-2">
                                    <div class="form-group">
                                        <label for="kecamatan_id">Kecamatan</label>
                                        <select name="kecamatan_id" class="form-control" id="kecamatan" required>
                                            <option value="" selected disabled>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="col-md-6 col-lg-2">
                                    <div class="form-group">
                                        <label for="kelurahan_id">Kelurahan</label>
                                        <select name="kelurahan_id" class="form-control" id="kelurahan" required>
                                            <option value="" selected disabled>Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- TPS -->
                                <div class="col-md-6 col-lg-2">
                                    <div class="form-group">
                                        <label for="polling_place_id">Nama TPS</label>
                                        <select name="tps_realcount_id" class="form-control" id="polling_place" required>
                                            <option value="" selected disabled>Pilih TPS</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Input File -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input type="file" name="file" class="form-control" id="vote_count"
                                            accept="application/pdf" required />
                                        <small id="file-info" class="form-text text-muted">Max: 5MB. Only PDF files
                                            allowed.</small>
                                        <!-- Tempat Preview -->
                                        <div id="file-preview" class="mt-3" style="display: none;">
                                            <iframe id="pdf-preview" width="100%" height="300"
                                                style="border: 1px solid #ccc;"></iframe>
                                            <p id="file-name"></p>
                                            <button type="button" class="btn btn-info btn-sm" id="open-modal">View
                                                Full</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal untuk Tampilan Full -->
                                <div id="fileModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="fileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe id="pdf-modal-preview" width="100%" height="500"
                                                    style="border: 1px solid #ccc;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('file-c1.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinsiId = $(this).val();
                $('#kabupaten').empty().append('<option value="">Pilih Kabupaten</option>');
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (provinsiId) {
                    $.ajax({
                        url: '/get-kabupaten/' + provinsiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kabupaten').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#kabupaten').change(function() {
                var kabupatenId = $(this).val();
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (kabupatenId) {
                    $.ajax({
                        url: '/get-kecamatan/' + kabupatenId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#kecamatan').change(function() {
                var kecamatanId = $(this).val();
                $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                if (kecamatanId) {
                    $.ajax({
                        url: '/get-kelurahan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#kelurahan').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#kelurahan').change(function() {
                var kelurahanId = $(this).val();
                $('#polling_place').empty().append('<option value="">Pilih TPS</option>');
                if (kelurahanId) {
                    $.ajax({
                        url: '/get-realcount-tps/' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#polling_place').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>

    {{-- Upload PDF --}}
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('vote_count').addEventListener('change', function(e) {
            const fileInput = e.target;
            const file = fileInput.files[0];
            const previewContainer = document.getElementById('file-preview');
            const pdfPreview = document.getElementById('pdf-preview');
            const fileNameDisplay = document.getElementById('file-name');
            const fileSizeLimit = 5 * 1024 * 1024; // 5MB

            // Reset preview dan pesan error
            previewContainer.style.display = 'none';
            pdfPreview.src = '';
            fileNameDisplay.textContent = '';

            // Cek jika file dipilih
            if (file) {
                // Cek ukuran file lebih dulu sebelum menampilkan tipe
                if (file.size > fileSizeLimit) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Too Large',
                        text: 'File size exceeds 5MB. Please select a smaller file.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    fileInput.value = ''; // Clear file input jika tidak valid
                    return; // Hentikan proses jika file terlalu besar
                }

                // Cek tipe file
                if (file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please select a valid PDF file.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    fileInput.value = ''; // Clear file input jika bukan PDF
                    return;
                }

                // Tampilkan preview file jika valid
                const fileURL = URL.createObjectURL(file);
                pdfPreview.src = fileURL;
                fileNameDisplay.textContent = `File name: ${file.name}`;
                previewContainer.style.display = 'block';

                // Modal preview
                document.getElementById('open-modal').onclick = function() {
                    document.getElementById('pdf-modal-preview').src = fileURL;
                    $('#fileModal').modal('show');
                };

                $('.close').click(function() {
                    $('#fileModal').modal('hide');
                });
            }
        });
    </script>
@endsection
