@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div id="printAbleArea">
                    <div class="panel-heading">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Pets World
                            <br/>
                            1673 McDonald Ave
                            <br/>
                            Brooklyn NY 11230
                            <br/>
                            Phone: 844 777 6970
                            <br/>
                            www.petpads.net
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($orderTransactionalDetail)
                            <table class="table table-bordered tbl-shopping-cart">
                                <thead>
                                    <tr>
                                        <th colspan="8">Shipping Details {{ ($orderTransactionalDetail->getOrder->billing_bit == 1) ? '& Billing Details' : '' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <strong>Order No: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrder->order_no }}
                                            <br />
                                            {{ $orderTransactionalDetail->getOrder->first_name }} {{ $orderTransactionalDetail->getOrder->last_name }}
                                            <br />
                                            @if ($orderTransactionalDetail->getOrder->phone != null)
                                                {{ $orderTransactionalDetail->getOrder->phone}}<br />
                                            @elseif($orderTransactionalDetail->getOrder->b_phone_no != null)
                                                {{ $orderTransactionalDetail->getOrder->b_phone_no}}<br />
                                            @elseif($orderTransactionalDetail->getOrder->getUser != null && $orderTransactionalDetail->getOrder->getUser->phone_no != null)
                                                {{$orderTransactionalDetail->getOrder->getUser->phone_no != null}}<br />
                                            @endif

                                            {{ $orderTransactionalDetail->getOrder->street }}
                                            <br />
                                            @if(!is_null($orderTransactionalDetail->getOrder->street2))
                                            {{ $orderTransactionalDetail->getOrder->street2 }}
                                            <br />
                                            @endif
                                            {{ $orderTransactionalDetail->getOrder->city }}, {{ isset($states[$orderTransactionalDetail->getOrder->state]) ? $states[$orderTransactionalDetail->getOrder->state] : '' }} {{ $orderTransactionalDetail->getOrder->postal_code }}
                                        </td>
                                    </tr>
                                </tbody>
                                @if($orderTransactionalDetail->getOrder->billing_bit == 0 && $orderTransactionalDetail->getOrder->b_street != NULL)
                                <thead>
                                    <tr>
                                        <th colspan="8">Billing Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            {{ $orderTransactionalDetail->getOrder->b_street }}
                                            <br />
                                            @if(!is_null($orderTransactionalDetail->getOrder->b_street2))
                                            {{ $orderTransactionalDetail->getOrder->b_street2 }}
                                            <br />
                                            @endif
                                            {{ $orderTransactionalDetail->getOrder->b_city }}, {{ isset($states[$orderTransactionalDetail->getOrder->b_state]) ? $states[$orderTransactionalDetail->getOrder->b_state] : '' }} {{ $orderTransactionalDetail->getOrder->b_postal_code }}
                                        </td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>

                            <table class="table table-condensed data-table">

                                <thead>
                                    <tr>
                                        <th colspan="8">Order Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <strong>Product Purchased:</strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->getProductDetail->name }}
                                            <br />
                                            <strong>Product Price: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->price }} 
                                            <br />
                                            <strong>Product Quantity: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->quantity }}
                                            <br />
                                            @if($orderTransactionalDetail->getOrderDetail->special_discount == 0)
                                            @if($orderTransactionalDetail->getOrderDetail->discount > 0)
                                            <strong>Discount: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->discount }}%
                                            @endif
                                            @else
                                            <strong>Discount: </strong>&nbsp;
                                            15%
                                            @endif
                                            <br />
                                            @if($orderTransactionalDetail->getOrderDetail->autoship_discount > 0 && $orderTransactionalDetail->getOrderDetail->autoship_interval > 0)
                                            <strong>Autoship Discount: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->autoship_discount }}%
                                            <br />
                                            <strong>Autoship Interval: </strong>&nbsp;
                                            Ship {{ $autoships[$orderTransactionalDetail->getOrderDetail->autoship_interval] }}
                                            @endif
                                            <br />
                                            @if($orderTransactionalDetail->getOrderDetail->subscription_id != NULL)
                                            <strong>Subscription Id: </strong>&nbsp;
                                            {{ $orderTransactionalDetail->getOrderDetail->subscription_id }}
                                            @endif
                                            <br />
                                            @if($orderTransactionalDetail->getOrderDetail->subscription_status > 0)
                                            <strong>Subscription Status: </strong>&nbsp;
                                            @if($orderTransactionalDetail->getOrderDetail->subscription_status == 1)
                                            <span class="label label-success">{{ $subscriptionStatus[$orderTransactionalDetail->getOrderDetail->subscription_status] }}</span>
                                            @elseif($orderTransactionalDetail->getOrderDetail->subscription_status == 2)
                                            <span class="label label-danger">{{ $subscriptionStatus[$orderTransactionalDetail->getOrderDetail->subscription_status] }}</span>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Date</th>
                                    </tr>

                                    <tr>
                                        <td>{{ $orderTransactionalDetail->transaction_id }}</td>
                                        <td>{{ Carbon\Carbon::parse($orderTransactionalDetail->date_time)->format('d M, Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="col-md-12 mt-30">
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <h4>Order Totals</h4>
                                        <table class="table table-condensed data-table">
                                            <?php
                                            $cartItems = array();
                                            $cartItems[] = [
                                                'product' => $orderTransactionalDetail->getOrderDetail->getProductDetail,
                                                'quantity' => $orderTransactionalDetail->getOrderDetail->quantity,
                                                'autoship_enabled' => ($orderTransactionalDetail->getOrderDetail->autoship_discount > 0),
                                                'autoship_discount' => $orderTransactionalDetail->getOrderDetail->autoship_discount
                                            ];
                                            $displayFirstTimeAutoShipDiscount = $orderTransactionalDetail->displayFirstTimeAutoShipDiscount();

                                            $calculatedData = getFinalCalculations($cartItems, $orderTransactionalDetail->getOrder->getUser, $orderTransactionalDetail->getOrder->isAutoship(), $displayFirstTimeAutoShipDiscount);
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>Sub-total</td>
                                                    <td>${{ number_format(round($calculatedData['totalPrice'], 2), 2) }}</td>
                                                </tr>
                                                @if($displayFirstTimeAutoShipDiscount)
                                                <tr>
                                                    <td>15% off first Autoship order</td>
                                                    <td>-${{ number_format(round($calculatedData['firstTimeAutoShipDiscount'], 2), 2) }}</td>
                                                </tr>
                                                @endif
                                                @if(!$displayFirstTimeAutoShipDiscount)
                                                @foreach($calculatedData['discounts'] as $discount_with_text)
                                                <tr>
                                                    <td>{{$discount_with_text['text']}}</td>
                                                    <td>-${{ number_format(round($discount_with_text['value'], 2), 2) }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td>Autoship Discounts</td>
                                                    <td>-${{ number_format(round($calculatedData['autoshipDiscount'], 2), 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping FREE</td>
                                                    <td>-${{ number_format(0, 2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>${{ number_format(round($calculatedData['grandTotal'], 2), 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Order's Invoice Found
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button onclick="printDiv()" class="btn btn-info">
                            Print
                        </button>
                        <a href="{{route('order.index')}}" class="btn btn-primary">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    function printDiv() {
        //Get the HTML of div
        
        var divElements = document.getElementById("printAbleArea").innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>

@endsection