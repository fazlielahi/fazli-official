<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('created_by')->nullable();
            $table->string('title', 255);
            $table->text('content');
            $table->text('image')->nullable()->default('blog-default.jpg');
            $table->text('thumb')->nullable()->default('blog-thumb-default.jpg');;
            $table->enum('status', ['published', 'draft', 'request', 'rejected']);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_message')->nullable();
            $table->text('rejection_message')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
}
