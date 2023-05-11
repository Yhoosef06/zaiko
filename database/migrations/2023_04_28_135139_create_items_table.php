<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location');
            $table->foreignId('category_id');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('description');
            $table->integer('quantity');
            $table->string('unit_number')->nullable();
            $table->date('aquisition_date')->nullable();
            $table->string('status');
            $table->string('borrowed');
            $table->string('inventory_tag');
            $table->string('serial_number')->nullable();
            $table->timestamps();

            $table->foreign('location')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
