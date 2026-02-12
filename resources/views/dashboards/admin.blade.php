@extends('layouts.app')

@section('content')
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
                    <a href="{{ route('facilities.create') }}" class="header-action-btn">
                        <div class="btn-icon-wrapper">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="btn-content">
                            <span class="btn-label">Create New</span>
                            <span class="btn-sublabel">Add Facility</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="notification-card notification-success">
            <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-content">
                <p class="notification-message">{{ session('success') }}</p>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="notification-card notification-error">
            <div class="notification-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notification-content">
                <p class="notification-message">{{ session('error') }}</p>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Statistics Overview -->
    <div class="stats-overview-section">
        <div class="section-title-bar">
            <h2 class="section-title">
                <i class="fas fa-chart-line"></i>
                <span>Overview</span>
            </h2>
            <div class="last-updated">
                <i class="fas fa-sync-alt"></i>
                <span>Updated just now</span>
            </div>
        </div>
        
        <div class="stats-grid-modern">
            <div class="stat-card-modern stat-warning">
                <div class="stat-card-header">
                    <div class="stat-icon-modern">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-urgency">
                        <span class="urgency-badge">Requires Action</span>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $pendingReservations->count() }}</h3>
                    <p class="stat-label">Pending Requests</p>
                    <div class="stat-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $pendingReservations->count() > 0 ? '80%' : '0%' }}"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="#pending-section" class="stat-action-link">
                        <span>Review All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="stat-card-modern stat-success">
                <div class="stat-card-header">
                    <div class="stat-icon-modern">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-urgency">
                        <span class="urgency-badge active">Active</span>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $approvedReservations->count() }}</h3>
                    <p class="stat-label">Approved Bookings</p>
                    <div class="stat-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $approvedReservations->count() > 0 ? '60%' : '0%' }}"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="#approved-section" class="stat-action-link">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="stat-card-modern stat-primary">
                <div class="stat-card-header">
                    <div class="stat-icon-modern">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-urgency">
                        <span class="urgency-badge">Available</span>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $facilities->count() }}</h3>
                    <p class="stat-label">Total Facilities</p>
                    <div class="stat-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $facilities->where('status', 'active')->count() / max($facilities->count(), 1) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="#facilities-section" class="stat-action-link">
                        <span>Manage All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="stat-card-modern stat-secondary">
                <div class="stat-card-header">
                    <div class="stat-icon-modern">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="stat-urgency">
                        <span class="urgency-badge">Total</span>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $allReservations->count() }}</h3>
                    <p class="stat-label">All Reservations</p>
                    <div class="stat-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $allReservations->count() > 0 ? '40%' : '0%' }}"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="#all-reservations" class="stat-action-link">
                        <span>See All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Reservations Section -->
    @if($pendingReservations->count() > 0)
    <div class="modern-section-card urgent-section" id="pending-section">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">Pending Reservation Requests</h2>
                    <p class="section-subtitle">Action required for these reservation requests</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge badge-warning">
                    <i class="fas fa-clock"></i>
                    {{ $pendingReservations->count() }} Pending
                </span>
                <button class="section-action-btn" title="Export">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
        
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility">
                            <i class="fas fa-building"></i>
                            <span>Facility</span>
                        </th>
                        <th class="table-col-guest">
                            <i class="fas fa-user"></i>
                            <span>Guest</span>
                        </th>
                        <th class="table-col-contact">
                            <i class="fas fa-phone"></i>
                            <span>Contact</span>
                        </th>
                        <th class="table-col-description">
                            <i class="fas fa-align-left"></i>
                            <span>Description</span>
                        </th>
                        <th class="table-col-actions">
                            <i class="fas fa-cog"></i>
                            <span>Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingReservations as $reservation)
                    <tr>
                        <td class="table-col-facility">
                            <div class="facility-info">
                                <div class="facility-name">{{ $reservation->facility->name }}</div>
                                <div class="facility-meta">
                                    <span class="facility-meta-item">
                                        <i class="fas fa-users"></i>
                                        {{ $reservation->facility->capacity }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="table-col-guest">
                            <div class="guest-info">
                                <div class="guest-name">{{ $reservation->guest_name }}</div>
                                <div class="guest-date">{{ $reservation->created_at->format('M d, Y') }}</div>
                            </div>
                        </td>
                        <td class="table-col-contact">
                            <div class="contact-info">
                                <a href="tel:{{ $reservation->guest_contact }}" class="contact-link">
                                    <i class="fas fa-phone"></i>
                                    {{ $reservation->guest_contact }}
                                </a>
                            </div>
                        </td>
                        <td class="table-col-description">
                            <div class="description-content">
                                {{ Str::limit($reservation->description, 60) }}
                            </div>
                        </td>
                        <td class="table-col-actions">
                            <div class="action-buttons-modern">
                                <!-- Approve Button - Now using the original modal trigger -->
                                <button type="button" class="action-btn action-approve" data-bs-toggle="modal" data-bs-target="#approveModal{{ $reservation->id }}">
                                    <i class="fas fa-check"></i>
                                    <span>Approve</span>
                                </button>
                                
                                <!-- Reject Button - Original form -->
                                <form action="{{ route('reservations.reject', $reservation) }}" method="POST" class="inline-form-modern">
                                    @csrf
                                    <button type="submit" class="action-btn action-reject" onclick="return confirm('Are you sure you want to reject this reservation?')">
                                        <i class="fas fa-times"></i>
                                        <span>Reject</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="section-footer">
            <a href="#" class="view-all-link">
                <span>View all pending requests</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Restore Original Modals -->
    @foreach($pendingReservations as $reservation)
    <!-- Approve Modal - Using original structure -->
    <div class="modal fade" id="approveModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header-custom">
                    <h5><i class="fas fa-check-circle"></i> Approve Reservation</h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('reservations.approve', $reservation) }}" method="POST">
                    @csrf
                    <div class="modal-body-custom">
                        <div class="info-box">
                            <p><strong>Facility:</strong> {{ $reservation->facility->name }}</p>
                            <p><strong>Guest:</strong> {{ $reservation->guest_name }}</p>
                            <p><strong>Purpose:</strong> {{ $reservation->description }}</p>
                        </div>
                        <div class="form-group-custom">
                            <label for="available_date{{ $reservation->id }}">
                                <i class="fas fa-calendar-alt"></i> Available Date *
                            </label>
                            <input type="date" class="form-control-custom" id="available_date{{ $reservation->id }}" name="available_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            <small>Select when the facility will be available again</small>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn-modal-confirm">
                            <i class="fas fa-check"></i> Approve Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Approved Reservations Section -->
    @if($approvedReservations->count() > 0)
    <div class="modern-section-card" id="approved-section">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">Currently Reserved Facilities</h2>
                    <p class="section-subtitle">Active and upcoming reservations</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <span class="status-count-badge badge-success">
                    <i class="fas fa-check-circle"></i>
                    {{ $approvedReservations->count() }} Active
                </span>
            </div>
        </div>
        
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility">
                            <i class="fas fa-building"></i>
                            <span>Facility</span>
                        </th>
                        <th class="table-col-guest">
                            <i class="fas fa-user"></i>
                            <span>Reserved By</span>
                        </th>
                        <th class="table-col-contact">
                            <i class="fas fa-phone"></i>
                            <span>Contact</span>
                        </th>
                        <th class="table-col-description">
                            <i class="fas fa-info-circle"></i>
                            <span>Purpose</span>
                        </th>
                        <th class="table-col-date">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Available Date</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvedReservations as $reservation)
                    <tr>
                        <td class="table-col-facility">
                            <div class="facility-info">
                                <div class="facility-name">{{ $reservation->facility->name }}</div>
                                <div class="facility-meta">
                                    <span class="facility-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $reservation->facility->location }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="table-col-guest">
                            <div class="guest-info">
                                <div class="guest-name">{{ $reservation->guest_name }}</div>
                                <div class="guest-date">Approved on {{ $reservation->updated_at->format('M d') }}</div>
                            </div>
                        </td>
                        <td class="table-col-contact">
                            <div class="contact-info">
                                <a href="tel:{{ $reservation->guest_contact }}" class="contact-link">
                                    <i class="fas fa-phone"></i>
                                    {{ $reservation->guest_contact }}
                                </a>
                            </div>
                        </td>
                        <td class="table-col-description">
                            <div class="description-content">
                                {{ Str::limit($reservation->description, 50) }}
                            </div>
                        </td>
                        <td class="table-col-date">
                            <div class="date-display-modern">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="date-info">
                                    <div class="date-value">
                                        {{ $reservation->available_date ? $reservation->available_date->format('M d, Y') : 'Not set' }}
                                    </div>
                                    @if($reservation->available_date)
                                    <div class="date-remaining">
                                        {{ \Carbon\Carbon::parse($reservation->available_date)->diffForHumans() }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- My Facilities Section -->
    <div class="modern-section-card" id="facilities-section">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">My Facilities</h2>
                    <p class="section-subtitle">Manage all your facility listings</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <a href="{{ route('facilities.create') }}" class="primary-action-btn">
                    <i class="fas fa-plus"></i>
                    <span>Add New Facility</span>
                </a>
            </div>
        </div>
        
        @if($facilities->count() > 0)
        <div class="facilities-grid-modern">
            @foreach($facilities as $facility)
            <div class="facility-card-modern">
                <div class="facility-card-header">
                    <div class="facility-status-indicator">
                        @if($facility->status === 'active')
                            <div class="status-dot status-dot-active"></div>
                            <span class="status-text">Active</span>
                        @else
                            <div class="status-dot status-dot-inactive"></div>
                            <span class="status-text">Inactive</span>
                        @endif
                    </div>
                    <div class="facility-actions-dropdown">
                        <button class="dropdown-toggle-btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu-facility">
                            <a href="{{ route('facilities.edit', $facility) }}" class="dropdown-item">
                                <i class="fas fa-edit"></i>
                                <span>Edit Facility</span>
                            </a>
                            @if(!$facility->reservations()->exists())
                            <form action="{{ route('facilities.destroy', $facility) }}" method="POST" class="dropdown-item-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item dropdown-item-danger" onclick="return confirm('Are you sure you want to delete this facility? This action cannot be undone.')">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete Facility</span>
                                </button>
                            </form>
                            @else
                            <div class="dropdown-item disabled">
                                <i class="fas fa-lock"></i>
                                <span>Delete (Has Reservations)</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="facility-card-body">
                    <h3 class="facility-name-modern">{{ $facility->name }}</h3>
                    <div class="facility-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $facility->location }}</span>
                    </div>
                    <div class="facility-details-grid">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-value">{{ $facility->capacity }}</div>
                                <div class="detail-label">Capacity</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-value">{{ $facility->available_hours }}</div>
                                <div class="detail-label">Hours</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="facility-card-footer">
                    <div class="reservation-count">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $facility->reservations->count() }} reservations</span>
                    </div>
                    <a href="{{ route('facilities.edit', $facility) }}" class="edit-facility-btn">
                        <i class="fas fa-edit"></i>
                        <span>Manage</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state-modern">
            <div class="empty-state-icon">
                <i class="fas fa-building"></i>
            </div>
            <h3 class="empty-state-title">No Facilities Yet</h3>
            <p class="empty-state-description">Start by creating your first facility to accept reservations</p>
            <a href="{{ route('facilities.create') }}" class="primary-action-btn empty-state-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Create Your First Facility</span>
            </a>
        </div>
        @endif
    </div>

    <!-- All Reservations Section -->
    <div class="modern-section-card" id="all-reservations">
        <div class="section-header-modern">
            <div class="section-title-container">
                <div class="section-title-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="section-title-content">
                    <h2 class="section-title-modern">All Reservations</h2>
                    <p class="section-subtitle">Complete history of reservation requests</p>
                </div>
            </div>
            <div class="section-actions-modern">
                <div class="filter-container">
                    <select class="status-filter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <span class="status-count-badge">
                    <i class="fas fa-list"></i>
                    {{ $allReservations->count() }} Total
                </span>
            </div>
        </div>
        
        @if($allReservations->count() > 0)
        <div class="modern-table-container">
            <table class="modern-admin-table">
                <thead>
                    <tr>
                        <th class="table-col-facility">
                            <i class="fas fa-building"></i>
                            <span>Facility</span>
                        </th>
                        <th class="table-col-guest">
                            <i class="fas fa-user"></i>
                            <span>Guest Name</span>
                        </th>
                        <th class="table-col-contact">
                            <i class="fas fa-phone"></i>
                            <span>Contact</span>
                        </th>
                        <th class="table-col-description">
                            <i class="fas fa-align-left"></i>
                            <span>Description</span>
                        </th>
                        <th class="table-col-status">
                            <i class="fas fa-info-circle"></i>
                            <span>Status</span>
                        </th>
                        <th class="table-col-date">
                            <i class="fas fa-calendar"></i>
                            <span>Submitted</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allReservations as $reservation)
                    <tr class="status-{{ $reservation->status }}">
                        <td class="table-col-facility">
                            <div class="facility-info">
                                <div class="facility-name">{{ $reservation->facility->name }}</div>
                            </div>
                        </td>
                        <td class="table-col-guest">
                            <div class="guest-info">
                                <div class="guest-name">{{ $reservation->guest_name }}</div>
                            </div>
                        </td>
                        <td class="table-col-contact">
                            <div class="contact-info">
                                <a href="tel:{{ $reservation->guest_contact }}" class="contact-link">
                                    <i class="fas fa-phone"></i>
                                    {{ $reservation->guest_contact }}
                                </a>
                            </div>
                        </td>
                        <td class="table-col-description">
                            <div class="description-content">
                                {{ Str::limit($reservation->description, 50) }}
                            </div>
                        </td>
                        <td class="table-col-status">
                            @if($reservation->status === 'pending')
                                <div class="status-badge-modern status-pending">
                                    <div class="status-dot"></div>
                                    <span>Pending</span>
                                </div>
                            @elseif($reservation->status === 'approved')
                                <div class="status-badge-modern status-approved">
                                    <div class="status-dot"></div>
                                    <span>Approved</span>
                                </div>
                            @elseif($reservation->status === 'rejected')
                                <div class="status-badge-modern status-rejected">
                                    <div class="status-dot"></div>
                                    <span>Rejected</span>
                                </div>
                            @else
                                <div class="status-badge-modern status-cancelled">
                                    <div class="status-dot"></div>
                                    <span>Cancelled</span>
                                </div>
                            @endif
                        </td>
                        <td class="table-col-date">
                            <div class="date-display-modern">
                                <div class="date-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="date-info">
                                    <div class="date-value">
                                        {{ $reservation->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="date-ago">
                                        {{ $reservation->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="table-footer">
            <div class="pagination-info">
                Showing {{ $allReservations->count() }} of {{ $allReservations->count() }} reservations
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn disabled">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="pagination-current">1</span>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        @else
        <div class="empty-state-modern empty-state-small">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="empty-state-title">No Reservations Yet</h3>
            <p class="empty-state-description">All reservation requests will appear here</p>
        </div>
        @endif
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
        --hcc-success-light: #a7f3d0;
        --hcc-warning: #f59e0b;
        --hcc-warning-light: #fde68a;
        --hcc-danger: #ef4444;
        --hcc-danger-light: #fecaca;
        
        --background-primary: #ffffff;
        --background-secondary: #f8fafc;
        --background-tertiary: #f1f5f9;
        
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        
        --border-light: #e2e8f0;
        --border-medium: #cbd5e1;
        
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
    }

    /* Keep all the CSS from the previous modern design... */
    /* [All the CSS from the previous modern design remains exactly the same] */
    
    /* Add the original modal styles back */
    .custom-modal .modal-header-custom {
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
        color: white;
        padding: 24px 32px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-custom h5 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-header-custom i {
        color: var(--hcc-gold);
    }

    .btn-close-custom {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-close-custom::before,
    .btn-close-custom::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 2px;
        background: white;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
    }

    .btn-close-custom::after {
        transform: translate(-50%, -50%) rotate(-45deg);
    }

    .btn-close-custom:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-body-custom {
        padding: 32px;
    }

    .info-box {
        background: rgba(26, 58, 82, 0.04);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid var(--hcc-gold);
    }

    .info-box p {
        margin: 8px 0;
        color: var(--hcc-blue);
        font-size: 0.95rem;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        display: block;
        margin-bottom: 8px;
        color: var(--hcc-blue);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-group-custom label i {
        color: var(--hcc-gold);
        margin-right: 6px;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--hcc-blue);
        box-shadow: 0 0 0 3px rgba(26, 58, 82, 0.1);
    }

    .form-group-custom small {
        display: block;
        margin-top: 6px;
        color: #64748b;
        font-size: 0.85rem;
    }

    .modal-footer-custom {
        padding: 24px 32px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        border-radius: 0 0 12px 12px;
    }

    .btn-modal-cancel, .btn-modal-confirm {
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-modal-cancel {
        background: #e2e8f0;
        color: var(--hcc-blue);
    }

    .btn-modal-cancel:hover {
        background: #cbd5e1;
        transform: translateY(-1px);
    }

    .btn-modal-confirm {
        background: linear-gradient(135deg, var(--hcc-success) 0%, #059669 100%);
        color: white;
    }

    .btn-modal-confirm:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    /* Fix for modal positioning */
    .modal {
        z-index: 1050;
    }

    .modal-backdrop {
        z-index: 1040;
    }

    /* Keep all other CSS styles from the previous modern design */

    .admin-dashboard-container {
        padding: 0;
        background: var(--background-secondary);
        min-height: 100vh;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-dark) 100%);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
    }

    .header-gradient-overlay {
        padding: 3rem 2rem;
        position: relative;
        z-index: 1;
    }

    .header-content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .header-left {
        flex: 1;
        min-width: 300px;
    }

    .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        color: var(--hcc-gold);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .header-title {
        color: white;
        margin-bottom: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .title-text {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.025em;
    }

    .title-subtext {
        font-size: 1rem;
        font-weight: 500;
        color: var(--hcc-gold-light);
        opacity: 0.9;
    }

    .header-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.125rem;
        max-width: 600px;
        line-height: 1.6;
        margin-top: 0.5rem;
    }

    .header-right {
        flex-shrink: 0;
    }

    .header-action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, var(--hcc-gold) 0%, var(--hcc-gold-dark) 100%);
        color: var(--hcc-blue-dark);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-lg);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-lg);
        border: none;
        cursor: pointer;
        min-width: 180px;
    }

    .header-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
        color: var(--hcc-blue-dark);
    }

    .btn-icon-wrapper {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        background: rgba(26, 58, 82, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .btn-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-label {
        font-size: 1rem;
        font-weight: 700;
    }

    .btn-sublabel {
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: 500;
    }

    /* Notifications */
    .notification-card {
        max-width: 1400px;
        margin: -1.5rem auto 2rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 10;
        box-shadow: var(--shadow-lg);
        animation: slideDown 0.3s ease-out;
        backdrop-filter: blur(10px);
    }

    .notification-success {
        background: linear-gradient(135deg, var(--hcc-success) 0%, #059669 100%);
        color: white;
        border-left: 4px solid rgba(255, 255, 255, 0.3);
    }

    .notification-error {
        background: linear-gradient(135deg, var(--hcc-danger) 0%, #dc2626 100%);
        color: white;
        border-left: 4px solid rgba(255, 255, 255, 0.3);
    }

    .notification-icon {
        font-size: 1.25rem;
    }

    .notification-content {
        flex: 1;
    }

    .notification-message {
        margin: 0;
        font-weight: 500;
    }

    .notification-close {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: var(--radius-sm);
        transition: all 0.2s;
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* Statistics Overview */
    .stats-overview-section {
        max-width: 1400px;
        margin: 0 auto 2rem;
        padding: 0 2rem;
    }

    .section-title-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0;
    }

    .section-title i {
        color: var(--hcc-gold);
    }

    .last-updated {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .stats-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .stat-card-modern {
        background: var(--background-primary);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--hcc-blue-light);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-icon-modern {
        width: 3rem;
        height: 3rem;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }

    .stat-warning .stat-icon-modern { background: linear-gradient(135deg, var(--hcc-warning) 0%, #ea580c 100%); }
    .stat-success .stat-icon-modern { background: linear-gradient(135deg, var(--hcc-success) 0%, #059669 100%); }
    .stat-primary .stat-icon-modern { background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%); }
    .stat-secondary .stat-icon-modern { background: linear-gradient(135deg, var(--hcc-gold) 0%, var(--hcc-gold-dark) 100%); }

    .urgency-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        background: var(--background-tertiary);
        color: var(--text-secondary);
    }

    .urgency-badge.active {
        background: var(--hcc-success-light);
        color: #065f46;
    }

    .stat-content {
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--hcc-blue);
        margin: 0 0 0.5rem 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0 0 0.75rem 0;
    }

    .stat-progress {
        margin-top: 0.5rem;
    }

    .progress-bar {
        height: 0.375rem;
        background: var(--background-tertiary);
        border-radius: 1rem;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 1rem;
        transition: width 0.6s ease;
    }

    .stat-warning .progress-fill { background: linear-gradient(90deg, var(--hcc-warning) 0%, #ea580c 100%); }
    .stat-success .progress-fill { background: linear-gradient(90deg, var(--hcc-success) 0%, #059669 100%); }
    .stat-primary .progress-fill { background: linear-gradient(90deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%); }
    .stat-secondary .progress-fill { background: linear-gradient(90deg, var(--hcc-gold) 0%, var(--hcc-gold-dark) 100%); }

    .stat-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--border-light);
    }

    .stat-action-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--hcc-blue);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: gap 0.2s ease;
    }

    .stat-action-link:hover {
        gap: 0.75rem;
        color: var(--hcc-blue-light);
    }

    /* Modern Section Cards */
    .modern-section-card {
        max-width: 1400px;
        margin: 0 auto 2rem;
        padding: 2rem;
        background: var(--background-primary);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
    }

    .urgent-section {
        border-left: 4px solid var(--hcc-warning);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: var(--shadow-md); }
        50% { box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1), var(--shadow-md); }
        100% { box-shadow: var(--shadow-md); }
    }

    .section-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title-container {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .section-title-icon {
        width: 3rem;
        height: 3rem;
        border-radius: var(--radius-lg);
        background: var(--background-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--hcc-gold);
    }

    .section-title-content {
        flex: 1;
    }

    .section-title-modern {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0 0 0.25rem 0;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .section-actions-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .status-count-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        background: var(--background-tertiary);
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .badge-warning {
        background: var(--hcc-warning-light);
        color: #92400e;
    }

    .badge-success {
        background: var(--hcc-success-light);
        color: #065f46;
    }

    .section-action-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-medium);
        background: var(--background-primary);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .section-action-btn:hover {
        background: var(--background-tertiary);
        border-color: var(--hcc-blue);
        color: var(--hcc-blue);
    }

    .primary-action-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .primary-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    /* Modern Tables */
    .modern-table-container {
        overflow-x: auto;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        margin-bottom: 1.5rem;
    }

    .modern-admin-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1000px;
    }

    .modern-admin-table thead {
        background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
    }

    .modern-admin-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: white;
        white-space: nowrap;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .modern-admin-table th i {
        margin-right: 0.5rem;
        color: var(--hcc-gold-light);
    }

    .modern-admin-table tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background-color 0.2s;
    }

    .modern-admin-table tbody tr:hover {
        background-color: var(--background-tertiary);
    }

    .modern-admin-table td {
        padding: 1.25rem 1.5rem;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    /* Table Columns */
    .table-col-facility {
        min-width: 200px;
    }

    .table-col-guest {
        min-width: 150px;
    }

    .table-col-contact {
        min-width: 140px;
    }

    .table-col-description {
        min-width: 200px;
    }

    .table-col-actions {
        min-width: 180px;
    }

    .table-col-status {
        min-width: 120px;
    }

    .table-col-date {
        min-width: 150px;
    }

    /* Table Cell Content */
    .facility-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .facility-name {
        font-weight: 600;
        color: var(--hcc-blue);
    }

    .facility-meta {
        display: flex;
        gap: 0.75rem;
    }

    .facility-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .facility-meta-item i {
        color: var(--hcc-gold);
    }

    .guest-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .guest-name {
        font-weight: 500;
        color: var(--text-primary);
    }

    .guest-date {
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }

    .contact-info {
        display: flex;
        align-items: center;
    }

    .contact-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--hcc-blue);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .contact-link:hover {
        color: var(--hcc-blue-light);
    }

    .description-content {
        line-height: 1.5;
        max-width: 300px;
    }

    /* Action Buttons */
    .action-buttons-modern {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }

    .action-approve {
        background: linear-gradient(135deg, var(--hcc-success) 0%, #059669 100%);
        color: white;
    }

    .action-approve:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .action-reject {
        background: linear-gradient(135deg, var(--hcc-danger) 0%, #dc2626 100%);
        color: white;
    }

    .action-reject:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .inline-form-modern {
        display: inline;
    }

    /* Date Display */
    .date-display-modern {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .date-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        background: var(--background-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hcc-gold);
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .date-value {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .date-remaining,
    .date-ago {
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }

    /* Status Badges */
    .status-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
    }

    .status-pending {
        background: var(--hcc-warning-light);
        color: #92400e;
    }

    .status-pending .status-dot {
        background: var(--hcc-warning);
    }

    .status-approved {
        background: var(--hcc-success-light);
        color: #065f46;
    }

    .status-approved .status-dot {
        background: var(--hcc-success);
    }

    .status-rejected {
        background: var(--hcc-danger-light);
        color: #991b1b;
    }

    .status-rejected .status-dot {
        background: var(--hcc-danger);
    }

    .status-cancelled {
        background: var(--background-tertiary);
        color: var(--text-secondary);
    }

    .status-cancelled .status-dot {
        background: var(--text-tertiary);
    }

    /* Facilities Grid */
    .facilities-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .facility-card-modern {
        background: var(--background-primary);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .facility-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--hcc-blue);
    }

    .facility-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .facility-status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
    }

    .status-dot-active {
        background: var(--hcc-success);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    .status-dot-inactive {
        background: var(--text-tertiary);
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.2);
    }

    .status-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .facility-actions-dropdown {
        position: relative;
    }

    .dropdown-toggle-btn {
        width: 2rem;
        height: 2rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-medium);
        background: var(--background-primary);
        color: var(--text-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .dropdown-toggle-btn:hover {
        background: var(--background-tertiary);
        border-color: var(--hcc-blue);
        color: var(--hcc-blue);
    }

    .dropdown-menu-facility {
        position: absolute;
        right: 0;
        top: 100%;
        background: var(--background-primary);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        padding: 0.5rem 0;
        min-width: 180px;
        box-shadow: var(--shadow-lg);
        display: none;
        z-index: 100;
    }

    .facility-actions-dropdown:hover .dropdown-menu-facility {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: var(--background-tertiary);
        color: var(--hcc-blue);
    }

    .dropdown-item-danger {
        color: var(--hcc-danger);
    }

    .dropdown-item-danger:hover {
        background: var(--hcc-danger-light);
        color: #991b1b;
    }

    .dropdown-item.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .dropdown-item-form {
        display: block;
        width: 100%;
    }

    .facility-card-body {
        padding: 1.5rem;
        flex: 1;
    }

    .facility-name-modern {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0 0 1rem 0;
    }

    .facility-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .facility-location i {
        color: var(--hcc-gold);
    }

    .facility-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .detail-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        background: var(--background-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--hcc-gold);
    }

    .detail-content {
        display: flex;
        flex-direction: column;
    }

    .detail-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--hcc-blue);
    }

    .detail-label {
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }

    .facility-card-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--border-light);
        background: var(--background-secondary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .reservation-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .edit-facility-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--background-primary);
        color: var(--hcc-blue);
        border: 1px solid var(--border-medium);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .edit-facility-btn:hover {
        background: var(--hcc-blue);
        color: white;
        border-color: var(--hcc-blue);
    }

    /* Empty States */
    .empty-state-modern {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, var(--background-secondary) 0%, var(--background-tertiary) 100%);
        border-radius: var(--radius-lg);
        border: 2px dashed var(--border-medium);
    }

    .empty-state-icon {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--hcc-gold-xlight) 0%, var(--hcc-gold-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--hcc-gold);
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--hcc-blue);
        margin: 0 0 0.5rem 0;
    }

    .empty-state-description {
        color: var(--text-secondary);
        margin: 0 0 1.5rem 0;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .empty-state-small {
        padding: 2rem;
    }

    .empty-state-small .empty-state-icon {
        width: 4rem;
        height: 4rem;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .empty-state-small .empty-state-title {
        font-size: 1.25rem;
    }

    /* Section Footer */
    .section-footer {
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-light);
        text-align: center;
    }

    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--hcc-blue);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: gap 0.2s;
    }

    .view-all-link:hover {
        gap: 0.75rem;
        color: var(--hcc-blue-light);
    }

    /* Table Footer */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-light);
    }

    .pagination-info {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-btn {
        width: 2rem;
        height: 2rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-medium);
        background: var(--background-primary);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination-btn:not(.disabled):hover {
        background: var(--background-tertiary);
        border-color: var(--hcc-blue);
        color: var(--hcc-blue);
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-current {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--hcc-blue);
        min-width: 2rem;
        text-align: center;
    }

    /* Filter */
    .filter-container {
        position: relative;
    }

    .status-filter {
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid var(--border-medium);
        border-radius: var(--radius-lg);
        background: var(--background-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        min-width: 140px;
    }

    .status-filter:focus {
        outline: none;
        border-color: var(--hcc-blue);
        box-shadow: 0 0 0 3px rgba(26, 58, 82, 0.1);
    }

    /* Animations */
    @keyframes slideDown {
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
        .header-content-wrapper,
        .stats-overview-section,
        .modern-section-card {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .title-text {
            font-size: 2rem;
        }
        
        .stats-grid-modern {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .header-gradient-overlay {
            padding: 2rem 1.5rem;
        }
        
        .header-content-wrapper {
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .header-right {
            width: 100%;
        }
        
        .header-action-btn {
            width: 100%;
            justify-content: center;
        }
        
        .title-text {
            font-size: 1.75rem;
        }
        
        .stats-grid-modern {
            grid-template-columns: 1fr;
        }
        
        .section-header-modern {
            flex-direction: column;
            align-items: stretch;
        }
        
        .section-actions-modern {
            justify-content: space-between;
        }
        
        .facilities-grid-modern {
            grid-template-columns: 1fr;
        }
        
        .modern-section-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .header-gradient-overlay {
            padding: 1.5rem 1rem;
        }
        
        .stats-overview-section,
        .modern-section-card {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .title-text {
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
        }
        
        .action-buttons-modern {
            flex-direction: column;
            width: 100%;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
        
        .table-footer {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
    }
</style>

<script>
    // Close notification functionality
    document.querySelectorAll('.notification-close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.notification-card').style.display = 'none';
        });
    });

    // Filter functionality for reservations table
    document.querySelector('.status-filter')?.addEventListener('change', function(e) {
        const status = e.target.value;
        const rows = document.querySelectorAll('#all-reservations tbody tr');
        
        rows.forEach(row => {
            const rowStatus = Array.from(row.classList).find(cls => cls.startsWith('status-'));
            const currentStatus = rowStatus ? rowStatus.replace('status-', '') : 'all';
            
            if (status === 'all' || currentStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Dropdown functionality
    document.querySelectorAll('.dropdown-toggle-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu-facility').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    });

    // Hover effect for stat cards
    document.querySelectorAll('.stat-card-modern').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const fill = this.querySelector('.progress-fill');
            const currentWidth = fill.style.width;
            fill.style.width = '100%';
            
            setTimeout(() => {
                if (fill.style.width === '100%') {
                    fill.style.width = currentWidth;
                }
            }, 300);
        });
    });
</script>
@endsection