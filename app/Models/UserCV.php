<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCV extends Model
{
    protected $table = 'user_cvs';

    protected $fillable = [
        'user_id',
        'template_slug',
        'title',
        'cv_data',
        'is_active',
    ];

    protected $casts = [
        'cv_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns this CV
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this CV
     */
    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'template_slug', 'slug');
    }
}


