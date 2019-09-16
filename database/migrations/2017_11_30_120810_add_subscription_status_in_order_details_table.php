<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionStatusInOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_details', function($table) {
            $table->integer('subscription_status')
                    ->default(0)
                    ->comment('1: Active; 2:Cancelled:')
                    ->after('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_details', function($table) {
            $table->dropColumn('subscrition_status');
        });
    }

}
