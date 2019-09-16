<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTransactionDetailTableAddedRefundCancelSubscriptionDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_transaction_details', function($table) {
            $table->string('refund_transaction_response_code')
                    ->nullable()
                    ->after('shipping_status');
            $table->string('refund_success_code')
                    ->nullable()
                    ->after('refund_transaction_response_code');
            $table->string('refund_code')
                    ->nullable()
                    ->after('refund_success_code');
            $table->string('refund_description')
                    ->nullable()
                    ->after('refund_code');
            $table->string('error_code')
                    ->nullable()
                    ->after('refund_description');
            $table->string('error_description')
                    ->nullable()
                    ->after('error_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_transaction_details', function($table) {
            $table->dropColumn('refund_transaction_response_code');
            $table->dropColumn('refund_success_code');
            $table->dropColumn('refund_code');
            $table->dropColumn('refund_description');
            $table->dropColumn('error_code');
            $table->dropColumn('error_description');
        });
    }

}
