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

    {{--  Dropzone Styling --}}
    <style>
        .custom-dropzone {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .custom-dropzone .dz-message {
            pointer-events: none;
        }

        /* Image Preview Styling */
        .preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }

        .preview .image-container {
            position: relative;
            display: inline-block;
        }

        .preview img {
            max-width: 100px;
            max-height: 100px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
        }

        /* Preview and Controls */
        #image-preview,
        #pdf-preview {
            border: 1px solid #ccc;
        }

        .slide-controls {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .slide-controls button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .slide-controls button:hover {
            background-color: #0056b3;
        }

        .button-group {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .button-group button {
            margin-left: 14px;
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

                                        <div class="form-group">
                                            <label class="d-block fw-bold fs-6 mb-2">Lampiran</label>
                                            <div class="custom-dropzone"
                                                onclick="document.getElementById('file_or_photo_input').click()">
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <div class="dz-message">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini
                                                        atau klik untuk mengunggah.</h3>
                                                    <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                                </div>
                                                <div class="preview" id="image-preview-container"></div>
                                                <!-- Container for image previews -->
                                            </div>
                                            <input type="file" id="file_or_photo_input" name="file[]"
                                                class="form-control d-none" multiple accept="application/pdf,image/*">
                                            <div class="error-message" id="error-message"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-start justify-content-center"
                                        style="margin-top: 30px">
                                        <div class="card border p-3 w-100">
                                            <h4>File / Photo Preview</h4>
                                            <div id="file-photo-preview" class="mt-3">
                                                <iframe id="pdf-preview" class="w-100"
                                                    style="height: 500px; display: none;"></iframe>
                                                <img id="image-preview" class="w-100" style="display: none;" />
                                                <p id="file-name" class="mt-2 text-center"></p>

                                                <!-- Slide Controls -->
                                                <div class="slide-controls mb-4" id="slide-controls"
                                                    style="display: none;">
                                                    <button type="button" id="prev-slide">❮ Previous</button>
                                                    <button type="button" id="next-slide">Next ❯</button>
                                                </div>

                                                <!-- Loading Spinner -->
                                                <div class="text-center mt-3" id="loading-spinner"
                                                    style="display: none;">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <p>Memproses, harap tunggu...</p>
                                                </div>

                                                <!-- Dynamic Verification Status per File -->
                                                <div id="verification-status-container" class="mt-4 text-center"></div>

                                                <button type="button" class="btn btn-info btn-sm mt-3"
                                                    id="open-modal">View
                                                    Full</button>
                                                <button type="button" class="btn btn-success btn-sm mt-3"
                                                    id="scan-file-photo">Scan File/Photo</button>
                                            </div>
                                        </div>
                                    </div>

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
                            <div class="button-group" style="margin-top: 15px;">
                                <button type="button" id="prevBtn" onclick="nextPrev(-1)"
                                    style="display:none; margin-left: 14px;">Previous</button>
                                <button type="button" id="nextBtn" onclick="nextPrev(1)"
                                    style="margin-left: 14px;">Next</button>
                                <button type="submit" id="submitBtn"
                                    style="margin-left: 14px; display:none;">Submit</button>
                            </div>

                    </form>
                </div>
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
            document.getElementById("submitBtn").style.display === step < steps.length - 1 ? "inline" : "none";
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
            const files = Array.from(e.target.files);
            let currentFileIndex = 0;
            const scanResults = Array(files.length).fill(null); // Array to store scan results for each file

            // Fungsi untuk seluruh foto discan
            // function updateSubmitButtonVisibility() {
            //     const allSuccess = scanResults.every(result => result && result.success === true);
            //     document.getElementById('submitBtn').style.display = allSuccess ? 'block' : 'none';
            // }

            // Fungsi untuk salah satu foto discan
            function updateSubmitButtonVisibility() {
                const anySuccess = scanResults.some(result => result && result.success === true);
                document.getElementById('submitBtn').style.display = anySuccess ? 'block' : 'none';
            }


            // Function to show the preview and load the correct scan result for the current file
            function showPreview(index) {
                const file = files[index];
                const fileURL = URL.createObjectURL(file);
                const pdfPreview = document.getElementById('pdf-preview');
                const imagePreview = document.getElementById('image-preview');
                const fileNameDisplay = document.getElementById('file-name');
                const slideControls = document.getElementById('slide-controls');
                const verificationStatusContainer = document.getElementById('verification-status-container');

                // Show the appropriate preview based on file type
                if (file.type === 'application/pdf') {
                    pdfPreview.src = fileURL;
                    pdfPreview.style.display = 'block';
                    imagePreview.style.display = 'none';
                } else if (file.type.startsWith('image/')) {
                    imagePreview.src = fileURL;
                    imagePreview.style.display = 'block';
                    pdfPreview.style.display = 'none';
                }
                fileNameDisplay.textContent = `File name: ${file.name}`;
                slideControls.style.display = files.length > 1 ? 'flex' : 'none';

                // Display the correct scan result for the current file, if available
                const scanResult = scanResults[index];
                verificationStatusContainer.innerHTML = scanResult ?
                    `<i class="${scanResult.iconClass}"></i><span>${scanResult.text}</span>` :
                    '<span>Belum diverifikasi</span>'; // Display default message if not yet scanned
            }

            // Initialize first preview
            showPreview(currentFileIndex);

            // Next and Previous buttons for navigation
            document.getElementById('prev-slide').addEventListener('click', function() {
                currentFileIndex = (currentFileIndex > 0) ? currentFileIndex - 1 : files.length - 1;
                showPreview(currentFileIndex);
            });

            document.getElementById('next-slide').addEventListener('click', function() {
                currentFileIndex = (currentFileIndex < files.length - 1) ? currentFileIndex + 1 : 0;
                showPreview(currentFileIndex);
            });

            // Scan button functionality
            document.getElementById('scan-file-photo').addEventListener('click', async () => {
                const imageFile = files[currentFileIndex];
                document.getElementById('loading-spinner').style.display = 'block';

                try {
                    if (imageFile.type.startsWith('image/')) {
                        const {
                            data: {
                                text
                            }
                        } = await Tesseract.recognize(imageFile, 'ind', {
                            logger: m => console.log(m)
                        });

                        // Determine success or failure based on keyword presence
                        const success = text.includes("JAWA BARAT");
                        const scanResult = {
                            iconClass: success ? 'fas fa-check-circle text-success' :
                                'fas fa-times-circle text-danger',
                            text: success ? "&nbsp;Berhasil 'Verifikasi'" :
                                "&nbsp;Gagal 'Verifikasi'.",
                            success: success
                        };

                        // Store scan result for the current file index
                        scanResults[currentFileIndex] = scanResult;

                        // Display result in verification status container
                        document.getElementById('verification-status-container').innerHTML =
                            `<i class="${scanResult.iconClass}"></i><span>${scanResult.text}</span>`;

                        // Update submit button visibility based on all files' statuses
                        updateSubmitButtonVisibility();

                    } else {
                        console.warn('Invalid File Type: Only images can be scanned.');
                    }
                } catch (error) {
                    console.error('Error during scan:', error);
                } finally {
                    document.getElementById('loading-spinner').style.display = 'none';
                }
            });

            // Modal functionality for viewing full file
            document.getElementById('open-modal').addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('fileModal'));
                const currentFile = files[currentFileIndex];
                const modalPdfPreview = document.getElementById('pdf-modal-preview');
                const modalImagePreview = document.getElementById('image-modal-preview');

                if (currentFile.type === 'application/pdf') {
                    modalPdfPreview.src = URL.createObjectURL(currentFile);
                    modalPdfPreview.style.display = 'block';
                    modalImagePreview.style.display = 'none';
                } else if (currentFile.type.startsWith('image/')) {
                    modalImagePreview.src = URL.createObjectURL(currentFile);
                    modalImagePreview.style.display = 'block';
                    modalPdfPreview.style.display = 'none';
                }
                modal.show();
            });
        });
    </script>

    <script>
        const previewContainer = document.getElementById('image-preview-container');
        const fileInput = document.getElementById('file_or_photo_input');
        let selectedFiles = [];

        // Listen for file input changes
        fileInput.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            selectedFiles.push(...newFiles); // Add new files to the selectedFiles array

            updatePreviews(); // Update the preview container
            updateFileInput(); // Sync file input with selected files
        });

        // Update the preview container with thumbnails for each file
        function updatePreviews() {
            previewContainer.innerHTML = ''; // Clear existing previews

            selectedFiles.forEach((file, index) => {
                const fileURL = URL.createObjectURL(file);
                const filePreviewDiv = document.createElement('div');
                filePreviewDiv.className = 'file-preview';
                filePreviewDiv.style.position = 'relative';
                filePreviewDiv.style.display = 'inline-block';
                filePreviewDiv.style.margin = '10px';

                // Add image or PDF icon based on file type
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = fileURL;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    filePreviewDiv.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    const pdfIcon = document.createElement('i');
                    pdfIcon.className = 'bi bi-file-earmark-pdf fs-3 text-danger';
                    pdfIcon.style.fontSize = '3rem';
                    filePreviewDiv.appendChild(pdfIcon);
                }

                // Add remove button
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-sm btn-danger';
                removeBtn.textContent = 'Remove';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
                removeBtn.style.fontSize = '0.8rem';

                // Remove button click event for removing specific file
                removeBtn.addEventListener('click', (event) => {
                    event.stopPropagation(); // Prevent triggering the file input
                    selectedFiles.splice(index, 1); // Remove the file from selectedFiles
                    updatePreviews(); // Refresh the previews
                    updateFileInput(); // Sync the input files
                });

                filePreviewDiv.appendChild(removeBtn);
                previewContainer.appendChild(filePreviewDiv);
            });
        }

        // Sync the file input with the selected files
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files; // Update the input with filtered files
        }
    </script>
@endsection
