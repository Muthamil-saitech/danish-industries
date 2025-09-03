

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
    <link rel="stylesheet" href="<?php echo e($baseURL . 'assets/bower_components/jquery-ui/jquery-ui.css'); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <input type="hidden" id="edit_mode" value="<?php echo e(isset($obj) && $obj ? $obj->id : null); ?>">
    <section class="main-content-wrapper">
        <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <section class="content-header">
            <h3 class="top-left-header">
                <?php echo e(isset($title) && $title ? $title : ''); ?>

            </h3>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'manufacture_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['productions.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <?php echo Form::hidden('stage_counter', null, ['class' => 'stage_counter', 'id' => 'stage_counter']); ?>

                <?php echo Form::hidden('stage_name', null, ['class' => 'stage_name', 'id' => 'stage_name']); ?>

                <div>
                    <div class="row">
                        
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)<span class="required_star">*</span></label>
                                <input type="hidden" name="selected_customer_id" id="selected_customer_id" value="<?php echo e(isset($selected_customer_id) ? $selected_customer_id : old('selected_customer_id')); ?>" >
                                <select class="form-control customer_id_c1 select2" name="customer_id" id="customer_id" <?php echo e(isset($selected_customer_id) ? 'disabled' : ''); ?>>
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>"
                                            <?php echo e(old('customer_id', $selected_customer_id ?? ($obj->customer_id ?? '')) == $value->id ? 'selected' : ''); ?>>
                                            <?php echo e($value->name); ?> (<?php echo e($value->customer_id); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.po_no'); ?><span class="required_star">*</span></label>
                                <input type="hidden" name="selected_customer_order_id" value="<?php echo e(isset($selected_customer_order_id) ? $selected_customer_order_id : old('selected_customer_order_id')); ?>" >
                                <select class="form-control customer_order_id_c1 select2" name="customer_order_id" id="customer_order_id" <?php echo e(isset($selected_customer_order_id) ? 'disabled' : ''); ?>>
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $customerOrderList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>"
                                            <?php echo e(old('customer_order_id', $selected_customer_order_id ?? ($obj->customer_order_id ?? '')) == $value->id ? 'selected' : ''); ?>>
                                            <?php echo e($value->reference_no); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['customer_order_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.start_date'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="start_date_m" id="start_date"
                                    class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly
                                    placeholder="Start Date"
                                    value="<?php echo e(isset($obj->start_date) ? date('d-m-Y',strtotime($obj->start_date)) : old('start_date_m')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.delivery_date'); ?> </label>
                                <input type="text" name="complete_date_m" id="complete_date"
                                    class="form-control <?php $__errorArgs = ['complete_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.delivery_date'); ?>"
                                    value="<?php echo e(isset($obj->complete_date) ? date('d-m-Y',strtotime($obj->complete_date)) : old('complete_date_m')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['complete_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="customer_order_area" class="row"></div>
                        <div class="clearfix"></div>
                        <?php $st_method = ''; ?>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.part_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)<span class="required_star">*</span></label>
                                <?php if(isset($obj->product_id) && $obj->product_id !== ''): ?>
                                    <input type="hidden" name="product_id" id="fproduct_id" value="<?php echo e(isset($obj) ? $obj->product_id : old('product_id')); ?>">
                                    <input type="text"
                                        class="form-control <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> check_required"
                                        id="fproduct_id" value="<?php echo e(getProductNameById($obj->product_id)); ?>" readonly>
                                    <?php
                                    if (isset($obj->product_id) && $obj->product_id) {
                                        $st_method = $obj->product->stock_method;
                                    }
                                    ?>
                                <?php else: ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($selected_product_id ?? ''); ?>">
                                    <select
                                        class="form-control <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 fproduct_id check_required" name="product_id" id="fproduct_id" <?php echo e(isset($selected_product_id) ? 'disabled' : ''); ?>>
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($manufactures) && $manufactures): ?>
                                            <?php $__currentLoopData = $manufactures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    <?php echo e(isset($selected_product_id) && $selected_product_id == $value->id ? 'selected' : ''); ?>

                                                    value="<?php echo e($value->id . '|' . $value->stock_method); ?>">
                                                    <?php echo e($value->name); ?> (<?php echo e($value->code); ?>)</option>
                                                <?php
                                                if (isset($selected_product_id) && $selected_product_id == $value->id) {
                                                    $st_method = $selected_st_method;
                                                }
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.prod_quantity'); ?> <span class="required_star">*</span></label>
                                <input type="number" name="product_quantity" id="product_quantity"
                                    class="check_required form-control <?php $__errorArgs = ['product_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> product_quantity"
                                    placeholder="<?php echo app('translator')->get('index.prod_quantity'); ?>"
                                    value="<?php echo e(isset($obj->product_quantity) ? $obj->product_quantity : old('product_quantity')); ?>" readonly>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['product_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.mat_type'); ?> <span class="required_star">*</span></label>
                                <?php if(isset($obj->stk_mat_type) && $obj->stk_mat_type !== ''): ?>
                                    <input type="hidden" name="stk_mat_type" id="stk_mat_type" value="<?php echo e($obj->stk_mat_type); ?>">
                                    <input type="text"
                                        class="form-control <?php $__errorArgs = ['stk_mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> check_required"
                                        id="stk_mat_type" value="<?php echo e(getMaterialType($obj->stk_mat_type)); ?>" readonly>
                                <?php else: ?>
                                    <select class="form-control <?php $__errorArgs = ['stk_mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="stk_mat_type" id="stk_mat_type">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <option value="1" <?php echo e((isset($obj->stk_mat_type) && $obj->stk_mat_type == 1) || old('stk_mat_type') == 1 ? 'selected' : ''); ?>>Material</option>
                                        <option value="2" <?php echo e((isset($obj->stk_mat_type) && $obj->stk_mat_type == 2) || old('stk_mat_type') == 2 ? 'selected' : ''); ?>>Raw Material</option>
                                    </select>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['stk_mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div> 
                        
                        
                        <div class="col-sm-12 mb-2 col-md-2">
                            <div class="form-group">
                                <button id="pr_go"
                                    class="btn bg-blue-btn w-100 goBtn govalid <?php echo e(isset($obj) ? 'disabled' : ''); ?>"><span
                                        class="me-2"><?php echo app('translator')->get('index.go'); ?></span> <iconify-icon
                                        icon="solar:arrow-right-broken"></iconify-icon></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row <?php echo e(isset($obj) ? '' : 'hidden_sec'); ?>">
                        <div class="col-md-12">
                            <h4 class="mb-0"><?php echo app('translator')->get('index.raw_material_consumption_cost'); ?> (BoM)</h4>
                            <div class="table-responsive" id="fprm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th class="w-30"><?php echo app('translator')->get('index.material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                            <th class="w-30"><?php echo app('translator')->get('index.stock'); ?></th>
                                            
                                            <th class="w-20"> <?php echo app('translator')->get('index.consumption'); ?> <span class="required_star">*</span>
                                            </th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="add_trm">
                                        <?php if(isset($m_rmaterials) && $m_rmaterials): ?>
                                            <?php $__currentLoopData = $m_rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="rowCount" data-id="<?php echo e($value->rmaterials_id); ?>">
                                                    <td class="width_1_p text-start">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="<?php echo e($value->stock_id); ?>"
                                                            name="stock_id[]">
                                                        <input type="hidden" value="<?php echo e($value->rmaterials_id); ?>"
                                                            name="rm_id[]" class="rm_id">
                                                        <span><?php echo e(getRMName($value->rmaterials_id)); ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden"
                                                            id="mat_stock" name="stock[]"       
                                                            class="check_required form-control"
                                                            value="<?php echo e($value->stock); ?>"
                                                            placeholder="Stock">
                                                        <p id="show_stock"><?php echo e($value->stock); ?> <span
                                                            ><?php echo e(getStockUnitById($value->stock_id)); ?></span></p>
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" data-countid="1" tabindex="51"
                                                                id="qty_1" name="quantity_amount[]"
                                                                onfocus="this.select();"
                                                                class="check_required form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk  qty_c cal_row"
                                                                value="<?php echo e($value->consumption); ?>"
                                                                placeholder="Consumption" readonly>
                                                            <span
                                                                class="input-group-text"><?php echo e(getStockUnitById($value->stock_id)); ?></span>
                                                        </div>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <hr>
                    <div class="row <?php echo e(isset($obj) ? '' : 'hidden_sec'); ?>">
                        <div class="clearfix"></div>
                        <h4 class="mb-0"><?php echo app('translator')->get('index.manufacture_stages'); ?></h4>
                        <p class="text-danger stage_check_error d-none"></p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="purchase_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                                <th class="width_20_p stage_header"><?php echo app('translator')->get('index.check'); ?></th>
                                                <th class="width_20_p stage_header text-left">
                                                    <?php echo app('translator')->get('index.stage'); ?></th>
                                                <th class="width_20_p stage_header"><?php echo app('translator')->get('index.required_time'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_tstage">
                                            <?php if(isset($finishProductStage) && $finishProductStage): ?>
                                                <?php
                                                $total_month = 0;
                                                $total_day = 0;
                                                $total_hour = 0;
                                                $total_mimute = 0;
                                                $i = 1;
                                                ?>
                                                <?php $__currentLoopData = $finishProductStage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    $checked = $disabled ='';
                                                    $tmp_key = $key + 1;
                                                    if ($obj->stage_counter == $tmp_key) {
                                                        $checked = 'checked=checked';
                                                    }
                                                    if ($tmp_key < $obj->stage_counter) {
                                                        $disabled = 'disabled';
                                                    }
                                                    $total_value = $value->stage_month * 2592000 + $value->stage_day * 86400 + $value->stage_hours * 3600 + $value->stage_minute * 60;
                                                    $months = floor($total_value / 2592000);
                                                    $hours = floor(($total_value % 86400) / 3600);
                                                    $days = floor(($total_value % 2592000) / 86400);
                                                    $minuts = floor(($total_value % 3600) / 60);
                                                    
                                                    $total_month += $months;
                                                    $total_hour += $hours;
                                                    $total_day += $days;
                                                    $total_mimute += $minuts;
                                                    
                                                    $total_stages = $total_month * 2592000 + $total_hour * 3600 + $total_day * 86400 + $total_mimute * 60;
                                                    $total_months = floor($total_stages / 2592000);
                                                    $total_hours = floor(($total_stages % 86400) / 3600);
                                                    $total_days = floor(($total_stages % 2592000) / 86400);
                                                    $total_minutes = floor(($total_stages % 3600) / 60);
                                                    
                                                    ?>
                                                    <tr class="rowCount2 align-baseline"
                                                        data-id="<?php echo e($value->productionstage_id); ?>">
                                                        <td class="width_1_p ir_txt_center">
                                                            <p class="set_sn2"></p>
                                                        </td>
                                                        <td class="width_1_p">
                                                            <input
                                                                class="form-check-input set_class custom_checkbox"
                                                                data-stage_name="<?php echo e(getProductionStages($value->productionstage_id)); ?>"
                                                                type="radio"
                                                                id="checkboxNoLabel_<?php echo e($i); ?>"
                                                                name="stage_check"
                                                                value="<?php echo e($i); ?>"
                                                                <?php echo e($checked); ?>

                                                                <?php echo e($disabled); ?>

                                                            >

                                                            
                                                            <?php if($disabled): ?>
                                                                <input type="hidden" name="stage_check_hidden[]" value="<?php echo e($i); ?>">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="stage_name text-left"><input type="hidden"
                                                                value="<?php echo e($value->productionstage_id); ?>"
                                                                name="producstage_id[]">
                                                            <span><?php echo e(getProductionStages($value->productionstage_id)); ?></span>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                
                                                                
                                                                <div class="col-xl-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning"
                                                                            type="number" id="hours_limit"
                                                                            name="stage_hours[]" min="0"
                                                                            max="24"
                                                                            value="<?php echo e($value->stage_hours); ?>"
                                                                            placeholder="Hours"><span
                                                                            class="input-group-text"><?php echo app('translator')->get('index.hours'); ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning"
                                                                            type="number" id="minute_limit"
                                                                            name="stage_minute[]" min="0"
                                                                            max="60"
                                                                            value="<?php echo e($value->stage_minute); ?>"
                                                                            placeholder="Minutes"><span
                                                                            class="input-group-text"><?php echo app('translator')->get('index.minutes'); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <tr>
                                            <td class="width_1_p"></td>
                                            <td class="width_1_p"></td>
                                            <td class="width_1_p"><?php echo app('translator')->get('index.total'); ?></td>
                                            <td>
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning stage_color"
                                                                readonly type="text" id="t_hours" name="t_hours"
                                                                value="<?php echo e(isset($total_hours) && $total_hours ? $total_hours : ''); ?>"
                                                                placeholder="Hours">
                                                            <span class="input-group-text"><?php echo app('translator')->get('index.hours'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning stage_color"
                                                                readonly type="text" id="t_minute" name="t_minute"
                                                                value="<?php echo e(isset($total_minutes) && $total_minutes ? $total_minutes : ''); ?>"
                                                                placeholder="Minutes">
                                                            <span class="input-group-text"><?php echo app('translator')->get('index.minutes'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div><br>
                    <div class="row <?php echo e(isset($obj) ? '' : 'hidden_sec'); ?>">
                        <div class="clearfix"></div>
                        <h4 class="mb-0"><?php echo app('translator')->get('index.manufacture_scheduling'); ?></h4>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive" id="purchase_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="w-5"></th>
                                                <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                                <th class="w-20"><?php echo app('translator')->get('index.stage'); ?></th>
                                                <th class="w-25">
                                                    <?php echo app('translator')->get('index.task'); ?></th>
                                                <th class="w-25"><?php echo app('translator')->get('index.assign_to'); ?></th>
                                                <th class="w-5"><?php echo app('translator')->get('index.total_hours'); ?></th>
                                                <th class="w-25"><?php echo app('translator')->get('index.task_status'); ?></th>
                                                <th class="w-30"><?php echo app('translator')->get('index.start_date'); ?></th>
                                                <th class="w-25"><?php echo app('translator')->get('index.complete_date'); ?></th>
                                                <th class="w-5 text-center"><?php echo app('translator')->get('index.actions'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_production_scheduling sort_menu">
                                            <?php if(isset($productionScheduling) && $productionScheduling): ?>
                                                <?php ($m = 0); ?>
                                                <?php $__currentLoopData = $productionScheduling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="rowCount3" data-id="<?php echo e($value->production_stage_id); ?>"
                                                        data-row="<?php echo e(++$m); ?>">
                                                        <td><span class="handle me-2"><iconify-icon
                                                                    icon="radix-icons:move"></iconify-icon></span></td>
                                                        <td class="width_1_p text-start">
                                                            <p class="set_sn4"><?php echo e($m); ?></p>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control"
                                                                value="<?php echo e(isset($value->production_stage_id) ? getProductionStage($value->production_stage_id) : ''); ?>"
                                                                disabled>
                                                            <input type="hidden"
                                                                name="productionstage_id_scheduling[]"
                                                                value="<?php echo e(isset($value->production_stage_id) ? $value->production_stage_id . '|' . getProductionStage($value->production_stage_id) : ''); ?>">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" id="manufacture_task" name="task[]"
                                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> changeableInput"
                                                                    value="<?php echo e($value->task); ?>" placeholder="Task">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select
                                                                class="form-control manufacture_stage_id changeableInput"
                                                                name="user_id_scheduling[]"
                                                                id="manufacture_user_id_<?php echo e($m); ?>">
                                                                <option value="" disabled><?php echo app('translator')->get('index.select'); ?></option>
                                                                <?php if(isset($employees) && $employees): ?>
                                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option
                                                                            <?php echo e(isset($value->user_id) && $value->user_id == $emp->id ? 'selected' : ''); ?>

                                                                            value="<?php echo e($emp->id); ?>">
                                                                            <?php echo e($emp->name); ?>(<?php echo e($emp->emp_code); ?>)</option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" name="task_note[]"
                                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> changeableInput"
                                                                    value="<?php echo e($value->task_note); ?>" placeholder="Task Note">
                                                                <input type="number" id="manufacture_task_hours" name="task_hours[]"
                                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> changeableInput"
                                                                    value="<?php echo e($value->task_hours); ?>" placeholder="Task Hours">
                                                            </div>
                                                        </td>                                                        
                                                        <td>
                                                            <input type="hidden" name="task_status[]" class="edit_post_status" value="<?php echo e($value->task_status); ?>">
                                                            <select class="form-control task_status changeableInput" id="task_status_<?php echo e($m); ?>" <?php echo e(isset($value->task_status) && $value->task_status=="3" ? "disabled" : ""); ?>>
                                                                <option value="" disabled><?php echo app('translator')->get('index.select'); ?></option>
                                                                <option <?php echo e(isset($value->task_status) && ($value->task_status == "1" || $value->task_status == "" ) ? 'selected' : ''); ?> value="1">Pending</option>
                                                                <option <?php echo e(isset($value->task_status) && $value->task_status == "2" ? 'selected' : ''); ?> value="2">In Progress</option>
                                                                <option <?php echo e(isset($value->task_status) && $value->task_status == "3" ? 'selected' : ''); ?> value="3">Completed</option>
                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="start_date[]"
                                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> changeableInput pstart_date"
                                                                    value="<?php echo e(date('d-m-Y',strtotime($value->start_date))); ?>"
                                                                    placeholder="Start Date">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    name="complete_date[]"
                                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> changeableInput pcomplete_date"
                                                                    value="<?php echo e(date('d-m-Y',strtotime($value->end_date))); ?>"
                                                                    placeholder="Complete Date">
                                                            </div>
                                                            <p class="text-danger end_date_error d-none"></p>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center" id="qc_msg">
                                                                <?php if(isset($value->task_status) && $value->task_status == "3"): ?>
                                                                <button id="qc_add" data-bs-toggle="modal" data-manufacture_id="<?php echo e($value->manufacture_id); ?>"
                                                                data-production_stage_id="<?php echo e($value->production_stage_id); ?>"
                                                                data-scheduling_id="<?php echo e($value->id); ?>"
                                                                data-bs-target="#qcScheduling" class="btn bg-blue-btn w-20" title="QC Check"
                                                                type="button"><i class="fa fa-list-check"></i></button>&nbsp;
                                                                <button id="qc_view" data-bs-toggle="modal"
                                                                data-manufacture_id="<?php echo e($value->manufacture_id); ?>"
                                                                data-production_stage_id="<?php echo e($value->production_stage_id); ?>"
                                                                data-scheduling_id="<?php echo e($value->id); ?>"
                                                                data-bs-target="#qcView" class="btn bg-blue-btn w-20" title="QC Assignment History"
                                                                type="button"><i class="fa fa-user"></i></button>
                                                                <?php endif; ?>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <button id="scheduling_add" data-bs-toggle="modal"
                                        data-bs-target="#productScheduling" class="btn bg-blue-btn w-20 mt-2"
                                        type="button" <?php echo e(isset($obj) && isset($move_to_next) && $move_to_next =="N" ? "disabled" : ""); ?>><?php echo app('translator')->get('index.add_more'); ?></button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <input type="hidden" name="previous_status"
                                value=<?php echo e(isset($obj->manufacture_status) ? $obj->manufacture_status : null); ?>>
                            <input type="hidden" name="previous_quantity"
                                value="<?php echo e(isset($obj->product_quantity) ? $obj->product_quantity : null); ?>">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.status'); ?> <span class="required_star">*</span></label>
                                <select
                                    class="form-control <?php $__errorArgs = ['manufacture_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 check_required"
                                    name="manufacture_status" id="m_status">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php if(isset($obj) && ($obj->manufacture_status != 'inProgress') || isset($obj) && $obj->stage_counter == 0 || !isset($obj)): ?>
                                    <option id="status_draft"
                                        <?php echo e((isset($obj->manufacture_status) && $obj->manufacture_status == 'draft') || old('manufacture_status') == 'draft' ? 'selected' : ''); ?>

                                        value="draft"><?php echo app('translator')->get('index.draft'); ?></option>
                                    <?php endif; ?>
                                    <option
                                        <?php echo e((isset($obj->manufacture_status) && $obj->manufacture_status == 'inProgress') || old('manufacture_status') == 'inProgress' ? 'selected' : ''); ?>

                                        value="inProgress"><?php echo app('translator')->get('index.in_progress'); ?></option>
                                    <?php if(isset($obj) && ($obj->stage_counter == count($finishProductStage))): ?>
                                        <option <?php echo e((isset($obj->manufacture_status) && $obj->manufacture_status == 'done') || old('manufacture_status') == 'done' ? 'selected' : ''); ?> value="done"><?php echo app('translator')->get('index.done'); ?></option>
                                    <?php endif; ?>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['manufacture_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Rev </label>
                                <input type="text" name="rev" class="form-control" placeholder="Rev" id="rev" value="<?php echo e(isset($obj) ? $obj->rev : ''); ?>" readonly>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['rev'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Operation </label>
                                <input type="text" name="operation" class="form-control" id="operation" placeholder="Operation" value="<?php echo e(isset($obj) ? $obj->operation : ''); ?>" readonly> 
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['operation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.drawer_no'); ?> </label>
                                <input type="text" name="drawer_no" class="form-control" id="drawer_no" placeholder="<?php echo app('translator')->get('index.drawer_no'); ?>" value="<?php echo e(isset($obj) ? $obj->drawer_no : ''); ?>" readonly>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['drawer_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.note'); ?></label>
                                <textarea name="note" id="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Note"><?php echo e(isset($obj->note) ? $obj->note : old('note')); ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group custom_table">
                                <label><?php echo app('translator')->get('index.add_a_file'); ?> (<?php echo app('translator')->get('index.max_size_5_mb'); ?>)</label>
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="100%">
                                                <input type="hidden" name="file_old"
                                                    value="<?php echo e(isset($obj->file) && $obj->file ? $obj->file : ''); ?>">
                                                <input type="file" name="file_button[]" id="file_button"
                                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> file_checker_global image_preview"
                                                    accept="image/png,image/jpeg,image/jgp,image/gif,application/pdf,.doc,.docx"
                                                    multiple>
                                                <p class="text-danger errorFile"></p>
                                                <div class="image-preview-container">
                                                    <?php if(isset($obj->file) && $obj->file): ?>
                                                        <?php ($files = explode(',', $obj->file)); ?>

                                                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php ($fileExtension = pathinfo($file, PATHINFO_EXTENSION)); ?>
                                                            <?php if($fileExtension == 'pdf'): ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/manufacture/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>assets/images/pdf.png"
                                                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            <?php elseif($fileExtension == 'doc' || $fileExtension == 'docx'): ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/manufacture/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>assets/images/word.png"
                                                                        alt="Word Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            <?php else: ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/manufacture/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>uploads/manufacture/<?php echo e($file); ?>"
                                                                        alt="File Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn submit_btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            <button type="button" class="btn bg-blue-btn d-none" id="checkStockButton"
                                data-bs-toggle="modal" data-bs-target="#stockCheck"><iconify-icon
                                    icon="solar:info-circle-broken"></iconify-icon><?php echo app('translator')->get('index.check_stock'); ?></button>
                            <a class="btn bg-second-btn" href="<?php echo e(route('productions.index')); ?>"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <select id="ram_hidden" class="display_none" name="rmaterials_id">
                <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                <?php $__currentLoopData = $rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option id="rmaterials_ids" class="rmaterials_ids"
                        value="<?php echo e($value->id . '|' . $value->unit . '|' . getPurchaseSaleUnitById($value->consumption_unit) . '|' . $setting->currency . '|' . $value->rate_per_consumption_unit . '|' . $value->rate_per_unit . '|' . getPurchaseUnitByRMID($value->id)); ?>">
                        <?php echo e($value->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="noni_hidden" class="display_none" name="noninvemtory_id">
                <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                <?php $__currentLoopData = $nonitem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option id="noninvemtory_ids" class="noninvemtory_ids"
                        value="<?php echo e($value->id . '|' . $value->nin_cost . '|' . $setting->currency); ?>">
                        <?php echo e($value->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="stages_hidden" class="display_none">
                <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                <?php $__currentLoopData = $p_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option id="noninvemtory_ids" class="noninvemtory_ids"
                        value="<?php echo e($value->productionstage_id.'|'.getProductionStage($value->productionstage_id)); ?>">
                        <?php echo e(getProductionStage($value->productionstage_id)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="account_hidden" class="display_none" name="account_id">
                <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option id="account_id" class="account_id" value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select class="form-control d-none" id="task_status_select">
                <option value="" disabled><?php echo app('translator')->get('index.select'); ?></option>
                <option value="1">Pending</option>
                <option value="2">In Progress</option>
                <option value="3">Completed</option>
            </select>
    </section>
    
    <div class="modal fade" id="stockCheck" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.current_stock'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form action="<?php echo e(route('purchase-generate-customer-order')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="table-responsive" id="check_stock_modal_body">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn delivaries_button"><iconify-icon
                                icon="solar:cart-plus-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.purchase'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qcScheduling" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.qc'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="qc_form">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.assign_to'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['qc_user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="qc_user_id" id="qc_user_id">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($qc_employees) && $qc_employees): ?>
                                            <?php $__currentLoopData = $qc_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($emp->id); ?>">
                                                    <?php echo e($emp->name); ?>(<?php echo e($emp->emp_code); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-danger qc_user_error"></p>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.start_date'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="start_date"
                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="qc_start_date" placeholder="Start Date">
                                    <p class="text-danger start_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.complete_date'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="complete_date"
                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="qc_complete_date" placeholder="Complete Date">
                                    <p class="text-danger end_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.note'); ?> </label>
                                    <textarea name="qc_note" id="qc_note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Note" maxlength="100"></textarea>
                                    <input type="hidden" name="manufacture_id" id="manufacture_id">
                                    <input type="hidden" name="production_stage_id" id="production_stage_id">
                                    <input type="hidden" name="scheduling_id" id="scheduling_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn qc_scheduling_btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.add'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="productScheduling" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.add_product_scheduling'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="product_scheduling_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.stage'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="productionstage_id" id="productionstage_id">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($p_stages) && $p_stages): ?>
                                            <?php $__currentLoopData = $p_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->productionstage_id.'|'.getProductionStage($value->productionstage_id)); ?>">
                                                    <?php echo e(getProductionStage($value->productionstage_id)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-danger stage_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.task'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="task"
                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="task"
                                        placeholder="Task">
                                    <p class="text-danger task_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.assign_to'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2"
                                        name="user_id" id="user_id">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php if(isset($employees) && $employees): ?>
                                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($emp->id); ?>">
                                                    <?php echo e($emp->name); ?>(<?php echo e($emp->emp_code); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-danger user_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.total_hours'); ?> <span class="required_star">*</span></label>
                                    <input type="number" name="task_hours"
                                        class="form-control <?php $__errorArgs = ['task_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="task_hours"
                                        placeholder="Task Hours">
                                    <p class="text-danger task_hrs_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.start_date'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="start_date"
                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="ps_start_date" placeholder="Start Date">
                                    <p class="text-danger start_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.complete_date'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="complete_date"
                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="ps_complete_date" placeholder="Complete Date">
                                    <p class="text-danger end_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('index.note'); ?> </label>
                                    <textarea name="task_note" id="task_note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Note" maxlength="100"><?php echo e(isset($obj->task_note) ? $obj->task_note : old('task_note')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn product_scheduling_button"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>
                            <?php echo app('translator')->get('index.add'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qcView" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">QC Assignment History</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                
                    <div class="modal-body">
                        <div class="table-responsive" id="qc_log_modal_body">

                        </div>
                    </div>
                    <input type="hidden" name="qa_manufacture_id" id="qa_manufacture_id">
                    <input type="hidden" name="qa_production_stage_id" id="qa_production_stage_id">
                    <input type="hidden" name="qa_scheduling_id" id="qa_scheduling_id">
                    
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('top_script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'; ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/genchat.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/addManufactures.js?v=2.1'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/imagePreview.js'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/manufacture/addEditManufacture.blade.php ENDPATH**/ ?>