@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Create User')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables.{{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $type }}</a>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form {{ $title }}</div>
                        </div>
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="email2"
                                                placeholder="Enter Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="NIK">NIK</label>
                                            <input type="number" name="nik" class="form-control" id="NIK"
                                                placeholder="NIK" />
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-select" name="roles" id="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-select" name="gender" id="gender">
                                                <option value="Pria">Pria</option>
                                                <option value="Wanita">Wanita</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            <input type="file" name="photo" class="form-control" id="photo"
                                                placeholder="Photo" />
                                        </div>

                                        <div class="form-group">
                                            <label for="provinsi_id">Provinsi</label>
                                            <select name="provinsi_id" id="provinsi" class="form-select" required>
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kecamatan_id">Kecamatan</label>
                                            <select name="kecamatan_id" id="kecamatan" class="form-select" required>
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date Of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control" id="date_of_birth"
                                                placeholder="Enter Date Of Birth" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="Enter Email" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Password" />
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea type="text" name="address" class="form-control" id="address" cols="4" rows="4"
                                                placeholder="Address"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="kabupaten_id">Kabupaten</label>
                                            <select name="kabupaten_id" id="kabupaten" class="form-select" required>
                                                <option value="">Pilih Kabupaten</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kelurahan_id">Kelurahan</label>
                                            <select name="kelurahan_id" id="kelurahan" class="form-select" required>
                                                <option value="">Pilih Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success">Submit</button>
                                <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
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
        });
    </script>
@endsection
