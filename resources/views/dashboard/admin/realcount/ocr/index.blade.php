@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Upload PDF & Extract Text</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pdf.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Choose PDF File:</label>
                        <input type="file" class="form-control" name="pdf_file" accept="application/pdf" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-block">
                            Upload & Extract Text
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($location_data) || isset($pemilih_data))
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Extracted Information</h5>
                </div>
                <div class="card-body">
                    @if (isset($location_data))
                        <h6>Lokasi:</h6>
                        <ul>
                            <li><strong>Provinsi:</strong> {{ $location_data['provinsi'] ?? '-' }}</li>
                            <li><strong>Kabupaten/Kota:</strong> {{ $location_data['kabupaten'] ?? '-' }}</li>
                            <li><strong>Dapil:</strong> {{ $location_data['dapil'] ?? '-' }}</li>
                            <li><strong>Kecamatan:</strong> {{ $location_data['kecamatan'] ?? '-' }}</li>
                            <li><strong>Kelurahan/Desa:</strong> {{ $location_data['kelurahan'] ?? '-' }}</li>
                            <li><strong>Nomor TPS:</strong> {{ $location_data['nomor_tps'] ?? '-' }}</li>
                        </ul>
                    @endif

                    @if (isset($pemilih_data))
                        <h6>Data Pemilih:</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Laki-Laki</th>
                                    <th>Perempuan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DPT</td>
                                    <td>{{ $pemilih_data['dpt_laki'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dpt_perempuan'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dpt_jumlah'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>DPTb</td>
                                    <td>{{ $pemilih_data['dptb_laki'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dptb_perempuan'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dptb_jumlah'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>DPK</td>
                                    <td>{{ $pemilih_data['dpk_laki'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dpk_perempuan'] ?? '-' }}</td>
                                    <td>{{ $pemilih_data['dpk_jumlah'] ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
