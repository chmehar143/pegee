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
                        Static Pages List
                        <a class="btn btn-default" href="{{ route('static_page.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Static page</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($static_pages) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Page Name</th>
                                    <th>Pages Description</th>
                                    <th>Page Status</th>
                                    <th>Page Show On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($static_pages as $static_page)
                                <tr>
                                    <td>{{$static_page->page_name }}</td>
                                    <td>
                                        <?php
                                        $string = strip_tags($static_page->page_description);

                                        if (strlen($string) > 400) {

                                            // truncate string
                                            $stringCut = substr($string, 0, 400);

                                            // make sure it ends in a word so assassinate doesn't become ass...
                                            $string = substr($stringCut, 0, strrpos($stringCut, ' '));
                                        }
                                        ?>
                                        {{ strip_tags($string) }}
                                    </td>
                                    <td>{{ $statuses[$static_page->page_status] }}</td>
                                    <td>{{ $show_pages[$static_page->page_show] }}</td>
                                    <td width="20">
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('static_page.edit', $static_page->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> Page</span>
                                        </a>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('meta_tags.create', ['resource_id' => $static_page->id, 'resource_type' => 'static-page']) }}" data-toggle="tooltip" title="MetaTags">
                                            <i class="fa fa-info fa-fw" aria-hidden="true"></i> <span>Meta Tags</span>
                                        </a>
                                    @if($static_page->page_status != 1)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('page.activate', $static_page->id) }}" data-toggle="tooltip" title="Activate">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span></span>
                                        </a>
                                    @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('page.deactivate', $static_page->id) }}" data-toggle="tooltip" title="Deaactivate">
                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span></span>
                                        </a>
                                    @endif
                                        <a href="{{ route('static_page.destroy', $static_page->id) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('destroy-form-<?php echo $static_page->id ?>').submit();" class="btn btn-sm btn-danger btn-block {{ $static_page->page_status == 2 ? ' disabled' : '' }}" data-toggle="tooltip" title="Remove">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Page</span>
                                        </a>
                                        <form id="destroy-form-{{$static_page->id}}" action="{{ route('static_page.destroy', $static_page->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Are you sure')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Static Page's Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $static_pages->links() }}
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
                    <form class="" method="GET" action="{{route('static_page.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Static Pages Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="page-name" type="text" class="form-control" name="name" value="{{ Input::get('name', '') }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Page Show On</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="show" id="page_show" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($show_pages as $key => $show_page)
                                            <option value="{{ $key }}" {{ Input::get('show') == $key ? 'selected' : ''}} >{{ $show_page }}</option>
                                            @endforeach
                                        </select>  
                                    </td>
                                </tr>
                                <tr>
                                    <th>Static Page Status</th>
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
                            <a href="{{route('static_page.index')}}" class="btn btn-default">
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