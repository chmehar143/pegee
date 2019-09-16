<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserTableWithSampleRequestAdded extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function($table) {
            $table->integer('sample_request')
                    ->default(2)
                    ->comment('1: Enable; 2: Disable')
                    ->after('status');
            $table->integer('sample_request_count')
                    ->default(0)
                    ->after('sample_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function($table) {
            $table->dropColumn('sample_request');
            $table->dropColumn('sample_request_count');
        });
    }

}
