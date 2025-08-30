<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Services\ArticleService;
use App\Traits\ApiResponse;

class ArticleController extends Controller
{
    use ApiResponse;

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->getAllArticles();
        return $this->successResponse($articles);
    }

    public function getArticleNotAuth()
    {
        $articles = $this->articleService->getArticlesNotAuth();
        return $this->successResponse($articles);
    }

    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        return $this->successResponse($article);
    }

    public function create()
    {
        // Logic to show the form for creating a new article
    }

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleService->createArticle($request->validated());
        return $this->successResponse($article, 'Article created successfully', 201);
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing article
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleService->updateArticle($id, $request->validated());
        return $this->successResponse($article, 'Article updated successfully');
    }

    public function destroy($id)
    {
        $this->articleService->deleteArticle($id);
        return $this->successResponse(null, 'Article deleted successfully');
    }
}
