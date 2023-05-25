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
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->date('date_submitted')->nullable();
            // $table->date('date_returned')->nullable();
            // $table->string('released_by')->nullable();
            // $table->string('returned_to')->nullable();
            // $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');

            $table->id();
            $table->integer('user_id');
            $table->date('date_submitted')->nullable();
            $table->date('date_returned')->nullable();
            $table->string('released_by')->nullable();
            $table->string('returned_to')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_number')->on('users');
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
