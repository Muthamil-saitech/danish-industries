
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
                    <h2 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h2>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="row mt-4">
                                <div class="table-box">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="ir_w_1"> <?php echo app('translator')->get('index.sn'); ?></th>
                                                    <th class="ir_w_16"><?php echo app('translator')->get('index.ppcrc_no'); ?></th>
                                                    <th class="ir_w_16"><?php echo app('translator')->get('index.production_stage'); ?></th>
                                                    <th class="ir_w_16"><?php echo app('translator')->get('index.employees'); ?></th>
                                                    <th class="ir_w_16"><?php echo app('translator')->get('index.material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                                    <th class="ir_w_16"><?php echo app('translator')->get('index.quantity'); ?></th>
                                                    <th class="ir_w_5"><?php echo app('translator')->get('index.actions'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $consumables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td class="ir_txt_center"><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($value->ppcrc_no ? $value->ppcrc_no : ''); ?></td>
                                                        <td>
                                                            <span class="badge bg-warning text-dark">
                                                                <?php echo e(getProductionStage($value->production_stage)); ?>

                                                            </span>
                                                        </td>
                                                        <td><?php echo e(getEmpCode($value->user_id)); ?></td>
                                                        <td><?php echo e(getRMName($value->mat_id)); ?></td>
                                                        <td><?php echo e($value->qty); ?></td>
                                                        <td>
                                                            <a class="button-success consumeBtn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#consumableModal"
                                                            data-id="<?php echo e($value->id); ?>"
                                                            data-production_stage="<?php echo e($value->production_stage); ?>"
                                                            data-manufacture_id="<?php echo e($value->manufacture_id); ?>"
                                                            data-ppcrc_no="<?php echo e($value->ppcrc_no); ?>"
                                                            data-user_id="<?php echo e($value->user_id); ?>"
                                                            data-mat_id="<?php echo e($value->mat_id); ?>"
                                                            data-qty="<?php echo e($value->qty); ?>"
                                                            title="Edit">
                                                                <i class="fa fa-edit tiny-icon"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">No consumables added.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="consumableModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.edit_consumable'); ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="consumableForm">
                            <div class="row">
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('index.production_stage'); ?> </label>
                                        <input type="hidden" name="consumable_id" id="consumable_id">
                                        <input type="hidden" name="manufacture_id" id="manufacture_id">
                                        <input type="hidden" name="ppcrc_no" id="ppcrc_no">
                                        <select name="production_stage" id="production_stage" class="form-control <?php $__errorArgs = ['production_stage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            <?php $__currentLoopData = $m_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($stage->productionstage_id); ?>"><?php echo e(getProductionStages($stage->productionstage_id)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <p class="text-danger stage_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('index.employees'); ?> </label>
                                        <select name="user_id" id="user_id" class="form-control <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            
                                        </select>
                                        <p class="text-danger user_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('index.material_name'); ?> (Code) <span class="required_star">*</span></label>
                                        <select name="mat_id" id="mat_id" class="form-control <?php $__errorArgs = ['mat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            <?php $__currentLoopData = $consumable_materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($material->id); ?>"><?php echo e(getRMName($material->id)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <p class="text-danger mat_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('index.quantity'); ?> <span class="required_star">*</span></label>
                                        <input type="text" name="qty" id="qty" class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo app('translator')->get('index.quantity'); ?>">
                                        <p class="text-danger qty_err"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn consume_edit_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.submit'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js'; ?>"></script>
    <script>
    $('#production_stage').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#user_id').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#mat_id').select2({
        dropdownParent: $('#consumableModal')
    });
    $(document).on("click", ".consumeBtn", function () {
        let id = $(this).data("id");
        let stage = $(this).data("production_stage");
        let user = $(this).data("user_id");
        let mat = $(this).data("mat_id");
        let qty = $(this).data("qty");
        let manufacture_id = $(this).data("manufacture_id");
        let ppcrc_no = $(this).data("ppcrc_no");
        $("#mat_id").val(mat).trigger("change");
        $("#qty").val(qty);
        $("#manufacture_id").val(manufacture_id);
        $("#ppcrc_no").val(ppcrc_no);
        $("#consumable_id").val(id);
        $("#user_id").data("selected", user);
        $("#production_stage").val(stage).trigger("change");
    });
    $(document).on("change", "#production_stage", function () {
        let production_stage = $(this).find(":selected").val();
        let manufacture_id = $("#manufacture_id").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getTaskPerson",
            data: { production_stage: production_stage, manufacture_id: manufacture_id },
            dataType: "json",
            success: function (data) {
                let users = data;
                let select = $("#user_id");
                select.empty();
                select.append('<option value="">Select</option>');
                users.forEach(function (user) {
                    if (user) {
                        let id = user.id;
                        let name = user.name;
                        let code = user.emp_code ?? '';
                        select.append('<option value="' + id + '">' + name + ' (' + code + ')' + '</option>');
                    }
                });
                let selectedUser = select.data("selected");
                if (selectedUser) {
                    select.val(selectedUser).trigger("change");
                }
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    });
    $(document).on("click", ".consume_edit_btn", function (e) {
        e.preventDefault();
        let status = true;
        let hidden_base_url = $("#hidden_base_url").val();
        let consumable_id = $("#consumable_id").val();
        let manufacture_id = $("#manufacture_id").val();
        let production_stage = $("#production_stage").val();
        let user_id = $("#user_id").val();
        let mat_id = $("#mat_id").val();
        let qty = $("#qty").val();
        if(production_stage != "" && user_id == "") {
            $(".user_err").text("If Production Stage is selected, then select Task Person.");
            status = false;
        } else {
            $(".user_err").text("");
        }
        if(mat_id == "") {
            $(".mat_err").text("The Material Name field is required");
            status = false;
        } else {
            $(".mat_err").text("");
        }
        if(qty == "") {
            $(".qty_err").text("The Quantity field is required");
            status = false;
        } else {
            $(".qty_err").text("");
        }
        if(status==false){
            return false;
        }
        $.ajax({
            type: "PUT",
            url: hidden_base_url + "consumable/" + consumable_id,
            data: $("#consumableForm").serialize(),
            success: function (data) {
                const modalEl = document.getElementById('consumableModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                let hidden_alert = data.status ? "Success" : "Error";
                let hidden_cancel = $("#hidden_cancel").val();
                let hidden_ok = $("#hidden_ok").val();
                swal({
                    title: hidden_alert + "!",
                    text: data.message,
                    cancelButtonText: hidden_cancel,
                    confirmButtonText: hidden_ok,
                    confirmButtonColor: "#3c8dbc",
                }, function () {
                    location.reload();
                });
            },
            error: function () {},
        });
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/consumable/detail.blade.php ENDPATH**/ ?>