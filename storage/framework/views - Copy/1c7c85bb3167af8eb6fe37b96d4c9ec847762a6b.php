
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
                    <input type="hidden" class="datatable_name material_table" data-filter="yes"
                        data-title="<?php echo e(isset($title) && $title ? $title : ''); ?>">
                </div>
                <div class="col-md-6">
                </div>
                
            </div>
            
        </section>
        <div class="box-wrapper">
            <ul class="nav nav-tabs" id="materialTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="danish-tab" data-bs-toggle="tab" data-bs-target="#danish" type="button" role="tab">Danish</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">Customers</button>
                </li>
            </ul>
            <div class="tab-content mt-3" id="materialTabContent">
                <div class="tab-pane fade show active" id="danish" role="tabpanel" aria-labelledby="danish-tab">
                    <div class="table-responsive">
                        <table class="table table-striped material_table">
                            <thead>
                                <tr>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                    
                                    <th class="width_10_p"><?php echo app('translator')->get('index.material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.mat_type'); ?></th>
                                    
                                    <th class="width_10_p"><?php echo app('translator')->get('index.customer'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.stock'); ?></th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.alter_level'); ?></th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.floating_stock'); ?></th>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(getStockCustomerNameById($value->customer_id) == 'Danish'): ?>
                                        <tr>
                                            <td><?php echo e($i++); ?></td>
                                            <td title="<?php echo e(getRMName($value->mat_id)); ?>"><?php echo e(substr_text(getRMName($value->mat_id),30)); ?></td>
                                            <td>
                                                <?php if($value->mat_type == 1): ?>
                                                    Material
                                                <?php elseif($value->mat_type == 2): ?>
                                                    Raw Material
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            
                                            <?php if(!$value->customer_id): ?>
                                            <td title="<?php echo e(getStockCustomerNameById($value->customer_id)); ?>"><?php echo e(substr_text(getStockCustomerNameById($value->customer_id),30)); ?></td>
                                            <?php else: ?>
                                            <td title="<?php echo e(getStockCustomerNameById($value->customer_id)); ?>"><?php echo e(substr_text(getStockCustomerNameById($value->customer_id),30)); ?><br><small>(<?php echo e(getCustomerCodeById($value->customer_id)); ?>)</small></td>
                                            <?php endif; ?>
                                            <td><?php echo e($value->current_stock); ?> <?php echo e(getRMUnitById($value->unit_id)); ?><div id="qty_msg"></div></td>
                                            <td><?php echo e($value->close_qty); ?> <?php echo e(getRMUnitById($value->unit_id)); ?></td>
                                            <td><?php echo e($value->float_stock); ?> <?php echo e(getRMUnitById($value->unit_id)); ?></td>
                                            <td>
                                                <a class="button-info" id="stockAdjBtn" data-bs-toggle="modal" data-id="<?php echo e($value->id); ?>" data-mat_id="<?php echo e($value->mat_id); ?>" data-customer_id="<?php echo e($value->customer_id); ?>" data-material="<?php echo e(getRMName($value->mat_id)); ?>" data-bs-target="#stockAdjModal" title="Stock Adjustment"><i class="fa fa-pencil"></i></a>
                                                <a href="<?php echo e(url('material_stocks')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/stock_adjustments" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Stock Adjustments"><i class="fa fa-list"></i></a>
                                                <?php if(routePermission('material_stocks.edit') && !$value->used_in_manufacture): ?>
                                                    <a href="<?php echo e(url('material_stocks')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit"
                                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if(routePermission('material_stocks.delete') && !$value->used_in_manufacture): ?>
                                                    <a href="#" class="delete button-danger"
                                                        data-form_class="alertDelete<?php echo e($value->id); ?>" type="submit"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.delete'); ?>">
                                                        <form action="<?php echo e(route('material_stocks.destroy', $value->id)); ?>"
                                                            class="alertDelete<?php echo e($value->id); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                                        </form>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                    <div class="table-responsive">
                        <table class="table table-striped material_table">
                            <thead>
                                <tr>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.mat_type'); ?></th>
                                    
                                    <th class="width_10_p"><?php echo app('translator')->get('index.customer'); ?><br>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.stock'); ?></th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.alter_level'); ?></th>
                                    <th class="width_10_p"><?php echo app('translator')->get('index.floating_stock'); ?></th>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $obj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(getStockCustomerNameById($value->customer_id) != 'Danish'): ?>
                                        <tr>
                                            <td class="c_center"><?php echo e($i++); ?></td>
                                            <td title="<?php echo e(getRMName($value->mat_id)); ?>"><?php echo e(substr_text(getRMName($value->mat_id),30)); ?></td>
                                            <td>
                                                <?php if($value->mat_type == 1): ?>
                                                    Material
                                                <?php elseif($value->mat_type == 2): ?>
                                                    Raw Material
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            
                                            <?php if(!$value->customer_id): ?>
                                            <td title="<?php echo e(getStockCustomerNameById($value->customer_id)); ?>"><?php echo e(substr_text(getStockCustomerNameById($value->customer_id),30)); ?></td>
                                            <?php else: ?>
                                            <td title="<?php echo e(getStockCustomerNameById($value->customer_id)); ?>"><?php echo e(substr_text(getStockCustomerNameById($value->customer_id),30)); ?><br><small>(<?php echo e(getCustomerCodeById($value->customer_id)); ?>)</small></td>
                                            <?php endif; ?>
                                            <td><?php echo e($value->current_stock); ?> <?php echo e(getRMUnitById($value->unit_id)); ?><div id="qty_msg"></div></td>
                                            <td><?php echo e($value->close_qty); ?> <?php echo e(getRMUnitById($value->unit_id)); ?></td>
                                            <td><?php echo e($value->float_stock); ?> <?php echo e(getRMUnitById($value->unit_id)); ?></td>
                                            <td>
                                                <a class="button-info" id="stockAdjBtn" data-bs-toggle="modal" data-id="<?php echo e($value->id); ?>" data-mat_id="<?php echo e($value->mat_id); ?>" data-customer_id="<?php echo e($value->customer_id); ?>" data-material="<?php echo e(getRMName($value->mat_id)); ?>" data-bs-target="#stockAdjModal" title="Stock Adjustment"><i class="fa fa-pencil"></i></a>
                                                <a href="<?php echo e(url('material_stocks')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/stock_adjustments" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Stock Adjustments"><i class="fa fa-list"></i></a>
                                                <?php if(routePermission('material_stocks.edit') && !$value->used_in_manufacture): ?>
                                                    <a href="<?php echo e(url('material_stocks')); ?>/<?php echo e(encrypt_decrypt($value->id, 'encrypt')); ?>/edit"
                                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.edit'); ?>"><i class="fa fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if(routePermission('material_stocks.delete') && !$value->used_in_manufacture): ?>
                                                    <a href="#" class="delete button-danger"
                                                        data-form_class="alertDelete<?php echo e($value->id); ?>" type="submit"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo app('translator')->get('index.delete'); ?>">
                                                        <form action="<?php echo e(route('material_stocks.destroy', $value->id)); ?>"
                                                            class="alertDelete<?php echo e($value->id); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                                        </form>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('index.rm_stocks'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::model(isset($mat_type) && $mat_type ? $mat_type : '', [
                            'id' => 'add_form',
                            'method' => 'GET',
                            'enctype' => 'multipart/form-data',
                            'route' => ['material_stocks.index'],
                        ]); ?>

                        <?php echo csrf_field(); ?>
                        <div class="row">                            
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.mat_type'); ?> </label>
                                    <select name="mat_type" id="mat_type" class="form-control select2">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <option value="1" <?php echo e(isset($mat_type) && $mat_type == "1" ? 'selected' : ''); ?>>Material</option>
                                        <option value="2" <?php echo e(isset($mat_type) && $mat_type == "2" ? 'selected' : ''); ?>>Raw Material</option>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.material'); ?> </label>
                                    <select name="mat_id" id="mat_id" class="form-control select2">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($mat_id)): ?>
                                            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>"
                                                    <?php echo e(isset($mat_id) && $mat_id == $value->id ? 'selected' : ''); ?>>
                                                    <?php echo e($value->name); ?> - <?php echo e($value->code); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" name="submit" value="submit"
                                    class="btn w-100 bg-blue-btn"><?php echo app('translator')->get('index.submit'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
        <div class="modal fade" id="stockAdjModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.stock_adjustment'); ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-2" id="selected_material">
                                    
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->get('index.stock_type'); ?><span class="ir_color_red">*</span></label>
                                        <select class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="stock_type" id="stock_type">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            <option value="purchase"><?php echo app('translator')->get('index.purchase_order'); ?></option>
                                            <option value="customer"><?php echo app('translator')->get('index.customer_order_no'); ?></option>
                                        </select>
                                        <p class="text-danger stock_type_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2 d-none" id="select_ref_no">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->get('index.po_no'); ?><span class="ir_color_red">*</span></label>
                                        <select class="form-control <?php $__errorArgs = ['reference_no_purchase'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="reference_no_purchase" id="reference_no">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        </select>
                                        <p class="text-danger reference_no_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6 d-none" id="inp_ref_no_div">
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('index.reference_no'); ?> <span class="required_star">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['reference_no_customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="reference_no_customer" id="inp_ref_no" placeholder="<?php echo app('translator')->get('index.po_no'); ?>" readonly>
                                        <p class="text-danger reference_no_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->get('index.adj_type'); ?><span class="ir_color_red">*</span></label>
                                        <input type="hidden" name="mat_stock_id" id="mat_stock_id">
                                        <input type="hidden" name="mat_id" id="stk_mat_id">
                                        <input type="hidden" name="customer_id" id="customer_id">
                                        <input type="hidden" name="reference_no" id="reference_no_hidden">
                                        <select class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="adj_type" id="adj_type">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            <option value="addition"><?php echo app('translator')->get('index.addition'); ?></option>
                                            <option value="subtraction"><?php echo app('translator')->get('index.subtraction'); ?></option>
                                        </select>
                                        <p class="text-danger material_id_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo app('translator')->get('index.quantity'); ?><span class="ir_color_red"> *</span></label>
                                        <div>
                                            <input type="number" class="form-control" name="quantity" id="stock_qty" placeholder="Quantity" value="" min="1">
                                        </div>
                                        <p class="text-danger quantity_error"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>DC No <span class="required_star">*</span></label>
                                        <input type="text" name="dc_no" class="form-control" id="dc_no" placeholder="DC No" >
                                        <p class="text-danger dc_no_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>Heat No <span class="required_star">*</span></label>
                                        <input type="text" name="heat_no" class="form-control" id="heat_no" placeholder="Heat No">
                                        <p class="text-danger heat_no_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>DC Date <span class="required_star">*</span></label>
                                        <?php echo Form::text('date', date('d-m-Y'), [
                                            'class' => 'form-control',
                                            'placeholder' => 'DC Date',
                                            'id' => 'dc_date',
                                        ]); ?>

                                        <p class="text-danger dc_date_err"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>Material Doc No</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['mat_doc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="mat_doc_no" id="mat_doc_no" placeholder="Material Doc No">
                                        <p class="text-danger mat_doc_no_err"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn stock_adjust_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.submit'); ?></button>
                    </div>
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
    $('#adj_type').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#stock_type').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#reference_no').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#mat_id').select2({
        dropdownParent: $('#filterModal')
    });
    $('#mat_type').select2({
        dropdownParent: $('#filterModal')
    });
    $('#ins_type').select2({
        dropdownParent: $('#filterModal')
    });
    /* Filter */
    $(document).on("change", "#mat_type", function () {
        let mat_type = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        // if(mat_type=="3") {
        //     $("#ins_type_div").removeClass('d-none');
        //     $("#ins_type").trigger("change");
        // } else {
        //     $("#ins_type_div").addClass('d-none');
        //     $("#ins_type").val('');
        // }
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialByMatType",
            data: { mat_type: mat_type },
            dataType: "json",
            success: function (data) {
                let materials = data;
                let select = $("#mat_id");
                select.empty();
                select.append('<option value="">Please Select</option>');
                materials.forEach(function (item) {
                    if (item) {
                        let id = item.id;
                        let name = item.name;
                        let code = item.code ?? '';
                        select.append('<option value="' + id + '|' + name + '|' + code + '">' + name + '</option>');
                    }
                });
                // $(".select2").select2();
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    });
    /* $(document).on("change", "#ins_type", function () {
        let mat_type = $("#mat_type").val();
        let ins_type = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialByMatInsType",
            data: { mat_type: mat_type, ins_type: ins_type },
            dataType: "json",
            success: function (data) {
                let materials = data;
                let select = $("#mat_id");
                select.empty();
                select.append('<option value="">Please Select</option>');
                materials.forEach(function (item) {
                    if (item) {
                        let id = item.id;
                        let name = item.name;
                        let code = item.code ?? '';
                        select.append('<option value="' + id + '|' + name + '|' + code + '">' + name + '</option>');
                    }
                });
                // $(".select2").select2();
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    }); */
    $(document).on("click", "#stockAdjBtn", function (e) {
        e.preventDefault();
        var mat_stock_id = $(this).data('id');
        $('#mat_stock_id').val(mat_stock_id);
        var mat_id = $(this).data('mat_id');
        $('#stk_mat_id').val(mat_id);
        var customer_id = $(this).data('customer_id');
        $('#customer_id').val(customer_id);
        var material = $(this).data('material');
        $('#selected_material').html('<p>'+material+'</p>');
        $('#stock_type').val("").trigger('change.select2');
        $('#reference_no').val("").trigger('change.select2');
        $("#select_ref_no").addClass("d-none");
        $("#inp_ref_no_div").addClass("d-none");
        $('#inp_ref_no').val("");
        $('#stock_qty').val("");
        $('#adj_type').val("").trigger('change.select2');
        $(".quantity_error").html("");
        $(".stock_type_err").html("");
        $(".reference_no_err").html("");
        $(".material_id_err").html("");
    });
    $(document).on("change", "#stock_type", function (e) {
        let hidden_base_url = $("#hidden_base_url").val();
        let stock_type = $("#stock_type").val();
        var mat_id = $("#stk_mat_id").val();
        var customer_id = $("#customer_id").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getStockReference",
            data: { stock_type: stock_type, mat_id: mat_id, customer_id: customer_id },
            dataType: "html",
            success: function (data) {
                if (typeof data === "string") {
                    data = JSON.parse(data);
                }
                if(data.type==="purchase") {
                    $("#reference_no").html(data.html);
                    $("#select_ref_no").removeClass("d-none");
                    $("#inp_ref_no_div").addClass("d-none");
                    $("#inp_ref_no").val("");
                    $("#stock_qty").val("");
                } else {
                    $("#select_ref_no").addClass("d-none");
                    $("#inp_ref_no_div").removeClass("d-none");
                    $("#inp_ref_no").val(data.html);
                    $("#stock_qty").val(data.qty);
                    $("#stock_qty").attr("max", data.qty);
                }
            },
            error: function () {
                console.log("error");
            },
        });
    });
    $(document).on("change", "#reference_no", function (e) {
        let selected = $(this).val();
        let split = selected.split('|');
        $("#stock_qty").val(split[1]);
        $("#stock_qty").attr("max", split[1]);
    });
    $("#stock_qty").on("input", function () {
        let enteredQty = parseFloat($(this).val());
        let maxQty = parseFloat($(this).attr("max"));
        if (enteredQty > maxQty) {
            $(this).val(maxQty);
            $(".quantity_error").text("Quantity cannot exceed ordered quantity.");
        } else {
            $(".quantity_error").text("");
        }
    });
    $(document).on("click", ".stock_adjust_btn", function (e) {
        e.preventDefault();
        let status = true;
        let hidden_base_url = $("#hidden_base_url").val();
        let mat_stock_id = $("#mat_stock_id").val();
        let mat_id = $("#stk_mat_id").val();
        let adj_type = $("#adj_type").val();
        let stock_type = $("#stock_type").val();
        let dc_no = $("#dc_no").val();
        let heat_no = $("#heat_no").val();
        let dc_date = $("#dc_date").val();
        let mat_doc_no = $("#mat_doc_no").val();
        let reference_no = "";
        if (stock_type === "purchase") {
            reference_no = $("#reference_no").val().split('|')[0];
        } else if (stock_type === "customer") {
            reference_no = $("#inp_ref_no").val();
        }
        $("#reference_no_hidden").val(reference_no);
        let stock_qty = $("#stock_qty").val();
        if(adj_type == "") {
            $(".material_id_err").text("The Adjustment Type field is required.");
            status = false;
        } else {
            $(".material_id_err").text("");
        }
        if(stock_qty == "") {
            $(".quantity_error").text("The Quantity field is required.");
            status = false;
        } else {
            $(".quantity_error").text("");
        }
        if(stock_type == "") {
            $(".stock_type_err").text("The Stock Type field is required.");
            status = false;
        } else {
            $(".stock_type_err").text("");
        }
        if(dc_no == "") {
            $(".dc_no_err").text("The DC No field is required.");
            status = false;
        } else {
            $(".dc_no_err").text("");
        }
        if(heat_no == "") {
            $(".heat_no_err").text("The Heat No field is required.");
            status = false;
        } else {
            $(".heat_no_err").text("");
        }
        if(dc_date == "") {
            $(".dc_date_err").text("The DC Date field is required.");
            status = false;
        } else {
            $(".dc_date_err").text("");
        }
        // if(mat_doc_no == "") {
        //     $(".mat_doc_no_err").text("The Material Doc No field is required.");
        //     status = false;
        // } else {
        //     $(".mat_doc_no_err").text("");
        // }
        if (reference_no === "") {
            if (stock_type === "purchase") {
                $(".reference_no_err").text("The PO Number field is required.");
            } else {
                $(".reference_no_err").text("The PO Number field is required.");
            }
            status = false;
        } else {
            $(".reference_no_err").text("");
        }
        if(status==false){
            return false;
        }
        $.ajax({
            type: "POST",
            url: hidden_base_url + "materialStockAdjust",
            data: { mat_stock_id: mat_stock_id, adj_type: adj_type, stock_qty: stock_qty, mat_id:mat_id, stock_type: stock_type, reference_no: reference_no, dc_no: dc_no, heat_no: heat_no, dc_date: dc_date, mat_doc_no: mat_doc_no },
            dataType: "json",
            success: function (data) {
                const modalEl = document.getElementById('stockAdjModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                let hidden_alert = data.status ? "Success" : "Error";
                let hidden_cancel = $("#hidden_cancel").val();
                let hidden_ok = $("#hidden_ok").val();
                swal({
                    title: hidden_alert + "!",
                    text: data.message,
                    cancelButtonText: hidden_cancel,
                    confirmButtonText: hidden_ok,
                    confirmButtonColor: "#3c8dbc",
                }, function () {
                    location.reload();
                });
            },
            error: function () {},
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/material_stock/materialstocks.blade.php ENDPATH**/ ?>