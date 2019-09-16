<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStaticPagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('static_pages', function($table) {
            $table->integer('page_show')
                    ->default(1)
                    ->comment('1: Navigation Menu; 2: Footer;')
                    ->after('page_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('static_pages', function($table) {
            $table->dropColumn('page_show');
        });
    }

}
