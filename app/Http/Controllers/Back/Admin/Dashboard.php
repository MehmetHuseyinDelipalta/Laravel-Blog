<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistic;

class Dashboard extends Controller
{
    public function index()
    {
        $statistic = new Statistic();
        $data['articlesCount'] = $statistic->getArticleCount();
        $data['usersCount'] = $statistic->getUserCount();
        $data['voteCount'] = $statistic->getVoteCount();
        $data['mostVotedTodayArticleId'] = $statistic->getMostVotedTodayArticleNameandCount()['id'];
        $data['mostVotedTodayArticleName'] = $statistic->getMostVotedTodayArticleNameandCount()['mostVotedTodayArticleName'];
        $data['mostVotedTodayVoteCount'] = $statistic->getMostVotedTodayArticleNameandCount()['voteCount'];
        $data['lastTenUser'] = $statistic->getLastTenUser();
        $data['lastTenArticle'] = $statistic->getLastTenArticle();

        return view('back.admin.dashboard', $data);
    }
}
