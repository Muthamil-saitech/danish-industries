
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
<input type="hidden" id="edit_mode" value="<?php echo e(isset($obj) && $obj ? $obj->id : null); ?>">
<section class="main-content-wrapper">
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <button id="report_file_upl" data-bs-toggle="modal" data-ins_id="<?php echo e(isset($inspection) ? $inspection->id : ''); ?>"  data-manufacture_id="<?php echo e($manufacture->id); ?>" data-bs-target="#insReportUpl" class="btn bg-second-btn" title="Inspection Report Form Upload" type="button"><i class="fa-regular fa-circle-up"></i>&nbsp;Upload</button>
                <button type="button"
                    class="btn bg-warning text-white final_inspect_btn"
                    data-bs-toggle="modal"
                    data-bs-target="#checkedPersonModal"
                    data-id="<?php echo e($manufacture->id); ?>"
                    <?php echo e((!empty($inspection_approval) && is_object($inspection_approval) && $inspection_approval->status == '2') || (isset($inspection) && count($inspection->details)==0) ? 'disabled' : ''); ?>>
                    <i class="fa-regular fa-circle-check" data-bs-toggle="tooltip" data-bs-placement="top" title="Inspection Approval"></i>&nbsp;Approval
                </button>
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_inspection" data-id="<?php echo e($manufacture->id); ?>"><iconify-icon icon="solar:printer-broken"></iconify-icon><?php echo app('translator')->get('index.print'); ?></a>
                
                <?php if(routePermission('inspection-generate.index')): ?>
                <a class="btn bg-second-btn" href="<?php echo e(route('inspection-generate.index')); ?>"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            <?php if(isset($latest_form) && $latest_form!=''): ?>
            <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
                <div class="text-center">
                    <img src="<?php echo getBaseURL() .
                                (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid mb-2">
                </div>
                <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;"><?php echo e(isset($title) && $title ? strtoupper($title) : ''); ?></p>
                <img src="<?php echo e($baseURL); ?>uploads/inspection_report_files/<?php echo e($latest_form); ?>" alt="inspection report file" class="img-fluid">
            </div>
            <?php else: ?>
            <div style="max-width: 1200px; margin: 30px auto; ">
                <div style="text-align: center; border-bottom: 1px solid #000; padding: 10px;">
                    <img src="<?php echo getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png'); ?>" alt="Logo Image" class="img-fluid mb-2">
                    <h3 style="font-weight: 700; text-decoration: underline; font-size: 20px; padding-bottom: 15px;">INSPECTION REPORT</h3>
                    <form style="display: flex; justify-content: center; gap: 30px; align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px; border-radius: 0px;" disabled <?php echo e($di_inspect_dimensions->count() > 0 && !is_object($inspection_approval) ? 'checked' : ''); ?>>
                            <label style="font-size: 20px;"> In-Process</label>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px;" disabled <?php echo e(is_object($inspection_approval) && $inspection_approval->status == '2' ? 'checked' : ''); ?>>
                            <label style="font-size: 20px;"> Final</label>
                        </div>
                    </form>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: start; padding: 10px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">CUSTOMER <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;"><?php echo e(getCustomerNameById($manufacture->customer_id)); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART NAME <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;"><?php echo e(isset($finishProduct) ? $finishProduct->name : ''); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART No. <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;"><?php echo e(isset($finishProduct) ? $finishProduct->code : ''); ?></p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DRG No. <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($finishProduct->drawer_no); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">REV <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($finishProduct->rev); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">OPERATION <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($finishProduct->operation); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PoNo <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e(getPoNo($manufacture->customer_order_id)); ?></p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">MATERIAL <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e(materialName($manufacture->rawMaterials[0]->rmaterials_id).'-'.($material->code)); ?> <?php echo e($material->diameter!='' ? 'DIA '.$material->diameter : ''); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Total Quantity <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($manufacture->product_quantity); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Sample Quantity <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($manufacture->product_quantity); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Heat No. <span>:</span> </span><p style="margin: 5px;"><?php echo e(getheatNo($manufacture->rawMaterials[0]->rmaterials_id)); ?></p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Report No. <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e('IR' . str_pad($manufacture->id, 4, '0', STR_PAD_LEFT)); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Date <span>:</span> </span>
                            <p style="margin: 5px;"> <?php echo e(date('d/m/Y')); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DC No. <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($material_stock->dc_no); ?></p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PPCRCNo. <span>:</span> </span>
                            <p style="margin: 5px;"><?php echo e($manufacture->reference_no); ?></p>
                        </div>
                    </div>
                </div>
                <div style="border:1px solid #000; border-top: none;">
                    <table style="width:100%; border-collapse:collapse; font-size:16px;">
                        <tr style="text-align:center;">
                            <th style='border: 1px solid #000; border-left: none;'>Sl.No</th>
                            <th style='border: 1px solid #000; padding: 10px;'>PARAMETER</th>
                            <th style='border: 1px solid #000; padding: 10px;'>DRAWING <br> SPEC.</th>
                            <th style='border: 1px solid #000; padding: 10px;'>INSP. <br>METHOD</th>
                            <?php $__currentLoopData = $di_inspect_dimensions->unique('set_no'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dimension): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="border: 1px solid #000; padding: 5px;">DBF <?php echo e(str_pad($displaySetNos[$dimension->set_no], 3, '0', STR_PAD_LEFT)); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </tr>
                        <?php if(isset($inspection) && $inspection && isset($inspection->details) && count($inspection->details) > 0): ?>
                            <tr>
                                <th></th>
                                <th colspan="<?php echo e(3 + $di_inspect_dimensions->unique('set_no')->count()); ?>" style="text-align: start; padding: 10px 7px;">Dimension Inspection</th>
                            </tr>
                            <?php $__currentLoopData = $inspection->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value->di_param != ''): ?>
                                    <tr>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px; border-left: none;"><?php echo e($loop->iteration); ?></td>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;"><?php echo e($value->di_param); ?></td>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;"><?php echo e($value->di_spec); ?></td>
                                        <td style="text-align: center; width: 80px; border: 1px solid #000; padding: 10px 7px;"><?php echo e($value->di_method != '' ? $value->di_method : '-'); ?></td>
                                        <?php $__currentLoopData = $di_inspect_dimensions->unique('set_no'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td style="width: 80px; border: 1px solid #000;">
                                                <?php echo e($di_inspect_dimensions->where('set_no', $setNo->set_no)->where('inspect_param_id', $value->id)->first()->di_observed_dimension ?? ''); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th></th>
                                <th colspan="<?php echo e(3 + $ap_inspect_dimensions->unique('set_no')->count()); ?>" style="text-align: start; padding: 10px 7px;">Appearance Inspection</th>
                            </tr>
                            <?php $__currentLoopData = $inspection->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value->ap_param != ''): ?>
                                    <tr>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px; border-left: none;"><?php echo e($loop->iteration); ?></td>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px;"><?php echo e($value->ap_param); ?></td>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px;"><?php echo e($value->ap_spec); ?></td>
                                        <td style="text-align: center; border: 1px solid; padding: 10px 7px; width: 80px;"><?php echo e($value->ap_method != '' ? $value->ap_method : '-'); ?></td>
                                        <?php $__currentLoopData = $ap_inspect_dimensions->unique('set_no'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td style="width: 80px; border: 1px solid #000;">
                                                <?php echo e($ap_inspect_dimensions->where('set_no', $setNo->set_no)->where('inspect_param_id', $value->id)->first()->ap_observed_dimension ?? ''); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </table>
                    <div style="display: flex; justify-content: space-around;">
                        <div style="padding-top: 5px;">
                            <p>INSPECTED BY</p>
                            <h5><?php echo e(!empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->inspected_by) : ''); ?></h5><br>
                        </div>
                        <div style="padding-top: 5px;">
                            <p>CHECKED BY</p>
                            <h5><?php echo e(!empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->checked_by) : ''); ?></h5><br>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        <?php if($currentPage > 1): ?>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $currentPage - 1])); ?>" style="margin-right: 10px;">&laquo; Previous</a>
                        <?php endif; ?>
                        <?php if($currentPage < ceil($totalSets / $perPage)): ?>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $currentPage + 1])); ?>">Next &raquo;</a>
                        <?php endif; ?>
                    </div>
                </div>
                <p style="padding-top: 30px; padding-bottom: 100px; font-size: 13px;"><b>Remarks</b>&nbsp;&nbsp;<?php echo e(!empty($inspection_approval) && is_object($inspection_approval) ? $inspection_approval->remarks : ''); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <div class="modal fade" id="checkedPersonModal" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Inspection Report Approval</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            data-feather="x"></i></button>
                </div>
                <form id="inspect_approval">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="manufacture_id" class="manufacture_id">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>Inspected By <span class="required_star">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['inspected_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="inspected_by" id="inspected_by">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($manage_users) && $manage_users): ?>
                                        <?php $__currentLoopData = $manage_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>">
                                            <?php echo e($user->name); ?>(<?php echo e($user->emp_code); ?>)
                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-danger inspected_user_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>Checked By <span class="required_star">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['checked_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="checked_by" id="checked_by">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($manage_users) && $manage_users): ?>
                                        <?php $__currentLoopData = $manage_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>">
                                            <?php echo e($user->name); ?>(<?php echo e($user->emp_code); ?>)
                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-danger checked_user_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>Remarks </label>
                                    <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control" maxlength="100"></textarea>
                                    <p class="text-danger remark_error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn"><?php echo app('translator')->get('index.update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="insReportUpl" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Inspection Report Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="ins_report_form" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="file" name="image" class="form-control" id="ins_rep_file" accept=".jpg,.jpeg,.png" required>
                        <input type="hidden" name="manufacture_id" id="manufacture_id" class="form-control">
                        <input type="hidden" name="ins_id" id="ins_id" class="form-control">
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
<script>
    let base_url = $("#hidden_base_url").val();
    $("#inspected_by").select2({
        dropdownParent: $("#checkedPersonModal"),
    });
    $("#checked_by").select2({
        dropdownParent: $("#checkedPersonModal"),
    });
    $(document).on("click", ".print_inspection", function() {
        viewInspectionReport($(this).attr("data-id"));
    });

    function viewInspectionReport(id) {
        open(
            base_url + "print_inspection/" + id,
            "Print Inspection Report",
            "width=1600,height=550"
        );
        newWindow.focus();
        newWindow.onload = function() {
            newWindow.document.body.insertAdjacentHTML("afterbegin");
        };
    }
    $(document).on("click", "#report_file_upl", function(e) {
        let ins_id = $(this).data('ins_id');
        $("#ins_id").val(ins_id);
        let manufacture_id = $(this).data('manufacture_id');
        $("#manufacture_id").val(manufacture_id);
    });
    $(document).on('change', "#ins_rep_file", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#ir_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="ir_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="ir_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('#ins_report_form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let hidden_cancel = $("#hidden_cancel").val();
        let hidden_ok = $("#hidden_ok").val();
        $.ajax({
            url: "<?php echo e(route('inspection-report-upload')); ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#insReportUpl').modal('hide');
                alert("File Uploaded Successfully!");
                location.reload();
            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Upload failed.";
                alert(errMsg);
            }
        });
    });
    $(document).on("click", ".final_inspect_btn", function() {
        let id = $(this).data("id");
        $(".manufacture_id").val(id);
    });
    $('#inspect_approval').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        $('.inspected_user_err').text('');
        $('.checked_user_err').text('');
        $('.remark_error').text('');
        const inspectedBy = $('#inspected_by').val();
        const checkedBy = $('#checked_by').val();
        const remarks = $('#remarks').val().trim();
        if (!inspectedBy) {
            $('.inspected_user_err').text('Inspected By field is required.');
            isValid = false;
        }
        if (!checkedBy) {
            $('.checked_user_err').text('Checked By field is required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        let formData = new FormData(this);
        $.ajax({
            url: "<?php echo e(route('updateInspectionApproval')); ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#checkedPersonModal').modal('hide');
                alert("Updated Successfully!");
                location.reload();

            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Something went wrong.";
                alert(errMsg);
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/inspection/inspectionGenerateDetail.blade.php ENDPATH**/ ?>