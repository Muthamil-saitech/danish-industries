
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
                <?php if(routePermission('sale.print-invoice')): ?>
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                    data-id="<?php echo e($obj->id); ?>"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                    <?php echo app('translator')->get('index.print'); ?></a>
                <?php endif; ?>
                <?php if(routePermission('sale.download-invoice')): ?>
                <a href="<?php echo e(route('sales.download_invoice', encrypt_decrypt($obj->id, 'encrypt'))); ?>"
                    target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                        icon="solar:cloud-download-broken"></iconify-icon>
                    <?php echo app('translator')->get('index.download'); ?></a>
                <?php endif; ?>
                <?php if(routePermission('sale.index')): ?>
                <a class="btn bg-second-btn" href="<?php echo e(route('sales.index')); ?>"><iconify-icon
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
                                    <p class="pb-7 rgb-71"><?php echo e(safe(getCompanyInfo()->address)); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.email'); ?> : <?php echo e(safe(getCompanyInfo()->email)); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.phone'); ?> : <?php echo e(safe(getCompanyInfo()->phone)); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo app('translator')->get('index.website'); ?> : <a href="<?php echo e(getCompanyInfo()->website); ?>" target="_blank"><?php echo e(safe(getCompanyInfo()->website)); ?></a>
                                    </p>
                                </td>
                                <td class="w-50 text-right">
                                    <img src="<?php echo getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="site-logo">
                                </td>
                            </tr>
                        </table>
                        <div class="text-center pt-10 pb-10">
                            <h2 class="color-000000 pt-20 pb-20"><?php echo app('translator')->get('index.sales_invoice'); ?></h2>
                        </div>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.customer_info'); ?>:</h4>
                                    <p class="pb-7"><?php echo e($obj->customer->name); ?></p>
                                    <p class="pb-7 rgb-71"><?php echo e($obj->customer->address); ?></p>
                                    <?php if($obj->customer->pan_no!=''): ?> <p class="pb-7 rgb-71"><b>PAN: </b><?php echo e($obj->customer->pan_no); ?></p> <?php endif; ?>
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7"><?php echo app('translator')->get('index.sale_info'); ?>:</h4>
                                    <p class="pb-7">
                                        <span class=""><?php echo app('translator')->get('index.invoice_no'); ?>:</span>
                                        <?php echo e($obj->reference_no); ?>

                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class=""><?php echo app('translator')->get('index.invoice_date'); ?>:</span>
                                        <?php echo e(getDateFormat($obj->sale_date)); ?>

                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-center"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="w-20 text-start"><?php echo app('translator')->get('index.part_no'); ?></th>
                                    <th class="w-20 text-start"><?php echo app('translator')->get('index.description'); ?></th>
                                    <th class="w-5 text-start">HSN</th>
                                    <th class="w-30 text-start">DC.No & Date</th>
                                    <th class="w-20 text-start">Your DC.No</th>
                                    <th class="w-5 text-start">SRN</th>
                                    <th class="w-5 text-start"><?php echo app('translator')->get('index.po_no'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.quantity'); ?></th>
                                    <th class="w-15 text-start"><?php echo app('translator')->get('index.unit_price'); ?></th>
                                    <th class="w-30 text-right pr-5"><?php echo app('translator')->get('index.total_amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($sale_details) && $sale_details): ?> <?php $sum = 0; ?>
                                <?php $__currentLoopData = $sale_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php        
                                $order = getOrderInfo($value->order_id);                        
                                $productInfo = getFinishedProductInfo($value->product_id);
                                $unit_id = optional($obj->quotation->quotationDetails
                                    ->where('product_id', $value->product_id)
                                    ->first())->unit_id;
                                $quote_price = optional($obj->quotation->quotationDetails
                                    ->where('product_id', $value->product_id)
                                    ->first())->price;
                                $orderInfo = getOrderDetail($value->order_id,$value->product_id);
                                // dd($quotationDet);
                                ?>
                                <tr class="rowCount" data-id="<?php echo e($value->product_id); ?>">
                                    <td class="width_1_p">
                                        <p class="set_sn"><?php echo e($key + 1); ?></p>
                                    </td>
                                    <td class="text-start">
                                        <?php echo e($productInfo->code); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e($productInfo->name); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e($productInfo->hsn_sac_no!='' ? $productInfo->hsn_sac_no : ' - '); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e(isset($challanInfo) ? $challanInfo->challan_no.'/'.date('d-m-Y',strtotime($challanInfo->challan_date)) : ' '); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e(getYourDCNo($value->manufacture_id)); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e($value->srn); ?>

                                    </td>
                                    <td class="text-start">
                                        <?php echo e(getPoNo($value->order_id)); ?>

                                    </td>
                                    <td class="text-start"><?php echo e($value->product_quantity); ?>

                                        
                                    </td>
                                    <td class="text-start">
                                        
                                        <?php echo e(getCurrency(number_format($orderInfo->sale_price, 2, '.', ''))); ?>

                                    </td>   
                                    <?php /* $sale_rate = getOrderPrice($quote_price,$orderInfo->sale_price,$orderInfo->tax_type);  */ $sale_rate = $orderInfo->sale_price;
                                    ?>                                 
                                    <td class="text-right pr-10">
                                        <?php echo e(getCurrency(getSalePrice($sale_rate,$value->product_quantity))); ?>

                                    </td>
                                    <?php $sale_r = getSalePrice($sale_rate,$value->product_quantity); $sum = $sum + $sale_r ?>
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
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                <p class=""><?php echo app('translator')->get('index.subtotal'); ?> :</p>
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                <p><?php echo e(getAmtCustom($sum)); ?> </p>
                                            </td>
                                        </tr>
                                    </table> 
                                    <?php
                                        $otherState = ($order->inter_state == 'N');
                                        $tax_row = getTaxItems($order->tax_type == 1 ? 'Labor' : 'Sales');
                                        if ($otherState) {
                                            // CGST + SGST
                                            $taxAmount = ($sum * ($tax_row->tax_value / 2) / 100) * 2;
                                        } else {
                                            // IGST
                                            $taxAmount = ($sum * $tax_row->tax_value) / 100;
                                        }

                                        $grandTotal = $sum + $taxAmount;
                                    ?>                                   
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                <?php if($otherState): ?>
                                                    <p>CGST : <?php echo e($tax_row->tax_value / 2 . '%'); ?></p>
                                                    <p>SGST : <?php echo e($tax_row->tax_value / 2 . '%'); ?></p>
                                                <?php else: ?>
                                                    <p>IGST : <?php echo e($tax_row->tax_value . '%'); ?></p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                <?php if($otherState): ?>
                                                    <p><?php echo e(getAmtCustom(($sum * ($tax_row->tax_value / 2)) / 100)); ?></p>
                                                    <p><?php echo e(getAmtCustom(($sum * ($tax_row->tax_value / 2)) / 100)); ?></p>
                                                <?php else: ?>
                                                    <p><?php echo e(getAmtCustom(($sum * $tax_row->tax_value) / 100)); ?></p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                <p class=""><?php echo app('translator')->get('index.grand_total'); ?> :</p>
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                <p><?php echo e(getAmtCustom($grandTotal)); ?> </p>
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
<script src="<?php echo $baseURL . 'frequent_changing/js/sales.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/sales/viewSalesDetails.blade.php ENDPATH**/ ?>