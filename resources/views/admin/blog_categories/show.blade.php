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
                            Blog Category Detail
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($blog_category)
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $blog_category->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{Carbon\Carbon::parse($blog_category->created_at)->format('M d, Y, H:i')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{Carbon\Carbon::parse($blog_category->updated_at)->format('M d, Y, H:i')}}</td>
                                    </tr>



                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Blog Category Found
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a class="btn btn-success"
                                   href="{{ route('blog_categories.edit', $blog_category->id) }}"
                                   data-toggle="tooltip" title="Edit">Edit</a>
                                <a href="{{route('blog_categories.index')}}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection