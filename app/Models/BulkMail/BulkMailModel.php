<?php

namespace App\Models\BulkMail;

use Illuminate\Database\Eloquent\Model;

abstract class BulkMailModel extends Model
{
    protected static string $bulkMailTable;

    public function getTable()
    {
        return config('bulk-mail.table_prefix', 'bm_') . static::$bulkMailTable;
    }
}
