<?php

namespace App\Models\BulkMail;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends BulkMailModel
{
    protected static string $bulkMailTable = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'monthly_email_limit',
        'daily_email_limit',
        'max_contacts',
        'max_lists',
        'price',
        'is_active',
    ];

    protected $casts = [
        'monthly_email_limit' => 'integer',
        'daily_email_limit' => 'integer',
        'max_contacts' => 'integer',
        'max_lists' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'plan_id');
    }
}
