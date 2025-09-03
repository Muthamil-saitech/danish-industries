
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
                                <th class="width_10_p"><?php echo app('translator')->get('index.created_on'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.po_no'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.order_type'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.customer'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.product_count'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.total_value'); ?></th>
                                
                                <th class="width_10_p"><?php echo app('translator')->get('index.status_for_quote'); ?></th>
                                <th class="width_10_p"><?php echo app('translator')->get('index.created_by'); ?></th>
                                <th class="width_3_p"><?php echo app('translator')->get('index.actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($obj && !empty($obj)): ?>
                                <?php
                                $i = count($obj);
                                ?>
                            <?php endif; ?>
                            <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(getDateFormat($value->created_at)); ?></td>
                                    <td><?php echo e($value->reference_no); ?></td>
                                    <td><?php echo e($value->order_type == "Quotation" ? "Labor" : "Sales"); ?></td>
                                    <td><?php echo e($value->customer->name); ?><br> (<?php echo e($value->customer->customer_id); ?>)</td>
                                    <td><?php echo e($value->total_product); ?></td>
                                    <td><?php echo e(getAmtCustom(round($value->total_amount))); ?></td>
                                    
                                    <td>
                                        <select name="order_status" class="form-control select2 order-quote-status" data-order_id="<?php echo e($value->id); ?>" <?php echo e(in_array($value->order_status, [1,2]) ? 'disabled' : ''); ?>>
                                            <option value="0" <?php echo e($value->order_status == 0 ? 'selected' : ''); ?>>Pending</option>
                                            <option value="1" <?php echo e($value->order_status == 1 ? 'selected' : ''); ?>>Confirmed</option>
                                            <option value="2" <?php echo e($value->order_status == 2 ? 'selected' : ''); ?>>Cancelled</option>
                                        </select>
                                        <div class="status-msg"></div>
                                    </td>
                                    <td><?php echo e(getUserName($value->created_by)); ?></td>
                                    <td>
                                        <?php if(routePermission('order.view-details')): ?>
                                            <a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>" class="button-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo app('translator')->get('index.view_details'); ?>"><i class="fa fa-eye tiny-icon"></i></a>
                                        <?php endif; ?>
                                        <?php if(routePermission('order.edit') && $value->order_status == 0): ?>
                                            <a href="<?php echo e(url('customer-orders')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit"
                                                class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit tiny-icon"></i></a>
                                        <?php endif; ?>
                                        
                                        <?php if(routePermission('order.delete') && $value->order_status == 0): ?>
                                            <a href="#" class="delete button-danger"
                                                data-form_class="alertDelete<?php echo e($value->id); ?>" type="submit"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('index.delete'); ?>">
                                                <form action="<?php echo e(route('customer-orders.destroy', $value->id)); ?>"
                                                    class="alertDelete<?php echo e($value->id); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <i class="fa fa-trash tiny-icon"></i>
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
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.customer_order'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::model('', [
                            'id' => 'add_form',
                            'method' => 'GET',
                            'enctype' => 'multipart/form-data',
                            'route' => ['customer-orders.index'],
                        ]); ?>

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'order_start_date']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <?php echo Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'order_complete_date']); ?>

                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.customer'); ?> </label>
                                    <select name="customer_id" id="fil_customer_id" class="form-control select2">
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
                                <a href="<?php echo e(route('customer-orders.index')); ?>" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
    <script src="<?php echo $baseURL . 'frequent_changing/js/order.js'; ?>"></script>
    <script>
        $("#fil_customer_id").select2({
            dropdownParent: $("#filterModal"),
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/customer_order/index.blade.php ENDPATH**/ ?>