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
                            Blog Categories
                            <a class="btn btn-default" href="{{ route('blog_categories.create') }}" data-toggle="tooltip"
                               title="Create">
                                <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span
                                        class=""> Blog Category</span>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($blog_categories->count() > 0)
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blog_categories as $blog_category)
                                        <tr>
                                            <td>{{$blog_category->name}}</td>
                                            <td>{{Carbon\Carbon::parse($blog_category->created_at)->format('M d, Y, H:i')}}</td>
                                            <td>{{Carbon\Carbon::parse($blog_category->updated_at)->format('M d, Y, H:i')}}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="{{ route('blog_categories.show', $blog_category->id) }}"
                                                   data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>Show
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('blog_categories.edit', $blog_category->id) }}"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Blog Categories Found
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection