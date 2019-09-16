<table class="table table-bordered">
    <tr>

        <th colspan="2">
            @if($detail->autoship_discount > 0)
                Autoship # {{($totalTransactions - ($key))}}
            @else
                Payment Information
            @endif
        </th>


    </tr>
    <tr>
        <td>
            <table class="table table-bordered">
                <tr>
                    <th>Transaction Id</th>
                    <td>
                        {{ $transactionDetail->transaction_id }}
                    </td>
                </tr>
                <tr>
                    <th>Transaction Date</th>
                    <td>{{ Carbon\Carbon::parse($transactionDetail->date_time)->format('d M, Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if(is_null($detail->error_code))
                            {{ $paymentStatus[$transactionDetail->payment_status] }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Shipping Status</th>
                    <td>{{ $orderStatus[$transactionDetail->shipping_status] }}</td>
                </tr>
                <tr>
                    <th>Tracking No</th>
                    <td>{{$transactionDetail->tracking_id}}</td>
                </tr>
                <tr>
                    <th>Shipping Carrier</th>
                    <td>{{ ucwords($transactionDetail->tracking_type) }}</td>
                </tr>
                <tr>
                    <th>Shipping Tracking</th>
                    <td>
                        <?php $shipmentTrackings = $transactionDetail->getLatestShipmentTrackings() ?>
                        @if($shipmentTrackings->count() > 0)
                            @foreach($shipmentTrackings as $shipmentTracking)
                                <p>{{$shipmentTracking->status_description}}
                                    - {{date('M d, Y H:i:s', strtotime($shipmentTracking->tracking_datetime))}}</p>
                            @endforeach

                        @else
                            Tracking information is not available. Please add
                            tracking
                            information.
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td width="400">
            <table class="table table-bordered">
                <?php
                $cartItems = array();
                $cartItems[] = [
                    'product' => $detail->getProductDetail,
                    'quantity' => $detail->quantity,
                    'autoship_enabled' => ($detail->autoship_discount > 0),
                    'autoship_discount' => $detail->autoship_discount
                ];
                $displayFirstTimeAutoShipDiscount = $transactionDetail->displayFirstTimeAutoShipDiscount();

                $calculatedData = getFinalCalculations($cartItems, $transactionDetail->getOrder->getUser, $transactionDetail->getOrder->isAutoship(), $displayFirstTimeAutoShipDiscount);
                ?>

                <tr>
                    <th>Total Amount</th>
                    <td align="right">${{$detail->price * $detail->quantity}}</td>
                </tr>

                @if($displayFirstTimeAutoShipDiscount)
                    <tr>
                        <th>15% off first Autoship order</th>
                        <td align="right">
                            -${{ number_format(round($calculatedData['firstTimeAutoShipDiscount'], 2), 2) }}</td>
                    </tr>
                @endif
                @if(!$displayFirstTimeAutoShipDiscount)
                    @foreach($calculatedData['discounts'] as $discount_with_text)
                        <tr>
                            <th>{{$discount_with_text['text']}}</th>
                            <td align="right">-${{ number_format(round($discount_with_text['value'], 2), 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                    <tr>
                        <th>Autoship Discounts</th>
                        <td align="right">-${{ number_format(round($calculatedData['autoshipDiscount'], 2), 2) }}</td>
                    </tr>
                <tr>
                    <th>Total Discount</th>
                    <td align="right">
                        -${{($detail->price * $detail->quantity) - $transactionDetail->transaction_amount}}</td>
                </tr>
                <tr>
                    <th>Shipping Free</th>
                    <td align="right">-${{ number_format(0, 2)}}</td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td align="right">${{$transactionDetail->transaction_amount}}</td>
                </tr>
                @if((!isset($hideAllButtons) || (isset($hideAllButtons) && !$hideAllButtons)))
                    <tr>
                        <td colspan="2">

                            <a onclick="return confirm('Are you sure?');"
                               class="btn btn-sm btn-primary btn-block <?php echo ($transactionDetail->refund_transaction_response_code != NULL || ($transactionDetail->payment_status == 4 || $transactionDetail->payment_status == 5)) ? ' disabled' : ''; ?>"
                               href="{{ route('refund.transaction', $transactionDetail->order_detail_id) }}"
                               data-toggle="tooltip" title="Show">
                                <i class="fa fa fa-retweet fa-fw"
                                   aria-hidden="true"></i> <span>Refund</span>
                            </a>
                            <a class="btn btn-sm btn-success btn-block"
                               href="{{ route('order.edit', $transactionDetail->id) }}"
                               data-toggle="tooltip" title="Edit">
                                <i class="fa fa-pencil fa-fw"
                                   aria-hidden="true"></i>
                                <span>Edit</span><span class=""> Order Shipping Status</span>
                            </a>
                            <a class="btn btn-sm btn-info btn-block"
                               href="{{ route('order.invoice', $transactionDetail->id) }}"
                               data-toggle="tooltip" title="Edit">
                                <i class="fa fa-file-word-o fa-fw"
                                   aria-hidden="true"></i>
                                <span>Order</span><span class=""> Invoice</span>
                            </a>
                            @if((!isset($hideViewSubscriptionButton) && $detail->autoship_interval > 0) || (isset($hideViewSubscriptionButton) && !$hideViewSubscriptionButton))
                                <a class="btn btn-sm btn-warning btn-block"
                                   href="{{ route('order.subscriptions', $detail->id) }}"
                                   data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-file-word-o fa-fw"
                                       aria-hidden="true"></i>
                                    <span>View</span><span
                                            class=""> Subscriptions</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            </table>


        </td>

    </tr>
</table>