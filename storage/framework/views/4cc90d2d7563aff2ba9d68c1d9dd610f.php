<?php $__env->startSection('content'); ?>
<div class="mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Reserve <?php echo e($facility->name); ?></h2>
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    Facility Details
                </div>
                <div class="card-body">
                    <p><strong>Location:</strong> <?php echo e($facility->location); ?></p>
                    <p><strong>Capacity:</strong> <?php echo e($facility->capacity); ?> people</p>
                    <p><strong>Available Hours:</strong> <?php echo e($facility->available_hours); ?> hours</p>
                    <?php if($facility->description): ?>
                        <p><strong>Description:</strong> <?php echo e($facility->description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Reservation Details
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('reservations.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="facility_id" value="<?php echo e($facility->id); ?>">

                        <div class="mb-3">
                            <label for="description" class="form-label">What will you use this facility for? *</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="4" placeholder="Please describe your intended use of the facility..." required><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> Your reservation will be submitted for admin approval. You will be notified once it's reviewed.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a>
                            <button type="submit" class="btn btn-primary">Submit Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/reservations/user-create.blade.php ENDPATH**/ ?>