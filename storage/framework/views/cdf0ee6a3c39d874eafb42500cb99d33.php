

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2><i class="fas fa-map-location-dot"></i> Facility Locations Map</h2>
            <p class="text-muted">Click on markers to view facility details and reserve a space</p>
        </div>
        <a href="<?php echo e(route('welcome')); ?>" class="btn btn-secondary">Back</a>
    </div>

    <div id="map" style="height: 700px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); position: relative;"></div>
    
    <!-- Map Legend -->
    <div style="position: absolute; bottom: 20px; right: 20px; background: white; padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); font-size: 13px; max-width: 220px; z-index: 1000;">
        <h6 style="margin: 0 0 12px 0; color: #1a3a52; font-weight: 700;"><i class="fas fa-legend"></i> Map Legend</h6>
        <div style="margin-bottom: 10px;">
            <span style="display: inline-block; width: 20px; height: 28px; background: url('https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png') no-repeat center; background-size: contain;"></span>
            <span style="margin-left: 8px; color: #333;">Facilities</span>
        </div>
        <div style="margin-bottom: 10px;">
            <span style="display: inline-block; width: 20px; height: 28px; background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cmVjdCB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIGZpbGw9IiMxYTNhNTIiIHJ4PSI0Ii8+PHBhdGggZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEybDEwIDEwIDEwLTEwYzAtNS41Mi00LjQ4LTEwLTEwLTEweiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==') no-repeat center; background-size: contain;"></span>
            <span style="margin-left: 8px; color: #333;">HCC Campus</span>
        </div>
        <div>
            <span style="display: inline-block; width: 20px; height: 20px; background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0Ij48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSI4IiBmaWxsPSIjMjJjNTVlIi8+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iNSIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==') no-repeat center; background-size: contain;"></span>
            <span style="margin-left: 8px; color: #333;">Your Location</span>
        </div>
    </div>

    <div class="mt-4">
        <h4>Facilities on Map</h4>
        <?php if($facilities->isEmpty()): ?>
            <div class="alert alert-info">No facilities with location coordinates found.</div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($facility->name); ?></h5>
                            <p class="card-text"><?php echo e(Str::limit($facility->description, 100)); ?></p>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt"></i> Lat: <?php echo e($facility->latitude); ?>, Lng: <?php echo e($facility->longitude); ?>

                            </p>
                            <a href="<?php echo e(route('facilities.show', $facility->id)); ?>" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

<!-- Leaflet JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // Initialize map centered on Holy Cross College (Santa Ana, Pampanga)
    const schoolLat = 15.0934532;
    const schoolLng = 120.7693744;
    const map = L.map('map').setView([schoolLat, schoolLng], 17);

    // Standard OpenStreetMap with detailed buildings and labels
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        minZoom: 1,
        attribution: '© OpenStreetMap contributors',
        className: 'leaflet-tiles'
    }).addTo(map);

    // Add facility markers
    const facilities = <?php echo json_encode($facilities, 15, 512) ?>;
    let userMarker = null;
    let bounds = L.latLngBounds([[schoolLat, schoolLng], [schoolLat, schoolLng]]);

    // Custom facility icon (larger and more visible)
    const facilityIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [32, 41],
        iconAnchor: [16, 41],
        popupAnchor: [0, -41],
        shadowSize: [41, 41]
    });

    // HCC Campus marker with gold color - using standard Leaflet marker
    const campusIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [40, 56],
        iconAnchor: [20, 56],
        popupAnchor: [0, -56],
        shadowSize: [41, 41]
    });

    // Add HCC Campus marker with detailed popup
    const campusMarker = L.marker([schoolLat, schoolLng], {icon: campusIcon})
        .addTo(map)
        .bindPopup(`
            <div style="min-width: 240px; text-align: center; font-family: 'Poppins', sans-serif;">
                <div style="background: linear-gradient(135deg, #1a3a52 0%, #2d5a7b 100%); color: white; padding: 12px; border-radius: 4px 4px 0 0; margin: -4px -4px 12px -4px;">
                    <h6 style="margin: 0; font-size: 16px; font-weight: 700;"><i class="fas fa-landmark"></i> Holy Cross College</h6>
                    <p style="margin: 4px 0 0 0; font-size: 11px; color: #ffd700;">Main Campus</p>
                </div>
                <p style="margin: 0 0 8px 0; font-size: 12px; color: #555; font-style: italic;">Baliwag-Candaba-Santa Ana Road<br/>Villa Luisa Subdivision, Santa Ana, Pampanga</p>
                <div style="border-left: 3px solid #d4af37; padding-left: 10px; text-align: left; margin: 8px 0;">
                    <p style="margin: 4px 0; font-size: 12px;"><strong>📍 Headquarters</strong></p>
                    <p style="margin: 4px 0; font-size: 11px; color: #666;">All facilities accessible from here</p>
                </div>
            </div>
        `, {maxWidth: 300});

    // Add a circle around campus to show the main hub
    L.circle([schoolLat, schoolLng], {
        color: '#d4af37',
        fill: true,
        fillColor: '#d4af37',
        fillOpacity: 0.1,
        weight: 2,
        radius: 300
    }).addTo(map);

    // Distance calculation function
    function haversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth's radius in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return (R * c).toFixed(2);
    }

    facilities.forEach(function(facility) {
        bounds.extend([facility.latitude, facility.longitude]);
        const distance = haversineDistance(schoolLat, schoolLng, facility.latitude, facility.longitude);
        
        const marker = L.marker([facility.latitude, facility.longitude], {icon: facilityIcon}).addTo(map);
        marker.bindPopup(`
            <div style="min-width: 280px; font-family: 'Poppins', sans-serif;">
                <div style="background: linear-gradient(135deg, #1a3a52 0%, #2d5a7b 100%); color: white; padding: 12px; border-radius: 4px 4px 0 0; margin: -4px -4px 12px -4px;">
                    <h6 style="margin: 0; font-size: 15px; font-weight: 700;"><i class="fas fa-door-open"></i> ${facility.name}</h6>
                </div>
                <p style="margin: 0 0 10px 0; font-size: 12px; color: #555; font-style: italic;">${facility.description.substring(0, 100)}${facility.description.length > 100 ? '...' : ''}</p>
                <div style="border-left: 3px solid #d4af37; padding-left: 12px; margin: 10px 0;">
                    <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> ${facility.location}</p>
                    <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-ruler-combined"></i> <strong>Distance:</strong> ${distance} km from campus</p>
                    <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-users"></i> <strong>Capacity:</strong> ${facility.capacity} people</p>
                    <p style="margin: 5px 0 10px 0; font-size: 12px;"><i class="fas fa-clock"></i> <strong>Hours:</strong> ${facility.available_hours} hours/day</p>
                </div>
                <a href="/reservations/create?facility=${facility.id}" class="btn btn-sm btn-primary" style="width: 100%; text-align: center; padding: 8px; font-size: 12px; font-weight: 600;"><i class="fas fa-calendar-check"></i> Reserve Now</a>
            </div>
        `);
    });

    // Get user location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    bounds.extend([userLat, userLng]);
                    
                    // Create user marker with improved styling
                    const userIcon = L.icon({
                        iconUrl: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0Ij48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSI4IiBmaWxsPSIjMjJjNTVlIi8+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iNSIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==',
                        iconSize: [32, 40],
                        iconAnchor: [16, 40],
                        popupAnchor: [0, -40]
                    });
                    
                    userMarker = L.marker([userLat, userLng], {icon: userIcon})
                        .addTo(map)
                        .bindPopup('<div style="text-align: center; font-weight: 600; color: #0066cc;"><i class="fas fa-location-dot"></i> <strong>Your Location</strong><br/><small style="font-weight: normal; color: #666;">Lat: ' + userLat.toFixed(4) + '<br/>Lng: ' + userLng.toFixed(4) + '</small></div>');
                    
                    // Fit bounds with padding
                    map.fitBounds(bounds, {padding: [50, 50]});
                },
                function(error) {
                    console.log('Geolocation error:', error.message);
                    // Fit to facilities bounds even if geolocation fails
                    if (facilities.length > 0) {
                        map.fitBounds(bounds, {padding: [50, 50]});
                    }
                }
            );
        } else {
            // Fit bounds if geolocation not available
            if (facilities.length > 0) {
                map.fitBounds(bounds, {padding: [50, 50]});
            }
        }
    }

    // Call getUserLocation on page load
    document.addEventListener('DOMContentLoaded', getUserLocation);
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/map/index.blade.php ENDPATH**/ ?>