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
        Schema::create('malfonds_invites', function (Blueprint $table) {
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('host_id');
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->dateTime('invited_at')->useCurrent();
            $table->string('title');

            $table->foreign('guest_id')->references('id')->on('users');
            $table->foreign('host_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('malfonds_invites');
    }
};
