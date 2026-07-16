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
        $listsTable = $prefix . 'contact_lists';
        $sendersTable = $prefix . 'senders';
        $templatesTable = $prefix . 'email_templates';
        $table = $prefix . 'campaigns';

        Schema::create($table, function (Blueprint $table) use ($listsTable, $sendersTable, $templatesTable) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('list_id')->nullable()->constrained($listsTable)->nullOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained($sendersTable)->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained($templatesTable)->nullOnDelete();
            $table->string('name');
            $table->string('subject');
            $table->longText('body');
            $table->string('status', 20)->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedInteger('total_recipients')->default(0);
            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->unsignedInteger('bounced_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('bulk-mail.table_prefix', 'bm_') . 'campaigns');
    }
};
