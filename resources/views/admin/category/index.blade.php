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
                        Categories List
                        <a class="btn btn-default" href="{{ route('category.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Category</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($categories) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Weight</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {!! getCategoriesView($categories) !!}
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Categories Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Filters
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="GET" action="{{route('category.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Parent Category</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="category" id="category-id" class="form-control" >
                                            {!! getCategoriesOptions($categories_select, Input::get('category'), "Please select") !!}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ Input::get('name', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category Status</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="status" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" {{ Input::get('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <a href="{{route('category.index')}}" class="btn btn-default">
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection