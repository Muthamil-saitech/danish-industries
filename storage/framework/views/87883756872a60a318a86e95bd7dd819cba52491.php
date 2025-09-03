
    
        <div class="table-responsive" style="overflow-y: hidden;">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="width_5_p"></th>
                        <th class="width_20_p"><?php echo app('translator')->get('index.name'); ?></th>
                        <th class="width_10_p"><?php echo app('translator')->get('index.salary'); ?></th>
                        <th class="width_10_p"><?php echo app('translator')->get('index.additional'); ?></th>
                        <th class="width_10_p"><?php echo app('translator')->get('index.subtraction'); ?></th>
                        <th class="width_10_p"><?php echo app('translator')->get('index.total'); ?></th>
                        <th class="width_15_p"><?php echo app('translator')->get('index.note'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="width_5_p">
                            <label class="container width_83_p">All
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="width_15_p"></th>
                        <th class="width_10_p"></th>
                        <th class="width_10_p"></th>
                        <th class="width_10_p"></th>
                        <th class="width_10_p" colspan="2"><?php echo app('translator')->get('index.total'); ?> = <span class="total_amount"></span><input type="hidden" id="total_amount" name="total_amount" value="<?php echo e(isset($obj) ? $obj->total_amount : 0); ?>"></th>
                        
                    </tr>
                    <?php $__currentLoopData = $userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="row_counter" data-id="<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>">
                            <th>
                                <label class="container width_5_p">
                                    <input class="checkbox_user" type="checkbox" <?php if(isset($user->p_status) && $user->p_status): echo 'checked'; endif; ?>
                                        name="product_id<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <td>
                                <?php echo e($user->name); ?>

                                <input type="hidden" id="selected_ids" name="selected_ids">
                                <input type="hidden" name="user_id[]"
                                    value="<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    id="salary_<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>" name="salary[]"
                                    value="<?php echo e(isset($user->salary) && $user->salary ? $user->salary : '0.00'); ?>"
                                    readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control cal_row integerchk" onfocus="select()"
                                    id="additional_<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>"
                                    name="additional[]"
                                    value="<?php echo e(isset($user->additional) && $user->additional ? $user->additional : '0.00'); ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control cal_row integerchk" onfocus="select()"
                                    id="subtraction_<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>"
                                    name="subtraction[]"
                                    value="<?php echo e(isset($user->subtraction) && $user->subtraction ? $user->subtraction : '0.00'); ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control" readonly
                                    id="total_<?php echo e(isset($user->user_id) ? $user->user_id : $user->id); ?>" name="total[]"
                                    value="<?php echo e(isset($user->total) && $user->total ? $user->total : '0.00'); ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="notes[]"
                                    value="<?php echo e(isset($user->notes) && $user->notes ? $user->notes : ''); ?>">
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="col-md-1"></div>
        <div class="clearfix"></div>
        <div class="col-md-8"></div>
    
    
    <div class="row mt-2">
        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
            <a class="btn bg-second-btn" href="<?php echo e(route('payroll.index')); ?>"><iconify-icon
                    icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
        </div>
    </div>
<?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/payroll/_form.blade.php ENDPATH**/ ?>