<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_one_id')->unsigned();
            $table->foreign('user_one_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_two_id')->unsigned();
            $table->foreign('user_two_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('seen_one')->default(0);
            $table->boolean('seen_two')->default(0);
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
        Schema::drop('chats');
    }
}
