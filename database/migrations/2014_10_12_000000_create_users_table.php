<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('api_token', 60)->unique()->index();
            $table->string('socket_token', 60)->nullable()->index();
            $table->timestamp('last_online')->nullable();
            $table->integer('picture_media_id')->unsigned()->nullable()->index();
            $table->foreign('picture_media_id')->references('id')->on('media');
            $table->string('locale', 5)->default('en');
            $table->text('options')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
