@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Product Feedback</div>
                    <div class="panel-body">
                        <form class="" method="POST"
                              action="{{ route('product_feedback.update', ['id' => $feedback->id]) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
                                <label for="rating" class="control-label">Rating</label>
                                <select id="rating" name="rating" class="form-control">
                                    <option value="1" {{ $feedback->rating == 1 ? 'selected' : '' }}>1 Star</option>
                                    <option value="2" {{ $feedback->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="3" {{ $feedback->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="4" {{ $feedback->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="5" {{ $feedback->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                </select>
                                @if ($errors->has('rating'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('rating') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="subject" class="control-label">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control"
                                       value="{{ old('subject') ? old('subject') : ($feedback->subject ? $feedback->subject : '')}}"/>
                                @if ($errors->has('subject'))
                                    <span class="help-block"><strong>{{ $errors->first('subject') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('product_feedback') ? ' has-error' : '' }}">
                                <label for="product_feedback" class="control-label">Subject</label>
                                <textarea id="product_feedback" name="product_feedback" class="form-control" row="12">{{ old('product_feedback') ? old('product_feedback') : ($feedback->product_feedback ? $feedback->product_feedback : '')}}</textarea>
                                @if ($errors->has('product_feedback'))
                                    <span class="help-block"><strong>{{ $errors->first('product_feedback') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('review_date') ? ' has-error' : '' }}">
                                <label for="review_date" class="control-label">Review date</label>
                                <input type="text" id="review_date" name="review_date" class="form-control datepicker" value="{{ old('review_date') ? old('review_date') : ($feedback->review_date ? date("Y-m-d", strtotime($feedback->review_date)) : '')}}" />
                                @if ($errors->has('review_date'))
                                    <span class="help-block"><strong>{{ $errors->first('review_date') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                <label for="user_id" class="control-label">User / Reviewed by</label>
                                <select id="user_id" name="user_id" class="form-control">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}" {{old('user_id') == $user->id ? 'selected' : ($feedback->user_id == $user->id ? 'selected' : '')}}>{{$user->first_name}} {{$user->last_name}} ({{$user->email}})</option>
                                        @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                    <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                                <label for="display_name" class="control-label">Display Name</label>
                                <input type="text" id="display_name" name="display_name" class="form-control" value="{{ old('display_name') ? old('display_name') : ($feedback->display_name ? $feedback->display_name : '')}}"/>
                                @if ($errors->has('display_name'))
                                    <span class="help-block"><strong>{{ $errors->first('display_name') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                                <label for="product_id" class="control-label">Product</label>
                                <select id="product_id" name="product_id" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" {{old('product_id') == $product->id ? 'selected' : ($feedback->product_id == $product->id ? 'selected' : '')}}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <span class="help-block"><strong>{{ $errors->first('product_id') }}</strong></span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="is_anonymous" class="control-label">Anonymous?</label>
                                <input type="checkbox" id="is_anonymous" name="is_anonymous" {{old('is_anonymous') && old('is_anonymous') == 1 ? 'checked' : ($feedback->is_anonymous == 1 ? 'checked' : '')  }} value="1" />
                            </div>

                            <div class="form-group">
                                <label for="is_approved" class="control-label">Approved?</label>
                                <input type="checkbox" id="is_approved" name="is_approved" {{old('is_approved') && old('is_approved') == 1 ? 'checked' : ($feedback->is_approved == 1 ? 'checked' : '')  }} value="1" />
                            </div>




                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <a href="{{route('product_feedback.show', $feedback->order_id)}}"
                                       class="btn btn-info">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
          $(".datepicker").datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd',
              todayHighlight: true
          });
        });
    </script>

@endsection