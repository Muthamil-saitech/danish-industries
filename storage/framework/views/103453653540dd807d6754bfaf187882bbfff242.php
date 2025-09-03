
<?php $__env->startSection('content'); ?>
<?php
$baseURL = getBaseURL();
$setting = getSettingsInfo();
$base_color = '#6ab04c';
if (isset($setting->base_color) && $setting->base_color) {
    $base_color = $setting->base_color;
}
?>
<section class="main-content-wrapper">
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h2>
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Inspection Report: <?php echo e($total_ins_reports); ?> </h5>
            </div>
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="ir_w_1"> <?php echo app('translator')->get('index.sn'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.ppcrc_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.drg_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.part_name'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.part_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.po_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.customer_name'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.start_date'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.delivery_date'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.status'); ?></th>
                            <th class="ir_w_1 ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($manufactures && !empty($manufactures)): ?>
                        <?php $__currentLoopData = $manufactures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $prodInfo = getFinishedProductInfo($value->product_id); ?>
                        <tr>
                            <td class="ir_txt_center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($value->reference_no); ?></td>
                            <td><?php echo e($value->drawer_no); ?></td>
                            <td><?php echo e($prodInfo->name); ?></td>
                            <td><?php echo e($prodInfo->code); ?></td>
                            <td><?php echo e(getPoNo($value->customer_order_id)); ?></td>
                            <td><?php echo e(getCustomerNameById($value->customer_id).' ('.getCustomerCodeById($value->customer_id).')'); ?></td>
                            <td><?php echo e(getDateFormat($value->start_date)); ?></td>
                            <td><?php echo e($value->complete_date!='' ? getDateFormat($value->complete_date) : ' - '); ?></td>
                            <td>
                                <?php if(is_object($value->inspect_approval) && $value->inspect_approval!=null && $value->inspect_approval->status == 2): ?>
                                <span class="text-success">Final</span>
                                <?php elseif(is_object($value->inspect_approval) && $value->inspect_approval!=null && $value->inspect_approval->status == 1): ?>
                                <span class="text-info">In Process</span>
                                <?php else: ?>
                                <span class="text-danger">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('inspection-generate')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo app('translator')->get('index.view_details'); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <?php if((!$value->inspect_approval) || (is_object($value->inspect_approval) && $value->inspect_approval->status < 2)): ?>
                                    <a href="javascript:void(0)" class="button-success inspection_dimension"
                                    data-bs-toggle="modal" data-bs-target="#inspectionDimensionModal"
                                    data-id="<?php echo e($value->id); ?>"><i class="fa-regular fa-circle-check" data-bs-toggle="tooltip" data-bs-placement="top" title="Inspection Dimension"></i></a>
                                    <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="inspectionDimensionModal" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Inspection Observed Dimensions </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            data-feather="x"></i></button>
                </div>
                <form action="<?php echo e(route('inspect.updateInspectionDimension')); ?>" id="inspect_dimension" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p class="text-danger" id="dimension_msg"></p>
                        <input type="hidden" name="manufacture_id" class="manufacture_id">
                        <div id="dimension_inspection_table"></div>

                        <div id="appearance_inspection_table"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn di_modal_submit" disabled><?php echo app('translator')->get('index.update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.inspect_list'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['inspection-generate.index'],
                    ]); ?>

                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'ir_start_date']); ?>

                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'ir_complete_date']); ?>

                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer'); ?> </label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php if(isset($customer_id)): ?>
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>"
                                        <?php echo e(isset($customer_id) && $customer_id == $value->id ? 'selected' : ''); ?>>
                                        <?php echo e($value->name); ?> (<?php echo e($value->customer_id); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn w-100 bg-blue-btn"><?php echo app('translator')->get('index.submit'); ?></button>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="<?php echo e(route('inspection-generate.index')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo $baseURL . 'assets/datatable_custom/jquery-3.3.1.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/dataTables.bootstrap4.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/dataTables.buttons.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/buttons.html5.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/buttons.print.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/jszip.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/pdfmake.min.js'; ?>"></script>
<script src="<?php echo $baseURL . 'assets/dataTable/vfs_fonts.js'; ?>"></script>
<script src="<?php echo $baseURL . 'frequent_changing/newDesign/js/forTable.js'; ?>"></script>
<script src="<?php echo $baseURL . 'frequent_changing/js/custom_report.js'; ?>"></script>
<script>
    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#ir_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#ir_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#ir_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#ir_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#ir_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#ir_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#ir_complete_date').datepicker('update', startDate);
            }
        }
    });
    $("#customer_id").select2({
        dropdownParent: $("#filterModal"),
    });
    $(document).on("click", ".inspection_dimension", function() {
        let id = $(this).data("id");
        let base_url = $("#hidden_base_url").val();
        $(".manufacture_id").val(id);
        $.ajax({
            url: base_url + "getInspectionParams",
            type: "POST",
            data: {
                "csrf-token": $("[name='csrf-token']").attr("content"),
                id: id,
            },
            success: function(response) {
                console.log(response);
                let dimensionRows = '';
                let appearanceRows = '';
                let diIndex = 1;
                let apIndex = 1;
                if (response.length != 0) {
                    $(".di_modal_submit").prop("disabled", false);
                    response.forEach((item) => {
                        if (item.di_param) {
                            dimensionRows += `
                                    <tr>
                                        <td>${diIndex++}</td>
                                        <td><input type="hidden" name="inspect_id[]" value="${item.inspect_id}">${item.di_param}</td>
                                        <td><input type="hidden" name="ins_param_id[]" value="${item.id}">${item.di_spec}</td>
                                        <td><input type="text" name="di_observed[]" class="form-control" maxlength="20"/></td>
                                    </tr>
                                `;
                        }
                        if (item.ap_param) {
                            appearanceRows += `
                                    <tr>
                                        <td>${apIndex++}</td>
                                        <td><input type="hidden" name="ap_inspect_id[]" value="${item.inspect_id}">${item.ap_param}</td>
                                        <td><input type="hidden" name="ap_param_id[]" value="${item.id}">${item.ap_spec || ''}</td>
                                        <td><input type="text" name="ap_observed[]" class="form-control" maxlength="20"/></td>
                                    </tr>
                                `;
                        }
                    });
                    const diTable = `
                            <h5>Dimension Inspection</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Parameter</th>
                                        <th>Drawing Spec</th>
                                        <th>Observed Dimension</th>
                                    </tr>
                                </thead>
                                <tbody>${dimensionRows}</tbody>
                            </table>
                        `;
                    const apTable = `
                            <h5 class="mt-3">Appearance Inspection</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Parameter</th>
                                        <th>Drawing Spec</th>
                                        <th>Observed Dimension</th>
                                    </tr>
                                </thead>
                                <tbody>${appearanceRows}</tbody>
                            </table>
                        `;
                    $('#dimension_inspection_table').html(diTable);
                    $('#appearance_inspection_table').html(apTable);
                    $('#inspectionDimensionModal').modal('show');
                } else {
                    $('#dimension_inspection_table').html('<p class="text-danger">No Inspection Parameters found.</p>');
                    $('#appearance_inspection_table').html('');
                    $(".di_modal_submit").prop("disabled", true);
                }
            },
        });
    });
    $(document).on('submit', '#inspect_dimension', function(e) {
        let hasEmptyDimension = false;
        let hasEmptyAppearance = false;
        $("#dimension_msg").text('');
        $('input[name="di_observed[]"]').each(function() {
            if ($(this).val().trim() === '') {
                hasEmptyDimension = true;
                return false;
            }
        });
        $('input[name="ap_observed[]"]').each(function() {
            if ($(this).val().trim() === '') {
                hasEmptyAppearance = true;
                return false;
            }
        });
        if (hasEmptyDimension || hasEmptyAppearance) {
            e.preventDefault();
            $("#dimension_msg").text("All fields are required.");
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/inspection/inspectionGenerate.blade.php ENDPATH**/ ?>