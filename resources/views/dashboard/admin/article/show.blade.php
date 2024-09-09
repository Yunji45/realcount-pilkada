@extends('layouts.dashboard.app')

@section('title')
    Pilkada | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3 text-center">{{ $article->title }}</h3>
        </div>
        <div class="card">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if ($article->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="img-fluid"
                                 style="max-width: 40%; height: auto; border-radius:10px; object-fit:cover;margin-top:30px">
                        </div>
                    @endif

                    <div class="mb-4">
                        <b>Created on:</b> {{ $article->created_at->format('Y-m-d H:i:s') }}
                        <hr>
                        <p style="text-align: justify; line-height: 1.6; font-size: 16px;">
                            {{ $article->content }}
                        </p>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning me-2">Edit</a>
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
