<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\Article;
use Illuminate\Contracts\Pagination\Paginator;

class Homepage extends Controller
{
    public function index()
    {
        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(2);
        return view('front.homepage', $data);
    }

    public function single($slug)
    {
        $data['article'] = Article::whereSlug($slug)->first() ?? abort(403, 'Article not found!');
        $data['title'] = $data['article']->title;
        return view('front.single', $data);
    }
}
