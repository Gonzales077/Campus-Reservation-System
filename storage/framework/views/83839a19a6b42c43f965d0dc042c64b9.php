

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Messages</h2>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if($messages->isEmpty()): ?>
        <div class="alert alert-info">No messages yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($message->id); ?></td>
                        <td><?php echo e($message->name); ?></td>
                        <td><?php echo e($message->email); ?></td>
                        <td><?php echo e($message->subject); ?></td>
                        <td style="max-width:420px; white-space:pre-wrap;"><?php echo e(Str::limit($message->message, 120)); ?></td>
                        <td>
                            <?php if(is_null($message->read_at)): ?>
                                <span class="badge bg-danger">Unread</span>
                            <?php else: ?>
                                <span class="badge bg-success">Read</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($message->created_at->format('Y-m-d H:i')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.messages.show', $message->id)); ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/messages/index.blade.php ENDPATH**/ ?>