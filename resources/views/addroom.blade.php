<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #007bff 0%, #6cb2eb 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px 25px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        /* Updated input styling to handle file inputs better */
        input, select {
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
            width: 100%; /* Ensure full width */
            box-sizing: border-box; /* Fix padding issues */
        }
        
        /* Specific styling for file input */
        input[type="file"] {
            padding: 6px; /* Slightly less padding for file input */
            background-color: #f8f9fa;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-primary, .btn-secondary {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            color: white;
            background-color: #09a611ff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none; /* Fix link styling */
            display: inline-block;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 10px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px 15px;
            }
            h2 {
                font-size: 20px;
            }
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Room</h2>

    {{-- ✅ IMPORTANT: Added enctype="multipart/form-data" for file upload --}}
    <form method="POST" action="{{ route('save_room') }}" enctype="multipart/form-data">
        @csrf

        {{-- ✅ New Picture Input --}}
        <label>Room Picture</label>
        <input type="file" name="picture" accept="image/*">
        @error('picture') <span class="error-message">{{ $message }}</span> @enderror

        <label>Room Number</label>
        <input type="text" name="room_number" placeholder="Enter Room number" required value="{{ old('room_number') }}">
        @error('room_number') <span class="error-message">{{ $message }}</span> @enderror


        <label>Room Type</label>
        <select name="room_type" required>
            <option value="">Select Room Type</option>
            <option value="Single" {{ old('room_type') == 'Single' ? 'selected' : '' }}>Single</option>
            <option value="Double" {{ old('room_type') == 'Double' ? 'selected' : '' }}>Double</option>
            <option value="Family" {{ old('room_type') == 'Family' ? 'selected' : '' }}> Family</option>
        </select>
        @error('room_type') <span class="error-message">{{ $message }}</span> @enderror

        
        <label>Room Status</label>
        <select name="status" required>
            <option value="">Room Status</option>
            <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
            <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
            <option value="Occupied" {{ old('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
        </select>
        @error('status') <span class="error-message">{{ $message }}</span> @enderror


        <div class="btn-group">
            <button type="submit" class="btn-primary" onclick="return confirmRoomSave(event)">Save Room</button>
            <a href="{{ route('rooms') }}" class="btn-secondary" onclick="return confirmBack(event)">Back</a>
        </div>
    </form>
</div>

<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    function confirmRoomSave(event) {
        const form = event.target.closest('form');
        const roomNumber = form.querySelector('[name="room_number"]').value;
        const roomType = form.querySelector('[name="room_type"]').value;
        
        if (!roomNumber || !roomType) {
            showSwiftError('Validation Error', 'Please fill in all required fields.');
            return false;
        }
        
        showSwiftConfirm(
            'Confirm Save',
            `Are you sure you want to save room ${roomNumber}?`,
            function() {
                form.submit();
            },
            function() {
                // User cancelled
            }
        );
        
        return false;
    }
    
    function confirmBack(event) {
        event.preventDefault();
        showSwiftConfirm(
            'Go Back?',
            'Are you sure you want to go back? Any unsaved changes will be lost.',
            function() {
                window.location.href = '{{ route("rooms") }}';
            }
        );
        return false;
    }
    
    // Show success message if room was saved successfully
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    // Show error message if there was an error
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
</body>
</html>