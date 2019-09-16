@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Checkout</h2>
        </div>
    </div>

    <section>
        <div class="container">
            <h2 class="title"><i class="fa fa-shield" aria-hidden="true"></i> Secure Checkout</h2>
            @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
            @endif  
            <div class="section-content">
                <div class="row mt-30">
                    <form id="paymentForm" method="POST" action="{{ route('save.checkout')}}">
                        {{ csrf_field() }}
                        <div class="col-md-7">
                            <div class="shipping-details">
                                <h3 class="mb-30">Shipping Details </h3>
                                <div class="row">
                                    <div class="form-group col-md-6{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first-name" class="control-label">First Name</label>
                                        <input id="first_name" type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ (Auth::user() ? Auth::user()->first_name : ($errors->has('first_name') ? old('first_name') : old('first_name'))) }}" autofocus />
                                        @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last-name" class="control-label">Last Name</label>
                                        <input id="last_name" type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ (Auth::user() ? Auth::user()->last_name : ($errors->has('last_name') ? old('last_name') : old('last_name'))) }}" />
                                        @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('company') ? ' has-error' : '' }}">
                                        <label for="company" class="control-label">Company Name</label>
                                        <input id="company" type="text" class="form-control" placeholder="Company Name" name="company" value="{{ old('company') }}" />
                                        @if ($errors->has('company'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                        @endif
                                        <label for="dont's" class="control-label text-warning"> <small>Optional</small> </label>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label">Phone</label>
                                        <input id="phone-no" type="text" class="form-control" placeholder="Phone" name="phone" value="{{ (Auth::user() ? Auth::user()->phone_no : ($errors->has('phone') ? old('phone') : old('phone'))) }}" />
                                        @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                        <label for="dont's" class="control-label text-warning"> <small>Optional</small> </label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="control-label">Email Address</label>
                                            <input id="email" type="email" class="form-control" placeholder="Email Address" name="email" value="{{ (Auth::user() ? Auth::user()->email : ($errors->has('email') ? old('email') : old('email'))) }}" />
                                            @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="dont's" class="control-label text-danger"> We DO NOT ship to PO Boxes </label>
                                        </div>
                                        <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                            <label for="street" class="control-label">Address</label>
                                            <input id="street" type="text" class="form-control" placeholder="Street address" name="street" value="{{ old('street') }}" />
                                            @if ($errors->has('street'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('street') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="street_2" type="text" class="form-control" placeholder="Apartment, suite, unit etc. (optional)" name="street2" value="{{ old('street2') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('city') ? ' has-error' : '' }}">
                                        <label for="city" class="control-label">City</label>
                                        <input id="city" type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" />
                                        @if ($errors->has('city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" class="control-label">State</label>
                                        <select name="state" id="state" class="form-control">
                                            @if(count($states) > 0)
                                            <option value="0">{{"Select State"}}</option>
                                            @foreach($states as $abr=>$state)
                                            <option value="{{$abr}}" {{old('state') == $abr ? 'selected' : ''}} >{{$state}}</option>
                                            @endforeach
                                            @else
                                            <option value="">{{"No State Found"}}</option>
                                            @endif
                                        </select>

                                        @if ($errors->has('state'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                        <label for="postal-code" class="control-label">Zip/Postal Code</label>
                                        <input id="postal_code" type="text" class="form-control" placeholder="Zip/Postal Code" name="postal_code" value="{{ old('postal_code') }}" />

                                        @if ($errors->has('postal_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('postal_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('country') ? ' has-error' : '' }}">
                                        <label for="country" class="control-label">Country</label>
                                        <select name="country" id="country" class="form-control">
                                            @if(count($countries) > 0)
                                            <option value="0">{{"Select Country"}}</option>
                                            @foreach($countries as $abr => $country)
                                            <option value="{{$abr}}" {{old('country') == $abr ? 'selected' : ''}} >{{ $country }}</option>
                                            @endforeach
                                            @else
                                            <option value="">{{"No Country Found"}}</option>
                                            @endif
                                        </select>

                                        @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <?php if (env('APP_ENV') == "production") { ?>
                                <script type="text/javascript"
                                        src="https://js.authorize.net/v1/Accept.js"
                                        charset="utf-8">
                                </script>
                            <?php } else { ?>
                                <script type="text/javascript"
                                        src="https://jstest.authorize.net/v1/Accept.js"
                                        charset="utf-8">
                                </script>
                            <?php } ?>
                            <div class="payment-details">
                                <h3 class="mb-30">Your Payment Information</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="dont's" class="control-label"> We Accept </label>
                                        <div class="payment-method-batches">
                                            <img src="{{ asset('images/batches/ax-plane-s.svg')}}" alt="American Express" class="card-bacthes" />
                                            <img src="{{ asset('images/batches/discover-plane-s.svg')}}" alt="Discover" class="card-bacthes" />
                                            <img src="{{ asset('images/batches/master-card-plane-s.svg')}}" alt="Master Card" class="card-bacthes" />
                                            <img src="{{ asset('images/batches/visa-plane-s.svg')}}" alt="Visa" class="card-bacthes" />
                                        </div>
                                    </div>
                                    <div id="cardNumberErr" class="form-group col-md-6{{ $errors->has('cardNumber') ? ' has-error' : '' }}">
                                        <label for="cardNumber" class="control-label">Card Number</label>
                                        <span class="" title="Example Card Number"><a id="cardNumberFront" href="javascript:void(0);"><i class="fa fa-info-circle fa-1x" aria-hidden="true"></i></a></span>
                                        <input id="cardNumber" type="number" class="form-control" placeholder="Card Number" name="cardNumber" value="{{ old('cardNumber') }}" />

                                        <span id="cardNumberErrText" class="help-block">
                                            @if ($errors->has('cardNumber'))
                                            <strong>{{ $errors->first('cardNumber') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('cardCode') ? ' has-error' : '' }}">
                                        <label for="cardCode" class="control-label">Card Code</label>
                                        <span class=""><a id="cardNumberBack" href="javascript:void(0);"><i class="fa fa-info-circle fa-1x" aria-hidden="true"></i></a></span>
                                        <input id="cardCode" type="number" class="form-control" placeholder="Card Code" name="cardCode" value="{{ old('cardCode') }}" />

                                        <span class="help-block">
                                            @if ($errors->has('cardCode'))
                                            <strong>{{ $errors->first('cardCode') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                    <div id="expMonthErr" class="form-group col-md-12{{ $errors->has('expMonth') ? ' has-error' : '' }}">
                                        <label for="expMonth" class="control-label">Month</label>
                                        <!--<input id="expMonth" type="number" class="form-control" placeholder="Month" name="expMonth" value="{{ old('expMonth') }}" />-->
                                        <select id="expMonth" class="form-control" name="expMonth" >
                                            <option value="">Exp Month</option>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <option value="{{ date('m', strtotime("first day $i month")) }}" {{ old('expMonth') == date('m', strtotime("first day $i month")) ? 'selected' : '' }}>{{ date('F', strtotime("first day $i month")) }}</option>
                                            <?php } ?>
                                        </select>
                                        <span id="expMonthErrText" class="help-block">
                                            @if ($errors->has('expMonth'))
                                            <strong>{{ $errors->first('expMonth') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                    <div id="expYearErr" class="form-group col-md-12{{ $errors->has('expYear') ? ' has-error' : '' }}">
                                        <label for="expYear" class="control-label">Year</label>
                                        <?php
                                        // set start and end year range
                                        $yearArray = range(date('Y'), 2036);
                                        ?>
                                        <!--<input id="expYear" type="number" class="form-control" placeholder="Year" name="expYear" value="{{ old('expYear') }}" />-->
                                        <select id="expYear" class="form-control" name="expYear" >
                                            <option value="">Exp Year</option>
                                            @foreach($yearArray as $year)
                                            <option value="{{ $year }}" {{ old('expYear') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        <span id="expYearErrText" class="help-block">
                                            @if ($errors->has('expYear'))
                                            <strong>{{ $errors->first('expYear') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                    <div id="cardHolderNameErr" class="form-group col-md-12{{ $errors->has('cardHolderName') ? ' has-error' : '' }}">
                                        <label for="cardHolderName" class="control-label">Card Holder Name</label>
                                        <input id="cardHolderName" type="text" class="form-control" placeholder="Card Holder Name" name="cardHolderName" value="{{ old('cardHolderName') }}" />
                                        @if ($errors->has('cardHolderName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cardHolderName') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="dataValue" id="dataValue" />
                                <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
                            </div>
                            <div class="billing-details">
                                <h3 class="mb-30">Billing Details</h3>
                                <div class="billing-div">
                                    <label>
                                        <input id="billing-checkbox" class="billing-checkbox" type="checkbox" name="billingCheckBox" value="1">
                                        Same as my Shipping Address
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('b_street') ? ' has-error' : '' }}">
                                            <label for="b_street" class="control-label">Address</label>
                                            <input id="b-street" type="text" class="form-control" placeholder="Billing Street address" name="b_street" value="{{ old('b_street') }}" />
                                            @if ($errors->has('street'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('b_street') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="b-street-2" type="text" class="form-control" placeholder="Billing Apartment, suite, unit etc. (optional)" name="b_street_2" value="{{ old('b_street_2') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('b_city') ? ' has-error' : '' }}">
                                        <label for="b_city" class="control-label">City</label>
                                        <input id="b-city" type="text" class="form-control" placeholder="City" name="b_city" value="{{ old('b_city') }}" />
                                        @if ($errors->has('b_city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('b_city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('b_state') ? ' has-error' : '' }}">
                                        <label for="b_state" class="control-label">State</label>
                                        <select name="b_state" id="b-state" class="form-control">
                                            @if(count($states) > 0)
                                            <option value="0">{{"Select State"}}</option>
                                            @foreach($states as $abr=>$state)
                                            <option value="{{$abr}}" {{old('state') == $abr ? 'selected' : ''}} >{{$state}}</option>
                                            @endforeach
                                            @else
                                            <option value="">{{"No State Found"}}</option>
                                            @endif
                                        </select>

                                        @if ($errors->has('b_state'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('b_state') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('b_postal_code') ? ' has-error' : '' }}">
                                        <label for="b-postal-code" class="control-label">Zip/Postal Code</label>
                                        <input id="b-postal-code" type="text" class="form-control" placeholder="Zip/Postal Code" name="b_postal_code" value="{{ old('b_postal_code') }}" />

                                        @if ($errors->has('b_postal_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('b_postal_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('b_phone_no') ? ' has-error' : '' }}">
                                        <label for="b_phone_no" class="control-label">Phone</label>
                                        <input id="b-phone-no" type="text" class="form-control" placeholder="Phone" name="b_phone_no" value="{{ old('b_phone_no') }}" />
                                        @if ($errors->has('b_phone_no'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('b_phone_no') }}</strong>
                                        </span>
                                        @endif
                                        <label for="dont's" class="control-label text-warning"> <small>Optional</small> </label>
                                    </div>
                                </div>
                            </div>
                            <?php $dataWithAutoShip = getFinalCalculations($cartItems, $loggedInUser, true) ?>
                            <?php $dataWithoutAutoShip = getFinalCalculations($cartItems, $loggedInUser, false) ?>
                            <?php if ($dataWithAutoShip['countOfAutoshipProducts']) { ?>
                                <div class="checkout_autoship_wrap">
                                    <div class="checkout_autoship">
                                    
                                        <div class="checkout_autoship-selections">
                                            <div class="checkout-content">
                                                <input class="radio_n" id="autoRadioYes" type="radio" name="auto" value="1">
                                                <label for="autoRadioYes" class="foption"><strong>Yes, make my life easy.</strong> 
                                                    <span class="sublabel">
                                                        You'll save an additional
                                                        <strong>20%</strong>
                                                        on this order, <strong> plus 5%</strong>
                                                        on eligible items on all Autoship orders!
                                                    </span>
                                                </label>
                                                <div class="autoship-items row">

                                                    <div class="col-md-6">
                                                        <div class="autoship-suboptions">
                                                            <div id="autoShipDropdown" class="suboption">
                                                                <label>Ship these items every:</label>
                                                                <select id="autoShipDrop" class="form-control" name="autoShip">
                                                                    <option value="0">Select One</option>
                                                                    @foreach($autoShips as $key => $autoShip)
                                                                    <option value="{{ $key }}" {{ old('autoShip') == $key ? 'selected' : ''}} >{{ $autoShip }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span id="autoShipInterval" class="help-block hide">
                                                                    <strong>Please select the interval for autoship </strong>
                                                                </span>
                                                                @if ($errors->has('autoShip'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('autoShip') }}</strong>
                                                                </span>
                                                                @endif
                                                                <p class="fnote">
                                                                    You can easily edit, cancel, or reschedule shipments at any time.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="included-items">
                                                            <h3>Items in your Autoship:</h3>
                                                            <ul>
                                                                @foreach ($cartItems as $item)
                                                                <li>
                                                                    <span class="discount">
                                                                        @if($item['product']->getActiveAutoShip())
                                                                        <a href="{{ route('product', ['slug' => $item['product']->slug] ) }}">
                                                                            <img width="50" alt="member" src="{{ asset('uploads/product/thumbnail/'. $item['product']->getFeaturedImage()->product_image) }}" />
                                                                        </a>
                                                                        <span>+{{ $item['product']->getActiveAutoShip()->autoship_percentage }}&#37 off!</span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkout-content checkout-no-thanks">
                                                <input id="autoRadioNo" type="radio" name="auto" class="radio_n" value="0" checked="">
                                                <label for="autoRadioNo" class="foption"> <strong> No, thank you.</strong> 
                                                    <span class="sublabel">Your order will only ship once.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="control-label text-danger" style="color: #e62f2d; font-weight: bold;">Maximum value of discount 20% off</span>
                                </div>
                            <?php } ?>
                            <div class="text-right"> <button id="sendAuthNet" type="button" onclick="sendPaymentDataToAnet()" class="btn btn-theme-colored btn-circled ">Place Order</button> </div>
                        </div>
                    </form>
                    <div class="col-md-5 without-autoship">
                        <h3>Your order</h3>
                        <table class="table tbl-shopping-cart">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-right"><a href="{{ url('shop/cart') }}">Edit Cart</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                <tr class="items">
                                    <td class="product-thumbnail" width="30%">
                                        <a href="{{ route('product', ['slug' => $item['product']->slug] ) }}">
                                            <img alt="member" src="{{ asset('uploads/product/thumbnail/'. $item['product']->getFeaturedImage()->product_image) }}">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product', ['slug' => $item['product']->slug] ) }}">{{ $item['product']->name }}</a>
                                        <table width="100%" border="0">
                                            <tr class="price-list">
                                                <td align="left">Qty: {{ $item['quantity'] }}</td>
                                                <td class="before-autoship text-right non-autoship"><span class="amount">&#36;{{ number_format($item['product']->price * $item['quantity'], 2) }}</span></td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="70%">Sub-total</td>
                                                <td class="text-right"><span class="amount">${{ number_format(round($dataWithoutAutoShip['totalPrice'], 2), 2) }}</span></td>
                                            </tr>
                                            @foreach($dataWithoutAutoShip['discounts'] as $discount_with_text)
                                            <tr>
                                                <td>{{$discount_with_text['text']}}</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(round($discount_with_text['value'], 2), 2) }}</span></td>
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <td width="70%">Shipping FREE</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(0, 2) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td class="text-right"><span class="amount">${{ number_format(round(($dataWithoutAutoShip['grandTotal']), 2), 2) }}</span></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <span class="control-label text-danger" style="color: #e62f2d; font-weight: bold;">Maximum value of discount 20% off</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5 with-autoship hide">
                        <h3>Your order</h3>
                        <table class="table tbl-shopping-cart">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-right"><a href="{{ url('shop/cart') }}">Edit Cart</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                <tr class="items">
                                    <td class="product-thumbnail" width="30%">
                                        <a href="{{ route('product', ['slug' => $item['product']->slug] ) }}">
                                            <img alt="member" src="{{ asset('uploads/product/thumbnail/'. $item['product']->getFeaturedImage()->product_image) }}">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product', ['slug' => $item['product']->slug] ) }}">{{ $item['product']->name }}</a>
                                        <table width="100%" border="0">
                                            <tr class="price-list">
                                                <td align="left">Qty: {{ $item['quantity'] }}</td>
                                                @if($item['product']->getActiveAutoShip())
                                                <td class="apply-autoship text-right autoship-discounted"><del><span class="amount">&#36;{{ number_format($item['product']->price * $item['quantity'], 2) }}</span></del></td>
                                                <td class="after-autoship text-right autoship-discounted">
                                                    <span class="amount">&#36;{{ number_format($dataWithAutoShip['internalDiscountMapping'][$item['product']->id]['PriceAfterAutoshipDiscount'], 2) }}</span>
                                                </td>
                                                @else
                                                <td class="before-autoship text-right non-autoship"><span class="amount">&#36;{{ number_format($item['product']->price * $item['quantity'], 2) }}</span></td>
                                                @endif
                                            </tr>
                                        </table>
                                        @if($item['product']->getActiveAutoShip())
                                        <ul class="autoShipDis variation">
                                            <li class="variation-size"><span class="autoship_n"><img src="{{ asset('images/ship1.png') }}" width="20" alt="" class="autoship-save"> Autoship & Save </span> -{{ $item['product']->getActiveAutoShip()->autoship_percentage }}&#37 off </li>
                                        </ul>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="70%">Sub-total</td>
                                                <td class="text-right"><span class="amount">${{ number_format(round($dataWithAutoShip['totalPrice'], 2), 2) }}</span></td>
                                            </tr>

                                            @if($dataWithAutoShip['firstTimeAutoShip'])
                                            <tr>
                                                <td width="70%">15% off first Autoship order</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(round($dataWithAutoShip['firstTimeAutoShipDiscount'], 2), 2) }}</span></td>
                                            </tr>
                                            @endif
                                            @foreach($dataWithAutoShip['discounts'] as $discount_with_text)
                                            <tr>
                                                <td>{{$discount_with_text['text']}}</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(round($discount_with_text['value'], 2), 2) }}</span></td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td width="70%">Autoship & Save Discount</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(round($dataWithAutoShip['autoshipDiscount'], 2), 2) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td width="70%">Shipping FREE</td>
                                                <td class="text-right"><span class="amount">-${{ number_format(0, 2) }}</span></td>
                                            </tr>


                                            <tr>
                                                <td>Grand Total</td>
                                                <td class="text-right"><span class="amount">${{ number_format(round(($dataWithAutoShip['grandTotal']), 2), 2) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <span class="control-label text-danger" style="color: #e62f2d; font-weight: bold;">Maximum value of discount 20% off</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var cardNumberFront = '<img src="{{asset("images/credit_card_number.jpg")}}">';
        $('#cardNumberFront').popover({placement: 'right', content: cardNumberFront, html: true});
        var cardNumberBack = '<img src="{{asset("images/CreditCardBack.jpg")}}">';
        $('#cardNumberBack').popover({placement: 'right', content: cardNumberBack, html: true});


        $('#billing-checkbox').on('click', function () {
            if ($(this).is(':checked')) {
                var street = $('#street').val();
                $("#b-street").val(street);
                var street2 = $('#street_2').val();
                $("#b-street-2").val(street2);
                var city = $('#city').val();
                $("#b-city").val(city);
                var postal_code = $('#postal_code').val();
                $("#b-postal-code").val(postal_code);
                var phone_no = $('#phone-no').val();
                $("#b-phone-no").val(phone_no);
                var state = $('#state').val();
                $("select[name='b_state']:eq(0)").val(state);
                $("#b-street").attr("disabled", true);
                $("#b-street-2").attr("disabled", true);
                $("#b-city").attr("disabled", true);
                $("#b-state").attr("disabled", true);
                $("#b-postal-code").attr("disabled", true);
                $("#b-phone-no").attr("disabled", true);
            } else {
                $("#b-street").prop("disabled", false);
                $("#b-street-2").prop("disabled", false);
                $("#b-city").prop("disabled", false);
                $("#b-state").prop("disabled", false);
                $("#b-postal-code").prop("disabled", false);
                $("#b-phone-no").prop("disabled", false);
            }
        });

        if (parseInt($('#autoRadioNo').val()) === 0) {
            $("#autoShipDrop").attr("disabled", true);
        }
        $('#autoRadioNo').on('change', function () {
            $("#autoShipDrop").prop('selectedIndex', 0);
        });
        $("#autoRadioYes").on('change', function () {
<?php if (Auth::user()) { ?>
                $("#autoShipDrop").attr("disabled", false);
                $('#sendAuthNet').attr("disabled", true);
                $('.without-autoship').addClass('hide');
                $('.with-autoship').removeClass('hide');
<?php } else { ?>
                window.location.href = '{{ route("redirected.subscription") }}';
<?php } ?>
        });
        $("#autoRadioNo").on('change', function () {
            $("#autoShipDrop").attr("disabled", true);
            $('#sendAuthNet').attr("disabled", false);
            $('.without-autoship').removeClass('hide');
            $('.with-autoship').addClass('hide');
        });

        $('input[name=auto]').on('change', function () {
            var isChecked = $("input[name=auto]:checked").val();
            if (isChecked == 1) {
                $('#autoShipInterval').removeClass('hide');
                $('#autoShipDropdown').addClass('has-error');
            } else {
                $('#autoShipInterval').addClass('hide');
                $('#autoShipDropdown').removeClass('has-error');
            }
        });

        $('#autoShipDrop').on('change', function () {
            var dropValue = $('#autoShipDrop').val();
            if (dropValue > 0) {
                $('#autoShipDropdown').removeClass('has-error');
                $('#autoShipInterval').addClass('hide');
                $('#sendAuthNet').attr("disabled", false);
            } else {
                $('#sendAuthNet').attr("disabled", true);
                $('#autoShipDropdown').addClass('has-error');
                $('#autoShipInterval').removeClass('hide');
            }
        });
    });
    $('#checkout-form').submit(function () {
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
    $(window).load(function ()
    {
        var phones = [{"mask": "(###) ###-####"}];
        $('#phone-no, #b-phone-no').inputmask({
            mask: phones,
            greedy: false,
            definitions: {'#': {validator: "[0-9]", cardinality: 1}}});
    });

    function sendPaymentDataToAnet() {
        var authData = {};
        $("#sendAuthNet").prop('disabled', true);
                authData.clientKey = {!! '"'.env('ANET_API_CLIENT_KEY').'"' !!};
                authData.apiLoginID = {!! '"'.env('ANET_API_LOGIN_ID').'"' !!};

        var cardData = {};
        cardData.cardNumber = document.getElementById("cardNumber").value;
        cardData.month = document.getElementById("expMonth").value;
        cardData.year = document.getElementById("expYear").value;
        cardData.cardCode = document.getElementById("cardCode").value;

        var secureData = {};
        secureData.authData = authData;
        secureData.cardData = cardData;

        Accept.dispatchData(secureData, responseHandler)

        function responseHandler(response) {
            if (response.messages.resultCode === "Error") {
                for (var i = 0; i < response.messages.message.length; i++) {
//                    console.log(response.messages.message[i].code + ":" + response.messages.message[i].text);
                    switch (response.messages.message[i].code) {
                        case "E_WC_05":
                            $('#cardNumberErr').addClass('has-error');
                            $("#cardNumberErrText").html('<strong>Please provide valid credit card number.</strong>');
                            break;
                        case "E_WC_07":
                            $('#expYearErr').addClass('has-error');
                            $("#expYearErrText").html('<strong>Please provide valid expiration year.</strong>');
                            break;
                        case "E_WC_06":
                            $('#expMonthErr').addClass('has-error');
                            $("#expMonthErrText").html('<strong>Please provide valid expiration month.</strong>');
                            break;
                    }
                }
                $("#sendAuthNet").prop('disabled', false);
            } else {
                paymentFormUpdate(response.opaqueData);
            }
        }
    }

    function paymentFormUpdate(opaqueData) {
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;

        // If using your own form to collect the sensitive data from the customer,
        // blank out the fields before submitting them to your server.
//        document.getElementById("cardNumber").value = "";
//        document.getElementById("expMonth").value = "";
//        document.getElementById("expYear").value = "";
//        document.getElementById("cardCode").value = "";

        document.getElementById("paymentForm").submit();
        $('#paymentForm').submit(function () {
            $(this).find(':input[type=submit]').prop('disabled', true);
        });
    }
</script>
@endsection
