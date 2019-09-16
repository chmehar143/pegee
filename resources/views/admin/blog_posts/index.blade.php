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
                            Blog Posts
                            <a class="btn btn-default" href="{{ route('blog_posts.create') }}" data-toggle="tooltip"
                               title="Create">
                                <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span
                                        class=""> Blog Post</span>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if(count($blog_posts) > 0)
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Blog Category</th>
                                        <th>Publish Date</th>
                                        <th>Author Name</th>
                                        <th>Published?</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blog_posts as $blog_post)
                                        <tr>
                                            <td>{{$blog_post->name}}</td>
                                            <td>{{$blog_post->getBlogCategoryName()}}</td>
                                            <td>{{Carbon\Carbon::parse($blog_post->publish_date)->format('M d, Y')}}</td>
                                            <td>{{$blog_post->author_name}}</td>
                                            <td>
                                                @if($blog_post->is_published)
                                                    <i class="fa fa-check fa-fw"></i>
                                                @else
                                                    <i class="fa fa-times fa-fw"></i>
                                                @endif
                                            </td>
                                            <td>{{Carbon\Carbon::parse($blog_post->created_at)->format('M d, Y, H:i')}}</td>
                                            <td>{{Carbon\Carbon::parse($blog_post->updated_at)->format('M d, Y, H:i')}}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="{{ route('blog_posts.show', $blog_post->id) }}"
                                                   data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>Show
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('blog_posts.edit', $blog_post->id) }}"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('meta_tags.create', ['resource_id' => $blog_post->id, 'resource_type' => 'blog_post']) }}"
                                                   data-toggle="tooltip" title="MetaTags">
                                                    <span>Meta Tags</span>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Blog Posts Found
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            {{ $blog_posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
            @include('admin/blog_posts/_filter')
        </div>
    </div>

@endsection