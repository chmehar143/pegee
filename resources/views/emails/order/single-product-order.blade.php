@extends('layouts.mail')
@section('content')
<!-- Main Email Body : BEGIN -->
<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
            <!-- COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;" class="padding-copy">
                        {!! $mail_contents !!}
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="center" style="padding: 15px 0 0;" class="padding">

                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 544px;" class="responsive-table">
                            <tr>
                                <td style="padding: 10px 0 10px 0;font-family: Arial, sans-serif;color: #333333;font-size: 16px;font-weight: bold;">
                                    Your Order Details
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        <?php echo $orderDetail->getProductDetail->name; ?>
                                                                        <span style="font-size: 12px;color: #666666;">
                                                                            x {{ $orderDetail->quantity }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        ${{ number_format($orderDetail->price * $orderDetail->quantity, 2) }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style=" clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing$detail="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <?php
                                                    $cartItems = array();

//                                                    foreach ($order->getOrderDetails as $detail) {
//                                                        $cartItems[] = ['product' => $detail->getProductDetail, 'quantity' => $detail->quantity];
                                                        $cartItems[] = [
                                                            'product' => $orderDetail->getProductDetail,
                                                            'quantity' => $orderDetail->quantity,
                                                            'autoship_enabled' => ($orderDetail->autoship_discount > 0),
                                                            'autoship_discount' => $orderDetail->autoship_discount
                                                        ];
//                                                    }
                                                    $calculatedData = getFinalCalculations($cartItems, $orderDetail->getOrder->getUser, $orderDetail->getOrder->isAutoship(), $displayFirstTimeAutoShipDiscount);
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        Sub-total
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        ${{ number_format(round($calculatedData['totalPrice'], 2), 2) }}
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

                            @if($displayFirstTimeAutoShipDiscount)
                            <!--Special Discount Table-->
                            <tr>
                                <td>
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        15% off first Autoship order
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        -${{ number_format(round($calculatedData['firstTimeAutoShipDiscount'], 2), 2) }}
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
                            @endif

                            <!--Discount Table-->
                            @if(!$displayFirstTimeAutoShipDiscount)
                            @foreach($calculatedData['discounts'] as $discount_with_text)
                            <tr>
                                <td>
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        {{$discount_with_text['text']}}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        -${{ number_format(round($discount_with_text['value'], 2), 2) }}
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
                            @endforeach
                            @endif
                            
                            <!--Autoship Discount Table-->
                            <tr>
                                <td>
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        Autoship Discounts
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        -${{ number_format(round($calculatedData['autoshipDiscount'], 2), 2) }}
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


                            <!--Shipping Table-->
                            <tr>
                                <td>
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        Shipping FREE
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        -${{ number_format(0, 2) }}
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

                            <!--Grand Total Table-->
                            <tr>
                                <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">
                                                                        Grand Total
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                                    <tr>
                                                        <td>
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">
                                                                        ${{ number_format(round($calculatedData['grandTotal'], 2), 2) }}
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

                            <!--100% Satisfaction-->
                            <tr>
                                <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                    <!-- TWO COLUMNS -->
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td valign="top" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%;" align="center">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;"><small>100% SATISFACTION GUARANTEED</small></td>
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
<!-- Main Email Body : END -->
@endsection