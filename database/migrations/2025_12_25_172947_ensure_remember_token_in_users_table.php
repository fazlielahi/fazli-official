<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration ensures the remember_token column exists in the users table.
     * This column is required for Laravel's built-in authentication "Remember Me" functionality.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if remember_token column doesn't exist, then add it
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Note: We won't drop the column in down() to avoid breaking existing functionality.
     * If you need to rollback, you can manually remove it.
     */
    public function down(): void
    {
        // Intentionally left empty - we don't want to drop remember_token
        // as it may be needed by Laravel's authentication system
    }
};
