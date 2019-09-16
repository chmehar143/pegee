@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Update Subscription</h2>
        </div>
    </div>

    <section class="divider">
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
            <div class="section-content">
                <div class="row mt-30">
                    <form id="update-subscription" name="update_subscription" class="update-subscription" action="{{ route('update.subscription') }}" method="POST">
                        {{ csrf_field() }}

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
                                <div id="cardNumberErr" class="form-group col-md-6{{ $errors->has('cardNumber') ? ' has-error' : '' }}">
                                    <label for="cardNumber" class="control-label">Card Number</label>
                                    <input id="cardNumber" type="number" class="form-control" placeholder="Card Number" name="cardNumber" value="{{ old('cardNumber') }}" />

                                    <span id="cardNumberErrText" class="help-block">
                                        @if ($errors->has('cardNumber'))
                                        <strong>{{ $errors->first('cardNumber') }}</strong>
                                        @endif
                                    </span>
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('cardCode') ? ' has-error' : '' }}">
                                    <label for="cardCode" class="control-label">Card Code</label>
                                    <input id="cardCode" type="number" class="form-control" placeholder="Card Code" name="cardCode" value="{{ old('cardCode') }}" />

                                    <span class="help-block">
                                        @if ($errors->has('cardCode'))
                                        <strong>{{ $errors->first('cardCode') }}</strong>
                                        @endif
                                    </span>
                                </div>
                                <div id="expMonthErr" class="form-group col-md-6{{ $errors->has('expMonth') ? ' has-error' : '' }}">
                                    <label for="expMonth" class="control-label">Month</label>
                                    <input id="expMonth" type="number" class="form-control" placeholder="Month" name="expMonth" value="{{ old('expMonth') }}" />
                                    <span id="expMonthErrText" class="help-block">
                                        @if ($errors->has('expMonth'))
                                        <strong>{{ $errors->first('expMonth') }}</strong>
                                        @endif
                                    </span>
                                </div>
                                <div id="expYearErr" class="form-group col-md-6{{ $errors->has('expYear') ? ' has-error' : '' }}">
                                    <label for="expYear" class="control-label">Year</label>
                                    <input id="expYear" type="number" class="form-control" placeholder="Year" name="expYear" value="{{ old('expYear') }}" />
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
                            <input type="hidden" name="subscription_id" id="subscription-id" value="{{ $orderDetail->subscription_id}}" />
                            <input type="hidden" name="dataValue" id="dataValue" />
                            <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
                        </div>

                        <div class="form-group text-center">
                            <input name="form_botcheck" class="form-control" type="hidden" value="" />
                            <button id="sendAuthNet" type="button" onclick="sendPaymentDataToAnet();" class="btn btn-theme-colored btn-sm mt-0 font-16" data-loading-text="Please wait...">Update Subscription</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section> 
</div>
<script type="text/javascript">
    $('#update_subscription').submit(function () {
        $(this).find(':input[type=submit]').prop('disabled', true);
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

        document.getElementById("update-subscription").submit();
        $('#update-subscription').submit(function () {
            $(this).find(':input[type=submit]').prop('disabled', true);
        });
    }
</script>
@endsection
