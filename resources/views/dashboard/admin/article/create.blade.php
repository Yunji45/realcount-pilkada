@extends('layouts.dashboard.app')

@section('title', 'Pilkada | {{ $title }}')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $type }} {{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('articles.index') }}">{{ $type }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form {{ $type }} {{ $title }}</div>
                    </div>
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama articles -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama Artikel</label>
                                        <input type="text" name="title" class="form-control" id="name"
                                            value="{{ old('title') }}" required />
                                    </div>
                                </div>

                                <!-- Logo articles -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="logo">Images (Opsional)</label>
                                        <input type="file" name="image" class="form-control" id="logo" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="color">Konten</label>
                                        <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                                    </div>
                                </div>

                                <!-- Kategori Artikel -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="category">Kategori Artikel</label>
                                        <select name="category_article_id" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_article_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('articles.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
