@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Slider Image</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('slider_image') ? ' has-error' : '' }}">
                            <label for="slider-image" class="control-label">Slider Image</label>

                            <input id="slider-image" type="file" class="form-control" name="slider_image" value="{{ old('slider_image') }}" required autofocus>

                            @if ($errors->has('slider_image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slider_image') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('layer_1') ? ' has-error' : '' }}">
                            <label for="layer-1" class="control-label">Slider Link</label>

                            <input id="layer-1" type="text" class="form-control" name="layer_1" value="{{ old('layer_1') }}" />

                            @if ($errors->has('layer_1'))
                            <span class="help-block">
                                <strong>{{ $errors->first('layer_1') }}</strong>
                            </span>
                            @endif

                        </div>
                        
                        {{--<div class="form-group{{ $errors->has('layer_2') ? ' has-error' : '' }}">--}}
                            {{--<label for="layer-2" class="control-label">Layer 2</label>--}}

                            {{--<input id="layer-2" type="text" class="form-control" name="layer_2" value="{{ old('layer_2') }}" />--}}

                            {{--@if ($errors->has('layer_2'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('layer_2') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}
                        {{----}}
                        {{--<div class="form-group{{ $errors->has('layer_3') ? ' has-error' : '' }}">--}}
                            {{--<label for="layer-3" class="control-label">Layer 3</label>--}}

                            {{--<input id="layer-3" type="text" class="form-control" name="layer_3" value="{{ old('layer_3') }}" />--}}

                            {{--@if ($errors->has('layer_3'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('layer_3') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}
                        {{----}}
                        {{--<div class="form-group{{ $errors->has('layer_4') ? ' has-error' : '' }}">--}}
                            {{--<label for="layer-4" class="control-label">Layer 4 (Button Text)</label>--}}

                            {{--<input id="layer-4" type="text" class="form-control" name="layer_4" value="{{ old('layer_4') }}" />--}}

                            {{--@if ($errors->has('layer_4'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('layer_4') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <a href="{{route('slider.index')}}" class="btn btn-info">
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