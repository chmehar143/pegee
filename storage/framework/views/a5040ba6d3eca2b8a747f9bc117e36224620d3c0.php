<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    Filters
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" action="<?php echo e(route('product.index')); ?>">
                    <div class="form-group col-md-3">
                        <select name="category" id="category-id" class="form-control">
                            <option value="">Select Category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(Input::get('category') == $category->id ? 'selected' : ''); ?> ><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group  col-md-3">
                        <input id="product" type="text" class="form-control" name="product"
                               placeholder="Product Name"
                               value="<?php echo e(Input::get('product', '')); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="description" type="text" class="form-control" name="description"
                               placeholder="Description"
                               value="<?php echo e(Input::get('description', '')); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="price" type="text" class="form-control" name="price" placeholder="Price"
                               value="<?php echo e(Input::get('price', '')); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="quantity" type="text" class="form-control" name="quantity" placeholder="Quantity"
                               value="<?php echo e(Input::get('quantity', '')); ?>">
                    </div>


                    <div class="form-group col-md-3">
                        <input id="code" type="text" class="form-control" name="code" placeholder="Code"
                               value="<?php echo e(Input::get('code', '')); ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Product Status</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(Input::get('status') == $key ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select id="outofstock" name="outofstock" class="form-control">
                            <option value="">Please select stock</option>
                            <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abr => $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($abr); ?>" <?php echo e(Input::get('outofstock') == $abr ? 'selected' : ''); ?>><?php echo e($stock); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <select id="samplerequest" name="samplerequest" class="form-control">
                            <option value="">Sample Request</option>
                            <?php $__currentLoopData = $sampleRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abr => $sampleRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($abr); ?>" <?php echo e(Input::get('samplerequest') == $abr ? 'selected' : ''); ?>><?php echo e($sampleRequest); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    <div class="form-group col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            Search
                        </button>
                        <a href="<?php echo e(route('product.index')); ?>" class="btn btn-default">
                            Reset Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>