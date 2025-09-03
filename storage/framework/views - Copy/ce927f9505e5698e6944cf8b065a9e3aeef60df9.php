
<?php $__env->startSection('content'); ?>
<?php
$baseURL = getBaseURL();
$setting = getSettingsInfo();
$base_color = '#6ab04c';
if (isset($setting->base_color) && $setting->base_color) {
    $base_color = $setting->base_color;
}
?>
<link rel="stylesheet" href="<?php echo e(getBaseURL()); ?>frequent_changing/css/pdf_common.css">
<section class="main-content-wrapper">
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo app('translator')->get('index.challan_info'); ?></h2>
            </div>
            <div class="col-md-6">
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_challan_invoice"
                    data-id="<?php echo e($obj->id); ?>"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                    <?php echo app('translator')->get('index.print'); ?></a>
                
                <a class="btn bg-second-btn" href="<?php echo e(route('quotation.index')); ?>"><iconify-icon
                        icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
            </div>
        </div>
    </section>
    <section class="content" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div style="width: 98%; max-width: 1200px; margin: 30px auto;">
            <div style="padding: 18px 0; border: 1px solid #000; background: #fff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <div style="flex: 1; text-align: center;">
                        <h5 style="font-size: 18px; font-weight: 700; letter-spacing: 1px; margin: 0;">DELIVERY CHALLAN</h5>
                        <img src="<?php echo getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid my-2">
                        <!-- <h3 style="font-size: 25px; font-weight: 500; margin: 2px 0;"><?php echo e(strtoupper(getCompanyInfo()->company_name)); ?></h3> -->
                        <p style="font-size: 15px; margin-top: 0px; margin-bottom: 1px;">An ISO 9001:2008 Certified Company</p>
                        <p style="font-size: 16px; margin: 0;"><?php echo e(safe(getCompanyInfo()->address)); ?>

                        </p>
                    </div>
                </div>
                <div
                    style="display: flex; align-items: start; justify-content: space-between; font-size: 16px; margin:0px 25px  2px 10px; flex-wrap: wrap">
                    <div style="display: flex; align-items: center;">
                        <p>GSTIN No.: </p><b style="margin-left: 10px"><?php echo e(safe(getCompanyInfo()->gst_no)); ?></b>
                    </div>
                    <div>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px; display: flex; justify-content: space-between; width: 30%; white-space: nowrap">SSl. No
                                <span>:</span>
                            </p> <b style="margin-left: 10px"><?php echo e(safe(getCompanyInfo()->ssi_no)); ?></b>
                        </span>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">PAN No. <span>:</span> </p><b style="margin-left: 10px"><?php echo e(safe(getCompanyInfo()->pan_no)); ?></b>
                        </span>
                    </div>
                    <div>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">Phone No<span>:</span> </p><b style="margin-left: 10px"><?php echo e(safe(getCompanyInfo()->phone)); ?></b>
                        </span>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">E-Mail
                                <span>:</span>
                            </p><b style=" width: 50%;margin-left: 10px"><?php echo e(safe(getCompanyInfo()->email)); ?></b>
                        </span>
                    </div>
                </div>
                <div style="display: flex; margin: 12px 0 0;">
                    <div
                        style="width: 50%; border-top: 1px solid #000; border-right: 1px solid #000; padding: 8px 10px; font-size: 16px;">
                        <b>To</b><br>
                        <div style="padding-left: 30px; padding-bottom:35px; display: flex;"> <span>Mr./Ms.</span> <b
                                style="padding-left: 10px; font-weight: 700;"> <?php echo e($obj->customer->name); ?><br>
                                <?php echo e($obj->customer->address); ?><br>
                                <?php echo e($obj->customer->pan_no!='' ? 'PAN: '.$obj->customer->pan_no : ''); ?></b>
                        </div>
                        <p>Party GSTIN No. : <?php echo e($obj->customer->gst_no); ?></p>
                    </div>
                    <div style="width: 50%; border-top: 1px solid #000; padding: 8px 10px; font-size: 16px;">
                        <div style="display: flex; margin-bottom: 4px;">
                            <span style="width: 40%;">DC No </span> <b>: <?php echo e($obj->challan_no); ?></b>
                        </div>
                        <div style="display: flex;margin-bottom: 4px;">
                            <span style="width: 40%;">DC Date</span> <b> : <?php echo e(getDateFormat($obj->challan_date)); ?></b>
                        </div>
                        <div style="display: flex; margin-bottom: 4px;">
                            <span style="width: 40%;">Customer Code</span> <b> : <?php echo e($obj->customer->customer_id); ?></b>
                        </div>
                    </div>
                </div>
                <table style="width:100%; border-collapse:collapse; font-size:16px;">
                    <tr style="text-align: center;">
                        <th style="border:1px solid #000; padding:4px; border-left: none;">S.No</th>
                        <th style="border:1px solid #000; padding:4px;">Part No.</th>
                        <th style="border:1px solid #000; padding:4px;">Description</th>
                        <th style="border:1px solid #000; padding:4px;">Qty</th>
                        <th style="border:1px solid #000; padding:4px;">UOM</th>
                        
                        <th style="border:1px solid #000; padding:4px;">PO No</th>
                        <th style="border:1px solid #000; padding:4px;">HSN/SAC</th>
                        <th style="border:1px solid #000; padding:4px;">DC Ref</th>
                        <th style="border:1px solid #000; padding:4px;">Challan Ref</th>
                        <th style="border:1px solid #000; padding:4px; border-right: none;">Remarks</th>
                    </tr>
                    <?php $i = 0;
                    $totalQty = 0; ?>
                    <?php if(isset($quotation_details) && $quotation_details): ?>
                    <?php $__currentLoopData = $quotation_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $i++;
                    $productInfo = getFinishedProductInfo($value->product_id);
                    $totalQty += $value->product_quantity;
                    $orderDetail = getOrderDetail($value->customer_order_id, $value->product_id);
                    ?>
                    <tr>
                        <td style="border:1px solid #000; padding:4px; text-align:center;  border-left: none;" rowspan="4"><?php echo e($i); ?></td>
                        <td style="padding:4px; text-align: center;"><?php echo e($productInfo->code); ?></td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none;"><?php echo e($productInfo->name); ?> </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:center;"><?php echo e($value->product_quantity); ?></td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;"><?php echo e(getRMUnitById($value->unit_id)); ?></td>
                        
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;"><?php echo e($value->po_no); ?>

                        </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;"><?php echo e($productInfo->hsn_sac_no!='' ? $productInfo->hsn_sac_no : ' '); ?></td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;"><?php echo e($value->dc_ref); ?>

                        </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;"><?php echo e($value->challan_ref); ?></td>
                        <td style="padding:4px; border-bottom: none; text-align:start; border-right: none;"><?php echo e($value->description); ?></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        
                        <td style="border-left: 1px solid #000;"><?php echo e($value->po_date!='' ? date('d-m-Y',strtotime($value->po_date)) : ''); ?></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"><?php echo e($value->dc_ref_date!='' ? date('d-m-Y',strtotime($value->dc_ref_date)) : ''); ?></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #000; padding: 0 4px;"></td>
                        <td style="border-left: 1px solid #000; padding: 0 4px;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom:1px solid #000;">
                        <td style="border-left: 1px solid #000;  padding: 5px 5px 7px;"></td>
                        <td style="border-left: 1px solid #000;  padding: 5px 5px 7px;"></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <tfoot>
                        <tr style="border: 1px solid #000;border-left:none;border-right:none;text-align:center;">
                            <td style="border-right: 1px solid #000; border-left:none;"> </td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;padding-bottom:35px;"><b>Total Quantity</b></td>
                            <td style="border-right: 1px solid #000;padding-bottom:35px;"><b><?php echo e($totalQty); ?></b></td>
                            
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;border-right:none;" >&nbsp;&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
                <div
                    style="display: flex; justify-content: space-between; align-items: start; margin: 30px 10px 0px; font-size: 16px;">
                    <div>
                        <p style="margin: 0;"> Received the above Goods in good conditions</p>
                        <p style="margin-top: 30px;"> Receiver's Signature with Seal</p>
                    </div>
                    <div style="text-align: right;">
                        For <b><?php echo e(strtoupper(getCompanyInfo()->company_name)); ?></b>

                    </div>
                </div>
            </div>
            <div style="text-align: end;">
                <span style="font-size: 12px;">DAN/STR/SF/01</span>
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
<script src="<?php echo $baseURL . 'frequent_changing/js/quotation.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/quotation/details.blade.php ENDPATH**/ ?>