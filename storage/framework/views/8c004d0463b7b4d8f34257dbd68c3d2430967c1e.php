
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
            <div class="table-box">
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['suppliers.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo app('translator')->get('index.supplier_name'); ?> <span class="required_star">*</span></label>
                                <input type="hidden" name="supplier_id" value="<?php echo e(isset($obj->supplier_id) ? $obj->supplier_id : $supplier_id); ?>"
                                    onfocus="select()" readonly>
                                <input type="text" name="name" id="name"
                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Name" value="<?php echo e(isset($obj->name) && $obj->name ? $obj->name : old('name')); ?>">
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
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo app('translator')->get('index.contact_person'); ?></label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control <?php $__errorArgs = ['contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Contact Person" value="<?php echo e(isset($obj->contact_person) && $obj->contact_person ? $obj->contact_person : old('contact_person')); ?>">
                                <?php $__errorArgs = ['contact_person'];
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
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
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
                                    placeholder="Phone" value="<?php echo e(isset($obj->phone) && $obj->phone ? $obj->phone : old('phone')); ?>">
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
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo app('translator')->get('index.email'); ?></label>
                                <input type="text" name="email" id="email"
                                    class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Email" value="<?php echo e(isset($obj->email) && $obj->email ? $obj->email : old('email')); ?>">
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
                        
                        
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo app('translator')->get('index.address'); ?></label>
                                <textarea name="address" id="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Address" rows="3"><?php echo e(isset($obj->address) && $obj->address ? $obj->address : old('address')); ?></textarea>
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
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo app('translator')->get('index.note'); ?></label>
                                <textarea name="note" id="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="note" rows="3"><?php echo e(isset($obj->note) && $obj->note ? $obj->note : old('note')); ?></textarea>
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
                    <div class="add_scp">
                        <?php if(isset($supplier_contact_info) && $supplier_contact_info->count() > 0): ?>
                            
                            <?php $__currentLoopData = $supplier_contact_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $contact_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Contact Person Name </label>
                                            <input type="hidden" name="scp_id[]" value="<?php echo e($contact_info->id ?? ''); ?>">
                                            <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name" value="<?php echo e($contact_info->scp_name ?? old('scp_name')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Department </label>
                                            <input type="text" name="scp_department[]" class="form-control" placeholder="Department" value="<?php echo e($contact_info->scp_department ?? old('scp_department')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Designation </label>
                                            <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation" value="<?php echo e($contact_info->scp_designation ?? old('scp_designation')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Phone Number </label>
                                            <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number" value="<?php echo e($contact_info->scp_phone ?? old('scp_phone')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="text" name="scp_email[]" class="form-control" placeholder="Email" value="<?php echo e($contact_info->scp_email ?? old('scp_email')); ?>">
                                        </div>
                                    </div>
                                    <?php if($key==0): ?>
                                        <div class="col-md-4 mb-3 mt-1">
                                            <button id="supContactPerson" class="btn bg-blue-btn mt-4" type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                                        </div>
                                    <?php else: ?>
                                        <?php if(isset($supplier_contact_info) && $supplier_contact_info->count() > 0): ?>
                                        <div class="col-md-4 mt-4">
                                            <a href="#" class="sup_c_del button-danger"
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
                                        <input type="hidden" name="scp_id[]" value="">
                                        <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name" value="<?php echo e(old('scp_name.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Department </label>
                                        <input type="text" name="scp_department[]" class="form-control" placeholder="Department" value="<?php echo e(old('scp_department.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Designation </label>
                                        <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation" value="<?php echo e(old('scp_designation.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Phone Number </label>
                                        <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number" value="<?php echo e(old('scp_phone.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="text" name="scp_email[]" class="form-control" placeholder="Email" value="<?php echo e(old('scp_email.0')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mt-1">
                                    <button id="supContactPerson" class="btn bg-blue-btn mt-4" type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            <a class="btn bg-second-btn" href="<?php echo e(route('suppliers.index')); ?>"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                        </div>
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
        $(document).on("click", "#supContactPerson", function (e) {
            ++i;
            let newRow = `
                <div class="row mt-3" id="cp_row_${i}">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Contact Person Name</label>
                            <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="scp_department[]" class="form-control" placeholder="Department">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="scp_email[]" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mt-4">
                        <button type="button" class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></button>
                    </div>
                </div>
            `;

            $(".add_scp").append(newRow);
        });
        $(document).on("click", ".del_row", function () {
            $(this).closest(".row").remove();
        });
        $('body').on('click', '.sup_c_del', function (e) {
            e.preventDefault();
            let contact_id = $(this).attr('data-contact_id');
            // console.log("contact_id",contact_id);
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
                        url: hidden_base_url + "contactDelete",
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/supplier/addEditSupplier.blade.php ENDPATH**/ ?>