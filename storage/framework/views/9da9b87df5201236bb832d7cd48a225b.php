

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reservation Details</h2>
        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="row">
        <!-- Left Column: Reservation Details -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Reservation Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%;">Reference ID:</th>
                            <td>#<?php echo e($reservation->id); ?></td>
                        </tr>
                        <tr>
                            <th>Facility:</th>
                            <td><strong><?php echo e($reservation->facility->name); ?></strong></td>
                        </tr>
                        <tr>
                            <th>Guest Name:</th>
                            <td><?php echo e($reservation->guest_name); ?></td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td><?php echo e($reservation->guest_contact); ?></td>
                        </tr>
                        <tr>
                            <th>Requested Date:</th>
                            <td><?php echo e($reservation->available_date ? $reservation->available_date->format('M d, Y') : 'Not specified'); ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if($reservation->status === 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($reservation->status === 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php elseif($reservation->status === 'rejected'): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td style="white-space: pre-wrap;"><?php echo e($reservation->description); ?></td>
                        </tr>
                        <tr>
                            <th>Notes:</th>
                            <td style="white-space: pre-wrap;"><?php echo e($reservation->notes ?? 'No notes'); ?></td>
                        </tr>
                        <tr>
                            <th>Submitted:</th>
                            <td><?php echo e($reservation->created_at->format('M d, Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-building"></i> Facility Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%;">Name:</th>
                            <td><?php echo e($reservation->facility->name); ?></td>
                        </tr>
                        <tr>
                            <th>Location:</th>
                            <td><?php echo e($reservation->facility->location); ?></td>
                        </tr>
                        <tr>
                            <th>Capacity:</th>
                            <td><?php echo e($reservation->facility->capacity); ?> people</td>
                        </tr>
                        <tr>
                            <th>Available Hours:</th>
                            <td><?php echo e($reservation->facility->available_hours); ?> hours</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if($reservation->facility->status === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p style="white-space: pre-wrap;"><?php echo e($reservation->facility->description); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Map -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-map"></i> Facility Location</h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if($reservation->facility->latitude && $reservation->facility->longitude): ?>
                        <div id="reservationMap" style="height: 500px;"></div>
                        
                        <div class="p-3">
                            <div class="alert alert-info mb-0">
                                <p class="mb-1"><strong>Coordinates:</strong></p>
                                <p class="mb-1">Latitude: <?php echo e($reservation->facility->latitude); ?></p>
                                <p class="mb-0">Longitude: <?php echo e($reservation->facility->longitude); ?></p>
                            </div>
                        </div>

                        <!-- Leaflet CSS -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
                        <!-- Leaflet JS -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
                        
                        <script>
                            // School center coordinates (Holy Cross College, Santa Ana, Pampanga)
                            const schoolLat = 15.0934532;
                            const schoolLng = 120.7693744;
                            
                            // Facility coordinates
                            const facilityLat = <?php echo e($reservation->facility->latitude); ?>;
                            const facilityLng = <?php echo e($reservation->facility->longitude); ?>;
                            
                            // Initialize map with better zoom
                            const map = L.map('reservationMap').setView([schoolLat, schoolLng], 17);
                            
                            // Standard OpenStreetMap with detailed buildings and labels
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                minZoom: 1,
                                attribution: '© OpenStreetMap contributors',
                                className: 'leaflet-tiles'
                            }).addTo(map);
                            
                            // Add school center marker with gold color - using standard Leaflet marker
                            const schoolIcon = L.icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [40, 56],
                                iconAnchor: [20, 56],
                                popupAnchor: [0, -56],
                                shadowSize: [41, 41]
                            });
                            
                            L.marker([schoolLat, schoolLng], {icon: schoolIcon})
                                .addTo(map)
                                .bindPopup('<div style=\"font-weight: bold; text-align: center; color: #1a3a52; min-width: 220px;\"><i class=\"fas fa-landmark\"></i> Holy Cross College<br/><small style=\"font-weight: normal; font-size: 12px; color: #666;\">Main Campus Center</small><br/><small style=\"font-weight: normal; font-size: 10px; color: #999; margin-top: 6px; display: block;\">Baliwag-Candaba Road<br/>Santa Ana, Pampanga</small></div>');
                            
                            // Add a circle around school to show the main hub
                            L.circle([schoolLat, schoolLng], {
                                color: '#d4af37',
                                fill: true,
                                fillColor: '#d4af37',
                                fillOpacity: 0.1,
                                weight: 2,
                                radius: 300
                            }).addTo(map);
                            
                            // Add facility marker with enhanced styling
                            const facilityIcon = L.icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [32, 41],
                                iconAnchor: [16, 41],
                                popupAnchor: [0, -41],
                                shadowSize: [41, 41]
                            });
                            
                            L.marker([facilityLat, facilityLng], {icon: facilityIcon})
                                .addTo(map)
                                .bindPopup(`\n                                    <div style="min-width: 260px; font-family: 'Poppins', sans-serif;">\n                                        <div style="background: linear-gradient(135deg, #1a3a52 0%, #2d5a7b 100%); color: white; padding: 12px; border-radius: 4px 4px 0 0; margin: -4px -4px 12px -4px;">\n                                            <h6 style="margin: 0; font-size: 15px; font-weight: 700;"><i class="fas fa-door-open"></i> <?php echo e($reservation->facility->name); ?></h6>\n                                        </div>\n                                        <p style="margin: 0 0 8px 0; font-size: 12px; color: #555;"><i class="fas fa-building"></i> <strong>Facility Type:</strong> Reserved</p>\n                                        <div style="border-left: 3px solid #d4af37; padding-left: 12px; margin: 10px 0;">\n                                            <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <?php echo e($reservation->facility->location); ?></p>\n                                            <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-users"></i> <strong>Capacity:</strong> <?php echo e($reservation->facility->capacity); ?> people</p>\n                                            <p style="margin: 5px 0; font-size: 12px;"><i class="fas fa-clock"></i> <strong>Hours:</strong> <?php echo e($reservation->facility->available_hours); ?> hours/day</p>\n                                            <p style="margin: 5px 0 10px 0; font-size: 11px; color: #666;"><strong>📍 Coordinates:</strong><br/>Lat: <?php echo e($reservation->facility->latitude); ?><br/>Lng: <?php echo e($reservation->facility->longitude); ?></p>\n                                        </div>\n                                    </div>\n                                `);
                            
                            // Draw enhanced line between school and facility
                            const line = L.polyline(
                                [[schoolLat, schoolLng], [facilityLat, facilityLng]],
                                {color: '#1a3a52', weight: 3, opacity: 0.6, dashArray: '5, 5'}
                            ).addTo(map);
                            
                            // Calculate distance using Haversine formula
                            function calculateDistance(lat1, lon1, lat2, lon2) {
                                const R = 6371; // km
                                const dLat = (lat2 - lat1) * Math.PI / 180;
                                const dLon = (lon2 - lon1) * Math.PI / 180;
                                const a = 
                                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                                    Math.sin(dLon/2) * Math.sin(dLon/2);
                                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                                return R * c;
                            }
                            
                            const distance = calculateDistance(schoolLat, schoolLng, facilityLat, facilityLng);
                            
                            // Fit bounds to show both markers with better padding
                            const group = new L.featureGroup([
                                L.marker([schoolLat, schoolLng]),
                                L.marker([facilityLat, facilityLng])
                            ]);
                            map.fitBounds(group.getBounds().pad(0.15));
                            
                            // Get user location
                            function getUserLocation() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(
                                        function(position) {
                                            const userLat = position.coords.latitude;
                                            const userLng = position.coords.longitude;
                                            
                                            // Create user marker with enhanced styling
                                            const userIcon = L.icon({
                                                iconUrl: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0Ij48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSI4IiBmaWxsPSIjMjJjNTVlIi8+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iNSIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==',
                                                iconSize: [32, 40],
                                                iconAnchor: [16, 40],
                                                popupAnchor: [0, -40]
                                            });
                                            
                                            L.marker([userLat, userLng], {icon: userIcon})
                                                .addTo(map)
                                                .bindPopup('<div style="text-align: center; font-weight: 600; color: #0066cc;"><i class="fas fa-location-dot"></i> <strong>Your Location</strong><br/><small style="font-weight: normal; color: #666;">Lat: ' + userLat.toFixed(4) + '<br/>Lng: ' + userLng.toFixed(4) + '</small></div>');
                                            
                                            // Calculate distance from user to facility
                                            const userToFacilityDist = calculateDistance(userLat, userLng, facilityLat, facilityLng);
                                            
                                            // Update distance info with user location
                                            const distanceEl = document.getElementById('distanceInfo');
                                            if (distanceEl) {
                                                distanceEl.innerHTML = '<div class="alert alert-info" style="margin: 0;"><strong><i class="fas fa-ruler-combined"></i> Distance from school center:</strong> <strong style="color: #d4af37;">' + distance.toFixed(2) + ' km</strong><br>' +
                                                    '<strong><i class="fas fa-location-dot"></i> Distance from your location:</strong> <strong style="color: #d4af37;">' + userToFacilityDist.toFixed(2) + ' km</strong></div>';
                                            }
                                            
                                            // Expand bounds to include user location with better padding
                                            const updatedGroup = new L.featureGroup([
                                                L.marker([schoolLat, schoolLng]),
                                                L.marker([facilityLat, facilityLng]),
                                                L.marker([userLat, userLng])
                                            ]);
                                            map.fitBounds(updatedGroup.getBounds().pad(0.15));
                                        },
                                        function(error) {
                                            console.log('Geolocation error:', error.message);
                                            // Still show distance from school center if geolocation fails
                                            const distanceEl = document.getElementById('distanceInfo');
                                            if (distanceEl) {
                                                distanceEl.innerHTML = '<div class="alert alert-warning" style="margin: 0;"><strong><i class="fas fa-ruler-combined"></i> Distance from school center:</strong> <strong style="color: #d4af37;">' + distance.toFixed(2) + ' km</strong><br><em style="font-size: 12px;">Could not retrieve your location. <a href="#" onclick="location.reload();">Try again</a></em></div>';
                                            }
                                        }
                                    );
                                } else {
                                    const distanceEl = document.getElementById('distanceInfo');
                                    if (distanceEl) {
                                        distanceEl.innerHTML = '<div class="alert alert-info" style="margin: 0;"><strong><i class="fas fa-ruler-combined"></i> Distance from school center:</strong> <strong style="color: #d4af37;">' + distance.toFixed(2) + ' km</strong><br><em style="font-size: 12px;">Browser does not support geolocation</em></div>';
                                    }
                                }
                            }
                            
                            // Update distance info
                            document.addEventListener('DOMContentLoaded', function() {
                                const distanceEl = document.getElementById('distanceInfo');
                                if (distanceEl) {
                                    distanceEl.innerHTML = '<div class="alert alert-info" style="margin: 0;"><strong><i class="fas fa-spinner fa-spin"></i> Getting your location and calculating distances...</strong></div>';
                                }
                                // Get user location
                                getUserLocation();
                            });
                        </script>

                        <div class="p-3 border-top">
                            <div id="distanceInfo" class="alert alert-info mb-0" style="border-left: 4px solid #d4af37;">
                                <i class="fas fa-spinner fa-spin"></i> <strong>Loading location data...</strong>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-3">
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle"></i> No location coordinates available for this facility.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Google Maps Alternative Link -->
            <?php if($reservation->facility->latitude && $reservation->facility->longitude): ?>
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-directions"></i> Directions</h5>
                </div>
                <div class="card-body">
                    <a href="https://www.google.com/maps/dir/<?php echo e($reservation->facility->latitude); ?>,<?php echo e($reservation->facility->longitude); ?>" 
                       target="_blank" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-directions"></i> Get Directions (Google Maps)
                    </a>
                    <a href="https://www.openstreetmap.org/?mlat=<?php echo e($reservation->facility->latitude); ?>&mlon=<?php echo e($reservation->facility->longitude); ?>&zoom=18" 
                       target="_blank" class="btn btn-info w-100">
                        <i class="fas fa-map"></i> View on OpenStreetMap
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/reservations/show.blade.php ENDPATH**/ ?>