<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectInProductFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_feedbacks', function($table) {
            $table->string('subject')->nullable();
            $table->dateTime('review_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_feedbacks', function($table) {
            $table->dropColumn('subject');
            $table->dropColumn('review_date');
        });
    }
}
