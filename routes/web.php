<?php

use Illuminate\Support\Facades\Route;

// isLogin middleware ile korunan rotalar
Route::middleware(['isLogin'])->group(function () {
    Route::get('/login', 'App\Http\Controllers\Back\AuthController@login')->name('login');
    Route::post('/login', 'App\Http\Controllers\Back\AuthController@loginPost')->name('login.post');
});

// isAdmin middleware ile korunan rotalar
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\Back\Admin\Dashboard@index')->name('admin.dashboard');
    Route::get('/admin/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('admin.logout');
    Route::get('/admin/delete/article/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@delete')->name('admin.delete.article');
    Route::get('/admin/trash/article', 'App\Http\Controllers\Back\Admin\ArticleController@trash')->name('admin.trash.article');
    Route::get('/admin/recover/article/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@recover')->name('admin.recover.article');
    Route::get('/admin/forceDelete/article/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@forceDelete')->name('admin.forceDelete.article');

    Route::get('/admin/article/index', 'App\Http\Controllers\Back\Admin\ArticleController@index')->name('admin.article.index');
    Route::get('/admin/article/create', 'App\Http\Controllers\Back\Admin\ArticleController@create')->name('admin.article.create');
    Route::post('/admin/article/create', 'App\Http\Controllers\Back\Admin\ArticleController@store')->name('admin.article.store');
    Route::get('/admin/article/edit/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@edit')->name('admin.article.edit');
    Route::put('/admin/article/edit/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@update')->name('admin.article.update');
    Route::get('/admin/article/show/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@show')->name('admin.article.show');
    Route::get('/admin/article/delete/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@delete')->name('admin.article.delete');
    Route::get('/admin/article/hardDelete/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@hardDelete')->name('admin.article.hardDelete');
    Route::get('/admin/article/recover/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@recover')->name('admin.article.recover');
    Route::get('/admin/article/trash', 'App\Http\Controllers\Back\Admin\ArticleController@trash')->name('admin.article.trash');
    Route::get('/admin/article/destroy/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@destroy')->name('admin.article.destroy');
    Route::get('/admin/article/restore/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@restore')->name('admin.article.restore');
    Route::get('/admin/article/forceDelete/{id}', 'App\Http\Controllers\Back\Admin\ArticleController@forceDelete')->name('admin.article.forceDelete');
});


// isCreator middleware ile korunan rotalar
Route::middleware(['isCreator'])->group(function () {
    Route::get('/creator/dashboard', 'App\Http\Controllers\Back\Creator\Dashboard@index')->name('creator.dashboard');
    Route::get('/creator/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('creator.logout');
    Route::get('/creator/delete/article/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@delete')->name('creator.delete.article');
    Route::get('/creator/trash/article', 'App\Http\Controllers\Back\Creator\ArticleController@trash')->name('creator.trash.article');
    Route::get('/creator/recover/article/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@recover')->name('creator.recover.article');
    Route::get('/creator/forceDelete/article/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@forceDelete')->name('creator.forceDelete.article');

    Route::get('/creator/article/index', 'App\Http\Controllers\Back\Creator\ArticleController@index')->name('creator.article.index');
    Route::get('/creator/article/create', 'App\Http\Controllers\Back\Creator\ArticleController@create')->name('creator.article.create');
    Route::post('/creator/article/create', 'App\Http\Controllers\Back\Creator\ArticleController@store')->name('creator.article.store');
    Route::get('/creator/article/edit/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@edit')->name('creator.article.edit');
    Route::put('/creator/article/edit/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@update')->name('creator.article.update');
    Route::get('/creator/article/show/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@show')->name('creator.article.show');
    Route::get('/creator/article/delete/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@delete')->name('creator.article.delete');
    Route::get('/creator/article/hardDelete/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@hardDelete')->name('creator.article.hardDelete');
    Route::get('/creator/article/recover/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@recover')->name('creator.article.recover');
    Route::get('/creator/article/trash', 'App\Http\Controllers\Back\Creator\ArticleController@trash')->name('creator.article.trash');
    Route::get('/creator/article/destroy/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@destroy')->name('creator.article.destroy');
    Route::get('/creator/article/restore/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@restore')->name('creator.article.restore');
    Route::get('/creator/article/forceDelete/{id}', 'App\Http\Controllers\Back\Creator\ArticleController@forceDelete')->name('creator.article.forceDelete');
});

// isUser middleware ile korunan rotalar
Route::middleware(['isUser'])->group(function () {
    Route::get('/homepage', 'App\Http\Controllers\Front\Homepage@index')->name('homepage');
});

// Ortak rotalar
Route::get('/register', 'App\Http\Controllers\Back\AuthController@register')->name('register');
Route::post('/register', 'App\Http\Controllers\Back\AuthController@registerPost')->name('register.post');
Route::get('/', 'App\Http\Controllers\Front\Homepage@index')->name('homepage');
Route::get('/blog/{slug}', 'App\Http\Controllers\Front\Homepage@single')->name('single');
Route::post('vote', 'App\Http\Controllers\Front\Homepage@vote')->name('vote');
Route::get('/logout', 'App\Http\Controllers\Back\AuthController@logout')->name('logout');
