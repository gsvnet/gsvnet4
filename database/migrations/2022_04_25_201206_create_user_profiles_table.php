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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('year_group_id')->nullable();
            $table->string('initials')->nullable();
            $table->string('photo_path')->nullable();

            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('town')->nullable();
            $table->string('country')->nullable();

            $table->string('study')->nullable();
            $table->string('student_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('gender')->nullable(); // Represented by GenderEnum
//            $table->boolean('reunist')->default(0); Redundant because of User type
            $table->boolean('alive')->default(1);

            $table->string('parent_address')->nullable();
            $table->string('parent_zip_code')->nullable();
            $table->string('parent_town')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_email')->nullable();

            $table->date('inauguration_date')->nullable()->default(null);
            $table->date('resignation_date')->nullable()->default(null);

            $table->string('company')->nullable();
            $table->string('profession')->nullable();
            $table->string('business_url')->nullable();

            $table->boolean('receive_newspaper')->default(0);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('year_group_id')->references('id')->on('year_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
