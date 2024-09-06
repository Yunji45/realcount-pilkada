<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Landing page tentang demokrasi">
  <meta name="author" content="Developer Name">
  <title>Democracy Landing Page</title>

  <!-- Bootstrap core CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
    .carousel-inner img {
      width: 100%;
      height: auto;
      max-height: 500px;
      object-fit: cover;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      height: 40px;
      width: 40px;
      background-size: 100%, 100%;
    }
    .carousel-indicators li {
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }
    .carousel-caption h1 {
      font-size: 2rem;
      font-weight: 600;
    }
    .carousel-caption p {
      font-size: 1.1rem;
    }
    .carousel-caption .btn {
      padding: 10px 20px;
      font-size: 1rem;
    }
  </style>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Democracy</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#articles">Articles</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main>

  <!-- Carousel -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('template/assets/img/logo.png') }}" alt="Slide 1" loading="lazy">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Welcome to Democracy</h1>
            <p>Explore the principles and values of democracy through our latest articles.</p>
            <p><a class="btn btn-primary" href="#articles">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('template/assets/img/logo.png') }}" alt="Slide 2" loading="lazy">
        <div class="container">
          <div class="carousel-caption">
            <h1>Our Mission</h1>
            <p>We are dedicated to promoting democratic values and civic engagement.</p>
            <p><a class="btn btn-primary" href="#articles">Discover more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('template/assets/img/logo.png') }}" alt="Slide 3" loading="lazy">
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>Get Involved</h1>
            <p>Join us in making a difference in the community.</p>
            <p><a class="btn btn-primary" href="#articles">Get started</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <!-- Articles Section -->
  <div class="container marketing" id="articles">
    <h2 class="text-center mb-5">Latest Articles</h2>

    <div class="row">
      @foreach ($articles as $article)
        <div class="col-lg-4">
          <img src="{{ asset('storage/' . $article->image) }}" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="{{ $article->title }}">
          <h2>{{ $article->title }}</h2>
          <p>{{ Str::limit($article->content, 100) }}</p>
          <p><a class="btn btn-secondary" href="{{ route('articles.show', $article->id) }}">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      @endforeach
    </div><!-- /.row -->
  </div><!-- /.container -->

  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2024 Democracy Website. All rights reserved. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
