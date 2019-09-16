<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTableWithShortDescriptionFieldAdded extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function($table) {
            $table->text('short_description')
                    ->nullable()
                    ->after('product_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function($table) {
            $table->dropColumn('short_description');
        });
    }

}
