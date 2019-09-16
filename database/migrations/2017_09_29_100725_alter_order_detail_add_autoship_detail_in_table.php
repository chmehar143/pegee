<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderDetailAddAutoshipDetailInTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_details', function($table) {
            $table->integer('autoship_discount')
                    ->default(0)
                    ->after('discount');
            $table->integer('autoship_interval')
                    ->default(0)
                    ->after('autoship_discount');
            $table->integer('autoship_id')
                    ->nullable()
                    ->unsigned()
                    ->after('offer_id');
            $table->foreign('autoship_id')
                    ->references('id')
                    ->on('auto_ships')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_details', function($table) {
            $table->dropColumn('autoship_discount');
            $table->dropColumn('autoship_interval');
            $table->dropForeign('order_details_autoship_id_foreign');
            $table->dropColumn('autoship_id');
        });
    }

}
