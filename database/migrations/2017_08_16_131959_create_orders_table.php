<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->string('company');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('street');
            $table->string('street2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->integer('payment_status')->default(0)->comment('1: Paid; 0: Not Paid; 2:Cancelled: 3:Refunded');
            $table->integer('status')->default(0);
            $table->dateTime('date_time');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }

}
