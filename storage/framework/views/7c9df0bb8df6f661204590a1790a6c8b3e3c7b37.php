
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
                <div class="col-md-6">
                    <?php if(routePermission('customer.index')): ?>
                        <a class="btn bg-second-btn" href="<?php echo e(route('customers.index')); ?>"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20"><?php echo app('translator')->get('index.customer_details'); ?></h3>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.cust_id'); ?>:</strong></span>
                                            <?php echo e($obj->customer_id); ?>

                                        </p>
                                        
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.customer_type'); ?>:</strong></span>
                                            <?php echo e($obj->customer_type); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.customer_name'); ?>:</strong></span>
                                            <?php echo e($obj->name); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.phone'); ?>:</strong></span>
                                            <?php echo e($obj->phone); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.gst_no'); ?>:</strong></span>
                                            <?php echo e($obj->gst_no); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.pan_no'); ?>:</strong></span>
                                            <?php echo e($obj->pan_no); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.email'); ?>:</strong></span>
                                            <?php echo e($obj->email); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.address'); ?>:</strong></span>
                                            <?php echo e($obj->address); ?>

                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.hsn'); ?>:</strong></span>
                                            <?php echo e($obj->hsn_sac_no); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.ecc_no'); ?>:</strong></span>
                                            <?php echo e($obj->ecc_no); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.landmark'); ?>:</strong></span>
                                            <?php echo e($obj->area); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.created_on'); ?>:</strong></span>
                                            <?php echo e(getDateFormat($obj->created_at)); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.created_by'); ?>:</strong></span>
                                            <?php echo e(getUserName($obj->added_by)); ?>

                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong><?php echo app('translator')->get('index.note'); ?>:</strong></span>
                                            <?php echo e($obj->note); ?>

                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20">Customer Contact Info</h3>
                            </div>
                            <table>
                                <?php if(isset($customer_contact_details) && count($customer_contact_details) > 0): ?>
                                    <thead>
                                        <tr>
                                            <th><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th>Contact Person Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $customer_contact_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($contact->cp_name!='' ? $contact->cp_name : 'N/A'); ?></td>
                                                <td><?php echo e($contact->cp_department!='' ? $contact->cp_department : 'N/A'); ?></td>
                                                <td><?php echo e($contact->cp_designation!='' ? $contact->cp_designation : 'N/A'); ?></td>
                                                <td><?php echo e($contact->cp_phone!='' ? $contact->cp_phone : 'N/A'); ?></td>
                                                <td><?php echo e($contact->cp_email!='' ? $contact->cp_email : 'N/A'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer/viewDetails.blade.php ENDPATH**/ ?>