<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddErrorDescriptionInOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_details', function($table) {
            $table->text('error_description')
                    ->nullable()
                    ->after('error_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_details', function($table) {
            $table->dropColumn('error_description');
        });
    }

}
