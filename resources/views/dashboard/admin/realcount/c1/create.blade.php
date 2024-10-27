@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $type }} {{ $title }}
@endsection

@section('content')
    <style>
        /* Basic styling for card */
        .card {
            border: 1px solid #e3e3e3;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Styling for step indicator */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .indicator {
            position: relative;
            width: 33.33%;
            text-align: center;
        }

        .indicator-circle {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            display: inline-block;
            line-height: 30px;
            color: white;
            font-weight: bold;
        }

        .indicator.active .indicator-circle {
            background-color: #28a745;
        }

        .indicator-text {
            display: block;
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }

        .card-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        /* Button styling */
        #prevBtn,
        #nextBtn,
        #submitBtn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            transition: 0.3s;
        }

        #prevBtn {
            background-color: #6c757d;
            color: white;
        }

        #nextBtn {
            background-color: #007bff;
            color: white;
        }

        #submitBtn {
            background-color: #28a745;
            color: white;
        }

        #prevBtn:hover,
        #nextBtn:hover,
        #submitBtn:hover {
            opacity: 0.8;
        }
    </style>

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
                    <div class="card-header text-center">
                        <h3 class="card-title">Form Input Suara</h3>
                    </div>
                    <form id="multiStepForm" action="{{ route('file-c1.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Step Indicators -->
                            <div class="step-indicator">
                                <div class="indicator" id="indicator-0">
                                    <div class="indicator-circle">1</div>
                                    <span class="indicator-text">Location</span>
                                </div>
                                <div class="indicator" id="indicator-1">
                                    <div class="indicator-circle">2</div>
                                    <span class="indicator-text">Vote</span>
                                </div>
                            </div>
                            <!-- Step 1: Location Selection -->
                            <div class="step active" id="step-1">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="provinsi_id">Provinsi :</label>
                                            <select name="provinsi_id" class="form-select" id="provinsi" required>
                                                <option value="" selected disabled>Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kabupaten_id">Kabupaten :</label>
                                            <select name="kabupaten_id" class="form-select" id="kabupaten" required>
                                                <option value="" selected disabled>Pilih Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kecamatan_id">Kecamatan :</label>
                                            <select name="kecamatan_id" class="form-select" id="kecamatan" required>
                                                <option value="" selected disabled>Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kelurahan_id">Kelurahan :</label>
                                            <select name="kelurahan_id" class="form-select" id="kelurahan" required>
                                                <option value="" selected disabled>Pilih Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kelurahan_id">TPS :</label>
                                            <select name="tps_realcount_id" class="form-select" id="polling_place" required>
                                                <option value="" selected disabled>Pilih TPS</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Step 2: TPS Selection -->
                            <div class="step" id="step-2">
                                <div class="row">
                                    <!-- Left Side: Form Inputs -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-2">
                                            <label for="jenis_pemilihan">Jenis Pemilihan:</label>
                                            <select class="form-select" name="election_id" id="election">
                                                <option value="" selected disabled>Pilih Pemilu</option>
                                                @foreach ($pemilihan as $election)
                                                    <option value="{{ $election->id }}">
                                                        {{ $election->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="candidate-votes-container"></div>

                                        <!-- File Upload and Preview Section -->
                                        <div class="form-group mb-2">
                                            <label for="file">File or Photo :</label>
                                            <input type="file" name="file" class="form-control"
                                                id="file_or_photo_input" accept="application/pdf,image/*" required />
                                            <small class="form-text text-muted">Max: 5MB. Only PDF or image files (JPEG,
                                                PNG) allowed.</small>
                                        </div>
                                    </div>

                                    <!-- Right Side: Large File Preview -->
                                    <div class="col-md-6 d-flex align-items-start justify-content-center"
                                        style="margin-top: 30px">
                                        <div class="card border p-3 w-100">
                                            <h4>File / Photo Preview</h4>
                                            <div id="file-photo-preview" class="mt-3" style="display: none;">
                                                <iframe id="pdf-preview" class="w-100"
                                                    style="height: 500px; border: 1px solid #ccc; display: none;"></iframe>
                                                <img id="image-preview" class="w-100"
                                                    style="height: 500px; border: 1px solid #ccc; display: none;" />
                                                <p id="file-name" class="mt-2 text-center"></p>

                                                <!-- Loading Spinner for Scan -->
                                                <div class="text-center mt-3" id="loading-spinner"
                                                    style="display: none;">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <p>Memproses, harap tunggu...</p>
                                                </div>

                                                <!-- Verification Status -->
                                                <div id="verification-status" class="mt-4 text-center"
                                                    style="display: none;">
                                                    <i id="status-icon" class="fas fa-check-circle"></i>
                                                    <span id="status-text"></span>
                                                </div>

                                                <button type="button" class="btn btn-info btn-sm" id="open-modal">
                                                    View Full
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm"
                                                    id="scan-file-photo">
                                                    Scan File/Photo
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal for Full View -->
                                    <div id="fileModal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="fileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fileModalLabel">Full View</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe id="pdf-modal-preview" width="100%" height="500"
                                                        style="border: 1px solid #ccc; display: none;"></iframe>
                                                    <img id="image-modal-preview" width="100%"
                                                        style="height: 500px; border: 1px solid #ccc; display: none;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="card-action">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)"
                                style="display:none;">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button type="submit" id="submitBtn" style="display:none;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@v2.1.0/dist/tesseract.min.js"></script>

    {{-- WIZARD STEP --}}
    <script>
        let currentStep = 0;
        showStep(currentStep);

        function showStep(step) {
            const steps = document.getElementsByClassName("step");
            const indicators = document.getElementsByClassName("indicator");

            // Hide all steps
            Array.from(steps).forEach(s => s.classList.remove("active"));
            steps[step].classList.add("active");

            // Update indicators
            Array.from(indicators).forEach(i => i.classList.remove("active"));
            indicators[step].classList.add("active");

            // Toggle button visibility
            document.getElementById("prevBtn").style.display = step > 0 ? "inline" : "none";
            document.getElementById("nextBtn").style.display = step < steps.length - 1 ? "inline" : "none";
            document.getElementById("submitBtn").style.display = step === steps.length - 1 ? "inline" : "none";
        }

        function nextPrev(n) {
            currentStep += n;
            showStep(currentStep);
        }
    </script>

    {{-- Lokasi --}}
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
                                $('#polling_place').append('<option value="' + value
                                    .id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>

    {{-- Pemilihan Pemilu --}}
    <script>
        $('#election').on('change', function() {
            let electionId = $(this).val();
            if (electionId) {
                $.ajax({
                    url: `/get-candidates-by-election/${electionId}`,
                    type: 'GET',
                    success: function(candidates) {
                        $('#candidate-votes-container').empty(); // Kosongkan input sebelumnya

                        if (candidates.length > 0) {
                            // Looping untuk setiap kandidat
                            candidates.forEach(candidate => {
                                $('#candidate-votes-container').append(`
                            <div class="form-group mb-2">
                                <label for="vote_${candidate.id}">Suara Kandidat (${candidate.name}):</label>
                                <input type="number" name="votes[${candidate.id}]" id="vote_${candidate.id}" class="form-control" placeholder="Masukkan suara untuk ${candidate.name}" required>
                            </div>
                        `);
                            });
                        } else {
                            $('#candidate-votes-container').append(
                                '<p>Tidak ada kandidat untuk pemilihan ini.</p>'
                            );
                        }
                    },
                    error: function() {
                        $('#candidate-votes-container').append(
                            '<p>Gagal memuat kandidat, coba lagi.</p>');
                    }
                });
            } else {
                $('#candidate-votes-container').empty();
            }
        });
    </script>

    {{-- Upload PDF --}}
    <script>
        document.getElementById('file_or_photo_input').addEventListener('change', function(e) {
            const fileInput = e.target;
            const file = fileInput.files[0];
            const previewContainer = document.getElementById('file-photo-preview');
            const pdfPreview = document.getElementById('pdf-preview');
            const imagePreview = document.getElementById('image-preview');
            const fileNameDisplay = document.getElementById('file-name');
            const fileSizeLimit = 5 * 1024 * 1024; // 5MB

            // Reset preview and error messages
            previewContainer.style.display = 'none';
            pdfPreview.style.display = 'none';
            imagePreview.style.display = 'none';
            pdfPreview.src = '';
            imagePreview.src = '';
            fileNameDisplay.textContent = '';

            if (file) {
                // Check file size
                if (file.size > fileSizeLimit) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Too Large',
                        text: 'File size exceeds 5MB. Please select a smaller file.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    fileInput.value = '';
                    return;
                }

                const fileURL = URL.createObjectURL(file);

                if (file.type === 'application/pdf') {
                    pdfPreview.src = fileURL;
                    pdfPreview.style.display = 'block';
                    imagePreview.style.display = 'none';
                } else if (file.type.startsWith('image/')) {
                    imagePreview.src = fileURL;
                    imagePreview.style.display = 'block';
                    pdfPreview.style.display = 'none';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please select a valid PDF or image file (JPEG, PNG).',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    fileInput.value = '';
                    return;
                }

                fileNameDisplay.textContent = `File name: ${file.name}`;
                previewContainer.style.display = 'block';

                // Modal preview
                document.getElementById('open-modal').onclick = function() {
                    if (file.type === 'application/pdf') {
                        document.getElementById('pdf-modal-preview').src = fileURL;
                        document.getElementById('pdf-modal-preview').style.display = 'block';
                        document.getElementById('image-modal-preview').style.display = 'none';
                    } else {
                        document.getElementById('image-modal-preview').src = fileURL;
                        document.getElementById('image-modal-preview').style.display = 'block';
                        document.getElementById('pdf-modal-preview').style.display = 'none';
                    }
                    $('#fileModal').modal('show');
                };

                $('.close').click(function() {
                    $('#fileModal').modal('hide');
                });
            }
        });

        document.getElementById('scan-file-photo').addEventListener('click', async () => {
            const fileInput = document.getElementById('file_or_photo_input');
            const imageFile = fileInput.files[0];

            if (!imageFile) {
                alert('Silakan pilih gambar atau file terlebih dahulu.');
                return;
            }

            // Sembunyikan status verifikasi saat mulai memproses
            document.getElementById('verification-status').style.display = 'none';

            // Tampilkan loading spinner
            document.getElementById('loading-spinner').style.display = 'block';

            try {
                Tesseract.recognize(
                    imageFile,
                    'ind', {
                        logger: info => console.log(info),
                        tessedit_char_whitelist: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
                        preserve_interword_spaces: '1',
                        psm: 12,
                        oem: 1,
                    }
                ).then(({
                    data: {
                        text
                    }
                }) => {
                    const statusIconElement = document.getElementById('status-icon');
                    const statusTextElement = document.getElementById('status-text');
                    const verificationStatusElement = document.getElementById('verification-status');

                    // Verifikasi sederhana berdasarkan teks tertentu
                    if (text.includes("JAWA BARAT")) {
                        statusIconElement.className = 'fas fa-check-circle text-success';
                        statusTextElement.textContent = 'Verifikasi Berhasil';
                    } else {
                        statusIconElement.className = 'fas fa-times-circle text-danger';
                        statusTextElement.textContent = 'Verifikasi Gagal';
                    }

                    verificationStatusElement.style.display = 'block';
                }).catch(error => {
                    console.error(error);
                    alert('Gagal melakukan verifikasi gambar.');
                }).finally(() => {
                    document.getElementById('loading-spinner').style.display = 'none';
                });

            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan dalam memproses gambar.');
                document.getElementById('loading-spinner').style.display = 'none';
            }
        });
    </script>
@endsection
