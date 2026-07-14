<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database table prefix
    |--------------------------------------------------------------------------
    |
    | Prefix for BulkMailer tables (e.g. bm_campaigns, bm_contacts).
    |
    */

    'table_prefix' => env('BULK_MAIL_TABLE_PREFIX', 'bm_'),

    /*
    |--------------------------------------------------------------------------
    | Queue batch size
    |--------------------------------------------------------------------------
    |
    | Number of emails dispatched per queue batch when sending a campaign.
    |
    */

    'batch_size' => max(1, (int) env('BULK_MAIL_BATCH_SIZE', 50)),

    /*
    |--------------------------------------------------------------------------
    | Failed send retries
    |--------------------------------------------------------------------------
    |
    | How many times a failed campaign email job is retried before marking
    | the recipient as permanently failed.
    |
    */

    'retry_attempts' => max(0, (int) env('BULK_MAIL_RETRY_ATTEMPTS', 3)),

    /*
    |--------------------------------------------------------------------------
    | Default sending limits (Free plan fallback)
    |--------------------------------------------------------------------------
    |
    | Used when a user has no active subscription row yet. Plan-specific
    | limits are stored in bm_subscription_plans and enforced per user.
    |
    */

    'default_daily_limit' => max(1, (int) env('BULK_MAIL_DAILY_LIMIT', 100)),

    'default_monthly_limit' => max(1, (int) env('BULK_MAIL_MONTHLY_LIMIT', 1000)),

    /*
    |--------------------------------------------------------------------------
    | Amazon SES
    |--------------------------------------------------------------------------
    |
    | Region used for outbound campaign email. Credentials are read from the
    | standard AWS_* env vars via config/services.php.
    |
    */

    'ses_region' => env('BULK_MAIL_SES_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),

];
