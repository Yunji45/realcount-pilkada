@extends('layouts.dashboard.app')

@section('content')
    <div class="container">
        <h1>{{ $article->title }}</h1>

        <!-- Tampilkan gambar jika ada -->
        @if ($article->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" width="300">
            </div>
        @endif

        <!-- Tampilkan konten artikel -->
        <div class="mb-4">
            <p>{{ $article->content }}</p>
        </div>

        <!-- Tombol aksi -->
        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>

        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
        </form>

        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to Articles</a>
    </div>
@endsection
