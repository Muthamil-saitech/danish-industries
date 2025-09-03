
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
                <h5 class="mb-0">Total Delivery Challan List: <?php echo e($total_dc); ?> </h5>
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
                            <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.challan_date'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.challan_no'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.doc_no'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.customer'); ?></th>
                            
                            
                            
                            
                            <th class="width_10_p"><?php echo app('translator')->get('index.status'); ?></th>
                            <th class="width_1_p"><?php echo app('translator')->get('index.actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($obj && !empty($obj)): ?>
                        <?php
                        $i = 1;
                        ?>
                        <?php endif; ?>
                        <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="c_center"><?php echo e($i++); ?></td>
                            <td><?php echo e(getDateFormat($value->challan_date)); ?></td>
                            <td><?php echo e($value->challan_no); ?></td>
                            <td><?php echo e($value->material_doc_no); ?></td>
                            <td><?php echo e(getCustomerNameById($value->customer_id)); ?></td>
                            
                            
                            
                            
                            <td>
                                <select name="challan_status" class="form-control select2 challan-status" data-id="<?php echo e($value->id); ?>" <?php echo e(in_array($value->challan_status, ["3"]) ? 'disabled' : ''); ?> style="width: 100px;">
                                    <option value="1" <?php echo e($value->challan_status == "1" ? 'selected' : ''); ?><?php echo e($value->challan_status =="2" ? "disabled" : ""); ?>>Pending</option>
                                    <option value="2" <?php echo e($value->challan_status == "2" ? 'selected' : ''); ?>>Progress</option>
                                    <option value="3" <?php echo e($value->challan_status == "3" ? 'selected' : ''); ?>>Verified</option>
                                </select>
                                <div class="challan-status-msg"></div>
                            </td>
                            <td>
                                <div class="d-flex items-start justify-start" id="dc_qc_msg">
                                    <?php if($value->challan_status!="3"): ?>
                                    <button id="dc_qc_add" data-bs-toggle="modal" data-challan_id="<?php echo e($value->id); ?>" data-bs-target="#dcQcScheduling" class="btn bg-blue-btn w-20" title="QC Check" type="button"><i class="fa fa-list-check"></i></button>&nbsp;
                                    <?php endif; ?>
                                    <button id="dc_qc_view" data-bs-toggle="modal" data-challan_id="<?php echo e($value->id); ?>" data-bs-target="#dcQcView" class="btn bg-blue-btn w-20" title="QC Assignment History" type="button"><i class="fa fa-user"></i></button>&nbsp;
                                    <a href="<?php echo e(url('quotation')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.view_details'); ?>"><i class="fa fa-eye"></i></a>
                                    <?php if(routePermission('quotations.edit') && $value->challan_status!="3"): ?>
                                    <a href="<?php echo e(url('quotation')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit" class="button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit"></i></a>
                                    <?php endif; ?>
                                    
                                    <?php if(routePermission('quotations.delete') && $value->challan_status!="3"): ?>
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete<?php echo e($value->id); ?>" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.delete'); ?>">
                                        <form action="<?php echo e(route('quotation.destroy', $value->id)); ?>"
                                            class="alertDelete<?php echo e($value->id); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>
<div class="modal fade" id="dcQcScheduling" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.qc'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <form id="dc_qc_form">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.assign_to'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['qc_user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                    name="qc_user_id" id="qc_user_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php if(isset($qc_employees) && $qc_employees): ?>
                                    <?php $__currentLoopData = $qc_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($emp->id); ?>">
                                        <?php echo e($emp->name); ?>(<?php echo e($emp->emp_code); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <p class="text-danger qc_user_error"></p>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.start_date'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="start_date"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="qc_start_date" placeholder="Start Date">
                                <p class="text-danger start_date_error"></p>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.complete_date'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="complete_date"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="qc_complete_date" placeholder="Complete Date">
                                <p class="text-danger end_date_error"></p>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.note'); ?> </label>
                                <textarea name="qc_note" id="qc_note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Note" maxlength="100"></textarea>
                                <input type="hidden" name="challan_id" id="challan_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn dc_qc_scheduling_btn"><iconify-icon
                            icon="solar:check-circle-broken"></iconify-icon>
                        <?php echo app('translator')->get('index.add'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="dcQcView" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">QC Assignment History</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" id="qc_dc_log_modal_body">

                </div>
            </div>
            <input type="hidden" name="challan_id" id="qc_challan_id">
        </div>
    </div>
</div>
<div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.dc_list'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php echo Form::model('', [
                'id' => 'add_form',
                'method' => 'GET',
                'enctype' => 'multipart/form-data',
                'route' => ['quotation.index'],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'quote_start_date']); ?>

                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'quote_complete_date']); ?>

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
                        <a href="<?php echo e(route('quotation.index')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('top_script'); ?>
<script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'; ?>"></script>
<?php $__env->stopPush(); ?>
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
    $("#qc_user_id").select2({
        dropdownParent: $("#dcQcScheduling"),
    });
    $("#customer_id").select2({
        dropdownParent: $("#filterModal"),
    });

    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#qc_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#qc_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#qc_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#qc_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#qc_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#qc_start_date').val();

        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#qc_complete_date').datepicker('update', startDate);
            }
        }
    });
    const existingQCStartDate = $('#qc_start_date').val();
    if (existingQCStartDate) {
        const startDate = parseDMYtoDate(existingQCStartDate);
        $('#qc_complete_date').datepicker('setStartDate', startDate);

        const completeDateVal = $('#qc_complete_date').val();
        if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
            $('#qc_complete_date').datepicker('update', startDate);
        }
    }
    $('#quote_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#quote_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#quote_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#quote_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#quote_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#quote_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#quote_complete_date').datepicker('update', startDate);
            }
        }
    });
    $(document).on("click", "#dc_qc_add", function(e) {
        let challan_id = $(this).data('challan_id');
        $("#challan_id").val(challan_id);
    });
    $('.dc_qc_scheduling_btn').on('click', function(e) {
        e.preventDefault();
        $('.qc_user_error, .start_date_error, .end_date_error').text('');
        let qcUserId = $('#qc_user_id').val().trim();
        let startDate = $('#qc_start_date').val().trim();
        let completeDate = $('#qc_complete_date').val().trim();
        let challanId = $('#challan_id').val().trim();
        let qc_note = $('#qc_note').val().trim();
        let isValid = true;
        if (!qcUserId) {
            $('.qc_user_error').text('Assign To is Required.');
            isValid = false;
        }
        if (!startDate) {
            $('.start_date_error').text('Start date is Required.');
            isValid = false;
        }
        if (!completeDate) {
            $('.end_date_error').text('Complete date is Required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "updateDcQcAssign",
            data: {
                "csrf-token": $("[name='csrf-token']").attr("content"),
                qc_user_id: qcUserId,
                start_date: startDate,
                complete_date: completeDate,
                challan_id: challanId,
                qc_note: qc_note
            },
            dataType: "json",
            success: function(response) {
                const modalEl = document.getElementById('dcQcScheduling');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                $("#dc_qc_msg").after('<p id="qc_response_msg" class="text-success mt-2">QC added successfully.</p>');
                setTimeout(function() {
                    $('#qc_response_msg').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function() {},
        });
    });
    $(document).on("click", "#dc_qc_view", function(e) {
        e.preventDefault();
        let hidden_base_url = $("#hidden_base_url").val();
        let challan_id = $(this).data('challan_id');
        $("#qc_challan_id").val(challan_id);
        let qc_challan_id = $("#qc_challan_id").val();
        let requestData = {
            qc_challan_id: qc_challan_id ?? '',
        }
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getDCQCAssignLog",
            data: requestData,
            dataType: "json",
            success: function(data) {
                let table = '';
                if (data.length === 0) {
                    table += '<tr><td colspan="4" class="text-center text-danger">No QC Assigned.</td></tr>';
                } else {
                    table += '<div class="d-flex justify-content-between"><div class="d-flex flex-column align-items-start ms-2"><h5 class="modal-title">' + data[0].challan_no + '</h5><div><small>Challan No</small></div></div><div id="challan_sts_wrapper" class="form-check mb-1"><input class="form-check-input challan_status" type="checkbox" id="chl_status"' + (data[0].challan_status === 3 ? "checked disabled" : "") + '><label class="form-check-label" for="chl_status">Verified</label><p class="text-success d-none" id="check-msg">Checked!</p></div></div><hr><table class="table table-bordered table-striped"><thead><tr><th>Employee Name</th><th>Start Date</th><th>Complete date</th><th>Note</th></tr></thead><tbody>';
                    for (let i = 0; i < data.length; i++) {
                        table +=
                            "<tr><td>" +
                            data[i].emp_name +
                            "</td><td>" +
                            data[i].start_date +
                            "</td><td>" +
                            data[i].end_date +
                            "</td><td>" +
                            data[i].note +
                            "</td></tr>";
                        table +=
                            '<input type="hidden" name="id[]" value="' +
                            data[i].id +
                            '">';
                    }
                }
                table += "</tbody></table>";
                $("#qc_dc_log_modal_body").html(table);
            },
            error: function() {},
        });
    });
    $(document).on("change", ".challan_status", function(e) {
        const checkbox = this;
        let qc_challan_id = $("#qc_challan_id").val();
        $.ajax({
            type: "POST",
            url: $("#hidden_base_url").val() + "updateVerifiedStatus",
            data: {
                qc_challan_id: qc_challan_id,
                challan_status: '3'
            },
            dataType: "json",
            success: function(data) {
                $(checkbox).prop('disabled', true).prop('checked', true);
                $('#check-msg').removeClass('d-none').fadeIn();
                setTimeout(() => {
                    $('#check-msg').fadeOut(() => {
                        $('#check-msg').addClass('d-none');
                        location.reload();
                    });
                }, 3000);
            },
            error: function() {}
        });
    });
    $(document).on("change", ".challan-status", function(e) {
        let $this = $(this);
        let status = $this.val();
        let challan_id = $this.data("id");
        let $statusMsg = $this.closest('td').find('.challan-status-msg');
        $.ajax({
            type: "POST",
            url: $("#hidden_base_url").val() + "updateChallanStatus",
            data: {
                challan_id: challan_id,
                status: status
            },
            dataType: "json",
            success: function(data) {
                $statusMsg.html('<span class="text-success">' + data.message + '</span>')
                    .delay(3000)
                    .fadeOut();
                location.reload();
            },
            error: function() {
                $statusMsg.html('<span class="text-danger">Something went wrong.</span>')
                    .delay(2000)
                    .fadeOut();
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/quotation/index.blade.php ENDPATH**/ ?>