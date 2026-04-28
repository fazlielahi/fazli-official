<?php

$days = (int) env('CV_TRASH_RETENTION_DAYS', 30);

return [

    /*
    |--------------------------------------------------------------------------
    | Trash retention (days)
    |--------------------------------------------------------------------------
    |
    | Fallback when site_settings has no cv_trash_retention_days value (e.g.
    | before migrate/seed, or DB unavailable). Clamped to 1–365. Admin UI
    | stores the live value in site_settings and overrides this for reads.
    |
    */

    'trash_retention_days' => max(1, min(365, $days)),
];
