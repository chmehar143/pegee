<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnNameCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('categories', function($table) {
            $table->integer('status')->default(1)->comment('1: Activated; 2: Is_removed 3: Deactivated;')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('categories', function($table) {
            $table->integer('status')->default(0)->change();
        });
    }

}
