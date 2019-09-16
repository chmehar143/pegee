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
                        Product Feedbacks
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($feedbacks) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Rating</th>
                                    <th>Subject</th>
                                    {{--<th>Product Feedback</th>--}}
                                    <th>Feedback</th>
                                    {{--<th>Is Approved</th>--}}
                                    <th>Feedback By</th>
                                    <th>Display Name</th>
                                    <th>Feedback Product</th>
                                    <th>Feedback Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $rating[$feedback->rating] }}</td>
                                    <td>{{ $feedback->subject }}</td>
{{--                                    <td>{{ $feedback->product_feedback }}</td>--}}
                                    <td>{{ $anonymous[$feedback->is_anonymous] }}</td>
                                    {{--<td>{{ $approved[$feedback->is_approved] }}</td>--}}
                                    <td>{{ $feedback->getUser->first_name }} {{ $feedback->getUser->last_name }}</td>
                                    <td>{{ $feedback->display_name }}</td>
                                    <td>{{ $feedback->getProduct->name }}</td>
                                    <td>{{ Carbon\Carbon::parse($feedback->created_at)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary btn-block" href="{{ route('product_feedback.show', $feedback->id) }}" data-toggle="tooltip" title="Show">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>Show</span>
                                        </a>
                                        <a class="btn btn-sm btn-primary btn-block" href="{{ route('product_feedback.edit', $feedback->id) }}" data-toggle="tooltip" title="Show">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span>
                                        </a>
                                        @if($feedback->is_approved != 2)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('feedback.disapproved', $feedback->id) }}" data-toggle="tooltip" title="Disapproved">
                                            <i class="fa fa-toggle-off fa-fw" aria-hidden="true"></i> <span class="">Disapproved</span></span>
                                        </a>
                                        @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('feedback.approved', $feedback->id) }}" data-toggle="tooltip" title="Approved">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Approved</span></span>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Product Feedbacks Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $feedbacks->links() }}
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
                    <form class="form-horizontal" method="GET" action="{{route('product_feedback.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Rating</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="rating" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($rating as $key => $rat)
                                            <option value="{{ $key }}" {{ Input::get('rating') == $key ? 'selected' : '' }}>{{ $rat }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="product" id="product-id" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" {{ Input::get('product') == $product->id ? 'selected' : '' }} >{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="user" id="user-id" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ Input::get('user') == $user->id ? 'selected' : '' }} >{{$user->first_name  }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Feedback</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="anonymous" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($anonymous as $key => $anon)
                                            <option value="{{ $key }}" {{ Input::get('anonymous') == $key ? 'selected' : '' }}>{{ $anon }}</option>
                                            @endforeach
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Feedback Status</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="status" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($approved as $key => $app)
                                            <option value="{{ $key }}" {{ Input::get('status') == $key ? 'selected' : '' }}>{{ $app }}</option>
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
                            <a href="{{route('product_feedback.index')}}" class="btn btn-default">
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