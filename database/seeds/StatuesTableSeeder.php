<?php

use Illuminate\Database\Seeder;

class StatuesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('statuses')->insert([
            [
                'status' => 'Pending'
            ], [
                'status' => 'In-Progress'
            ], [
                'status' => 'In-Shipping'
            ], [
                'status' => 'Delivered'
            ], [
                'status' => 'Cancelled'
            ]
        ]);
    }

}
