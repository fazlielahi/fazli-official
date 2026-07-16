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
        $recipientsTable = $prefix . 'campaign_recipients';
        $table = $prefix . 'email_logs';

        Schema::create($table, function (Blueprint $table) use ($campaignsTable, $recipientsTable) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained($campaignsTable)->nullOnDelete();
            $table->foreignId('recipient_id')->nullable()->constrained($recipientsTable)->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('status', 20);
            $table->string('provider_message_id')->nullable();
            $table->string('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('bulk-mail.table_prefix', 'bm_') . 'email_logs');
    }
};
