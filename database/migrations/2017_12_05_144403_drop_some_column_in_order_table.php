<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSomeColumnInOrderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('status');
            $table->dropColumn('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function($table) {
            $table->integer('payment_status')
                    ->default(0)
                    ->comment('1: Paid; 0: Not Paid; 2:Cancelled: 3:Refunded');
            $table->integer('status')
                    ->default(0);
            $table->string('transaction_id')
                    ->nullable()
                    ->after('date_time');
        });
    }

}
