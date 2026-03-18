@extends('layouts.app')

@section('content')
<div class="hcc-dashboard-wrapper">
    {{-- Hero Header --}}
    <div class="hcc-hero-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-main-info">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb hcc-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reservation Details</li>
                        </ol>
                    </nav>
                    <h1 class="hcc-title">
                        <i class="fas fa-ribbon me-2 gold-text"></i>Reservation <span class="fw-light">#{{ $reservation->id }}</span>
                    </h1>
                    <p class="hcc-subtitle">Management portal for facility booking and guest coordination.</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-hcc-outline-gold">
                        <i class="fas fa-chevron-left me-2"></i>Return to Portal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-n5">
        <div class="row">
            {{-- Left Column: Booking Details --}}
            <div class="col-lg-8">
                {{-- Status Banner Card --}}
                <div class="card hcc-card status-banner-card mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div class="d-flex align-items-center">
                            <div class="hcc-icon-box bg-hcc-blue-soft me-3">
                                <i class="fas fa-university hcc-blue-text"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $reservation->facility->name ?? 'Facility Reference' }}</h4>
                                <span class="text-muted small uppercase-tracking">Primary Booking Venue</span>
                            </div>
                        </div>
                        <div class="status-badge-wrapper">
                            @php
                                $statusClasses = ['pending' => 'hcc-bg-gold', 'approved' => 'hcc-bg-blue', 'rejected' => 'hcc-bg-danger'];
                                $statusLabels = ['pending' => 'Pending Review', 'approved' => 'Confirmed', 'rejected' => 'Declined'];
                                $currentClass = $statusClasses[$reservation->status] ?? 'bg-secondary';
                                $currentLabel = $statusLabels[$reservation->status] ?? ucfirst($reservation->status);
                            @endphp
                            <span class="hcc-badge-lg {{ $currentClass }}">
                                {{ $currentLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Booking Particulars --}}
                <div class="card hcc-card mb-4">
                    <div class="card-header hcc-card-header">
                        <h5 class="mb-0" style="color: white"><i class="fas fa-info-circle me-2"></i>Booking Particulars</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6 detail-item">
                                <label>Full Name of Guest</label>
                                <p>{{ $reservation->guest_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 detail-item">
                                <label>Contact Information</label>
                                <p>{{ $reservation->guest_contact ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 detail-item">
                                <label>Estimated Participants</label>
                                <p class="fw-bold"><i class="fas fa-users me-2 text-muted"></i>{{ $reservation->estimated_participants ?? '0' }} Persons</p>
                            </div>
                           <div class="col-md-6 detail-item">
    <label>Reservation Date</label>
    <p class="hcc-blue-text fw-bold">
        <i class="far fa-calendar-alt me-2"></i>
        {{-- Change requested_date to available_date --}}
        {{ $reservation->available_date ? \Carbon\Carbon::parse($reservation->available_date)->format('F j, Y') : 'Pending Admin Approval' }}
    </p>
</div>
                            <div class="col-md-12 detail-item">
                                <label>Submission Timestamp</label>
                                <p class="small text-muted"><i class="fas fa-clock me-2"></i>{{ $reservation->created_at ? $reservation->created_at->format('M d, Y | g:i A') : 'N/A' }}</p>
                            </div>
                            
                            @if($reservation->description)
                            <div class="col-12 detail-item mt-2">
                                <label>Purpose / Description</label>
                                <div class="hcc-well">
                                    <i class="fas fa-quote-left me-2 opacity-25"></i>{{ $reservation->description }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Venue Specs Sidebar --}}
            <div class="col-lg-4">
                <div class="card hcc-card facility-sidebar sticky-top" style="top: 20px; z-index: 10;">
                    <div class="hcc-card-header-gold">
                        <h5 class="mb-0 text-dark"><i class="fas fa-map-marked-alt me-2"></i>Venue Specs</h5>
                    </div>
                    @if($reservation->facility)
                    <div class="card-body p-4">
                        <ul class="list-unstyled hcc-list mb-4">
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Location</span>
                                <strong>{{ $reservation->facility->location }}</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Capacity</span>
                                <strong>{{ $reservation->facility->capacity }} Persons</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Hours</span>
                                <strong>{{ $reservation->facility->available_hours }} Hours/Day</strong>
                            </li>
                        </ul>
                        <div class="facility-status-box text-center">
                            <span class="small text-muted d-block mb-2">Current Facility Status</span>
                            <span class="badge {{ $reservation->facility->status === 'active' ? 'bg-success' : 'bg-dark' }} w-100 py-2">
                                {{ strtoupper($reservation->facility->status) }}
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                        <p class="text-muted">Facility data unavailable.</p>
                    </div>
                    @endif
                </div>

                <div class="card hcc-card mt-4 border-hcc-blue">
                    <div class="card-body p-3">
                        <button class="btn btn-hcc-blue w-100 mb-2" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Record
                        </button>
                        <a href="mailto:{{ $reservation->guest_contact ?? '' }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-envelope me-2"></i>Contact Guest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* HCC COLOR PALETTE */
:root {
    --hcc-blue: #102136;
    --hcc-blue-soft: #f1f5f9;
    --hcc-gold: #fcc419;
    --hcc-mint-bg: #d1f7ec;
    --hcc-mint-text: #0f816d;
    --hcc-text: #1e293b;
    --hcc-muted: #64748b;
    --hcc-border: #e2e8f0;
    --white: #ffffff;
}

.hcc-dashboard-wrapper { background-color: #f8fafc; min-height: 100vh; font-family: 'Poppins', sans-serif; padding-bottom: 50px; }
.hcc-hero-header { background: var(--hcc-blue); padding: 60px 0 100px 0; color: var(--white); border-bottom: 4px solid var(--hcc-gold); }
.hcc-title { font-weight: 800; font-size: 2.2rem; }
.gold-text { color: var(--hcc-gold); }
.hcc-breadcrumb .breadcrumb-item, .hcc-breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.85rem; }
.hcc-breadcrumb .breadcrumb-item.active { color: var(--white); }

.hcc-card { border: 1px solid var(--hcc-border); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); background: var(--white); overflow: hidden; }
.status-banner-card { border-left: 6px solid #22c55e !important; }
.hcc-card-header { padding: 1.25rem 1.5rem; color: var(--hcc-blue); font-weight: 700; border-bottom: 1px solid var(--hcc-border); }
.hcc-card-header-gold { background: var(--hcc-gold); padding: 1.25rem 1.5rem; }

.detail-item label { display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--hcc-muted); margin-bottom: 4px; }
.detail-item p { font-size: 1.05rem; color: var(--hcc-text); margin-bottom: 0; }
.hcc-well { background: #fffbeb; padding: 1.25rem; border-radius: 8px; border: 1px solid #fef3c7; color: #92400e; font-style: italic; }

.hcc-badge-lg { padding: 8px 18px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; }
.hcc-bg-blue { background-color: var(--hcc-mint-bg) !important; color: var(--hcc-mint-text) !important; }
.hcc-bg-gold { background-color: #fef3c7; color: #92400e; }
.hcc-bg-danger { background-color: #fee2e2; color: #b91c1c; }

.btn-hcc-outline-gold { border: 2px solid var(--hcc-gold); color: var(--hcc-gold); font-weight: 600; transition: 0.3s; }
.btn-hcc-outline-gold:hover { background: var(--hcc-gold); color: var(--hcc-blue); }
.btn-hcc-blue { background: var(--hcc-blue); color: white; }

.hcc-list li { padding: 12px 0; border-bottom: 1px solid var(--hcc-border); }
.hcc-icon-box { background-color: var(--hcc-blue-soft); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
.hcc-blue-text { color: var(--hcc-blue); }

@media print {
    .hcc-hero-header, .btn, .breadcrumb, .facility-sidebar { display: none !important; }
    .mt-n5 { margin-top: 0 !important; }
}
</style>
@endsection