<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('category');
            $table->string('brand');
            $table->string('model');
            $table->string('item_description');
            $table->string('serial_number');
            $table->integer('quantity');
            $table->date('return_date');
            $table->string('release_by');
            $table->string('return_to');
            $table->string('order_status');
            $table->string('item_remark');
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
        Schema::dropIfExists('orders');
    }
}
