<?php $__env->startSection('content'); ?>
<?php
$baseURL = getBaseURL();
$setting = getSettingsInfo();
$base_color = '#6ab04c';
if (isset($setting->base_color) && $setting->base_color) {
    $base_color = $setting->base_color;
}
?>
<link rel="stylesheet" href="<?php echo e(getBaseURL() . 'frequent_changing/css/pdf_common.css'); ?>">
<link rel="stylesheet" href="<?php echo e(getBaseURL() . 'assets/dist/css/lightbox.min.css'); ?>">
<section class="main-content-wrapper">
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo app('translator')->get('index.customer_payment_invoice'); ?></h2>
            </div>
            <div class="col-md-6">
                
                <a class="btn bg-second-btn" href="<?php echo e(route('customer-payment.index')); ?>"><iconify-icon
                        icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
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
                                    <img src="<?php echo getBaseURL() . (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid mb-2">
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.customer_info'); ?>:</h4>
                                    <p class="pb-7 arabic"><?php echo e($obj->customer->name); ?></p>
                                    <p class="pb-7 rgb-71 arabic"><?php echo e($obj->customer->address); ?></p>
                                    <p class="pb-7 rgb-71 arabic"><?php echo e($obj->customer->phone); ?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.order_info'); ?>:</h4>
                                    <p class="pb-7">
                                        <span class=""><?php echo app('translator')->get('index.po_no'); ?>:</span>
                                        <?php echo e($obj->reference_no); ?>

                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class=""><?php echo app('translator')->get('index.order_date'); ?>:</span>
                                        <?php echo e(getDateFormat($customer_inv->invoice_date)); ?>

                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class=""><?php echo app('translator')->get('index.total_amount'); ?>:</span>
                                        <?php echo e(getAmtCustom($customer_inv->amount)); ?>

                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.payment_date'); ?></th>
                                    
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.paid_amount'); ?></th>
                                    
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.payment_type'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.payment_img'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.note'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                <?php if(isset($customer_due_entries) && $customer_due_entries->isNotEmpty()): ?>
                                <?php $__currentLoopData = $customer_due_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer_due): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="rowCount" data-id="<?php echo e($customer_due->id); ?>">
                                    <td class="width_1_p">
                                        <p class="set_sn"><?php echo e($i++); ?></p>
                                    </td>
                                    <td class="text-start">
                                        <?php echo e(getDateFormat($customer_due->created_at)); ?>

                                    </td>
                                    
                                    <td class="text-start"><?php echo e(getAmtCustom($customer_due->pay_amount)); ?>

                                    </td>
                                    
                                    <td class="text-start"><?php echo e($customer_due->payment_type); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php if($customer_due->payment_proof): ?>
                                        
                                        <a class="text-decoration-none"
                                            href="<?php echo e($baseURL); ?>uploads/customer_due/<?php echo e($customer_due->payment_proof); ?>"
                                            data-lightbox="payment-proof"
                                            data-title="Payment Proof">
                                            <img src="<?php echo e($baseURL); ?>uploads/customer_due/<?php echo e($customer_due->payment_proof); ?>"
                                                alt="File Preview" class="img-thumbnail mx-2"
                                                width="50px">
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-start" title="<?php echo e($customer_due->note); ?>"><?php echo e(substr_text($customer_due->note,20)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr class="rowCount">
                                    <td colspan="7" class="text-center">No Data Found</td>
                                </tr>
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
<?php
$baseURL = getBaseURL();
?>
<script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/addRMPurchase.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/supplier.js'; ?>"></script>
<script src="<?php echo $baseURL . 'frequent_changing/js/customer_payment.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dist/js/lightbox.min.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_payment/invoice.blade.php ENDPATH**/ ?>