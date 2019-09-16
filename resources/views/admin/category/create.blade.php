@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Category</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('category.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ $errors->has('name') ? old('name') : "" }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group {{ $errors->has('weight') ? ' has-error' : '' }}">
                            <label for="weight" class="control-label">Weight</label>

                            <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') ? old('weight') : $default_weight  }}"/>
                            @if ($errors->has('weight'))
                                <span class="help-block">
                                <strong>{{ $errors->first('weight') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="control-label">Parent Category</label>

                            <select name="parent_id" id="parent-id" class="form-control">
                                {!! getCategoriesOptions($categories, old('parent_id'), "Please select") !!}
                            </select>

                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <a href="{{route('category.index')}}" class="btn btn-info">
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