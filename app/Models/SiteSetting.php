<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const KEY_CV_TRASH_RETENTION_DAYS = 'cv_trash_retention_days';

    private const TRASH_RETENTION_MIN = 1;

    private const TRASH_RETENTION_MAX = 365;

    private const TRASH_RETENTION_DEFAULT = 30;

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
}
