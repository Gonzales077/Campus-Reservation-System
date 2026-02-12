<?php $__env->startSection('content'); ?>
<div class="user-dashboard">
    <!-- Hero Section -->
    <div class="dashboard-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="welcome-badge">
                <i class="fas fa-calendar-check"></i>
                <span>Dashboard</span>
            </div>
            <h1 class="welcome-title">
                Welcome back, <span class="user-name"><?php echo e(auth()->user()->name); ?></span>
            </h1>
            <p class="welcome-subtitle">
                Manage your facility reservations and browse available spaces
            </p>
            <div class="quick-stats">
                <div class="stat-chip">
                    <i class="fas fa-building"></i>
                    <span><?php echo e($facilities->count()); ?> Facilities Available</span>
                </div>
                <div class="stat-chip">
                    <i class="fas fa-clock"></i>
                    <span><?php echo e($reservations->where('status', 'pending')->count()); ?> Pending Requests</span>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="notification-card notification-success">
            <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-content">
                <h4>Success!</h4>
                <p><?php echo e(session('success')); ?></p>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <div class="notification-card notification-error">
            <div class="notification-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notification-content">
                <h4>Error</h4>
                <p><?php echo e(session('error')); ?></p>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Available Facilities Section -->
    <div class="dashboard-section">
        <div class="section-header-modern">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <i class="fas fa-building"></i>
                </div>
                <div class="header-text">
                    <h2 class="section-title">Available Facilities</h2>
                    <p class="section-description">Browse and reserve facilities that match your needs</p>
                </div>
            </div>
            <div class="header-right">
                <span class="facility-count-badge">
                    <?php echo e($facilities->count()); ?> <?php echo e(Str::plural('Facility', $facilities->count())); ?>

                </span>
            </div>
        </div>
        
        <div class="facility-grid-modern">
            <?php $__empty_1 = true; $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="facility-card-modern">
                <div class="card-header-gradient" style="background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);"></div>
                <div class="card-content">
                    <div class="facility-icon-circle">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <h3 class="facility-name"><?php echo e($facility->name); ?></h3>
                    <p class="facility-description"><?php echo e(Str::limit($facility->description, 100)); ?></p>
                    
                    <div class="facility-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="feature-text">
                                <span class="feature-label">Location</span>
                                <span class="feature-value"><?php echo e($facility->location); ?></span>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="feature-text">
                                <span class="feature-label">Capacity</span>
                                <span class="feature-value"><?php echo e($facility->capacity); ?> people</span>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="feature-text">
                                <span class="feature-label">Availability</span>
                                <span class="feature-value"><?php echo e($facility->available_hours); ?> hours/day</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(route('reservations.create', ['facility' => $facility->id])); ?>" class="reserve-button">
                        <span>Reserve Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state-modern">
                <div class="empty-state-icon">
                    <i class="fas fa-door-closed"></i>
                </div>
                <h3 class="empty-state-title">No Facilities Available</h3>
                <p class="empty-state-description">
                    All facilities are currently reserved. Please check back later or contact the administrator.
                </p>
                <button class="refresh-button" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    <span>Refresh</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Reservations Section -->
    <div class="dashboard-section">
        <div class="section-header-modern">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="header-text">
                    <h2 class="section-title">My Reservations</h2>
                    <p class="section-description">Track the status of your reservation requests</p>
                </div>
            </div>
            <div class="header-right">
                <span class="reservation-count-badge">
                    <?php echo e($reservations->count()); ?> Total
                </span>
            </div>
        </div>
        
        <?php if($reservations->count() > 0): ?>
        <div class="reservations-timeline">
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="reservation-card <?php echo e($reservation->status); ?>">
                <div class="reservation-status-indicator">
                    <div class="status-dot status-<?php echo e($reservation->status); ?>"></div>
                </div>
                
                <div class="reservation-content">
                    <div class="reservation-header">
                        <div class="reservation-title">
                            <h4 class="facility-title"><?php echo e($reservation->facility->name); ?></h4>
                            <span class="reservation-id">#<?php echo e($reservation->id); ?></span>
                        </div>
                        <div class="reservation-status-badge">
                            <?php if($reservation->status === 'pending'): ?>
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Pending Review
                                </span>
                            <?php elseif($reservation->status === 'approved'): ?>
                                <span class="status-badge status-approved">
                                    <i class="fas fa-check-circle"></i>
                                    Approved
                                </span>
                            <?php elseif($reservation->status === 'rejected'): ?>
                                <span class="status-badge status-rejected">
                                    <i class="fas fa-times-circle"></i>
                                    Rejected
                                </span>
                            <?php else: ?>
                                <span class="status-badge status-cancelled">
                                    <i class="fas fa-ban"></i>
                                    Cancelled
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="reservation-details">
                        <div class="detail-group">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-align-left"></i>
                                    <span>Purpose:</span>
                                </div>
                                <div class="detail-value">
                                    <?php echo e(Str::limit($reservation->description, 80)); ?>

                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar"></i>
                                    <span>Submitted:</span>
                                </div>
                                <div class="detail-value">
                                    <?php echo e($reservation->created_at->format('F d, Y')); ?>

                                    <span class="detail-meta"><?php echo e($reservation->created_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                            
                            <?php if($reservation->status === 'approved' && $reservation->available_date): ?>
                            <div class="detail-row highlight">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Available From:</span>
                                </div>
                                <div class="detail-value">
                                    <strong><?php echo e($reservation->available_date->format('F d, Y')); ?></strong>
                                    <span class="detail-meta">(<?php echo e($reservation->available_date->diffForHumans()); ?>)</span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="reservation-footer">
                        <?php if($reservation->status === 'pending'): ?>
                        <form action="<?php echo e(route('reservations.destroy', $reservation)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="cancel-button" onclick="return confirm('Are you sure you want to cancel this reservation?')">
                                <i class="fas fa-times"></i>
                                <span>Cancel Request</span>
                            </button>
                        </form>
                        <?php elseif($reservation->status === 'approved'): ?>
                        <div class="approved-message">
                            <i class="fas fa-check-circle"></i>
                            <span>Your reservation has been approved</span>
                        </div>
                        <?php elseif($reservation->status === 'rejected'): ?>
                        <div class="rejected-message">
                            <i class="fas fa-info-circle"></i>
                            <span>This reservation request was declined</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <?php if($reservations->count() > 5): ?>
        <div class="view-more-container">
            <button class="view-more-button">
                <span>View All Reservations</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="empty-state-modern compact">
            <div class="empty-state-icon small">
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3 class="empty-state-title">No Reservations Yet</h3>
            <p class="empty-state-description">
                You haven't made any facility reservations. Browse available facilities above to get started.
            </p>
            <a href="#available-facilities" class="primary-button">
                <i class="fas fa-search"></i>
                <span>Browse Facilities</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    :root {
        --hcc-blue: #1a3a52;
        --hcc-blue-dark: #0f2432;
        --hcc-blue-light: #2d5a7b;
        --hcc-blue-lighter: #3a6b91;
        --hcc-blue-xlight: #4a7ca8;
        --hcc-gold: #d4af37;
        --hcc-gold-dark: #b8941f;
        --hcc-gold-light: #e6c56e;
        --hcc-gold-xlight: #f3e0b5;
        --hcc-success: #10b981;
        --hcc-success-light: #d1fae5;
        --hcc-warning: #f59e0b;
        --hcc-warning-light: #fef3c7;
        --hcc-danger: #ef4444;
        --hcc-danger-light: #fee2e2;
        
        --background-primary: #ffffff;
        --background-secondary: #f8fafc;
        --background-tertiary: #f1f5f9;
        --background-card: #ffffff;
        
        --text-primary: #0f172a;
        --text-secondary: #334155;
        --text-tertiary: #64748b;
        --text-muted: #94a3b8;
        
        --border-light: #e2e8f0;
        --border-medium: #cbd5e1;
        --border-strong: #94a3b8;
        
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .user-dashboard {
        padding: 0 0 2rem 0;
        background: linear-gradient(135deg, var(--background-secondary) 0%, var(--background-tertiary) 100%);
        min-height: 100vh;
    }

    /* Hero Section */
    .dashboard-hero {
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-dark) 100%);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
    }

    .hero-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
        position: relative;
        z-index: 2;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        color: var(--hcc-gold-light);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    .welcome-title {
        color: white;
        font-size: 2.75rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }

    .user-name {
        color: var(--hcc-gold);
        position: relative;
        display: inline-block;
    }

    .user-name::after {
        content: '';
        position: absolute;
        bottom: 0.25rem;
        left: 0;
        right: 0;
        height: 0.25rem;
        background: linear-gradient(90deg, var(--hcc-gold) 0%, transparent 100%);
        border-radius: 0.125rem;
    }

    .welcome-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        max-width: 600px;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .quick-stats {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stat-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 0.625rem 1.25rem;
        border-radius: 2rem;
        color: white;
        font-size: 0.9375rem;
        font-weight: 500;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .stat-chip:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .stat-chip i {
        color: var(--hcc-gold);
    }

    /* Notifications */
    .notification-card {
        max-width: 1400px;
        margin: 0 auto 1.5rem;
        padding: 1.25rem 1.5rem;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        position: relative;
        animation: slideIn 0.3s ease-out;
        box-shadow: var(--shadow-lg);
    }

    .notification-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .notification-error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .notification-icon {
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
    }

    .notification-content h4 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .notification-content p {
        font-size: 0.9375rem;
        opacity: 0.95;
        margin: 0;
    }

    .notification-close {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: var(--radius-sm);
        transition: all 0.2s;
        font-size: 1rem;
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* Dashboard Sections */
    .dashboard-section {
        max-width: 1400px;
        margin: 0 auto 2.5rem;
        padding: 0 2rem;
    }

    .section-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon-wrapper {
        width: 3.5rem;
        height: 3.5rem;
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hcc-gold);
        font-size: 1.5rem;
        box-shadow: var(--shadow-md);
    }

    .header-text {
        display: flex;
        flex-direction: column;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0 0 0.25rem 0;
        letter-spacing: -0.025em;
    }

    .section-description {
        font-size: 0.9375rem;
        color: var(--text-tertiary);
        margin: 0;
    }

    .facility-count-badge,
    .reservation-count-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1.25rem;
        background: white;
        border: 1px solid var(--border-light);
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--hcc-blue);
        box-shadow: var(--shadow-sm);
    }

    /* Facility Grid */
    .facility-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
    }

    .facility-card-modern {
        background: var(--background-card);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border-light);
    }

    .facility-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-xl);
        border-color: var(--hcc-blue-light);
    }

    .card-header-gradient {
        height: 0.5rem;
        width: 100%;
    }

    .card-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .facility-icon-circle {
        width: 4rem;
        height: 4rem;
        background: linear-gradient(135deg, var(--hcc-gold-light) 0%, var(--hcc-gold) 100%);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: var(--hcc-blue-dark);
        font-size: 1.75rem;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .facility-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0 0 0.75rem 0;
        line-height: 1.3;
    }

    .facility-description {
        color: var(--text-secondary);
        font-size: 0.9375rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .facility-features {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.25rem;
        background: var(--background-tertiary);
        border-radius: var(--radius-lg);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .feature-icon {
        width: 2rem;
        height: 2rem;
        background: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hcc-gold);
        font-size: 1rem;
        box-shadow: var(--shadow-sm);
    }

    .feature-text {
        display: flex;
        flex-direction: column;
    }

    .feature-label {
        font-size: 0.75rem;
        color: var(--text-tertiary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.125rem;
    }

    .feature-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .reserve-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: auto;
        position: relative;
        overflow: hidden;
    }

    .reserve-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .reserve-button:hover {
        background: linear-gradient(135deg, var(--hcc-blue-dark) 0%, var(--hcc-blue) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 58, 82, 0.4);
    }

    .reserve-button:hover::before {
        width: 300px;
        height: 300px;
    }

    .reserve-button i {
        transition: transform 0.3s ease;
    }

    .reserve-button:hover i {
        transform: translateX(4px);
    }

    /* Reservations Timeline */
    .reservations-timeline {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .reservation-card {
        background: var(--background-card);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        position: relative;
    }

    .reservation-card:hover {
        border-color: var(--hcc-blue-light);
        box-shadow: var(--shadow-lg);
    }

    .reservation-status-indicator {
        width: 0.375rem;
        background: var(--border-medium);
        transition: background 0.3s ease;
    }

    .status-dot {
        width: 100%;
        height: 100%;
    }

    .status-pending {
        background: var(--hcc-warning);
    }

    .status-approved {
        background: var(--hcc-success);
    }

    .status-rejected {
        background: var(--hcc-danger);
    }

    .status-cancelled {
        background: var(--text-tertiary);
    }

    .reservation-content {
        flex: 1;
        padding: 1.75rem;
    }

    .reservation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .reservation-title {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .facility-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0;
    }

    .reservation-id {
        font-size: 0.875rem;
        color: var(--text-tertiary);
        font-weight: 500;
        padding: 0.25rem 0.75rem;
        background: var(--background-tertiary);
        border-radius: 2rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge i {
        font-size: 0.875rem;
    }

    .status-pending {
        background: var(--hcc-warning-light);
        color: #92400e;
    }

    .status-approved {
        background: var(--hcc-success-light);
        color: #065f46;
    }

    .status-rejected {
        background: var(--hcc-danger-light);
        color: #991b1b;
    }

    .status-cancelled {
        background: var(--background-tertiary);
        color: var(--text-tertiary);
    }

    .reservation-details {
        margin-bottom: 1.5rem;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.5rem 0;
    }

    .detail-row.highlight {
        background: rgba(212, 175, 55, 0.08);
        padding: 0.75rem;
        border-radius: var(--radius-md);
        margin: 0.25rem 0;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 110px;
        color: var(--text-tertiary);
        font-size: 0.875rem;
    }

    .detail-label i {
        color: var(--hcc-gold);
        width: 1rem;
    }

    .detail-value {
        flex: 1;
        color: var(--text-primary);
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .detail-meta {
        display: inline-block;
        margin-left: 0.5rem;
        color: var(--text-tertiary);
        font-size: 0.8125rem;
    }

    .reservation-footer {
        display: flex;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid var(--border-light);
    }

    .cancel-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        background: linear-gradient(135deg, var(--hcc-danger) 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cancel-button:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .approved-message,
    .rejected-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .approved-message {
        background: var(--hcc-success-light);
        color: #065f46;
    }

    .rejected-message {
        background: var(--hcc-danger-light);
        color: #991b1b;
    }

    .approved-message i,
    .rejected-message i {
        font-size: 1rem;
    }

    /* Empty States */
    .empty-state-modern {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, var(--background-primary) 0%, var(--background-tertiary) 100%);
        border-radius: var(--radius-xl);
        border: 2px dashed var(--border-medium);
    }

    .empty-state-modern.compact {
        padding: 3rem 2rem;
    }

    .empty-state-icon {
        width: 6rem;
        height: 6rem;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--hcc-gold-xlight) 0%, var(--hcc-gold-light) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hcc-gold-dark);
        font-size: 2.5rem;
    }

    .empty-state-icon.small {
        width: 5rem;
        height: 5rem;
        font-size: 2rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin-bottom: 0.75rem;
    }

    .empty-state-description {
        color: var(--text-tertiary);
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    .refresh-button,
    .primary-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .refresh-button:hover,
    .primary-button:hover {
        background: linear-gradient(135deg, var(--hcc-blue-dark) 0%, var(--hcc-blue) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* View More */
    .view-more-container {
        margin-top: 2rem;
        text-align: center;
    }

    .view-more-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: white;
        border: 1px solid var(--border-medium);
        border-radius: var(--radius-md);
        color: var(--hcc-blue);
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-more-button:hover {
        background: var(--background-tertiary);
        border-color: var(--hcc-blue);
        gap: 0.75rem;
    }

    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .hero-content {
            padding: 2.5rem 1.5rem;
        }

        .welcome-title {
            font-size: 2.25rem;
        }

        .dashboard-section {
            padding: 0 1.5rem;
        }

        .facility-grid-modern {
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .hero-content {
            padding: 2rem 1.25rem;
            text-align: center;
        }

        .welcome-title {
            font-size: 1.875rem;
        }

        .welcome-subtitle {
            margin-left: auto;
            margin-right: auto;
        }

        .quick-stats {
            justify-content: center;
        }

        .dashboard-section {
            padding: 0 1.25rem;
        }

        .section-header-modern {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-left {
            width: 100%;
        }

        .facility-grid-modern {
            grid-template-columns: 1fr;
        }

        .reservation-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .reservation-title {
            width: 100%;
        }

        .detail-row {
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-label {
            min-width: auto;
        }
    }

    @media (max-width: 480px) {
        .hero-content {
            padding: 1.5rem 1rem;
        }

        .welcome-title {
            font-size: 1.5rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }

        .stat-chip {
            width: 100%;
            justify-content: center;
        }

        .dashboard-section {
            padding: 0 1rem;
        }

        .card-content {
            padding: 1.5rem;
        }

        .facility-icon-circle {
            width: 3.5rem;
            height: 3.5rem;
            font-size: 1.5rem;
        }

        .facility-name {
            font-size: 1.25rem;
        }

        .reservation-content {
            padding: 1.25rem;
        }

        .empty-state-modern {
            padding: 2rem 1rem;
        }

        .empty-state-icon {
            width: 5rem;
            height: 5rem;
            font-size: 2rem;
        }

        .empty-state-title {
            font-size: 1.25rem;
        }
    }
</style>

<script>
    // Close notification functionality
    document.querySelectorAll('.notification-close').forEach(button => {
        button.addEventListener('click', function() {
            const notification = this.closest('.notification-card');
            notification.style.animation = 'slideOut 0.3s ease-out forwards';
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
    });

    // Add slideOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    `;
    document.head.appendChild(style);

    // Smooth scroll to facilities section
    document.querySelectorAll('a[href="#available-facilities"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const facilitiesSection = document.querySelector('.dashboard-section');
            if (facilitiesSection) {
                facilitiesSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // View more button functionality
    document.querySelector('.view-more-button')?.addEventListener('click', function() {
        // Add your view more logic here
        console.log('View more reservations clicked');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/dashboards/user.blade.php ENDPATH**/ ?>