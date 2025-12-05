<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Booking - Bluebird Hotel</title>

    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            background: url('{{ asset('images/pool.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(9, 12, 32, 0.85), rgba(15, 32, 55, 0.7));
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .booking-card {
            max-width: 600px;
            margin: 0 auto;
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            box-shadow: 0 25px 65px rgba(7, 12, 27, 0.55);
            padding: 2.5rem;
        }

        .form-control, .form-select {
            border-radius: 14px;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-control:focus, .form-select:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .section-title {
            color: #60a5fa;
            font-weight: 600;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #60a5fa, #4338ca);
            border: none;
            border-radius: 14px;
            padding: 0.9rem;
            font-weight: 600;
            color: white;
            transition: transform 0.2s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-outline-light {
            border-radius: 14px;
            padding: 0.9rem;
        }
        
        .alert-custom {
            border-radius: 14px;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="position-relative">

    <div class="overlay"></div>

    <div class="page-wrapper container">
        <div class="booking-card">
            
            <div class="text-center mb-4">
                <a href="{{ route('customerDashboard') }}" class="text-decoration-none mb-3 d-block">
                    <i class="fas fa-arrow-left text-white-50 me-2"></i><span class="text-white-50">Back to Dashboard</span>
                </a>
                <h2 class="fw-bold text-white">
                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                    Member Booking
                </h2>
                
                @if(Session::has('customer_id'))
                    <div class="alert alert-success alert-custom bg-success bg-opacity-25 border-success text-white mt-3">
                        <i class="fas fa-user-check me-2"></i>
                        Booking as <strong>{{ Session::get('name') }}</strong>
                        <span class="badge bg-primary ms-2">Member</span>
                    </div>
                @else
                    <div class="alert alert-warning alert-custom bg-warning bg-opacity-25 border-warning text-white mt-3">
                        Please log in to your account to use the member booking form.
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('member_book_room') }}" id="memberBookingForm">
                @csrf

                <div class="section-title mt-2">Reservation Details</div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Check In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" required value="{{ old('check_in') }}">
                        @error('check_in') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Check Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" required value="{{ old('check_out') }}">
                        @error('check_out') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Preference</label>
                    <select name="room_type" class="form-select" required>
                        <option value="">Select Room Type</option>
                        <option value="Single" {{ old('room_type') == 'Single' ? 'selected' : '' }}>Single Suite</option>
                        <option value="Double" {{ old('room_type') == 'Double' ? 'selected' : '' }}>Double Suite</option>
                        <option value="Family" {{ old('room_type') == 'Family' ? 'selected' : '' }}>Family Suite</option>
                    </select>
                    @error('room_type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Number of Guests</label>
                    <select name="guests" class="form-select" required>
                        <option value="1" {{ old('guests') == '1' ? 'selected' : '' }}>1 Guest</option>
                        <option value="2" {{ old('guests') == '2' ? 'selected' : '' }}>2 Guests</option>
                        <option value="3" {{ old('guests') == '3' ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ old('guests') == '4' ? 'selected' : '' }}>4+ Guests</option>
                    </select>
                    @error('guests') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-gradient text-white shadow" onclick="confirmMemberBooking()">
                        <i class="fas fa-paper-plane me-2"></i>
                        Confirm Member Booking
                    </button>
                    <a href="{{ route('customerDashboard') }}" class="btn btn-outline-light" onclick="return confirmBack(event)">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/swift-alerts.js') }}"></script>
    <script>
        function confirmMemberBooking() {
            const form = document.getElementById('memberBookingForm');
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            
            if (!checkIn || !checkOut) {
                if(typeof showSwiftError === 'function') {
                    showSwiftError('Validation Error', 'Please select Check-in and Check-out dates.');
                } else {
                    alert('Please select Check-in and Check-out dates.');
                }
                return;
            }

            if(typeof showSwiftConfirm === 'function') {
                showSwiftConfirm(
                    'Confirm Booking',
                    `Are you sure you want to book from ${checkIn} to ${checkOut} as a member?`,
                    function() { form.submit(); },
                    function() { }
                );
            } else {
                if(confirm(`Are you sure you want to book from ${checkIn} to ${checkOut}?`)) {
                    form.submit();
                }
            }
        }
        
        function confirmBack(event) {
            event.preventDefault();
            const url = event.target.href;
            if(typeof showSwiftConfirm === 'function') {
                showSwiftConfirm(
                    'Cancel Booking?',
                    'Are you sure you want to leave? Your booking details will be lost.',
                    function() { window.location.href = url; }
                );
            } else {
                 if(confirm('Are you sure you want to leave? Your booking details will be lost.')) {
                    window.location.href = url;
                 }
            }
            return false;
        }
        
        @if(session('success'))
            if(typeof showSwiftSuccess === 'function') {
                showSwiftSuccess('Success!', '{{ session("success") }}');
            } else { alert('{{ session("success") }}'); }
        @endif
        
        @if(session('error'))
            if(typeof showSwiftError === 'function') {
                showSwiftError('Error', '{{ session("error") }}');
            } else { alert('{{ session("error") }}'); }
        @endif
    </script>
</body>
</html>


