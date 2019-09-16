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
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Slider Images List
                        <a class="btn btn-default" href="{{ route('slider.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Slide image</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($sliders) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Slider Image</th>
                                    <th>Slider Link</th>
                                    <th>Alt Text</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td width="300"><img class="img-responsive img-thumbnail" src="{{ asset('uploads/slider/images/'. $slider->slider_image) }}" alt="{{$slider->layer_1}}"></td>
                                    <td>{{ $slider->layer_1 }}</td>
                                    <td>{{ $slider->layer_2 }}</td>
                                    <td width="20">
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('slider.edit', $slider->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> Slider Image</span>
                                        </a>
                                        @if($slider->slider_image_status != 1)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('slider.activate', $slider->id) }}" data-toggle="tooltip" title="Activate">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span>
                                        </a>
                                        @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('slider.deactivate', $slider->id) }}" data-toggle="tooltip" title="Deactivate">
                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span>
                                        </a>
                                        @endif
                                        <a href="{{ route('slider.destroy', $slider->id) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('destroy-form-<?php echo $slider->id ?>').submit();" class="btn btn-sm btn-danger btn-block {{ $slider->slider_image_status == 2 ? ' disabled' : '' }}" data-toggle="tooltip" title="Remove">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Slider Image</span>
                                        </a>
                                        <form id="destroy-form-{{$slider->id}}" action="{{ route('slider.destroy', $slider->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Are you sure')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Slider Image's Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $sliders->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Filters
                    </div>
                </div>
                <div class="panel-body">
                    <form class="" method="GET" action="{{route('slider.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Layer 1</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="layer-one" type="text" class="form-control" name="layerOne" value="{{ Input::get('layerOne', '') }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Layer 2</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="layer-two" type="text" class="form-control" name="layerTwo" value="{{ Input::get('layerTwo', '') }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Layer 3</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="layer-three" type="text" class="form-control" name="layerThree" value="{{ Input::get('layerThree', '') }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Layer 4</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="layer-four" type="text" class="form-control" name="layerFour" value="{{ Input::get('layerFour', '') }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Slider Image Status</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="status" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" {{ Input::get('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <a href="{{route('slider.index')}}" class="btn btn-default">
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection