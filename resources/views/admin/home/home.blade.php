@extends('layouts.admin')

@section('content')

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Dashboard
                            
                           <span>
                           <form method="GET" action="{{route('admin.home.home')}}">
                            <div class="row">
                                <label class='col-sm-1'>From</label>
                                <div class='col-sm-4' >
                                <input type="text" class="input-sm  form-control " value="<?php if(isset($_GET['fromDate'])) { echo $_GET['fromDate'];}else{ echo "01/01/".date('Y'); } ?>" name="fromDate" id="fromDate">
                                </div>
                                <label class='col-sm-1'>To </label>
                                <div class='col-sm-4'>
                                <input type="text" class="input-sm  form-control " value="<?php if(isset($_GET['toDate'])) { echo $_GET['toDate']; }else{ echo "12/31/".date('Y'); }?>" name="toDate" id="toDate">
                                </div>
                                <div class=" col-sm-2">
                                <button type="submit" class="btn-sm btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body dashboard">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">New Orders This Month</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-success"><i class="fa fa-bell" aria-hidden="true"></i></li>
                                        <li class="text-right"><span
                                                    class="counter">{{$totalMonthOrder->count()}}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Total Pending Orders</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-danger"><i class="fa fa-adjust" aria-hidden="true"></i></li>
                                        <li class="text-right"><span class="counter">{{$orders->count()}}</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Subscriptions This Month</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-success"><i class="fa fa-retweet" aria-hidden="true"></i></li>
                                        <li class="text-right"><span
                                                    class="counter">{{$totalMonthSubscriptionOrder->count()}}</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Direct Orders This Month</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-info"><i class="fa fa-exchange" aria-hidden="true"></i></li>
                                        <li class="text-right"><span
                                                    class="counter">{{$totalDirectSubscriptionOrder->count()}}</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Total Orders</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-success"><i class="fa fa-calendar-check-o"
                                                                    aria-hidden="true"></i></li>
                                        <li class="text-right"><span class="counter">{{$ordersYear->count()}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Total Sales</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-info"><i class="fa fa-usd" aria-hidden="true"></i></li>
                                        <li class="text-right"><span class="counter">${{number_format($ordersYearSale, 2)}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="dashboard-counts">
                                    <h3 class="box-title">Total Sales This Month</h3>
                                    <ul class="list-inline two-part">
                                        <li class="text-info"><i class="fa fa-money" aria-hidden="true"></i></li>
                                        <li class="text-right"><span
                                                    class="counter">${{number_format($ordersMonthSale, 2)}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php

                                $datamax = 10;
                                foreach ($orderMonthlySales as $sale) {
                                    if ($sale[1] > $datamax) {
                                        $datamax = $sale[1];
                                    }

                                }

                                ?>
                                <div id="placeholder" class="demo-placeholder"
                                     style="width:650px; height: 300px; margin: 0 auto"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script language="javascript" type="text/javascript" src="{{ asset('js/flot/jquery.flot.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/flot/jquery.flot.time.js') }}"></script>

    <script type="text/javascript">

     $('#toDate').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        });

         $('#fromDate').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        });

        $(function () {

            var data = <?php echo json_encode($orderMonthlySales) ?>;
            $.plot("#placeholder", [{data: data, label: 'Orders'}], {
                series: {
                    lines: {show: true},
                    points: {show: true}
                },
                yaxis: {
                    ticks: 10,
                    min: 0,
                    max: <?php echo $datamax + 10 ?>,
                    tickDecimals: 0
                },
                xaxes: [{
                    mode: "time",
                    timeformat: "%b %Y"
                }]
            });
        });
    </script>
@endsection

