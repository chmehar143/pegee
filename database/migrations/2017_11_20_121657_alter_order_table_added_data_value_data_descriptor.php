<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTableAddedDataValueDataDescriptor extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function($table) {
            $table->longText('data_value')
                    ->nullable()
                    ->after('transaction_id');
            $table->string('data_descriptor')
                    ->nullable()
                    ->after('data_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function($table) {
            $table->dropColumn('data_value');
            $table->dropColumn('data_descriptor');
        });
    }

}
