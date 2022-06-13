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
            $table->unsignedInteger('committee_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->timestamps();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
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
