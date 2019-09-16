<?php

namespace App;

use App\Mail\SingleProductOrderUpdate;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use SoapClient;
use Illuminate\Support\Facades\Log;

class OrderTransactionDetail extends Model
{

    use Filterable;

    const TRACKING_TYPE_UPS = 'ups';
    const TRACKING_TYPE_FEDEX = 'fedex';

    /**
     * The attributes that should be guarded for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'date_time',
        'order_id',
        'order_detail_id',
        'payment_status',
        'shipping_status',
        'tracking_id',
        'tracking_type',
        'transaction_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'order_id',
        'order_detail_id',
    ];

    public function getOrder()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function getOrderDetail()
    {
        return $this->belongsTo('App\OrderDetail', 'order_detail_id');
    }


    public function processUpsShipmentTracking()
    {
        $send_email = false;
        $is_delivered = false;
        $tracking = new \Ups\Tracking(env('UPS_ACCESS_KEY'), env('UPS_USER_ID'), env('UPS_PASSWORD'));
        try {
            $shipment = $tracking->track($this->tracking_id);
            if (isset($shipment->Package)) {
                $activities = $shipment->Package->Activity;
                if(is_array($activities)){
                    foreach ($activities as $activity) {
                        $datetime = date("Y-m-d H:i:s", strtotime($activity->Date . " " . $activity->Time));
                        $shipment_tracking = $this->shipmentTrackings()->where('status_code', $activity->Status->StatusCode->Code)->first();
                        if (!$shipment_tracking) {
                            $shipment_tracking = new ShipmentTracking();
                            $shipment_tracking->order_transaction_detail_id = $this->id;
                            $shipment_tracking->status_code = $activity->Status->StatusCode->Code;
                            $shipment_tracking->status_description = $activity->Status->StatusType->Description;
                            $shipment_tracking->tracking_datetime = $datetime;
                            $shipment_tracking->save();
                            if ($shipment_tracking->status_description == 'Delivered') {
                                $send_email = true;
                                $is_delivered = true;
                                $this->shipping_status = 4;
                            }

                            if (!$is_delivered && $shipment_tracking->status_description != 'Delivered') {
                                $this->shipping_status = 3;
                            }
                        }else if($shipment_tracking && $shipment_tracking->status_description == 'Delivered') {
                            $this->shipping_status = 4;
                        }
                    }
                    $this->save();
                }
            }
        } catch (\Exception $e) {
            //skip exception
            echo $e->getMessage() . "\r\n";
        }

        return $send_email;
    }

    public function processFedexShipmentTracking()
    {
        $send_email = false;
        $is_delivered = false;
        $path_to_wsdl = public_path("TrackService_v14.wsdl");
        $client = new SoapClient($path_to_wsdl, array('trace' => 1));

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => env('FEDEX_KEY'),
                'Password' => env('FEDEX_PASSWORD')
            ),
            'UserCredential' => array(
                'Key' => env('FEDEX_KEY'),
                'Password' => env('FEDEX_PASSWORD')
            )
        );

        $request['ClientDetail'] = array(
            'AccountNumber' => env('FEDEX_ACCOUNT_NUMBER'),
            'MeterNumber' => env('FEDEX_METER_NUMBER')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request From PetsWorld ***');
        $request['Version'] = array(
            'ServiceId' => 'trck',
            'Major' => '14',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $request['SelectionDetails'] = array(
            'PackageIdentifier' => array(
                'Type' => 'TRACKING_NUMBER_OR_DOORTAG',
                'Value' => $this->tracking_id // Replace 'XXX' with a valid tracking identifier
            )
        );
        try {
            $client->__setLocation(env('FEDEX_ENDPOINT'));
            $response = $client->track($request);
            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                if ($response->HighestSeverity == 'SUCCESS') {
                    if ($response->CompletedTrackDetails->HighestSeverity == 'SUCCESS' && is_object($response->CompletedTrackDetails->TrackDetails) && $response->CompletedTrackDetails->TrackDetails->Notification->Severity == 'SUCCESS') {
                        $status_details = $response->CompletedTrackDetails->TrackDetails->StatusDetail;
                        $datetime = date("Y-m-d H:i:s", strtotime($status_details->CreationTime));
                        $shipment_tracking = $this->shipmentTrackings()->where('status_code', $status_details->Code)->first();
                        if (!$shipment_tracking) {
                            $shipment_tracking = new ShipmentTracking();
                            $shipment_tracking->order_transaction_detail_id = $this->id;
                            $shipment_tracking->status_code = $status_details->Code;
                            $shipment_tracking->status_description = $status_details->Description;
                            $shipment_tracking->tracking_datetime = $datetime;
                            $shipment_tracking->save();
                            if ($shipment_tracking->status_code == 'DL') {
                                $send_email = true;
                                $is_delivered = true;
                                $this->shipping_status = 4;
                            }

                            if (!$is_delivered && $shipment_tracking->status_code != 'DL') {
                                $this->shipping_status = 3;
                            }
                        }
                        $this->save();
                    }
                }
            }
        } catch (SoapFault $exception) {
            //skip exception
            echo $exception->getMessage() . "\r\n";
        }
        return $send_email;
    }

    public function processShipmentTracking()
    {
        $sendEmail = false;
        switch ($this->tracking_type) {
            case OrderTransactionDetail::TRACKING_TYPE_UPS:
                {
                    $sendEmail = $this->processUpsShipmentTracking();
                    break;
                }
            case OrderTransactionDetail::TRACKING_TYPE_FEDEX:
                {
                    $sendEmail = $this->processFedexShipmentTracking();
                    break;
                }
            default:
                //do nothing
        }
        if ($sendEmail) {
            /* SEND EMAIL TO CUSTOMER */
            $customer_order_shipping_tracking_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_ORDER_SHIPPING_TRACKING_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($customer_order_shipping_tracking_email_template) {
                try {
                    \Mail::to($this->getOrder->email)->send(new SingleProductOrderUpdate($this->getOrderDetail, $customer_order_shipping_tracking_email_template, $this));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
        }
    }


    public static function getTransactionDetailsForShipmentTracking()
    {
        return OrderTransactionDetail::where('payment_status', 1)
            ->whereNotIn('shipping_status', [4, 5])
            ->whereNotNull('tracking_id')
            ->whereNotNull('tracking_type')
            ->get();
    }

    public function shipmentTrackings()
    {
        return $this->hasMany('App\ShipmentTracking');
    }


    public function getLatestShipmentTracking()
    {
        return $this->shipmentTrackings()->orderBy('tracking_datetime', 'DESC')->first();
    }

    public function getLatestShipmentTrackings()
    {
        return $this->shipmentTrackings()->orderBy('tracking_datetime', 'DESC')->get();
    }

    public function prepareShipmentTracking()
    {
        $shipment_tracking = $this->shipmentTrackings()->where('status_code', 'SHP')->first();
        if (!$shipment_tracking) {
            $shipment_tracking = new ShipmentTracking();
            $shipment_tracking->order_transaction_detail_id = $this->id;
            //custom code for sending initial email
            $shipment_tracking->status_code = 'SHP';
            $shipment_tracking->status_description = "IN SHIPPING";
            $shipment_tracking->tracking_datetime = date('Y-m-d H:i:s');
            $shipment_tracking->save();
            /* SEND EMAIL TO CUSTOMER */
            $customer_order_shipping_tracking_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_ORDER_SHIPPING_TRACKING_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($customer_order_shipping_tracking_email_template) {
                try {
                    \Mail::to($this->getOrder->email)->send(new SingleProductOrderUpdate($this->getOrderDetail, $customer_order_shipping_tracking_email_template, $this));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
        }
        $this->shipping_status = 3;
        $this->save();
    }


    public function displayFirstTimeAutoShipDiscount()
    {
        $firstTransaction = $this->getOrder->getOrderTransactionDetails()->first();
        if ($firstTransaction && $firstTransaction->id ==  $this->id && $this->getOrder->special_discount > 0) {
            return true;
        }
        return false;
    }

}
