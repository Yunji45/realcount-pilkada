@extends('layouts.dashboard.app')

@section('title', 'Pilkada | Edit User')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit {{ $title }}</h3>
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
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                              <label for="name">Name</label>
                              <input
                                type="text"
                                name="name"
                                class="form-control"
                                id="name"
                                placeholder="Enter Name"
                                value="{{ old('name', $user->name) }}"
                              />
                        </div>
                        <div class="form-group">
                          <label for="email">Email Address</label>
                          <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="email"
                            placeholder="Enter Email"
                            value="{{ old('email', $user->email) }}"
                          />
                        </div>
                        <div class="form-group">
                          <label for="password">Password (Leave blank if not changing)</label>
                          <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="password"
                            placeholder="Password"
                          />
                        </div>
                        <div class="form-group">
                          <label for="gender">Gender</label>
                          <select
                            class="form-select"
                            name="gender"
                            id="gender"
                          >
                            <option value="Pria" {{ $user->gender == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ $user->gender == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="date_of_birth">Date Of Birth</label>
                            <input
                              type="date"
                              name="date_of_birth"
                              class="form-control"
                              id="date_of_birth"
                              value="{{ old('date_of_birth', $user->date_of_birth) }}"
                            />
                          </div>
                          <div class="form-group">
                            <label for="photo">Photo</label>
                            <input
                              type="file"
                              name="photo"
                              class="form-control"
                              id="photo"
                            />
                            @if($user->photo)
                              <small>Current Photo: <img src="{{ asset('storage/'.$user->photo) }}" alt="User Photo" width="50"></small>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="roles">Role</label>
                            <select
                              class="form-select"
                              name="roles"
                              id="roles"
                            >
                              @foreach($roles as $role)
                                  <option value="{{ $role->name }}" {{ $user->roles == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="nik">Nik</label>
                            <input
                              type="text"
                              name="nik"
                              class="form-control"
                              id="nik"
                              placeholder="Enter Nik"
                              value="{{ old('nik', $user->nik) }}"
                            />
                          </div>
                          <div class="form-group">
                            <label for="address">Address</label>
                            <input
                              type="text"
                              name="address"
                              class="form-control"
                              id="address"
                              placeholder="Enter Address"
                              value="{{ old('address', $user->address) }}"
                            />
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-action">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                  </div>
                      
                </form>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
