@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Blog Post</div>
                    <div class="panel-body">
                        @include('admin/blog_posts/_form', ['blog_post' => $blog_post])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection