<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditCardNumberInTransactionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_transaction_details', function($table) {
            $table->string('credit_card_number')
                    ->nullable()
                    ->after('shipping_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_transaction_details', function($table) {
            $table->dropColumn('credit_card_number');
        });
    }

}
