
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
                    <input type="hidden" class="datatable_name" data-filter="yes" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>"
                        data-id_name="datatable">
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="">Total Sales: <?php echo e(isset($obj) && $obj ? count($obj) : '0'); ?></h5>
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
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.sale_date'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.invoice_no'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.challan_no'); ?></th>
                                <th class="width_10_p">Customer Name (Code)</th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.total_amount'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.paid_amount'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.due_amount'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($obj && !empty($obj)): ?>
                                <?php
                                $i = 1;
                                ?>
                            <?php endif; ?>
                            <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="c_center"><?php echo e($i++); ?></td>
                                    <td><?php echo e(getDateFormat($value->sale_date)); ?></td>
                                    <td><?php echo e($value->reference_no); ?></td>
                                    <td><?php echo e($value->challan_no); ?></td>
                                    <td><?php echo e(getCustomerNameById($value->customer_id)); ?> (<?php echo e(getCustomerCodeById($value->customer_id)); ?>)</td>
                                    <td><?php echo e(getAmtCustom($value->grand_total)); ?></td>
                                    <td><?php echo e(getAmtCustom($value->pay)); ?></td>
                                    <td><?php echo e(getAmtCustom($value->bal)); ?></td>
                                    
                                    <td><h6><?php if($value->receive_status=="Paid"): ?> <span class="badge bg-success">Paid</span> <?php elseif($value->receive_status=="Initiated"): ?> <span class="badge bg-danger">Initiated</span> <?php else: ?> <span class="badge bg-info">Partially Paid</span><?php endif; ?></h6></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.inspect_list'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::model('', [
                            'id' => 'sale_report',
                            'method' => 'GET',
                            'enctype' => 'multipart/form-data',
                            'route' => ['report.sales'],
                        ]); ?>

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'sale_start_date']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'sale_complete_date']); ?>

                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.customer'); ?> </label>
                                    <select name="customer_id" id="customer_id" class="form-control select2">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($customer_id)): ?>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>"
                                                    <?php echo e(isset($customer_id) && $customer_id == $value->id ? 'selected' : ''); ?>>
                                                    <?php echo e($value->name); ?> (<?php echo e($value->customer_id); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <button type="submit" name="submit" value="submit"
                                    class="btn w-100 bg-blue-btn"><?php echo app('translator')->get('index.submit'); ?></button>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="<?php echo e(route('report.sales')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                            </div>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

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
    <script src="<?php echo $baseURL . 'frequent_changing/js/sales.js'; ?>"></script>
    <script>
        function parseDMYtoDate(dmy) {
            const [day, month, year] = dmy.split('-');
            return new Date(`${year}-${month}-${day}`);
        }
        $('#sale_start_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const startDate = e.date;
            $('#sale_complete_date').datepicker('setStartDate', startDate);
            const completeDateVal = $('#sale_complete_date').val();
            if (completeDateVal) {
                const completeDate = parseDMYtoDate(completeDateVal);
                if (completeDate < startDate) {
                    $('#sale_complete_date').datepicker('update', startDate);
                }
            }
        });
        $('#sale_complete_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const completeDate = e.date;
            const startDateVal = $('#sale_start_date').val();
            if (startDateVal) {
                const startDate = parseDMYtoDate(startDateVal);
                if (completeDate < startDate) {
                    $('#sale_complete_date').datepicker('update', startDate);
                }
            }
        });
        $("#customer_id").select2({
            dropdownParent: $("#filterModal"),
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/report/saleReport.blade.php ENDPATH**/ ?>