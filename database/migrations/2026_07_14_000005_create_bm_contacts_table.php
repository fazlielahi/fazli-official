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
        $table = $prefix . 'contacts';

        Schema::create($table, function (Blueprint $table) use ($listsTable) {
            $table->id();
            $table->foreignId('list_id')->constrained($listsTable)->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->string('status', 20)->default('active');
            $table->timestamps();

            $table->unique(['list_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('bulk-mail.table_prefix', 'bm_') . 'contacts');
    }
};
