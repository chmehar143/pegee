<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->float('price')->default(0);
            $table->integer('product_quantity')->default(0);
            $table->longText('product_description')->nullable();
            $table->integer('product_height')->default(0);
            $table->integer('product_width')->default(0);
            $table->string('product_packaging')->nullable();
            $table->string('product_code')->unique();
            $table->integer('product_status')->default(1)->comment('1: Active; 0: Deactivated');
            $table->tinyInteger('product_featured')->nullable()->default(0)->comment('1: Show on Homepage; 0: Not Show on Homepage');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}
