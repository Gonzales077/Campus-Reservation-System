@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>
    /* ── FULL SCREEN RESET ── */
    body > main, main.py-4, .container, .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
        max-width: none !important;
        width: 100% !important;
    }

    .full-screen-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Top Bar Consistency */
    .admin-top-bar {
        background: #fff;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .admin-top-bar h2 {
        margin: 0;
        font-weight: 800;
        font-size: 1.4rem;
        color: #1a3a52;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Professional Form Card */
    .form-container {
        max-width: 900px;
        margin: 0 auto 3rem auto;
        padding: 0 20px;
        width: 100%;
    }

    .glass-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        padding: 2.5rem;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s;
        color: #1a3a52;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #1a3a52;
        box-shadow: 0 0 0 4px rgba(26, 58, 82, 0.1);
    }

    /* Auto-Media Info Box */
    .media-info-box {
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    /* Buttons */
    .btn-save {
        background: #1a3a52;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-save:hover {
        background: #0f2639;
        transform: translateY(-1px);
    }

    .btn-back {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-back:hover {
        background: #e2e880;
        color: #1a3a52;
    }

    .required-dot { color: #ef4444; }
</style>

<div class="full-screen-wrapper">
    <div class="admin-top-bar">
        <h2><i class="fas fa-plus-circle"></i> Add New Facility</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Cancel
        </a>
    </div>

    <div class="form-container">
        <div class="glass-card">
            <form action="{{ route('facilities.store') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Facility Name <span class="required-dot">*</span></label>
                        <select class="form-select @error('name') is-invalid @enderror" id="name" name="name" required>
                            <option value="">-- Select Category --</option>
                            @foreach($facilityNames as $facilityName)
                                <option value="{{ $facilityName }}" {{ old('name') === $facilityName ? 'selected' : '' }}>{{ $facilityName }}</option>
                            @endforeach
                        </select>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Address / Location <span class="required-dot">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Building A, 2nd Floor" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description & Details</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe the facility features...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-4 bg-light">
                            <label for="capacity" class="form-label">Max Capacity <span class="required-dot">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-transparent"><i class="fas fa-users"></i></span>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-4 bg-light">
                            <label for="available_hours" class="form-label">Daily Available Hours <span class="required-dot">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-transparent"><i class="fas fa-clock"></i></span>
                                <input type="number" class="form-control" id="available_hours" name="available_hours" value="{{ old('available_hours') }}" min="1" required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5" style="border-top: 1px solid #e2e8f0;">

                <h5 class="fw-bold mb-4" style="color: #1a3a52;">Facility Media</h5>
                
                <div class="media-info-box">
                    <i class="fas fa-images fa-2x" style="color: #0369a1;"></i>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #0369a1;">Smart Resource Mapping Active</h6>
                        <p class="mb-0 text-muted small">The system will automatically assign professional thumbnails and gallery images based on your <strong>Facility Name</strong> selection above. No manual upload required.</p>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back d-flex align-items-center">Cancel</a>
                    <button type="submit" class="btn-save shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Confirm & Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    @if(session('toast_success'))
        Toast.fire({ icon: 'success', title: "{{ session('toast_success') }}" });
    @endif

    @if(session('toast_error'))
        Toast.fire({ icon: 'error', title: "{{ session('toast_error') }}" });
    @endif
</script>
@endsection