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
        $articles = Article::all();
        return view('dashboard.admin.article.index', compact('articles'));
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
            'image' => 'nullable|image|max:2048' // Validasi untuk gambar
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    // Menampilkan detail artikel
    public function show(Article $article)
    {
        return view('dashboard.admin.article.show', compact('article'));
    }

    // Menampilkan form untuk mengedit artikel
    public function edit(Article $article)
    {
        return view('dashboard.admin.article.edit', compact('article'));
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

    public function showLandingPage() {
        $articles = Article::latest()->take(6)->get(); // Mengambil 6 artikel terbaru
        return view('landingpage.app', compact('articles'));
    }
}