
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
                    <input type="hidden" class="datatable_name" data-filter="yes" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>"
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
                                <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.purchase_no'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.purchase_date'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.supplier_name'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.g_total'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.paid'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.due'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.status'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.added_by'); ?></th>
                                <th class="width_3_p"><?php echo app('translator')->get('index.actions'); ?></th>
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
                                    <td><?php echo e($value->reference_no); ?></td>
                                    <td><?php echo e(getDateFormat($value->date)); ?></td>
                                    <td><?php echo e(getSupplierName($value->supplier)); ?></td>
                                    <td><?php echo e(getCurrency($value->grand_total)); ?></td>
                                    <td><?php echo e(getCurrency($value->paid)); ?></td>
                                    <td><?php echo e(getCurrency($value->due)); ?></td>
                                    <td >
                                        <select name="status" class="form-control select2 purchase-status" data-id="<?php echo e($value->id); ?>" <?php echo e(in_array($value->status, ["Completed"]) ? 'disabled' : ''); ?> style="width: 200px;">
                                            <option value="Draft" <?php echo e($value->status == "Draft" ? 'selected' : ''); ?>>Draft</option>
                                            <option value="Completed" <?php echo e($value->status == "Completed" ? 'selected' : ''); ?>>Completed</option>
                                        </select>
                                        <div class="purchase-status-msg"></div>
                                    </td>
                                    <td><?php echo e(getUserName($value->added_by)); ?></td>
                                    <td class="text-start">
                                        <a href="<?php echo e(url('rawmaterialpurchases')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.view_details'); ?>"><i class="fa fa-eye tiny-icon"></i></a>
                                        <?php if($value->status=="Draft"): ?>
                                        <a href="<?php echo e(url('rawmaterialpurchases')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit"
                                            class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if($value->status=="Draft"): ?>
                                        <a href="#" class="delete button-danger"
                                            data-form_class="alertDelete<?php echo e($value->id); ?>" type="submit"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.delete'); ?>">
                                            <form action="<?php echo e(route('rawmaterialpurchases.destroy', $value->id)); ?>"
                                                class="alertDelete<?php echo e($value->id); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                            </form>
                                        </a>
                                        <?php endif; ?>
                                    </td>
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
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.purchase'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::model('', [
                            'id' => 'add_form',
                            'method' => 'GET',
                            'enctype' => 'multipart/form-data',
                            'route' => ['rawmaterialpurchases.index'],
                        ]); ?>

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'pur_start_date']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'pur_complete_date']); ?>

                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.suppliers'); ?> </label>
                                    <select name="supplier_id" id="supplier_id" class="form-control select2">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($supplier_id)): ?>
                                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>"
                                                    <?php echo e(isset($supplier_id) && $supplier_id == $value->id ? 'selected' : ''); ?>>
                                                    <?php echo e($value->name); ?> (<?php echo e($value->supplier_id); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <button type="submit" name="submit" value="submit" class="btn w-100 bg-blue-btn"><?php echo app('translator')->get('index.submit'); ?></button>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="<?php echo e(route('rawmaterialpurchases.index')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
    <script src="<?php echo $baseURL . 'frequent_changing/js/purchase.js'; ?>"></script>
    <script>
        function parseDMYtoDate(dmy) {
            const [day, month, year] = dmy.split('-');
            return new Date(`${year}-${month}-${day}`);
        }
        $('#pur_start_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const startDate = e.date;
            $('#pur_complete_date').datepicker('setStartDate', startDate);
            const completeDateVal = $('#pur_complete_date').val();
            if (completeDateVal) {
                const completeDate = parseDMYtoDate(completeDateVal);
                if (completeDate < startDate) {
                    $('#pur_complete_date').datepicker('update', startDate);
                }
            }
        });
        $('#pur_complete_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const completeDate = e.date;
            const startDateVal = $('#pur_start_date').val();
            if (startDateVal) {
                const startDate = parseDMYtoDate(startDateVal);
                if (completeDate < startDate) {
                    $('#pur_complete_date').datepicker('update', startDate);
                }
            }
        });
        $("#supplier_id").select2({
            dropdownParent: $("#filterModal"),
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/purchase/purchases.blade.php ENDPATH**/ ?>