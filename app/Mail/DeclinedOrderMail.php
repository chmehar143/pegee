<?php

namespace App\Mail;

use App\EmailTemplate;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use CountryState;

class DeclinedOrderMail extends Mailable
{

    use Queueable,
        SerializesModels;

    public $order;
    public $template;
    public $template_attribute;
    public $mail_contents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $template)
    {
        $this->order = $order;
        $this->template = $template;
        $this->template_attribute = $template->getEmailTemplateAttributes()->first();
        $this->mail_contents = $this->template_attribute->attr_val;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->populate_data();
        /* Using same template as new order  because it shares same contents */
//        return $this->subject($this->template->subject)->view('emails.order.declined-order');
        return $this->subject($this->template->subject)->view('emails.order.new-order');
    }

    protected function populate_data()
    {
        if ($this->order) {
            $error = $this->order->getErrorDescription();
            $error_message = $error->error_description;
            if ($this->template->template_type == EmailTemplate::CUSTOMER_DECLINED_ORDER_EMAIL && $error->error_code == 'E00003') {
                $error_message = 'An internal error has occurred';
            }

            $states = CountryState::getStates('US');
            $countries = CountryState::getCountries();


            $this->mail_contents = str_replace("{%ORDER_ERROR%}", $error_message, $this->mail_contents);
            $this->mail_contents = str_replace("{%APP_NAME%}", config('app.name'), $this->mail_contents);
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
