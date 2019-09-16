<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductId2InSampleRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('samples', function($table) {
            $table->string('currently_using')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->integer('product_id2')->nullable()->unsigned();
            $table->foreign('product_id2')->references('id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('samples', function($table) {
            $table->dropForeign(['product_id2']);
            $table->dropColumn('product_id2');
        });


    }
}
