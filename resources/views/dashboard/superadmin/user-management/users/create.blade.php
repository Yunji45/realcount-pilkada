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
                              <input
                                type="text"
                                name="name"
                                class="form-control"
                                id="email2"
                                placeholder="Enter Name"
                              />
                        </div>
                        <div class="form-group">
                          <label for="email2">Email Address</label>
                          <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="email2"
                            placeholder="Enter Email"
                          />
                        </div>
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="password"
                            placeholder="Password"
                          />
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlSelect1"
                            >Gender</label
                          >
                          <select
                            class="form-select"
                            name="gender"
                            id="exampleFormControlSelect1"
                          >
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="email2">Date Of Birth</label>
                            <input
                              type="date"
                              name="date_of_birth"
                              class="form-control"
                              id="email2"
                              placeholder="Enter Date Of Birth"
                            />
                          </div>
                          <div class="form-group">
                            <label for="password">Photo</label>
                            <input
                              type="file"
                              name="photo"
                              class="form-control"
                              id="password"
                              placeholder="Password"
                            />
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect1"
                              >Role</label
                            >
                            <select
                              class="form-select"
                              name="roles"
                              id="exampleFormControlSelect1"
                            >
                              @foreach($roles as $role)
                                  <option value="{{ $role->name }}">{{ $role->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="password">Nik</label>
                            <input
                              type="text"
                              name="nik"
                              class="form-control"
                              id="password"
                              placeholder="Password"
                            />
                          </div>
                          <div class="form-group">
                            <label for="password">Address</label>
                            <input
                              type="text"
                              name="address"
                              class="form-control"
                              id="password"
                              placeholder="Password"
                            />
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <button class="btn btn-danger">Cancel</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
