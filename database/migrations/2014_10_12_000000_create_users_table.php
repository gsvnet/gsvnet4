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
        Schema::create('users', function (Blueprint $table) {
//            $table->engine = 'MyISAM'; // means you can't use foreign key constraints // Disabled in gsvnet4; could lead to error

            $table->id();
            // distinguishing (0) visitor, (1) potential, (2) member, (3) former member
            $table->integer('type')->default(0);

            $table->string('username');
            $table->string('firstname')->index();
            $table->string('middlename')->nullable();
            $table->string('lastname')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('approved')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->fullText(['firstname', 'middlename', 'lastname']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
