<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingIdAndTrackingTypeToOrderTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_transaction_details', function($table) {
            $table->string('tracking_id')->nullable();
            $table->string('tracking_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_transaction_details', function($table) {
            $table->dropColumn('tracking_id');
            $table->dropColumn('tracking_type');
        });
    }
}
