<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCommentOfPageShowInStaticPageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('static_pages', function($table) {
            $table->integer('page_show')
                    ->default(1)
                    ->comment('1: Navigation Menu; 2: Footer; 3:Below Footer')
                    ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('static_pages', function($table) {
            $table->integer('page_show')
                    ->default(1)
                    ->comment('1: Navigation Menu; 2: Footer;')
                    ->change();
        });
    }

}
