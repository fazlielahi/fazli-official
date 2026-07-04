<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const KEY_CV_TRASH_RETENTION_DAYS = 'cv_trash_retention_days';

    public const KEY_SESSION_LIFETIME_MINUTES = 'session_lifetime_minutes';

    public const KEY_REMEMBER_ME_DAYS = 'remember_me_days';

    public const KEY_SESSION_EXPIRE_ON_CLOSE = 'session_expire_on_close';

    private const TRASH_RETENTION_MIN = 1;

    private const TRASH_RETENTION_MAX = 365;

    private const TRASH_RETENTION_DEFAULT = 30;

    private const SESSION_LIFETIME_MIN = 5;

    private const SESSION_LIFETIME_MAX = 10080;

    private const REMEMBER_ME_MIN = 1;

    private const REMEMBER_ME_MAX = 365;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::query()->where('key', $key)->value('value');

        return $value !== null && $value !== '' ? (string) $value : $default;
    }

    public static function set(string $key, string $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getCvTrashRetentionDays(): int
    {
        $raw = static::get(self::KEY_CV_TRASH_RETENTION_DAYS);
        if ($raw === null || ! is_numeric($raw)) {
            return max(
                self::TRASH_RETENTION_MIN,
                min(self::TRASH_RETENTION_MAX, (int) config('cv.trash_retention_days', self::TRASH_RETENTION_DEFAULT))
            );
        }

        return max(self::TRASH_RETENTION_MIN, min(self::TRASH_RETENTION_MAX, (int) $raw));
    }

    public static function setCvTrashRetentionDays(int $days): void
    {
        $days = max(self::TRASH_RETENTION_MIN, min(self::TRASH_RETENTION_MAX, $days));
        static::set(self::KEY_CV_TRASH_RETENTION_DAYS, (string) $days);
    }

    public static function getSessionLifetimeMinutes(): int
    {
        $raw = static::get(self::KEY_SESSION_LIFETIME_MINUTES);
        if ($raw === null || ! is_numeric($raw)) {
            return (int) config('site.session_lifetime_minutes', 120);
        }

        return max(self::SESSION_LIFETIME_MIN, min(self::SESSION_LIFETIME_MAX, (int) $raw));
    }

    public static function setSessionLifetimeMinutes(int $minutes): void
    {
        $minutes = max(self::SESSION_LIFETIME_MIN, min(self::SESSION_LIFETIME_MAX, $minutes));
        static::set(self::KEY_SESSION_LIFETIME_MINUTES, (string) $minutes);
    }

    public static function getRememberMeDays(): int
    {
        $raw = static::get(self::KEY_REMEMBER_ME_DAYS);
        if ($raw === null || ! is_numeric($raw)) {
            return (int) config('site.remember_me_days', 30);
        }

        return max(self::REMEMBER_ME_MIN, min(self::REMEMBER_ME_MAX, (int) $raw));
    }

    public static function setRememberMeDays(int $days): void
    {
        $days = max(self::REMEMBER_ME_MIN, min(self::REMEMBER_ME_MAX, $days));
        static::set(self::KEY_REMEMBER_ME_DAYS, (string) $days);
    }

    public static function getSessionExpireOnClose(): bool
    {
        $raw = static::get(self::KEY_SESSION_EXPIRE_ON_CLOSE);
        if ($raw === null) {
            return (bool) config('site.session_expire_on_close', false);
        }

        return in_array(strtolower((string) $raw), ['1', 'true', 'yes', 'on'], true);
    }

    public static function setSessionExpireOnClose(bool $enabled): void
    {
        static::set(self::KEY_SESSION_EXPIRE_ON_CLOSE, $enabled ? '1' : '0');
    }

    /**
     * @return array{
     *     session_lifetime_minutes: int,
     *     remember_me_days: int,
     *     session_expire_on_close: bool,
     *     trash_retention_days: int
     * }
     */
    public static function allForAdmin(): array
    {
        return [
            'session_lifetime_minutes' => static::getSessionLifetimeMinutes(),
            'remember_me_days' => static::getRememberMeDays(),
            'session_expire_on_close' => static::getSessionExpireOnClose(),
            'trash_retention_days' => static::getCvTrashRetentionDays(),
        ];
    }
}
