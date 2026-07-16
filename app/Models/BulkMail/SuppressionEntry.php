<?php

namespace App\Models\BulkMail;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuppressionEntry extends BulkMailModel
{
    protected static string $bulkMailTable = 'suppression_list';

    protected $fillable = [
        'email',
        'reason',
        'user_id',
        'campaign_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
