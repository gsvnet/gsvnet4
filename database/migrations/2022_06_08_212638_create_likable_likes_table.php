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
        Schema::create('likable_likes', function (Blueprint $table) {
            $table->id();
            $table->string('likable_id', 36);
            $table->string('likable_type', 100);
            $table->string('user_id', 36)->index();
            $table->timestamps();
            $table->unique(['likable_id', 'likable_type', 'user_id'], 'likable_likes_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likeable_likes');
    }
};
