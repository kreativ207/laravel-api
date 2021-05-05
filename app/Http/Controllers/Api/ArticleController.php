<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function showArticles()
    {
        $articles = Article::all();
        return response()->json($articles);
        //return Article::all();
    }

    public function showArticle($id)
    {
        $article = Article::find($id);

        if(!$article) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ])->setStatusCode('404', 'Post not found');
        }

        return response()->json($article);
    }
}
