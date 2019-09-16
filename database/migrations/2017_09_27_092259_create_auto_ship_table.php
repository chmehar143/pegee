<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoShipTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auto_ships', function (Blueprint $table) {
            $table->increments('id');
            $table->float('autoship_percentage')
                    ->default(0);
            $table->integer('autoship_status')
                    ->default(1)
                    ->comment('1: Activated; 2: Is_removed 3: Deactivated;');
            $table->integer('product_id')
                    ->unique()
                    ->unsigned();
            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('auto_ships');
    }

}
