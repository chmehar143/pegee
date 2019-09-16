<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_name');
            $table->string('slug')->unique();
            $table->longText('page_description')->nullable();
            $table->integer('page_status')->default(1)->comment('1: Active; 0: Deactivated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('static_pages');
    }

}
