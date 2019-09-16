<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderDetailTableWithPaymentDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_details', function($table) {
            $table->string('subscription_id')
                    ->nullable()
                    ->after('autoship_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_details', function($table) {
            $table->dropColumn('subscription_id');
        });
    }

}
