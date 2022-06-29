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
        Schema::create('committee_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();

            $table->foreign('committee_id')->references('id')->on('committees');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('committee_user');
    }
};
