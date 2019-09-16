@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update Order Status</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('order.update', ['id' => $order->id]) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="control-label">Status</label>

                            <select name="status" id="status" class="form-control" required>
                                <option value="0">Please select</option>
                                @foreach($statuses as $status)
                                <option value="{{$status->id}}" {{ ($errors->has('status') ? old('status') : $order->shipping_status) == $status->id ? 'selected' : ''}} >{{$status->status }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('tracking_id') ? ' has-error' : '' }}">
                            <label for="status" class="control-label">Tracking Id</label>
                            <input type="text" class="form-control" id="tracking_id" name="tracking_id" value="{{old('tracking_id') ? old('tracking_id') : $order->tracking_id}}" />
                            @if ($errors->has('tracking_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('tracking_id') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('tracking_type') ? ' has-error' : '' }}">
                            <label for="status" class="control-label">Tracking Service Provider</label>
                            <select id="tracking_type" name="tracking_type" class="form-control">
                                <option value="">Please Select</option>
                                @foreach($tracking_service_providers as $tracking_service_provider)
                                    <option value="{{$tracking_service_provider}}" {{(old('tracking_type') && old('tracking_type') == $tracking_service_provider) ? 'selected' : ($order->tracking_type == $tracking_service_provider ? 'selected' : '')  }}>{{$tracking_service_provider}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tracking_type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('tracking_type') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{route('order.show', $order->order_id)}}" class="btn btn-info">
                                    Back
                                </a>
                            </div>
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