<?php

use Illuminate\Database\Seeder;
use App\EmailTemplate;
use App\EmailTemplateAttribute;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /** Customer registration welcome email */
        $customer_welcome = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_WELCOME)->first();
        if (!$customer_welcome) {
            $customer_welcome = new EmailTemplate();
        }

        $customer_welcome->subject = 'Welcome to PetsWorld, Inc';
        $customer_welcome->template_type = EmailTemplate::CUSTOMER_WELCOME;
        $customer_welcome->save();

        $customer_welcome_attribute = $customer_welcome->getEmailTemplateAttributes()->where('attr_key', 'body')->first();
        if (!$customer_welcome_attribute) {
            $customer_welcome_attribute = new EmailTemplateAttribute();
            $customer_welcome_attribute->email_template_id = $customer_welcome->id;
            $customer_welcome_attribute->hints = '"{%APP_NAME%}", "{%FULL_NAME%}", "{%FIRST_NAME%}", "{%LAST_NAME%}", "{%EMAIL%}", "{%GENDER%}", "{%PHONE_NUMBER%}"';
            $customer_welcome_attribute->attr_key = 'body';

        }
        $customer_welcome_attribute->attr_val = '<!-- Main Email Body : BEGIN -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

        <!-- Full Width, Fluid Column : BEGIN -->
        <tr>
            <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
                <!-- COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family: sans-serif; color: #666666;" class="padding-copy">Hey <?php echo $user->{%FULL_NAME%}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 20px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;" class="padding-copy">
                            Thanks for registering on {%APP_NAME%}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Full Width, Fluid Column : END -->
    </table>
    <!-- Main Email Body : END -->';
        $customer_welcome_attribute->save();

        /** customer new order email */
        $customer_new_order_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_NEW_ORDER_EMAIL)->first();
        if (!$customer_new_order_email) {
            $customer_new_order_email = new EmailTemplate();
        }
        $customer_new_order_email->subject = 'Order placed successfully';
        $customer_new_order_email->template_type = EmailTemplate::CUSTOMER_NEW_ORDER_EMAIL;
        $customer_new_order_email->save();

        $customer_new_order_email_attribute = $customer_new_order_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_new_order_email_attribute) {
            $customer_new_order_email_attribute = new EmailTemplateAttribute();
            $customer_new_order_email_attribute->email_template_id = $customer_new_order_email->id;
            $customer_new_order_email_attribute->attr_key = 'greeting_message';
        }

        $customer_new_order_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $customer_new_order_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Your order has been placed successfully. To track your order use this order no <b>{%ORDER_NO%}</b>.';
        $customer_new_order_email_attribute->save();


        /** customer declined order email */
        $customer_declined_order_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_DECLINED_ORDER_EMAIL)->first();
        if (!$customer_declined_order_email) {
            $customer_declined_order_email = new EmailTemplate();
        }
        $customer_declined_order_email->subject = 'OOPS! your order has been declined!';
        $customer_declined_order_email->template_type = EmailTemplate::CUSTOMER_DECLINED_ORDER_EMAIL;
        $customer_declined_order_email->save();

        $customer_declined_order_email_attribute = $customer_declined_order_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_declined_order_email_attribute) {
            $customer_declined_order_email_attribute = new EmailTemplateAttribute();
            $customer_declined_order_email_attribute->email_template_id = $customer_declined_order_email->id;
            $customer_declined_order_email_attribute->attr_key = 'greeting_message';
        }

        $customer_declined_order_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_ERROR%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $customer_declined_order_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Your order #<b>{%ORDER_NO%}</b> has been declined due to <br/><ul style="color: red;list-style: none;"><li><b>{%ORDER_ERROR%}</b></li></ul>';
        $customer_declined_order_email_attribute->save();

        /** customer update subscription order email */
        $customer_update_subscription_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_UPDATE_SUBSCRIPTION_EMAIL)->first();
        if (!$customer_update_subscription_email) {
            $customer_update_subscription_email = new EmailTemplate();
        }
        $customer_update_subscription_email->subject = 'Your subscription has been updated!';
        $customer_update_subscription_email->template_type = EmailTemplate::CUSTOMER_UPDATE_SUBSCRIPTION_EMAIL;
        $customer_update_subscription_email->save();

        $customer_update_subscription_email_attribute = $customer_update_subscription_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_update_subscription_email_attribute) {
            $customer_update_subscription_email_attribute = new EmailTemplateAttribute();
            $customer_update_subscription_email_attribute->email_template_id = $customer_update_subscription_email->id;
            $customer_update_subscription_email_attribute->attr_key = 'greeting_message';
        }

        $customer_update_subscription_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $customer_update_subscription_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Your payment method has been updated successfully against order # <b>{%ORDER_NO%}</b>.';
        $customer_update_subscription_email_attribute->save();

        /** customer cancel subscription email */
        $customer_cancel_subscription_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_CANCEL_SUBSCRIPTION_EMAIL)->first();
        if (!$customer_cancel_subscription_email) {
            $customer_cancel_subscription_email = new EmailTemplate();
        }
        $customer_cancel_subscription_email->subject = 'Your subscription has been cancelled!';
        $customer_cancel_subscription_email->template_type = EmailTemplate::CUSTOMER_CANCEL_SUBSCRIPTION_EMAIL;
        $customer_cancel_subscription_email->save();

        $customer_cancel_subscription_email_attribute = $customer_cancel_subscription_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_cancel_subscription_email_attribute) {
            $customer_cancel_subscription_email_attribute = new EmailTemplateAttribute();
            $customer_cancel_subscription_email_attribute->email_template_id = $customer_cancel_subscription_email->id;
            $customer_cancel_subscription_email_attribute->attr_key = 'greeting_message';
        }

        $customer_cancel_subscription_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $customer_cancel_subscription_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Your subscription has been cancelled successfully.';
        $customer_cancel_subscription_email_attribute->save();


        /** customer refund transaction email */
        $customer_refund_transaction_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_REFUND_TRANSACTION_EMAIL)->first();
        if (!$customer_refund_transaction_email) {
            $customer_refund_transaction_email = new EmailTemplate();
        }
        $customer_refund_transaction_email->subject = 'Refund Notification!';
        $customer_refund_transaction_email->template_type = EmailTemplate::CUSTOMER_REFUND_TRANSACTION_EMAIL;
        $customer_refund_transaction_email->save();

        $customer_refund_transaction_email_attribute = $customer_refund_transaction_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$customer_refund_transaction_email_attribute) {
            $customer_refund_transaction_email_attribute = new EmailTemplateAttribute();
            $customer_refund_transaction_email_attribute->email_template_id = $customer_refund_transaction_email->id;
            $customer_refund_transaction_email_attribute->attr_key = 'greeting_message';
        }

        $customer_refund_transaction_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}", "{%ORDER_PRODUCT%}"';
        $customer_refund_transaction_email_attribute->attr_val = 'Hi {%ORDER_FULL_NAME%}, <br/>Your payment against {%ORDER_PRODUCT%} has been refunded successfully.';
        $customer_refund_transaction_email_attribute->save();

        /** customer sample request email */
        $customer_sample_request_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_SAMPLE_REQUEST_EMAIL)->first();
        if (!$customer_sample_request_email) {
            $customer_sample_request_email = new EmailTemplate();
        }
        $customer_sample_request_email->subject = 'Sample Request Confirmation!';
        $customer_sample_request_email->template_type = EmailTemplate::CUSTOMER_SAMPLE_REQUEST_EMAIL;
        $customer_sample_request_email->save();

        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'main_body')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'main_body';
        }
        $customer_sample_request_email_attribute->hints = '"{%APP_NAME%}", "{%FULL_NAME%}", "{%FIRST_NAME%}", "{%LAST_NAME%}", "{%EMAIL%}", "{%PHONE_NUMBER%}", "{%GENDER%}", "{%COMPANY_BLOCK%}", "{%ADDRESS_BLOCK%}", "{%PRODUCT_1_BLOCK%}", "{%PRODUCT_2_BLOCK%}", "{%DOG_WEIGHT_BLOCK%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- Main Email Body : BEGIN -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

        <!-- Full Width, Fluid Column : BEGIN -->
        <tr>
            <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
                <!-- COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            Hi {%FULL_NAME%},
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            Thank you for submitting the sample request. We will let you know once your request is processed. Below are the details for your submitted request.
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 15px 0 0;" class="padding">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 544px;"
                                   class="responsive-table">
                                <tr>
                                    <td style="padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;">
                                        Sample Request Details
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">

                                    <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Full Name
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%FULL_NAME%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Email
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%EMAIL%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Phone No
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%PHONE_NUMBER%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>
                                                    {%COMPANY_BLOCK%}
                                                    {%ADDRESS_BLOCK%}
                                                    {%PRODUCT_1_BLOCK%}
                                                    {%PRODUCT_2_BLOCK%}
                                                    {%DOG_WEIGHT_BLOCK%}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!--100% Satisfaction-->
                                <tr>
                                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                           style="width: 100%;" align="center">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="center"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">
                                                                            <small>100% SATISFACTION GUARANTEED</small>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Full Width, Fluid Column : END -->

    </table>
    <!-- Main Email Body : END -->';
        $customer_sample_request_email_attribute->save();

        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'company_block')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'company_block';
        }
        $customer_sample_request_email_attribute->hints = '"{%COMPANY%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Company
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%COMPANY%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_email_attribute->save();

        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'address_block')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'address_block';
        }
        $customer_sample_request_email_attribute->hints = '"{%STREET_ADDRESS%}", "{%CITY%}", "{%STATE%}", "{%POSTAL_CODE%}", "{%COUNTRY%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="left">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                Address
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- RIGHT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="right">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="right"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                {%STREET_ADDRESS%}<br/>
                                                                                {%CITY%}, {%STATE%}<br/>
                                                                                {%POSTAL_CODE%}, {%COUNTRY%}.
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div style=" clear: both;"></div>';
        $customer_sample_request_email_attribute->save();


        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'product_1_block')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'product_1_block';
        }
        $customer_sample_request_email_attribute->hints = '"{%PRODUCT_1_NAME%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_1_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_email_attribute->save();


        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'product_2_block')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'product_2_block';
        }
        $customer_sample_request_email_attribute->hints = '"{%PRODUCT_2_NAME%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_2_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_email_attribute->save();


        $customer_sample_request_email_attribute = $customer_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'weight_block')->first();
        if (!$customer_sample_request_email_attribute) {
            $customer_sample_request_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_email_attribute->email_template_id = $customer_sample_request_email->id;
            $customer_sample_request_email_attribute->attr_key = 'weight_block';
        }
        $customer_sample_request_email_attribute->hints = '"{%WEIGHT%}"';
        $customer_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Dog Weight</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%WEIGHT%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_email_attribute->save();


        /** customer sample request approved email */
        $customer_sample_request_approved_email = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_SAMPLE_REQUEST_APPROVED_EMAIL)->first();
        if (!$customer_sample_request_approved_email) {
            $customer_sample_request_approved_email = new EmailTemplate();
        }
        $customer_sample_request_approved_email->subject = 'Sample Request Approved!';
        $customer_sample_request_approved_email->template_type = EmailTemplate::CUSTOMER_SAMPLE_REQUEST_APPROVED_EMAIL;
        $customer_sample_request_approved_email->save();

        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'main_body')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'main_body';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%APP_NAME%}", "{%FULL_NAME%}", "{%FIRST_NAME%}", "{%LAST_NAME%}", "{%EMAIL%}", "{%PHONE_NUMBER%}", "{%GENDER%}", "{%COMPANY_BLOCK%}", "{%ADDRESS_BLOCK%}", "{%PRODUCT_1_BLOCK%}", "{%PRODUCT_2_BLOCK%}", "{%DOG_WEIGHT_BLOCK%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- Main Email Body : BEGIN -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

        <!-- Full Width, Fluid Column : BEGIN -->
        <tr>
            <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
                <!-- COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            Hi {%FULL_NAME%},
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            Congratulations! Your Sample Request has been approved. Please find the details of your sample request.
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 15px 0 0;" class="padding">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 544px;"
                                   class="responsive-table">
                                <tr>
                                    <td style="padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;">
                                        Sample Request Details
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">

                                    <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Full Name
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%FULL_NAME%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Email
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%EMAIL%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Phone No
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%PHONE_NUMBER%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>
                                                    {%COMPANY_BLOCK%}
                                                    {%ADDRESS_BLOCK%}
                                                    {%PRODUCT_1_BLOCK%}
                                                    {%PRODUCT_2_BLOCK%}
                                                    {%DOG_WEIGHT_BLOCK%}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!--100% Satisfaction-->
                                <tr>
                                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                           style="width: 100%;" align="center">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="center"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">
                                                                            <small>100% SATISFACTION GUARANTEED</small>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Full Width, Fluid Column : END -->

    </table>
    <!-- Main Email Body : END -->';
        $customer_sample_request_approved_email_attribute->save();

        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'company_block')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'company_block';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%COMPANY%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Company
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%COMPANY%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_approved_email_attribute->save();

        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'address_block')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'address_block';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%STREET_ADDRESS%}", "{%CITY%}", "{%STATE%}", "{%POSTAL_CODE%}", "{%COUNTRY%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="left">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                Address
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- RIGHT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="right">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="right"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                {%STREET_ADDRESS%}<br/>
                                                                                {%CITY%}, {%STATE%}<br/>
                                                                                {%POSTAL_CODE%}, {%COUNTRY%}.
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div style=" clear: both;"></div>';
        $customer_sample_request_approved_email_attribute->save();


        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'product_1_block')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'product_1_block';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%PRODUCT_1_NAME%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_1_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_approved_email_attribute->save();


        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'product_2_block')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'product_2_block';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%PRODUCT_2_NAME%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_2_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_approved_email_attribute->save();


        $customer_sample_request_approved_email_attribute = $customer_sample_request_approved_email->getEmailTemplateAttributes()->where('attr_key', 'weight_block')->first();
        if (!$customer_sample_request_approved_email_attribute) {
            $customer_sample_request_approved_email_attribute = new EmailTemplateAttribute();
            $customer_sample_request_approved_email_attribute->email_template_id = $customer_sample_request_approved_email->id;
            $customer_sample_request_approved_email_attribute->attr_key = 'weight_block';
        }
        $customer_sample_request_approved_email_attribute->hints = '"{%WEIGHT%}"';
        $customer_sample_request_approved_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Dog Weight</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%WEIGHT%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $customer_sample_request_approved_email_attribute->save();

        /** admin new order email */
        $admin_new_order_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_NEW_ORDER_EMAIL)->first();
        if (!$admin_new_order_email) {
            $admin_new_order_email = new EmailTemplate();
        }
        $admin_new_order_email->subject = 'New order has arrived!';
        $admin_new_order_email->template_type = EmailTemplate::ADMIN_NEW_ORDER_EMAIL;
        $admin_new_order_email->save();

        $admin_new_order_email_attribute = $admin_new_order_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$admin_new_order_email_attribute) {
            $admin_new_order_email_attribute = new EmailTemplateAttribute();
            $admin_new_order_email_attribute->email_template_id = $admin_new_order_email->id;
            $admin_new_order_email_attribute->attr_key = 'greeting_message';
        }

        $admin_new_order_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $admin_new_order_email_attribute->attr_val = '{%ORDER_FULL_NAME%} has placed a new order #<b>{%ORDER_NO%}</b> with the following details.';
        $admin_new_order_email_attribute->save();

        /** admin new order email */
        $admin_declined_order_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_DECLINED_ORDER_EMAIL)->first();
        if (!$admin_declined_order_email) {
            $admin_declined_order_email = new EmailTemplate();
        }
        $admin_declined_order_email->subject = 'Order payment has been declined!';
        $admin_declined_order_email->template_type = EmailTemplate::ADMIN_DECLINED_ORDER_EMAIL;
        $admin_declined_order_email->save();

        $admin_declined_order_email_attribute = $admin_declined_order_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$admin_declined_order_email_attribute) {
            $admin_declined_order_email_attribute = new EmailTemplateAttribute();
            $admin_declined_order_email_attribute->email_template_id = $admin_declined_order_email->id;
            $admin_declined_order_email_attribute->attr_key = 'greeting_message';

        }
        $admin_declined_order_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_ERROR%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $admin_declined_order_email_attribute->attr_val = 'Hi, <br/>{%ORDER_FULL_NAME%} has placed an order #<b>{%ORDER_NO%}</b> has been declined due to <br/><ul style="color: red;list-style: none;"><li><b>{%ORDER_ERROR%}</b></li></ul>';
        $admin_declined_order_email_attribute->save();


        /** admin payment approve email */
        $admin_payment_approve_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_PAYMENT_APPROVE_EMAIL)->first();
        if (!$admin_payment_approve_email) {
            $admin_payment_approve_email = new EmailTemplate();
        }
        $admin_payment_approve_email->subject = 'Payment approval notification';
        $admin_payment_approve_email->template_type = EmailTemplate::ADMIN_PAYMENT_APPROVE_EMAIL;
        $admin_payment_approve_email->save();

        $admin_payment_approve_email_attribute = $admin_payment_approve_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$admin_payment_approve_email_attribute) {
            $admin_payment_approve_email_attribute = new EmailTemplateAttribute();
            $admin_payment_approve_email_attribute->email_template_id = $admin_payment_approve_email->id;
            $admin_payment_approve_email_attribute->attr_key = 'greeting_message';
        }
        $admin_payment_approve_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}","{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}"';
        $admin_payment_approve_email_attribute->attr_val = "Hi, <br/>{%ORDER_FULL_NAME%}'s order #<b>{%ORDER_NO%}</b> payment has been approved.";
        $admin_payment_approve_email_attribute->save();

        /** admin cancel subscription email */
        $admin_cancel_subscription_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_CANCEL_SUBSCRIPTION_EMAIL)->first();
        if (!$admin_cancel_subscription_email) {
            $admin_cancel_subscription_email = new EmailTemplate();
        }
        $admin_cancel_subscription_email->subject = 'Cancel subscription notification!';
        $admin_cancel_subscription_email->template_type = EmailTemplate::ADMIN_CANCEL_SUBSCRIPTION_EMAIL;
        $admin_cancel_subscription_email->save();

        $admin_cancel_subscription_email_attribute = $admin_cancel_subscription_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$admin_cancel_subscription_email_attribute) {
            $admin_cancel_subscription_email_attribute = new EmailTemplateAttribute();
            $admin_cancel_subscription_email_attribute->email_template_id = $admin_cancel_subscription_email->id;
            $admin_cancel_subscription_email_attribute->attr_key = 'greeting_message';
        }

        $admin_cancel_subscription_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}", "{%ORDER_PRODUCT%}"';
        $admin_cancel_subscription_email_attribute->attr_val = 'Hi, <br/>{%ORDER_FULL_NAME%} has cancelled the subscription for order # {%ORDER_NO%}. against {%ORDER_PRODUCT%}.';
        $admin_cancel_subscription_email_attribute->save();

        /** admin refund transaction email */
        $admin_refund_transaction_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_REFUND_TRANSACTION_EMAIL)->first();
        if (!$admin_refund_transaction_email) {
            $admin_refund_transaction_email = new EmailTemplate();
        }
        $admin_refund_transaction_email->subject = 'Refund Notification!';
        $admin_refund_transaction_email->template_type = EmailTemplate::ADMIN_REFUND_TRANSACTION_EMAIL;
        $admin_refund_transaction_email->save();

        $admin_refund_transaction_email_attribute = $admin_refund_transaction_email->getEmailTemplateAttributes()->where('attr_key', 'greeting_message')->first();
        if (!$admin_refund_transaction_email_attribute) {
            $admin_refund_transaction_email_attribute = new EmailTemplateAttribute();
            $admin_refund_transaction_email_attribute->email_template_id = $admin_refund_transaction_email->id;
            $admin_refund_transaction_email_attribute->attr_key = 'greeting_message';
        }

        $admin_refund_transaction_email_attribute->hints = '"{%APP_NAME%}", "{%ORDER_NO%}", "{%ORDER_FULL_NAME%}", "{%ORDER_FIRST_NAME%}", "{%ORDER_LAST_NAME%}", "{%ORDER_EMAIL%}", "{%ORDER_PHONE_NUMBER%}", "{%ORDER_COMPANY%}", "{%ORDER_STREET_ADDRESS%}", "{%ORDER_STREET_ADDRESS_2%}", "{%ORDER_CITY%}", "{%ORDER_STATE%}", "{%ORDER_POSTAL_CODE%}", "{%ORDER_COUNTRY%}", "{%ORDER_BILLING_STREET%}", "{%ORDER_BILLING_STREET_2%}", "{%ORDER_BILLING_CITY%}", "{%ORDER_BILLING_STATE%}", "{%ORDER_BILLING_POSTAL_CODE%}", "{%ORDER_BILLING_PHONE_NO%}", "{%ORDER_PRODUCT%}"';
        $admin_refund_transaction_email_attribute->attr_val = "Hi, <br/>{%ORDER_FULL_NAME%}'s payment against {%ORDER_PRODUCT%} has been refunded successfully.";
        $admin_refund_transaction_email_attribute->save();




        /** admin sample request email */
        $admin_sample_request_email = EmailTemplate::where('template_type', EmailTemplate::ADMIN_SAMPLE_REQUEST_EMAIL)->first();
        if (!$admin_sample_request_email) {
            $admin_sample_request_email = new EmailTemplate();
        }
        $admin_sample_request_email->subject = 'New Sample Request!';
        $admin_sample_request_email->template_type = EmailTemplate::ADMIN_SAMPLE_REQUEST_EMAIL;
        $admin_sample_request_email->save();

        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'main_body')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'main_body';
        }
        $admin_sample_request_email_attribute->hints = '"{%APP_NAME%}", "{%FULL_NAME%}", "{%FIRST_NAME%}", "{%LAST_NAME%}", "{%EMAIL%}", "{%PHONE_NUMBER%}", "{%GENDER%}", "{%COMPANY_BLOCK%}", "{%ADDRESS_BLOCK%}", "{%PRODUCT_1_BLOCK%}", "{%PRODUCT_2_BLOCK%}", "{%DOG_WEIGHT_BLOCK%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- Main Email Body : BEGIN -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

        <!-- Full Width, Fluid Column : BEGIN -->
        <tr>
            <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
                <!-- COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            Hi,
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;"
                            class="padding-copy">
                            A new Sample request has been submitted by {%FULL_NAME%}. Below are the details for submitted request.
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 15px 0 0;" class="padding">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 544px;"
                                   class="responsive-table">
                                <tr>
                                    <td style="padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;">
                                        Sample Request Details
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">

                                    <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Full Name
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%FULL_NAME%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Email
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%EMAIL%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>

                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Phone No
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%PHONE_NUMBER%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>
                                                    {%COMPANY_BLOCK%}
                                                    {%ADDRESS_BLOCK%}
                                                    {%PRODUCT_1_BLOCK%}
                                                    {%PRODUCT_2_BLOCK%}
                                                    {%DOG_WEIGHT_BLOCK%}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!--100% Satisfaction-->
                                <tr>
                                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                        <!-- TWO COLUMNS -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td valign="top" class="mobile-wrapper">
                                                    <!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                           style="width: 100%;" align="center">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="center"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">
                                                                            <small>100% SATISFACTION GUARANTEED</small>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Full Width, Fluid Column : END -->

    </table>
    <!-- Main Email Body : END -->';
        $admin_sample_request_email_attribute->save();

        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'company_block')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'company_block';
        }
        $admin_sample_request_email_attribute->hints = '"{%COMPANY%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            Company
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                           style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                            {%COMPANY%}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $admin_sample_request_email_attribute->save();

        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'address_block')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'address_block';
        }
        $admin_sample_request_email_attribute->hints = '"{%STREET_ADDRESS%}", "{%CITY%}", "{%STATE%}", "{%POSTAL_CODE%}", "{%COUNTRY%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="left">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                Address
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- RIGHT COLUMN -->
                                                        <table cellpadding="0" cellspacing="0" border="0" width="47%"
                                                               style="width: 47%;" align="right">
                                                            <tr>
                                                                <td style="padding: 0 0 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="right"
                                                                                style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                                {%STREET_ADDRESS%}<br/>
                                                                                {%CITY%}, {%STATE%}<br/>
                                                                                {%POSTAL_CODE%}, {%COUNTRY%}.
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div style=" clear: both;"></div>';
        $admin_sample_request_email_attribute->save();


        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'product_1_block')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'product_1_block';
        }
        $admin_sample_request_email_attribute->hints = '"{%PRODUCT_1_NAME%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_1_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $admin_sample_request_email_attribute->save();


        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'product_2_block')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'product_2_block';
        }
        $admin_sample_request_email_attribute->hints = '"{%PRODUCT_2_NAME%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Product</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%PRODUCT_2_NAME%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $admin_sample_request_email_attribute->save();


        $admin_sample_request_email_attribute = $admin_sample_request_email->getEmailTemplateAttributes()->where('attr_key', 'weight_block')->first();
        if (!$admin_sample_request_email_attribute) {
            $admin_sample_request_email_attribute = new EmailTemplateAttribute();
            $admin_sample_request_email_attribute->email_template_id = $admin_sample_request_email->id;
            $admin_sample_request_email_attribute->attr_key = 'weight_block';
        }
        $admin_sample_request_email_attribute->hints = '"{%WEIGHT%}"';
        $admin_sample_request_email_attribute->attr_val = '<!-- LEFT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Dog Weight</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- RIGHT COLUMN -->
                                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                        <tr>
                                                            <td style="padding: 0 0 10px 0;">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                       width="100%">
                                                                    <tr><td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{%WEIGHT%}</td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style=" clear: both;"></div>';
        $admin_sample_request_email_attribute->save();

    }
}
