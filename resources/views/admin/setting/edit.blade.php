@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Slider Image</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('setting.update', ['id' => $settings->id]) }}" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        
                        <div class="form-group">
                            <label for="sample_request" class="control-label">Sample Request in Main Menu</label>
                            <input id="sample_request" type="checkbox" name="sample_request" value="1" {{$settings->sample_request == 1 ? 'checked' : ''}} />

                        </div>
                        


                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{route('setting.index')}}" class="btn btn-info">
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