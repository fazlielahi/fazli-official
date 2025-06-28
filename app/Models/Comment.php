<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $fillable = ['blog_id', 'visiter_token', 'comment', 'name', 'user_id'];

    //Each comment belongs to 1 blog post
    public function blog()
    {
        return $this->belongsTo(Blog::class); 
    }

    //Each comment belongs to 1 user
    public function user()
    {
        return $this->belongsTo(User::class); 
    }

     /**
     * Check if comment was made by a registered user.
     */
    public function isFromRegisteredUser()
    {
        return !is_null($this->user_id);
    }
}
