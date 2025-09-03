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
                <h2 class="top-left-header"><?php echo app('translator')->get('index.supplier_payment_invoice'); ?></h2>
            </div>
            <div class="col-md-6">
                
                <a class="btn bg-second-btn" href="<?php echo e(route('supplier-payment.index')); ?>"><iconify-icon
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
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.supplier_info'); ?>:</h4>
                                    <p class="pb-7"><?php echo e($supplier->name); ?></p>
                                    
                                    <p class="pb-7 rgb-71"><?php echo e($supplier->phone); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo e($supplier->email); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo e($supplier->address); ?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.purchase_info'); ?>:</h4>
                                    <p class="pb-7">
                                        <span class=""><?php echo app('translator')->get('index.purchase_no'); ?>:</span>
                                        <?php echo e($obj->reference_no); ?>

                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class=""><?php echo app('translator')->get('index.purchase_date'); ?>:</span>
                                        <?php echo e(getDateFormat($obj->date)); ?>

                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.payment_date'); ?></th>
                                    <th class="w-15"><?php echo app('translator')->get('index.paid_amount'); ?></th>
                                    <th class="w-15"><?php echo app('translator')->get('index.payment_type'); ?></th>
                                    <th class="w-15"><?php echo app('translator')->get('index.payment_img'); ?></th>
                                    <th class="w-15"><?php echo app('translator')->get('index.note'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                <?php if(isset($supplier_pay_entries) && $supplier_pay_entries->isNotEmpty()): ?>
                                <?php $__currentLoopData = $supplier_pay_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier_pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="rowCount" data-id="<?php echo e($supplier_pay->id); ?>">
                                    <td class="width_1_p">
                                        <p class="set_sn"><?php echo e($i++); ?></p>
                                    </td>
                                    <td class="text-start"><?php echo e(getDateFormat($supplier_pay->purchase_date)); ?></td>
                                    <td class="text-start"><?php echo e(getAmtCustom($supplier_pay->pay_amount)); ?>

                                    </td>
                                    <td class="text-start"><?php echo e($supplier_pay->pay_type); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php if($supplier_pay->payment_proof): ?>
                                        <a class="text-decoration-none"
                                            href="<?php echo e($baseURL); ?>uploads/supplier_payments/<?php echo e($supplier_pay->payment_proof); ?>"
                                            data-lightbox="payment-proof"
                                            data-title="Payment Proof">
                                            <img src="<?php echo e($baseURL); ?>uploads/supplier_payments/<?php echo e($supplier_pay->payment_proof); ?>"
                                                alt="File Preview" class="img-thumbnail mx-2"
                                                width="50px">
                                        </a>
                                        <?php else: ?>
                                        N/A
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-start" title="<?php echo e($supplier_pay->note); ?>"><?php echo e($supplier_pay->note ? substr_text($supplier_pay->note,20) : 'N/A'); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr class="rowCount" data-id="<?php echo e($obj->id); ?>">
                                    <td class="width_1_p">
                                        <p class="set_sn"><?php echo e($i++); ?></p>
                                    </td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start"><?php echo e(getAmtCustom($obj->paid)); ?>

                                    </td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start">N/A</td>
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
<script src="<?php echo $baseURL . 'frequent_changing/js/supplier_payment.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dist/js/lightbox.min.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/supplier_payment/invoice.blade.php ENDPATH**/ ?>