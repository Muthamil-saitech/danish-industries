
<?php $__env->startSection('script_top'); ?>
<?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="main-content-wrapper">
        <section class="content-header">
            <h3 class="top-left-header">
                <?php echo e(isset($title) && $title ? $title : ''); ?>

            </h3>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <!-- form start -->
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'material_stock_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['material_stocks.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.raw_material_name'); ?> (Code) <span class="required_star">*</span></label>
                                <?php if(isset($materials) && $materials): ?>
                                    <select tabindex="4" class="form-control <?php $__errorArgs = ['mat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible" name="mat_id" id="mat_id">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($rm->id.'|'.$rm->name.'|'.$rm->code); ?>" <?php echo e(isset($obj) && $rm->id === $obj->mat_id ? 'selected' : ''); ?>><?php echo e($rm->name); ?> (<?php echo e($rm->code); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php else: ?> 
                                    <select tabindex="4" class="form-control <?php $__errorArgs = ['mat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible" name="mat_id" id="mat_id">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    </select>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['mat_id'];
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
                                <label><?php echo app('translator')->get('index.material_category'); ?> <span class="required_star">*</span></label>
                                <input type="hidden" name="mat_cat_id" class="form-control" id="mat_cat_id" placeholder="<?php echo app('translator')->get('index.material_category'); ?> " value="<?php echo e(isset($obj) && $obj->mat_cat_id!='' ? $obj->mat_cat_id : old('mat_cat_id')); ?>" readonly>
                                <input type="text" name="mat_cat" class="form-control" id="mat_cat" placeholder="<?php echo app('translator')->get('index.material_category'); ?>" value="<?php echo e(isset($obj) ? getCategoryById($obj->mat_cat_id) : old('mat_cat')); ?>" readonly>
                                
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['mat_cat_id'];
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
                        <div class="col-sm-12 mb-2 col-md-4 <?php echo e(isset($obj) && $obj->old_mat_no!='' ? "" : "d-none"); ?>" id="old_mat_no_div">
                            <div class="form-group">
                                <label>Old Material No </label>
                                <input type="text" name="old_mat_no" class="form-control" id="old_mat_no" placeholder="Old Material No" value="<?php echo e(isset($obj) && $obj->old_mat_no!='' ? $obj->old_mat_no : old('old_mat_no')); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.challan_no'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="dc_no" class="form-control" id="dc_no" placeholder="<?php echo app('translator')->get('index.challan_no'); ?>" value="<?php echo e(isset($obj) && $obj->dc_no!='' ? $obj->dc_no : old('dc_no')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['dc_no'];
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
                                <label>Heat No <span class="required_star">*</span></label>
                                <input type="text" name="heat_no" class="form-control" id="heat_no" placeholder="Heat No" value="<?php echo e(isset($obj) && $obj->heat_no!='' ? $obj->heat_no : old('heat_no')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['heat_no'];
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
                                <label>DC Date <span class="required_star">*</span></label>
                                <?php echo Form::text('date', isset($obj->dc_date) && $obj->dc_date ? date('d-m-Y',strtotime($obj->dc_date)) : (old('dc_date') ?: date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'DC Date',
                                    'id' => 'dc_date',
                                ]); ?>

                                <div class="text-danger d-none"></div>
                                <?php if($errors->has('dc_date')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('dc_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.doc_no'); ?></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['mat_doc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="mat_doc_no" id="mat_doc_no" value="<?php echo e(isset($obj->mat_doc_no) && $obj->mat_doc_no ? $obj->mat_doc_no : old('mat_doc_no')); ?>" placeholder="<?php echo app('translator')->get('index.doc_no'); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['mat_doc_no'];
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
                                <select class="form-control <?php $__errorArgs = ['mat_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="mat_type" id="mat_type">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <option <?php echo e((isset($obj->mat_type) && $obj->mat_type == 1) || old('mat_type') == 1 ? 'selected' : ''); ?> value="1">Material</option>
                                    <option <?php echo e((isset($obj->mat_type) && $obj->mat_type == 2) || old('mat_type') == 2 ? 'selected' : ''); ?> value="2">Raw Material</option>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['mat_type'];
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
                        
                        <div class="col-sm-12 mb-2 col-md-4 <?php echo e((isset($obj) && $obj->mat_type == 1) || old('mat_type') == 1 ? '' : 'd-none'); ?>" id="cust_div">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer'); ?> </label>
                                <select class="form-control <?php $__errorArgs = ['mat_cat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="customer_id" id="customer_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php echo e((isset($obj->customer_id) && $obj->customer_id == $value->id) || old('customer_id') == $value->id ? 'selected' : ''); ?>

                                            value="<?php echo e($value->id); ?>"><?php echo e($value->name.'('.$value->customer_id.')'); ?></option>
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
                                <label><?php echo app('translator')->get('index.unit'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['unit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="unit_id" id="unit_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php echo e((isset($obj->unit_id) && $obj->unit_id == $value->id) || old('unit_id') == $value->id ? 'selected' : ''); ?>

                                            value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['unit_id'];
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
                                <label><?php echo app('translator')->get('index.stock_type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['stock_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="stock_type" id="stock_type">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <option value="purchase" <?php echo e((isset($obj->stock_type) && $obj->stock_type == 'purchase') || old('stock_type') == 'purchase' ? 'selected' : ''); ?>><?php echo app('translator')->get('index.purchase_order'); ?></option>
                                    <option value="customer" <?php echo e((isset($obj->stock_type) && $obj->stock_type == 'customer') || old('stock_type') == 'customer' ? 'selected' : ''); ?>><?php echo app('translator')->get('index.customer_order_no'); ?></option>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['stock_type'];
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
                        <div class="col-sm-12 mb-2 col-md-4 <?php echo e(!isset($obj) || (isset($obj) && $obj->stock_type == 'customer') ? 'd-none' : ''); ?>" id="select_ref_no">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.po_no'); ?> <span class="required_star">*</span></label>
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
                                    <?php if(isset($obj) && isset($purchases)): ?>
                                        <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($po->purchase->reference_no); ?>"
                                                <?php echo e((isset($obj->reference_no) && $obj->reference_no == $po->purchase->reference_no) || old('reference_no') == $po->purchase->reference_no ? 'selected' : ''); ?>>
                                                <?php echo e($po->purchase->reference_no); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4 <?php echo e(!isset($obj) || (isset($obj) && $obj->stock_type == 'customer') ? '' : 'd-none'); ?>" id="inp_ref_no_div">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.po_no'); ?> <span class="required_star">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['reference_no_customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="reference_no_customer" id="inp_ref_no" value="<?php echo e(isset($obj->reference_no) ? $obj->reference_no : old('reference_no')); ?>" placeholder="<?php echo app('translator')->get('index.po_no'); ?>" readonly>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <input type="hidden" name="reference_no" id="reference_no_hidden">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.stock'); ?> <span class="required_star">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['current_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="current_stock" id="current_stock" value="<?php echo e(isset($obj->current_stock) ? $obj->current_stock : old('current_stock')); ?>" placeholder="<?php echo app('translator')->get('index.stock'); ?>" min="0" <?php echo e(isset($obj) ? 'readonly' : ''); ?>>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['current_stock'];
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
                                <label><?php echo app('translator')->get('index.alter_level'); ?> </label>
                                <input type="number" class="form-control <?php $__errorArgs = ['close_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="close_qty" id="close_qty" value="<?php echo e(isset($obj->close_qty) && $obj->close_qty ? $obj->close_qty : old('close_qty')); ?>" placeholder="<?php echo app('translator')->get('index.alter_level'); ?>" min="0">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['close_qty'];
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
                                <label><?php echo app('translator')->get('index.mat_price'); ?> </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['material_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="material_price" id="material_price" value="<?php echo e(isset($obj->material_price) && $obj->material_price ? $obj->material_price : old('material_price')); ?>" placeholder="<?php echo app('translator')->get('index.mat_price'); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['material_price'];
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
                                <label><?php echo app('translator')->get('index.hsn_no'); ?> </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['hsn_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hsn_no" id="hsn_no" value="<?php echo e(isset($obj->hsn_no) && $obj->hsn_no ? $obj->hsn_no : old('hsn_no')); ?>" placeholder="<?php echo app('translator')->get('index.hsn_no'); ?>" >
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['hsn_no'];
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
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            <a class="btn bg-second-btn" href="<?php echo e(route('material_stocks.index')); ?>"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script_bottom'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/stock.js?v=1.2'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/material_stock/addEditMaterialStock.blade.php ENDPATH**/ ?>