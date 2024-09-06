@extends('layouts.dashboard.app')

@section('content')
    <div class="container">
        <h1>Create New Article</h1>

        <!-- Tampilkan pesan error jika ada -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image (optional):</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Create Article</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
