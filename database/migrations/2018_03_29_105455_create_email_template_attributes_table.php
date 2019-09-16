<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_template_id')->unsigned();
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onDelete('cascade');
            $table->string('attr_key');
            $table->longText('attr_val');
            $table->text('hints', 255);
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
        Schema::dropIfExists('email_template_attributes');
    }
}
