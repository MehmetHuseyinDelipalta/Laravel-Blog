<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
