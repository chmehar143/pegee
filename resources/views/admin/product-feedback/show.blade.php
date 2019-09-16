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
                        Product Feedback
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if($feedback)
                        <table class="table table-striped table-condensed data-table">
                            <tr>
                                <th>Rating</th>
                                <td>{{ $rating[$feedback->rating] }}</td>
                            </tr>
                            <tr>
                                <th>Feedback Subject</th>
                                <td>{{ $feedback->subject }}</td>
                            </tr>
                            <tr>
                                <th>Product Feedback</th>
                                <td>{{ $feedback->product_feedback }}</td>
                            </tr>

                            <tr>
                                <th>Feedback As</th>
                                <td>{{ $anonymous[$feedback->is_anonymous] }}</td>
                            </tr>
                            <tr>
                                <th>Is Approved</th>
                                <td>{{ $approved[$feedback->is_approved] }}</td>
                            </tr>
                            <tr>
                                <th>Feedback By</th>
                                <td>{{ $feedback->getUser->getName() }}</td>
                            </tr>
                            <tr>
                                <th>Display Name</th>
                                <td>{{ $feedback->display_name }}</td>
                            </tr>
                            <tr>
                                <th>Feedback Product</th>
                                <td>{{ $feedback->getProduct->name }}</td>
                            </tr>
                            <tr>
                                <th>Feedback Date</th>
                                <td>{{ Carbon\Carbon::parse($feedback->created_at)->format('Y-m-d') }}</td>
                            </tr>
                        </table>

                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Product Feedback Found
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{route('product_feedback.edit', $feedback->id)}}" class="btn btn-info">
                                Edit
                            </a>
                            <a href="{{route('product_feedback.index')}}" class="btn btn-info">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection