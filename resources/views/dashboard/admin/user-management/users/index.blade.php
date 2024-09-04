@extends('layouts.dashboard.app')

@section('title')
    Pilkada | Data User
@endsection

@section('content')
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title">Data User</h5>
            <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
        </div>
        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
