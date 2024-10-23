@extends('layouts.dashboard.app')

@section('title', 'My Gerindra | Create Role')

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form {{ $title }}</div>
                </div>
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Enter Role Name" value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group" style="margin-left: 1.3%">
                                <label for="permissions">Permissions</label>
                                <div class="form-check">
                                    <!-- Select All Checkbox -->
                                    <div>
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                        <label class="form-check-label" for="select-all">Select All</label>
                                    </div>
                                    <!-- Scrollable Permissions List -->
                                    <div class="permission-container" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                        <div class="row">
                                            @foreach($permission->chunk(10) as $chunk)
                                                <div class="col-md-6">
                                                    @foreach($chunk as $perm)
                                                        <div>
                                                            <input type="checkbox"
                                                                   class="form-check-input permission-checkbox"
                                                                   id="perm-{{ $perm->id }}" name="permission[]"
                                                                   value="{{ $perm->id }}">
                                                            <label class="form-check-label"
                                                                   for="perm-{{ $perm->id }}">{{ $perm->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('permission')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Create</button>
                        <a href="{{ route('role.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery for Select All functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Select all permissions
        $('#select-all').on('change', function() {
            $('.permission-checkbox').prop('checked', this.checked);
        });

        // If all permissions are selected, the "Select All" checkbox should be checked
        $('.permission-checkbox').on('change', function() {
            if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
        });
    });
</script>
@endsection
