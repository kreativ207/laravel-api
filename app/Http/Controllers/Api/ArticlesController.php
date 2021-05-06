<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Validator;

class ArticlesController extends Controller
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

    public function storeArticle(Request $request)
    {
        $request_data = $request->only(['title', 'content']);

        $validator_status = $this->validateStoreArticle($request_data);

        if($validator_status->fails()) {
            return response()->json([
                'status' => false,
                'article' => $validator_status->messages()
            ])->setStatusCode('422');
        }

        $article = Article::create([
            "title" => $request->title,
            "content" => $request->content,
        ]);

        return response()->json([
            'status' => true,
            'article' => $article
        ])->setStatusCode('201', 'Article is store');
    }

    public function validateStoreArticle($request_data)
    {
        $validator = Validator::make($request_data, [
            "title" => ['required', 'string'],
            "content" => ['required', 'string'],
        ]);

        return $validator;
    }
}
