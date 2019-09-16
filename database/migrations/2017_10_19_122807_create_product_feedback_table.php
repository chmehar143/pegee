<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFeedbackTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rating')->default(0);
            $table->longText('product_feedback')->nullable();
            $table->integer('is_anonymous')->default(2)->comment('1: Anonymous; 2: User');
            $table->tinyInteger('is_approved')->default(2)->comment('1: Is Approved; 2: Not Approved');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('product_feedbacks');
    }

}
