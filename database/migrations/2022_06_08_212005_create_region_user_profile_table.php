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
        Schema::create('region_user_profile', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id')->index();
            $table->unsignedBigInteger('user_profile_id')->index();

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('user_profile_id')->references('id')->on('user_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_user_profile');
    }
};
