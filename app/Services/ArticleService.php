<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getAllArticles()
    {
        return Article::with('user')->get();
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
        $article->update($data);
        return $article;
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
    }
}
