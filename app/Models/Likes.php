<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = ['visiter_token', 'blog_id'];

    //Each like belongs to one blog post
    public function Blog()
    {
        return $this->belongsTo(Blog::class);
    }
}


