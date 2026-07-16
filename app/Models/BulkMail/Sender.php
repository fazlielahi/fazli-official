<?php

namespace App\Models\BulkMail;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sender extends BulkMailModel
{
    protected static string $bulkMailTable = 'senders';

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'is_verified',
        'verified_at',
        'verification_token',
        'domain',
        'domain_verified',
        'is_default',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'domain_verified' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $hidden = [
        'verification_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'sender_id');
    }
}
