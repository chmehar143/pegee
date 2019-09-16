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
                            Sample Request Details
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($sample_request)
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $user->first_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ $user->last_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email}}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone No</th>
                                        <td>{{ $user->phone_no}}</td>
                                    </tr>

                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $user->gender == 0 ? 'Male' : 'Female'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Company Name</th>
                                        <td>{{ $sample_request->company}}</td>
                                    </tr>
                                    <tr>
                                        <th>Street Address</th>
                                        <td>
                                            {{ $sample_request->street }}
                                            @if ($sample_request->street2 != NULL) {
                                            <br/>{{$sample_request->street2}}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>City</th>
                                        <td>{{ $sample_request->city }}</td>

                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>{{ $states[$sample_request->state] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Zip/Postal Code</th>
                                        <td>{{ $sample_request->postal_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $countries[$sample_request->country] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ Carbon\Carbon::parse($sample_request->created_at)->format('M d, Y, H:i') }}</td>
                                    </tr>

                                    <tr>
                                        <th>Currently Using?</th>
                                        <td>{{ $sample_request->currently_using ? $sample_request->currently_using : "Not Provided" }}</td>
                                    </tr>
                                    <tr>
                                        <th>Weight</th>
                                        <td>{{ $sample_request->weight ? $weights[$sample_request->weight] : "Not Provided" }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved?</th>
                                        <td>{{ $approved[$sample_request->is_approved] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product # 1</th>
                                        <td>{{ $sample_request->getProduct1->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Product # 2</th>
                                        <td>{{ $sample_request->getProduct2 ? $sample_request->getProduct2->name : ''}}</td>
                                    </tr>


                                </table>

                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Sample Request Found
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a onclick="return confirm('Are you sure')" class="btn btn-primary btn-info {{ $sample_request->is_approved == 1 ? 'disabled' : '' }}" href="{{ route('samples.approve', $sample_request->id) }}" data-toggle="tooltip" title="Approve">
                                    Approve
                                </a>
                                <a href="{{route('samples.index')}}" class="btn btn-info">
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