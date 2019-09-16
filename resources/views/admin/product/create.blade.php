@extends('layouts.admin')

@section('content')

<?php
$totalSubmitted = 1;
if (old('total_images')) {
    $totalSubmitted = old('total_images');
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Product</div>
                <div class="panel-body">
                    <form id="product-form" class="" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="control-label">Category</label>

                            <select name="category_id" id="category-id" class="form-control" required="" autofocus="">
                                {!! getCategoriesOptions($categories, old('category_id'), "Please select") !!}
                            </select>

                            @if ($errors->has('category_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Product Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="control-label">Product Price</label>

                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" >

                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div id="product_image">
                            @for($i = 0; $i < $totalSubmitted; $i++)
                            <div id="image_append" class="form-group{{ $errors->has('product_picture.'.$i) ? ' has-error' : '' }}">
                                <label for="product_picture" class="control-label">Product Picture</label>

                                <input id="product-picture-1" type="file" class="form-control" name="product_picture[]" >
                                @if ($errors->has('product_picture.'.$i))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_picture.'.$i) }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="radio form-group">
                                <label class="control-label">
                                    <input id="featured-product" type="radio" name="featured_product" value="{{ $i + 1 }}" {{ old('featured_product') == 1 ? 'checked' : '' }} /> <span class="text-primary">Featured Image</span>
                                </label>
                            </div>
                            @endfor
                            <input id="total-images" type="hidden" name="total_images" value="{{ $totalSubmitted }}" />
                        </div>

                        <div class="form-group">
                            <div class="text-left">
                                <button type="button" onclick="add_images()" class="btn btn-primary">
                                    Add More Images
                                </button>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('product_quantity') ? ' has-error' : '' }}">
                            <label for="product_quantity" class="control-label">Product Quantity</label>

                            <input id="product-quantity" type="number" class="form-control" name="product_quantity" value="{{ old('product_quantity') }}" >

                            @if ($errors->has('product_quantity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_quantity') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('product_description') ? ' has-error' : '' }}">
                            <label for="product_description" class="control-label">Product Description</label>

                            <textarea id="product-description" class="form-control" rows="5" name="product_description" >{{ old('product_description') }}</textarea>

                            @if ($errors->has('product_description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                            <label for="short-description" class="control-label">Short Description</label>

                            <textarea id="short-description" class="form-control" rows="5" name="short_description" >{{ old('short_description') }}</textarea>

                            @if ($errors->has('short_description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('short_description') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('out_of_stock') ? ' has-error' : '' }}">
                            <label for="out_of_stock" class="control-label ">Out of Stock</label>

                            <input id="out_of_stock" type="checkbox"  name="out_of_stock" value="2" >

                            @if ($errors->has('out_of_stock'))
                            <span class="help-block">
                                <strong>{{ $errors->first('out_of_stock') }}</strong>
                            </span>
                            @endif
                        </div>

                          <div class="form-group{{ $errors->has('out_of_stock_message') ? ' has-error' : '' }}">
                            <label for="out_of_stock_message" class="control-label">Out of stock Message</label>

                            <input id="out_of_stock_message" type="text" class="form-control" name="out_of_stock_message" value="{{ old('out_of_stock_message') }}"  >

                            @if ($errors->has('out_of_stock_message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('out_of_stock_message') }}</strong>
                            </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('product_height') ? ' has-error' : '' }}">
                            <label for="product-height" class="control-label">Product Height</label>
                            <input id="product-height" type="number" class="form-control" name="product_height" value="{{ old('product_height') }}" >

                            @if ($errors->has('product_height'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_height') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('product_width') ? ' has-error' : '' }}">
                            <label for="product-width" class="control-label">Product Width</label>
                            <input id="product-width" type="number" class="form-control" name="product_width" value="{{ old('product_width') }}" >

                            @if ($errors->has('product_width'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_width') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                            <label for="weight" class="control-label">Weight</label>
                            <input id="weight" type="number" class="form-control" name="weight" value="{{  old('weight') }}" required>

                            @if ($errors->has('weight'))
                                <span class="help-block">
                                <strong>{{ $errors->first('weight') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('product_packaging') ? ' has-error' : '' }}">
                            <label for="product-packaging" class="control-label">Product Packaging</label>

                            <textarea id="product-packaging" class="form-control" rows="5" name="product_packaging" >{{ old('product_packaging') }}</textarea>

                            @if ($errors->has('product_packaging'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_packaging') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
                            <label for="product_code" class="control-label">Product Code</label>
                            <input id="product-code" type="text" class="form-control" name="product_code" value="{{ old('product_code') }}" >

                            @if ($errors->has('product_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_code') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="checkbox form-group">
                            <label class="control-label">
                                <input type="checkbox" name="product_featured" value="1" {{ old('product_featured') == 1 ? 'checked' : '' }} /> <span class="text-primary">Featured Product Show on Homepage</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <a href="{{route('product.index')}}" class="btn btn-info">
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
        $('#product-description').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });

        $('#product-packaging').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });

        $('#short-description').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });

        $('input:radio:first-child').attr('checked', true);
    });

    function add_images() {
        var len = $('#product_image div').length;

        var imageCount = parseInt($('#total-images').val()) + 1;

        $("#product_image").append(
                "<div id='image_append' class='form-group{{ $errors->has('product_picture_input') ? ' has-error' : '' }}'>" +
                "<label for='product_picture' class='control-label'>Product Picture</label>" +
                "<input onclick='readstate()' id='product-picture-" + len + "' type='file' class='form-control' name='product_picture[]' >" +
                "<div class='radio form-group'>" +
                "<label class='control-label'>" +
                "<input type='radio' name='featured_product' value='" + imageCount + "' /> <span class='text-primary'>Featured Image</span>" +
                "</label>" +
                "</div>"
                );
        $('#total-images').val(imageCount);
    }
</script>

@endsection