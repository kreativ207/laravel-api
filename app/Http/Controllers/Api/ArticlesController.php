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
                'errors' => $validator_status->messages()
            ])->setStatusCode('422');
        }

        $content = "content"; // PHPStorm ругаеться на свойство $request->content, такой себе костиль ;)
        $article = Article::create([
            "title" => $request->title,
            "content" => $request->$content, // PHPStorm ругаеться на свойство $request->content, такой себе костиль ;)
        ]);

        return response()->json([
            'status' => true,
            'article' => $article
        ])->setStatusCode('201', 'Article is store');
    }

    public function putArticles($id, Request $request)
    {
        $request_data = $request->only(['title', 'content']);

        $validator_status = $this->validateStoreArticle($request_data);

        if($validator_status->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator_status->messages()
            ])->setStatusCode('422');
        }

        $article = Article::find($id);
        if(!$article) {
            return response()->json([
                'status' => false,
                'message' => "Article not found"
            ])->setStatusCode('404', "Article not found");
        }
        return $this->putUpdateArticle($article, $request_data);
    }

    public function patchArticles($id, Request $request)
    {
        $request_data = $request->only(['title', 'content']);

        if(count($request_data) === 0) {
            return response()->json([
                'status' => false,
                'errors' => 'All fields is empty'
            ])->setStatusCode(422, 'All fields is empty');
        }

        $validator_status = $this->patchValidateArticles($request_data);

        if($validator_status->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator_status->messages()
            ])->setStatusCode(422);
        }

        $article = Article::find($id);
        if(!$article) {
            return response()->json([
                'status' => false,
                'message' => "Article not found"
            ])->setStatusCode(404, "Article not found");
        }
        return $this->patchUpdateArticle($article, $request_data);
    }

    public function deleteArticles($id)
    {
        $article = Article::find($id);
        if(!$article) {
            return response()->json([
                'status' => false,
                'message' => "Article not found"
            ])->setStatusCode(404, "Article not found");
        }
        $article->delete();

        return response()->json([
            'status' => true,
            'message' => "Article is delete"
        ])->setStatusCode(200, "Article is delete");
    }

    public function patchUpdateArticle($article, $request_data)
    {
        foreach ($request_data as $key => $val) {
            $article[$key] = $request_data[$key];
        }

        $article->save();

        return response()->json([
            'status' => true,
            'message' => "Article is update"
        ])->setStatusCode(200, "Article is update");
    }

    public function patchValidateArticles($request_data)
    {
        $rules_const = [
            "title" => ['required', 'string'],
            "content" => ['required', 'string'],
        ];

        $rules = [];

        foreach ($request_data as $key => $val) {
            $rules[$key] = $rules_const[$key];
        }

        $validator = Validator::make($request_data, $rules);

        return $validator;

        return $validator;
    }

    public function putUpdateArticle($article, $request_data)
    {
        $article->title = $request_data['title'];
        $article->content = $request_data['content'];
        $article->save();

        return response()->json([
            'status' => true,
            'message' => "Article is update"
        ])->setStatusCode(200, "Article is update");
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
