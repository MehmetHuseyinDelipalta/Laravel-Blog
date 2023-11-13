<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return \Illuminate\Support\Facades\Auth::user();
    });
    Route::get('/article/all', 'App\Http\Controllers\Api\ArticleController@getAllArticle')->name('api.article.all');
    Route::get('/article/{id}', 'App\Http\Controllers\Api\ArticleController@getArticle')->name('api.article.get');
    Route::post('/article/search', 'App\Http\Controllers\Api\ArticleController@searchArticle')->name('api.article.search');
    Route::post('/article/create', 'App\Http\Controllers\Api\ArticleController@createArticle')->name('api.article.create');
    Route::post('/article/update/{id}', 'App\Http\Controllers\Api\ArticleController@updateArticle')->name('api.article.update');
    Route::get('/article/delete/{id}', 'App\Http\Controllers\Api\ArticleController@deleteArticle')->name('api.article.delete');
    Route::get('/article/trash/all', 'App\Http\Controllers\Api\ArticleController@getAllTrashArticle')->name('api.article.trash.all');
    Route::get('/article/trash/{id}', 'App\Http\Controllers\Api\ArticleController@getTrashArticle')->name('api.article.trash.get');
    Route::get('/article/trash/restore/{id}', 'App\Http\Controllers\Api\ArticleController@restoreTrashArticle')->name('api.article.trash.restore');
    Route::get('/article/trash/delete/{id}', 'App\Http\Controllers\Api\ArticleController@deleteTrashArticle')->name('api.article.trash.delete');
});


Route::get('/ornek', 'App\Http\Controllers\Api\AuthController@index')->name('api.ornek');

Route::post('/login', 'App\Http\Controllers\Api\AuthController@login')->name('api.login');
