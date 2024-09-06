@extends('layouts.dashboard.app')

@section('content')
    <div class="container">
        <h1>Articles</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Create New Article</a>

        @if($articles->isEmpty())
            <p>No articles available.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" width="100">
                                @else
                                    No image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
