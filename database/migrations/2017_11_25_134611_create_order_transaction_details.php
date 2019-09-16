<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTransactionDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable();
            $table->dateTime('date_time');
            $table->string('payment_status')
                    ->default(4)
                    ->comment('1: Paid; 2:Cancelled; 3:Refunded 4: Not Paid;');
            $table->string('shipping_status')
                    ->default(1)
                    ->comment('1: Pending; 2: In-Progress; 3: In-Shipping; 4: Delivered; 5: Cancelled;');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('order_detail_id')->unsigned();
            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_transaction_details');
    }

}
