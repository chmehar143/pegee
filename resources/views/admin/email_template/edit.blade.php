@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit {{$email_template->getHumanizeType()}}</div>
                    <div class="panel-body">
                        <form class="" method="POST"
                              action="{{ route('email_templates.update', ['id' => $email_template->id]) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                                <label for="subject" class="control-label">Subject</label>
                                <input id="subject" type="text" name="subject"
                                       class="form-control"
                                       value="{{ old('subject') ? old('subject') : $email_template->subject}}"/>
                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @foreach($email_template_attributes as $key => $email_template_attribute)
                                <div class="form-group {{ $errors->has('attr_val.'.$key) ? 'has-error' : '' }}">

                                    <label for="attr_val_{{$key}}"
                                           class="control-label">{{$email_template_attribute->getHumanizedKey()}}</label>
                                    <input type="hidden" id="attr_key_{{$key}}" name="attr_key[]"
                                           value="{{$email_template_attribute->attr_key}}"/>
                                    <textarea id="attr_val_{{$key}}" rows="10" name="attr_val[]"
                                              class="form-control">{{ old('attr_val.'.$key) ? old('attr_val.'.$key) : $email_template_attribute->attr_val}}</textarea>
                                    <span>Available variables are: {!! str_replace('"', "", $email_template_attribute->hints) !!}</span>
                                    @if ($errors->has('attr_val.'.$key))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('attr_val.'.$key) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endforeach

                            <div class="form-group">
                                <label for="is_active">Active
                                    <input type="checkbox" id="is_active" name="is_active"
                                           value="1" {{old('is_active') == 1 ? 'checked' : ($email_template->is_active == 1 ? 'checked' : '')}}
                                </label>


                            </div>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <a href="{{route('email_templates.index')}}" class="btn btn-info">
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
        $(document).ready(function () {
            @foreach($email_template_attributes as $key => $email_template_attribute)
            $('#attr_val_{{$key}}').summernote({
                hint: {
                    words: [{!! $email_template_attribute->hints !!}],
                    match: /{%(.*)/,
                    search: function (keyword, callback) {
                        callback($.grep(this.words, function (item) {
                            return item.indexOf(keyword) !== -1;
                        }));
                    }
                },
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
            });
            @endforeach
        });
    </script>
@endsection