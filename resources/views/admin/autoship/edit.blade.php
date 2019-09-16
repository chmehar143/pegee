@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Category</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('autoship.update', ['id' => $autoShip->id]) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('autoship_percentage') ? ' has-error' : '' }}">
                            <label for="autoship_percentage" class="control-label">Auto Ship Percentage</label>

                            <input id="autoship_percentage" type="text" class="form-control" name="autoship_percentage" value="{{ $errors->has('autoship_percentage') ? old('naautoship_percentageme') : $autoShip->autoship_percentage }}" required autofocus>

                            @if ($errors->has('autoship_percentage'))
                            <span class="help-block">
                                <strong>{{ $errors->first('autoship_percentage') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                            <label for="product" class="control-label">Select Product</label>

                            <select name="product" id="product" class="form-control">
                                <option value="">Please select</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}" {{ ($errors->has('product') ? old('product') : $autoShip->product_id) == $product->id ? 'selected' : ''}} >{{$product->name}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('product'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{route('autoship.index')}}" class="btn btn-info">
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

@endsection