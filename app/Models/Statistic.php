<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Statistic extends Model
{
    public function getVoteCount()
    {
        return \App\Models\Vote::all()->count();
    }
    public function getVoteCountUser($id)
    {
        return \App\Models\Vote::join('articles', 'articles.id', '=', 'votes.article_id')
            ->where('articles.creator_id', $id)
            ->count();
    }

    public function getArticleCount()
    {
        return \App\Models\Article::all()->count();
    }
    public function getArticleCountUser($id)
    {
        return \App\Models\Article::where('creator_id', $id)->count();
    }

    public function getUserCount()
    {
        return \App\Models\User::all()->count();
    }

    public function getMostVotedTodayArticleNameandCount()
    {
        $mostVotedTodayArticles = \App\Models\Article::select('articles.title', \DB::raw('COUNT(votes.id) as vote_count'), 'articles.id')
            ->join('votes', 'articles.id', '=', 'votes.article_id')
            ->whereDate('votes.created_at', now()->toDateString())
            ->groupBy('articles.id', 'articles.title')
            ->orderByDesc('vote_count')
            ->first();
        if ($mostVotedTodayArticles) {
            $mostVotedTodayArticleName = strlen($mostVotedTodayArticles->title) > 20 ? substr($mostVotedTodayArticles->title, 0, 20) . "..." : $mostVotedTodayArticles->title;
            $voteCount = $mostVotedTodayArticles->vote_count;
            $id = $mostVotedTodayArticles->id;
        } else {
            $mostVotedTodayArticleName = "Today, no article has received votes.";
            $voteCount = 0;
            $id = '';
        }

        $returnData = [
            'mostVotedTodayArticleName' => $mostVotedTodayArticleName,
            'id' => $id,
            'voteCount' => $voteCount
        ];

        return $returnData;
    }
    public function getMostVotedTodayArticleNameandCountUser($id)
    {
        $mostVotedTodayArticles = \App\Models\Article::select('articles.title', \DB::raw('COUNT(votes.id) as vote_count'), 'articles.id')
            ->join('votes', 'articles.id', '=', 'votes.article_id')
            ->whereDate('votes.created_at', now()->toDateString())
            ->where('articles.creator_id', $id)
            ->groupBy('articles.id', 'articles.title')
            ->orderByDesc('vote_count')
            ->first();
        if ($mostVotedTodayArticles) {
            $mostVotedTodayArticleName = strlen($mostVotedTodayArticles->title) > 20 ? substr($mostVotedTodayArticles->title, 0, 20) . "..." : $mostVotedTodayArticles->title;
            $voteCount = $mostVotedTodayArticles->vote_count;
            $id = $mostVotedTodayArticles->id;
        } else {
            $mostVotedTodayArticleName = "Today, no article has received votes.";
            $voteCount = 0;
            $id = '';
        }

        $returnData = [
            'mostVotedTodayArticleName' => $mostVotedTodayArticleName,
            'id' => $id,
            'voteCount' => $voteCount
        ];
        return $returnData;
    }

    public function getMostVotedTodayVoteCount()
    {
        $mostVotedTodayArticles = \App\Models\Article::select('articles.title', \DB::raw('COUNT(votes.id) as vote_count'))
            ->join('votes', 'articles.id', '=', 'votes.article_id')
            ->whereDate('votes.created_at', now()->toDateString())
            ->groupBy('articles.id', 'articles.title')
            ->orderByDesc('vote_count')
            ->first();

        if ($mostVotedTodayArticles) {
            $mostVotedTodayArticleName = $mostVotedTodayArticles->title;
            $voteCount = $mostVotedTodayArticles->vote_count;
        } else {
            $mostVotedTodayArticleName = "Bugün oy almayan bir makale bulunamadı.";
            $voteCount = 0;
        }

        return $voteCount;
    }

    public function getLastTenUser()
    {
        $lastTenUser = \App\Models\User::select('name', 'email', 'created_at')
            ->where('role', 'user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return $lastTenUser;
    }

    public function getLastTenArticle()
    {
        $lastTenArticle = \App\Models\Article::select('title', 'created_at', 'creator_id', 'slug', 'id')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return $lastTenArticle;
    }
    public function getLastTenArticleUser($id)
    {
        $lastTenArticle = \App\Models\Article::select('title', 'created_at', 'creator_id', 'slug', 'id')
            ->where('creator_id', $id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return $lastTenArticle;
    }
}
