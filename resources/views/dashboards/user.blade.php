@extends('layouts.app')
 
@section('content')
 
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
 
{{-- Force full-width, same as admin --}}
<style>
    body > .container,
    body > .container-fluid,
    body > main > .container,
    body > main > .container-fluid,
    .container:has(.user-dashboard),
    .container-fluid:has(.user-dashboard) {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
    }
</style>
 
<div class="user-dashboard">
 
    <!-- ── Hero Section ── -->
    <div class="dashboard-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="welcome-badge">
                <i class="fas fa-calendar-check"></i>
                <span>Dashboard</span>
            </div>
            <h1 class="welcome-title">
                Welcome back, <span class="user-name">{{ auth()->user()->name }}</span>
            </h1>
            <p class="welcome-subtitle">
                Manage your facility reservations and browse available spaces
            </p>
            <div class="quick-stats">
                <div class="stat-chip">
                    <i class="fas fa-building"></i>
                    <span>{{ $facilities->count() }} Facilities Available</span>
                </div>
                <div class="stat-chip">
                    <i class="fas fa-clock"></i>
                    <span>{{ $reservations->where('status','pending')->count() }} Pending Requests</span>
                </div>
                <div class="stat-chip" style="cursor:pointer;">
                    <i class="fas fa-map"></i>
                    <button type="button" onclick="showSchoolMapModal()" style="background:none;border:none;color:inherit;font-weight:600;cursor:pointer;padding:0;margin:0;">View School Map</button>
                </div>
            </div>
        </div>
    </div>
 
    @if(session('success'))
        <div class="notification-card notification-success">
            <div class="notification-icon"><i class="fas fa-check-circle"></i></div>
            <div class="notification-content">
                <h4>Success!</h4>
                <p>{{ session('success') }}</p>
            </div>
            <button class="notification-close"><i class="fas fa-times"></i></button>
        </div>
    @endif
 
    @if(session('error'))
        <div class="notification-card notification-error">
            <div class="notification-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="notification-content">
                <h4>Error</h4>
                <p>{{ session('error') }}</p>
            </div>
            <button class="notification-close"><i class="fas fa-times"></i></button>
        </div>
    @endif
 
    <!-- ══════════════════════════════════════════════
         AVAILABLE FACILITIES SECTION
    ══════════════════════════════════════════════ -->
    <div class="dashboard-section">
        <div class="section-header-modern">
            <div class="header-left">
                <div class="header-icon-wrapper"><i class="fas fa-building"></i></div>
                <div class="header-text">
                    <h2 class="section-title">Available Facilities</h2>
                    <p class="section-description">Browse and reserve facilities that match your needs</p>
                </div>
            </div>
            <div class="header-right">
                <span class="facility-count-badge" id="facilityCountBadge">
                    {{ $facilities->count() }} {{ Str::plural('Facility', $facilities->count()) }}
                </span>
            </div>
        </div>
 
        <!-- Facility Filter Bar -->
        <div class="filter-bar">
            <div class="filter-search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text"
                       class="filter-search-input"
                       id="facilitySearch"
                       placeholder="Search by name, location, or description…">
                <button class="filter-clear" id="facilityClear" title="Clear"><i class="fas fa-times"></i></button>
            </div>
            <select class="filter-select" id="facilityCapacityFilter">
                <option value="all">Any Capacity</option>
                <option value="small">Small (≤ 50)</option>
                <option value="medium">Medium (51–150)</option>
                <option value="large">Large (151+)</option>
            </select>
            <div class="filter-results-count" id="facilityResultsCount"></div>
            <button class="filter-reset-btn" id="facilityResetBtn" style="display:none;">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
 
        <div class="facility-grid-modern" id="facilityGrid">
            @forelse($facilities as $facility)
            <div class="facility-card-modern"
                 data-name="{{ strtolower($facility->name) }}"
                 data-location="{{ strtolower($facility->location) }}"
                 data-description="{{ strtolower($facility->description ?? '') }}"
                 data-capacity="{{ $facility->capacity }}">
                <div class="card-header-gradient" style="background:linear-gradient(135deg,var(--hcc-blue) 0%,var(--hcc-blue-light) 100%);"></div>
                <div class="card-content">
                    <div class="facility-icon-circle">
    @if($facility->thumbnail)
        {{-- Fixed: removed 'storage/' and added leading slash if missing --}}
        <img src="{{ asset(Str::start($facility->thumbnail, '/')) }}" 
             alt="{{ $facility->name }}" 
             style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
    @else
        <i class="fas fa-door-open"></i>
    @endif
</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div style="flex:1;min-width:0;">
                            <h3 class="facility-name">{{ $facility->name }}</h3>
                            <p class="facility-description">{{ Str::limit($facility->description, 100) }}</p>
                        </div>
                        @if(!empty($facility->images) && is_array($facility->images))
                            <button type="button" class="btn btn-sm btn-outline-secondary facility-gallery-btn ms-2"
                                    data-facility-name="{{ $facility->name }}"
                                    data-images='@json($facility->images)'>
                                <i class="fas fa-eye"></i>
                            </button>
                        @endif
                    </div>
 
                    <div class="facility-features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="feature-text">
                                <span class="feature-label">Location</span>
                                <span class="feature-value">{{ $facility->location }}</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-users"></i></div>
                            <div class="feature-text">
                                <span class="feature-label">Capacity</span>
                                <span class="feature-value">{{ $facility->capacity }} people</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-clock"></i></div>
                            <div class="feature-text">
                                <span class="feature-label">Availability</span>
                                <span class="feature-value">{{ $facility->available_hours }} hours/day</span>
                            </div>
                        </div>
                    </div>
 
                    <a href="{{ route('reservations.create', ['facility' => $facility->id]) }}" class="reserve-button">
                        <span>Reserve Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state-modern" style="grid-column:1/-1;">
                <div class="empty-state-icon"><i class="fas fa-door-closed"></i></div>
                <h3 class="empty-state-title">No Facilities Available</h3>
                <p class="empty-state-description">All facilities are currently reserved. Please check back later.</p>
                <button class="refresh-button" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i><span>Refresh</span>
                </button>
            </div>
            @endforelse
        </div>
 
        <!-- Facility no-results -->
        <div class="filter-no-results" id="facilityNoResults">
            <i class="fas fa-search"></i>
            <p>No facilities match your search. <a href="#" id="facilityResetLink" style="color:var(--hcc-blue);font-weight:600;">Clear filters</a></p>
        </div>
    </div>
 
    <!-- ══════════════════════════════════════════════
         MY RESERVATIONS SECTION
    ══════════════════════════════════════════════ -->
    <div class="dashboard-section">
        <div class="section-header-modern">
            <div class="header-left">
                <div class="header-icon-wrapper"><i class="fas fa-calendar-alt"></i></div>
                <div class="header-text">
                    <h2 class="section-title">My Reservations</h2>
                    <p class="section-description">Track the status of your reservation requests</p>
                </div>
            </div>
            <div class="header-right">
                <span class="reservation-count-badge" id="reservationCountBadge">
                    {{ $reservations->count() }} Total
                </span>
            </div>
        </div>
 
        @if($reservations->count() > 0)
 
        <!-- Reservation Filter Bar -->
        <div class="filter-bar">
            <div class="filter-search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text"
                       class="filter-search-input"
                       id="reservationSearch"
                       placeholder="Search by facility name or purpose…">
                <button class="filter-clear" id="reservationClear" title="Clear"><i class="fas fa-times"></i></button>
            </div>
            <select class="filter-select" id="reservationStatusFilter">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select class="filter-select" id="reservationSortFilter">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
            <div class="filter-results-count" id="reservationResultsCount"></div>
            <button class="filter-reset-btn" id="reservationResetBtn" style="display:none;">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
 
        <div class="reservations-timeline" id="reservationList">
            @foreach($reservations as $reservation)
            <div class="reservation-card"
                 data-status="{{ $reservation->status }}"
                 data-facility="{{ strtolower($reservation->facility->name) }}"
                 data-description="{{ strtolower($reservation->description ?? '') }}"
                 data-date="{{ $reservation->created_at->timestamp }}">
                <div class="reservation-status-indicator status-{{ $reservation->status }}-bar"></div>
 
                <div class="reservation-content">
                    <div class="reservation-header">
                        <div class="reservation-title">
                            <h4 class="facility-title">{{ $reservation->facility->name }}</h4>
                            <span class="reservation-id">#{{ $reservation->id }}</span>
                        </div>
                        <div class="reservation-status-badge">
                            @if($reservation->status === 'pending')
                                <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending Review</span>
                            @elseif($reservation->status === 'approved')
                                <span class="status-badge status-approved"><i class="fas fa-check-circle"></i> Approved</span>
                            @elseif($reservation->status === 'rejected')
                                <span class="status-badge status-rejected"><i class="fas fa-times-circle"></i> Rejected</span>
                            @else
                                <span class="status-badge status-cancelled"><i class="fas fa-ban"></i> Cancelled</span>
                            @endif
                        </div>
                    </div>
 
                    <div class="reservation-details">
                        <div class="detail-group">
                            <div class="detail-row">
                                <div class="detail-label"><i class="fas fa-align-left"></i><span>Purpose:</span></div>
                                <div class="detail-value">{{ Str::limit($reservation->description, 80) }}</div>
                            </div>
 
                            @if($reservation->requested_date)
                            <div class="detail-row">
                                <div class="detail-label"><i class="fas fa-calendar-alt"></i><span>Requested Date:</span></div>
                                <div class="detail-value">
                                    <strong>{{ $reservation->requested_date->format('F d, Y') }}</strong>
                                    <span class="detail-meta">({{ $reservation->requested_date->diffForHumans() }})</span>
                                </div>
                            </div>
                            @endif
 
                            <div class="detail-row">
                                <div class="detail-label"><i class="fas fa-calendar"></i><span>Submitted:</span></div>
                                <div class="detail-value">
                                    {{ $reservation->created_at->format('F d, Y') }}
                                    <span class="detail-meta">{{ $reservation->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
 
                            @if($reservation->status === 'approved' && $reservation->available_date)
                            <div class="detail-row highlight">
                                <div class="detail-label"><i class="fas fa-calendar-check"></i><span>Available From:</span></div>
                                <div class="detail-value">
                                    <strong>{{ $reservation->available_date->format('F d, Y') }}</strong>
                                    <span class="detail-meta">({{ $reservation->available_date->diffForHumans() }})</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
 
                    <div class="reservation-footer">
                        <a href="{{ route('reservations.show', $reservation) }}" class="btn-view-details">
                            <i class="fas fa-info-circle"></i>
                            <span>View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
 
                        @if($reservation->status === 'pending')
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="cancel-button" onclick="return confirm('Cancel this reservation?')">
                                <i class="fas fa-times"></i><span>Cancel Request</span>
                            </button>
                        </form>
                        @elseif($reservation->status === 'approved')
                        <div class="approved-message">
                            <i class="fas fa-check-circle"></i><span>Your reservation has been approved</span>
                        </div>
                        @elseif($reservation->status === 'rejected')
                        <div class="rejected-message">
                            <i class="fas fa-info-circle"></i><span>This reservation request was declined</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
 
        <!-- Reservation no-results -->
        <div class="filter-no-results" id="reservationNoResults">
            <i class="fas fa-calendar-times"></i>
            <p>No reservations match your filters. <a href="#" id="reservationResetLink" style="color:var(--hcc-blue);font-weight:600;">Clear filters</a></p>
        </div>
 
        @if($reservations->count() > 5)
        <div class="view-more-container">
            <button class="view-more-button">
                <span>View All Reservations</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        @endif
 
        @else
        <div class="empty-state-modern compact">
            <div class="empty-state-icon small"><i class="fas fa-calendar-times"></i></div>
            <h3 class="empty-state-title">No Reservations Yet</h3>
            <p class="empty-state-description">You haven't made any facility reservations. Browse available facilities above to get started.</p>
            <a href="#" onclick="document.querySelector('.dashboard-section').scrollIntoView({behavior:'smooth'}); return false;" class="primary-button">
                <i class="fas fa-search"></i><span>Browse Facilities</span>
            </a>
        </div>
        @endif
    </div>
 
</div>{{-- end .user-dashboard --}}
 
<!-- Facility Images Modal -->
<div id="facilityGalleryModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <button type="button" class="modal-close" id="facilityGalleryClose"><i class="fas fa-times"></i></button>
        <h3 id="facilityGalleryTitle">Facility Photos</h3>
        <div class="gallery-grid" id="facilityGalleryGrid"></div>
    </div>
</div>
 
<!-- School Map Modal -->
<div id="schoolMapModal" style="display:none;position:fixed;inset:0;background:rgba(2,6,23,0.6);z-index:1200;align-items:center;justify-content:center;padding:20px;">
    <div style="width:100%;max-width:920px;max-height:80vh;background:linear-gradient(180deg,#ffffff,#f8fafc);border-radius:12px;box-shadow:0 10px 40px rgba(2,6,23,0.6);position:relative;overflow:hidden;display:flex;flex-direction:column;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:linear-gradient(90deg,#1a3a52,#2d5a7b);color:#fff;">
            <div style="display:flex;align-items:center;gap:10px;">
                <i class="fas fa-map" style="font-size:18px;"></i>
                <strong>School Map</strong>
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <button onclick="zoomOut()"  style="background:rgba(255,255,255,0.06);border:none;color:#fff;padding:6px 8px;border-radius:6px;cursor:pointer;font-weight:700;">−</button>
                <button onclick="resetZoom()" style="background:rgba(255,255,255,0.06);border:none;color:#fff;padding:6px 8px;border-radius:6px;cursor:pointer;font-weight:700;">100%</button>
                <button onclick="zoomIn()"   style="background:rgba(255,255,255,0.06);border:none;color:#fff;padding:6px 8px;border-radius:6px;cursor:pointer;font-weight:700;">+</button>
                <button onclick="hideSchoolMapModal()" style="background:rgba(255,255,255,0.12);border:none;color:#fff;padding:6px 10px;border-radius:6px;cursor:pointer;">✕</button>
            </div>
        </div>
        <div style="padding:12px;display:flex;align-items:center;justify-content:center;flex:1;overflow:auto;">
            <img id="schoolMapImage" src="{{ asset('images/schoolmap.png') }}" alt="School Map"
                 style="width:100%;height:auto;max-height:calc(80vh - 88px);object-fit:contain;border-radius:6px;border:1px solid rgba(15,23,42,0.05);" />
        </div>
        <div style="padding:10px 16px;font-size:13px;color:#475569;text-align:center;">
            <small>Tip: use browser zoom or download for a higher-resolution view.</small>
        </div>
    </div>
</div>

<div id="notification-toast-wrapper" style="position: fixed; top: 25px; right: 25px; z-index: 9999;">
    @if(session('toast_success'))
        <div class="modern-toast toast-success">
            <div class="toast-icon"><i class="fas fa-check-circle"></i></div>
            <div class="toast-body">{{ session('toast_success') }}</div>
            <button onclick="this.parentElement.remove()" class="toast-close">&times;</button>
        </div>
    @endif

    @if(session('toast_error'))
        <div class="modern-toast toast-error">
            <div class="toast-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="toast-body">{{ session('toast_error') }}</div>
            <button onclick="this.parentElement.remove()" class="toast-close">&times;</button>
        </div>
    @endif
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
 
<script>
// ============================================================
// FACILITY FILTER
// ============================================================
(function () {
    const searchInput   = document.getElementById('facilitySearch');
    const clearBtn      = document.getElementById('facilityClear');
    const capacityFilter= document.getElementById('facilityCapacityFilter');
    const resetBtn      = document.getElementById('facilityResetBtn');
    const countEl       = document.getElementById('facilityResultsCount');
    const badgeEl       = document.getElementById('facilityCountBadge');
    const grid          = document.getElementById('facilityGrid');
    const noResults     = document.getElementById('facilityNoResults');
    const resetLink     = document.getElementById('facilityResetLink');
 
    if (!searchInput || !grid) return;
 
    const allCards = Array.from(grid.querySelectorAll('.facility-card-modern'));
 
    function applyFilters() {
        const term     = searchInput.value.trim().toLowerCase();
        const capacity = capacityFilter ? capacityFilter.value : 'all';
        const isActive = term || capacity !== 'all';
 
        let visible = 0;
        allCards.forEach(card => {
            const name = card.dataset.name || '';
            const loc  = card.dataset.location || '';
            const desc = card.dataset.description || '';
            const cap  = parseInt(card.dataset.capacity) || 0;
 
            const matchesSearch   = !term || name.includes(term) || loc.includes(term) || desc.includes(term);
            const matchesCapacity = capacity === 'all'
                || (capacity === 'small'  && cap <= 50)
                || (capacity === 'medium' && cap > 50  && cap <= 150)
                || (capacity === 'large'  && cap > 150);
 
            const show = matchesSearch && matchesCapacity;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
 
        if (noResults)  noResults.style.display = visible === 0 ? 'block' : 'none';
        if (countEl)    countEl.innerHTML = isActive ? `<span>${visible}</span> result${visible !== 1 ? 's' : ''} found` : `<span>${allCards.length}</span> total`;
        if (badgeEl)    badgeEl.textContent = `${visible} ${visible !== 1 ? 'Facilities' : 'Facility'}`;
        if (clearBtn)   clearBtn.style.display = term ? 'block' : 'none';
        if (resetBtn)   resetBtn.style.display = isActive ? 'inline-flex' : 'none';
    }
 
    function reset() {
        searchInput.value = '';
        if (capacityFilter) capacityFilter.value = 'all';
        applyFilters();
        searchInput.focus();
    }
 
    searchInput.addEventListener('input', applyFilters);
    if (capacityFilter) capacityFilter.addEventListener('change', applyFilters);
    if (clearBtn)  clearBtn.addEventListener('click',  () => { searchInput.value = ''; applyFilters(); searchInput.focus(); });
    if (resetBtn)  resetBtn.addEventListener('click',  reset);
    if (resetLink) resetLink.addEventListener('click', (e) => { e.preventDefault(); reset(); });
 
    applyFilters(); // init count
})();
 
// ============================================================
// RESERVATION FILTER
// ============================================================
(function () {
    const searchInput  = document.getElementById('reservationSearch');
    const clearBtn     = document.getElementById('reservationClear');
    const statusFilter = document.getElementById('reservationStatusFilter');
    const sortFilter   = document.getElementById('reservationSortFilter');
    const resetBtn     = document.getElementById('reservationResetBtn');
    const countEl      = document.getElementById('reservationResultsCount');
    const badgeEl      = document.getElementById('reservationCountBadge');
    const list         = document.getElementById('reservationList');
    const noResults    = document.getElementById('reservationNoResults');
    const resetLink    = document.getElementById('reservationResetLink');
 
    if (!searchInput || !list) return;
 
    const allCards = Array.from(list.querySelectorAll('.reservation-card'));
 
    function applyFilters() {
        const term   = searchInput.value.trim().toLowerCase();
        const status = statusFilter ? statusFilter.value : 'all';
        const sort   = sortFilter ? sortFilter.value : 'newest';
        const isActive = term || status !== 'all';
 
        // Filter
        let visible = allCards.filter(card => {
            const fac  = card.dataset.facility    || '';
            const desc = card.dataset.description || '';
            const st   = card.dataset.status      || '';
 
            const matchesSearch = !term || fac.includes(term) || desc.includes(term);
            const matchesStatus = status === 'all' || st === status;
            return matchesSearch && matchesStatus;
        });
 
        // Sort
        visible.sort((a, b) => {
            const da = parseInt(a.dataset.date) || 0;
            const db = parseInt(b.dataset.date) || 0;
            return sort === 'newest' ? db - da : da - db;
        });
 
        // Apply visibility
        allCards.forEach(c => c.style.display = 'none');
        visible.forEach(c => c.style.display  = '');
 
        // Re-order in DOM by appending in sorted order
        visible.forEach(c => list.appendChild(c));
 
        const count = visible.length;
        if (noResults) noResults.style.display = count === 0 ? 'block' : 'none';
        if (countEl)   countEl.innerHTML = isActive ? `<span>${count}</span> result${count !== 1 ? 's' : ''} found` : `<span>${allCards.length}</span> total`;
        if (badgeEl)   badgeEl.textContent = `${count} Total`;
        if (clearBtn)  clearBtn.style.display = term ? 'block' : 'none';
        if (resetBtn)  resetBtn.style.display = isActive ? 'inline-flex' : 'none';
    }
 
    function reset() {
        searchInput.value = '';
        if (statusFilter) statusFilter.value = 'all';
        if (sortFilter)   sortFilter.value   = 'newest';
        applyFilters();
        searchInput.focus();
    }
 
    searchInput.addEventListener('input', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    if (sortFilter)   sortFilter.addEventListener('change', applyFilters);
    if (clearBtn)   clearBtn.addEventListener('click',   () => { searchInput.value = ''; applyFilters(); searchInput.focus(); });
    if (resetBtn)   resetBtn.addEventListener('click',   reset);
    if (resetLink)  resetLink.addEventListener('click',  (e) => { e.preventDefault(); reset(); });
 
    applyFilters(); // init count
})();
 
// ============================================================
// GALLERY MODAL
// ============================================================
// ============================================================
// GALLERY MODAL (Fixed for public/images path)
// ============================================================
const galleryModal = document.getElementById('facilityGalleryModal');
const galleryTitle = document.getElementById('facilityGalleryTitle');
const galleryGrid  = document.getElementById('facilityGalleryGrid');
const galleryClose = document.getElementById('facilityGalleryClose');

// ============================================================
// GALLERY MODAL (Fixed pathing for public/images)
// ============================================================
function openGalleryModal(name, images) {
    galleryTitle.textContent = name + ' Photos';
    galleryGrid.innerHTML = '';
    
    if (!images || images.length === 0) {
        galleryGrid.innerHTML = '<div class="gallery-empty">No images available.</div>';
    } else {
        images.forEach(img => {
            const el = document.createElement('img');
            
            // Clean the path: 
            // 1. Remove 'storage/' if it was accidentally prepended in the DB
            // 2. Ensure it starts with a single '/'
            let path = img.replace('storage/', '');
            let cleanPath = path.startsWith('/') ? path : '/' + path;
            
            // This is the most direct way to hit the public folder
            el.src = cleanPath; 
            
            el.alt = name; 
            el.className = 'gallery-image';
            
            // Error handling: if image fails to load, show a placeholder
            el.onerror = function() {
                this.src = '/images/placeholder.jpg'; // Path to a backup image
                console.error("Failed to load: " + cleanPath);
            };

            galleryGrid.appendChild(el);
        });
    }
    galleryModal.style.display = 'flex';
}

document.querySelectorAll('.facility-gallery-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Parse the JSON array from the data attribute
        const images = JSON.parse(btn.getAttribute('data-images') || '[]');
        openGalleryModal(btn.getAttribute('data-facility-name'), images);
    });
});

// Close logic remains the same
if(galleryClose) {
    galleryClose.addEventListener('click', () => { galleryModal.style.display = 'none'; });
}
galleryModal.addEventListener('click', (e) => { if (e.target === galleryModal) galleryModal.style.display = 'none'; });
 
// ============================================================
// SCHOOL MAP MODAL
// ============================================================
function showSchoolMapModal() {
    const m = document.getElementById('schoolMapModal');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function hideSchoolMapModal() {
    const m = document.getElementById('schoolMapModal');
    if (m) { m.style.display = 'none'; document.body.style.overflow = 'auto'; resetZoom(); }
}
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') hideSchoolMapModal(); });
 
// Zoom & pan
(function(){
    const img = document.getElementById('schoolMapImage');
    if (!img) return;
    let scale = 1, minScale = 1, maxScale = 3, startScale = 1;
    let translate = {x:0,y:0};
    let isPanning = false, startX = 0, startY = 0, pinchStartDist = 0;
 
    function applyTransform() { img.style.transform = `translate(${translate.x}px,${translate.y}px) scale(${scale})`; img.style.cursor = scale > 1 ? 'grab' : 'auto'; }
    window.zoomIn    = () => { scale = Math.min(maxScale,+(scale+0.25).toFixed(2)); applyTransform(); };
    window.zoomOut   = () => { scale = Math.max(minScale,+(scale-0.25).toFixed(2)); if(scale===1) translate={x:0,y:0}; applyTransform(); };
    window.resetZoom = () => { scale=1; translate={x:0,y:0}; applyTransform(); };
 
    img.addEventListener('wheel', (e) => { e.preventDefault(); const d=-e.deltaY||e.wheelDelta; scale=Math.min(maxScale,Math.max(minScale,+(scale+(d>0?.15:-.15)).toFixed(2))); applyTransform(); }, {passive:false});
    img.addEventListener('mousedown', (e) => { if(scale<=1)return; isPanning=true; startX=e.clientX-translate.x; startY=e.clientY-translate.y; img.style.cursor='grabbing'; e.preventDefault(); });
    document.addEventListener('mousemove', (e) => { if(!isPanning)return; translate.x=e.clientX-startX; translate.y=e.clientY-startY; applyTransform(); });
    document.addEventListener('mouseup', () => { if(isPanning){ isPanning=false; img.style.cursor='grab'; } });
    img.addEventListener('touchstart', (e) => { if(e.touches.length===1){ if(scale<=1)return; const t=e.touches[0]; isPanning=true; startX=t.clientX-translate.x; startY=t.clientY-translate.y; } else if(e.touches.length===2){ isPanning=false; pinchStartDist=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY); startScale=scale; } }, {passive:true});
    img.addEventListener('touchmove', (e) => { if(e.touches.length===1&&isPanning){ const t=e.touches[0]; translate.x=t.clientX-startX; translate.y=t.clientY-startY; applyTransform(); } else if(e.touches.length===2){ const d=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY); scale=Math.min(maxScale,Math.max(minScale,+(startScale*(d/(pinchStartDist||d))).toFixed(2))); applyTransform(); } }, {passive:true});
    img.addEventListener('touchend', (e) => { if(e.touches.length===0){ isPanning=false; pinchStartDist=0; } });
    img.addEventListener('dblclick', () => resetZoom());
    img.style.transition = 'transform 0.08s linear';
    img.style.transformOrigin = 'center center';
})();
 
// ============================================================
// NOTIFICATION CLOSE
// ============================================================
document.querySelectorAll('.notification-close').forEach(btn => {
    btn.addEventListener('click', function() {
        const n = this.closest('.notification-card');
        n.style.animation = 'slideOut 0.3s ease-out forwards';
        setTimeout(() => n.remove(), 300);
    });
});
 
// Smooth scroll for browse link
document.querySelectorAll('a[href="#available-facilities"]').forEach(l => {
    l.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.dashboard-section')?.scrollIntoView({behavior:'smooth'});
    });
});
</script>
 
@endsection