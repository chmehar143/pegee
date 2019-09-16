<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    /* Customer templates */
    const CUSTOMER_WELCOME = 'customer_welcome';
    const CUSTOMER_NEW_ORDER_EMAIL = 'customer_new_order_email';
    const CUSTOMER_DECLINED_ORDER_EMAIL = 'customer_declined_order_email';
    const CUSTOMER_UPDATE_SUBSCRIPTION_EMAIL = 'customer_update_subscription_email';
    const CUSTOMER_CANCEL_SUBSCRIPTION_EMAIL = 'customer_cancel_subscription_email';
    const CUSTOMER_REFUND_TRANSACTION_EMAIL = 'customer_refund_transaction_email';
    const CUSTOMER_SAMPLE_REQUEST_EMAIL = 'customer_sample_request_email';
    const CUSTOMER_SAMPLE_REQUEST_APPROVED_EMAIL = 'customer_sample_request_approved_email';
    const CUSTOMER_ORDER_SHIPPING_TRACKING_EMAIL = 'customer_order_shipping_tracking_email';

    /* Admin templates */
    const ADMIN_NEW_ORDER_EMAIL = 'admin_new_order_email';
    const ADMIN_DECLINED_ORDER_EMAIL = 'admin_declined_order_email';
    const ADMIN_PAYMENT_APPROVE_EMAIL = 'admin_payment_approve_email';
    const ADMIN_CANCEL_SUBSCRIPTION_EMAIL = 'admin_cancel_subscription_email';
    const ADMIN_REFUND_TRANSACTION_EMAIL = 'admin_refund_transaction_email';
    const ADMIN_SAMPLE_REQUEST_EMAIL = 'admin_sample_request_email';

    public function getHumanizeType(){
        return ucfirst(str_replace("_", " ", $this->template_type));

    }

    public function getEmailTemplateAttributes(){
        return $this->hasMany('App\EmailTemplateAttribute');
    }


}
