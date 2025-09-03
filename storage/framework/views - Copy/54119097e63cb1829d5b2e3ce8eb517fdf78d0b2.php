
<?php $__env->startSection('script_top'); ?>
<?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="main-content-wrapper">
        <section class="content-header">
            <h3 class="top-left-header">
                <?php echo e(isset($title) && $title ? $title : ''); ?>

            </h3>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'inspectionForm',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['inspections.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.mat_type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="mat_type" id="mat_type">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <option <?php echo e((isset($obj->mat_type) && $obj->mat_type == 1) || old('mat_type') == 1 ? 'selected' : ''); ?> value="1">Raw Material</option>
                                    
                                </select>
                                <p class="text-danger mat_type_err"></p>
                                <?php $__errorArgs = ['mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.material_name'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['mat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="mat_id" id="mat_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e((isset($obj->mat_id) && $obj->mat_id == $material->id) || old('mat_id') == $material->id ? 'selected' : ''); ?> value="<?php echo e($material->id); ?>"><?php echo e($material->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-danger mat_err"></p>
                                <?php $__errorArgs = ['mat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.material_code'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="mat_code" id="mat_code" class="form-control <?php $__errorArgs = ['mat_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo app('translator')->get('index.material_code'); ?>" value="<?php echo e(isset($obj) && $obj->mat_code ? $obj->mat_code : old('mat_code')); ?>" readonly>
                                <p class="text-danger mat_code_err"></p>
                                <?php $__errorArgs = ['mat_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.drawer_no'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['drawer_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="drawer_no" id="drawer_no">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $drawers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drawer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e((isset($obj->drawer_id) && $obj->drawer_id == $drawer->id) || old('drawer_no') == $drawer->id ? 'selected' : ''); ?> value="<?php echo e($drawer->id); ?>"><?php echo e($drawer->drawer_no); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-danger drawer_no_err"></p>
                                <?php $__errorArgs = ['drawer_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-0">Dimension Inspection</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-center"><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th class="w-5 text-center">Parameter <span class="required_star">*</span></th>
                                            <th class="w-5 text-center">Drawing Specification <span class="required_star">*</span></th>
                                            <th class="w-5 text-center">Inspection Method</th>
                                            <th class="w-5 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_di_ins">
                                        <?php if(isset($inspectParams) && !empty($inspectParams)): ?>
                                            <?php $__currentLoopData = $inspectParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $isEmpty = empty($value->di_param);
                                                ?>
                                                <?php if(!$isEmpty): ?>
                                                    <tr class='rowDiCount'>
                                                        <td class='text-center'><?php echo e($loop->iteration); ?></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="di_param[]" maxlength='30' value="<?php echo e($value->di_param); ?>"></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="di_spec[]" maxlength='100' value="<?php echo e($value->di_spec); ?>"></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="di_method[]" maxlength='100' value="<?php echo e($value->di_method); ?>"></td>
                                                        <td class='text-center'>
                                                            <a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <button id="di_param_add" class="btn btn-xs bg-blue-btn mt-2"
                                    type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <h4 class="mb-0">Appearance Inspection</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-center"><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th class="w-5 text-center">Parameter <span class="required_star">*</span></th>
                                            <th class="w-5 text-center">Drawing Specification <span class="required_star">*</span></th>
                                            <th class="w-5 text-center">Inspection Method</th>
                                            <th class="w-5 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_ap_ins">
                                        <?php if(isset($inspectParams) && !empty($inspectParams)): ?>
                                            <?php $__currentLoopData = $inspectParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $isEmpty = empty($value->ap_param);
                                                ?>
                                                <?php if(!$isEmpty): ?>
                                                    <tr class='rowDiCount'>
                                                        <td class='text-center'><?php echo e($loop->iteration); ?></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="ap_param[]" maxlength='30' value="<?php echo e($value->ap_param); ?>"></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="ap_spec[]" maxlength='100' value="<?php echo e($value->ap_spec); ?>"></td>
                                                        <td class='text-center'><input type="text" class="form-control" name="ap_method[]" maxlength='100' value="<?php echo e($value->ap_method); ?>"></td>
                                                        <td class='text-center'>
                                                            <a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <button id="ap_param_add" class="btn btn-xs bg-blue-btn mt-2"
                                    type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn submit_ins_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                        <a class="btn bg-second-btn" href="<?php echo e(route('inspections.index')); ?>"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script_bottom'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    // Initial numbering
    $(".add_di_ins tr").addClass("rowDiCount");
    $(".add_ap_ins tr").addClass("rowApCount");
    resetSerialNumbers(".rowDiCount");
    resetSerialNumbers(".rowApCount");
});
function resetSerialNumbers(selector) {
    $(selector).each(function(index) {
        $(this).find("td:first").text(index + 1);
    });
}
$(document).on("click", "#di_param_add", function () {
    let html = "<tr class='rowDiCount'>";
    html += "<td class='text-center'></td>"; // will be updated
    html += "<td><input type='text' name='di_param[]' class='form-control' maxlength='30'></td>";
    html += "<td><input type='text' name='di_spec[]' class='form-control' maxlength='100'></td>";
    html += "<td><input type='text' name='di_method[]' class='form-control' maxlength='100'></td>";
    html += '<td class="text-center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>';
    html += "</tr>";
    $(".add_di_ins").append(html);
    resetSerialNumbers(".add_di_ins .rowDiCount");
});
$(document).on("click", "#ap_param_add", function () {
    let html = "<tr class='rowApCount'>";
    html += "<td class='text-center'></td>"; // will be updated
    html += "<td><input type='text' name='ap_param[]' class='form-control'></td>";
    html += "<td><input type='text' name='ap_spec[]' class='form-control'></td>";
    html += "<td><input type='text' name='ap_method[]' class='form-control'></td>";
    html += '<td class="text-center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>';
    html += "</tr>";
    $(".add_ap_ins").append(html);
    resetSerialNumbers(".add_ap_ins .rowApCount");
});
/* $(document).on("change", "#mat_type", function () {
    let mat_type = $(this).val();
    $(".ins_type_err").text("");
    if(mat_type=="2") {
        $('#ins_type_div').show();
    } else {
       $('#ins_type_div').hide();
    }
    $('#ins_type').val("").trigger('change');
}); */
$(document).on("change","#mat_id", function () {
    let hidden_base_url = $("#hidden_base_url").val();
    let mat_id = $("#mat_id").val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: hidden_base_url + "getMaterialCode",
        data: { id: mat_id },
        success: function (data) {
            $("#mat_code").val(data.code);
        },
    });
});
$(document).on('submit', '#inspectionForm', function (e) {
    resetSerialNumbers(".rowDiCount");
    resetSerialNumbers(".rowApCount");
    let isValid = true;

    $('.is-invalid').removeClass('is-invalid');
    $('.heat_no_err, .drawer_no_err, .mat_code_err, .mat_err, .mat_type_err').text('');
    $('.add_di_ins .di-error-row, .add_ap_ins .ap-error-row').remove();

    let matType = $('#mat_type').val()?.trim() || '';
    // let insType = $('#ins_type').val()?.trim() || '';
    let matId   = $('#mat_id').val()?.trim() || '';
    let matCode = $('#mat_code').val()?.trim() || '';
    let drawNo  = $('#drawer_no').val()?.trim() || '';
    let heatNo  = $('#heat_no').val()?.trim() || '';

    // Field validation
    if (!matType) $(".mat_type_err").text("The Material Type field is required"), isValid=false;
    // if (matType=='2' && !insType) $(".ins_type_err").text("The Insert Type field is required"), isValid=false;
    if (!matId) $(".mat_err").text("The Material Name field is required"), isValid=false;
    if (!matCode) $(".mat_code_err").text("The Material Code field is required"), isValid=false;
    if (!drawNo) $(".drawer_no_err").text("The Drawing No field is required"), isValid=false;

    // Dimension inspection validation
    let diRows = $('.add_di_ins tr.rowDiCount');
    let diParamsSet = new Set();
    if (diRows.length < 1) {
        isValid = false;
        $('.add_di_ins').html('<tr class="di-error-row"><td colspan="5" class="text-danger text-center">At least one row is required.</td></tr>');
    } else {
        diRows.each(function () {
            const param = $(this).find('input[name="di_param[]"]').val();
            const spec = $(this).find('input[name="di_spec[]"]').val();
            if (!param || !spec) isValid = false;
            if (diParamsSet.has(param)) isValid=false;
            else diParamsSet.add(param);
        });
        if (!isValid && !$('.add_di_ins .di-error-row').length) {
            $('.add_di_ins').append('<tr class="di-error-row"><td colspan="5" class="text-danger text-center">All fields are required and no duplicates allowed.</td></tr>');
        }
    }
    let apRows = $('.add_ap_ins tr.rowApCount');
    let apParamsSet = new Set();
    if (apRows.length < 1) {
        isValid = false;
        $('.add_ap_ins').html('<tr class="ap-error-row"><td colspan="5" class="text-danger text-center">At least one row is required.</td></tr>');
    } else {
        apRows.each(function () {
            const param = $(this).find('input[name="ap_param[]"]').val();
            const spec = $(this).find('input[name="ap_spec[]"]').val();
            if (!param || !spec) isValid = false;
            if (apParamsSet.has(param)) isValid=false;
            else apParamsSet.add(param);
        });
        if (!isValid && !$('.add_ap_ins .ap-error-row').length) {
            $('.add_ap_ins').append('<tr class="ap-error-row"><td colspan="5" class="text-danger text-center">All fields are required and no duplicates allowed.</td></tr>');
        }
    }

    if (!isValid) e.preventDefault();
});

// Delete row and reset numbers
$(document).on("click", ".dlt_button", function () {
    const row = $(this).closest("tr");
    const parentTableBody = row.closest("tbody");
    row.remove();
    if (parentTableBody.hasClass("add_di_ins")) {
        resetSerialNumbers(".add_di_ins .rowDiCount");
    } else if (parentTableBody.hasClass("add_ap_ins")) {
        resetSerialNumbers(".add_ap_ins .rowApCount");
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/inspection/addEditInspection.blade.php ENDPATH**/ ?>