<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">

<style>
    /* ── FULL SCREEN RESET ── */
    body > main, main.py-4, .container, .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
        max-width: none !important;
        width: 100% !important;
    }

    .full-screen-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Top Bar Consistency */
    .admin-top-bar {
        background: #fff;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .admin-top-bar h2 {
        margin: 0;
        font-weight: 800;
        font-size: 1.4rem;
        color: #1a3a52;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Form Container */
    .form-container {
        max-width: 1000px;
        margin: 0 auto 4rem auto;
        padding: 0 20px;
        width: 100%;
    }

    .glass-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        padding: 3rem;
    }

    .form-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin-bottom: 0.8rem;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.8rem 1rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        color: #1a3a52;
        transition: 0.2s;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #1a3a52;
        box-shadow: 0 0 0 4px rgba(26, 58, 82, 0.1);
    }

    /* Image Preview Styling */
    .current-asset-card {
        background: #f1f5f9;
        border-radius: 16px;
        padding: 10px;
        border: 1px solid #e2e8f0;
        position: relative;
    }

    .current-asset-card img {
        border-radius: 10px;
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .asset-label {
        position: absolute;
        top: -10px;
        left: 10px;
        background: #1a3a52;
        color: white;
        font-size: 0.6rem;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        font-weight: 700;
    }

    /* Buttons */
    .btn-update {
        background: #1a3a52;
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 14px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-update:hover {
        background: #0f2639;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 14px 40px;
        border-radius: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-cancel:hover { background: #e2e8f0; color: #1a3a52; }
</style>

<div class="full-screen-wrapper">
    <div class="admin-top-bar">
        <h2><i class="fas fa-edit"></i> Edit Facility: <span style="color: #64748b;"><?php echo e($facility->name); ?></span></h2>
        <div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-cancel">
                <i class="fas fa-times me-2"></i> Close
            </a>
        </div>
    </div>

    <div class="form-container">
        <div class="glass-card">
            <form action="<?php echo e(route('facilities.update', $facility)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-4">
                            <label for="name" class="form-label">Facility Category</label>
                            <select class="form-select <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" required>
                                <?php $__currentLoopData = $facilityNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facilityName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($facilityName); ?>" <?php echo e(old('name', $facility->name) === $facilityName ? 'selected' : ''); ?>><?php echo e($facilityName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted">Changing this category will automatically update the facility images.</small>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label">Location Address</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo e(old('location', $facility->location)); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Facility Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo e(old('description', $facility->description)); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="capacity" class="form-label">Capacity (Pax)</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo e(old('capacity', $facility->capacity)); ?>" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="available_hours" class="form-label">Available Hours</label>
                                <input type="number" class="form-control" id="available_hours" name="available_hours" value="<?php echo e(old('available_hours', $facility->available_hours)); ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Operational Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?php echo e(old('status', $facility->status) === 'active' ? 'selected' : ''); ?>>Active / Operational</option>
                                <option value="inactive" <?php echo e(old('status', $facility->status) === 'inactive' ? 'selected' : ''); ?>>Inactive / Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h6 class="fw-bold mb-4" style="color: #1a3a52;"><i class="fas fa-images me-2"></i> Active Media Assets</h6>

                            <label class="form-label">Main Thumbnail</label>
                            <?php if($facility->thumbnail): ?>
                                <div class="current-asset-card mb-4">
                                    <span class="asset-label">Active Preview</span>
                                    <img src="<?php echo e(asset($facility->thumbnail)); ?>" alt="Thumbnail">
                                </div>
                            <?php endif; ?>

                            <label class="form-label">Gallery Preview</label>
                            <?php if(!empty($facility->images) && is_array($facility->images)): ?>
                                <div class="row g-2">
                                    <?php $__currentLoopData = $facility->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-4">
                                            <div class="current-asset-card p-1">
                                                <img src="<?php echo e(asset($img)); ?>" style="height: 60px;">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mt-4 p-3 rounded-3" style="background: #e2e8f0; border-left: 4px solid #1a3a52;">
                                <p class="small mb-0" style="color: #475569;">
                                    <i class="fas fa-info-circle me-1"></i> <strong>Asset Management:</strong> Manual uploads are disabled. Assets are managed via naming conventions in the <code>public/images/facilities</code> folder.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                    <button type="submit" class="btn-update">
                        <i class="fas fa-check-circle me-2"></i> Update Facility
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/facilities/edit.blade.php ENDPATH**/ ?>