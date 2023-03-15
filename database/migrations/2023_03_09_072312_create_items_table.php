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
            $table->string('serial_number')->primary();
            $table->string('item_name');
            $table->string('item_description');
            $table->integer('quantity');
            $table->string('unit_number');
            $table->date('aquisition_date')->nullable();
            $table->string('status');
            $table->string('borrowed');
            $table->string('inventory_tag');
            $table->string('location');
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
        Schema::dropIfExists('items');
    }
}
