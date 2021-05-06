<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\ProductsController;

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
Route::get('/articles', [ArticlesController::class, 'showArticles']);

/***
 * GET
 * Получение одного поста
 * URI: {host}/api/articles/{id}
 */
Route::get('/articles/{id}', [ArticlesController::class, 'showArticle']);

/***
 *POST
 * Запись поста в DB
 * URI: {host}/api/articles
 */

Route::post('/articles', [ArticlesController::class, 'storeArticle']);


/***
 * Homework
 * GET
 * Получение всех товаров из DB
 */
Route::get('/products', [ProductsController::class, 'showProducts']);

/***
 * Homework
 * GET
 * Получение одного товара
 * URI: {host}/api/products/{id}
 */
Route::get('/products/{id}', [ProductsController::class, 'showProduct']);

/***
 * Homework
 * POST
 * Запись товара в DB
 * URI: {host}/api/articles
 */
Route::post('/products', [ProductsController::class, 'storeProduct']);
