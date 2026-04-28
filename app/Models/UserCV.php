<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Saved CV for a user. SoftDeletes: normal queries omit rows with deleted_at set.
 * Trash UI should use onlyTrashed() / withTrashed() explicitly where needed.
 */
class UserCV extends Model
{
    use SoftDeletes;

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


