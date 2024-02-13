<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @param  Article $article
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, Article $article): AnonymousResourceCollection
    {
        return ArticleResource::collection($article->adminList($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article): ArticleResource
    {
        return new ArticleResource($article->store($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article->show());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): ArticleResource
    {
        return new ArticleResource($article->edit());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): ArticleResource
    {
        return new ArticleResource($article->renew($request));
    }

    /**
     * Remove an article. Might soft delete or remove permanently.
     *
     * @param  Request $request
     * @param  Article $article
     * @return boolean|ArticleResource
     */
    public function destroy(Request $request, Article $article): bool|ArticleResource
    {
        // Might return bool or model
        $article = $article->remove($request);
        if(is_bool($article)) {
            return response()->json($article);
        }
        return new ArticleResource($article);
    }
}
