@extends('layouts.app')

@section('content')
<div class="mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Reserve {{ $facility->name }}</h2>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Facility Details
                </div>
                <div class="card-body">
                    <p><strong>Location:</strong> {{ $facility->location }}</p>
                    <p><strong>Capacity:</strong> {{ $facility->capacity }} people</p>
                    <p><strong>Available Hours:</strong> {{ $facility->available_hours }} hours</p>
                    @if($facility->description)
                        <p><strong>Description:</strong> {{ $facility->description }}</p>
                    @endif
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
                            <label for="description" class="form-label">What will you use this facility for? *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Please describe your intended use of the facility..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> Your reservation will be submitted for admin approval. You will be notified once it's reviewed.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                            <button type="submit" class="btn btn-primary">Submit Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
