<?php

namespace App\Models\BulkMail;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends BulkMailModel
{
    protected static string $bulkMailTable = 'user_subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'starts_at',
        'ends_at',
        'emails_sent_today',
        'emails_sent_month',
        'quota_reset_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'emails_sent_today' => 'integer',
        'emails_sent_month' => 'integer',
        'quota_reset_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}
