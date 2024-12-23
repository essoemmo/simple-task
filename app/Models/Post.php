<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'description',
    ];

    protected $with = ['comments'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
