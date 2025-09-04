
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
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo e(isset($title) && $title?$title:''); ?></h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo e(isset($title) && $title?$title:''); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="">Total Expenses: <?php echo e(isset($obj) && $obj ? count($obj): '0'); ?></h5>
            </div>
        </div>
    </section>

    <?php if($startDate != '' || $endDate != ''): ?>
    <div class="my-2">
        <h4 class="ir_txtCenter_mt0">
            Date:
            <?php echo e(($startDate != '') ? date('d-m-Y',strtotime($startDate)):''); ?>

            <?php echo e(($endDate != '') ? ' - '.date('d-m-Y',strtotime($endDate)):''); ?>

        </h4>
    </div>
    <?php endif; ?>

    <div class="box-wrapper">
        <?php echo e(Form::open(['route'=>'expense-report', 'id' => "expense_form", 'method'=>'get'])); ?>

        <div class="row">
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <div class="form-group">
                    <?php echo Form::text('startDate', $startDate, ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'exp_start_date']); ?>

                </div>
            </div>
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <div class="form-group">
                    <?php echo Form::text('endDate', $endDate, ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'exp_complete_date']); ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    <button type="submit" value="submit" class="btn bg-blue-btn w-100"><?php echo app('translator')->get('index.submit'); ?></button>
                </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    <a href="<?php echo e(route('expense-report')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>


        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                            <th class="w-20"><?php echo app('translator')->get('index.date'); ?></th>
                            <th class="w-20"><?php echo app('translator')->get('index.category'); ?></th>
                            <th class="w-20"><?php echo app('translator')->get('index.amount'); ?></th>
                            <th class="w-20"><?php echo app('translator')->get('index.responsible_person'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($obj)) {
                            $i = 1;
                            $total = 0;
                            foreach ($obj as $value) {
                                $total += $value->amount;
                        ?>
                                <tr>
                                    <td class="text-start"><?php echo e($i++); ?></td>
                                    <td><?php echo e(getDateFormat($value->date)); ?></td>
                                    <td><?php echo e($value->expenseCategory->name); ?></td>
                                    <td><?php echo e(getAmtCustom($value->amount)); ?></td>
                                    <td><?php echo e($value->responsibleBy->name); ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-end fw-bold"><?php echo app('translator')->get('index.total'); ?>=</th>
                            <th><?php echo e(getAmtCustom($total)); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
<script>
    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#exp_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function (e) {
        const startDate = e.date;
        $('#exp_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#exp_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#exp_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#exp_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function (e) {
        const completeDate = e.date;
        const startDateVal = $('#exp_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#exp_complete_date').datepicker('update', startDate);
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/report/expense_report.blade.php ENDPATH**/ ?>