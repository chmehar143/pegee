<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderdetailsTableIncludeErrorCode extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_details', function($table) {
            $table->string('error_code')
                    ->nullable()
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
            $table->dropColumn('error_code');
        });
    }

}
