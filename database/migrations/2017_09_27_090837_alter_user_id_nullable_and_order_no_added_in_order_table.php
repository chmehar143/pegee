<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserIdNullableAndOrderNoAddedInOrderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->string('order_no')
                    ->unique()
                    ->nullable()
                    ->after('transaction_id');
            $table->integer('user_id')
                    ->nullable()
                    ->unsigned()
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
            $table->dropColumn('order_no');
            $table->integer('user_id')
                    ->nullable(false)
                    ->unsigned()
                    ->change();
        });
    }

}
