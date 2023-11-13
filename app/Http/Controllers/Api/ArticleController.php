<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'success'], 200);
    }

    public function getAllArticle()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator')) {
            $articles = Article::orderByDesc('publish_date')->get();
            if ($articles->count() == 0) {
                return response()->json(['status' => 'error', 'message' => 'No Articles Found!'], 404);
            }
        } elseif (auth()->user()->hasRole('creator')) {
            $articles = Article::where('creator_id', auth()->user()->id)
                ->orderByDesc('publish_date')
                ->get();
            if ($articles->count() == 0) {
                return response()->json(['status' => 'error', 'message' => 'No Articles Found!'], 404);
            }
        } else {
            $articles = Article::where('status', 'active')
                ->where('publish_date', '<=', now())
                ->orderByDesc('publish_date')
                ->get();
            if ($articles->count() == 0) {
                return response()->json(['status' => 'error', 'message' => 'No Articles Found!'], 404);
            }
        }
        return response()->json(['status' => 'success', 'articles' => $articles], 200);
    }

    public function getArticle($id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator')) {
            $article = Article::whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
        } elseif (auth()->user()->hasRole('creator')) {
            $article = Article::whereId($id)
                ->where('user_id', auth()->user()->id)
                ->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
        } else {
            $article = Article::whereId($id)
                ->where('status', 'active')
                ->where('publish_date', '<=', now())
                ->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
        }
        return response()->json(['status' => 'success', 'article' => $article], 200);
    }

    public function createArticle(Request $request)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $request->validate([
                'title' => 'required|min:3',
                'content' => 'required|min:10',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'publish_date' => 'required|date|after_or_equal:today',
                'status' => 'required|in:active,draft',
            ]);

            $article = new Article;
            $strTitle = Str::slug($request->title);
            $article->title = $request->title;
            $article->content = $request->content;
            $article->slug = $strTitle;
            $article->status = $request->status;
            $article->publish_date = $request->publish_date;
            $article->creator_id = auth()->user()->id;

            if ($request->hasFile('image')) {
                $imageName = $strTitle . Str::random(16) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads'), $imageName);
                $article->image = 'uploads/' . $imageName;
            }
            $article->save();
            return response()->json(['status' => 'success', 'message' => 'Article Created Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to create article!'], 401);
        }
    }

    public function updateArticle(Request $request, $id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $request->validate([
                'title' => 'required|min:3',
                'content' => 'required|min:10',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                'publish_date' => 'required|date|after_or_equal:today',
                'status' => 'required|in:active,draft',
            ]);

            $article = Article::whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to update article!'], 401);
            }
            $strTitle = Str::slug($request->title);
            $article->title = $request->title;
            $article->content = $request->content;
            $article->slug = $strTitle;
            $article->status = $request->status;
            $article->publish_date = $request->publish_date;
            $article->creator_id = auth()->user()->id;

            if ($request->hasFile('image')) {
                $imageName = $strTitle . Str::random(16) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads'), $imageName);
                $article->image = 'uploads/' . $imageName;
            }
            $article->save();
            return response()->json(['status' => 'success', 'message' => 'Article Updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to update article!'], 401);
        }
    }

    public function deleteArticle($id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $article = Article::whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to delete article!'], 401);
            }
            $article->delete();
            return response()->json(['status' => 'success', 'message' => 'Article Deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to delete article!'], 401);
        }
    }

    public function getAllTrashArticle()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $articles = Article::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
            if ($articles->count() == 0) {
                return response()->json(['status' => 'error', 'message' => 'No Articles Found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to view trash article!'], 401);
            }
            return response()->json(['status' => 'success', 'articles' => $articles], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to view trash article!'], 401);
        }
    }

    public function getTrashArticle($id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $article = Article::onlyTrashed()->whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to view trash article!'], 401);
            }
            return response()->json(['status' => 'success', 'article' => $article], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to view trash article!'], 401);
        }
    }

    public function restoreTrashArticle($id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $article = Article::onlyTrashed()->whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to restore trash article!'], 401);
            }
            $article->restore();
            return response()->json(['status' => 'success', 'message' => 'Article Restored Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to restore trash article!'], 401);
        }
    }

    public function deleteTrashArticle($id)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('creator')) {
            $article = Article::onlyTrashed()->whereId($id)->first();
            if (!$article) {
                return response()->json(['status' => 'error', 'message' => 'Article not found!'], 404);
            }
            if ($article->creator_id != auth()->user()->id and (!auth()->user()->hasRole('admin') or !auth()->user()->hasRole('moderator'))) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to delete trash article!'], 401);
            }
            $article->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'Article Deleted Permanently'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to delete trash article!'], 401);
        }
    }

    public function searchArticle(Request $request)
    {
        $request->validate([
            'search' => 'required|min:3'
        ]);
        $articles = Article::where('title', 'like', '%' . $request->search . '%')
            ->orWhere('content', 'like', '%' . $request->search . '%')
            ->orderByDesc('publish_date')
            ->get();
        if ($articles->count() == 0) {
            return response()->json(['status' => 'error', 'message' => 'No Articles Found!'], 404);
        }
        return response()->json(['status' => 'success', 'articles' => $articles], 200);
    }
}
