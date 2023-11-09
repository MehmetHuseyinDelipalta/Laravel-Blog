<?php

use Illuminate\Support\Facades\Route;

// isLogin middleware ile korunan rotalar
Route::middleware(['isLogin'])->group(function () {
    Route::get('/login', 'App\Http\Controllers\Back\AuthController@login')->name('login');
    Route::post('/login', 'App\Http\Controllers\Back\AuthController@loginPost')->name('login.post');
});

// isAdmin middleware ile korunan rotalar
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\Back\Dashboard@index')->name('admin.dashboard');
    Route::get('/admin/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('admin.logout');
    Route::resource('/admin/article', 'App\Http\Controllers\Back\ArticleController');
    Route::get('/admin/delete/article/{id}', 'App\Http\Controllers\Back\ArticleController@delete')->name('admin.delete.article');
    Route::get('/admin/trash/article', 'App\Http\Controllers\Back\ArticleController@trash')->name('admin.trash.article');
    Route::get('/admin/recover/article/{id}', 'App\Http\Controllers\Back\ArticleController@recover')->name('admin.recover.article');
    Route::get('/admin/forceDelete/article/{id}', 'App\Http\Controllers\Back\ArticleController@forceDelete')->name('admin.forceDelete.article');
});


// isCreator middleware ile korunan rotalar
Route::middleware(['isCreator'])->group(function () {
    Route::get('/creator/dashboard', 'App\Http\Controllers\Back\Dashboard@index')->name('creator/dashboard');
    Route::get('/creator/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('/creator/logout');
});

// isModerator middleware ile korunan rotalar
Route::middleware(['isModerator'])->group(function () {
    Route::get('/moderator/dashboard', 'App\Http\Controllers\Back\Dashboard@index')->name('moderator/dashboard');
    Route::get('/moderator/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('/moderator/logout');
});


// isUser middleware ile korunan rotalar
Route::middleware(['isUser'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\Back\Dashboard@index')->name('dashboard');
    Route::get('/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('/logout');
});

// Ortak rotalar
Route::get('/register', 'App\Http\Controllers\Back\AuthController@register')->name('register');
Route::post('/register', 'App\Http\Controllers\Back\AuthController@registerPost')->name('register.post');
Route::get('/', 'App\Http\Controllers\Front\Homepage@index')->name('homepage');
Route::get('/blog/{slug}', 'App\Http\Controllers\Front\Homepage@single')->name('single');
