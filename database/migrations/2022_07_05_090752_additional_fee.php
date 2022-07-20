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
        Schema::create('additional_fee', function (Blueprint $table) {
            $table->id('id_additional_fee');
            $table->string('name');
            $table->integer('amount');
            $table->integer('price');
            $table->unsignedBigInteger('id_checkin_room');
            $table->foreign('id_checkin_room')->references('id_checkin_room')->on('checkin');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_fee');
    }
};
