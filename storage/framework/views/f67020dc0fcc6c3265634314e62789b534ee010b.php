
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
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Consumables: <?php echo e($total_consumables); ?> </h5>
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
                            <th class="ir_w_16"><?php echo app('translator')->get('index.part_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.part_name'); ?> </th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.po_no'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.customer_name'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.start_date'); ?></th>
                            <th class="ir_w_16"><?php echo app('translator')->get('index.delivery_date'); ?></th>
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
                            <td><?php echo e($prodInfo->code); ?></td>
                            <td><?php echo e($prodInfo->name); ?></td>
                            <td><?php echo e(getPoNo($value->customer_order_id)); ?></td>
                            <td><?php echo e(getCustomerNameById($value->customer_id).' ('.getCustomerCodeById($value->customer_id).')'); ?></td>
                            <td><?php echo e(getDateFormat($value->start_date)); ?></td>
                            <td><?php echo e($value->complete_date!='' ? getDateFormat($value->complete_date) : ' - '); ?></td>
                            <td>
                                <a href="<?php echo e(url('consumable')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo app('translator')->get('index.view_details'); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="<?php echo e(url('consumable')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit" class="button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit tiny-icon"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/consumable/index.blade.php ENDPATH**/ ?>