<?php if(session('success')): ?>
    <section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body">
                <p><i class="m-right fa fa-check"></i><strong><?php echo app('translator')->get('index.success'); ?>!</strong> <?php echo e(session('success')); ?></p>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if(session('error')): ?>
    <section class="alert-wrapper">
        <div class="alert alert-danger alert-dismissible show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body">
                <i class="m-right fa fa-times"></i> <strong><?php echo app('translator')->get('index.error'); ?>!</strong> <?php echo e(session('error')); ?>

            </div>
        </div>
    </section>
<?php endif; ?>
<?php if(session('import_errors')): ?>
    <section class="alert-wrapper">
        <div class="alert alert-warning alert-dismissible show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body">
                <strong>Some rows failed to import:</strong>
                <ul class="mt-2 mb-0">
                    <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row => $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <strong>Row <?php echo e($row); ?> - <?php echo e($error['type']); ?>:</strong>
                            <ul>
                                <?php $__currentLoopData = $error['messages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($message); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if(Session::has('message')): ?>
    <div class="alert alert-<?php echo e(Session::get('type') ?? 'info'); ?> alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
            <p class="mb-0">
                <i class="m-right fa fa-<?php echo e(Session::get('sign') ?? 'check'); ?>"></i>
                <?php echo e(Session::get('message')); ?>

            </p>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\danish\resources\views/utilities/messages.blade.php ENDPATH**/ ?>