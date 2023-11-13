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
        //$data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(5);
        $page = request('page', 1); // Varsayılan sayfa 1
        $data['articles'] = cache()->remember("articles-page-$page", 600, function () use ($page) {
            return Article::orderBy('created_at', 'DESC')->paginate(5);
        });
        return view('front.homepage', $data);
    }

    public function single($slug)
    {

        $data['article'] = cache()->remember('article' . $slug, 600, function () use ($slug) {
            return Article::whereSlug($slug)->first() ?? abort(403, 'Article not found!');
        });
        $data['title'] = $data['article']->title;
        return view('front.single', $data);
    }

    public function vote(Request $request)
    {
        if ($request->user()) {
            //daha önce oy vermiş mi? vermişse o oyu güncelle
            $request->user()->votes()->updateOrCreate(
                ['article_id' => $request->article_id],
                ['vote' => $request->rate]
            );
            $article = Article::find($request->article_id);
            return response()->json(['status' => 'success', 'message' => 'Thanks for your vote!', 'rate' => $article->getUpdatedVoteAverage()], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You must login to vote!'], 403);
        }
    }
}
