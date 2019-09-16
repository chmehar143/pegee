<?php

namespace App\Console\Commands;

use App\OrderTransactionDetail;
use Illuminate\Console\Command;

class ShipmentTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'OrderShipmentTracking:shipmenttracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will check the status of shipment delivery and update the database records and notifies the users regarding delivery if required';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "******************* SHIPMENT TRACKING CRON STARTED AT " . date("Y-m-d H:i:s") . " *******************\r\n";
        $orderTransactionDetails = OrderTransactionDetail::getTransactionDetailsForShipmentTracking();
        foreach ($orderTransactionDetails as $orderTransactionDetail) {
            echo "PROCESSING ORDER : " . $orderTransactionDetail->order_id . "\r\n";
            echo "PROCESSING TRACKING ID : " . $orderTransactionDetail->tracking_id . "\r\n";
            echo "PROCESSING TRACKING TYPE : " . $orderTransactionDetail->tracking_type . "\r\n";
            $orderTransactionDetail->processShipmentTracking();
        }
        echo "******************* SHIPMENT TRACKING CRON ENDS AT " . date("Y-m-d H:i:s") . " *******************\r\n";
    }
}
