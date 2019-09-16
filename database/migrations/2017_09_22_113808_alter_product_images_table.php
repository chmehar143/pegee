<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('product_images', function($table) {
            $table->integer('product_image_status')
                    ->default(1)
                    ->comment('1: Activated; 2: Is_removed 3: Deactivated;')
                    ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('product_images', function($table) {
            $table->integer('product_image_status')
                    ->default(0)
                    ->comment('1: Active; 0: Deactivated')
                    ->change();
        });
    }

}
