@extends('layouts.app')

@section('content')
<div class="mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(isset($facility))
                <h2 class="mb-4 text-white">Reserve {{ $facility->name }}</h2>
                
                {{-- Facility Details Card --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-dark text-white">Facility Reference</div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <<div class="col-md-4">
    @if($facility->thumbnail)
        {{-- Fixed: Removing 'storage/' to point directly to the public/images folder --}}
        <img src="{{ asset(Str::start($facility->thumbnail, '/')) }}" 
             class="img-fluid rounded shadow-sm" 
             alt="{{ $facility->name }}">
    @else
        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
            <i class="fas fa-image fa-3x text-muted"></i>
        </div>
    @endif
</div>
                            <div class="col-md-8">
                                <p><strong>Location:</strong> {{ $facility->location }}</p>
                                <p><strong>Base Capacity:</strong> <span id="base_capacity">{{ $facility->capacity }}</span> people</p>
                                <p><strong>Available Hours:</strong> {{ $facility->available_hours }} hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reservation Form --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">Reservation Details</div>
                    <div class="card-body">
                        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
                            @csrf
                            <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                            {{-- Date of Use Input --}}
                            <div class="mb-3">
                                <label for="requested_date" class="form-label fw-bold">Date of Use *</label>
                                <input type="date" 
                                       class="form-control @error('requested_date') is-invalid @enderror" 
                                       id="requested_date" 
                                       name="requested_date" 
                                       {{-- Prevents selecting past dates --}}
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                       value="{{ old('requested_date') }}" 
                                       required>
                                @error('requested_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Estimated Participants --}}
                            <div class="mb-4">
                                <label for="estimated_participants" class="form-label fw-bold">Estimated Participants *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" 
                                           class="form-control form-control-lg @error('estimated_participants') is-invalid @enderror" 
                                           id="estimated_participants" 
                                           name="estimated_participants" 
                                           placeholder="0" 
                                           min="1" 
                                           value="{{ old('estimated_participants') }}" 
                                           required>
                                </div>
                                @error('estimated_participants')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                
                                {{-- Dynamic Chair Request Alert --}}
                                <div id="chair_request_alert" class="mt-3 p-3 border rounded bg-light d-none">
                                    <div class="d-flex align-items-center text-warning">
                                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Additional Seating Required</h6>
                                            <p class="mb-0 small text-muted">
                                                You are requesting <span id="extra_chairs_count" class="fw-bold text-dark">0</span> additional chairs beyond the venue's base capacity.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Purpose --}}
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Purpose of Use *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Describe your event..." 
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5">Submit Reservation Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const participantInput = document.getElementById('estimated_participants');
    const baseCapacitySpan = document.getElementById('base_capacity');
    
    // Safety check in case the element isn't there
    if(participantInput && baseCapacitySpan) {
        const baseCapacity = parseInt(baseCapacitySpan.innerText);
        const chairAlert = document.getElementById('chair_request_alert');
        const extraCount = document.getElementById('extra_chairs_count');

        function updateChairLogic() {
            const val = parseInt(participantInput.value) || 0;
            
            if (val > baseCapacity) {
                const diff = val - baseCapacity;
                extraCount.innerText = diff;
                chairAlert.classList.remove('d-none');
                participantInput.classList.add('border-warning');
            } else {
                chairAlert.classList.add('d-none');
                participantInput.classList.remove('border-warning');
            }
        }

        participantInput.addEventListener('input', updateChairLogic);
        updateChairLogic();
    }
});
</script>
@endsection