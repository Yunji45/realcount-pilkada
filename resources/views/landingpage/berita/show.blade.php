@extends('landingpage.app')

@section('title')
    Pilkada | Berita
@endsection

@section('content')
    <div class="container-xxl py-5" style="margin-top: 5%">
        <div class="container" id="container">
            <section class="latest-articles" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Berita</h2>
                <div class="articles-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @if ($articles->isEmpty())
                        <p>No articles available.</p>
                    @else
                        @foreach ($articles as $article)
                            <div class="article-card"
                                style="background-color: #fff; padding: 0px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <!-- Image -->
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                    class="article-image"
                                    style="max-width: 100%; height: 200px; display: block; border-radius: 8px 8px 0 0;">

                                <!-- Title and meta info -->
                                <div class="article-content" style="padding: 20px;">
                                    <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                        {{ $article->title }}
                                    </h3>
                                    <div style="color: #888; font-size: 12px; margin-bottom: 10px;">
                                        {{ $article->created_at->format('d/m/Y') }} | No Comments
                                    </div>

                                    <!-- Short content -->
                                    <p style="color: #555; font-size: 14px; margin-bottom: 10px;">
                                        {!! Str::limit($article->content, 100) !!}
                                    </p>

                                    <!-- Read more link -->
                                    <a href="{{ route('berita.detail', $article->id) }}" class="read-more"
                                        style="font-size: 14px; font-weight: bold; color: #e74c3c; text-decoration: none;">
                                        SELENGKAPNYA »
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </section>
            <!-- Pagination -->
            <div style="margin-top: 50px;" class="text-start">
                {{ $articles->links() }}
            </div>

            {{-- <section class="categories" style="margin-top: 40px;">
                    <h2 style="font-size: 32px; margin-bottom: 20px;">Categories</h2>
                    <div class="categories-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @if ($categories->isEmpty())
                            <p>No categories available.</p>
                        @else
                            @foreach ($categories as $category)
                            @endforeach
                            @endif
                        </div>
                    </section> --}}
            {{-- <a href="{{ route('category.show', $category->category) }}" class="category-item" style="background-color: #3498db; color: #fff; padding: 10px 20px; border-radius: 5px;">{{ $category->category }}</a> --}}

            <!-- Trending Topics Section -->
            {{-- <section class="trending-topics" style="margin-top: 40px;">
                    <h2 style="font-size: 32px; margin-bottom: 20px;">Trending Topics</h2>
                    <div class="trending-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        @if ($trendingArticles->isEmpty())
                            <p>No trending articles available.</p>
                        @else
                            @foreach ($trendingArticles as $article)
                                <div class="trending-item"
                                    style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                    <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                    <p>{!! Str::limit($article->content, 50) !!}</p>
                                    <a href="{{ route('article.show', $article->id) }}" class="read-more"
                                        style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read
                                        More</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section> --}}
        </div>
    </div>
@endsection
