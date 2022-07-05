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
        Schema::create('price_room', function (Blueprint $table) {
            $table->increments('id_price_room');
            $table->integer('first_hour');
            $table->integer('next_hour');
            $table->unsignedBigInteger('id_type_room');
            $table->foreign('id_type_room')->references('id_type_room')->on('type_room');
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
        Schema::dropIfExists('price_room');
    }
};