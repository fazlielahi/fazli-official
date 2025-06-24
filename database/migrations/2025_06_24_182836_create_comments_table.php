<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('visiter_token', 255);
            $table->string('name', 255)->default('Anonymous');
            $table->text('comment');
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Optional: Foreign key constraints (uncomment if you have related tables)
            // $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}
