<?php

use Illuminate\Database\Seeder;
use App\EmailTemplate;
use App\EmailTemplateAttribute;

class TrackingEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_tracking_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_ORDER_SHIPPING_TRACKING_EMAIL)->first();
        if (!$customer_tracking_email) {
            $customer_tracking_email = new EmailTemplate();
        }

        $customer_tracking_email->subject = 'Your Order {%ORDER_NO%} is {%TRACKING_STATUS%}';
        $customer_tracking_email->template_type = EmailTemplate::CUSTOMER_ORDER_SHIPPING_TRACKING_EMAIL;
        $customer_tracking_email->save();

        $customer_tracking_email_attribute = $customer_tracking_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_tracking_email_attribute) {
            $customer_tracking_email_attribute = new EmailTemplateAttribute();
            $customer_tracking_email_attribute->email_template_id = $customer_tracking_email->id;
            $customer_tracking_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}", "{%TRACKING_INFORMATION%}", "{%TRACKING_BUTTONS%}"';
            $customer_tracking_email_attribute->attr_key = 'greeting_message';
        }

        $customer_tracking_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Below is the tracking for your order no <b>{%ORDER_NO%}</b>.<br/>{%TRACKING_BUTTONS%}';
        $customer_tracking_email_attribute->save();
    }
}
