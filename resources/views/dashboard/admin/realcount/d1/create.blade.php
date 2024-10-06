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
                    <a href="{{ route('file-d1.index') }}">{{ $type }}</a>
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
                    <form action="{{ route('file-d1.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Kandidat -->
                                {{-- <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input type="file" name="file" class="form-control" id="vote_count"
                                            required />
                                    </div>
                                </div> --}}

                                <!-- Provinsi -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="provinsi_id">Provinsi</label>
                                        <select name="provinsi_id" class="form-control" id="provinsi_id" required>
                                            <option value="" selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kabupaten_id">Kabupaten</label>
                                        <select name="kabupaten_id" class="form-control" id="kabupaten_id" required>
                                            <option value="" selected disabled>Pilih Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kecamatan_id">Kecamatan</label>
                                        <select name="kecamatan_id" class="form-control" id="kecamatan_id" required>
                                            <option value="" selected disabled>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

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

                                <div id="fileModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="fileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fileModalLabel">Preview {{ $title }}</h5>
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
                            <a href="{{ route('candidate.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('provinsi_id').addEventListener('change', function () {
            let provinsi_id = this.value;
            fetch(`/get-kabupatens/${provinsi_id}`)
                .then(response => response.json())
                .then(data => {
                    let kabupatenSelect = document.getElementById('kabupaten_id');
                    kabupatenSelect.innerHTML = '<option value="" selected disabled>Pilih Kabupaten</option>';
                    data.forEach(kabupaten => {
                        kabupatenSelect.innerHTML += `<option value="${kabupaten.id}">${kabupaten.name}</option>`;
                    });
                    // Reset kecamatan dropdown
                    document.getElementById('kecamatan_id').innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
                });
        });
    
        document.getElementById('kabupaten_id').addEventListener('change', function () {
            let kabupaten_id = this.value;
            fetch(`/get-kecamatans/${kabupaten_id}`)
                .then(response => response.json())
                .then(data => {
                    let kecamatanSelect = document.getElementById('kecamatan_id');
                    kecamatanSelect.innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
                    data.forEach(kecamatan => {
                        kecamatanSelect.innerHTML += `<option value="${kecamatan.id}">${kecamatan.name}</option>`;
                    });
                });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('vote_count').addEventListener('change', function(e) {
            const fileInput = e.target;
            const file = fileInput.files[0];
            const previewContainer = document.getElementById('file-preview');
            const pdfPreview = document.getElementById('pdf-preview');
            const fileNameDisplay = document.getElementById('file-name');
            const fileSizeLimit = 5 * 1024 * 1024; // 5MB
            previewContainer.style.display = 'none';
            pdfPreview.src = '';
            fileNameDisplay.textContent = '';
            if (file) {
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
                const fileURL = URL.createObjectURL(file);
                pdfPreview.src = fileURL;
                fileNameDisplay.textContent = `File name: ${file.name}`;
                previewContainer.style.display = 'block';
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
