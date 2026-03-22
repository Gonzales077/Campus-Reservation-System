 
<?php $__env->startSection('content'); ?>
 
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
 

<style>
    /* Target whatever wrapper your layouts.app uses */
    body > .container,
    body > .container-fluid,
    body > main > .container,
    body > main > .container-fluid,
    .container:has(.admin-dashboard-container),
    .container-fluid:has(.admin-dashboard-container) {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
    }
 
    /* Search / Filter / Pagination extras (kept inline so CSS file stays clean) */
    .section-search-bar, .facilities-search-bar {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 0; background: transparent;
        border-bottom: 1px solid #e8edf2;
        flex-wrap: wrap; margin-bottom: 1.25rem;
    }
    .search-input-wrapper { position: relative; flex: 1; min-width: 200px; }
    .search-input-wrapper i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none; }
    .search-input-wrapper .clear-search { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; cursor: pointer; background: none; border: none; padding: 2px 4px; display: none; line-height: 1; }
    .search-input-wrapper .clear-search:hover { color: #ef4444; }
    .section-search-input { width: 100%; padding: 9px 32px 9px 36px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13.5px; color: #334155; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; outline: none; box-sizing: border-box; }
    .section-search-input:focus { border-color: #1a3a52; box-shadow: 0 0 0 3px rgba(26,58,82,0.08); }
    .section-filter-select { padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13.5px; color: #334155; background: #fff; cursor: pointer; transition: border-color 0.2s; outline: none; min-width: 140px; }
    .section-filter-select:focus { border-color: #1a3a52; }
    .search-results-count { font-size: 12.5px; color: #64748b; white-space: nowrap; padding: 4px 0; }
    .search-results-count span { font-weight: 700; color: #1a3a52; }
    .table-pagination, .facilities-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 0 0; border-top: 1px solid #e8edf2; flex-wrap: wrap; gap: 10px; margin-top: 1rem; }
    .pagination-info-text { font-size: 13px; color: #64748b; }
    .pagination-info-text strong { color: #1a3a52; }
    .pagination-buttons { display: flex; align-items: center; gap: 4px; }
    .pg-btn { min-width: 34px; height: 34px; border: 1.5px solid #e2e8f0; background: #fff; border-radius: 7px; font-size: 13px; color: #475569; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.18s; padding: 0 8px; font-weight: 500; }
    .pg-btn:hover:not(:disabled) { background: #1a3a52; color: #fff; border-color: #1a3a52; }
    .pg-btn.active  { background: #1a3a52; color: #fff; border-color: #1a3a52; font-weight: 700; }
    .pg-btn:disabled{ opacity: 0.38; cursor: not-allowed; }
    .pg-ellipsis    { font-size: 13px; color: #94a3b8; padding: 0 4px; }
    .no-results-row td { text-align: center; padding: 32px 20px; color: #94a3b8; font-size: 14px; }
    .no-results-row i  { font-size: 28px; display: block; margin-bottom: 8px; color: #cbd5e1; }
    .facility-card-item { transition: opacity 0.18s; }
</style>
 
<div class="admin-dashboard-container">
 
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-gradient-overlay">
            <div class="header-content-wrapper">
                <div class="header-left">
                    <div class="header-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Admin Panel</span>
                    </div>
                    <h1 class="header-title">
                        <span class="title-text">Admin Dashboard</span>
                        <span class="title-subtext">Facility Management</span>
                    </h1>
                    <p class="header-description">Monitor and manage all facility reservations and requests</p>
                </div>
 
                <div class="header-right">
                    <a href="<?php echo e(route('facilities.create')); ?>" class="header-action-btn">
                        <div class="btn-icon-wrapper"><i class="fas fa-plus"></i></div>
                        <div class="btn-content">
                            <span class="btn-label">Create New</span>
                            <span class="btn-sublabel">Add Facility</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.messages.index')); ?>" class="header-action-btn" style="background:#fff; color:#333;">
                        <div class="btn-icon-wrapper"><i class="fas fa-envelope"></i></div>
                        <div class="btn-content">
                            <span class="btn-label">Messages</span>
                            <span class="btn-sublabel">Contact Inbox</span>
                            <?php if(isset($unreadMessagesCount) && $unreadMessagesCount > 0): ?>
                                <span style="display:inline-block;background:#e53935;color:#fff;padding:2px 6px;border-radius:12px;margin-left:6px;font-size:12px;"><?php echo e($unreadMessagesCount); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
 
    <?php if(session('success')): ?>
        <div class="notification-card notification-success">
            <div class="notification-icon"><i class="fas fa-check-circle"></i></div>
            <div class="notification-content"><p class="notification-message"><?php echo e(session('success')); ?></p></div>
            <button class="notification-close"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>
 
    <?php if(session('error')): ?>
        <div class="notification-card notification-error">
            <div class="notification-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="notification-content"><p class="notification-message"><?php echo e(session('error')); ?></p></div>
            <button class="notification-close"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>
 
    <!-- Statistics Overview -->
    <div class="stats-overview-section">
        <div class="section-title-bar">
            <h2 class="section-title"><i class="fas fa-chart-line"></i><span>Overview</span></h2>
            <div class="last-updated"><i class="fas fa-sync-alt"></i><span>Updated just now</span></div>
        </div>
        <div class="stats-grid-modern">
            <div class="stat-card-modern stat-warning">
                <div class="stat-card-header">
                    <div class="stat-icon-modern"><i class="fas fa-clock"></i></div>
                    <div class="stat-urgency"><span class="urgency-badge">Requires Action</span></div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?php echo e($pendingReservations->count()); ?></h3>
                    <p class="stat-label">Pending Requests</p>
                    <div class="stat-progress"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($pendingReservations->count() > 0 ? '80%' : '0%'); ?>"></div></div></div>
                </div>
                <div class="stat-footer"><a href="#pending-section" class="stat-action-link"><span>Review All</span><i class="fas fa-arrow-right"></i></a></div>
            </div>
 
            <div class="stat-card-modern stat-success">
                <div class="stat-card-header">
                    <div class="stat-icon-modern"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-urgency"><span class="urgency-badge active">Active</span></div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?php echo e($approvedReservations->count()); ?></h3>
                    <p class="stat-label">Approved Bookings</p>
                    <div class="stat-progress"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($approvedReservations->count() > 0 ? '60%' : '0%'); ?>"></div></div></div>
                </div>
                <div class="stat-footer"><a href="#approved-section" class="stat-action-link"><span>View All</span><i class="fas fa-arrow-right"></i></a></div>
            </div>
 
            <div class="stat-card-modern stat-primary">
                <div class="stat-card-header">
                    <div class="stat-icon-modern"><i class="fas fa-building"></i></div>
                    <div class="stat-urgency"><span class="urgency-badge">Available</span></div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?php echo e($facilities->count()); ?></h3>
                    <p class="stat-label">Total Facilities</p>
                    <div class="stat-progress"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($facilities->where('status','active')->count() / max($facilities->count(),1) * 100); ?>%"></div></div></div>
                </div>
                <div class="stat-footer"><a href="#facilities-section" class="stat-action-link"><span>Manage All</span><i class="fas fa-arrow-right"></i></a></div>
            </div>
 
            <div class="stat-card-modern stat-secondary">
                <div class="stat-card-header">
                    <div class="stat-icon-modern"><i class="fas fa-list"></i></div>
                    <div class="stat-urgency"><span class="urgency-badge">Total</span></div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value"><?php echo e($allReservations->count()); ?></h3>
                    <p class="stat-label">All Reservations</p>
                    <div class="stat-progress"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($allReservations->count() > 0 ? '40%' : '0%'); ?>"></div></div></div>
                </div>
                <div class="stat-footer"><a href="#all-reservations" class="stat-action-link"><span>See All</span><i class="fas fa-arrow-right"></i></a></div>
            </div>
        </div>
    </div>
 
    <!-- ===== PENDING RESERVATIONS ===== -->
    <?php if($pendingReservations->count() > 0): ?>
    <div class="modern-section-card urgent-section" id="pending-section">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">Pending Reservation Requests</h2>
                    <p class="section-subtitle">Action required for these reservation requests</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge badge-warning"><i class="fas fa-clock"></i> <?php echo e($pendingReservations->count()); ?> Pending</span>
                <button class="section-action-btn" title="Export"><i class="fas fa-download"></i></button>
            </div>
        </div>
 
        <div class="section-search-bar">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="section-search-input" id="pendingSearch" placeholder="Search by facility, guest, contact, or description…">
                <button class="clear-search" id="pendingClear"><i class="fas fa-times"></i></button>
            </div>
            <div class="search-results-count" id="pendingCount"></div>
        </div>
 
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility"><i class="fas fa-building"></i> Facility</th>
                        <th class="table-col-guest"><i class="fas fa-user"></i> Guest</th>
                        <th class="table-col-contact"><i class="fas fa-phone"></i> Contact</th>
                        <th class="table-col-description"><i class="fas fa-align-left"></i> Description</th>
                        <th class="table-col-actions"><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="pendingTbody">
                    <?php $__currentLoopData = $pendingReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-search="<?php echo e(strtolower($reservation->facility->name.' '.$reservation->guest_name.' '.$reservation->guest_contact.' '.$reservation->description)); ?>">
                        <td>
                            <div class="facility-info">
                                <div class="facility-name"><?php echo e($reservation->facility->name); ?></div>
                                <div class="facility-meta"><span class="facility-meta-item"><i class="fas fa-users"></i> <?php echo e($reservation->facility->capacity); ?></span></div>
                            </div>
                        </td>
                        <td>
                            <div class="guest-info">
                                <div class="guest-name"><?php echo e($reservation->guest_name); ?></div>
                                <div class="guest-date"><?php echo e($reservation->created_at->format('M d, Y')); ?></div>
                            </div>
                        </td>
                        <td><div class="contact-info"><a href="tel:<?php echo e($reservation->guest_contact); ?>" class="contact-link"><i class="fas fa-phone"></i> <?php echo e($reservation->guest_contact); ?></a></div></td>
                        <td><div class="description-content"><?php echo e(Str::limit($reservation->description, 60)); ?></div></td>
                        <td>
                            <div class="action-buttons-modern">
                                <button type="button" class="action-btn action-approve" data-bs-toggle="modal" data-bs-target="#approveModal<?php echo e($reservation->id); ?>">
                                    <i class="fas fa-check"></i><span>Approve</span>
                                </button>
                                <form action="<?php echo e(route('reservations.reject', $reservation)); ?>" method="POST" class="inline-form-modern">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="action-btn action-reject" onclick="return confirm('Reject this reservation?')">
                                        <i class="fas fa-times"></i><span>Reject</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="table-pagination" id="pendingPagination">
            <div class="pagination-info-text" id="pendingPaginationInfo"></div>
            <div class="pagination-buttons" id="pendingPaginationBtns"></div>
        </div>
    </div>
    <?php endif; ?>


    <!-- Clinic appointments -->
  <div class="modern-section-card" id="clinic-section">
    <div class="section-header-modern">
        <div class="section-title-container">
            <div class="section-title-icon"><i class="fas fa-user-medical text-primary"></i></div>
            <div class="section-title-content">
                <h2 class="section-title-modern">Clinic Room Requests</h2>
                <p class="section-subtitle">Manage synchronized appointments from the clinic system</p>
            </div>
        </div>
        <div class="section-actions-modern">
            <span class="status-count-badge badge-primary">
                <i class="fas fa-sync-alt"></i> <?php echo e($clinicSyncs->count()); ?> Pending Syncs
            </span>
        </div>
    </div>

    <div class="modern-table-container">
        <table class="modern-admin-table">
            <thead>
                <tr>
                    <th class="table-col-facility"><i class="fas fa-building"></i> Facility</th>
                    <th class="table-col-guest"><i class="fas fa-user"></i> Patient</th>
                    <th class="table-col-contact"><i class="fas fa-envelope"></i> Contact</th>
                    <th class="table-col-description"><i class="fas fa-align-left"></i> Clinic Notes</th>
                    <th class="table-col-actions"><i class="fas fa-cog"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $clinicSyncs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sync): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="facility-info">
                            <div class="facility-name"><?php echo e($sync->facility->name ?? 'N/A'); ?></div>
                            <div class="facility-meta">
                                <span class="facility-meta-item text-primary"><i class="fas fa-tag"></i> Clinic Reservation</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="guest-info">
                            <div class="guest-name"><?php echo e(str_replace('CLINIC: ', '', $sync->guest_name)); ?></div>
                            <div class="guest-date"><?php echo e(\Carbon\Carbon::parse($sync->requested_date)->format('M d, Y')); ?></div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <a href="mailto:<?php echo e($sync->guest_contact); ?>" class="contact-link">
                                <i class="fas fa-at"></i> <?php echo e($sync->guest_contact); ?>

                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="description-content" title="<?php echo e($sync->description); ?>">
                            <?php echo e(Str::limit($sync->description, 50)); ?>

                        </div>
                    </td>
                    <td>
                        <div class="action-buttons-modern">
                            <button type="button" class="action-btn" style="background: var(--background-tertiary); color: var(--hcc-blue);" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo e($sync->id); ?>">
                                <i class="fas fa-eye"></i><span>Details</span>
                            </button>
                            
                            <form action="<?php echo e(route('reservations.approve', $sync->id)); ?>" method="POST" class="inline-form-modern">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="available_date" value="<?php echo e($sync->requested_date); ?>">
                                <button type="submit" class="action-btn action-approve" onclick="return confirm('Confirm this clinic appointment?')">
                                    <i class="fas fa-check"></i><span>Approve</span>
                                </button>
                            </form>

                            <form action="<?php echo e(route('reservations.reject', $sync->id)); ?>" method="POST" class="inline-form-modern">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn action-reject" onclick="return confirm('Reject this clinic request?')">
                                    <i class="fas fa-times"></i><span>Reject</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr class="no-results-row">
                    <td colspan="5">
                        <i class="fas fa-calendar-check"></i>
                        No pending clinic synchronization requests found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__currentLoopData = $clinicSyncs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sync): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="detailsModal<?php echo e($sync->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-xl);">
            <div class="modal-header" style="background: var(--hcc-blue); color: white; border-radius: var(--radius-xl) var(--radius-xl) 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-medical mr-2"></i>Patient Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row p-3 rounded mb-3" style="background: var(--background-secondary); border: 1px solid var(--border-light);">
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">Patient Name</small>
                        <span class="font-weight-bold text-dark"><?php echo e(str_replace('CLINIC: ', '', $sync->guest_name)); ?></span>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">Email Address</small>
                        <span class="text-dark"><?php echo e($sync->guest_contact); ?></span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">Requested Date</small>
                        <span class="font-weight-bold text-dark"><?php echo e(\Carbon\Carbon::parse($sync->requested_date)->format('M d, Y')); ?></span>
                    </div>
                 <div class="col-6">
    <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">Actual Time</small>
    <span class="font-weight-bold text-primary">
        <?php if(isset($sync->actual_appointment_time) && $sync->actual_appointment_time): ?>
            
            <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $sync->actual_appointment_time)->format('h:i A')); ?>

        <?php else: ?>
            
            <?php echo e(\Carbon\Carbon::parse($sync->created_at)->format('h:i A')); ?>

        <?php endif; ?>
    </span>
</div>
                </div>
                <label class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.65rem;">Reason for Visit / Clinic Notes</label>
                <div class="border rounded p-3 bg-white shadow-sm small italic text-dark">
                    "<?php echo e($sync->description); ?>"
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Close</button>
                <form action="<?php echo e(route('reservations.approve', $sync->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="available_date" value="<?php echo e($sync->requested_date); ?>">
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: var(--radius-md);">Approve Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
    <!-- Approve Modals -->
    <?php $__currentLoopData = $pendingReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="approveModal<?php echo e($reservation->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header-custom">
                    <h5><i class="fas fa-check-circle"></i> Approve Reservation</h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('reservations.approve', $reservation)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body-custom">
                        <div class="info-box">
                            <p><strong>Facility:</strong> <?php echo e($reservation->facility->name); ?></p>
                            <p><strong>Guest:</strong> <?php echo e($reservation->guest_name); ?></p>
                            <p><strong>Purpose:</strong> <?php echo e($reservation->description); ?></p>
                        </div>
                        <div class="form-group-custom">
    <label><i class="fas fa-calendar-alt"></i> Date Requested by User</label>
    
    <div class="form-control-custom bg-light p-2 mb-2" style="border: 1px solid #ddd; border-radius: 5px;">
        <span class="fw-bold">
            
            <?php if($reservation->requested_date): ?>
                <?php echo e(\Carbon\Carbon::parse($reservation->requested_date)->format('F j, Y')); ?>

            <?php else: ?>
                <span class="text-danger">Error: No date found in database</span>
            <?php endif; ?>
        </span>
    </div>

    
    <input type="hidden" name="available_date" value="<?php echo e($reservation->requested_date); ?>">
    
    <small class="text-muted">This is the date the user selected in their form.</small>
</div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn-modal-confirm"><i class="fas fa-check"></i> Approve Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
    <!-- ===== APPROVED RESERVATIONS ===== -->
    <?php if($approvedReservations->count() > 0): ?>
    <div class="modern-section-card" id="approved-section">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">Currently Reserved Facilities</h2>
                    <p class="section-subtitle">Active and upcoming reservations</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge badge-success"><i class="fas fa-check-circle"></i> <?php echo e($approvedReservations->count()); ?> Active</span>
            </div>
        </div>
 
        <div class="section-search-bar">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="section-search-input" id="approvedSearch" placeholder="Search by facility, guest, contact, or purpose…">
                <button class="clear-search" id="approvedClear"><i class="fas fa-times"></i></button>
            </div>
            <div class="search-results-count" id="approvedCount"></div>
        </div>
 
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility"><i class="fas fa-building"></i> Facility</th>
                        <th class="table-col-guest"><i class="fas fa-user"></i> Reserved By</th>
                        <th class="table-col-contact"><i class="fas fa-phone"></i> Contact</th>
                        <th class="table-col-description"><i class="fas fa-info-circle"></i> Purpose</th>
                        <th class="table-col-date"><i class="fas fa-calendar-alt"></i> Available Date</th>
                    </tr>
                </thead>
                <tbody id="approvedTbody">
                    <?php $__currentLoopData = $approvedReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-search="<?php echo e(strtolower($reservation->facility->name.' '.$reservation->guest_name.' '.$reservation->guest_contact.' '.$reservation->description.' '.$reservation->facility->location)); ?>">
                        <td>
                            <div class="facility-info">
                                <div class="facility-name"><?php echo e($reservation->facility->name); ?></div>
                                <div class="facility-meta"><span class="facility-meta-item"><i class="fas fa-map-marker-alt"></i> <?php echo e($reservation->facility->location); ?></span></div>
                            </div>
                        </td>
                        <td>
                            <div class="guest-info">
                                <div class="guest-name"><?php echo e($reservation->guest_name); ?></div>
                                <div class="guest-date">Approved on <?php echo e($reservation->updated_at->format('M d')); ?></div>
                            </div>
                        </td>
                        <td><div class="contact-info"><a href="tel:<?php echo e($reservation->guest_contact); ?>" class="contact-link"><i class="fas fa-phone"></i> <?php echo e($reservation->guest_contact); ?></a></div></td>
                        <td><div class="description-content"><?php echo e(Str::limit($reservation->description, 50)); ?></div></td>
                        <td>
                            <div class="date-display-modern">
                                <div class="date-icon"><i class="fas fa-calendar-day"></i></div>
                                <div class="date-info">
                                    <div class="date-value"><?php echo e($reservation->available_date ? $reservation->available_date->format('M d, Y') : 'Not set'); ?></div>
                                    <?php if($reservation->available_date): ?>
                                    <div class="date-remaining"><?php echo e(\Carbon\Carbon::parse($reservation->available_date)->diffForHumans()); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="table-pagination" id="approvedPagination">
            <div class="pagination-info-text" id="approvedPaginationInfo"></div>
            <div class="pagination-buttons" id="approvedPaginationBtns"></div>
        </div>
    </div>
    <?php endif; ?>
 
    <!-- ===== MY FACILITIES ===== -->
    <div class="modern-section-card" id="facilities-section">
    <div class="section-header-modern">
        <div class="section-title-container">
            <div class="section-title-icon"><i class="fas fa-building"></i></div>
            <div class="section-title-content">
                <h2 class="section-title-modern">My Facilities</h2>
                <p class="section-subtitle">Manage all your facility listings</p>
            </div>
        </div>
        <div class="section-actions-modern">
            <a href="<?php echo e(route('facilities.create')); ?>" class="primary-action-btn"><i class="fas fa-plus"></i><span>Add New Facility</span></a>
        </div>
    </div>

    <?php if($facilities->count() > 0): ?>
    <div class="facilities-search-bar">
        <div class="search-input-wrapper" style="flex:1;min-width:200px;">
            <i class="fas fa-search"></i>
            <input type="text" class="section-search-input" id="facilitiesSearch" placeholder="Search by name or location…">
            <button class="clear-search" id="facilitiesClear"><i class="fas fa-times"></i></button>
        </div>
        <select class="section-filter-select" id="facilitiesStatusFilter">
            <option value="all">All Status</option>
            <option value="active">Available</option>
            <option value="reserved">Reserved</option>
            <option value="pending">With Pending Req.</option>
            <option value="inactive">Inactive</option>
        </select>
        <div class="search-results-count" id="facilitiesCount"></div>
    </div>

    <div class="facilities-grid-modern" id="facilitiesGrid">
        <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Logic to determine status
            $isReserved = $facility->reservations->where('status', 'approved')->count() > 0;
            $hasPending = $facility->reservations->where('status', 'pending')->count() > 0;
            
            // Determine Visual Status
            $displayStatus = 'active';
            if ($isReserved) {
                $displayStatus = 'reserved';
            } elseif ($hasPending) {
                $displayStatus = 'pending';
            } elseif ($facility->status !== 'active') {
                $displayStatus = 'inactive';
            }

            $maxRequested = $facility->reservations->max('estimated_participants') ?? 0;
            $isOverCapacity = $maxRequested > $facility->capacity;
            $chairsNeeded = $isOverCapacity ? ($maxRequested - $facility->capacity) : 0;
        ?>

        <div class="facility-card-modern facility-card-item <?php echo e($isOverCapacity ? 'border-danger' : ''); ?> status-<?php echo e($displayStatus); ?>"
             data-name="<?php echo e(strtolower($facility->name)); ?>"
             data-location="<?php echo e(strtolower($facility->location)); ?>"
             data-status="<?php echo e($displayStatus); ?>">
            
            <div class="facility-card-header">
                <div class="facility-status-indicator">
                    <?php if($displayStatus === 'reserved'): ?>
                        <div class="status-dot" style="background-color: #ef4444;"></div>
                        <span class="status-text text-danger">Reserved</span>
                    <?php elseif($displayStatus === 'pending'): ?>
                        <div class="status-dot" style="background-color: #f59e0b;"></div>
                        <span class="status-text text-warning">Pending Review</span>
                    <?php elseif($displayStatus === 'active'): ?>
                        <div class="status-dot status-dot-active"></div>
                        <span class="status-text">Available</span>
                    <?php else: ?>
                        <div class="status-dot status-dot-inactive"></div>
                        <span class="status-text">Inactive</span>
                    <?php endif; ?>
                </div>

                <?php if($isOverCapacity): ?>
                    <div class="badge bg-danger pulse-animation"><i class="fas fa-exclamation-triangle"></i> Needs <?php echo e($chairsNeeded); ?> Chairs</div>
                <?php endif; ?>

                <div class="facility-actions-dropdown">
                    <button class="dropdown-toggle-btn"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu-facility">
                        <a href="<?php echo e(route('facilities.edit', $facility)); ?>" class="dropdown-item"><i class="fas fa-edit"></i><span>Edit Facility</span></a>
                        <?php if(!$facility->reservations()->exists()): ?>
                        <form action="<?php echo e(route('facilities.destroy', $facility)); ?>" method="POST" class="dropdown-item-form">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="dropdown-item dropdown-item-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i><span>Delete</span></button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="facility-card-body">
                <?php if($facility->thumbnail): ?>
                <div class="facility-thumbnail mb-3" style="<?php echo e($isReserved ? 'filter: grayscale(0.8); opacity: 0.7;' : ''); ?>">
                    <img src="<?php echo e(asset(Str::start($facility->thumbnail, '/'))); ?>" 
                         alt="<?php echo e($facility->name); ?>" 
                         style="width:100%; border-radius:12px; max-height:160px; object-fit:cover;">
                </div>
                <?php endif; ?>
                
                <h3 class="facility-name-modern"><?php echo e($facility->name); ?></h3>
                <div class="facility-location"><i class="fas fa-map-marker-alt"></i><span><?php echo e($facility->location); ?></span></div>
                
                <div class="facility-details-grid">
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fas fa-users"></i></div>
                        <div class="detail-content"><div class="detail-value"><?php echo e($facility->capacity); ?></div><div class="detail-label">Capacity</div></div>
                    </div>
                    <div class="detail-item <?php echo e($isOverCapacity ? 'text-danger fw-bold' : ''); ?>">
                        <div class="detail-icon"><i class="fas <?php echo e($isOverCapacity ? 'fa-chair text-danger' : 'fa-clock'); ?>"></i></div>
                        <div class="detail-content"><div class="detail-value"><?php echo e($isOverCapacity ? $maxRequested : $facility->available_hours); ?></div><div class="detail-label"><?php echo e($isOverCapacity ? 'Max Req.' : 'Hours'); ?></div></div>
                    </div>
                </div>
            </div>

            <div class="facility-card-footer">
                <div class="reservation-count">
                    <i class="fas fa-calendar"></i>
                    <span><?php echo e($facility->reservations->count()); ?> Records</span>
                </div>
                <div class="footer-actions">
                    <?php if($isReserved): ?>
                        <span class="badge bg-light text-dark border"><i class="fas fa-lock"></i> Occupied</span>
                    <?php else: ?>
                        <?php if($isOverCapacity): ?>
                            <a href="<?php echo e(route('chairs.order', ['facility'=>$facility->id,'needed'=>$chairsNeeded])); ?>" class="btn-add-chairs text-decoration-none me-2">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('facilities.edit', $facility)); ?>" class="edit-facility-btn"><i class="fas fa-cog"></i> Manage</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div id="facilitiesNoResults" style="display:none;text-align:center;padding:40px 20px;color:#94a3b8;">
        <i class="fas fa-search" style="font-size:32px;display:block;margin-bottom:10px;color:#cbd5e1;"></i>
        <p style="font-size:15px;margin:0;">No facilities match your search.</p>
    </div>

    <div class="facilities-pagination" id="facilitiesPagination">
        <div class="pagination-info-text" id="facilitiesPaginationInfo"></div>
        <div class="pagination-buttons" id="facilitiesPaginationBtns"></div>
    </div>

    <?php else: ?>
    <div class="empty-state-modern">
        <i class="fas fa-building fa-3x mb-3"></i>
        <h3>No Facilities Yet</h3>
        <a href="<?php echo e(route('facilities.create')); ?>" class="primary-action-btn mt-3">Create First Facility</a>
    </div>
    <?php endif; ?>
</div>
 
    <!-- Google Calendar Section -->
    <div class="modern-section-card" id="google-calendar">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">Google Calendar Integration</h2>
                    <p class="section-subtitle">View and manage reserved facilities</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge"><i class="fas fa-envelope"></i> <?php echo e(auth()->user()->gmail_address ?? 'Not Set'); ?></span>
            </div>
        </div>
        <?php if(!auth()->user()->gmail_address): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-calendar-times"></i></div>
                <h3 class="empty-state-title">Gmail Address Not Configured</h3>
                <p class="empty-state-description">Please add your Gmail address to enable Google Calendar integration</p>
                <button class="primary-action-btn empty-state-btn" data-bs-toggle="modal" data-bs-target="#updateGmailModal">
                    <i class="fas fa-envelope"></i><span>Add Gmail Address</span>
                </button>
            </div>
        <?php else: ?>
            <div style="padding:20px;background:#f8f9fa;border-radius:8px;">
                <div style="background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <h5 style="margin-bottom:15px;color:#333;"><i class="fas fa-info-circle" style="color:#1a3a52;margin-right:8px;"></i>Google Calendar Instructions</h5>
                    <p style="margin:10px 0;font-size:14px;color:#666;"><strong>Your Gmail:</strong> <?php echo e(auth()->user()->gmail_address); ?></p>
                    <p style="margin:10px 0;font-size:14px;color:#666;"><i class="fas fa-check-circle" style="color:#4caf50;margin-right:5px;"></i> Calendar events are automatically created when you approve reservations</p>
                    <p style="margin:10px 0;font-size:14px;color:#666;"><i class="fas fa-check-circle" style="color:#4caf50;margin-right:5px;"></i> To view events, open <a href="https://calendar.google.com" target="_blank" style="color:#1a3a52;text-decoration:underline;">Google Calendar</a></p>
                    <hr style="margin:15px 0;border:none;border-top:1px solid #e0e0e0;">
                    <div style="background:#f0f4f8;padding:12px;border-radius:4px;border-left:4px solid #1a3a52;">
                        <strong style="color:#1a3a52;">📅 Active Reservations Calendar</strong>
                        <p style="margin:8px 0 0;font-size:13px;color:#555;"><span id="approved-count"><?php echo e($approvedReservations->count() ?? 0); ?></span> facilities currently reserved</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
 
    <!-- ===== ALL RESERVATIONS ===== -->
    <div class="modern-section-card" id="all-reservations">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon"><i class="fas fa-list-alt"></i></div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">All Reservations</h2>
                    <p class="section-subtitle">Complete history of reservation requests</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge"><i class="fas fa-list"></i> <?php echo e($allReservations->count()); ?> Total</span>
            </div>
        </div>
 
        <div class="section-search-bar">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="section-search-input" id="allSearch" placeholder="Search by facility, guest, contact, or description…">
                <button class="clear-search" id="allClear"><i class="fas fa-times"></i></button>
            </div>
            <select class="section-filter-select" id="allStatusFilter">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <div class="search-results-count" id="allCount"></div>
        </div>
 
        <?php if($allReservations->count() > 0): ?>
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility"><i class="fas fa-building"></i> Facility</th>
                        <th class="table-col-guest"><i class="fas fa-user"></i> Guest Name</th>
                        <th class="table-col-contact"><i class="fas fa-phone"></i> Contact</th>
                        <th class="table-col-description"><i class="fas fa-align-left"></i> Description</th>
                        <th class="table-col-status"><i class="fas fa-info-circle"></i> Status</th>
                        <th class="table-col-date"><i class="fas fa-calendar"></i> Submitted</th>
                    </tr>
                </thead>
                <tbody id="allTbody">
                    <?php $__currentLoopData = $allReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="status-<?php echo e($reservation->status); ?>"
                        data-search="<?php echo e(strtolower($reservation->facility->name.' '.$reservation->guest_name.' '.$reservation->guest_contact.' '.$reservation->description)); ?>"
                        data-status="<?php echo e($reservation->status); ?>">
                        <td><div class="facility-info"><div class="facility-name"><?php echo e($reservation->facility->name); ?></div></div></td>
                        <td><div class="guest-info"><div class="guest-name"><?php echo e($reservation->guest_name); ?></div></div></td>
                        <td><div class="contact-info"><a href="tel:<?php echo e($reservation->guest_contact); ?>" class="contact-link"><i class="fas fa-phone"></i> <?php echo e($reservation->guest_contact); ?></a></div></td>
                        <td><div class="description-content"><?php echo e(Str::limit($reservation->description, 50)); ?></div></td>
                        <td>
                            <?php if($reservation->status === 'pending'): ?>
                                <div class="status-badge-modern status-pending"><div class="status-dot"></div><span>Pending</span></div>
                            <?php elseif($reservation->status === 'approved'): ?>
                                <div class="status-badge-modern status-approved"><div class="status-dot"></div><span>Approved</span></div>
                            <?php elseif($reservation->status === 'rejected'): ?>
                                <div class="status-badge-modern status-rejected"><div class="status-dot"></div><span>Rejected</span></div>
                            <?php else: ?>
                                <div class="status-badge-modern status-cancelled"><div class="status-dot"></div><span>Cancelled</span></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="date-display-modern">
                                <div class="date-icon"><i class="fas fa-clock"></i></div>
                                <div class="date-info">
                                    <div class="date-value"><?php echo e($reservation->created_at->format('M d, Y')); ?></div>
                                    <div class="date-ago"><?php echo e($reservation->created_at->diffForHumans()); ?></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="table-pagination" id="allPagination">
            <div class="pagination-info-text" id="allPaginationInfo"></div>
            <div class="pagination-buttons" id="allPaginationBtns"></div>
        </div>
        <?php else: ?>
        <div class="empty-state-modern empty-state-small">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <h3 class="empty-state-title">No Reservations Yet</h3>
            <p class="empty-state-description">All reservation requests will appear here</p>
        </div>
        <?php endif; ?>
    </div>
 
</div>
 
<!-- Update Gmail Modal -->
<div class="modal fade" id="updateGmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a3a52 0%,#2d5a7b 100%);color:white;">
                <h5 class="modal-title"><i class="fas fa-envelope"></i> Add Gmail Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom:15px;color:#333;">Enter your Gmail address to enable Google Calendar integration.</p>
                <form id="updateGmailForm" action="<?php echo e(route('admin.update-gmail')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group" style="margin-bottom:15px;">
                        <label for="gmail_address" style="font-weight:600;color:#333;margin-bottom:8px;display:block;">Gmail Address</label>
                        <input type="email" id="gmail_address" name="gmail_address" class="form-control" placeholder="your.email@gmail.com" value="<?php echo e(auth()->user()->gmail_address ?? ''); ?>" required>
                        <small style="color:#666;display:block;margin-top:5px;">Use your Gmail account connected to Google Calendar</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#1a3a52 0%,#2d5a7b 100%);border:none;padding:10px;">
                        <i class="fas fa-save"></i> Save Gmail Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="notification-toast-wrapper" style="position: fixed; top: 25px; right: 25px; z-index: 9999;">
    <?php if(session('toast_success')): ?>
        <div class="modern-toast toast-success">
            <div class="toast-icon"><i class="fas fa-check-circle"></i></div>
            <div class="toast-body"><?php echo e(session('toast_success')); ?></div>
            <button onclick="this.parentElement.remove()" class="toast-close">&times;</button>
        </div>
    <?php endif; ?>

    <?php if(session('toast_error')): ?>
        <div class="modern-toast toast-error">
            <div class="toast-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="toast-body"><?php echo e(session('toast_error')); ?></div>
            <button onclick="this.parentElement.remove()" class="toast-close">&times;</button>
        </div>
    <?php endif; ?>
</div>

<script>
    // Automatically fade out and remove the toast after 4 seconds
    document.querySelectorAll('.modern-toast').forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Approve Confirmation
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.onclick = function() {
            Swal.fire({
                title: 'Approve Reservation?',
                text: "This will confirm the clinic appointment for " + this.dataset.name,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Yes, Approve'
            }).then((result) => { if (result.isConfirmed) this.parentElement.submit(); });
        };
    });

    // Reject Confirmation
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.onclick = function() {
            Swal.fire({
                title: 'Reject Reservation?',
                text: "Are you sure you want to decline " + this.dataset.name + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, Reject'
            }).then((result) => { if (result.isConfirmed) this.parentElement.submit(); });
        };
    });
});
</script>
 
<script>
const PER_PAGE = 10;
 
function createTableController(config) {
    const { searchInputId, clearBtnId, tbodyId, countId, paginationInfoId, paginationBtnsId, statusFilterId = null, rowStatusAttr = null } = config;
    const searchInput  = document.getElementById(searchInputId);
    const clearBtn     = document.getElementById(clearBtnId);
    const tbody        = document.getElementById(tbodyId);
    const countEl      = document.getElementById(countId);
    const pgInfoEl     = document.getElementById(paginationInfoId);
    const pgBtnsEl     = document.getElementById(paginationBtnsId);
    const statusFilter = statusFilterId ? document.getElementById(statusFilterId) : null;
    if (!searchInput || !tbody) return;
    const allRows = Array.from(tbody.querySelectorAll('tr'));
    let filteredRows = [...allRows], currentPage = 1;
 
    function applyFilters() {
        const term = searchInput.value.trim().toLowerCase();
        const status = statusFilter ? statusFilter.value : 'all';
        filteredRows = allRows.filter(row => {
            const s = (row.dataset.search || '').toLowerCase();
            const rs = rowStatusAttr ? (row.dataset[rowStatusAttr] || '') : '';
            return (!term || s.includes(term)) && (status === 'all' || rs === status);
        });
        currentPage = 1; render();
    }
 
    function render() {
        const total = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * PER_PAGE, end = start + PER_PAGE;
        allRows.forEach(r => r.style.display = 'none');
        filteredRows.slice(start, end).forEach(r => r.style.display = '');
        const noR = tbody.querySelector('.no-results-row');
        if (noR) noR.remove();
        if (!filteredRows.length) {
            const cols = tbody.closest('table').querySelectorAll('thead th').length;
            const nr = document.createElement('tr'); nr.className = 'no-results-row';
            nr.innerHTML = `<td colspan="${cols}"><i class="fas fa-search"></i> No records match your search.</td>`;
            tbody.appendChild(nr);
        }
        if (countEl) {
            const isF = searchInput.value.trim() || (statusFilter && statusFilter.value !== 'all');
            countEl.innerHTML = isF ? `<span>${total}</span> result${total !== 1 ? 's' : ''} found` : `<span>${total}</span> record${total !== 1 ? 's' : ''} total`;
        }
        if (pgInfoEl) pgInfoEl.innerHTML = !total ? 'No records' : `Showing <strong>${start+1}–${Math.min(end,total)}</strong> of <strong>${total}</strong>`;
        if (pgBtnsEl) {
            pgBtnsEl.innerHTML = '';
            if (totalPages <= 1) return;
            const mk = (html, disabled, onClick) => { const b = document.createElement('button'); b.className = 'pg-btn'; b.innerHTML = html; b.disabled = disabled; if (!disabled) b.addEventListener('click', onClick); pgBtnsEl.appendChild(b); };
            mk('<i class="fas fa-chevron-left"></i>', currentPage === 1, () => { currentPage--; render(); });
            getPageNumbers(currentPage, totalPages).forEach(p => {
                if (p === '...') { const s = document.createElement('span'); s.className = 'pg-ellipsis'; s.textContent = '…'; pgBtnsEl.appendChild(s); }
                else { const b = document.createElement('button'); b.className = 'pg-btn' + (p === currentPage ? ' active' : ''); b.textContent = p; b.addEventListener('click', () => { currentPage = p; render(); }); pgBtnsEl.appendChild(b); }
            });
            mk('<i class="fas fa-chevron-right"></i>', currentPage === totalPages, () => { currentPage++; render(); });
        }
    }
 
    function updateClear() { if (clearBtn) clearBtn.style.display = searchInput.value.length ? 'block' : 'none'; }
    searchInput.addEventListener('input', () => { updateClear(); applyFilters(); });
    if (clearBtn) clearBtn.addEventListener('click', () => { searchInput.value = ''; updateClear(); applyFilters(); searchInput.focus(); });
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    render();
}
 
function getPageNumbers(current, total) {
    if (total <= 7) return Array.from({length: total}, (_,i) => i+1);
    const p = [1];
    if (current > 3) p.push('...');
    for (let i = Math.max(2, current-1); i <= Math.min(total-1, current+1); i++) p.push(i);
    if (current < total-2) p.push('...');
    p.push(total);
    return p;
}
 
function createFacilitiesController() {
    const searchInput  = document.getElementById('facilitiesSearch');
    const clearBtn     = document.getElementById('facilitiesClear');
    const statusFilter = document.getElementById('facilitiesStatusFilter');
    const grid         = document.getElementById('facilitiesGrid');
    const countEl      = document.getElementById('facilitiesCount');
    const pgInfoEl     = document.getElementById('facilitiesPaginationInfo');
    const pgBtnsEl     = document.getElementById('facilitiesPaginationBtns');
    const noResultsEl  = document.getElementById('facilitiesNoResults');
    if (!searchInput || !grid) return;
    const allCards = Array.from(grid.querySelectorAll('.facility-card-item'));
    let filteredCards = [...allCards], currentPage = 1;
 
    function applyFilters() {
        const term = searchInput.value.trim().toLowerCase();
        const status = statusFilter ? statusFilter.value : 'all';
        filteredCards = allCards.filter(c => {
            const n = (c.dataset.name||'').toLowerCase(), l = (c.dataset.location||'').toLowerCase(), s = (c.dataset.status||'').toLowerCase();
            return (!term || n.includes(term) || l.includes(term)) && (status === 'all' || s === status);
        });
        currentPage = 1; render();
    }
 
    function render() {
        const total = filteredCards.length, totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage-1)*PER_PAGE, end = start+PER_PAGE;
        allCards.forEach(c => c.style.display = 'none');
        filteredCards.slice(start, end).forEach(c => c.style.display = '');
        if (noResultsEl) noResultsEl.style.display = !filteredCards.length ? 'block' : 'none';
        if (countEl) {
            const isF = searchInput.value.trim() || (statusFilter && statusFilter.value !== 'all');
            countEl.innerHTML = isF ? `<span>${total}</span> result${total!==1?'s':''} found` : `<span>${total}</span> facilit${total!==1?'ies':'y'} total`;
        }
        if (pgInfoEl) pgInfoEl.innerHTML = !total ? 'No facilities' : `Showing <strong>${start+1}–${Math.min(end,total)}</strong> of <strong>${total}</strong>`;
        if (pgBtnsEl) {
            pgBtnsEl.innerHTML = '';
            if (totalPages <= 1) return;
            const mk = (html, disabled, onClick) => { const b = document.createElement('button'); b.className = 'pg-btn'; b.innerHTML = html; b.disabled = disabled; if (!disabled) b.addEventListener('click', onClick); pgBtnsEl.appendChild(b); };
            mk('<i class="fas fa-chevron-left"></i>', currentPage===1, ()=>{currentPage--;render();});
            getPageNumbers(currentPage,totalPages).forEach(p => {
                if (p==='...'){const s=document.createElement('span');s.className='pg-ellipsis';s.textContent='…';pgBtnsEl.appendChild(s);}
                else{const b=document.createElement('button');b.className='pg-btn'+(p===currentPage?' active':'');b.textContent=p;b.addEventListener('click',()=>{currentPage=p;render();});pgBtnsEl.appendChild(b);}
            });
            mk('<i class="fas fa-chevron-right"></i>', currentPage===totalPages, ()=>{currentPage++;render();});
        }
    }
 
    function updateClear() { if (clearBtn) clearBtn.style.display = searchInput.value.length ? 'block' : 'none'; }
    searchInput.addEventListener('input', () => { updateClear(); applyFilters(); });
    if (clearBtn) clearBtn.addEventListener('click', () => { searchInput.value=''; updateClear(); applyFilters(); searchInput.focus(); });
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    render();
}
 
document.addEventListener('DOMContentLoaded', function () {
    createTableController({ searchInputId:'pendingSearch', clearBtnId:'pendingClear', tbodyId:'pendingTbody', countId:'pendingCount', paginationInfoId:'pendingPaginationInfo', paginationBtnsId:'pendingPaginationBtns' });
    createTableController({ searchInputId:'approvedSearch', clearBtnId:'approvedClear', tbodyId:'approvedTbody', countId:'approvedCount', paginationInfoId:'approvedPaginationInfo', paginationBtnsId:'approvedPaginationBtns' });
    createTableController({ searchInputId:'allSearch', clearBtnId:'allClear', tbodyId:'allTbody', countId:'allCount', paginationInfoId:'allPaginationInfo', paginationBtnsId:'allPaginationBtns', statusFilterId:'allStatusFilter', rowStatusAttr:'status' });
    createFacilitiesController();
 
    document.querySelectorAll('.notification-close').forEach(b => b.addEventListener('click', function(){ this.closest('.notification-card').style.display='none'; }));
 
    document.querySelectorAll('.dropdown-toggle-btn').forEach(b => b.addEventListener('click', function(e){ e.stopPropagation(); const d=this.nextElementSibling; d.style.display=d.style.display==='block'?'none':'block'; }));
    document.addEventListener('click', () => document.querySelectorAll('.dropdown-menu-facility').forEach(d=>d.style.display='none'));
 
    document.querySelectorAll('.stat-card-modern').forEach(card => {
        card.addEventListener('mouseenter', function(){ const f=this.querySelector('.progress-fill'),w=f.style.width; f.style.width='100%'; setTimeout(()=>{if(f.style.width==='100%')f.style.width=w;},300); });
    });
});
</script>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/dashboards/admin.blade.php ENDPATH**/ ?>