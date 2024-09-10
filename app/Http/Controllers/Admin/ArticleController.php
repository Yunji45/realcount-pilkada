<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $title = 'Daftar Artikel';
        $articles = Article::all();
        return view('dashboard.admin.article.index', compact('title','articles'));
    }

    // Menampilkan form untuk membuat artikel baru
    public function create()
    {
        return view('dashboard.admin.article.create');
    }

    // Menyimpan artikel baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048', // Validasi untuk gambar
            'category' => 'required' // Validasi untuk kategori
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Membuat artikel baru
        Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'category' => $request->input('category'), // Menyimpan kategori
            'click-count' => 0 // Inisialisasi click count
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    // Menampilkan detail artikel dan menambahkan jumlah klik
    public function show(Article $article)
    {
        // Tambahkan 1 ke click_count setiap kali artikel diakses
        $article->increment('click-count');

        return view('dashboard.admin.article.show', compact('article'));
    }

    // Menampilkan form untuk mengedit artikel
    public function edit(Article $article)
    {
        $categories = Article::select('category')->distinct()->get();

        return view('dashboard.admin.article.edit', compact('article', 'categories'));
    }

    // Mengupdate artikel yang sudah ada
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category' => 'required' // Validasi kategori
        ]);

        // Mengupdate gambar jika ada file baru
        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Mengupdate artikel
        $article->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'category' => $request->input('category') // Mengupdate kategori
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    // Menghapus artikel
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    // Menampilkan artikel pada landing page dengan pengelompokan kategori
    public function showLandingPage() {
        $articles = Article::latest()->take(6)->get(); // Mengambil 6 artikel terbaru
        $categories = Article::select('category')->distinct()->get(); // Mengambil semua kategori unik
        $trendingArticles = Article::orderBy('click-count', 'desc')->take(5)->get(); // Mengambil 5 artikel dengan click_count tertinggi

        return view('landingpage.berita', compact('articles', 'categories', 'trendingArticles'));
    }

    public function showByCategory($category) {
        // Mengambil artikel berdasarkan kategori
        $articles = Article::where('category', $category)->get();

        // Mengambil semua kategori untuk ditampilkan di sidebar atau bagian kategori
        $categories = Article::select('category')->distinct()->get();

        // Mengambil artikel trending berdasarkan click_count
        $trendingArticles = Article::orderBy('click-count', 'desc')->take(5)->get();

        return view('landingpage.berita', compact('articles', 'categories', 'trendingArticles', 'category'));
    }

    public function showArticle($id) {
        // Mengambil artikel berdasarkan ID
        $article = Article::findOrFail($id);

        // Tambahkan 1 ke click_count setiap kali artikel diakses
        $article->increment('click-count');

        // Menampilkan artikel secara penuh
        return view('landingpage.showArticle', compact('article'));
    }

}
