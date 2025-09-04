

<?php $__env->startSection('script_top'); ?>
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e($baseURL. 'assets/bower_components/jquery-ui/jquery-ui.css'); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <section class="main-content-wrapper">
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
                    'id' => 'product_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['finishedproducts.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]); ?>

                <?php echo csrf_field(); ?>
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.part_no'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="check_required form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.part_no'); ?>" value="<?php echo e(isset($obj->code) ? $obj->code : old('code')); ?>" onfocus="select()">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['code'];
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
                                <label><?php echo app('translator')->get('index.part_name'); ?> <span class="required_star">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="check_required form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.part_name'); ?>" value="<?php echo e(isset($obj) && $obj ? $obj->name : old('name')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['name'];
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
                                <label><?php echo app('translator')->get('index.product_category'); ?> <span class="required_star">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2" name="category"
                                    id="category_id">
                                    <option value=""><?php echo app('translator')->get('index.select_category'); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php echo e(isset($obj->category) && $obj->category == $value->id || old('category') == $value->id ? 'selected' : ''); ?>

                                            value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['category'];
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
                                <label><?php echo app('translator')->get('index.hsn'); ?></label>
                                <input type="text" name="hsn_sac_no" id="hsn_sac_no"
                                    class="check_required form-control <?php $__errorArgs = ['hsn_sac_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.hsn'); ?>" value="<?php echo e(isset($obj) && $obj ? $obj->hsn_sac_no : old('hsn_sac_no')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['hsn_sac_no'];
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
                                <label><?php echo app('translator')->get('index.sin_no'); ?> </label>
                                <input type="text" name="danish_sin_no" id="danish_sin_no"
                                    class="check_required form-control <?php $__errorArgs = ['danish_sin_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="<?php echo app('translator')->get('index.sin_no'); ?>" value="<?php echo e(isset($obj) && $obj ? $obj->danish_sin_no : old('danish_sin_no')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['danish_sin_no'];
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
                                <label>Rev </label>
                                <input type="text" name="rev" class="form-control" placeholder="Rev" value="<?php echo e(isset($obj) ? $obj->rev : old('rev')); ?>">
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
                                <input type="text" name="operation" class="form-control" placeholder="Operation" value="<?php echo e(isset($obj) ? $obj->operation : old('operation')); ?>">
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
                                <label><?php echo app('translator')->get('index.drawer_no'); ?><span class="required_star">*</span></label>
                                <select class="form-control select2" name="drawer_no" id="drawer_no">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $drawers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->drawer_no); ?>"
                                            <?php echo e(old('drawer_no', ($obj->drawer_no ?? '')) == $value->drawer_no ? 'selected' : ''); ?>>
                                            <?php echo e($value->drawer_no); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Scope</label>
                                <input type="text" name="scope" class="form-control" placeholder="Scope" value="<?php echo e(isset($obj) ? $obj->scope : old('scope')); ?>">
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['scope'];
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
                                <label><?php echo app('translator')->get('index.description'); ?> <span class="required_star">*</span></label>
                                <textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('index.description')); ?>" rows="3"><?php echo e(isset($obj) && $obj->description ? $obj->description : old('description')); ?></textarea>
                                <div class="text-danger d-none"></div>
                                <?php $__errorArgs = ['description'];
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
                                <label><?php echo app('translator')->get('index.remarks'); ?></label>
                                <textarea name="remarks" id="remarks" class="form-control <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('index.remarks')); ?>" rows="3"><?php echo e(isset($obj) && $obj->remarks ? $obj->remarks : old('remarks')); ?></textarea>
                                <?php $__errorArgs = ['remarks'];
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
                        <hr>
                        <h4 class=""><?php echo app('translator')->get('index.raw_material_consumption_cost'); ?> (BoM)</h4>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.material_category'); ?><span class="required_star">*</span></label>
                                <select tabindex="4"
                                    class="form-control <?php $__errorArgs = ['mat_cat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible"
                                    name="mat_cat_id" id="mat_cat_id">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $rmaterialcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rmc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($rmc->id); ?>" <?php echo e(isset($fp_rmaterials) && $fp_rmaterials[0]['mat_cat_id'] === $rmc->id ? 'selected' : ''); ?>><?php echo e($rmc->name); ?></option>             
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.raw_material_name'); ?> (Code)<span class="required_star">*</span></label>
                                <?php if(isset($rmaterials) && $rmaterials): ?>
                                    <select tabindex="4" class="form-control <?php $__errorArgs = ['rmaterial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible" name="rmaterial" id="rmaterial">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                        <?php $__currentLoopData = $rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($rm->id.'|'.$rm->name.'|'.$rm->code); ?>"><?php echo e($rm->name); ?> (<?php echo e($rm->code); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php else: ?> 
                                    <select tabindex="4" class="form-control <?php $__errorArgs = ['rmaterial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible" name="rmaterial" id="rmaterial">
                                        <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    </select>
                                <?php endif; ?>  
                                <?php $__errorArgs = ['rmaterial'];
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
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rawmaterialsec" id="purchase_cart">
                                <table class="table">
                                    <thead>
                                        <th class="w-10 text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                        <th class="w-20"><?php echo app('translator')->get('index.raw_material_name'); ?>(<?php echo app('translator')->get('index.code'); ?>)</th>
                                        <th class="w-10 text-end"><?php echo app('translator')->get('index.actions'); ?></th>
                                    </thead>
                                    <tbody class="add_tr">
                                        <?php if(isset($fp_rmaterials) && $fp_rmaterials): ?>
                                            <?php $__currentLoopData = $fp_rmaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="rowCount" data-id="<?php echo e($value->rmaterials_id); ?>">
                                                    <td class="width_1_p">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="<?php echo e($value->rmaterials_id); ?>"
                                                            name="rm_id[]">
                                                        <span><?php echo e(getRMName($value->rmaterials_id)); ?></span>
                                                    </td>
                                                    <td class="text-end"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
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
                    <h4 class=""><?php echo app('translator')->get('index.manufacture_stages'); ?></h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('index.manufacture_stages'); ?></label>
                                <select tabindex="4"
                                    class="form-control <?php $__errorArgs = ['productionstage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 select2-hidden-accessible"
                                    name="productionstage" id="productionstage">
                                    <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                    <?php $__currentLoopData = $productionstage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ps->id . '|' . $ps->name); ?>"><?php echo e($ps->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php $__errorArgs = ['productionstage'];
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
                            <div class="table-responsive" id="purchase_cart">
                                <table class="table" id="drageable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="width_1_p text-start"><?php echo app('translator')->get('index.sn'); ?></th>
                                            <th class="width_20_p stage_header text-left">
                                                <?php echo app('translator')->get('index.stage'); ?></th>
                                            <th class="width_20_p stage_header"><?php echo app('translator')->get('index.required_time'); ?></th>
                                            <th class="width_1_p ir_txt_center"><?php echo app('translator')->get('index.actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_tr2 sort_menu">

                                        <?php if(isset($fp_productionstages) && $fp_productionstages): ?>
                                            <?php
                                                $total_month = 0;
                                                $total_hour = 0;
                                                $total_day = 0;
                                                $total_mimute = 0;
                                            ?>
                                            <?php $__currentLoopData = $fp_productionstages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php                                               

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
                                                <tr class="rowCount2 align-middle ui-state-default" data-id="<?php echo e($value->productionstage_id); ?>">
                                                <td><span class="handle me-2"><iconify-icon icon="radix-icons:move"></iconify-icon></span></td>
                                                    <td class="width_1_p">
                                                        <p class="set_sn2 m-0"></p>
                                                    </td>
                                                    <td class="stage_name text-left"><input type="hidden"
                                                            value="<?php echo e($value->productionstage_id); ?>"
                                                            name="producstage_id[]">
                                                        <span><?php echo e(getProductionStages($value->productionstage_id)); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            

                                                            

                                                            <div class="col-md-6">
                                                                <div class="input-group"><input
                                                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning"
                                                                        type="text" id="hours_limit"
                                                                        name="stage_hours[]" min="0"
                                                                        max="24" value="<?php echo e($value->stage_hours); ?>"
                                                                        placeholder="Hours"><span
                                                                        class="input-group-text"><?php echo app('translator')->get('index.hours'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group"><input
                                                                        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> stage_aligning"
                                                                        type="text" id="minute_limit"
                                                                        name="stage_minute[]" min="0"
                                                                        max="60" value="<?php echo e($value->stage_minute); ?>"
                                                                        placeholder="Minutes"><span
                                                                        class="input-group-text"><?php echo app('translator')->get('index.minutes'); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ir_txt_center"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tr class="align-middle">
                                        <td></td>
                                        <td class="width_1_p"></td>
                                        <td class="width_1_p"><?php echo app('translator')->get('index.total'); ?></td>
                                        <td class="width_20_p stage_header">
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
                                                            readonly type="text" id="t_hours"
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
                                                            readonly type="text" id="t_minute"
                                                            value="<?php echo e(isset($total_minutes) && $total_minutes ? $total_minutes : ''); ?>"
                                                            placeholder="Minutes">
                                                        <span class="input-group-text"><?php echo app('translator')->get('index.minutes'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="width_1_p ir_txt_center"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon><?php echo app('translator')->get('index.submit'); ?></button>
                        <a class="btn bg-second-btn" href="<?php echo e(route('finishedproducts.index')); ?>"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon><?php echo app('translator')->get('index.back'); ?></a>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseURL . 'frequent_changing/js/addFinishedProduct.js?v=1.2'; ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish-industries\resources\views/pages/finished_product/addEditFinishedProduct.blade.php ENDPATH**/ ?>