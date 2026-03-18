

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white p-3">
                    <h4 class="mb-0" style="color: white;">
                        <i class="fas fa-chair me-2" style="color: white;"></i> Additional Seating Order
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo e(route('chairs.process_order')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Target Facility</label>
                            <input type="text" class="form-control bg-light" value="<?php echo e($facility->name); ?>" disabled>
                            <input type="hidden" name="facility_id" value="<?php echo e($facility->id); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-bold">Number of Chairs to Order *</label>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   class="form-control form-control-lg border-danger" 
                                   value="<?php echo e(request('needed')); ?>" 
                                   required>
                            <small class="text-muted">Calculated requirement based on largest reservation.</small>
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label fw-bold">Admin Email (Contact) *</label>
                            <input type="email" 
                                   name="admin_email" 
                                   id="admin_email" 
                                   class="form-control" 
                                   value="macgonzales159@gmail.com" 
                                   required>
                            <small class="text-muted">Official correspondence will be sent to this address.</small>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Special Instructions</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="e.g. Needs to be delivered by 8:00 AM..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg text-white" style="background-color: green; border-color: green;">
                                <i class="fas fa-check-circle me-1"></i> Confirm & Place Order
                            </button>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-danger btn-lg">
                                <i class="fas fa-times-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/chairs/order.blade.php ENDPATH**/ ?>