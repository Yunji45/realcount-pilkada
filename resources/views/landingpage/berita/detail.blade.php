@extends('landingpage.app')

@section('title')
    {{ $article->title }} | Berita
@endsection

@section('content')
<div class="container-xxl py-5" style="margin-top:8%">
    <div class="container" id="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="article-detail mb-4">
                    <h1>{{ $article->title }}</h1>
                    <p class="article-meta">
                        {{ $article->created_at->format('d/m/Y') }} | {{ $article->click_count }} Views
                    </p>
                    @if($article->image)
                        <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" class="img-fluid mb-4">
                    @endif
                    <!-- Apply text justification and line spacing here -->
                    <div style="text-align: justify; line-height: 1.6; font-family: Arial, sans-serif; font-size: 16px;">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </article>
                <!-- Kembali ke seluruh berita -->
                <a href="{{ route('berita.all') }}" class="btn btn-primary mb-4">Kembali ke Seluruh Berita</a>
            </div>
            <div class="col-lg-4">
                <div class="trending-articles">
                    <h2>Trending Articles</h2>
                    <ul class="list-unstyled">
                        @foreach($trendingArticles as $trendingArticle)
                        <li class="mb-2">
                            <a href="{{ route('berita.detail', $trendingArticle->id) }}">
                                {{ $trendingArticle->title }} ({{ $trendingArticle->click_count }} Views)
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
