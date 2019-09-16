@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Meta Tag</div>
                    <div class="panel-body">
                        @include('admin/meta_tags/_form')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection