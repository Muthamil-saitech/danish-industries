

<?php $__env->startSection('script_top'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header"><?php echo e(isset($title) && $title?$title:''); ?></h3>
    </section>
    <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php echo Form::model(isset($customerOrder) && $customerOrder ? $customerOrder : '', [
                'id' => 'customer_order_form',
                'method' => isset($customerOrder) && $customerOrder ? 'PATCH' : 'POST',
                'enctype' => 'multipart/form-data',
                'route' => ['customer-orders.update', isset($customerOrder->id) && $customerOrder->id ? $customerOrder->id : ''],
            ]); ?>

            <?php echo csrf_field(); ?>
            <?php echo $__env->make('pages/customer_order/_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo Form::close(); ?>

        </div>
    </div>
</section>

<div class="modal fade" id="invoiceModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.add_invoice'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.type'); ?><span class="ir_color_red"> *</span></label>
                                <div>
                                    <select class="form-control select2" name="invoice_type" id="invoice_type" placeholder="<?php echo app('translator')->get('index.invoice_type'); ?>">
                                        <option value="Invoice"><?php echo app('translator')->get('index.invoice'); ?></option>
                                        <option value="Quotation"><?php echo app('translator')->get('index.quotation'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.paid_amount'); ?> <span class="required_star">*</span></label>
                                <div>
                                    <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="<?php echo app('translator')->get('index.paid_amount'); ?>" value="" required="">
                                    <div class="paid_amount_err_msg_contnr err_cust">
                                        <p class="paid_amount_err_msg text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.due_amount'); ?></label>
                                <div>
                                    <input type="number" class="form-control" id="due_amount" name="due_amount" placeholder="<?php echo app('translator')->get('index.due_amount'); ?>" value="">
                                    <div class="due_amount_err_msg_contnr err_cust">
                                        <p class="due_amount_err_msg"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.order_due_amount'); ?></label>
                                <div>
                                    <input type="number" class="form-control" id="order_due_amount" name="order_due_amount" placeholder="<?php echo app('translator')->get('index.order_due_amount'); ?>" value="">
                                    <div class="order_due_amount_err_msg_contnr err_cust">
                                        <p class="order_due_amount_err_msg"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="customer_order_id" value="<?php echo e(@$customerOrder->id); ?>">
                <button type="submit" class="btn bg-blue-btn invoice_submit"><iconify-icon icon="solar:check-circle-broken"></iconify-icon> <?php echo app('translator')->get('index.submit'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deliveryModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.add_delivery'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.product'); ?><span class="ir_color_red"> *</span></label>
                                <div>
                                    <?php echo Form::select('product_id', $product, null, ['class'=>'form-control select2', 'id'=>'product_id',  'placeholder'=>'Please Select', 'required']); ?>

                                </div>
                                <p class="text-danger product_error"></p>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.quantity'); ?><span class="ir_color_red"> *</span></label>
                                <div>
                                    <input type="number" class="form-control" name="quantity" id="delivary_quantity" placeholder="Quantity" value="" required="">
                                </div>
                                <p class="text-danger quantity_error"></p>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.delivery_date'); ?> <span class="required_star">*</span></label>
                                <div>
                                    <input type="text" class="form-control customDatepicker" id="ddelivery_date" name="delivery_date" placeholder="Delivery Date" readonly="" required="">
                                </div>
                                <p class="text-danger delivery_date_error"></p>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.delivery_status'); ?> <span class="required_star">*</span></label>
                                <div>
                                    <select class="form-control select2" name="delivery_status" id="delivery_status" placeholder="Please Select" required="">
                                        <option value="In Progress"><?php echo app('translator')->get('index.in_progress'); ?></option>
                                        <option value="Done"><?php echo app('translator')->get('index.done'); ?></option>
                                    </select>
                                </div>
                                <p class="text-danger delivery_status_error"></p>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->get('index.delivery_note'); ?></label>
                                <div>
                                    <textarea tabindex="4" class="form-control" rows="4" name="delivery_note" placeholder="Delivery Note ..."></textarea>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="customer_order_id" value="<?php echo e(@$customerOrder->id); ?>">
                <button type="submit" class="btn bg-blue-btn delivaries_button"><iconify-icon icon="solar:check-circle-broken"></iconify-icon> <?php echo app('translator')->get('index.submit'); ?></button>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="stockCheck" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.current_stock'); ?></h4>                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="fprm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.product_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.current_stock'); ?></th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.need_to_manufacture'); ?></th>                                    
                                </tr>
                            </thead>
                            <tbody class="stock_check_table">
                                
                            </tbody>
                        </table>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn download_button"><iconify-icon icon="solar:download-square-broken"></iconify-icon>
                        <?php echo app('translator')->get('index.download'); ?></button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="estimateCost" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('index.estimate_cost_date'); ?></h4>                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="fprm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="width_1_p"><?php echo app('translator')->get('index.sn'); ?></th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.product_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.quantity'); ?></th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.costing'); ?></th>
                                    <th class="width_20_p"><?php echo app('translator')->get('index.required_time'); ?></th>                                    
                                </tr>
                            </thead>
                            <tbody class="estimate_cost_table">
                                
                            </tbody>
                        </table>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn download_button_cost"><iconify-icon icon="solar:download-square-broken"></iconify-icon>
                        <?php echo app('translator')->get('index.download'); ?></button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="<?php echo $baseURL.'frequent_changing/js/order.js?v=1.0'; ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/customer_order/edit.blade.php ENDPATH**/ ?>