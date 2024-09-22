@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Profile</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                @if ($editMode)
                    <a href="{{ route('profile.index') }}" class="btn btn-warning btn-round me-2">Cancel Edit</a>
                @else
                    <a href="{{ route('profile.index', ['edit' => true]) }}" class="btn btn-info btn-round me-2">Edit
                        Profile</a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile shadow-lg">
                    <div class="card-header"
                        style="background-image: url('{{ asset('template/assets/img/examples/product12.jpeg') }}'); height: 200px; background-size: cover; background-position: center; border-radius: 15px 15px 0 0;">
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . (Auth::user()->photo ? Auth::user()->photo : 'template/assets/img/profile.jpg')) }}"
                            alt="Profile Picture" class="rounded-circle img-fluid mb-3"
                            style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                        <h4 class="card-title fw-bold">{{ $user->name }}</h4>
                        <p class="card-text"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i>
                            {{ $user->address ?? 'No address provided' }}</p>
                        <p class="card-text"><i class="fas fa-calendar-alt"></i>
                            {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : 'N/A' }}
                            ({{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->age : 'N/A' }} years
                            old)
                        </p>
                        <p class="card-text">
                            <strong>Status:</strong> {{ ucfirst($user->status) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tampilkan form edit jika dalam mode edit -->
            @if ($editMode)
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h4 class="fw-bold">Edit Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="{{ $user->address }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ $user->date_of_birth }}"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter new password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm new password">
                                </div>


                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <div class="profile-photo-wrapper">
                                        <!-- Image preview -->
                                        <img id="photo-preview" src="{{ asset('storage/' . $user->photo) }}"
                                            alt="Profile Photo" class="img-fluid rounded mt-2"
                                            style="max-width: 150px; object-fit: cover;">

                                        <!-- Custom file input -->
                                        <div class="custom-file mt-3">
                                            <input type="file" name="photo" class="custom-file-input" id="photo"
                                                onchange="previewPhoto()">
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript to preview the image -->
                                <script>
                                    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                                        let fileName = e.target.files[0].name;
                                        let nextSibling = e.target.nextElementSibling;
                                        nextSibling.innerText = fileName;

                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            document.getElementById('photo-preview').src = e.target.result;
                                        }
                                        reader.readAsDataURL(this.files[0]);
                                    });
                                </script>





                                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Personal Information -->
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h4 class="fw-bold">Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>NIK:</strong>
                                    <p>{{ $user->nik }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Gender:</strong>
                                    <p>{{ ucfirst($user->gender) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>KTP:</strong>
                                    <img src="{{ Auth::user()->ktp ? asset('storage/' . Auth::user()->ktp) : asset('template/assets/img/examples/KTP.png') }}"
                                        alt="KTP" class="img-fluid" style="max-width: 150px;">
                                </div>
                                <div class="col-md-6">
                                    <strong>Description:</strong>
                                    <p>{{ $user->description ?? 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .card-profile {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .card-profile img {
            border: 3px solid #fff;
        }

        .page-inner {
            padding: 30px;
        }

        .btn-info,
        .btn-warning {
            background-color: #5e72e4;
            color: #fff;
        }

        /* Custom file input style */
        .custom-file-label {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            display: inline-block;
            width: auto;
            background-color: #fff;
            cursor: pointer;
        }

        .custom-file-input {
            display: none;
            /* Hide the original file input */
        }

        /* Styling for left card alignment */
        .card-left-content {
            text-align: left;
        }

        .card-left-content .img-fluid {
            margin: 0 auto;
            display: block;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        /* Optional: Add some margin between elements for better spacing */
        .profile-photo-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }
    </style>
@endsection
