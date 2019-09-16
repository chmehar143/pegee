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
                        Samples List
                    </div>
                </div>

                <div class="panel-body">
                    <div class="table-responsive users-table">
                        @if(count($samples) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                    <th>Is Approved</th>
                                    <th>Product#1</th>
                                    <th>Product#2</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($samples as $sample)
                                <tr>
                                    <td>{{ $sample->getUser->first_name }}</td>
                                    <td>{{ $sample->getUser->last_name }}</td>
                                    <td>{{ $sample->company }}</td>
                                    <td>{{ $sample->getFullAddress() }}</td>
                                    <td>{{ Carbon\Carbon::parse($sample->created_at)->format('M d, Y, H:i') }}</td>
                                    <td>{{ $approved[$sample->is_approved] }}</td>
                                    <td>{{ $sample->getProduct1->name }}</td>
                                    <td>{{ $sample->getProduct2 ? $sample->getProduct2->name : ''}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary btn-block" href="{{ route('samples.show', $sample->id) }}" data-toggle="tooltip" title="Show">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="">Show</span>
                                        </a>
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block<?php echo $sample->is_approved == 1 ? ' disabled' : ''; ?>" href="{{ route('samples.approve', $sample->id) }}" data-toggle="tooltip" title="Approve">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Approve</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Samples Request Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $samples->links() }}
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
                    <form class="form-horizontal" method="GET" action="{{route('samples.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Product Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="product" id="product-id" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" {{ Input::get('product') == $product->id ? 'selected' : '' }} >{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dog Weight</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="weight" id="weight" class="form-control" >
                                            <option value="">Please select weight</option>
                                            @foreach($weights as $abr =>$weight)
                                            <option value="{{ $abr }}" {{ Input::get('weight') == $abr ? 'selected' : '' }} >{{ $weight }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Is Approved</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="approved" id="approved" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($approved as $abr =>$approved)
                                            <option value="{{ $abr }}" {{ Input::get('approved') == $abr ? 'selected' : '' }} >{{ $approved }}</option>
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
                            <a href="{{route('samples.index')}}" class="btn btn-default">
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