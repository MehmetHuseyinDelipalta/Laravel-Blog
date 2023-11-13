<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Article extends Model
{

    use HasFactory;
    use SoftDeletes;
    // 1. Define the table name
    protected $table = 'articles';

    // 2. Define the fillable columns
    protected $fillable = ['title', 'image', 'content', 'slug', 'creator_id'];

    // 3. Define the relationships
    public function getCreator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function getPrev()
    {
        return $this->where('publish_date', '<', $this->publish_date)
            ->orderBy('publish_date', 'DESC')
            ->first();
    }

    public function getNext()
    {
        return $this->where('publish_date', '>', $this->publish_date)
            ->orderBy('publish_date', 'ASC')
            ->first();
    }

    public function getUpdatedVoteAverage()
    {
        $subquery = DB::table('votes as v')
            ->select(
                'v.article_id',
                DB::raw('CASE WHEN ROW_NUMBER() OVER (PARTITION BY v.article_id ORDER BY v.created_at DESC) <= (SELECT COUNT(*) * 0.3 FROM votes AS v2 WHERE v2.article_id = v.article_id) THEN v.vote * 2 ELSE v.vote END AS updated_vote'),
                DB::raw('(SELECT COUNT(*) FROM votes AS v2 WHERE v2.article_id = v.article_id) AS article_count')
            )
            ->where('v.article_id', $this->id);

        $data = DB::table(DB::raw('(' . $subquery->toSql() . ') as subquery'))
            ->mergeBindings($subquery)
            ->select('article_id', DB::raw('SUM(updated_vote) / article_count AS updated_vote_avg'))
            ->groupBy('article_id')
            ->get();

        if ($data->isNotEmpty()) {
            $updatedVoteAvg = $data[0]->updated_vote_avg;
            return $updatedVoteAvg;
        } else {
            return 0;
        }
    }
}
