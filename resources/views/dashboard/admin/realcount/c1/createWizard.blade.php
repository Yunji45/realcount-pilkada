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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title">Form {{ $type }} {{ $title }}</h3>
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
                                    <span class="indicator-text">Select TPS</span>
                                </div>
                                <div class="indicator" id="indicator-2">
                                    <div class="indicator-circle">3</div>
                                    <span class="indicator-text">Upload File</span>
                                </div>
                            </div>
                            <!-- Step 1: Location Selection -->
                            <div class="step active" id="step-1">
                                <div class="row">
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
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kabupaten_id">Kabupaten</label>
                                            <select name="kabupaten_id" class="form-control" id="kabupaten" required>
                                                <option value="" selected disabled>Pilih Kabupaten</option>
                                                {{-- @foreach ($kabupatens as $kabupaten)
                                                    <option value="{{ $kabupaten->id }}">{{ $kabupaten->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kecamatan_id">Kecamatan</label>
                                            <select name="kecamatan_id" class="form-control" id="kecamatan" required>
                                                <option value="" selected disabled>Pilih Kecamatan</option>
                                                {{-- @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="kelurahan_id">Kelurahan</label>
                                            <select name="kelurahan_id" class="form-control" id="kelurahan" required>
                                                <option value="" selected disabled>Pilih Kelurahan</option>
                                                {{-- @foreach ($kelurahans as $kelurahan)
                                                    <option value="{{ $kelurahan->id }}">{{ $kelurahan->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: TPS Selection -->
                            <div class="step" id="step-2">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="polling_place_id">Nama TPS</label>
                                            <select name="tps_realcount_id" class="form-control" id="polling_place"
                                                required>
                                                <option value="" selected disabled>Pilih TPS</option>
                                                {{-- @foreach ($tps_realcounts as $tps)
                                                    <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: File Upload -->
                            <div class="step" id="step-3">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="file">File</label>
                                            <input type="file" name="file" class="form-control" id="vote_count"
                                                accept="application/pdf" required />
                                            <small class="form-text text-muted">Max: 5MB. Only PDF files allowed.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="card-action">
<<<<<<< Updated upstream
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
                                <div class="col-md-6 col-lg-2">
                                    <div class="form-group">
                                        <label for="polling_place_id">Nama Pemilihan</label>
                                        <select name="election_id" class="form-control" id="election_id" required>
                                            <option value="" selected disabled>Pilih Pemilihan</option>
                                            @foreach ($pemilihan as $item)
                                                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                            @endforeach
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
=======
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)"
                                style="display:none;">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button type="submit" id="submitBtn" style="display:none;">Submit</button>
>>>>>>> Stashed changes
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

    </div>
@endsection
