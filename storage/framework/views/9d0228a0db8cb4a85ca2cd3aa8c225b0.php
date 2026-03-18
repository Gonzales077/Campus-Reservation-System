

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Message Details</h2>
        <div>
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-secondary">Back to Inbox</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo e($message->subject ?? 'No Subject'); ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">From: <?php echo e($message->name); ?> &lt;<?php echo e($message->email); ?>&gt;</h6>
            <p class="card-text" style="white-space:pre-wrap;"><?php echo e($message->message); ?></p>
            <p class="text-muted">Received: <?php echo e($message->created_at->format('Y-m-d H:i')); ?></p>
            <p>
                <?php if(is_null($message->read_at)): ?>
                    <span class="badge bg-danger">Unread</span>
                <?php else: ?>
                    <span class="badge bg-success">Read</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/messages/show.blade.php ENDPATH**/ ?>