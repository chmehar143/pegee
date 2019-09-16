<div class="table-responsive users-table">
    @if($order)

        <table class="table table-condensed data-table">
            <tbody>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Initial Order Discount</th>
                @if($detail->subscription_id)
                    <th>Subscription Id</th>
                @endif
                @if($detail->autoship_discount > 0)
                    <th>Autoship Discount</th>
                @endif
                @if($detail->autoship_interval > 0)
                    <th>Autoship Interval</th>
                @endif
                @if($detail->subscription_id)
                    <th>Subscription Status</th>
                @endif
            </tr>
            <tr>
                <td>{{ $detail->getProductDetail->name }}</td>
                <td>$ {{ $detail->price }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>@if($detail->special_discount == 0)
                        @if($detail->discount > 0)&nbsp;
                        {{ $detail->discount }}%
                        @endif
                    @else
                        15%
                    @endif
                </td>
                @if($detail->subscription_id)
                    <td>{{ $detail->subscription_id }}</td>
                @endif
                @if($detail->autoship_discount > 0)
                    <td>{{ $detail->autoship_discount }}%</td>
                @endif
                @if($detail->autoship_interval > 0)
                    <td>{{ $autoships[$detail->autoship_interval] }}</td>
                @endif
                @if($detail->subscription_id)
                    <td>
                        @if($detail->subscription_status > 0)
                            @if($detail->subscription_status == 1)
                                <span class="label label-success">{{ $subscriptionStatus[$detail->subscription_status] }}</span>
                            @elseif($detail->subscription_status == 2)
                                <span class="label label-danger">{{ $subscriptionStatus[$detail->subscription_status] }}</span>
                            @endif
                        @endif
                    </td>
                @endif
            </tr>
            </tbody>
        </table>
        <?php

        if ($showFirstOnly) {
            $transactionDetails = [$detail->getFirstTransaction()];
            $totalTransactions = 1;
        } else {
            $transactionDetails = $detail->getTransactions('desc');
            $totalTransactions = $transactionDetails->count();
        }


        ?>
        @if($totalTransactions > 0)
            @foreach($transactionDetails as $key => $transactionDetail)
                @include('admin/order/_transaction_box', ['totalTransactions' => $totalTransactions, 'hideViewSubscriptionButton' => $hideViewSubscriptionButton])
            @endforeach
        @else
            <table class="table">
                <tr>
                    <th>Date</th>
                    <th>Payment Status</th>
                    <th>Shipping Status</th>
                    <th>Shipping Carrier</th>
                    <th>Shipping Tracking</th>
                </tr>
                <tr>
                    <td>{{ Carbon\Carbon::parse($detail->date_time)->format('M d, Y, H:i') }}</td>
                    <td>
                        @if(is_null($detail->error_description))
                            {{ $paymentStatus[5] }}
                        @else
                            {{ $detail->error_description }}
                        @endif
                    </td>
                    <td>{{ $orderStatus[1] }}</td>
                    <td></td>
                    <td>Tracking information is not available. Please add tracking
                        information.
                    </td>
                </tr>
            </table>
        @endif
    @endif


</div>