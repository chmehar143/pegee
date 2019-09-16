<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderStatusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->integer('payment_status')
                    ->default(4)
                    ->comment('1: Paid; 2:Cancelled: 3:Refunded 4: Not Paid;')
                    ->change();
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
                    ->comment('1: Paid; 0: Not Paid; 2:Cancelled: 3:Refunded')
                    ->change();
        });
    }

}
