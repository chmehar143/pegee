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
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Meta Tag Detail
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($meta_tag)
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $meta_tag->getName()}}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $meta_tag->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{$meta_tag->description}}</td>
                                    </tr>
                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Meta Tag Found
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a class="btn btn-success"
                                   href="{{ route('meta_tags.edit', $meta_tag->id) }}"
                                   data-toggle="tooltip" title="Edit">Edit</a>
                                <a href="{{route('meta_tags.index')}}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection