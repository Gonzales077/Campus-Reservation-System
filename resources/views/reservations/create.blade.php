@extends('layouts.app')

@section('content')
<div class="mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Book {{ $facility->name }}</h2>

            <div class="card">
                <div class="card-header">
                    Facility Details
                </div>
                <div class="card-body">
                    <p><strong>Location:</strong> {{ $facility->location }}</p>
                    <p><strong>Capacity:</strong> {{ $facility->capacity }} people</p>
                    <p><strong>Available Hours:</strong> {{ $facility->available_hours }} hours</p>
                    <p><strong>Description:</strong> {{ $facility->description ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Reservation Details
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time *</label>
                            <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time *</label>
                            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hours_used" class="form-label">Hours to Use *</label>
                            <input type="number" class="form-control @error('hours_used') is-invalid @enderror" id="hours_used" name="hours_used" value="{{ old('hours_used', 1) }}" min="1" max="{{ $facility->available_hours }}" required>
                            <small class="form-text text-muted">Maximum available: {{ $facility->available_hours }} hours</small>
                            @error('hours_used')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <strong>Hours Requested:</strong> <span id="hours-display">1</span> / {{ $facility->available_hours }} hours available
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Submit Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const hoursUsedInput = document.getElementById('hours_used');
    const hoursDisplay = document.getElementById('hours-display');
    const maxHours = {{ $facility->available_hours }};

    hoursUsedInput.addEventListener('change', function() {
        hoursDisplay.textContent = this.value;
    });
</script>
@endsection
