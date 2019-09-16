<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_image');
            $table->integer('image_featured')->default(0)->comment('1: Featured; 0: Un-Featured');
            $table->integer('product_image_status')->default(0)->comment('1: Active; 0: Deactivated');
            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('product_images');
    }

}
