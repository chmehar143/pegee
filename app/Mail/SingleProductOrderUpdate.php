<?php

namespace App\Mail;

use App\OrderDetail;
use App\OrderTransactionDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use CountryState;

class SingleProductOrderUpdate extends Mailable
{

    use Queueable,
        SerializesModels;
    public $order;
    public $orderDetail;
    public $template;
    public $template_attribute;
    public $mail_contents;
    public $orderTransactionDetail;
    public $displayFirstTimeAutoShipDiscount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderDetail $orderDetail, $template, $orderTransactionDetail = null)
    {
        $this->orderDetail = $orderDetail;
        $this->order = $this->orderDetail->getOrder;
        $this->template = $template;
        $this->template_attribute = $template->getEmailTemplateAttributes()->first();
        $this->mail_contents = $this->template_attribute->attr_val;
        $this->orderTransactionDetail = $orderTransactionDetail;
        if ($this->orderTransactionDetail) {
            $this->displayFirstTimeAutoShipDiscount = $orderTransactionDetail->displayFirstTimeAutoShipDiscount();
        } else {
            $this->displayFirstTimeAutoShipDiscount = $orderDetail->getOrder->special_discount == 1;
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->populateSubject();
        $this->populate_data();
        return $this->subject(ucfirst(strtolower($this->template->subject)))->view('emails.order.single-product-order');
    }

    protected function populateSubject()
    {
        if ($this->order) {
            $this->template->subject = str_replace("{%ORDER_NO%}", $this->order->order_no, $this->template->subject);
            $description = '';
            if ($this->orderTransactionDetail) {
                $shipmentTracking = $this->orderTransactionDetail->getLatestShipmentTracking();
                $description = $shipmentTracking ? $shipmentTracking->status_description : '';
            }
            $this->template->subject = str_replace("{%TRACKING_STATUS%}", $description, $this->template->subject);
        }
    }


    protected function populate_data()
    {
        if ($this->order) {
            $states = CountryState::getStates('US');
            $countries = CountryState::getCountries();
            if (strpos($this->mail_contents, "{%TRACKING_INFORMATION%}")) {
                $tracking_html = '';
                if ($this->orderTransactionDetail) {
                    $tracking_information = $this->orderTransactionDetail->getLatestShipmentTrackings();
                    if ($tracking_information->count() > 0) {
                        $tracking_html .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 544px;" class="responsive-table">
                                <tr>
                                    <td style="padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;">
                                        Tracking Information
                                    </td>
                                </tr>
                              <tr>
                                <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">
                                  <table cellspacing="0" cellpadding="0" border="0" width="100%">';

                        foreach ($tracking_information as $t_info) {
                            $tracking_html .= "<tr><td>" . $t_info->status_description . " - " . date("M d, Y H:i:s", strtotime($t_info->tracking_datetime)) . "</td></tr>";
                        }
                        $tracking_html .= '</table></td></tr></table>';
                    }
                }
                $this->mail_contents = str_replace("{%TRACKING_INFORMATION%}", $tracking_html, $this->mail_contents);
            }

            if (strpos($this->mail_contents, "{%TRACKING_BUTTONS%}")) {
                if ($this->orderTransactionDetail) {
                    $tracking_link = '#';
                    if ($this->orderTransactionDetail->tracking_type == OrderTransactionDetail::TRACKING_TYPE_UPS) {
                        $tracking_link = env('UPS_TRACKING_LINK') . $this->orderTransactionDetail->tracking_id;
                    }
                    if ($this->orderTransactionDetail->tracking_type == OrderTransactionDetail::TRACKING_TYPE_FEDEX) {
                        $tracking_link = env('FEDEX_TRACKING_LINK') . $this->orderTransactionDetail->tracking_id;
                    }

                    $order_details_link = env('APP_URL') . '/order/details/'. $this->order->order_no;
                    $tracking_url_button_html = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 544px;\" class=\"responsive-table\">
                                    <tr>
                                        <td style=\"padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;\">
                                            Shipping Confirmation
                                        </td>
                                    </tr>
                                  <tr>
                                    <td style=\"padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;\">
                                      <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
                                      <tr>
                                          <td>
                                              <a href='" . $tracking_link . "' style='display: inline-block;cursor: pointer;text-align: center;white-space: nowrap;font-weight: 400;margin-bottom: 0px;vertical-align: middle;touch-action: manipulation;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 25px;line-height: 1.38;padding: 8px 22px;font-size: 14px;color: #fff;background-color: #e8282a;'>Track Your Package</a>
                                              <a href='" . $order_details_link . "' style='display: inline-block;cursor: pointer;text-align: center;white-space: nowrap;font-weight: 400;margin-bottom: 0px;vertical-align: middle;touch-action: manipulation;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 25px;line-height: 1.38;padding: 8px 22px;font-size: 14px;color: #fff;background-color: #e8282a;'>Order Details</a>
                                          </td>
                                      </tr>
                                      </table></td></tr></table>'";
                    $this->mail_contents = str_replace("{%TRACKING_BUTTONS%}", $tracking_url_button_html, $this->mail_contents);
                }
            }

            $this->mail_contents = str_replace("{%APP_NAME%}", config('app.name'), $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_PRODUCT%}", $this->orderDetail->getProductDetail->name, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_NO%}", $this->order->order_no, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_FULL_NAME%}", $this->order->first_name . " " . $this->order->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_FIRST_NAME%}", $this->order->first_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_LAST_NAME%}", $this->order->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_EMAIL%}", $this->order->email, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_PHONE_NUMBER%}", $this->order->phone, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_COMPANY%}", $this->order->company, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_STREET_ADDRESS%}", $this->order->street, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_STREET_ADDRESS_2%}", $this->order->street2, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_CITY%}", $this->order->city, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_STATE%}", isset($states[$this->order->state]) ? $states[$this->order->state] : $this->order->state, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_POSTAL_CODE%}", $this->order->postal_code, $this->mail_contents);
            $this->mail_contents = str_replace("{%ORDER_COUNTRY%}", isset($countries[$this->order->country]) ? $countries[$this->order->country] : $this->order->country, $this->mail_contents);
            if ($this->order->billing_bit == 1) {
                $this->mail_contents = str_replace("{%ORDER_BILLING_STREET%}", $this->order->b_street, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_STREET_2%}", $this->order->b_street2, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_CITY%}", $this->order->b_city, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_STATE%}", isset($states[$this->order->b_state]) ? $states[$this->order->b_state] : $this->order->b_state, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_POSTAL_CODE%}", $this->order->b_postal_code, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_PHONE_NO%}", $this->order->b_phone_no, $this->mail_contents);
            } else {
                $this->mail_contents = str_replace("{%ORDER_BILLING_STREET%}", $this->order->street, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_STREET_2%}", $this->order->street2, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_CITY%}", $this->order->city, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_STATE%}", isset($states[$this->order->state]) ? $states[$this->order->state] : $this->order->state, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_POSTAL_CODE%}", $this->order->postal_code, $this->mail_contents);
                $this->mail_contents = str_replace("{%ORDER_BILLING_PHONE_NO%}", $this->order->phone, $this->mail_contents);
            }
        }
    }

}
