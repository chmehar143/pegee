<?php $__env->startSection('content'); ?>

<?php
$totalSubmitted = 1;
if (old('total_images')) {
    $totalSubmitted = old('total_images');
}
?>

<div class="container">
    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo e(session('success')); ?>

    </div>
    <?php elseif(session('error')): ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Product</div>
                <div class="panel-body">
                    <form class="" method="POST" action="<?php echo e(route('product.update', ['id' => $product->id] )); ?>" enctype="multipart/form-data">
                        <?php echo e(method_field('PATCH')); ?>

                        <?php echo e(csrf_field()); ?>

                        <input id="fproduct-id" type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                        <div class="form-group<?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
                            <label for="category_id" class="control-label">Category</label>


                            <select name="category_id" id="category-id" class="form-control" required autofocus="">
                                <?php echo getCategoriesOptions($categories, (old('category_id') ? old('category_id') : $product->category_id), "Please select"); ?>

                            </select>

                            <?php if($errors->has('category_id')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('category_id')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>

                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="control-label">Product Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e($errors->has('name') ? old('name') : $product->name); ?>" required >

                            <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('price') ? ' has-error' : ''); ?>">
                            <label for="price" class="control-label">Product Price</label>

                            <input id="price" type="text" class="form-control" name="price" value="<?php echo e($errors->has('price') ? old('price') : $product->price); ?>" required>

                            <?php if($errors->has('price')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('price')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>

                        <?php if($product->getActiveProductImages()->count() > 0): ?>
                        <div class="form-group">
                            <label for="product-picture" class="control-label">Product Pictures</label>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <?php $__currentLoopData = $product->getActiveProductImages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-xs-4 col-sm-3 cols">
                                    <div class="thumbnail">
                                        <img class="" src="<?php echo e(asset('uploads/product/thumbnail/'. $productImage->product_image)); ?>" alt="<?php echo e($product->name); ?>">

                                        <div class="radio form-group">
                                            <label class="control-label">
                                                <input class="featured-image" data-id="<?php echo e($productImage->id); ?>" type="radio" name="featured_product" value="<?php echo e($productImage->image_featured); ?>" <?php echo e($productImage->image_featured == 1 ? 'checked' : ''); ?> /> <span class="text-primary">Featured Image</span>
                                            </label>
                                        </div>

                                        <div class="text-right">
                                            <a data-id="<?php echo e($productImage->id); ?>" href="javascript:void(0)" class="btn btn-xs btn-danger featured-image-del">
                                                Remove Product Image
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div id="product_image">
                            <?php for($i = 0; $i < $totalSubmitted; $i++): ?>
                            <div class="form-group<?php echo e($errors->has('product_picture') ? ' has-error' : ''); ?>">
                                <label for="product-picture" class="control-label">Product Picture</label>

                                <input id="product-picture-1" type="file" class="form-control" name="product_picture[]" >
                                <?php if($errors->has('product_picture.'.$i)): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_picture.'.$i)); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="radio form-group">
                                <label class="control-label">
                                    <input type="radio" name="featured_product" value="<?php echo e($i + 1); ?>" <?php echo e(old('featured_product') == 1 ? 'checked' : ''); ?> /> <span class="text-primary">Featured Image</span>
                                </label>
                            </div>
                            <?php endfor; ?>
                            <input id="total-images" type="hidden" name="total_images" value="<?php echo e($totalSubmitted); ?>" />
                        </div>

                        <div class="form-group">
                            <div class="text-left">
                                <button type="button" onclick="add_images()" class="btn btn-primary">
                                    Add More Images
                                </button>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('product_quantity') ? ' has-error' : ''); ?>">
                            <label for="product_quantity" class="control-label">Product Quantity</label>

                            <input id="product-quantity" type="text" class="form-control" name="product_quantity" value="<?php echo e($errors->has('product_quantity') ? old('product_quantity') : $product->product_quantity); ?>" required>

                            <?php if($errors->has('product_quantity')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_quantity')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>

                        <div class="form-group<?php echo e($errors->has('product_description') ? ' has-error' : ''); ?>">
                            <label for="product_description" class="control-label">Product Description</label>


                            <textarea id="product-description" class="form-control" rows="5" name="product_description"><?php echo e($errors->has('product_description') ? old('product_description') : $product->product_description); ?></textarea>

                            <?php if($errors->has('product_description')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_description')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>
                        
                        <div class="form-group<?php echo e($errors->has('short_description') ? ' has-error' : ''); ?>">
                            <label for="short-description" class="control-label">Short Description</label>


                            <textarea id="short-description" class="form-control" rows="5" name="short_description"><?php echo e($errors->has('short_description') ? old('short_description') : $product->short_description); ?></textarea>

                            <?php if($errors->has('short_description')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('short_description')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>

                        <div class="form-group<?php echo e($errors->has('out_of_stock') ? ' has-error' : ''); ?>">
                            <label for="out_of_stock_message" class="control-label">Out of stock</label>

                            <input id="out_of_stock" type="checkbox"  name="out_of_stock" value="2" <?php if($product->out_of_stock==2){echo "checked";} ?> >

                            <?php if($errors->has('out_of_stock')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('out_of_stock')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('out_of_stock_message') ? ' has-error' : ''); ?>">
                            <label for="out_of_stock_message" class="control-label">Out of stock Message</label>

                            <input id="out_of_stock_message" type="text" class="form-control" name="out_of_stock_message" value="<?php echo e($errors->has('out_of_stock_message') ? old('out_of_stock_message') : $product->out_of_stock_message); ?>"  >

                            <?php if($errors->has('out_of_stock_message')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('out_of_stock_message')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('product_height') ? ' has-error' : ''); ?>">
                            <label for="product-height" class="control-label">Product Height</label>
                            <input id="product-height" type="number" class="form-control" name="product_height" value="<?php echo e($errors->has('product_height') ? old('product_height') : $product->product_height); ?>" required>

                            <?php if($errors->has('product_height')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_height')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('product_width') ? ' has-error' : ''); ?>">
                            <label for="product-width" class="control-label">Product Width</label>
                            <input id="product-width" type="number" class="form-control" name="product_width" value="<?php echo e($errors->has('product_width') ? old('product_width') : $product->product_width); ?>" required>

                            <?php if($errors->has('product_width')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_width')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('weight') ? ' has-error' : ''); ?>">
                            <label for="weight" class="control-label">Weight</label>
                            <input id="weight" type="number" class="form-control" name="weight" value="<?php echo e($errors->has('weight') ? old('weight') : $product->weight); ?>" required>

                            <?php if($errors->has('weight')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('weight')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('product_packaging') ? ' has-error' : ''); ?>">
                            <label for="product-packaging" class="control-label">Product Packaging</label>

                            <textarea id="product-packaging" class="form-control" rows="5" name="product_packaging" required><?php echo e($errors->has('product_packaging') ? old('product_packaging') : $product->product_packaging); ?></textarea>

                            <?php if($errors->has('product_packaging')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_packaging')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group<?php echo e($errors->has('product_code') ? ' has-error' : ''); ?>">
                            <label for="product_code" class="control-label">Product Code</label>

                            <input id="product-code" type="text" class="form-control" name="product_code" value="<?php echo e($errors->has('product_code') ? old('product_code') : $product->product_code); ?>" required>

                            <?php if($errors->has('product_code')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('product_code')); ?></strong>
                            </span>
                            <?php endif; ?>

                        </div>

                        <div class="checkbox form-group">
                            <label class="control-label">
                                <input type="checkbox" name="product_featured" value="1" <?php echo e($product->product_featured == 1  ? 'checked' : ''); ?> /> <span class="text-primary">Featured Product Show on Homepage</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="<?php echo e(route('product.index')); ?>" class="btn btn-info">
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
        
        $('#short-description').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });

        $('#product-packaging').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });
    });

    function add_images() {
        var len = $('#product_image div').length;

        var imageCount = parseInt($('#total-images').val()) + 1;

        $("#product_image").append(
                "<div id='image_append' class='form-group<?php echo e($errors->has('product_picture_input') ? ' has-error' : ''); ?>'>" +
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

    (function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.featured-image').on('change', function () {
            var id = $(this).attr('data-id');
            var featureImage = $(this).val();
            var product_id = parseInt($('#fproduct-id').val());
            if (parseInt(featureImage) == 0) {
                console.log(featureImage);
                featureImage = parseInt(1);
            }
            $.ajax({
                type: "PATCH",
                url: '<?php echo e(url("admin/product/feature")); ?>' + '/' + id,
                data: {
                    'featureImage': featureImage,
                },
                success: function (data) {
                    var url = '<?php echo e(route("product.edit", ":product_id")); ?>';
                    url = url.replace(':product_id', product_id)
                    window.location.href = url;
                }
            });

        });

        $('.featured-image-del').on('click', function () {
            var id = $(this).attr('data-id');
            var product_id = parseInt($('#fproduct-id').val());
            console.log(id);
            console.log(product_id);
            $.ajax({
                type: "DELETE",
                url: '<?php echo e(url("admin/product/image")); ?>' + '/' + id,
                data: {
                    'featureImage': product_id,
                },
                success: function (data) {
                    var url = '<?php echo e(route("product.edit", ":product_id")); ?>';
                    url = url.replace(':product_id', product_id)
                    window.location.href = url;
                }
            });

        });

    })();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>