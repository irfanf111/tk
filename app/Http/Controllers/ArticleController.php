<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Daftar semua berita yang sudah terbit — 9 per halaman, urut terbaru.
     */
    public function index()
    {
        $articles = Article::published()
            ->whereNotNull('slug')
            ->latest('published_at')
            ->paginate(9);

        return view('berita.index', compact('articles'));
    }

    /**
     * Detail satu berita berdasarkan slug.
     */
    public function show(Article $article)
    {
        // Berita terkait: ambil 4 berita lain terbaru selain yang sedang dibuka
        $relatedArticles = Article::published()
            ->whereNotNull('slug')
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('berita.show', compact('article', 'relatedArticles'));
    }
}
