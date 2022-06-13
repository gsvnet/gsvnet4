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
        Schema::create('forum_threads_visitations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('thread_id');
            $table->timestamp('visited_at');
            $table->timestamps();

            $table->index(['thread_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_threads_visitations');
    }
};
