<?php

namespace App\Models\BulkMail;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends BulkMailModel
{
    protected static string $bulkMailTable = 'contacts';

    protected $fillable = [
        'list_id',
        'user_id',
        'email',
        'first_name',
        'last_name',
        'company',
        'position',
        'city',
        'country',
        'tags',
        'is_valid',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_valid' => 'boolean',
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(ContactList::class, 'list_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaignRecipients(): HasMany
    {
        return $this->hasMany(CampaignRecipient::class, 'contact_id');
    }
}
