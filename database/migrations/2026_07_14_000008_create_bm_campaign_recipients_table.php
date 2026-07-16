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
        $contactsTable = $prefix . 'contacts';
        $table = $prefix . 'campaign_recipients';

        Schema::create($table, function (Blueprint $table) use ($campaignsTable, $contactsTable) {
            $table->id();
            $table->foreignId('campaign_id')->constrained($campaignsTable)->cascadeOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained($contactsTable)->nullOnDelete();
            $table->string('email');
            $table->json('personalization_data')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->string('unsubscribe_token', 64)->unique();
            $table->timestamps();

            $table->unique(['campaign_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('bulk-mail.table_prefix', 'bm_') . 'campaign_recipients');
    }
};
