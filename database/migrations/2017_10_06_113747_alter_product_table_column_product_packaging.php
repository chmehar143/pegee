<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTableColumnProductPackaging extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function($table) {
            $table->longText('product_packaging')
                    ->nullable()
                    ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function($table) {
            $table->string('product_packaging')
                    ->nullable()
                    ->change();
        });
    }

}
