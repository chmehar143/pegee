<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slider_image')->nullable();
            $table->string('layer_1')->nullable();
            $table->string('layer_2')->nullable();
            $table->string('layer_3')->nullable();
            $table->string('layer_4')->nullable();
            $table->integer('slider_image_status')->default(1)->comment('1: Active; 0: Deactivated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sliders');
    }

}
