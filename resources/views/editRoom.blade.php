@extends('themes.main')

@section('title', 'Edit Room')

@section('content_header')
<nav class="navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>
</nav>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-edit mr-1"></i> Edit Room</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rooms') }}"><i class="fas fa-bed"></i> Rooms</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-edit"></i> Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bed mr-1"></i> Edit Room Information</h3>
                    </div>
                    
                    {{-- ✅ Added enctype for file upload --}}
                    <form method="POST" action="{{ route('updateRoom', $room->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            
                            {{-- ✅ New Section: Display Current Image --}}
                            <div class="form-group text-center">
                                <label>Current Picture</label><br>
                                @if(!empty($room->picture))
                                    <img src="{{ asset($room->picture) }}" 
                                         alt="Current Room Image" 
                                         class="img-thumbnail" 
                                         style="width: 200px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default_room.png') }}" 
                                         alt="Default Image" 
                                         class="img-thumbnail" 
                                         style="width: 200px; height: 150px; object-fit: cover;">
                                @endif
                            </div>

                            {{-- ✅ New Section: Upload New Image --}}
                            <div class="form-group">
                                <label for="picture"><i class="fas fa-image mr-1"></i> Update Picture</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="picture" accept="image/*">
                                        <label class="custom-file-label" for="picture">Choose file</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Leave blank if you don't want to change the picture.</small>
                                @error('picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="room_number"><i class="fas fa-door-open mr-1"></i> Room Number</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="room_number" 
                                       name="room_number" 
                                       value="{{ $room->room_number }}" 
                                       readonly 
                                       style="background-color: #e9ecef;">
                                <small class="form-text text-muted">Room number cannot be changed.</small>
                            </div>

                            <div class="form-group">
                                <label for="room_type"><i class="fas fa-th-large mr-1"></i> Room Type</label>
                                <select class="form-control" id="room_type" name="room_type" style="height: auto;" required>
                                    <option value="">Select Room Type</option>
                                    <option value="Single" {{ $room->room_type == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Double" {{ $room->room_type == 'Double' ? 'selected' : '' }}>Double</option>
                                    <option value="Family" {{ $room->room_type == 'Family' ? 'selected' : '' }}>Family</option>
                                </select>
                                @error('room_type') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status"><i class="fas fa-clipboard-check mr-1"></i> Room Status</label>
                                <select class="form-control" id="status" name="status" style="height: auto;" required>
                                    <option value="">Select Status</option>
                                    <option value="Available" {{ $room->status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Occupied" {{ $room->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                    <option value="Under Maintenance" {{ $room->status == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    <option value="Unavailable" {{ $room->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" onclick="return confirmUpdateRoom(event)">
                                <i class="fas fa-save mr-1"></i> Update Room
                            </button>
                            <a href="{{ route('rooms') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
{{-- bs-custom-file-input helps show the filename when selected in Bootstrap 4 --}}
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    // Initialize custom file input to show filename
    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    function confirmUpdateRoom(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        const roomNumber = form.querySelector('[name="room_number"]').value;
        const roomType = form.querySelector('[name="room_type"]').value;
        const status = form.querySelector('[name="status"]').value;
        
        if (!roomType || !status) {
            showSwiftError('Validation Error', 'Please fill in all required fields.');
            return false;
        }
        
        showSwiftConfirm(
            'Update Room?',
            `Are you sure you want to update room ${roomNumber}?`,
            function() {
                form.submit();
            }
        );
        
        return false;
    }
    
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection