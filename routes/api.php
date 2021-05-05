<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/***
 * GET
 * Получение всех постов из DB
 * URI: {host}/api/articles
 */
Route::get('/articles', [ArticleController::class, 'showArticles']);

/***
 * GET
 * Получение одного поста
 * URI: {host}/api/articles/{id}
 */
Route::get('/articles/{id}', [ArticleController::class, 'showArticle']);
