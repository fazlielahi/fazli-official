<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $prefix = config('bulk-mail.table_prefix', 'bm_');
        $campaignsTable = $prefix . 'campaigns';
        $table = $prefix . 'suppression_list';

        Schema::create($table, function (Blueprint $table) use ($campaignsTable) {
            $table->id();
            $table->string('email');
            $table->string('reason', 20);
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained($campaignsTable)->nullOnDelete();
            $table->timestamps();

            $table->unique(['email', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('bulk-mail.table_prefix', 'bm_') . 'suppression_list');
    }
};
