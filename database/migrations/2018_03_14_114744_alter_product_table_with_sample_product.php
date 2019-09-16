<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTableWithSampleProduct extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function($table) {
            $table->integer('sample_product')
                    ->default(2)
                    ->comment('1: Enable; 2: Disable')
                    ->after('out_of_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function($table) {
            $table->dropColumn('sample_product');
        });
    }

}
