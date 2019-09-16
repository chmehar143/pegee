@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Static Page</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('static_page.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('page_name') ? ' has-error' : '' }}">
                            <label for="page-name" class="control-label">Page Name</label>

                            <input id="page-name" type="text" class="form-control" name="page_name" value="{{ old('page_name') }}" required autofocus>

                            @if ($errors->has('page_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('page_name') }}</strong>
                            </span>
                            @endif

                        </div>
                        
                        <div class="form-group{{ $errors->has('page_show') ? ' has-error' : '' }}">
                            <label for="page_show" class="control-label">Page Show On</label>

                            <select name="page_show" id="page_show" class="form-control" >
                                <option value="0">Please select</option>
                                @foreach($show_pages as $key => $show_page)
                                <option value="{{$key}}" {{old('page_show') == $key ? 'selected' : ''}} >{{$show_page}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('page_show'))
                            <span class="help-block">
                                <strong>{{ $errors->first('page_show') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('page_description') ? ' has-error' : '' }}">
                            <label for="page-description" class="control-label">Page Description</label>

                            <textarea id="page-description" class="form-control" rows="5" name="page_description">{{ old('page_description') }}</textarea>

                            @if ($errors->has('page_description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('page_description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <a href="{{route('static_page.index')}}" class="btn btn-info">
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
    $(document).ready(function () {
        $('#page-description').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });
    });
</script>

@endsection