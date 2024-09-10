<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <style>
        .article-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .article-title {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .article-content {
            margin-top: 20px;
            font-size: 1.2em;
        }
        .article-image {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="article-container">
        <h1 class="article-title">{{ $article->title }}</h1>
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image">
        @endif
        <p class="article-content">{!! $article->content !!}</p>
        <p><strong>Category:</strong> {{ $article->category }}</p>
    </div>
</body>
</html>
