<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use App\Models\UserCV;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PurgeExpiredTrash extends Command
{
    protected $signature = 'cv:purge-expired-trash {--dry-run : Only report how many would be deleted}';

    protected $description = 'Permanently delete trashed resumes older than the configured retention period';

    public function handle(): int
    {
        $days = SiteSetting::getCvTrashRetentionDays();
        $cutoff = now()->subDays($days);

        $query = UserCV::onlyTrashed()->where('deleted_at', '<=', $cutoff);

        if ((bool) $this->option('dry-run')) {
            $count = (int) $query->count();
            $msg = "Dry run: {$count} trashed resumes are older than {$days} days (cutoff: {$cutoff}).";
            $this->info($msg);
            Log::info('cv:purge-expired-trash dry run', [
                'retention_days' => $days,
                'cutoff' => $cutoff->toDateTimeString(),
                'would_delete' => $count,
            ]);
            return self::SUCCESS;
        }

        $deleted = 0;

        $query
            ->orderBy('id')
            ->chunkById(500, function ($cvs) use (&$deleted) {
                foreach ($cvs as $cv) {
                    $cv->forceDelete();
                    $deleted++;
                }
            });

        $msg = "Deleted {$deleted} trashed resumes older than {$days} days (cutoff: {$cutoff}).";
        $this->info($msg);
        Log::info('cv:purge-expired-trash completed', [
            'retention_days' => $days,
            'cutoff' => $cutoff->toDateTimeString(),
            'deleted' => $deleted,
        ]);

        return self::SUCCESS;
    }
}

