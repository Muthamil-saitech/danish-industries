<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($obj->reference_no); ?></title>
    <link rel="stylesheet" href="<?php echo e(getBaseURL()); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7"><?php echo e(getCompanyInfo()->company_name); ?></h3>
                    <p class="pb-7 rgb-71"><?php echo e(getCompanyInfo()->address); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.email'); ?> : <?php echo e(getCompanyInfo()->email); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.phone'); ?> : <?php echo e(getCompanyInfo()->phone); ?></p>
                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.website'); ?> : <?php echo e(getCompanyInfo()->website); ?></p>
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
                    <th class="w-25 text-start"><?php echo app('translator')->get('index.raw_material'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                    
                    <th class="w-15 text-start"><?php echo app('translator')->get('index.raw_quantity'); ?></th>
                    <th class="w-15 text-start"><?php echo app('translator')->get('index.prod_quantity'); ?></th>
                    <th class="w-15 text-start"><?php echo app('translator')->get('index.unit_price'); ?></th>
                    
                    
                    <th class="w-15 text-start"><?php echo app('translator')->get('index.tax'); ?></th>
                    <th class="w-15 text-start"><?php echo app('translator')->get('index.total'); ?></th>
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
                            
                            <td class="text-start"><?php echo e($value->raw_qty); ?></td>
                            <td class="text-start"><?php echo e($value->quantity); ?></td>
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($value->sale_price,2)); ?></td>
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
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($gst_value,2)); ?>

                            </td>
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($total,2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        
        <table>
            <tr>
                <td class="w-30">
                </td>
                <td class="w-50">
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class=""><?php echo app('translator')->get('index.total_cost'); ?></p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹<?php echo e(number_format($obj->total_amount,2)); ?></p>
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
    <script src="<?php echo e($baseURL . ('assets/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e($baseURL . ('frequent_changing/js/onload_print.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_order/invoice.blade.php ENDPATH**/ ?>