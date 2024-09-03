@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit User</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}" required>
                @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control @error('jk') is-invalid @enderror" required>
                    <option value="" disabled>Select Gender</option>
                    <option value="Laki-laki" {{ old('jk', $user->jk) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jk', $user->jk) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <small class="text-muted">Leave blank if you don't want to change the password.</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label for="roles">Roles</label>
                <select name="roles[]" id="roles" class="form-control @error('roles') is-invalid @enderror" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ in_array($role, old('roles', $userRole)) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @error('roles')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
                @error('photo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                @if($user->photo)
                    <small class="form-text text-muted">Current photo: <a href="{{ asset($user->photo) }}" target="_blank">View Photo</a></small>
                @endif
            </div>

            {{-- <div class="form-group">
                <label for="company_id">Company</label>
                <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror">
                    <option value="" disabled>Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</div>
@endsection
