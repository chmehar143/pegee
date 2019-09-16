<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizeTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorize_transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('message')->nullable();
            $table->integer('attempts')->default(0);
            $table->boolean('is_processed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorize_transaction_logs');
    }
}
