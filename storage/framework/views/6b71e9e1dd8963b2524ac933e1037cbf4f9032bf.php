<?php
$orderType = isset($customerOrder->order_type) && $customerOrder->order_type ? $customerOrder->order_type : '';
?>
<input type="hidden" name="currency" id="only_currency_sign" value=<?php echo e(getCurrencyOnly()); ?>>
<div>
    <div class="row">
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label><?php echo app('translator')->get('index.po_no'); ?> <span class="required_star">*</span></label>
                <input type="text" name="reference_no" id="code"
                    class="check_required form-control <?php $__errorArgs = ['reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="<?php echo e(__('index.po_no')); ?>"
                    value="<?php echo e(isset($customerOrder->reference_no) ? $customerOrder->reference_no : old('reference_no')); ?>"
                    onfocus="select()" <?php echo e(isset($customerOrder) ? 'readonly' : ''); ?>>
                <div class="text-danger d-none"></div>
                <?php $__errorArgs = ['reference_no'];
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
                <label><?php echo app('translator')->get('index.customer'); ?> <span class="required_star">*</span></label>
                <?php if(isset($customerOrder) && $customerOrder->id): ?>
                <input type="hidden" name="customer_id" value="<?php echo e($customerOrder->customer_id); ?>">
                <select class="form-control select2" disabled>
                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e($customerOrder->customer_id == $key ? 'selected' : ''); ?>>
                        <?php echo e($customer); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php else: ?>
                <select name="customer_id" id="customer_id" class="form-control select2">
                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(old('customer_id') == $key ? 'selected' : ''); ?>>
                        <?php echo e($customer); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>
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
                <label><?php echo app('translator')->get('index.order_type'); ?> <span class="required_star">*</span></label>
                <?php if(isset($customerOrder)): ?>
                <input type="hidden" name="order_type" id="order_type" value="<?php echo e(isset($customerOrder) ? $customerOrder->order_type : ""); ?>">
                <select class="form-control <?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" <?php echo e(isset($customerOrder) ? 'disabled' : ''); ?>>
                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                    <?php $__currentLoopData = $orderTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"
                        <?php echo e(isset($customerOrder->order_type) && $customerOrder->order_type == $key ? 'selected' : ''); ?>>
                        <?php echo e($orderType); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php else: ?>
                <select name="order_type" id="order_type" class="form-control <?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" <?php echo e(isset($customerOrder) ? 'disabled' : ''); ?>>
                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                    <?php $__currentLoopData = $orderTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"
                        <?php echo e(isset($customerOrder->order_type) && $customerOrder->order_type == $key ? 'selected' : ''); ?>>
                        <?php echo e($orderType); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>
                <div class="text-danger d-none"></div>
                <?php $__errorArgs = ['order_type'];
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
                <label><?php echo app('translator')->get('index.po_date'); ?> <span class="required_star">*</span></label>
                <?php echo Form::text('po_date', isset($obj->po_date) && $obj->po_date ? $obj->po_date : (old('po_date') ?: date('d-m-Y')), [
                'class' => 'form-control',
                'id' => 'po_date',
                'placeholder' => 'PO Date',
                ]); ?>

                <?php if($errors->has('po_date')): ?>
                <div class="error_alert text-danger">
                    <?php echo e($errors->first('po_date')); ?>

                </div>
                <?php endif; ?>
                <div class="text-danger d-none"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mb-2 col-lg-8">
            <div class="form-group">
                <label><?php echo app('translator')->get('index.delivery_address'); ?> <span class="required_star">*</span></label>
                <textarea name="delivery_address" id="delivery_address" cols="30" rows="10" class="form-control <?php $__errorArgs = ['delivery_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('index.delivery_address')); ?>"><?php echo e(isset($customerOrder->delivery_address) ? $customerOrder->delivery_address : old('delivery_address')); ?></textarea>
                <div class="text-danger d-none"></div>
                <?php $__errorArgs = ['delivery_address'];
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
        <div class="col-md-12">
            <div class="table-responsive" id="fprm">
                <?php
                $showIColumns = false;
                $showCSColumns = false;
                if (isset($orderDetails)) {
                foreach ($orderDetails as $od) {
                if ($od->inter_state === 'Y') {
                $showIColumns = true;
                }
                if ($od->inter_state === 'N') {
                $showCSColumns = true;
                }
                }
                }
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-50-p"><?php echo app('translator')->get('index.sn'); ?></th>
                            <th class="w-220-p">Part Name(Part No)</th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.raw_material_name'); ?>(Code)</th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.raw_quantity'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.prod_quantity'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.unit_price'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.price'); ?></th>
                            
                            <th class="w-220-p"><?php echo app('translator')->get('index.tax_type'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.inter_state'); ?></th>
                            <th class="w-75-p" id="cgst_th" style="<?php echo e($showCSColumns ? '' : 'display: none;'); ?>">CGST (%)</th>
                            <th class="w-75-p" id="sgst_th" style="<?php echo e($showCSColumns ? '' : 'display: none;'); ?>">SGST (%)</th>
                            <th class="w-150-p" id="igst_th" style="<?php echo e($showIColumns ? '' : 'display: none;'); ?>">IGST (%)</th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.delivery_date'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.tax_amount'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.subtotal'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.production_status'); ?></th>
                            <th class="w-220-p"><?php echo app('translator')->get('index.delivered'); ?> Quantity</th>
                            <?php if(!isset($orderDetails)): ?><th class="ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="add_trm">
                        <?php $i = 0; ?>
                        <?php if(isset($orderDetails) && $orderDetails): ?>
                        <?php $__currentLoopData = $orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $i++; ?>
                        <tr class="rowCount" data-id="<?php echo e($value->id); ?>">
                            <td class="width_1_p ir_txt_center"><?php echo e($i); ?></td>
                            <td>
                                <input type="hidden" name="product[]" value="<?php echo e($value->product_id); ?>">
                                <select id="fproduct_id_<?php echo e($i); ?>"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> fproduct_id select2" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
                                    <option value=""><?php echo app('translator')->get('index.please_select'); ?></option>
                                    <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>" <?php if($product->id == $value->product_id): echo 'selected'; endif; ?>>
                                        <?php echo e($product->name); ?> (<?php echo e($product->code); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="raw_material[]" value="<?php echo e($value->raw_material_id); ?>">
                                <select id="rm_id_<?php echo e($i); ?>"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rm_id select2" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
                                    <option value=""><?php echo app('translator')->get('index.please_select'); ?></option>
                                    <?php $__currentLoopData = $rawMaterialList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($rm->id); ?>"
                                        <?php if($rm->id == optional($value)->raw_material_id): echo 'selected'; endif; ?>>
                                        <?php echo e($rm->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="raw_quantity[]" onfocus="this.select();"
                                    class="check_required form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk rquantity_c"
                                    placeholder="Raw Quantity" value="<?php echo e($value->raw_qty); ?>"
                                    id="rquantity_<?php echo e($i); ?>">
                            </td>
                            <td>
                                <input type="number" name="prod_quantity[]" onfocus="this.select();"
                                    class="check_required form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk pquantity_c"
                                    placeholder="Quantity" value="<?php echo e($value->quantity); ?>"
                                    id="pquantity_<?php echo e($i); ?>">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="sale_price[]" onfocus="this.select();"
                                        class="check_required form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk sale_price_c"
                                        placeholder="Unit Price" value="<?php echo e($value->sale_price); ?>"
                                        id="sale_price_<?php echo e($i); ?>">
                                    <span class="input-group-text"> <?php echo e($setting->currency); ?></span>
                                </div>
                            </td>
                            <td>
                                <input type="number" name="price[]" onfocus="this.select();"
                                    class="check_required form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk price_c"
                                    placeholder="Price" value="<?php echo e($value->price); ?>"
                                    id="price_<?php echo e($i); ?>">
                            </td>
                            
            <td>
                <input type="hidden" name="tax_type[]" value="<?php echo e($value->tax_type); ?>">
                <select id="tax_type_id_<?php echo e($i); ?>"
                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> tax_type_id select2" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
                    <option value=""><?php echo app('translator')->get('index.please_select'); ?></option>
                    <?php $__currentLoopData = $tax_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tax->id); ?>" <?php if($tax->id == $value->tax_type): echo 'selected'; endif; ?>>
                        <?php echo e($tax->tax_type); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>
                <div class="form-group radio_button_problem">
                    <div class="radio">
                        <label>
                            <input tabindex="1" type="radio" name="disabled_inter_state[<?php echo e($i); ?>]" id="inter_state_yes_<?php echo e($i); ?>"
                                value="Y" <?php if(isset($value->inter_state) && $value->inter_state === 'Y'): ?> checked <?php endif; ?> disabled>
                            <?php echo app('translator')->get('index.yes'); ?>
                        </label>
                        <label>
                            <input tabindex="2" type="radio" name="disabled_inter_state[<?php echo e($i); ?>]" id="inter_state_no_<?php echo e($i); ?>"
                                value="N" <?php if(isset($value->inter_state) && $value->inter_state === 'N'): ?> checked <?php endif; ?> disabled>
                            <?php echo app('translator')->get('index.no'); ?>
                        </label>
                    </div>
                    <input type="hidden" name="inter_state[<?php echo e($i); ?>]" value="<?php echo e($value->inter_state); ?>">
                </div>
            </td>
            <td class="cgst_cell" style="<?php echo e(($showCSColumns && $value->inter_state == 'N') ? '' : 'display: none;'); ?>">
                <input type="hidden" name="cgst[]" class="form-control cgst_input" value="<?php echo e($value->cgst); ?>">
                <input type="text" class="form-control cgst_input" value="<?php echo e($value->cgst); ?>" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
            </td>
            <td class="sgst_cell" style="<?php echo e(($showCSColumns && $value->inter_state == 'N') ? '' : 'display: none;'); ?>">
                <input type="hidden" name="sgst[]" class="form-control sgst_input" value="<?php echo e($value->sgst); ?>">
                <input type="text" class="form-control sgst_input" value="<?php echo e($value->sgst); ?>" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
            </td>
            <td class="igst_cell" style="<?php echo e(($showIColumns && $value->inter_state == 'Y') ? '' : 'display: none;'); ?>">
                <input type="hidden" name="igst[]" class="form-control igst_input" value="<?php echo e($value->igst); ?>" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
                <input type="text" class="form-control igst_input" value="<?php echo e($value->igst); ?>">
            </td>
            <td>
                <?php if(isset($orderDetails)): ?>
                <?php echo Form::text('disabled_delivery_date_product[]', $value->delivery_date != '' ? date('d-m-Y', strtotime($value->delivery_date)) : '', [
                'class' => 'form-control order_delivery_date',
                'placeholder' => 'Delivery Date',
                'disabled'
                ]); ?>

                <?php echo Form::hidden('delivery_date_product[]', $value->delivery_date != '' ? date('d-m-Y', strtotime($value->delivery_date)) : ''); ?>

                <?php else: ?>
                <?php echo Form::text('delivery_date_product[]', date('d-m-Y'), [
                'class' => 'form-control order_delivery_date',
                'placeholder' => 'Delivery Date'
                ]); ?>

                <?php endif; ?>
            </td>
            <td>
                <input type="text" name="tax_amount[]" onfocus="this.select();"
                    class="check_required form-control <?php $__errorArgs = ['tax_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk tax_amount_c readonly"
                    placeholder="Tax Amount" value="<?php echo e(number_format($value->tax_amount,2)); ?>"
                    id="tax_amount_<?php echo e($i); ?>">
            </td>
            <td>
                <div class="input-group">
                    <input type="text" id="sub_total_<?php echo e($i); ?>"
                        name="sub_total[]"
                        class="form-control sub_total_c"
                        value="<?php echo e(number_format($value->sub_total,2)); ?>"
                        placeholder="Subtotal"
                        readonly>

                    <span class="input-group-text"> <?php echo e($setting->currency); ?></span>
                </div>
            </td>
            <td>
                <input type="hidden" name="status[]" value="<?php echo e($value->status); ?>">
                <select id="fstatus_id_<?php echo e($i); ?>"
                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> fstatus_id select2" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
                    <option value="none" <?php echo e($value->status == 'none' ? 'selected' : ''); ?>>
                        <?php echo app('translator')->get('index.none'); ?>
                    </option>
                    <option value="in_progress"
                        <?php echo e($value->status == 'in_progress' ? 'selected' : ''); ?>>
                        <?php echo app('translator')->get('index.in_progress'); ?>
                    </option>
                    <option value="done" <?php echo e($value->status == 'done' ? 'selected' : ''); ?>>
                        <?php echo app('translator')->get('index.done'); ?>
                    </option>
                </select>
            </td>
            <td>
                <input type="hidden" name="delivered_qty[]" value="<?php echo e($value->delivered_qty); ?>">
                <input type="number" class="check_required form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> integerchk" placeholder="<?php echo app('translator')->get('index.delivered'); ?>" value="<?php echo e($value->delivered_qty); ?>" id="delivered_<?php echo e($i); ?>" <?php echo e(isset($orderDetails) ? 'disabled' : ''); ?>>
            </td>
            <?php if(!isset($orderDetails)): ?>
            <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon
                        icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
            <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            </tbody>
            </table>
            <?php if(!isset($orderDetails)): ?>
            <button id="finishProduct" class="btn bg-blue-btn w-10 mb-2 mt-2" type="button"><?php echo app('translator')->get('index.add_more'); ?></button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row mt-2 gap-2">
    <button class="btn bg-blue-btn w-20 stockCheck" data-bs-toggle="modal" data-bs-target="#stockCheck"
        type="button"><?php echo app('translator')->get('index.check_stock'); ?></button>
    
</div>
<div class="row mt-3 <?php echo e(isset($orderInvoice) && count($orderInvoice) > 0 ? '' : 'd-none'); ?>"
    id="invoice_quotations_sections">
    <div class="col-md-12">
        <h4 class="header_right"><?php echo app('translator')->get('index.invoice_quotations'); ?></h4>

        <div class="table-responsive" id="fprm">
            <table class="table">
                <thead>
                    <tr>
                        <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                        <th class="width_10_p"><?php echo app('translator')->get('index.type'); ?></th>
                        <th class="width_20_p"><?php echo app('translator')->get('index.date'); ?></th>
                        <th class="width_20_p"><?php echo app('translator')->get('index.amount'); ?></th>
                        <th class="width_20_p"><?php echo app('translator')->get('index.paid'); ?></th>
                        <th class="width_20_p"><?php echo app('translator')->get('index.due'); ?></th>
                        
                        
                    </tr>
                </thead>
                <tbody class="add_order_inv">
                    <?php $i = 0; ?>
                    <?php if(isset($orderInvoice) && $orderInvoice): ?>
                    <?php $__currentLoopData = $orderInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $i++; ?>
                    <tr class="rowCount" data-id="<?php echo e($value->id); ?>">
                        <td class="width_1_p ir_txt_center"><?php echo e($i); ?></td>
                        <td>
                            <input type="text" name="invoice_type[]" value="<?php echo e($value->invoice_type); ?>" id="invoice_type_<?php echo e($i); ?>"
                                class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e(isset($orderDetails) ? 'readonly' : ''); ?>>
                        </td>
                        <td>
                            <input type="hidden" name="invoice_date[]" value="<?php echo e(date('d-m-Y',strtotime($value->invoice_date))); ?>">
                            <?php echo Form::text('invoice_date[]', date('d-m-Y',strtotime($value->invoice_date)), [
                            'class' => 'form-control order_delivery_date',
                            'placeholder' => 'Invoice Date',
                            'disabled'
                            ]); ?>

                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" id="invoice_amount_<?php echo e($i); ?>"
                                    name="invoice_amount[]"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> invoice_amount_c"
                                    value="<?php echo e(round($value->amount)); ?>" placeholder="Amount" <?php echo e(isset($orderDetails) ? 'readonly' : ''); ?>>
                                <span class="input-group-text"> <?php echo e($setting->currency); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" id="paid_amount_<?php echo e($i); ?>"
                                    name="invoice_paid[]"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> paid_amount_c"
                                    value="<?php echo e(round($value->paid_amount)); ?>" placeholder="Paid" <?php echo e(isset($orderDetails) ? 'readonly' : ''); ?>>
                                <span class="input-group-text"> <?php echo e($setting->currency); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" id="due_amount_<?php echo e($i); ?>"
                                    name="invoice_due[]"
                                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> due_amount_c"
                                    value="<?php echo e(round($value->due_amount)); ?>" placeholder="Due" <?php echo e(isset($orderDetails) ? 'readonly' : ''); ?>>
                                <span class="input-group-text"> <?php echo e($setting->currency); ?></span>
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
<div class="row mt-3">
    <div class="col-sm-6 col-md-6 mb-2">
        <div class="form-group">
            <label>Upload Document</label>
            <input type="hidden" name="file_old" value="<?php echo e(isset($obj->file) && $obj->file ? $obj->file : ''); ?>">
            <input type="file" name="file_button" id="file_button"
                class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> file_checker_global image_preview"
                accept="image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx">
            <p class="text-danger errorFile"></p>
            <div class="image-preview-container">
                <?php if(isset($obj->file) && $obj->file): ?>
                <?php ($file = $obj->file); ?>
                
                <?php ($fileExtension = pathinfo($file, PATHINFO_EXTENSION)); ?>
                <?php if($fileExtension == 'pdf'): ?>
                <a class="text-decoration-none"
                    href="<?php echo e($baseURL); ?>uploads/order/<?php echo e($file); ?>"
                    target="_blank">
                    <img src="<?php echo e($baseURL); ?>assets/images/pdf.png"
                        alt="PDF Preview" class="img-thumbnail mx-2"
                        width="100px">
                </a>
                <?php elseif($fileExtension == 'doc' || $fileExtension == 'docx'): ?>
                <a class="text-decoration-none"
                    href="<?php echo e($baseURL); ?>uploads/order/<?php echo e($file); ?>"
                    target="_blank">
                    <img src="<?php echo e($baseURL); ?>assets/images/word.png"
                        alt="Word Preview" class="img-thumbnail mx-2"
                        width="100px">
                </a>
                <?php else: ?>
                <a class="text-decoration-none"
                    href="<?php echo e($baseURL); ?>uploads/order/<?php echo e($file); ?>"
                    target="_blank">
                    <img src="<?php echo e($baseURL); ?>uploads/order/<?php echo e($file); ?>"
                        alt="File Preview" class="img-thumbnail mx-2"
                        width="100px">
                </a>
                <?php endif; ?>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-6 col-md-6 mb-2">
        <div class="form-group">
            <label><?php echo app('translator')->get('index.quotation_note'); ?></label>
            <textarea name="quotation_note" id="quotation_note" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('index.quotation_note')); ?>" rows="3"><?php echo e(isset($customerOrder) ?$customerOrder->quotation_note : ""); ?></textarea>
            <input type="hidden" name="total_subtotal" id="total_subtotal"
                value="<?php echo e(isset($customerOrder->total_amount) ? $customerOrder->total_amount : 0); ?>"
                class="form-control input_aligning" placeholder="<?php echo app('translator')->get('index.total'); ?>"
                readonly="">
        </div>
    </div>

    <div class="col-sm-6 col-md-6 mb-2">
        <div class="form-group">
            <label><?php echo app('translator')->get('index.internal_note'); ?></label>
            <textarea name="internal_note" id="internal_note" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('index.internal_note')); ?>" rows="3"><?php echo e(isset($customerOrder) ?$customerOrder->internal_note : ""); ?></textarea>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
        <button type="submit" name="submit" value="submit"
            class="btn bg-blue-btn order_submit_button"><iconify-icon
                icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
        <a class="btn bg-second-btn" href="<?php echo e(route('customer-orders.index')); ?>"><iconify-icon
                icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
    </div>
</div>
</div>
<select id="hidden_product" class="display_none">
    <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($value->id ?? ''); ?>"><?php echo e($value->name); ?> (<?php echo e($value->code); ?>)</option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<select id="hidden_tax_type" class="display_none">
    <?php $__currentLoopData = $tax_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($value->id ?? ''); ?>"><?php echo e($value->tax_type ?? ''); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<input type="hidden" id="default_currency" value="<?php echo e($setting->currency); ?>" /><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_order/_form.blade.php ENDPATH**/ ?>