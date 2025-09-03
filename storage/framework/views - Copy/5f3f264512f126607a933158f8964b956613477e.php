
<?php $__env->startSection('script_top'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
    <link rel="stylesheet" href="<?php echo e(getBaseURL()); ?>frequent_changing/css/pdf_common.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Optional theme -->

    <section class="main-content-wrapper bg-main">
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h2>
                </div>
                <div class="col-md-6">
                    <?php if(routePermission('order.print-invoice')): ?>
                        <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                            data-id="<?php echo e($obj->id); ?>"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.print'); ?></a>
                    <?php endif; ?>
                    <?php if(routePermission('order.download-invoice')): ?>
                        <a href="<?php echo e(route('customer-order-download', encrypt_decrypt($obj->id, 'encrypt'))); ?>"
                            target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                                icon="solar:cloud-download-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.download'); ?></a>
                    <?php endif; ?>
                    <?php if(routePermission('order.index')): ?>
                        <a class="btn bg-second-btn" href="<?php echo e(route('customer-orders.index')); ?>"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h3 class="pb-7"><?php echo e(getCompanyInfo()->company_name); ?></h3>
                                        <p class="pb-7 rgb-71"><?php echo e(getCompanyInfo()->address); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.email'); ?> : <?php echo e(getCompanyInfo()->email); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.phone'); ?> : <?php echo e(getCompanyInfo()->phone); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.website'); ?> : <a href="<?php echo e(getCompanyInfo()->website); ?>" target="_blank"><?php echo e(getCompanyInfo()->website); ?></a>
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <img src="<?php echo getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="site-logo">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20"><?php echo app('translator')->get('index.order_details'); ?></h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h4 class="pb-7"><?php echo app('translator')->get('index.customer_info'); ?>:</h4>
                                        <p class="pb-7"><?php echo e($obj->customer->name); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo e($obj->customer->phone); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo e($obj->customer->email); ?></p>
                                        <p class="pb-7 rgb-71"><?php echo e($obj->customer->address); ?></p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <h4 class="pb-7"><?php echo app('translator')->get('index.order_info'); ?>:</h4>
                                        <p class="pb-7">
                                            <span class=""><?php echo app('translator')->get('index.po_no'); ?>:</span>
                                            <?php echo e($obj->reference_no); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><?php echo app('translator')->get('index.order_type'); ?>:</span>
                                            <?php echo e($obj->order_type=='Quotation' ? 'Labor' : 'Sales'); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><?php echo app('translator')->get('index.delivery_address'); ?>:</span>
                                            <?php echo e($obj->delivery_address); ?>

                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table class="w-100 mt-20">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                        <?php if($obj->order_type=='Work Order'): ?>
                                        <th class="w-20 text-start"><?php echo app('translator')->get('index.delivery_date'); ?></th>
                                        <?php else: ?>
                                        <th class="w-20 text-start"><?php echo app('translator')->get('index.quote_date'); ?></th>
                                        <?php endif; ?>
                                        <th class="w-25 text-start">Part Name<br>(Part No)</th>
                                        <th class="w-25 text-start"><?php echo app('translator')->get('index.raw_material_name'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                        
                                        <th class="w-15 text-center"><?php echo app('translator')->get('index.raw_quantity'); ?></th>
                                        <th class="w-15 text-center"><?php echo app('translator')->get('index.prod_quantity'); ?></th>
                                        <th class="w-15 text-center"><?php echo app('translator')->get('index.unit_price'); ?></th>
                                        
                                        
                                        <th class="w-15 text-center"><?php echo app('translator')->get('index.tax'); ?></th>
                                        <th class="w-15 text-center"><?php echo app('translator')->get('index.total'); ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($orderDetails) && $orderDetails): ?>
                                        <?php ($i = 1); ?>
                                        <?php $__currentLoopData = $orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $productRawInfo = getProductRawMaterialByProductId($value->product_id);
                                            $productInfo = getFinishedProductInfo($value->product_id);
                                            ?>
                                            <tr class="rowCount" data-id="<?php echo e($value->product_id); ?>">
                                                <td class="width_1_p">
                                                    <p class="set_sn"><?php echo e($i++); ?></p>
                                                </td>
                                                <td class="text-start"><?php echo e($value->delivery_date != null ? getDateFormat($value->delivery_date): getDateFormat($obj->created_at)); ?>

                                                </td>
                                                <td class="text-start"><?php echo e($productInfo->name); ?><br>(<?php echo e($productInfo->code); ?>)
                                                </td>
                                                <td class="text-start"><?php echo e(getRMName($value->raw_material_id)); ?></td>
                                                
                                                <td class="text-center"><?php echo e($value->raw_qty); ?></td>
                                                <td class="text-center"><?php echo e($value->quantity); ?></td>
                                                <td class="text-center"><?php echo e(getAmtCustom($value->sale_price)); ?></td>
                                                <?php
                                                    $sub_tot_before_dis = $value->sale_price;
                                                    $dis_val = $value->discount_percent != '0' ? $sub_tot_before_dis * ($value->discount_percent / 100) : '0';
                                                    $sub_tot_af_dis = $dis_val!='0' ? $sub_tot_before_dis - $dis_val : $sub_tot_before_dis;
                                                ?>
                                                
                                                
                                                <?php
                                                    if($value->igst=='') {
                                                        $gst_per = $value->cgst + $value->sgst;
                                                    } else {
                                                        $gst_per = $value->igst;
                                                    }
                                                    $gst_value = $sub_tot_af_dis * ($gst_per/100);
                                                    $total = $sub_tot_af_dis + $gst_value
                                                ?>
                                                <td class="text-center"><?php echo e(getAmtCustom($gst_value)); ?>

                                                </td>                                                
                                                <td class="text-center"><?php echo e(getAmtCustom($total)); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            
                            <table>
                                <tr>
                                    <td class="w-30 ">
                                    </td>
                                    <td class="w-50">
                                        <table class="mt-10 mb-10">
                                            <tr>
                                                <td class="w-50">
                                                    <p class=""><?php echo app('translator')->get('index.total_cost'); ?> :</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p><?php echo e(getAmtCustom($obj->total_amount)); ?></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table class="mt-50">
                                <tr>
                                    <td class="w-50">
                                    </td>
                                    <td class="w-50 text-right">
                                        <p class="rgb-71 d-inline border-top-e4e5ea pt-10"><?php echo app('translator')->get('index.authorized_signature'); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo $baseURL . 'frequent_changing/js/order.js'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_order/view.blade.php ENDPATH**/ ?>