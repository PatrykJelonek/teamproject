<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('fields_specializations', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('field_id');
//            $table->foreign('field_id')->references('id')->on('fields');
//            $table->foreignId('specialization_id');
//            $table->foreign('specialization_id')->references('id')->on('specializations');
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
        Schema::dropIfExists('fields_specializations');
    }
}
