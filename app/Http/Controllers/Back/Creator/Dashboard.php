<?php

namespace App\Http\Controllers\Back\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistic;

class Dashboard extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $statistic = new Statistic();
        $data['articlesCountUser'] = $statistic->getArticleCountUser($user->id);
        $data['voteCountUser'] = $statistic->getVoteCountUser($user->id);
        $getMostVotedTodayArticleNameandCount = $statistic->getMostVotedTodayArticleNameandCountUser($user->id);
        $data['mostUserVotedTodayArticleId'] = $getMostVotedTodayArticleNameandCount['id'];
        $data['mostUserVotedTodayArticleName'] = $getMostVotedTodayArticleNameandCount['mostVotedTodayArticleName'];
        $data['mostUserVotedTodayVoteCount'] = $getMostVotedTodayArticleNameandCount['voteCount'];
        $data['lastTenArticleUser'] = $statistic->getLastTenArticleUser($user->id);
        return view('back.creator.dashboard', $data);
    }
}
