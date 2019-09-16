@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update Offer</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('offer.update', ['id' => $offer->id]) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('offer') ? ' has-error' : '' }}">
                            <label for="offer" class="control-label">Discount Percentage</label>

                            <input id="offer" type="text" class="form-control" name="offer" value="{{ $errors->has('offer') ? old('offer') : $offer->offer }}" required autofocus>

                            @if ($errors->has('offer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('offer') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="control-label">Discount Quantity</label>

                            <input id="quantity" type="text" class="form-control" name="quantity" value="{{ $errors->has('quantity') ? old('quantity') : $offer->quantity }}" required>

                            @if ($errors->has('quantity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label for="product_id" class="control-label">Product</label>

                            <select name="product_id" id="product-id" class="form-control" required>
                                <option value="0">Please select</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}" {{ ($errors->has('product_id') ? old('product_id') : $offer->product_id) == $product->id ? 'selected' : ''}} >{{$product->name}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('product_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_id') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{route('offer.index')}}" class="btn btn-info">
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