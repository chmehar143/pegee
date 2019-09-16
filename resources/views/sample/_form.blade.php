<form id="sample-request" action="{{ route('request.sample') }}" method="POST">
    {{ csrf_field() }}
    <div class="col-md-12">
        <h3 class="mb-30">Sample Request</h3>
        <div class="row">
            <div class="form-group col-md-6{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <input id="first-name" name="first_name"
                       {{Auth::check()? 'readonly' : ""}} value="{{ old('first_name') ? old('first_name') : (Auth::check() ? Auth::user()->first_name : '') }}"
                       class="form-control" type="text" placeholder="First Name" autofocus>
                @if ($errors->has('first_name'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-6{{ $errors->has('last_name') ? ' has-error' : '' }}">
                <input id="last-name" name="last_name"
                       {{Auth::check()? 'readonly' : ""}} value="{{ old('last_name') ? old('last_name') : (Auth::check() ? Auth::user()->last_name : '') }}"
                       class="form-control" type="text" placeholder="Last Name">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-12{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" name="email"
                       {{Auth::check()? 'readonly' : ""}} value="{{ old('email') ? old('email') : (Auth::check() ? Auth::user()->email : '') }}"
                       class="form-control"
                       type="email" placeholder="Enter Email">
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            @if(!Auth::check())
                <div class="form-group col-md-6{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" name="password" class="form-control" type="password"
                           placeholder="Enter Password">
                    @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <input id="password_confirmation" name="password_confirmation"
                           class="form-control" type="password" placeholder="Re-Enter Password">
                    @if ($errors->has('password'))
                        <span class="help-block"><strong>&nbsp;</strong></span>
                    @endif
                </div>
            @endif

            <div class="form-group col-md-6{{ $errors->has('phone_no') ? ' has-error' : '' }}">
                <input id="phone-no" name="phone_no"
                       value="{{ old('phone_no') ? old('phone_no') : (Auth::check() ? Auth::user()->phone_no : '') }}"
                       class="form-control" type="text" placeholder="Enter Phone No">

                @if ($errors->has('phone_no'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-6{{ $errors->has('gender') ? ' has-error' : '' }}">
                <input id="gender-male" type="radio" class="gender_class" name="gender" {{Auth::check()? 'disabled' : ""}}
                value="0" {{ old('gender') == 0 ? 'checked' : (Auth::check() && Auth::user()->gender == 0 ? 'checked' : '')  }} />Male<br/>
                <input id="gender-female" type="radio" class="gender_class" name="gender"
                       value="1" {{Auth::check()? 'disabled' : ""}} {{ old('gender') == 1 ? 'checked' : (Auth::check() && Auth::user()->gender == 1 ? 'checked' : '')  }} />Female
                @if ($errors->has('gender'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-12{{ $errors->has('company') ? ' has-error' : '' }}">
                <input id="company" type="text" class="form-control" placeholder="Company Name"
                       name="company" value="{{ old('company') }}"/>
                @if ($errors->has('company'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                @endif
                <label for="dont's" class="control-label text-warning">
                    <small>Optional</small>
                </label>
            </div>

            <div class="form-group col-md-12{{ $errors->has('street') ? ' has-error' : '' }}">
                <input id="street" type="text" class="form-control" placeholder="Street address"
                       name="street" value="{{ old('street') }}"/>
                @if ($errors->has('street'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('street') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-12">
                <input id="street_2" type="text" class="form-control"
                       placeholder="Apartment, suite, unit etc. (optional)" name="street_2"
                       value="{{ old('street_2') }}"/>
            </div>

            <div class="form-group col-md-6{{ $errors->has('city') ? ' has-error' : '' }}">
                <input id="city" type="text" class="form-control" placeholder="City" name="city"
                       value="{{ old('city') }}"/>
                @if ($errors->has('city'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-6{{ $errors->has('state') ? ' has-error' : '' }}">
                <select name="state" id="state" class="form-control">
                    @if(count($states) > 0)
                        <option value="0">{{"Select State"}}</option>
                        @foreach($states as $abr=>$state)
                            <option value="{{$abr}}" {{old('state') == $abr ? 'selected' : ''}} >{{$state}}</option>
                        @endforeach
                    @else
                        <option value="">{{"No State Found"}}</option>
                    @endif
                </select>

                @if ($errors->has('state'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-6{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                <input id="postal_code" type="text" class="form-control"
                       placeholder="Zip/Postal Code" name="postal_code"
                       value="{{ old('postal_code') }}"/>

                @if ($errors->has('postal_code'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('postal_code') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-6{{ $errors->has('country') ? ' has-error' : '' }}">
                <select name="country" id="country" class="form-control">
                    @if(count($countries) > 0)
                        <option value="0">{{"Select Country"}}</option>
                        @foreach($countries as $abr => $country)
                            <option value="{{$abr}}" {{old('country') == $abr ? 'selected' : ''}} >{{ $country }}</option>
                        @endforeach
                    @else
                        <option value="">{{"No Country Found"}}</option>
                    @endif
                </select>

                @if ($errors->has('country'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group col-md-12{{ $errors->has('currently_using') ? ' has-error' : '' }}">
                <input id="currently-using" type="text" class="form-control"
                       placeholder="What brand are you currently using?" name="currently_using"
                       value="{{ old('currently_using') }}"/>
                @if ($errors->has('currently_using'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('currently_using') }}</strong>
                                </span>
                @endif
                <label for="dont's" class="control-label text-warning">
                    <small>Optional</small>
                </label>
            </div>

            <div class="form-group col-md-12">
                <label> <a href="javascript:void(0);" class="" id="pad-select"
                           data-toggle="modal" data-target="#modal-window-choose"> How do I know
                        which pad to select? </a></label>
            </div>

            <div class="form-group col-md-6{{ $errors->has('product1') ? ' has-error' : '' }}">
                <select name="product1" id="product" class="form-control">
                    @if(count($products) > 0)
                        <option value="">{{"Select Product"}}</option>
                        @foreach($products as $product)
                            <?php
                            $string = $product->name;
                            $patterns = array();
                            $patterns[0] = '/ *\([^)]*\) */';
                            $replacements = array();
                            $replacements[0] = '';
                            $replacements[1] = '';
                            $string1 = preg_replace($patterns, $replacements, $string);
                            ?>
                            <option value="{{ $product->id }}" {{old('product2') == $product->id ? 'selected' : ($product->slug == $selected_product ? 'selected' : '') }} >{{ str_replace('()', '', $string1) }}</option>
                        @endforeach
                    @else
                        <option value="">{{"No product available"}}</option>
                    @endif
                </select>

                @if ($errors->has('product1'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('product1') }}</strong>
                                </span>
                @endif
            </div>

            @if(count($products) > 1)
                <div class="form-group col-md-6{{ $errors->has('product2') ? ' has-error' : '' }}">
                    <select name="product2" id="product2" class="form-control">
                        <option value="">{{"Select 2nd Product"}}</option>
                    </select>
                    @if ($errors->has('product2'))
                        <span class="help-block"><strong>{{ $errors->first('product2') }}</strong></span>
                    @endif
                </div>
            @endif

            <div class="form-group col-md-12">
                <label class="text-danger"> <span>NOTE: You will get only 1 Pad for each Products</span>
                </label>
            </div>

            <div class="form-group col-md-12{{ $errors->has('weight') ? ' has-error' : '' }}">
                <select name="weight" id="weight" class="form-control">
                    @if(count($weights) > 0)
                        <option value="">{{"Select Dog Weight"}}</option>
                        @foreach($weights as $abr => $weight)
                            <option value="{{$abr}}" {{old('weight') == $abr ? 'selected' : ''}} >{{ $weight }}</option>
                        @endforeach
                    @else
                        <option value="">{{"No Weight Found"}}</option>
                    @endif
                </select>

                @if ($errors->has('weight'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                @endif
                <label for="dont's" class="control-label text-warning">
                    <small>Optional</small>
                </label>
            </div>
        </div>
        <div class="form-group text-center">
            <input name="form_botcheck" class="form-control" type="hidden" value=""/>
            <button type="submit" class="btn btn-theme-colored btn-sm mt-0 font-16"
                    data-loading-text="Please wait...">Request
            </button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#product").on('change', function () {
            var options = $(this).find('option');
            var html_options = '<option value="">Select 2nd Product</option>';
            var selected_option = $(this).val();
            if (selected_option != '') {
                $.each(options, function (index, element) {
                    if ($(element).val() != '' && selected_option != $(element).val()) {
                        html_options += '<option value="' + $(element).val() + '">' + $(element).text() + '</option>';
                    }
                });
            }
            $("#product2").html(html_options);
        });
        $("#product").trigger('change');
    });
</script>