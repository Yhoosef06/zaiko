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
            $table->integer('encoded_by');
            $table->integer('quantity');
            $table->string('mode');
            $table->date('date');
            $table->unsignedBigInteger('room_from')->nullable();
            $table->unsignedBigInteger('room_to')->nullable();
            $table->timestamps();

            $table->foreign('encoded_by')->references('id_number')->on('users')->onDelete('cascade');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->foreign('room_from')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('room_to')->references('id')->on('rooms')->onDelete('cascade');
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
