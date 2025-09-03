

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
            <h3 class="top-left-header"><?php echo e(isset($title) && $title ? $title : ''); ?></h3>
        </section>
         <?php echo $__env->make('utilities.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="box-wrapper">
            <div class="table-box">
                <!-- form start -->
                <?php echo e(Form::open(['route' => 'payroll.store', 'id' => 'attendance_form', 'method' => 'post'])); ?>

                <div class="row">
                    <div class="col-sm-12 col-md-4 mb-2">
                        <div class="form-group">
                        <label><?php echo app('translator')->get('index.month'); ?> <span class="required_star">*</span></label>
                            <select name="month"
                                class="form-control <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 width_100_p">
                                <option value=""><?php echo app('translator')->get('index.select'); ?></option>
                                <option value="January"><?php echo app('translator')->get('index.january'); ?></option>
                                <option value="February"><?php echo app('translator')->get('index.february'); ?></option>
                                <option value="March"><?php echo app('translator')->get('index.march'); ?></option>
                                <option value="April"><?php echo app('translator')->get('index.april'); ?></option>
                                <option value="May"><?php echo app('translator')->get('index.may'); ?></option>
                                <option value="June"><?php echo app('translator')->get('index.june'); ?></option>
                                <option value="July"><?php echo app('translator')->get('index.july'); ?></option>
                                <option value="August"><?php echo app('translator')->get('index.august'); ?></option>
                                <option value="September"><?php echo app('translator')->get('index.september'); ?></option>
                                <option value="October"><?php echo app('translator')->get('index.october'); ?></option>
                                <option value="November"><?php echo app('translator')->get('index.november'); ?></option>
                                <option value="December"><?php echo app('translator')->get('index.december'); ?></option>
                            </select>
                            <?php $__errorArgs = ['month'];
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
                    <div class="col-sm-12 col-md-4 mb-2">
                        <div class="form-group">
                        <label><?php echo app('translator')->get('index.year'); ?> <span class="required_star">*</span></label>    
                            <select name="year"
                                class="form-control <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2 width_100_p">
                                <option value="">Select</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                                <option value="2034">2034</option>
                                <option value="2035">2035</option>
                                <option value="2036">2036</option>
                                <option value="2037">2037</option>
                                <option value="2038">2038</option>
                                <option value="2039">2039</option>
                                <option value="2040">2040</option>
                                <option value="2041">2041</option>
                                <option value="2042">2042</option>
                                <option value="2043">2043</option>
                                <option value="2044">2044</option>
                                <option value="2045">2045</option>
                                <option value="2046">2046</option>
                                <option value="2047">2047</option>
                                <option value="2048">2048</option>
                                <option value="2049">2049</option>
                                <option value="2050">2050</option>
                            </select>
                            <?php $__errorArgs = ['year'];
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
                <button type="submit" class="btn bg-blue-btn"><iconify-icon
                        icon="solar:check-circle-broken"></iconify-icon>
                    <?php echo app('translator')->get('index.submit'); ?></button>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" href="<?php echo $baseURL . 'assets/bower_components/buttonCSS/checkBotton2.css'; ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\danish\resources\views/pages/payroll/create.blade.php ENDPATH**/ ?>