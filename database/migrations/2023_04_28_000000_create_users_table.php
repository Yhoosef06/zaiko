<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id_number')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('account_type');
            $table->boolean('isActive')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('security_question_id')->nullable();
            $table->string('answer')->nullable();
            $table->rememberToken();
            $table->date('last_login_at')->nullable();
            $table->boolean('password_updated')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('security_question_id')->references('id')->on('security_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
