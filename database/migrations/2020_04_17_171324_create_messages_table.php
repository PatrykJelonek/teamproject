<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('messages', function (Blueprint $table) {
//            $table->id();
//            $table->string('content', 255);
//            $table->unsignedBigInteger('from_user_id');
//            $table->foreign('from_user_id')->references('id')->on('users');
//            $table->unsignedBigInteger('to_user_id');
//            $table->foreign('to_user_id')->references('id')->on('users');
//            $table->dateTime('created_at', 0);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
