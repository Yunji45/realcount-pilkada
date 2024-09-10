<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <!-- Hero Section -->
        <header class="hero-section" style="text-align: center; padding: 40px 0; background-color: #2c3e50; color: #ecf0f1;">
            <h1 style="font-size: 48px; margin-bottom: 10px;">Welcome to Our News Platform</h1>
            <p style="font-size: 20px;">Stay updated with the latest news and trending topics!</p>
        </header>

        <!-- Main Content -->
        <main>
            <!-- Latest Articles Section -->
            <section class="latest-articles" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Latest Articles</h2>
                <div class="articles-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @if($articles->isEmpty())
                        <p>No articles available.</p>
                    @else
                        @foreach ($articles as $article)
                            <div class="article-card" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image" style="max-width: 100%; height: auto; display: block; border-radius: 8px;">
                                <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                <p style="color: #555;">{!! Str::limit($article->content, 100) !!}</p>
                                <a href="{{ route('article.show', $article->id) }}" class="read-more" style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read More</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            <!-- Categories Section -->
            <section class="categories" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Categories</h2>
                <div class="categories-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @if($categories->isEmpty())
                        <p>No categories available.</p>
                    @else
                        @foreach ($categories as $category)
                            <a href="{{ route('category.show', $category->category) }}" class="category-item" style="background-color: #3498db; color: #fff; padding: 10px 20px; border-radius: 5px;">{{ $category->category }}</a>
                        @endforeach
                    @endif
                </div>
            </section>

            <!-- Trending Topics Section -->
            <section class="trending-topics" style="margin-top: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Trending Topics</h2>
                <div class="trending-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    @if($trendingArticles->isEmpty())
                        <p>No trending articles available.</p>
                    @else
                        @foreach ($trendingArticles as $article)
                            <div class="trending-item" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $article->title }}</h3>
                                <p>{!! Str::limit($article->content, 50) !!}</p>
                                <a href="{{ route('article.show', $article->id) }}" class="read-more" style="display: inline-block; margin-top: 10px; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Read More</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer style="text-align: center; margin-top: 40px; padding: 20px 0; background-color: #2c3e50; color: #ecf0f1;">
            <p>&copy; 2024 News Platform. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
