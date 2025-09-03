
<?php $__env->startSection('script_top'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="main-content-wrapper">
        <section class="content-header">
            <h3 class="top-left-header">
                <?php echo e(isset($title) && $title ? $title : ''); ?>

            </h3>
        </section>
        <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="box-wrapper">
            <div class="table-box">
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'sale_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['sales.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.sale_date'); ?> <span class="required_star">*</span></label>
                                <?php echo Form::text('date', isset($obj->sale_date) && $obj->sale_date ? $obj->sale_date : (old('sale_date') ?: date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Sale Date',
                                    'id' => 'sale_date',
                                ]); ?>

                                <div class="text-danger d-none"></div>
                                <?php if($errors->has('date')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.challan_no'); ?> <span class="required_star">*</span></label>
                                <div class="d-flex align-items-center">
                                    <div class="w-100">
                                        <select class="form-control select2" id="challan_id" name="challan_id">
                                            <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                            <?php $__currentLoopData = $delivery_challan_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php echo e(isset($obj->challan_id) && $obj->challan_id == $challan->id ? 'selected' : ''); ?> value="<?php echo e($challan->id); ?>"><?php echo e($challan->challan_no); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="text-danger chlnoErr d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customers'); ?> <span class="required_star">*</span></label>
                                <input type="hidden" name="customer_id" id="customer_id" class="form-control" placeholder="Customer" readonly>
                                <input type="text" name="customer_data" id="customer_data" class="form-control" placeholder="Customer" value="<?php echo e(isset($obj) ? getCustomerNameById($obj->customer_id).'('.getCustomerCodeById($obj->customer_id).')' : ""); ?>" readonly>
                                <div class="text-danger customerErr d-none"></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.part_name'); ?> (<?php echo app('translator')->get('index.part_no'); ?>)<span class="required_star">*</span></label>
                                <select class="form-control select2 select2-hidden-accessible" name="product_id"
                                    id="product_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    
                                </select>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="purchase_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th class="w-30"><?php echo app('translator')->get('index.part_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                            <th class="w-30">SRN</th>
                                            <th class="w-20"><?php echo app('translator')->get('index.sale_price'); ?><span class="required_star">*</span></th>
                                            <th class="w-20"><?php echo app('translator')->get('index.quantity'); ?><span class="required_star">*</span></th>
                                            
                                            <th class="w-5 ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_tr">
                                        <?php if(isset($sale_details) && $sale_details): ?>
                                            <?php $__currentLoopData = $sale_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $productInfo = getFinishedProductInfo($value->product_id);
                                                $manufactureInfo = $value->manufacture_id !=null ? getManufactureInfo($value->manufacture_id) : null;
                                                ?>
                                                <tr class="rowCount" data-id="<?php echo e($value->product_id); ?>">
                                                    <td class="width_1_p text-start">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="<?php echo e($value->product_id); ?>"
                                                            name="selected_product_id[]">
                                                        <span><?php echo e($productInfo->name); ?>(<?php echo e($productInfo->code); ?>)</span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" id="srn_1"
                                                                name="srn[]" onfocus="this.select();"
                                                                class="check_required form-control"
                                                                value="<?php echo e($value->srn); ?>"
                                                                placeholder="SRN" maxlength="50">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" value="<?php echo e($value->manufacture_id); ?>"
                                                            name="rm_id[]">
                                                        <input type="hidden" value="<?php echo e($value->manufacture_id); ?>"
                                                            name="manufacture_id[]">
                                                        <div class="input-group">
                                                            <input type="hidden" name="sale_price[]"
                                                                onfocus="this.select();"
                                                                class="check_required form-control integerchk input_aligning unit_price_c cal_row"
                                                                placeholder="Sale Price" value="<?php echo e($value->unit_price); ?>"
                                                                id="unit_price_1">
                                                            <p>₹<?php echo e($value->unit_price); ?></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="hidden" data-countid="1" id="qty_1"
                                                                name="quantity[]" onfocus="this.select();"
                                                                class="check_required form-control integerchk input_aligning qty_c cal_row"
                                                                value="<?php echo e($value->product_quantity); ?>"
                                                                placeholder="Qty/Amount">
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon  icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="quotation_page" value="0" />
                    <div class="row mt-4">
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.note'); ?></label>
                                <?php echo Form::textarea('note', null, [
                                    'class' => 'form-control',
                                    'id' => 'note',
                                    'placeholder' => 'Note',
                                    'rows' => '3',
                                ]); ?>

                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3">
                            <div class="row w-86 mb-2">
                                <label class="custom_label"><?php echo app('translator')->get('index.subtotal'); ?></label>
                                <div class="input-group">
                                    <?php echo Form::text('subtotal', isset($obj->subtotal) && $obj->subtotal ? $obj->subtotal : null, [
                                        'class' => 'form-control',
                                        'readonly' => '',
                                        'id' => 'subtotal',
                                        'placeholder' => 'Sub Total',
                                        'readonly'
                                    ]); ?>

                                    <span class="input-group-text"><?php echo e($setting->currency); ?></span>
                                </div>
                            </div>
                            
                            <div class="row w-86 mb-2">
                                <label class="custom_label"><?php echo app('translator')->get('index.discount'); ?></label>
                                <div class="input-group">
                                    <?php echo Form::text('discount', null, [
                                        'class' => 'form-control discount cal_sale_row',
                                        'data-special_ignore' => 'ignore',
                                        'id' => 'discount',
                                        'placeholder' => 'Discount',
                                    ]); ?>

                                    <span class="input-group-text"><?php echo e($setting->currency); ?></span>
                                </div>
                            </div>
                            <div class="row w-86 mb-2">
                                <label class="custom_label"><?php echo app('translator')->get('index.g_total'); ?></label>
                                <div class="input-group">
                                    <?php echo Form::text('grand_total', isset($obj->grand_total) && $obj->grand_total ? $obj->grand_total : "", [
                                        'class' => 'form-control',
                                        'readonly' => '',
                                        'id' => 'sgrand_total',
                                        'placeholder' => 'G.Total',
                                        'readonly'
                                    ]); ?>

                                    <span class="input-group-text"><?php echo e($setting->currency); ?></span>
                                </div>
                            </div>

                            <div class="row w-86 mb-2">
                                <label class="custom_label"><?php echo app('translator')->get('index.paid'); ?></label>
                                <div class="input-group">
                                    <?php echo Form::text('paid', isset($obj->paid) && $obj->paid ? $obj->paid : null, [
                                        'class' => 'form-control check_required integerchk',
                                        'placeholder' => 'Paid',
                                        'onfocus' => 'select()',
                                        'id' => 'paid',
                                        'readonly'
                                    ]); ?></td>
                                    <span class="input-group-text"><?php echo e($setting->currency); ?></span>
                                </div>
                                <div class="text-danger paidErr d-none"></div>
                            </div>                            
                            <div class="row w-86 mb-2">
                                <label class="custom_label"><?php echo app('translator')->get('index.due'); ?></label>
                                <div class="input-group">
                                    <?php echo Form::text('due', isset($obj->due) && $obj->due ? $obj->due : null, [
                                        'class' => 'form-control integerchk customer_current_due check',
                                        'readonly' => '',
                                        'placeholder' => 'Due',
                                        'id' => 'due',
                                        'readonly'
                                    ]); ?></td>
                                    <span class="input-group-text"><?php echo e($setting->currency); ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input class="form-control customer_credit_limit" type="hidden" value="<?php echo e(isset($obj->customer_id) ? getCustomerCreditLimit($obj->customer_id) : ''); ?>" />
                    <input class="form-control customer_previous_due" type="hidden" value="<?php echo e(isset($obj->customer_id) ? getCustomerDue($obj->customer_id) : ''); ?>" />
                </div>
                <!-- /.box-body -->

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                        <a class="btn bg-second-btn" href="<?php echo e(route('sales.index')); ?>"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
        </div>
    </section>


    <div class="modal fade" id="customerModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo app('translator')->get('index.add_customer'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.name'); ?><span class="ir_color_red">
                                            *</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Name" value="">
                                        <div class="customer_err_msg_contnr">
                                            <p class="customer_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.phone'); ?> <span
                                            class="required_star">*</span></label>
                                    <div>
                                        <input type="text" class="form-control integerchk" id="phone"
                                            name="phone" placeholder="Phone" value="">
                                        <div class="customer_phone_err_msg_contnr err_cust">
                                            <p class="text-danger customer_phone_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.email'); ?> </label>
                                    <div>
                                        <input type="text" class="form-control" id="emailAddress" name="emailAddress"
                                            placeholder="Email" value="">
                                        <div class="customer_email_err_msg_contnr err_cust">
                                            <p class="text-danger customer_email_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.gst_no'); ?><span class="ir_color_red">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="gst_no" id="gst_no"
                                            placeholder="<?php echo app('translator')->get('index.gst_no'); ?>" value="">
                                        <div class="customer_gst_err_msg_contnr">
                                            <p class="text-danger customer_gst_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.address'); ?></label>
                                    <div>
                                        <textarea class="form-control" rows="3" name="supAddress" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.note'); ?></label>
                                    <div>
                                        <textarea class="form-control" rows="4" name="note" placeholder="Enter ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" value="submit" id="addCustomer"><iconify-icon
                            icon="solar:check-circle-broken"></iconify-icon> <?php echo app('translator')->get('index.submit'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cartPreviewModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo app('translator')->get('index.select_finish_product'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label"><?php echo app('translator')->get('index.name'); ?>: </label>
                            <div class="col-sm-12">
                                <p id="item_name_modal"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="col-sm-12"><?php echo app('translator')->get('index.current_stock'); ?>:  <span id="item_stock_modal"></span></p>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.sale_price'); ?> <span
                                            class="required_star">*</span></label>
                                    <input type="text" autocomplete="off"
                                        class="form-control integerchk1 unit_price_modal" onfocus="select();"
                                        name="unit_price_modal" id="" placeholder="Unit Price" value="">
                                    <input type="hidden" name="item_id_modal" id="item_id_modal" value="">
                                    <input type="hidden" name="item_currency_modal" id="item_currency_modal"
                                        value="">
                                    <input type="hidden" name="item_unit_modal" id="item_unit_modal" value="">
                                    <input type="hidden" name="item_st_method" id="item_st_method" value="">
                                    <input type="hidden" name="item_params" id="item_params" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="custom_label"><?php echo app('translator')->get('index.quantity'); ?> <span
                                        class="required_star">*</span></label>
                                <div class="input-group">
                                    <input type="number" autocomplete="off" min="1"
                                        class="form-control integerchk1" onfocus="select();" name="qty_modal"
                                        id="qty_modal" placeholder="Quantity" value="1">
                                    <span class="input-group-text modal_unit_name"></span>
                                </div>
                            </div>
                            <div class="col-md-12 d-none" id="batch_sec">                                
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            <th class="w-30"><?php echo app('translator')->get('index.batch_no'); ?></th>
                                            <th class="w-30"><?php echo app('translator')->get('index.current_stock'); ?></th>
                                            <th class="w-40"><?php echo app('translator')->get('index.sale_qty'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="batch_table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ir_d_block">
                    <button type="button" class="btn bg-blue-btn" id="addToCart"><iconify-icon
                            icon="solar:add-circle-broken"></iconify-icon><?php echo app('translator')->get('index.add_to_cart'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php
    $baseURL = getBaseURL();
    ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/addSales.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/customer.js'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/sales/addEditSale.blade.php ENDPATH**/ ?>