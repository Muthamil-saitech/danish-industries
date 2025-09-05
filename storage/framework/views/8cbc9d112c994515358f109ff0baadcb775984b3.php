
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
            </div>
            <div class="col-md-6">
                <button id="route_add" data-bs-toggle="modal" data-id="<?php echo e($obj->id); ?>" data-bs-target="#routeUpl" class="btn bg-second-btn" title="Route Card Form Upload" type="button"><i class="fa-regular fa-circle-up"></i>&nbsp;Upload</button>
                <?php if(routePermission('manufacture.print')): ?>
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_route_card"
                    data-id="<?php echo e($obj->id); ?>"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                    <?php echo app('translator')->get('index.print'); ?></a>
                <?php endif; ?>
                <!--<a href="<?php echo e(route('download_route_card', encrypt_decrypt($obj->id, 'encrypt'))); ?>"
                        target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                            icon="solar:cloud-download-broken"></iconify-icon>
                        <?php echo app('translator')->get('index.download'); ?></a>-->
                <?php if(routePermission('manufacture.index')): ?>
                <a class="btn bg-second-btn" href="<?php echo e(route('productions.index')); ?>"><iconify-icon
                        icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if(isset($latest_form) && $latest_form!=''): ?>
    <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
        <div class="text-center">
            <img src="<?php echo getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid mb-2">
        </div>
        <!-- <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;"><?php echo e(strtoupper($setting->name_company_name)); ?></h3> -->
        <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;"><?php echo e(isset($title) && $title ? strtoupper($title) : ''); ?></p>
        <img src="<?php echo e($baseURL); ?>uploads/route_card_form/<?php echo e($latest_form); ?>" alt="route_card_form" class="img-fluid">
    </div>
    <?php else: ?>
    <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
        <div class="text-center">
            <img src="<?php echo getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid mb-2">
        </div>
        <!-- <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;"><?php echo e(strtoupper($setting->name_company_name)); ?></h3> -->
        <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;"><?php echo e(isset($title) && $title ? strtoupper($title) : ''); ?></p>
        <div style="border: 1px solid #222; border-top:none; margin-top: 20px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 15px; margin: 0px 0px 20px;  ">
                <tr>
                    <td style="border: 1px solid #222; padding: 4px; border-left: none;"> <b>PPCRC No :</b><?php echo e(isset($obj) ? $obj->reference_no : "-"); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;"><b>PPCRC Date : </b> <?php echo e(isset($obj) ? getDateFormat($obj->start_date) : "-"); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;"><b>Delivery Date : </b> <?php echo e(isset($obj) && $obj->complete_date!='' ? getDateFormat($obj->complete_date) : "-"); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;  border-right: none;"> <b>Quantity : </b><?php echo e(isset($obj) ? $obj->product_quantity : "-"); ?> <?php echo e(getStockUnitById($m_rmaterial->stock_id)); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 7px 5px;">Customer Name : <b><?php echo e(isset($obj) ? getCustomerNameById($obj->customer_id) : '-'); ?></b></td>
                    <td colspan="2" style="padding:  7px 5px;">Item : <b><?php echo e(isset($product) ? $product->name : '-'); ?></b></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:  7px 5px;">Part Number : <b><?php echo e(isset($product) ? $product->code : '-'); ?></b></td>
                    <td>
                        <div style="display: flex; justify-content: space-between; align-items: center; ">
                            <p>Drg No. : <b><?php echo e(isset($drawer) ? $drawer->drawer_no : '-'); ?></b>  </p>
                            <p> Rev No.<b> <?php echo e(isset($product) ? $product->rev : '-'); ?></b></p>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="padding:  7px 5px;">P.O No. : <b><?php echo e(isset($order) ? $order->reference_no.'_'.date('d-M-y',strtotime($order->created_at)) : '-'); ?></b></td>
                    
                    <td>
                        <div style="display: flex; justify-content: space-between; align-items: center; ">
                            <p>Size:  </p>
                            <p> Drg Location:<b> <?php echo e(isset($drawer) ? $drawer->drawer_loc : '-'); ?></b></p>
                        </div>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border-collapse: collapse; font-size: 15px; margin-bottom: 10px;">
                <tr style="text-align: center;">
                    <th style="border: 1px solid #222; padding: 4px; border-left: none;">Sl.No</th>
                    <th style="border: 1px solid #222; padding: 4px;">Scope</th>
                    <th style="border: 1px solid #222; padding: 4px;">Specification</th>
                    <th style="border: 1px solid #222; padding: 4px;">Your DC &amp; Challan No.</th>
                    <th style="border: 1px solid #222; padding: 4px;">H.No./R.No.</th>
                    <th style="border: 1px solid #222; padding: 4px;">Batch No</th>
                    <th style="border: 1px solid #222; padding: 4px;">Quantity</th>
                    <th style="border: 1px solid #222; padding: 4px;">Checked By</th>
                    <th style="border: 1px solid #222; padding: 4px;  border-right: none;">Remarks</th>
                </tr>
                <?php if(isset($rmaterial)): ?>
                <tr style="text-align: left;">
                    <td style="border: 1px solid #222; padding: 4px; text-align: center;  border-left: none;">1</td>
                    <td style="border: 1px solid #222; padding: 4px;"><?php echo e(isset($product) ? $product->scope : '-'); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;"><?php echo e($rmaterial->name.'-'.$rmaterial->code); ?> <?php echo e($rmaterial->diameter!='' ? '_DIA'.$rmaterial->diameter : ''); ?><?php echo e(isset($product) ? '_'.$product->name : '-'); ?><?php echo e(isset($m_rmaterial->materialStock) ? '_'.$m_rmaterial->materialStock->heat_no : ''); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;"><?php echo e(isset($delivery_challan) && $delivery_challan!='' ? $delivery_challan->challan_no.'/'.date('d-M-Y',strtotime($delivery_challan->challan_date)) : ' '); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;">&nbsp;</td>
                    <td style="border: 1px solid #222; padding: 4px;"></td>
                    <td style="border: 1px solid #222; padding: 4px;"><?php echo e(isset($m_rmaterial) ? $m_rmaterial->stock : ''); ?></td>
                    <td style="border: 1px solid #222; padding: 4px;"></td>
                    <td style="border: 1px solid #222; padding: 4px;  border-right: none;">
                    </td>
                </tr>
                <?php endif; ?>
            </table>
            <div style="margin-bottom: 5px; padding: 5px 10px; border-bottom: 1px solid #000; line-height: 25px; display: flex; justify-content: space-between;">
                <div>
                    <b>Tools/Gauges List : - Yes/No</b><br>
                    1. <?php echo e(isset($drawer) && $drawer->notes!='' ? $drawer->notes : ' '); ?>

                </div>
                
            </div>
            <div style="margin-bottom: 5px; padding: 5px 10px; line-height: 25px;">
                <b>Program List :- Yes/No</b><br>
                1. <?php echo e(isset($drawer) && $drawer->program_code!='' ? $drawer->program_code : ' '); ?>

            </div>
        </div>
    </div>
    <div style="display: flex; gap: 20px; width: 98%; max-width: 1100px; margin: 30px auto;">
        <div style="width: 50%;">
            <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;">Production Process Route</h3>
            <table style="border-collapse: collapse; font-size: 15px;">
                <tr style="text-align: center;">
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 18%;">Operations</th>
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 8%;">Cycle Time</th>
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 12%;">Date</th>
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 10%;">Opr Code</th>
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 10%;">M/C Code</th>
                    <th style="border: 1px solid #222; padding: 10px 5px; width: 8%;">Qty</th>
                </tr>
                <tbody style="text-align: center;">
                    <?php if(isset($finishProductStages)): ?>
                    <?php $__currentLoopData = $finishProductStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="3"><?php echo e(getProductionStage($value->productionstage_id)); ?></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="3"><?php if($value->stage_hours!=0 && $value->stage_minute==0): ?> <?php echo e(number_format($value->stage_hours*60, 2, '.', '')); ?> <?php elseif($value->stage_minute!=0 && $value->stage_hours==0): ?> <?php echo e(number_format($value->stage_minute, 2, '.', '')); ?> <?php else: ?> <?php echo e(number_format(($value->stage_hours * 60) + $value->stage_minute, 2, '.', '')); ?><?php endif; ?></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                        <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div style="width: 50%;">
            <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;">Quality Control</h3>
            <table style="text-align: center; border-collapse: collapse; font-size: 15px; width: 100%;">
                <tr>
                    <th style="border: 1px solid #222; padding:  10px 5px; width: 20%;"></th>
                    <th style="border: 1px solid #222; padding:  10px 5px; width: 20%;">Date</th>
                    <th style="border: 1px solid #222; padding:  10px 5px; width: 20%;">Qty</th>
                    <th style="border: 1px solid #222; padding:  10px 5px; width: 20%;">Sl. No</th>
                    <th style="border: 1px solid #222; padding:  10px 5px; width: 20%;">SIGN</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="6">Accepted</td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="4">Blow Hole</td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="3">RMI</td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;" rowspan="3">Rejected</td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #222; padding:  10px 5px;">RMR</td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                    <td style="border: 1px solid #222; padding:  10px 5px;"></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="display: flex; align-items: start; flex-direction: column; gap: 20px; width: 98%; max-width: 1100px; margin: 30px auto;">
        <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;">Dispatch</h3>
        <table style="text-align:center; width: 100%; border-collapse: collapse; font-size: 15px; margin-bottom: 10px;">
            <tr>
                <th style="border: 1px solid #222; padding: 4px;">Date</th>
                <th style="border: 1px solid #222; padding: 4px;">Our Dc No</th>
                <th style="border: 1px solid #222; padding: 4px;">Quantity</th>
                <th style="border: 1px solid #222; padding: 4px;">Signature</th>
                <th style="border: 1px solid #222; padding: 4px;">Vehicle No</th>
                <th style="border: 1px solid #222; padding: 4px;">Remarks</th>
            </tr>
            <tr>
                <td style="border: 1px solid #222; padding: 4px; text-align: center;">1</td>
                <td style="border: 1px solid #222; padding: 4px;"></td>
                <td style="border: 1px solid #222; padding: 4px;"> </td>
                <td style="border: 1px solid #222; padding: 4px;"> </td>
                <td style="border: 1px solid #222; padding: 4px;"></td>
                <td style="border: 1px solid #222; padding: 4px;"></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>
    <div class="modal fade" id="routeUpl" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Route Card Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="rc_upload_form" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="file" name="image" class="form-control" id="rc_file" accept=".jpg,.jpeg,.png" required>
                        <input type="hidden" name="manufacture_id" id="manufacture_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn">Upload</button>
                        <button type="button" class="btn bg-second-btn" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/addManufactures.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/genchat.js'; ?>"></script>
<script src="<?php echo $baseURL . 'frequent_changing/js/manufacture.js'; ?>"></script>
<script>
    $(document).on("click", "#route_add", function(e) {
        let manufacture_id = $(this).data('id');
        $("#manufacture_id").val(manufacture_id);
    });
    $(document).on('change', "#rc_file", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#rc_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="rc_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="rc_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('#rc_upload_form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let hidden_cancel = $("#hidden_cancel").val();
        let hidden_ok = $("#hidden_ok").val();
        $.ajax({
            url: "<?php echo e(route('route-card-upload')); ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#routeUpl').modal('hide');
                alert("File Uploaded Successfully!");
                location.reload();
            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Upload failed.";
                alert(errMsg);
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/manufacture/route_card.blade.php ENDPATH**/ ?>