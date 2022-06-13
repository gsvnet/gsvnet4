<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->string('subject');
            $table->text('body');
            $table->string('slug')->unique();
            $table->integer('most_recent_reply_id');
            $table->integer('reply_count');
            $table->boolean('public')->default(false);
            $table->boolean('private')->default(false); // public and private should be merged one day (enum)
            $table->unsignedInteger('like_count');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_threads');
    }
};
