@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Import Excel</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('import.file') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('csv_excel') ? ' has-error' : '' }}">
                            <label for="csv-excel" class="col-md-4 control-label">CSV File</label>

                            <div class="col-md-6">
                                <input id="csv-excel" type="file" class="form-control" name="csv_excel" required>
                                <small>NOTE: Import only CSV File</small>
                                @if ($errors->has('csv_excel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('csv_excel') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Import
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection