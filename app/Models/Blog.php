<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Str;

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
        'rejection_message',
        'category_id',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = $blog->generateUniqueSlug();
            }
        });
        
        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = $blog->generateUniqueSlug();
            }
        });
    }

    public function generateUniqueSlug()
    {
        $baseSlug = Str::slug($this->title);
        $slug = $baseSlug;
        $counter = 1;
        
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
