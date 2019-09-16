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
                        Auto Ships List
                        <a class="btn btn-default" href="{{ route('autoship.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Auto ship</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($autoShips) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Auto Ship Percentage</th>
                                    <th>Product</th>
                                    <th>Auto Ship Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($autoShips as $autoShip)
                                <tr>
                                    <td>{{ $autoShip->autoship_percentage }}%</td>
                                    <td>{{ $autoShip->getActiveShipProduct->name }}</td>
                                    <td>{{ $statuses[$autoShip->autoship_status] }}</td>
                                    <td width="20">
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('autoship.edit', $autoShip->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> Auto Ship</span>
                                        </a>
                                        @if($autoShip->autoship_status != 1)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('autoship.activate', $autoShip->id) }}" data-toggle="tooltip" title="Activate">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span></span>
                                        </a>
                                        @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('autoship.deactivate', $autoShip->id) }}" data-toggle="tooltip" title="Deactivate">
                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span></span>
                                        </a>
                                        @endif
<!--                                        <a href="{{ route('category.destroy', $autoShip->id) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('destroy-form-<?php //echo $autoShip->id ?>').submit();" class="btn btn-sm btn-danger btn-block {{ $autoShip->status == 2 ? ' disabled' : '' }}" data-toggle="tooltip" title="Remove">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Auto Ship</span>
                                        </a>
                                        <form id="destroy-form-{{$autoShip->id}}" action="{{ route('autoship.destroy', $autoShip->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Are you sure')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Auto Ship's Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $autoShips->links() }}
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
                    <form class="form-horizontal" method="GET" action="{{route('autoship.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Auto Ship Percentage</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="percentage" type="text" class="form-control" name="percentage" value="{{ Input::get('percentage', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="product" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ Input::get('product') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Auto Ship Status</th>
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
                            <a href="{{route('autoship.index')}}" class="btn btn-default">
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