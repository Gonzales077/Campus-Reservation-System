

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

    .full-screen-inbox {
        background: #ffffff;
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Top Bar */
    .inbox-top-bar {
        background: #fff;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .inbox-top-bar h2 {
        margin: 0;
        font-weight: 800;
        font-size: 1.4rem;
        color: #1a3a52;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* ── FIXED TABLE ALIGNMENT ── */
    .table-full {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        table-layout: fixed; /* CRITICAL: Forces columns to stay in place */
    }

    .table-full th {
        background: #f8fafc;
        padding: 1rem 2rem;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #edf2f7;
        text-align: left;
    }

    /* Column Widths - Explicitly matching across all rows */
    .col-sender { width: 25%; }
    .col-content { width: 35%; }
    .col-status { width: 15%; }
    .col-date { width: 15%; }
    .col-action { width: 10%; }

    .table-full td {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
        vertical-align: middle;
        position: relative; /* For the unread indicator */
    }

    /* Unread Styling */
    .row-unread {
        background-color: #f0f7ff !important;
    }

    /* THE FIX: Use a div inside the TD instead of a pseudo-element on the TR */
    .unread-indicator {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #d4af37;
    }

    .row-unread td { font-weight: 600; }
    .table-full tr:hover td { background-color: #f8fafc; cursor: pointer; }

    /* UI Components */
    .sender-avatar {
        width: 42px;
        height: 42px;
        background: #1a3a52;
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
    }

    .status-dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .dot-unread { background-color: #ef4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.4); }
    .dot-read { background-color: #10b981; }

    .btn-action-view {
        background: #02478b;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.2s;
    }

    .btn-action-view:hover {
        background: #1a3a52;
        color: #fff;
    }

    /* Text Truncation */
    .text-truncate-custom {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    /* ── MODAL STYLING ── */
    #viewMessageModal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
    }

    .content-block {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .modal-avatar-circle {
        width: 48px;
        height: 48px;
        background: #1a3a52;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .message-text {
        color: #475569;
        line-height: 1.6;
        white-space: pre-wrap;
    }
</style>

<div class="full-screen-inbox">
    <div class="inbox-top-bar">
        <div>
            <h2><i class="fas fa-envelope-open-text"></i> Message Inbox</h2>
        </div>
        <div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-action-view text-decoration-none" style="#1a3a52">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="table-container">
        <?php if($messages->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-light mb-3"></i>
                <p class="text-muted">No messages in your inbox.</p>
            </div>
        <?php else: ?>
            <table class="table-full">
                <thead>
                    <tr>
                        <th class="col-sender">Sender</th>
                        <th class="col-content">Message Content</th>
                        <th class="col-status">Status</th>
                        <th class="col-date">Received</th>
                        <th class="col-action text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e(is_null($message->read_at) ? 'row-unread' : ''); ?> open-message" 
                        data-url="<?php echo e(route('admin.messages.show', $message->id)); ?>">
                        
                        <td class="col-sender">
                            <?php if(is_null($message->read_at)): ?>
                                <div class="unread-indicator"></div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center">
                                <div class="sender-avatar me-3">
                                    <?php echo e(strtoupper(substr($message->name, 0, 1))); ?>

                                </div>
                                <div style="min-width: 0;">
                                    <div class="text-dark text-truncate-custom"><?php echo e($message->name); ?></div>
                                    <div class="text-muted small text-truncate-custom"><?php echo e($message->email); ?></div>
                                </div>
                            </div>
                        </td>

                        <td class="col-content">
                            <div class="text-dark fw-bold mb-0 text-truncate-custom"><?php echo e($message->subject); ?></div>
                            <div class="text-muted small text-truncate-custom">
                                <?php echo e($message->message); ?>

                            </div>
                        </td>

                        <td class="col-status">
                            <?php if(is_null($message->read_at)): ?>
                                <span class="status-dot dot-unread"></span><span class="status-text small">Unread</span>
                            <?php else: ?>
                                <span class="status-dot dot-read"></span><span class="status-text small">Read</span>
                            <?php endif; ?>
                        </td>

                        <td class="col-date">
                            <div class="small text-dark"><?php echo e($message->created_at->format('M d, Y')); ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;"><?php echo e($message->created_at->diffForHumans()); ?></div>
                        </td>

                        <td class="col-action text-end">
                            <button class="btn-action-view">View</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1a3a52;">Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <span style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem; display: block;">Sender</span>
                <div class="content-block">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-avatar-circle" id="modalAvatar">?</div>
                        <div>
                            <p class="fw-bold mb-0 text-dark" id="modalName" style="font-size: 1.1rem;"></p>
                            <span class="text-muted small" id="modalEmail"></span>
                        </div>
                    </div>
                </div>

                <span style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem; display: block;">Message Content</span>
                <div class="content-block">
                    <div class="fw-bold text-dark mb-2" id="modalSubject"></div>
                    <p class="message-text" id="modalBody"></p>
                </div>

                <div class="d-flex flex-column align-items-end">
                    <div id="modalDate" class="text-muted small"></div>
                </div>
            </div>
            
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" style="background:#1a3a52; border-radius:10px; padding:12px; border: none;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.open-message').forEach(row => {
    row.addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        const modalElement = document.getElementById('viewMessageModal');
        const modal = new bootstrap.Modal(modalElement);
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalName').innerText = data.name;
            document.getElementById('modalEmail').innerText = data.email;
            document.getElementById('modalSubject').innerText = data.subject;
            document.getElementById('modalBody').innerText = data.message;
            document.getElementById('modalDate').innerText = "Received: " + data.received;
            document.getElementById('modalAvatar').innerText = data.name.charAt(0).toUpperCase();
            
            modal.show();
            
            // Mark as read visually
            if(this.classList.contains('row-unread')) {
                this.classList.remove('row-unread');
                
                // Remove the gold indicator div
                const indicator = this.querySelector('.unread-indicator');
                if(indicator) indicator.remove();
                
                const dot = this.querySelector('.status-dot');
                const text = this.querySelector('.status-text');
                if(dot) {
                    dot.classList.remove('dot-unread');
                    dot.classList.add('dot-read');
                }
                if(text) text.innerText = 'Read';
            }
        })
        .catch(err => console.error('Error loading message details.'));
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/messages/index.blade.php ENDPATH**/ ?>