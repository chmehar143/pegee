<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTransactionTableWithAddedVerifingPaymentField extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_transaction_details', function($table) {
            $table->integer('payment_status')
                    ->default(4)
                    ->comment('1: Paid; 2:expired; 3:Refunded 4: Awaiting payment; 5: Your payment is being verified')
                    ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_transaction_details', function($table) {
            $table->string('payment_status')
                    ->default(4)
                    ->comment('1: Paid; 2:Cancelled; 3:Refunded 4: Not Paid;')
                    ->change();
        });
    }

}
