
<?php $__env->startSection('script_top'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo $baseURL . 'assets/bower_components/gantt/css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo e(getBaseURL()); ?>frequent_changing/css/pdf_common.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Optional theme -->
    <input type="hidden" id="edit_mode" value="<?php echo e(isset($obj) && $obj ? $obj->id : null); ?>">
    <section class="main-content-wrapper">
        <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h2>
                </div>
                <div class="col-md-6 text-end">
                    <a class="btn bg-second-btn" href="<?php echo e(route('material_stocks.index')); ?>"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <h6 class="text-muted mb-2"><strong><?php echo app('translator')->get('index.opening_stock'); ?></strong></h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if(isset($material_stock) && $material_stock && isset($material) && $material): ?>
                                    <table class="w-100 mt-10">
                                        <thead class="b-r-3 bg-color-000000">
                                            <tr>
                                                <th class="w-30 text-start"><?php echo app('translator')->get('index.raw_material_name'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.challan_no'); ?><br>(DC Date)</th>
                                                <th class="w-15 text-start">Heat No</th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.doc_no'); ?></th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.stock_type'); ?></th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.po_no'); ?></th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.stock'); ?></th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.alter_level'); ?></th>
                                                <th class="w-15 text-start"><?php echo app('translator')->get('index.floating_stock'); ?></th>
                                                <th class="w-30 text-start"><?php echo app('translator')->get('index.created_on'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="rowCount">
                                                <td class="text-start"><?php echo e($material->name); ?><br>(<?php echo e($material->code); ?>)</td>
                                                <?php if($material_stock->dc_no!=''): ?>
                                                    <td class="text-start"><?php echo e($material_stock->dc_no); ?><br>(<?php echo e(date('d-m-Y',strtotime($material_stock->dc_date))); ?>)</td>
                                                    <td class="text-start" title="<?php echo e($material_stock->heat_no); ?>"><?php echo e(substr_text($material_stock->heat_no,30)); ?></td>
                                                    <td class="text-start"><?php echo e($material_stock->mat_doc_no); ?></td>
                                                <?php else: ?>
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                <?php endif; ?>
                                                <td class="text-start"><?php echo $material_stock->stock_type == 'customer'
                                                ? $material_stock->stock_type . '<br><small>(' . getCustomerNameById($material_stock->customer_id) . ')</small>'
                                                : $material_stock->stock_type; ?></td>
                                                <td class="text-start"><?php echo e($material_stock->reference_no); ?></td>
                                                <td class="text-start"><?php echo e($material_stock->current_stock); ?> <?php echo e(getRMUnitById($material_stock->unit_id)); ?></td>
                                                <td class="text-start"><?php echo e($material_stock->close_qty); ?> <?php echo e(getRMUnitById($material_stock->unit_id)); ?></td>
                                                <td class="text-start"><?php echo e($material_stock->float_stock); ?> <?php echo e(getRMUnitById($material_stock->unit_id)); ?></td>
                                                <td class="text-start padding-0"><?php echo e(getDateFormat($material_stock->created_at)); ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <h6 class="text-muted mb-2 mt-2"><strong><?php echo e($title); ?></strong></h6>
                            <table class="w-100 mt-10">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.adj_type'); ?></th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.challan_no'); ?><br>(DC Date)</th>
                                        <th class="w-15 text-start">Heat No</th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.doc_no'); ?></th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.stock_type'); ?></th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.po_no'); ?></th>
                                        <th class="w-15 text-start"><?php echo app('translator')->get('index.quantity'); ?></th>
                                        <th class="w-20 text-start"><?php echo app('translator')->get('index.created_on'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($stock_adjustments) && $stock_adjustments): ?>
                                        <?php
                                        $i = 1;
                                        ?>
                                        <?php $__currentLoopData = $stock_adjustments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="rowCount">
                                                <td class="width_1_p">
                                                    <p class="set_sn"><?php echo e($i++); ?></p>
                                                </td>
                                                <td class="text-start"><?php echo e($value->type); ?></td>
                                                <?php if($value->dc_no!=''): ?>
                                                    <td class="text-start"><?php echo e($value->dc_no); ?><br>(<?php echo e(date('d-m-Y',strtotime($value->dc_date))); ?>)</td>
                                                    <td class="text-start" title="<?php echo e($value->heat_no); ?>"><?php echo e(substr_text($value->heat_no,30)); ?></td>
                                                    <td class="text-start"><?php echo e($value->mat_doc_no); ?></td>
                                                <?php else: ?>
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                <?php endif; ?>
                                                <td class="text-start"><?php echo e($value->stock_type); ?></td>
                                                <td class="text-start"><?php echo e($value->reference_no); ?></td>
                                                <td class="text-start"><?php echo e($value->quantity); ?> <?php echo e(isset($material_stock) ?  getRMUnitById($material_stock->unit_id) : ""); ?></td>
                                                <td class="text-start padding-0"><?php echo e(getDateFormat($value->created_at)); ?>   <i class="fa fa-circle-question" title="<?php echo e(notificationDateFormat($value->created_at)); ?>"></i>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/material_stock/stockAdjustmentLog.blade.php ENDPATH**/ ?>