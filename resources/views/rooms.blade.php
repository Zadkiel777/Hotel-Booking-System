@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Rooms')

{{-- Content Header Section (Breadcrumbs) --}}
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

    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('addroom') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-bed mr-1"></i> Add Room
        </a>
    </div>

    <form class="form-inline ml-3" action="{{ route('rooms') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search room details..."
                aria-label="Search"
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-bed mr-1"></i> Rooms</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-bed"></i> Rooms</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Main Content Block --}}
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Lists of Rooms</h3>
                    </div>

                    <div class="table-responsive">
                        <table id="userTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-image"></i> Room Picture</th>
                                    <th><i class="fas fa-door-open"></i> Room Number</th>
                                    <th><i class="fas fa-th-large"></i> Room Type</th>
                                    <th><i class="fas fa-clipboard-check"></i> Room Status</th>
                                    <th style="width: 150px" class="text-center">
                                        <i class="fas fa-tools"></i> Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($room as $rooms)
                                    <tr>
                                        {{-- ✅ FIXED IMAGE DISPLAY LOGIC HERE --}}
                                        <td class="text-center">
                                            @if(!empty($rooms->picture))
                                                <img 
                                                    src="{{ asset($rooms->picture) }}" 
                                                    alt="Room {{ $rooms->room_number }}" 
                                                    class="img-thumbnail"
                                                    style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                {{-- Make sure you have a default image at public/images/default_room.png --}}
                                                <img 
                                                    src="{{ asset('images/Luxury Room.jpg') }}" 
                                                    alt="No Image" 
                                                    class="img-thumbnail"
                                                    style="width: 80px; height: 60px; object-fit: cover;">
                                            @endif
                                        </td>
                                        
                                        <td class="align-middle">{{ $rooms->room_number }}</td>
                                        <td class="align-middle">{{ $rooms->room_type }}</td>
                                        
                                        {{-- Optional: Add status badges for better visuals --}}
                                        <td class="align-middle">
                                            @if(strtolower($rooms->status) == 'available')
                                                <span class="badge badge-success">{{ $rooms->status }}</span>
                                            @elseif(strtolower($rooms->status) == 'occupied')
                                                <span class="badge badge-danger">{{ $rooms->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $rooms->status }}</span>
                                            @endif
                                        </td>

                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('editRoom', $rooms->id) }}"
                                                    class="btn btn-success btn-sm" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <form
                                                    action="{{ route('deleteRoom', $rooms->id) }}"
                                                    method="POST"
                                                    class="delete-room-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirmDeleteRoom(event, '{{ $rooms->room_number }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                                No rooms found.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> {{-- End .table-responsive --}}

                    <div class="d-flex justify-content-center mt-3">
                        {{ $room->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    function confirmDeleteRoom(event, roomNumber) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Delete Room?',
            `Are you sure you want to delete room ${roomNumber}? This action cannot be undone.`,
            function() {
                form.submit();
            }
        );
        
        return false;
    }
    
    // Show success/error messages
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection