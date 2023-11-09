<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable // Model
{
    // 1. Define the table name
    protected $table = 'users';

    // 2. Define the fillable columns
    protected $fillable = ['name', 'email', 'password'];

    // 3. Define the relationships
    public function articles()
    {
        return $this->hasMany(Article::class, 'creator_id', 'id');
    }
}
