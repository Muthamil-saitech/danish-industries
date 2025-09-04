
<?php $__env->startSection('content'); ?>
<?php
$baseURL = getBaseURL();
$setting = getSettingsInfo();
$base_color = "#6ab04c";
if (isset($setting->base_color) && $setting->base_color) {
    $base_color = $setting->base_color;
}
?>
<section class="main-content-wrapper">
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo e(isset($title) && $title?$title:''); ?></h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo e(isset($title) && $title?$title:''); ?>" data-id_name="datatable">
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
                            <th class="op_width_2_p"><?php echo app('translator')->get('index.sn'); ?></th>
                            <th><?php echo app('translator')->get('index.account_name'); ?></th>
                            <th><?php echo app('translator')->get('index.credit'); ?></th>
                            <th><?php echo app('translator')->get('index.debit'); ?></th>
                            <th><?php echo app('translator')->get('index.balance'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalDebit = 0;
                            $totalCredit = 0;
                            $totalBalance = 0;
                         ?>

                        <?php if($obj && !empty($obj)): ?>
                        <?php $i = 1; ?>
                        <?php endif; ?>

                        <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $credit = getTotalCredit($value->id);
                            $totalCredit += $credit;
                            $debit = getTotalDebit($value->id);
                            $totalDebit += $debit;
                            $balance = $credit - $debit;
                            $totalBalance += $balance;
                        ?>
                        <tr>
                            <td class="c_center"><?php echo e($i++); ?></td>
                            <td><?php echo e($value->name); ?></td>
                            <td><?php echo e(getAmtCustom($credit)); ?></td>
                            <td><?php echo e(getAmtCustom($debit)); ?></td>
                            <td><?php echo e(getAmtCustom($balance)); ?></td>
                        </tr>                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="c_center"></td>
                            <td class="fw-bold text-end"><?php echo app('translator')->get('index.total'); ?>=</td>
                            <td class="fw-bold"><?php echo e(getAmtCustom($totalCredit)); ?></td>
                            <td class="fw-bold"><?php echo e(getAmtCustom($totalDebit)); ?></td>
                            <td class="fw-bold"><?php echo e(getAmtCustom($totalBalance)); ?></td>
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
<script src="<?php echo $baseURL.'assets/datatable_custom/jquery-3.3.1.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/dataTables.bootstrap4.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/dataTables.buttons.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/buttons.html5.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/buttons.print.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/jszip.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/pdfmake.min.js'; ?>"></script>
<script src="<?php echo $baseURL.'assets/dataTable/vfs_fonts.js'; ?>"></script>
<script src="<?php echo $baseURL.'frequent_changing/newDesign/js/forTable.js'; ?>"></script>
<script src="<?php echo $baseURL.'frequent_changing/js/custom_report.js'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/report/balance_sheet.blade.php ENDPATH**/ ?>