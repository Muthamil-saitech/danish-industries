
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
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Customer Receives: <?php echo e(isset($obj) ? count($obj) : '0'); ?> </h5>
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
                        <tr>
                            <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.po_no'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.po_date'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.customer'); ?><br>(Code)</th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.total_amount'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.paid_amount'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.due_amount'); ?></th>
                            <th class="width_10_p"><?php echo app('translator')->get('index.payment_status'); ?></th>
                            <th class="width_3_p ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($obj && !empty($obj)): ?>
                        <?php
                        $i = 1;
                        ?>
                        <?php endif; ?>
                        <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td><?php echo e($value->reference_no); ?></td>
                            <td><?php echo e($value->po_date ? getDateFormat($value->po_date) : '-'); ?></td>
                            <td><?php echo e(getCustomerNameById($value->customer_id)); ?><br><small><?php echo e('('.getCustomerCodeById($value->customer_id).')'); ?></small></td>
                            <td><?php echo e(getAmtCustom($value->orderInvoice->amount)); ?></td>
                            <td><?php echo e(getAmtCustom($value->orderInvoice->paid_amount)); ?></td>
                            <td><?php echo e(getAmtCustom($value->orderInvoice->due_amount)); ?></td>
                            <td>
                                <h6><?php if($value->orderInvoice->due_amount==0.00): ?> <span class="badge bg-success">Paid</span> <?php elseif($value->orderInvoice->paid_amount==0.00): ?> <span class="badge bg-danger">Unpaid</span> <?php else: ?> <span class="badge bg-info">Partially Paid</span><?php endif; ?></h6>
                            </td>
                            <td class="text-end">
                                <?php if($value->orderInvoice->due_amount!=0.00): ?>
                                <a class="button-success" id="customerDueModal" data-bs-toggle="modal" data-order_id="<?php echo e($value->id); ?>" data-tot_amount="<?php echo e($value->orderInvoice->amount); ?>" data-paid_amount="<?php echo e($value->orderInvoice->paid_amount); ?>" data-due_amount="<?php echo e($value->orderInvoice->due_amount); ?>" data-bs-target="#customerDue" data-bs-toggle="tooltip" data-bs-placement="top" title="Due Entry"><i class="fa fa-money-bill"></i></a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('customer-payment-view', encrypt_decrypt($value->id, 'encrypt'))); ?>" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.view_details'); ?>"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="customerDue" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Customer Receive Entry</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="customer_due_form" action="<?php echo e(route('customer-due-entry')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.total_amount'); ?></label>
                                    <input type="hidden" class="form-control" name="order_id" id="order_id">
                                    <input type="text" class="form-control <?php $__errorArgs = ['total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="total_amount" id="total_amount" placeholder="<?php echo app('translator')->get('index.total_amount'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.balance_amount'); ?></label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['balance_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="balance_amount" id="balance_amount" placeholder="<?php echo app('translator')->get('index.balance_amount'); ?>" min="1" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.amt_to_pay'); ?> <span class="ir_color_red">*</span></label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['pay_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="pay_amount" id="pay_amount" placeholder="<?php echo app('translator')->get('index.amt_to_pay'); ?>" min="1">
                                    <p class="text-danger" id="paid_amt_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group mt-1">
                                    <label class="control-label"><?php echo app('translator')->get('index.payment_type'); ?> <span class="ir_color_red">*</span></label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_cash" value="Cash">
                                        <label class="form-check-label" for="payment_cash">Cash</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_upi" value="UPI">
                                        <label class="form-check-label" for="payment_upi">UPI</label>
                                    </div>
                                    <p class="text-danger" id="pay_type_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.payment_img'); ?> (<?php echo app('translator')->get('index.max_size_1_mb'); ?>)</label>
                                    <input type="file" class="form-control" name="payment_img" id="payment_img" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.note'); ?></label>
                                    <textarea name="note" id="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Note" maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn customer_due_submit"><iconify-icon icon="solar:check-circle-broken"></iconify-icon> <?php echo app('translator')->get('index.submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.customer_due_receives'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer-payment.index'],
                    ]); ?>

                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'cr_start_date']); ?>

                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'cr_complete_date']); ?>

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
                                        <?php echo e($value->name); ?> (<?php echo e($value->customer_id); ?>)
                                    </option>
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
                            <a href="<?php echo e(route('customer-payment.index')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
<script>
    $(document).on("click", "#customerDueModal", function(e) {
        e.preventDefault();
        var order_id = $(this).data('order_id');
        $('#order_id').val(order_id);
        var tot_amount = $(this).data('tot_amount');
        $('#total_amount').val(tot_amount);
        var due_amount = $(this).data('due_amount');
        $('#balance_amount').val(due_amount);
    });
    $(document).on('change', "#payment_img", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#payment_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="payment_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="payment_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('.customer_due_submit').on('click', function(e) {
        e.preventDefault();
        $('#paid_amt_err, #pay_type_err').text('');
        let payAmount = $('#pay_amount').val().trim();
        let balAmount = $('#balance_amount').val().trim();
        let isValid = true;
        if (!payAmount) {
            $('#paid_amt_err').text('Amount to Pay is Required.');
            isValid = false;
        } else if (parseFloat(payAmount) > parseFloat(balAmount)) {
            $('#paid_amt_err').text('Amount to Pay cannot exceed Balance Amount.');
            isValid = false;
        }
        if (!$('input[name="payment_type"]:checked').val()) {
            $('#pay_type_err').text('Payment type is Required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        $("#customer_due_form").submit();
    });

    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#cr_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#cr_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#cr_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#cr_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#cr_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#cr_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#cr_complete_date').datepicker('update', startDate);
            }
        }
    });
    $("#customer_id").select2({
        dropdownParent: $("#filterModal"),
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_payment/index.blade.php ENDPATH**/ ?>