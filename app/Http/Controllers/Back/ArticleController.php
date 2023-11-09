<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;
use File;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view("back.articles.index", compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("back.articles.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]
        );

        $article = new Article;
        $strTitle = Str::slug($request->title);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->slug = $strTitle;
        $article->status = $request->status;
        $article->creator_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $imageName = $strTitle . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Success', 'Article Created Successfully');
        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "Article Show Page";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit işlemi için önce veri tabanından ilgili kaydı bulup değişkene atıyoruz
        $article = Article::findOrFail($id);
        //daha sonra bu değişkeni edit.blade.php ye gönderiyoruz
        return view("back.articles.edit", compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]
        );

        $article = Article::findOrFail($id);
        $strTitle = Str::slug($request->title);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->slug = $strTitle;
        $article->status = $request->status;
        $article->creator_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $imageName = $strTitle . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Success', 'Article Updated Successfully');
        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success('Success', 'Article Deleted Successfully');
        return redirect()->route('article.index');
    }

    public function trash()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view("back.articles.trash", compact('articles'));
    }

    public function recover($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Success', 'Article Restored Successfully');
        return redirect()->route('article.index');
    }



    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->find($id);
        if (File::exists($article->image)) {
            File::delete(public_path($article->image));
        }
        Article::onlyTrashed()->find($id)->forceDelete();
        toastr()->success('Success', 'Article Hard Deleted Successfully');
        return redirect()->route('article.index');
    }
}
