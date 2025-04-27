<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function getAllArticles()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            return Article::with('user')->get();
        }

        return Article::with('user')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })->get();
    }

    public function getArticlesNotAuth()
    {
        $articles = [];
        Article::chunk(2, function ($chunk) use (&$articles) {
            foreach ($chunk as $article) {
                $articles[] = $article;
            }
        });

        return $articles;
    }

    public function getArticleById($id)
    {
        $article = Article::findOrFail($id);
        return $article;
    }

    public function createArticle($data)
    {
        return Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => auth()->id(),
        ]);
    }

    public function updateArticle($id, array $data)
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== auth()->id() && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $article->update($data);
        return $article;
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== auth()->id() && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $article->delete();
    }
}
