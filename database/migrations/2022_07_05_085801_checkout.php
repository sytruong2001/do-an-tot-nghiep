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
        Schema::create('checkout', function (Blueprint $table) {
            $table->id('id_checkout_room');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->unsignedBigInteger('id_checkin_room');
            $table->foreign('id_checkin_room')->references('id_checkin_room')->on('checkin');
            $table->integer('sum_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout');
    }
};