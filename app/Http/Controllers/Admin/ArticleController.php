<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $articles = Article::all();
        $title = 'Artikel';
        return view('dashboard.admin.article.index', compact('articles', 'title'));
    }

    // Menampilkan form untuk membuat artikel baru
    public function create()
    {
        $title = 'Artikel';
        $type = "Tambah Data";
        $categories = CategoryArticle::all(); // Mengambil semua kategori
        return view('dashboard.admin.article.create', compact('title', 'type', 'categories'));
    }

    // Menyimpan artikel baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_article_id' => 'required|exists:category_articles,id',
            'image' => 'nullable|image|max:2048', // Validasi untuk gambar
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_article_id' => $request->category_article_id,  // This line
            'image' => $imagePath
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }


    // Menampilkan detail artikel
    public function show(Article $article)
    {
        $title = 'Artikel';
        $type = "Tambah Data";
        return view('dashboard.admin.article.show', compact('article', 'title', 'type'));
    }

    // Menampilkan form untuk mengedit artikel
    public function edit(Article $article)
    {
        $title = 'Artikel';
        $type = "Tambah Data";
        $categories = CategoryArticle::all(); // Mengambil semua kategori
        return view('dashboard.admin.article.edit', compact('article', 'title', 'type', 'categories'));
    }

    // Mengupdate artikel yang sudah ada
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        // Mengupdate gambar jika ada file baru
        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $article->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category_article_id' => $request->input('category_article_id'),
            'image' => $imagePath
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    // Menghapus artikel
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function showLandingPage()
    {
        $articles = Article::latest()->simplePaginate(perPage: 6);
        $categories = Article::select('category_article_id')->distinct()->get(); // Mengambil semua kategori unik
        $trendingArticles = Article::orderBy('click-count', 'desc')->take(5)->get(); // Mengambil 5 artikel dengan click_count tertinggi


        return view('landingpage.berita.index', compact('articles', 'trendingArticles', 'categories'));
    }
    public function showLandingPageAll()
    {
        $articles = Article::latest()->simplePaginate(9);
        $trendingArticles = Article::orderBy('click-count', 'desc')->take(5)->get();

        return view('landingpage.berita.show', compact('articles', 'trendingArticles'));
    }

    public function showDetail($id)
    {
        // Ambil artikel berdasarkan id
        $article = Article::findOrFail($id);

        // Update jumlah klik ketika artikel ditampilkan
        $article->increment(column: 'click-count');

        // Ambil 5 artikel terpopuler
        $trendingArticles = Article::orderBy('click-count', 'desc')->take(5)->get();

        return view('landingpage.berita.detail', compact('article', 'trendingArticles'));
    }


}
