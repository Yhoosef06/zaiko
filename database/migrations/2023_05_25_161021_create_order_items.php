<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_temp_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->integer('order_quantity');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->string('order_serial_number')->nullable();
            $table->date('date_returned');
            $table->string('released_by')->nullable();
            $table->string('returned_to')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_number')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('order_temp_id')->references('id')->on('order_item_temps');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
