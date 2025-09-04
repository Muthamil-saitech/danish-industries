<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($obj->reference_no); ?></title>
    <link rel="stylesheet" href="<?php echo e(getBaseURL()); ?>frequent_changing/css/pdf_common.css">
</head>

<body>
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    $base_color = '#6ab04c';
    if (isset($setting->base_color) && $setting->base_color) {
        $base_color = $setting->base_color;
    }
    ?>
    <div class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7"><?php echo e(getCompanyInfo()->company_name); ?></h3>
                    <p class="pb-7 rgb-71"><?php echo e(safe(getCompanyInfo()->address)); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.email'); ?> : <?php echo e(safe(getCompanyInfo()->email)); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.phone'); ?> : <?php echo e(safe(getCompanyInfo()->phone)); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.website'); ?> : <?php echo e(getCompanyInfo()->website); ?>

                    </p>
                </td>
                <td class="w-50 text-right">
                    <img src="<?php echo getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="site-logo">
                </td>
            </tr>
        </table>
        <div class="text-center pt-10 pb-10">
            <h2 class="color-000000 pt-20 pb-20"><?php echo app('translator')->get('index.purchase_invoice'); ?></h2>
        </div>
        <table>
            <tr>
                <td class="w-50">
                    <h4 class="pb-7"><?php echo app('translator')->get('index.supplier_info'); ?>:</h4>
                    <p class="pb-7"><?php echo e($suppliers[0]->name); ?></p>
                    <p class="pb-7 rgb-71"><?php echo e($suppliers[0]->contact_person); ?></p>
                    <p class="pb-7 rgb-71"><?php echo e($suppliers[0]->phone); ?></p>
                    <p class="pb-7 rgb-71"><?php echo e($suppliers[0]->email); ?></p>
                    <p class="pb-7 rgb-71"><?php echo e($suppliers[0]->address); ?></p>
                </td>
                <td class="w-50 text-right">
                    <h4 class="pb-7"><?php echo app('translator')->get('index.purchase_info'); ?>:</h4>
                    <p class="pb-7">
                        <span class="f-w-600"><?php echo app('translator')->get('index.purchase_no'); ?>:</span>
                        <?php echo e(isset($obj->reference_no) && $obj->reference_no != null ? $obj->reference_no : ""); ?>

                    </p>
                    <?php if($obj->invoice_no!=0): ?>
                    <p class="pb-7">
                        <span class="f-w-600"><?php echo app('translator')->get('index.invoice'); ?>:</span>
                        <?php echo e(isset($obj->invoice_no) ? $obj->invoice_no : ""); ?>

                    </p>
                    <?php endif; ?>
                    <p class="pb-7 rgb-71">
                        <span class="f-w-600"><?php echo app('translator')->get('index.date'); ?>:</span>
                        <?php echo e(getDateFormat($obj->date)); ?>

                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="f-w-600"><?php echo app('translator')->get('index.mat_type'); ?>:</span>
                        <?php
                            $types = [
                                "2" => "Raw Material",
                                "3" => "Insert"
                            ];
                            $selectedTypes = explode(',', $obj->mat_type);
                        ?>
                        <span
                            class="status-draft"><?php echo e(collect($selectedTypes)->map(fn($type) => $types[trim($type)] ?? '')->filter()->join(', ')); ?></span>
                    </p>
                    
                    <p class="pb-7 rgb-71">
                        <span class="f-w-600"><?php echo app('translator')->get('index.status'); ?>:</span>
                        <span class="status-draft"><?php echo e($obj->status); ?></span>
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="f-w-600"><?php echo app('translator')->get('index.payment_status'); ?>:</span>
                        <span class="status-draft"><?php echo e(paymentStatus($obj->due, $obj->paid)); ?></span>
                    </p>
                </td>
            </tr>
        </table>

        <table class="w-100 mt-20">
            <thead class="b-r-3 bg-color-000000">
                <tr>
                    <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                    <th class="w-30 text-start"><?php echo app('translator')->get('index.raw_material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                    
                    <th class="w-15 text-center"><?php echo app('translator')->get('index.unit_price'); ?></th>
                    <th class="w-15 text-center"><?php echo app('translator')->get('index.quantity'); ?></th>
                    <th class="w-20 text-right pr-5"><?php echo app('translator')->get('index.total'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($pruchse_rmaterials) && $pruchse_rmaterials): ?>
                    <?php $i = 1; ?>
                    <?php $__currentLoopData = $pruchse_rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="rowCount" data-id="<?php echo e($value->finishProduct_id); ?>">

                            <td class="width_1_p">
                                <p class="set_sn"><?php echo e($i++); ?></p>
                            </td>
                            <td class=""><?php echo e(getRMName($value->rmaterials_id)); ?><br></td>
                            
                            <td class="text-center" style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($value->unit_price,2)); ?>

                            </td>
                            <td class="text-center"><?php echo e($value->quantity_amount); ?>

                                <?php echo e(getRMUnitById($value->mat_unit)); ?>

                            </td>
                            <td class="text-right pr-10" style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($value->total,2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>

        <table>
            <tr>
                <td valign="top" class="w-50">
                    <div class="pt-20">
                        <h4 class="d-block pb-10"><?php echo app('translator')->get('index.note'); ?></h4>
                        <div class="">
                            <p class="h-180 color-black">
                                <?php echo e($obj->note); ?>

                            </p>
                        </div>
                    </div>
                </td>
                <td class="w-50">
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo app('translator')->get('index.subtotal'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->subtotal,2)); ?></p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo app('translator')->get('index.other'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->other,2)); ?></p>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo app('translator')->get('index.discount'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->discount,2)); ?></p>
                            </td>
                        </tr>
                    </table>

                    <table class="mt-10 mb-10">
                        <tr>
                            <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray">
                                <p class="f-w-600"><?php echo app('translator')->get('index.grand_total'); ?> :</p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->grand_total,2)); ?></p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo app('translator')->get('index.paid'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->paid,2)); ?></p>
                            </td>
                        </tr>
                    </table>
                    
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo app('translator')->get('index.due'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->due,2)); ?></p>
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
    <?php
        $baseURL = getBaseURL();
        $setting = getSettingsInfo();
        $base_color = '#6ab04c';
        if (isset($setting->base_color) && $setting->base_color) {
            $base_color = $setting->base_color;
        }
    ?>
    <script src="<?php echo e($baseURL .('assets/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e($baseURL . ('frequent_changing/js/onload_print.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/purchase/print_purchase_invoice.blade.php ENDPATH**/ ?>