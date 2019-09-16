@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Offer</div>
                    <div class="panel-body">

                        <form method="POST" action="{{ route('admin.order.address-update', $order->order_no)}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-12{{ $errors->has('street') ? ' has-error' : '' }}">
                                    <label for="street" class="control-label">Address</label>
                                    <input id="street" type="text" class="form-control"
                                           placeholder="Street address" name="street"
                                           value="{{ $order->street ? $order->street : old('street') }}"/>
                                    @if ($errors->has('street'))
                                        <span class="help-block"><strong>{{ $errors->first('street') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="street2" type="text" class="form-control"
                                           placeholder="Apartment, suite, unit etc. (optional)"
                                           name="street2"
                                           value="{{ $order->street2 ? $order->street2 : old('street2') }}"/>
                                </div>

                                <div class="form-group col-md-6{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="control-label">City</label>
                                    <input id="city" type="text" class="form-control" placeholder="City"
                                           name="city"
                                           value="{{ $order->city ? $order->city : old('city') }}"/>
                                    @if ($errors->has('city'))
                                        <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('state') ? ' has-error' : '' }}">
                                    <label for="state" class="control-label">State</label>
                                    <select name="state" id="state" class="form-control">
                                        @if(count($states) > 0)
                                            <option value="0">{{"Select State"}}</option>
                                            @foreach($states as $abr=>$state)
                                                <option value="{{$abr}}" {{($order->state && $order->state == $abr) ? 'selected' : old('state') == $abr ? 'selected' : ''}} >{{$state}}</option>
                                            @endforeach
                                        @else
                                            <option value="">{{"No State Found"}}</option>
                                        @endif
                                    </select>

                                    @if ($errors->has('state'))
                                        <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                    <label for="postal-code" class="control-label">Zip/Postal
                                        Code</label>
                                    <input id="postal_code" type="text" class="form-control"
                                           placeholder="Zip/Postal Code" name="postal_code"
                                           value="{{ $order->postal_code ? $order->postal_code : old('postal_code') }}"/>

                                    @if ($errors->has('postal_code'))
                                        <span class="help-block"><strong>{{ $errors->first('postal_code') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country" class="control-label">Country</label>
                                    <select name="country" id="country" class="form-control">
                                        @if(count($countries) > 0)
                                            <option value="0">{{"Select Country"}}</option>
                                            @foreach($countries as $abr => $country)
                                                <option value="{{$abr}}" {{ ($order->country && $order->country == $abr) ?  'selected' : old('country') == $abr ? 'selected' : ''}} >{{ $country }}</option>
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

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Update Address</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    </script>

@endsection