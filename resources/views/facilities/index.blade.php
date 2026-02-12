@extends('layouts.app')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"><i class="fas fa-building"></i> Available Facilities</h2>
            <p class="text-muted">Reserve rooms and facilities for your academic and extracurricular activities</p>
        </div>
    </div>

    <div class="facility-grid">
        @forelse($facilities as $facility)
        <div class="facility-card">
            <div class="facility-icon">
                <i class="fas fa-door-open"></i>
            </div>
            <h5>{{ $facility->name }}</h5>
            <p class="facility-description">{{ $facility->description }}</p>
            <div class="facility-details">
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $facility->location }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-users"></i>
                    <span>{{ $facility->capacity }} people</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-dollar-sign"></i>
                    <span>${{ $facility->hourly_rate }}/hour</span>
                </div>
            </div>
            <a href="{{ route('reservations.create', $facility) }}" class="btn btn-primary btn-block mt-3">
                <i class="fas fa-calendar-check"></i> Book Now
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No facilities available at the moment.
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .facility-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    
    .facility-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 4px rgba(74, 20, 140, 0.1);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .facility-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(74, 20, 140, 0.2);
        border-color: #4A148C;
    }
    
    .facility-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #4A148C 0%, #6A1B9A 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    
    .facility-icon i {
        color: #FFC107;
        font-size: 28px;
    }
    
    .facility-card h5 {
        color: #4A148C;
        margin-bottom: 12px;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .facility-description {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 16px;
        line-height: 1.5;
    }
    
    .facility-details {
        margin-bottom: 16px;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        color: #555;
        font-size: 0.9rem;
    }
    
    .detail-item i {
        color: #4A148C;
        width: 18px;
    }
    
    .btn-block {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
</style>
@endsection
