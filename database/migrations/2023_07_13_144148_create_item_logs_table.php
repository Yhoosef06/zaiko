<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->integer('quantity');
            $table->string('mode');
            $table->date('date');
            $table->timestamps();

            $table->foreign('order_item_id')->references('id')->on('order_items');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_logs');
    }
}
