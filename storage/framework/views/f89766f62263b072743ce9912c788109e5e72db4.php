
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
                    <input type="hidden" class="datatable_name" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>"
                        data-id_name="datatable">
                </div>
                <div class="col-md-offset-4 col-md-2">

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
                                <th class="width_10_p"><?php echo app('translator')->get('index.wait_for_quote'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.quote_cancel'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.waiting_for_production'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.yet_to_start'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.in_production'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.ready_for_shipment'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $order_quotation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body text-left fs-6">
                                                <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                <p>Part No : <?php echo e($value->code); ?></p>
                                                <p>Part Name : <?php echo e($value->name); ?></p>
                                                <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $order_quotation_cancelled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body text-left fs-6">
                                                <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                <p>Part No : <?php echo e($value->code); ?></p>
                                                <p>Part Name : <?php echo e($value->name); ?></p>
                                                <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $waiting_for_production; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body d-flex justify-content-between align-items-start fs-6">
                                                <div class="text-left">
                                                    <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                    <p>Part No : <?php echo e($value->code); ?></p>
                                                    <p>Part Name : <?php echo e($value->name); ?></p>
                                                    <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                </div>
                                                <div>
                                                    <a href="<?php echo e(url('productions')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/<?php echo e(encrypt_decrypt($value->product_id, 'encrypt')); ?>/create" class="btn bg-second-btn">Add Production</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $yet_to_start; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body d-flex justify-content-between align-items-start fs-6">
                                                <div class="text-left">
                                                    <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                    <p>Assign to : <strong class="text-right"><?php echo e(getAssignee($value->id,$value->mid)); ?></strong></p>
                                                    <p>Part No : <?php echo e($value->code); ?></p>
                                                    <p>Part Name : <?php echo e($value->name); ?></p>
                                                    <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.start_date'); ?> : <strong class="text-right"><?php echo e($value->start_date!=null ? getDateFormat($value->start_date) : '-'); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.end_date'); ?> : <strong class="text-right"><?php echo e($value->complete_date!=null ? getDateFormat($value->complete_date) : '-'); ?></strong></p>
                                                </div>
                                                <div>
                                                    <span class="badge bg-info text-dark"><?php echo e(getStageNo($value->id)); ?></span>
                                                    <span class="badge bg-warning text-dark"><?php echo e(getStageName($value->id)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $inproduction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body d-flex justify-content-between align-items-start fs-6">
                                                <div class="text-left">
                                                    <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                    <p>Assign to : <strong class="text-right"><?php echo e(getAssignee($value->id,$value->mid)); ?></strong></p>
                                                    <p>Part No : <?php echo e($value->code); ?></p>
                                                    <p>Part Name : <?php echo e($value->name); ?></p>
                                                    <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.start_date'); ?> : <strong class="text-right"><?php echo e($value->start_date!=null ? getDateFormat($value->start_date) : '-'); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.end_date'); ?> : <strong class="text-right"><?php echo e($value->complete_date!=null ? getDateFormat($value->complete_date) : '-'); ?></strong></p>
                                                </div>
                                                <div>
                                                    <span class="badge bg-info text-dark"><?php echo e(getStageNo($value->id)); ?></span>
                                                    <span class="badge bg-warning text-dark"><?php echo e(getStageName($value->id)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="text-center align-baseline">
                                    <?php $__currentLoopData = $ready_for_ship; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card border-bottom mb-2">
                                            <div class="card-body d-flex justify-content-between align-items-start fs-6">
                                                <div class="text-left">
                                                    <p><a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.view_details'); ?>">#<?php echo e($value->reference_no); ?></a></p>
                                                    <p>Assign to : <strong class="text-right"><?php echo e(getAssignee($value->id,$value->mid)); ?></strong></p>
                                                    <p>Part No : <?php echo e($value->code); ?></p>
                                                    <p>Part Name : <?php echo e($value->name); ?></p>
                                                    <p><?php echo app('translator')->get('index.total'); ?> : <strong class="text-right"><?php echo e(getAmtCustom($value->total_amount)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.po_date'); ?> : <strong class="text-right"><?php echo e(getDateFormat($value->po_date)); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.start_date'); ?> : <strong class="text-right"><?php echo e($value->start_date!=null ? getDateFormat($value->start_date) : '-'); ?></strong></p>
                                                    <p><?php echo app('translator')->get('index.end_date'); ?> : <strong class="text-right"><?php echo e($value->complete_date!=null ? getDateFormat($value->complete_date) : '-'); ?></strong></p>
                                                </div>
                                                <div>
                                                    <span class="badge bg-info text-dark"><?php echo e(getStageNo($value->id)); ?></span>
                                                    <span class="badge bg-warning text-dark"><?php echo e(getStageName($value->id)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_order/order-status.blade.php ENDPATH**/ ?>