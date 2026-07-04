<?php

$sessionLifetime = (int) env('SESSION_LIFETIME', 120);
$rememberMeDays = (int) env('REMEMBER_ME_DAYS', 30);

return [
    'session_lifetime_minutes' => max(5, min(10080, $sessionLifetime)),
    'remember_me_days' => max(1, min(365, $rememberMeDays)),
    'session_expire_on_close' => filter_var(env('SESSION_EXPIRE_ON_CLOSE', false), FILTER_VALIDATE_BOOL),
];
