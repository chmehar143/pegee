<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingDetailsInOrderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->string('b_street')
                    ->nullable()
                    ->after('credit_card_number');
            $table->string('b_street2')
                    ->nullable()
                    ->after('b_street');
            $table->string('b_city')
                    ->nullable()
                    ->after('b_street2');
            $table->string('b_state')
                    ->nullable()
                    ->after('b_city');
            $table->string('b_postal_code')
                    ->nullable()
                    ->after('b_state');
            $table->string('b_phone_no')
                    ->nullable()
                    ->after('b_postal_code');
            $table->integer('billing_bit')
                    ->default(0)
                    ->after('b_phone_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function($table) {
            $table->dropColumn('b_street');
            $table->dropColumn('b_street2');
            $table->dropColumn('b_city');
            $table->dropColumn('b_state');
            $table->dropColumn('b_postal_code');
            $table->dropColumn('b_phone_no');
            $table->dropColumn('billing_bit');
        });
    }

}
