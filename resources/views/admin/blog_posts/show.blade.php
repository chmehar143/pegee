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
                            Blog Post Detail
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($blog_post)
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $blog_post->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Blog Category</th>
                                        <td>{{ $blog_post->getBlogCategoryName()}}</td>
                                    </tr>
                                    <tr>
                                        <th>Post Content</th>
                                        <td>{!! $blog_post->post_content !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Author Name</th>
                                        <td>{{$blog_post->author_name}}</td>
                                    </tr>

                                    <tr>
                                        <th>Published?</th>
                                        <td>@if($blog_post->is_published)
                                                <i class="fa fa-check fa-fw"></i>
                                            @else
                                                <i class="fa fa-times fa-fw"></i>
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{Carbon\Carbon::parse($blog_post->created_at)->format('M d, Y, H:i')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{Carbon\Carbon::parse($blog_post->updated_at)->format('M d, Y, H:i')}}</td>
                                    </tr>
                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Blog Post Found
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a class="btn btn-success"
                                   href="{{ route('blog_posts.edit', $blog_post->id) }}"
                                   data-toggle="tooltip" title="Edit">Edit</a>
                                <a href="{{route('blog_posts.index')}}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection