@extends('layouts.dashboard.app')

@section('content')
    <div class="container">
        <h1>Edit Article</h1>

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

        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <input id="content" type="hidden" name="content" value="{{ old('content', $article->content ?? '') }}">
                <trix-editor input="content"></trix-editor>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category }}" 
                            {{ old('category', $article->category) == $category->category ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
            </div>            

            <div class="form-group">
                <label for="image">Current Image:</label><br>
                @if ($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" width="150"><br><br>
                    <label for="image">Change Image (optional):</label>
                @else
                    <p>No image available</p>
                    <label for="image">Upload Image (optional):</label>
                @endif
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Article</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
