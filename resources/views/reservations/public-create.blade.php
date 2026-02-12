<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve {{ $facility->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .reservation-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .reservation-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }
        .facility-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .facility-info h4 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            display: block;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="reservation-container">
        <h2>Reserve Facility</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="facility-info">
            <h4>{{ $facility->name }}</h4>
            <p><strong>Location:</strong> {{ $facility->location }}</p>
            <p><strong>Capacity:</strong> {{ $facility->capacity }} people</p>
            <p><strong>Available Hours:</strong> {{ $facility->available_hours }} hours</p>
            @if($facility->description)
                <p><strong>Description:</strong> {{ $facility->description }}</p>
            @endif
        </div>

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf

            <input type="hidden" name="facility_id" value="{{ $facility->id }}">

            <div class="form-group">
                <label for="guest_name">Your Name *</label>
                <input type="text" id="guest_name" name="guest_name" placeholder="Enter your full name" value="{{ old('guest_name') }}" required>
            </div>

            <div class="form-group">
                <label for="guest_contact">Contact Number/Email *</label>
                <input type="text" id="guest_contact" name="guest_contact" placeholder="Phone or email for confirmation" value="{{ old('guest_contact') }}" required>
            </div>

            <div class="form-group">
                <label for="description">What will you use this facility for? *</label>
                <textarea id="description" name="description" rows="4" placeholder="Please describe your intended use of the facility..." required>{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Reservation Request</button>
        </form>

        <div class="back-link">
            <a href="/">← Back to Facilities</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
