@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Ambil Foto & Verifikasi</h5>
            </div>
            <div class="card-body">
                <form id="image-upload-form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image_file" class="form-label">Unggah Gambar:</label>
                        <input type="file" class="form-control" id="image_file" accept="image/*" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-block" id="upload-and-verify">
                            Upload & Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="text-center mt-3" id="loading-spinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Memproses, harap tunggu...</p>
        </div>

        <div class="mt-5 text-center">
            <img id="uploaded-image" src="" alt="Uploaded Image" class="img-fluid rounded"
                style="max-width: 400px; display: none;">
            <div id="verification-status" class="mt-4" style="display: none;">
                <i id="status-icon" class="fas fa-check-circle"></i> <span id="status-text"></span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@v2.1.0/dist/tesseract.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        document.getElementById('upload-and-verify').addEventListener('click', async () => {
            const imageFile = document.getElementById('image_file').files[0];

            if (!imageFile) {
                alert('Silakan pilih gambar terlebih dahulu.');
                return;
            }

            // Tampilkan foto yang diunggah
            const uploadedImageElement = document.getElementById('uploaded-image');
            if (uploadedImageElement) {
                uploadedImageElement.src = URL.createObjectURL(imageFile);
                uploadedImageElement.style.display = 'block';
            } else {
                console.error('Elemen #uploaded-image tidak ditemukan');
            }

            // Sembunyikan status verifikasi saat mulai memproses
            document.getElementById('verification-status').style.display = 'none';

            // Tampilkan loading spinner
            document.getElementById('loading-spinner').style.display = 'block';

            try {
                // Simulasi proses verifikasi menggunakan Tesseract (dihapus bagian ekstraksi teksnya)
                const processedImage = imageFile; // Tidak perlu preprocessing lagi

                Tesseract.recognize(
                    processedImage,
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

                    // Verifikasi sederhana berdasarkan keberadaan teks tertentu (misalnya "Jawa Barat")
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
