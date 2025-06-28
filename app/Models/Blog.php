<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Blog extends Model
{
    //field that can be mass assigned via blog::create(...)
    protected $fillable = [
        'title',
        'content',
        'image',
        'thumb',
        'status',
        'created_by',
        'approved_by',
        'rejected_by',
        'approval_message',
        'rejection_message'
    ];

    public function creater()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function rejected_by_user()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
