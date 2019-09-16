<?php $__env->startSection('content'); ?>
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
        <?php echo $__env->make('admin/product/_filters', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Products
                            <div>
                                <a class="btn btn-default" href="<?php echo e(route('product.create')); ?>" data-toggle="tooltip"
                                   title="Create">
                                    <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span
                                            class=""> Product</span>
                                </a>
                                <a class="btn btn-default" href="<?php echo e(route('import.form')); ?>" data-toggle="tooltip"
                                   title="Import">
                                    <i class="fa fa-download fa-fw" aria-hidden="true"></i> <span>Import</span><span
                                            class=""> CSV</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <?php if(count($products) > 0): ?>
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Weight</th>
                                        <th>Display on Homepage</th>
                                        <th>Sample Request</th>
                                        <th>Show Video</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td width="100">
                                                <?php if($product->getFeaturedImage()): ?>
                                                <img alt=""
                                                     src="<?php echo e(asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image)); ?>"
                                                     class="img-responsive img-fullwidth">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($product->name); ?></td>
                                            <td><?php echo e($product->price); ?></td>
                                            <td><?php echo e($product->product_quantity); ?></td>
                                            <td><?php echo e($product->product_code); ?></td>
                                            <td><?php echo e($statuses[$product->product_status]); ?></td>
                                            <td><?php echo e($product->weight); ?></td>
                                            <td align="center"><?php echo $product->product_featured == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td align="center"><?php echo $product->sample_product == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td align="center"><?php echo $product->show_video == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="<?php echo e(route('product.show', $product->id)); ?>"
                                                   data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>View</span>
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="<?php echo e(route('product.edit', $product->id)); ?>"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="<?php echo e(route('meta_tags.create', ['resource_id' => $product->id, 'resource_type' => 'product'])); ?>"
                                                   data-toggle="tooltip" title="MetaTags">
                                                    <i class="fa fa-info fa-fw" aria-hidden="true"></i>
                                                    <span>Meta Tags</span>
                                                </a>
                                                <?php if($product->out_of_stock != 2): ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="<?php echo e(route('product.outstock', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-down fa-fw" aria-hidden="true"></i> <span
                                                                class="">Out of Stock</span></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="<?php echo e(route('product.instock', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-up fa-fw" aria-hidden="true"></i> <span
                                                                class="">In Stock</span></span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if($product->sample_product != 2): ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="<?php echo e(route('product.dssample', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-down fa-fw" aria-hidden="true"></i> <span
                                                                class="">Disable Sample Request</span></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="<?php echo e(route('product.ensample', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-up fa-fw" aria-hidden="true"></i> <span
                                                                class="">Enable Sample Request</span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if($product->show_video != 2): ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="<?php echo e(route('product.dsvideo', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-video-camera fa-fw" aria-hidden="true"></i>
                                                        <span class="">Deactivate Video</span></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="<?php echo e(route('product.acvideo', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-video-camera fa-fw" aria-hidden="true"></i>
                                                        <span class="">Activate Video</span></span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if($product->product_status != 1): ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="<?php echo e(route('product.activate', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span
                                                                class="">Activate</span></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-warning btn-block"
                                                       href="<?php echo e(route('product.deactivate', $product->id)); ?>"
                                                       data-toggle="tooltip" title="Deactivate">
                                                        <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span
                                                                class="">Deactivate</span></span>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-sm btn-danger btn-block <?php echo e($product->product_status == 2 ? ' disabled' : ''); ?>"
                                                   href="<?php echo e(route('product.destroy', $product->id)); ?>" onclick="
                                                        event.preventDefault();
                                                        document.getElementById('destroy-form-<?php echo $product->id ?>').submit();"
                                                   data-toggle="tooltip" title="Remove">
                                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span>
                                                </a>
                                                <form id="destroy-form-<?php echo e($product->id); ?>"
                                                      action="<?php echo e(route('product.destroy', $product->id)); ?>"
                                                      method="POST" style="display: none;"
                                                      onsubmit="return confirm('Are you sure')">
                                                    <?php echo e(method_field('DELETE')); ?>

                                                    <?php echo e(csrf_field()); ?>

                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Products Found
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <?php echo e($products->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>