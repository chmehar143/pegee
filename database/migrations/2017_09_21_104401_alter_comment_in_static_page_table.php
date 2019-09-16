<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCommentInStaticPageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('static_pages', function($table) {
            $table->integer('page_status')->comment('1: Activated; 2: Is_removed 3: Deactivated;')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('static_pages', function($table) {
            $table->integer('page_status')->comment('1: Active; 0: Deactivated')->change();
        });
    }

}
