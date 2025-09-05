<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
$whiteLabelInfo = App\WhiteLabelSettings::first();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            <h2 class="color-000000 pt-20 pb-20"><?php echo app('translator')->get('index.manufacture_details'); ?></h2>
        </div>
        <table>
            <tr>
                <td class="w-50">
                    <p class="pb-7">
                        <span class=""><?php echo app('translator')->get('index.ppcrc_no'); ?>:</span>
                        <?php echo e($obj->reference_no); ?>

                    </p>
                    
                    <p class="pb-7 rgb-71">
                        <span class=""><?php echo app('translator')->get('index.status'); ?>:</span>
                        <?php if($obj->manufacture_status == 'draft'): ?>
                            Draft
                        <?php elseif($obj->manufacture_status == 'inProgress'): ?>
                            In Progress
                        <?php elseif($obj->manufacture_status == 'done'): ?>
                            Done
                        <?php endif; ?>
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class=""><?php echo app('translator')->get('index.start_date'); ?>:</span>
                        <?php echo e(getDateFormat($obj->start_date)); ?>

                    </p>
                </td>
                <td class="w-50 text-right">
                    <?php $prodInfo = getFinishedProductInfo($obj->product_id); ?>
                    <p class="pb-7">
                        <span class=""><?php echo app('translator')->get('index.part_no'); ?>:</span>
                        <?php echo e($prodInfo->code); ?>

                    </p>
                    <p class="pb-7">
                        <span class=""><?php echo app('translator')->get('index.part_name'); ?>:</span>
                        <?php echo e($prodInfo->name); ?>

                    </p>                    
                    <p class="pb-7 rgb-71">
                        <span class=""><?php echo app('translator')->get('index.prod_quantity'); ?>:</span>
                        <?php echo e($obj->product_quantity); ?>

                    </p>
                    <p class="pb-7 rgb-71">
                        <span class=""><?php echo app('translator')->get('index.delivery_date'); ?>:</span>
                        <?php echo e($obj->complete_date != null ? getDateFormat($obj->complete_date) : 'N/A'); ?>

                    </p>
                </td>
            </tr>
        </table>
        <h5><?php echo app('translator')->get('index.raw_material_consumption_cost'); ?> (RoM)</h5>
        <table class="w-100 mt-10">
            <thead class="b-r-3 bg-color-000000">
                <tr>
                    <th class="w-5 text-left"><?php echo app('translator')->get('index.sn'); ?></th>
                    <th class="w-30 text-left"><?php echo app('translator')->get('index.raw_material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                    <th class="w-15 text-left">Heat No</th>
                    <th class="w-15 text-left"><?php echo app('translator')->get('index.stock'); ?></th>
                    <th class="w-15 text-left"><?php echo app('translator')->get('index.consumption'); ?></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if(isset($m_rmaterials) && $m_rmaterials): ?>
                    <?php
                    $i = 1;
                    ?>
                    <?php $__currentLoopData = $m_rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="rowCount">
                            <td class="width_1_p">
                                <p class="set_sn"><?php echo e($i++); ?></p>
                            </td>
                            <td class="text-start"><?php echo e(getRMName($value->rmaterials_id)); ?></td>
                            <td class="text-start"><?php echo e(getheatNo($value->rmaterials_id)); ?></td>
                            <td class="text-start"><?php echo e($value->stock); ?> <?php echo e(getStockUnitById($value->stock_id)); ?></td>
                            <td class="text-start"><?php echo e($value->consumption); ?>

                                <?php echo e(getStockUnitById($value->stock_id)); ?>

                            </td>
                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
            
        </table>

        

        <h5><?php echo app('translator')->get('index.manufacture_stages'); ?></h5>
        <table class="w-100 mt-10">
            <thead class="b-r-3 bg-color-000000">
                <tr>
                    <th class="w-5 text-left"><?php echo app('translator')->get('index.sn'); ?></th>
                    <th class="w-30 text-left"><?php echo app('translator')->get('index.stage'); ?></th>
                    
                    
                    <th class="w-15 text-center"><?php echo app('translator')->get('index.required_hour'); ?></th>
                    <th class="w-15 text-center"><?php echo app('translator')->get('index.required_minute'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($m_stages) && $m_stages): ?>
                    <?php
                    $k = 1;
                    $total_month = 0;
                    $total_day = 0;
                    $total_hour = 0;
                    $total_mimute = 0;
                    ?>
                    <?php $__currentLoopData = $m_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $checked = '';
                        $tmp_key = $key + 1;
                        if ($obj->stage_counter == $tmp_key) {
                            $checked = 'checked=checked';
                        }
                        $total_value = $value->stage_month * 2592000 + $value->stage_day * 86400 + $value->stage_hours * 3600 + $value->stage_minute * 60;
                        $months = floor($total_value / 2592000);
                        $hours = floor(($total_value % 86400) / 3600);
                        $days = floor(($total_value % 2592000) / 86400);
                        $minuts = floor(($total_value % 3600) / 60);
                        
                        $total_month += $months;
                        $total_hour += $hours;
                        $total_day += $days;
                        $total_mimute += $minuts;
                        
                        $total_stages = $total_month * 2592000 + $total_hour * 3600 + $total_day * 86400 + $total_mimute * 60;
                        $total_months = floor($total_stages / 2592000);
                        $total_hours = floor(($total_stages % 86400) / 3600);
                        $total_days = floor(($total_stages % 2592000) / 86400);
                        $total_minutes = floor(($total_stages % 3600) / 60);
                        
                        ?>
                        <tr class="rowCount">
                            <td class="width_1_p">
                                <p class="set_sn"><?php echo e($k++); ?></p>
                            </td>
                            <td class="text-left">
                                <?php echo e(getProductionStages($value->productionstage_id)); ?></td>
                            
                            
                            <td class="text-center"><?php echo e($value->stage_hours); ?>

                            </td>
                            <td class="text-center"><?php echo e($value->stage_minute); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right pr-10"><?php echo app('translator')->get('index.total'); ?> :</td>
                    
                    <td class="text-center">
                        <?php echo e(isset($total_hours) && $total_hours ? $total_hours : ''); ?></td>
                    <td class="text-center">
                        <?php echo e(isset($total_minutes) && $total_minutes ? $total_minutes : ''); ?>

                    </td>
                </tr>
            </tfoot>
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
    <script src="<?php echo e(asset('assets/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frequent_changing/js/onload_print.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/manufacture/print_manufacture_details.blade.php ENDPATH**/ ?>