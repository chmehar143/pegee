<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditNumberInOrderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->string('credit_card_number')
                    ->nullable()
                    ->after('data_descriptor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function($table) {
            $table->dropColumn('credit_card_number');
        });
    }

}
