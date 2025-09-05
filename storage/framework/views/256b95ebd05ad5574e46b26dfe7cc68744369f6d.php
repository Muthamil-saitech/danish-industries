
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
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['customers.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer_name'); ?> <span class="required_star">*</span></label>
                                <input type="hidden" name="customer_id" value="<?php echo e(isset($obj->customer_id) ? $obj->customer_id : $customer_id); ?>"
                                    onfocus="select()">
                                <input type="text" name="name" id="name"
                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.customer_name')); ?>"
                                    value="<?php echo e(isset($obj) && $obj->name ? $obj->name : old('name')); ?>">
                                <?php $__errorArgs = ['name'];
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.phone'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.phone')); ?>" value="<?php echo e(isset($obj) && $obj->phone ? $obj->phone : old('phone')); ?>">
                                <?php $__errorArgs = ['phone'];
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.email'); ?></label>
                                <input type="email" name="email" id="email"
                                    class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.email')); ?>" value="<?php echo e(isset($obj) && $obj->email ? $obj->email : old('email')); ?>">
                                <?php $__errorArgs = ['email'];
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
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer_type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['customer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="customer_type" id="customer_type">
                                    <option value="">Select</option>
                                    <option value="Retail"
                                        <?php echo e((isset($obj) && $obj->customer_type == 'Retail') || old('customer_type') == 'Retail' ? 'selected' : ''); ?>>
                                        <?php echo app('translator')->get('index.retail'); ?>
                                    </option>
                                    <option value="Wholesale"
                                        <?php echo e((isset($obj) && $obj->customer_type == 'Wholesale') || old('customer_type') == 'Wholesale' ? 'selected' : ''); ?>>
                                        <?php echo app('translator')->get('index.wholesale'); ?>
                                    </option>
                                </select>
                                <?php $__errorArgs = ['customer_type'];
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.gst_no'); ?> </label>
                                <input type="text" name="gst_no" id="gst_no"
                                    class="form-control <?php $__errorArgs = ['gst_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.gst_no')); ?>"
                                    value="<?php echo e(isset($obj) && $obj->gst_no ? $obj->gst_no : old('gst_no')); ?>">
                                <?php $__errorArgs = ['gst_no'];
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.pan_no'); ?> </label>
                                <input type="text" name="pan_no"
                                    class="form-control <?php $__errorArgs = ['pan_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="pan_no" placeholder="<?php echo app('translator')->get('index.pan_no'); ?>"
                                    value="<?php echo e(isset($obj) && $obj->pan_no ? $obj->pan_no : old('pan_no')); ?>">
                                <?php $__errorArgs = ['pan_no'];
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
                                <label><?php echo app('translator')->get('index.hsn'); ?></label>
                                <input type="text" name="hsn_sac_no" id="hsn_sac_no"
                                    class="check_required form-control <?php $__errorArgs = ['hsn_sac_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.hsn'); ?>" value="<?php echo e(isset($obj) && $obj ? $obj->hsn_sac_no : old('hsn_sac_no')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['hsn_sac_no'];
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.ecc_no'); ?> </label>
                                <input type="text" name="ecc_no" id="ecc_no"
                                    class="form-control <?php $__errorArgs = ['ecc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.ecc_no')); ?>"
                                    value="<?php echo e(isset($obj) && $obj->ecc_no ? $obj->ecc_no : old('ecc_no')); ?>">
                                <?php $__errorArgs = ['ecc_no'];
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
                                <label><?php echo app('translator')->get('index.landmark'); ?> </label>
                                <input type="text" name="area" id="area"
                                    class="form-control <?php $__errorArgs = ['area'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.landmark')); ?>"
                                    value="<?php echo e(isset($obj) && $obj->area ? $obj->area : old('area')); ?>">
                                <?php $__errorArgs = ['area'];
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
                                <label><?php echo app('translator')->get('index.address'); ?></label>
                                <textarea name="address" id="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.address')); ?>" rows="3"><?php echo isset($obj) && $obj->address ? $obj->address : old('address'); ?></textarea>
                                <?php $__errorArgs = ['address'];
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
                                <label><?php echo app('translator')->get('index.note'); ?></label>
                                <textarea name="note" id="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo e(__('index.note')); ?>" rows="3" ><?php echo e(isset($obj) && $obj->note ? $obj->note : old('note')); ?></textarea>
                                <?php $__errorArgs = ['note'];
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
                    <hr>
                    <div class="add_cp">
                        <?php if(isset($customer_contact_info) && $customer_contact_info->count() > 0): ?>
                            
                            <?php $__currentLoopData = $customer_contact_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $contact_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Contact Person Name </label>
                                            <input type="hidden" name="cp_id[]" value="<?php echo e($contact_info->id ?? ''); ?>">
                                            <input type="text" name="cp_name[]" class="form-control" placeholder="Contact Person Name" value="<?php echo e($contact_info->cp_name ?? old('cp_name')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Department </label>
                                            <input type="text" name="cp_department[]" class="form-control" placeholder="Department" value="<?php echo e($contact_info->cp_department ?? old('cp_department')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Designation </label>
                                            <input type="text" name="cp_designation[]" class="form-control" placeholder="Designation" value="<?php echo e($contact_info->cp_designation ?? old('cp_designation')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Phone Number </label>
                                            <input type="text" name="cp_phone[]" class="form-control" placeholder="Phone Number" value="<?php echo e($contact_info->cp_phone ?? old('cp_phone')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="text" name="cp_email[]" class="form-control" placeholder="Email" value="<?php echo e($contact_info->cp_email ?? old('cp_email')); ?>">
                                        </div>
                                    </div>
                                    <?php if($key==0): ?>
                                        <div class="col-md-4 mb-3 mt-1">
                                            <button id="custContactPerson" class="btn bg-blue-btn mt-4" type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                                        </div>
                                    <?php else: ?>
                                        <?php if(isset($customer_contact_info) && $customer_contact_info->count() > 0): ?>
                                        <div class="col-md-4 mt-4">
                                            <a href="#" class="cus_c_del button-danger"
                                                data-contact_id="<?php echo e($contact_info->id); ?>" type="submit"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.delete'); ?>">
                                                <i class="fa fa-trash tiny-icon"></i>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                            <div class="col-md-4 mt-4">
                                                <button type="button" class="btn btn-xs del_row dlt_button">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Contact Person Name </label>
                                        <input type="hidden" name="cp_id[]" value="">
                                        <input type="text" name="cp_name[]" class="form-control" placeholder="Contact Person Name" value="<?php echo e(old('cp_name.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Department </label>
                                        <input type="text" name="cp_department[]" class="form-control" placeholder="Department" value="<?php echo e(old('cp_department.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Designation </label>
                                        <input type="text" name="cp_designation[]" class="form-control" placeholder="Designation" value="<?php echo e(old('cp_designation.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Phone Number </label>
                                        <input type="text" name="cp_phone[]" class="form-control" placeholder="Phone Number" value="<?php echo e(old('cp_phone.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="text" name="cp_email[]" class="form-control" placeholder="Email" value="<?php echo e(old('cp_email.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mt-1">
                                    <button id="custContactPerson" class="btn bg-blue-btn mt-4" type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            <a class="btn bg-second-btn" href="<?php echo e(route('customers.index')); ?>"><iconify-icon
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
        let base_url = $('#base_url').val();
        let hidden_base_url = $("#hidden_base_url").val();
        let hidden_alert = $(".hidden_alert").val();
        let hidden_ok = $(".hidden_ok").val();
        let hidden_cancel = $(".hidden_cancel").val();
        let thischaracterisnotallowed = $(".thischaracterisnotallowed").val();
        let are_you_sure = $(".are_you_sure").val();
        let i = 0;
        $(document).on("click", "#custContactPerson", function (e) {
            ++i;
            let newRow = `
                <div class="row mt-3" id="cp_row_${i}">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Contact Person Name</label>
                            <input type="text" name="cp_name[]" class="form-control" placeholder="Contact Person Name">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="cp_department[]" class="form-control" placeholder="Department">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" name="cp_designation[]" class="form-control" placeholder="Designation">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="cp_phone[]" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="cp_email[]" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mt-4">
                        <button type="button" class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></button>
                    </div>
                </div>
            `;

            $(".add_cp").append(newRow);
        });
        $(document).on("click", ".del_row", function () {
            $(this).closest(".row").remove();
        });
        $('body').on('click', '.cus_c_del', function (e) {
            e.preventDefault();
            let contact_id = $(this).attr('data-contact_id');
            swal({
                title: hidden_alert+"!",
                text: are_you_sure,
                cancelButtonText:hidden_cancel,
                confirmButtonText:hidden_ok,
                confirmButtonColor: '#3c8dbc',
                showCancelButton: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: hidden_base_url + "customerContactDelete",
                        data: {
                            contact_id: contact_id
                        },
                        dataType: "json",
                        success: function(data) {
                            let hidden_alert = data.status ? "Success" : "Error";
                            swal({
                                title: hidden_alert + "!",
                                text: data.message,
                                cancelButtonText: hidden_cancel,
                                confirmButtonText: hidden_ok,
                                confirmButtonColor: "#3c8dbc",
                            }, function() {
                                location.reload();
                            });
                        },
                        error: function() {
                            console.error("Failed to fetch product details.");
                        },
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer/addEditCustomer.blade.php ENDPATH**/ ?>