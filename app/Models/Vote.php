<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    // 1. Define the table name
    protected $table = 'votes';

    // 2. Define the fillable columns

    protected $fillable = ['user_id', 'article_id', 'vote'];

    // 3. Define the relationships

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
