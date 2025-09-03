

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
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                <?php echo Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'dc_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['quotation.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>


                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.challan_date'); ?> <span class="required_star">*</span></label>
                                <?php echo Form::text('challan_date', isset($obj->challan_date) && $obj->challan_date ? $obj->challan_date : (old('challan_date') ?: date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'id' => 'challan_date',
                                    'placeholder' => 'DC Date',
                                ]); ?>

                                <?php if($errors->has('challan_date')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('challan_date')); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.challan_no'); ?> <span class="required_star">*</span></label>
                                <?php echo Form::text('challan_no', isset($obj->challan_no) && $obj->challan_no ? $obj->challan_no : old('challan_no'), [
                                    'class' => 'check_required form-control',
                                    'id' => 'challan_no',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'DC No',
                                ]); ?>

                                <?php if($errors->has('challan_no')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('challan_no')); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.doc_no'); ?> <span class="required_star">*</span></label>
                                <?php echo Form::text('material_doc_no', isset($obj->material_doc_no) && $obj->material_doc_no ? $obj->material_doc_no : old('material_doc_no'), [
                                    'class' => 'check_required form-control',
                                    'id' => 'material_doc_no',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'Material Doc No',
                                ]); ?>

                                <?php if($errors->has('material_doc_no')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('material_doc_no')); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.customer'); ?> <span class="required_star">*</span></label>
                                <div class="d-flex align-items-center">
                                    <div class="w-100">
                                        <input type="hidden" value="<?php echo e(isset($obj) && $obj ? $obj->customer_id : ''); ?>" name="customer_id">
                                        <select class="form-control select2" id="dccustomer_id" name="customer_id" <?php echo e(isset($obj) && $obj ? 'disabled' : ''); ?>>
                                            <option value=""><?php echo app('translator')->get('index.select_customer'); ?></option>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    <?php echo e(isset($obj->customer_id) && $obj->customer_id == $value->id ? 'selected' : ''); ?>

                                                    value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?> (<?php echo e($value->customer_id); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if($errors->has('dccustomer_id')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('dccustomer_id')); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="text-danger d-none customerErr"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.gst_no'); ?> </label>
                                <?php echo Form::text('customer_gst', isset($obj->customer_gst) && $obj->customer_gst ? $obj->customer_gst : old('customer_gst'), [
                                    'class' => 'form-control',
                                    'id' => 'customer_gst',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'Customer GST',
                                    'readonly' => 'true'
                                ]); ?>

                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.delivery_address'); ?> <span class="required_star">*</span></label>
                                <?php echo Form::textarea('customer_address', isset($obj) ? $obj->customer_address : old('customer_address'), [
                                    'class' => 'form-control',
                                    'id' => 'customer_address',
                                    'placeholder' => 'Customer Address',
                                    'rows' => '3',
                                ]); ?>

                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>PPCRC Number (Part Name) <span class="required_star">*</span></label>
                                <select class="form-control select2 select2-hidden-accessible" name="product_id[]" id="dcproduct_id" multiple <?php echo e(isset($obj) && $obj ? 'disabled' : ''); ?>>
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    
                                </select>
                                <?php if($errors->has('dcproduct_id')): ?>
                                    <div class="error_alert text-danger">
                                        <?php echo e($errors->first('dcproduct_id')); ?>

                                    </div>
                                <?php endif; ?>
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
                                            
                                            <th class="w-50"><?php echo app('translator')->get('index.part_no'); ?></th>
                                            
                                            <th class="w-50"><?php echo app('translator')->get('index.description'); ?></th>
                                            <th class="w-15"><?php echo app('translator')->get('index.prod_quantity'); ?></th>
                                            
                                            
                                            
                                            
                                            
                                            
                                            <th class="w-15"><?php echo app('translator')->get('index.hsn'); ?></th>
                                            <th class="w-15"><?php echo app('translator')->get('index.dc_ref'); ?></th>
                                            <th class="w-15"><?php echo app('translator')->get('index.dc_ref_date'); ?></th>
                                            <th class="w-15"><?php echo app('translator')->get('index.challan_ref'); ?></th>
                                            <th class="w-30 ir_txt_center"><?php echo app('translator')->get('index.remarks'); ?></th>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            <?php if(!isset($obj)): ?><th class="w-5 ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody class="add_tr">
                                        <?php if(isset($quotation_details) && $quotation_details): ?>
                                            <?php $__currentLoopData = $quotation_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $productInfo = getFinishedProductInfo($value->product_id);
                                                ?>
                                                <tr class="rowCount" data-id="<?php echo e($value->product_id); ?>">
                                                    <td class="width_1_p ir_txt_center">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td>
                                                        <span><?php echo e($productInfo->code); ?></span>
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="hidden" value="<?php echo e($productInfo->id.'|'. $value->customer_order_id); ?>" name="selected_product_id[]">
                                                        <span><?php echo e($productInfo->name); ?> (<?php echo e($productInfo->code); ?>)</span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo e($value->product_quantity); ?> <?php echo e(getRMUnitById($value->unit_id)); ?></span>
                                                    </td>
                                                    
                                                    
                                                    
                                                    
                                                    <td>
                                                        <span><?php echo e($productInfo->hsn_sac_no); ?></span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="dc_ref[]" placeholder="DC Reference" rows="3" cols="50" maxlength="50"><?php echo e($value->dc_ref); ?></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dc_ref_date[]" class="form-control dc-ref-date" value="<?php echo e($value->dc_ref_date!='' ? date('d-m-Y',strtotime($value->dc_ref_date)) : date('d-m-Y')); ?>">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="challan_ref[]" placeholder="Challan Reference" rows="3" cols="50" maxlength="50"><?php echo e($value->challan_ref); ?></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="description[]" placeholder="Description" rows="3" cols="50" maxlength="50"><?php echo e($value->description ?? ''); ?></textarea>
                                                    </td>
                                                    
                                                    <?php if(!isset($obj)): ?><td class="ir_txt_center">
                                                        <a class="btn btn-xs del_row dlt_button">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                                        </a>
                                                    </td><?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.note'); ?></label>
                                <?php echo Form::textarea('note', isset($obj) ? $obj->note : '', [
                                    'class' => 'form-control',
                                    'id' => 'note',
                                    'placeholder' => 'Note',
                                    'rows' => '3',
                                ]); ?>

                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
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
                                                <?php $__currentLoopData = $errors->get('file_button.*'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="error_alert text-danger"><?php echo e($message); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <p class="text-danger errorFile"></p>
                                                <div class="image-preview-container">
                                                    <?php if(isset($obj->file) && $obj->file): ?>
                                                        <?php ($files = explode(',', $obj->file)); ?>
                                                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php ($fileExtension = pathinfo($file, PATHINFO_EXTENSION)); ?>
                                                            <?php if($fileExtension == 'pdf'): ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/quotation/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>assets/images/pdf.png"
                                                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            <?php elseif($fileExtension == 'doc' || $fileExtension == 'docx'): ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/quotation/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>assets/images/word.png"
                                                                        alt="Word Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            <?php else: ?>
                                                                <a class="text-decoration-none"
                                                                    href="<?php echo e($baseURL); ?>uploads/quotation/<?php echo e($file); ?>"
                                                                    target="_blank">
                                                                    <img src="<?php echo e($baseURL); ?>uploads/quotation/<?php echo e($file); ?>"
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
                        <div class="col-sm-12 col-md-12 mb-2 d-flex gap-3 flex-column flex-md-row">
                            <input type="hidden" name="button_click_type" id="button_click_type">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                            
                            <a class="btn bg-second-btn" href="<?php echo e(route('quotation.index')); ?>"><iconify-icon
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
                                            <p class="customer_err_msg text-danger"></p>
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
                                            <p class="customer_phone_err_msg text-danger"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo app('translator')->get('index.email'); ?> <span
                                            class="required_star">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="emailAddress" name="emailAddress"
                                            placeholder="Email" value="">
                                        <div class="customer_email_err_msg_contnr err_cust">
                                            <p class="customer_email_err_msg text-danger"></p>
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
                            <label class="col-sm-4 control-label"><?php echo app('translator')->get('index.product_name'); ?> <span
                                    class="required_star">*</span></label>
                            <div class="col-sm-12">
                                <p id="item_name_modal" readonly=""></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo app('translator')->get('index.sale_price'); ?> <span
                                            class="required_star">*</span></label>
                                    <div class="col-sm-12">
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
                            </div>
                            <div class="col-md-6">
                                <label class="custom_label"><?php echo app('translator')->get('index.quantity'); ?> <span class="required_star">*</span></label>
                                <div class="input-group">
                                    <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                                        onfocus="select();" name="qty_modal" id="qty_modal" placeholder="Quantity"
                                        value="1">
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
                    <button type="button" class="btn bg-blue-btn" id="addToCart"><iconify-icon icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.add_to_cart'); ?></button>
                </div>
                <input type="hidden" id="quotation_page" value="1" />
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
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/quotation.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/imagePreview.js'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/quotation/addEdit.blade.php ENDPATH**/ ?>