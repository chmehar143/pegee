<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_transaction_detail_id')->unsigned();
            $table->foreign('order_transaction_detail_id')->references('id')->on('order_transaction_details')->onDelete('cascade');
            $table->string('status_code');
            $table->string('status_description');
            $table->dateTime('tracking_datetime');
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
        Schema::dropIfExists('shipment_trackings');
    }
}
