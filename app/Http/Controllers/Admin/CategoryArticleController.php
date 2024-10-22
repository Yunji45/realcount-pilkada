<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class CategoryArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $articles = CategoryArticle::all();
        $title = 'Category Artikel';
        return view('dashboard.admin.category-article.index', compact('articles', 'title'));
    }

    // Menampilkan form untuk membuat artikel baru
    public function create()
    {
        $title = 'Category Artikel';
        $type = "Tambah Data";
        return view('dashboard.admin.category-article.create', compact('title', 'type'));
    }

    // Menyimpan artikel baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        CategoryArticle::create([
            'category_name' => $request->input('category_name'),
        ]);

        return redirect()->route('category_articles.index')->with('success', 'Article created successfully.');
    }


    // Menampilkan form untuk mengedit artikel
    public function edit(CategoryArticle $category_article)
    {
        $title = 'Category Artikel';
        $type = "Edit Data";
        return view('dashboard.admin.category-article.edit', compact('category_article', 'type', 'title'));
    }


    // Mengupdate artikel yang sudah ada
    public function update(Request $request, CategoryArticle $category_article)
    {
        $category_article->update($request->all());
        return redirect()->route('category_articles.index')->with('success', 'Article updated successfully.');
    }


    // Menghapus artikel
    public function destroy(CategoryArticle $category_article)
    {
        try {
            if ($category_article) {
                $category_article->delete();
                return redirect()->route('category_articles.index')->with('success', 'Article deleted successfully.');
            } else {
                return redirect()->route('category_articles.index')->with('error', 'Article not found.');
            }
        } catch (\Exception $e) {
            return redirect()->route('category_articles.index')->with('error', 'An error occurred while deleting the article.');
        }
    }


    public function showLandingPage()
    {
        $articles = CategoryArticle::latest()->take(6)->get(); // Mengambil 6 artikel terbaru
        return view('landingpage.app', compact('articles'));
    }

    // Menghapus artikel secara massal
    public function massDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            CategoryArticle::whereIn('id', $ids)->delete();
            return redirect()->route('category_articles.index')->with('success', 'Selected category articles have been deleted.');
        }
        return redirect()->route('category_articles.index')->with('error', 'No category articles selected.');
    }

}
