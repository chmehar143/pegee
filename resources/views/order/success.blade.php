@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Success!</h2>
            </div>
        </div>

        <section class="divider">
            <div class="container">
                <?php
                $cartItems = array();
                $totalQuantity = 0;
                $sa_products = [];
                foreach ($order->getOrderDetails as $detail) {
                    $product = $detail->getProductDetail;
                    $totalQuantity += $detail->quantity;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $detail->quantity,
                        'autoship_enabled' => ($detail->autoship_discount > 0),
                        'autoship_discount' => $detail->autoship_discount
                    ];
                    $sa_products[$product->id] = $product->name;
                }
                ?>
                @if (session('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> {{ session('success') }}
                    </div>
                    <script type="text/javascript">
                        var sa_products = <?php echo json_encode($sa_products) ?>;
                        var sa_values = {
                            "site": 27575,
                            "token": "277FGZ0R",
                            'orderid': '{{$order->order_no}}',
                            'name': '{{$order->getName()}}',
                            'email': '{{$order->email}}'
                        };

                        function saLoadScript(src) {
                            var js = window.document.createElement("script");
                            js.src = src;
                            js.type = "text/javascript";
                            document.getElementsByTagName("head")[0].appendChild(js);
                        }

                        var d = new Date();
                        if (d.getTime() - 172800000 > 1477399567000) saLoadScript("//www.shopperapproved.com/thankyou/rate/27575.js"); else saLoadScript("//direct.shopperapproved.com/thankyou/rate/27575.js?d=" + d.getTime());
                    </script>
                        <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>

                        <script>
                            window.renderOptIn = function() {
                                window.gapi.load('surveyoptin', function() {
                                    window.gapi.surveyoptin.render(
                                        {
                                            // REQUIRED FIELDS
                                            "merchant_id": 125279986,
                                            "order_id": "{{$order->order_no}}",
                                            "email": "{{$order->email}}",
                                            "delivery_country": "{{$order->country}}",
                                            "estimated_delivery_date": "{{date('Y-m-d', strtotime('+4 days', strtotime(date('Y-m-d H:i:s'))))}}"


                                        });
                                });
                            }

                            // OPTIONAL FIELDS
                            // "products": [{"gtin":"GTIN1"}, {"gtin":"GTIN2"}]
                        </script>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> {{ session('error') }}
                    </div>
                @endif

                <?php
                $calculatedData = getFinalCalculations($cartItems, $order->getUser, $order->isAutoship(), $order->special_discount == 1);
                ?>
                <input type="hidden" id="grand_total"
                       value="${{ number_format(round($calculatedData['grandTotal'], 2), 2) }}"/>
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('order.detail', $order->order_no) }}"
                               class="btn btn-theme-colored btn-circled">Order Details</a></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Event snippet for www.petpads.net conversion page -->
    <script>
        window.addEventListener('load', function () {
            gtag('event', 'conversion', {
                'send_to': 'AW-814712277/_n0TCLid334Q1Yu-hAM',
                'value': jQuery('#grand_total').val().replace(/[^0-9.]/g, ''),
                'currency': 'USD',
                'transaction_id': ''
            });
        })
    </script>
    <script language="javascript">
        /* Performance Tracking Data */
        var mid            = '310651';
        var cust_type      = '1';
        var order_value    = "{{ number_format(round($calculatedData['grandTotal'], 2), 2) }}";
        var order_id       = '{{$order->order_no}}';
        var units_ordered  = '{{$totalQuantity}}';
    </script>
    <script language="javascript" src="https://s1.cnnx.io/api/roi_tracker.min.js?v=1"></script>
    <script type="text/javascript">
        /* Include all products in the following object using the key value pairs: 'product id':'Product Name' */

        //
    </script>


@endsection
