@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Blog Category</div>
                    <div class="panel-body">
                        @include('admin/blog_categories/_form', ['blog_category' => $blog_category])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection