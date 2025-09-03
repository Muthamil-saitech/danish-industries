
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
                <?php echo Form::model(isset($manufacture) && $manufacture ? $manufacture : '', [
                    'id' => 'consumable_form',
                    'method' => isset($manufacture) && $manufacture ? 'PATCH' : 'POST',
                    'route' => ['consumable.update', isset($manufacture->id) && $manufacture->id ? $manufacture->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.ppcrc_no'); ?> </label>
                                <input type="hidden" name="manufacture_id" id="manufacture_id"
                                    class="form-control <?php $__errorArgs = ['manufacture_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(isset($manufacture) && $manufacture ? $manufacture->id : old('manufacture_id')); ?>" readonly>
                                <input type="text" name="ppcrc_no" id="ppcrc_no"
                                    class="form-control <?php $__errorArgs = ['ppcrc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo app('translator')->get('index.ppcrc_no'); ?>" value="<?php echo e(isset($manufacture) && $manufacture ? $manufacture->reference_no : old('reference_no')); ?>" readonly>
                                <p class="text-danger manufacture_err"></p>
                                <?php $__errorArgs = ['ppcrc_no'];
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.production_stage'); ?> </label>
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
                                        <option value="<?php echo e($stage->productionstage_id); ?>" <?php echo e(isset($stage->productionstage_id) && $stage->productionstage_id==old('production_stage') ? 'selected' : ''); ?>><?php echo e(getProductionStages($stage->productionstage_id)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-danger pro_stage_err"></p>
                                <?php $__errorArgs = ['production_stage'];
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
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($emp->id); ?>" <?php echo e(isset($emp) && $emp->id==old('user_id') ? 'selected' : ''); ?>><?php echo e(getEmpCode($emp->id)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-danger user_err"></p>
                                <?php $__errorArgs = ['user_id'];
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
                                        <option value="<?php echo e($material->id); ?>" <?php echo e(isset($material) && $material->id==old('mat_id') ? 'selected' : ''); ?>><?php echo e(getRMName($material->id)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-danger material_err"></p>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.quantity'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="qty" id="qty" class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo app('translator')->get('index.quantity'); ?>" value="<?php echo e(old('qty')); ?>">
                                <p class="text-danger qty_err"></p>
                                <?php $__errorArgs = ['qty'];
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
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            <a class="btn bg-second-btn" href="<?php echo e(route('consumable.index')); ?>"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <?php echo Form::close(); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script_bottom'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'; ?>"></script>
    <script>
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
                    // $(".select2").select2();
                },
                error: function () {
                    console.error("Failed to fetch product details.");
                },
            });
        });
        $(document).on('submit', '#consumable_form', function (e) {
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            $('.manufacture_err, .pro_stage_err, .user_err, .material_err, .qty_err').text('');
            let ppcrcNo  = $('#ppcrc_no').val()?.trim() || '';
            let productionStage  = $('#production_stage').val()?.trim() || '';
            let userId  = $('#user_id').val()?.trim() || '';
            let matId  = $('#mat_id').val()?.trim() || '';
            let qty  = $('#qty').val()?.trim() || '';
            if (!ppcrcNo) $(".manufacture_err").text("The PPCRC Number field is required"), isValid=false;
            if (productionStage && !userId) $(".user_err").text("If Production Stage is selected, then select Task Person."), isValid=false;
            if (!matId) $(".material_err").text("The Material Name field is required"), isValid=false;
            if (!qty) $(".qty_err").text("The Qty field is required"), isValid=false;
            if (!isValid) e.preventDefault();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/consumable/edit.blade.php ENDPATH**/ ?>