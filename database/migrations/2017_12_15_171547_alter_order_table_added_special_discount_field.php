<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTableAddedSpecialDiscountField extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->integer('special_discount')
                    ->default(0)
                    ->after('order_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function($table) {
            $table->dropColumn('special_discount');
        });
    }

}
