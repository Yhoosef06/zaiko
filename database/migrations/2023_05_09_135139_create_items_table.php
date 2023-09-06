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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('part_number')->nullable();
            $table->unsignedBigInteger('parent_item')->nullable();
            $table->unsignedBigInteger('replaced_item')->nullable();
            $table->string('description');
            $table->integer('quantity');
            // $table->integer('same_serial_numbers')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('aquisition_date')->nullable();
            $table->string('status');
            $table->string('inventory_tag');
            $table->string('borrowed');
            $table->string('item_image')->nullable();
            $table->timestamps();


            $table->foreign('parent_item')->references('id')->on('items');
            $table->foreign('replaced_item')->references('id')->on('items');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('location')->references('id')->on('rooms');
            $table->foreign('category_id')->references('id')->on('item_categories');
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
