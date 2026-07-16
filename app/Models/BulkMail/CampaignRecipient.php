<?php

namespace App\Models\BulkMail;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignRecipient extends BulkMailModel
{
    protected static string $bulkMailTable = 'campaign_recipients';

    protected $fillable = [
        'campaign_id',
        'contact_id',
        'email',
        'personalization_data',
        'status',
        'sent_at',
        'error_message',
        'unsubscribe_token',
    ];

    protected $casts = [
        'personalization_data' => 'array',
        'sent_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class, 'recipient_id');
    }
}
