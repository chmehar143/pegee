<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTableAddedShowVideoField extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function($table) {
            $table->integer('show_video')
                    ->default(2)
                    ->comment('1: Show Video; 2: Not Show Video')
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
            $table->dropColumn('show_video');
        });
    }

}
