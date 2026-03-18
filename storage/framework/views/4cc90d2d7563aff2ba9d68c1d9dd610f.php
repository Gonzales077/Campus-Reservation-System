<?php $__env->startSection('content'); ?>
<div class="mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php if(isset($facility)): ?>
                <h2 class="mb-4 text-white">Reserve <?php echo e($facility->name); ?></h2>
                
                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-dark text-white">Facility Reference</div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <<div class="col-md-4">
    <?php if($facility->thumbnail): ?>
        
        <img src="<?php echo e(asset(Str::start($facility->thumbnail, '/'))); ?>" 
             class="img-fluid rounded shadow-sm" 
             alt="<?php echo e($facility->name); ?>">
    <?php else: ?>
        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
            <i class="fas fa-image fa-3x text-muted"></i>
        </div>
    <?php endif; ?>
</div>
                            <div class="col-md-8">
                                <p><strong>Location:</strong> <?php echo e($facility->location); ?></p>
                                <p><strong>Base Capacity:</strong> <span id="base_capacity"><?php echo e($facility->capacity); ?></span> people</p>
                                <p><strong>Available Hours:</strong> <?php echo e($facility->available_hours); ?> hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">Reservation Details</div>
                    <div class="card-body">
                        <form action="<?php echo e(route('reservations.store')); ?>" method="POST" id="reservationForm">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="facility_id" value="<?php echo e($facility->id); ?>">

                            
                            <div class="mb-3">
                                <label for="requested_date" class="form-label fw-bold">Date of Use *</label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['requested_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="requested_date" 
                                       name="requested_date" 
                                       
                                       min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" 
                                       value="<?php echo e(old('requested_date')); ?>" 
                                       required>
                                <?php $__errorArgs = ['requested_date'];
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

                            
                            <div class="mb-4">
                                <label for="estimated_participants" class="form-label fw-bold">Estimated Participants *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" 
                                           class="form-control form-control-lg <?php $__errorArgs = ['estimated_participants'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="estimated_participants" 
                                           name="estimated_participants" 
                                           placeholder="0" 
                                           min="1" 
                                           value="<?php echo e(old('estimated_participants')); ?>" 
                                           required>
                                </div>
                                <?php $__errorArgs = ['estimated_participants'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                                
                                <div id="chair_request_alert" class="mt-3 p-3 border rounded bg-light d-none">
                                    <div class="d-flex align-items-center text-warning">
                                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Additional Seating Required</h6>
                                            <p class="mb-0 small text-muted">
                                                You are requesting <span id="extra_chairs_count" class="fw-bold text-dark">0</span> additional chairs beyond the venue's base capacity.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Purpose of Use *</label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Describe your event..." 
                                          required><?php echo e(old('description')); ?></textarea>
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

                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5">Submit Reservation Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const participantInput = document.getElementById('estimated_participants');
    const baseCapacitySpan = document.getElementById('base_capacity');
    
    // Safety check in case the element isn't there
    if(participantInput && baseCapacitySpan) {
        const baseCapacity = parseInt(baseCapacitySpan.innerText);
        const chairAlert = document.getElementById('chair_request_alert');
        const extraCount = document.getElementById('extra_chairs_count');

        function updateChairLogic() {
            const val = parseInt(participantInput.value) || 0;
            
            if (val > baseCapacity) {
                const diff = val - baseCapacity;
                extraCount.innerText = diff;
                chairAlert.classList.remove('d-none');
                participantInput.classList.add('border-warning');
            } else {
                chairAlert.classList.add('d-none');
                participantInput.classList.remove('border-warning');
            }
        }

        participantInput.addEventListener('input', updateChairLogic);
        updateChairLogic();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/reservations/user-create.blade.php ENDPATH**/ ?>