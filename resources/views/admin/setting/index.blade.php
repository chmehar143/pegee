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
                            Settings

                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th>Sample Request in Main Menu</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                @if($settings->sample_request)
                                                    <i class="fa fa-check fa-fw"></i>
                                                    @else
                                                    <i class="fa fa-times fa-fw"></i>
                                                    @endif

                                                </td>
                                            <td width="20">
                                                <a class="btn btn-sm btn-success btn-block" href="{{ route('setting.edit', $settings->id) }}" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit Settings</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection