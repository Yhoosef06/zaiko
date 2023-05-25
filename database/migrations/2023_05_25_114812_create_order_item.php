<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_temp_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->integer('quantity');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->string('order_serial_number');
            $table->date('date_returned');
            $table->string('returned_to');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('order_temp_isd')->references('id')->on('order_item_temp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item');
    }
}
