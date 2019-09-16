@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Slider Image</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('slider.update', ['id' => $slider->id]) }}" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('slider_image') ? ' has-error' : '' }}">
                            <label for="slider-image" class="control-label">Slider Image</label>

                            <input id="slider-image" type="file" class="form-control" name="slider_image" />

                            @if ($errors->has('slider_image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slider_image') }}</strong>
                            </span>
                            @endif

                        </div>
                        
                        @if($slider->slider_image != "")
                        <div class="form-group">
                            <label for="slider-image" class="control-label">Slider Image</label>

                            <img class="img-responsive img-thumbnail" src="{{ asset('uploads/slider/images/'. $slider->slider_image) }}" alt="{{$slider->layer_1}}">

                        </div>
                        @endif

                        <div class="form-group{{ $errors->has('layer_1') ? ' has-error' : '' }}">
                            <label for="layer-1" class="control-label">Slider Link</label>

                            <input id="layer-1" type="text" class="form-control" name="layer_1" value="{{ $errors->has('layer_1') ? old('layer_1') : $slider->layer_1 }}" />

                            @if ($errors->has('layer_1'))
                            <span class="help-block">
                                <strong>{{ $errors->first('layer_1') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('layer_2') ? ' has-error' : '' }}">
                            <label for="layer-2" class="control-label">Alt Text</label>

                            <input id="layer-2" type="text" class="form-control" name="layer_2" value="{{ $errors->has('layer_2') ? old('layer_2') : $slider->layer_2 }}" />

                            @if ($errors->has('layer_2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('layer_2') }}</strong>
                            </span>
                            @endif

                        </div>

                        {{--<div class="form-group{{ $errors->has('layer_3') ? ' has-error' : '' }}">--}}
                            {{--<label for="layer-3" class="control-label">Layer 3</label>--}}

                            {{--<input id="layer-3" type="text" class="form-control" name="layer_3" value="{{ $errors->has('layer_3') ? old('layer_3') : $slider->layer_3 }}" />--}}

                            {{--@if ($errors->has('layer_3'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('layer_3') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}
                        {{----}}
                        {{--<div class="form-group{{ $errors->has('layer_4') ? ' has-error' : '' }}">--}}
                            {{--<label for="layer-4" class="control-label">Layer 4 (Button Text)</label>--}}

                            {{--<input id="layer-4" type="text" class="form-control" name="layer_4" value="{{ $errors->has('layer_4') ? old('layer_4') : $slider->layer_4 }}" />--}}

                            {{--@if ($errors->has('layer_4'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('layer_4') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
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