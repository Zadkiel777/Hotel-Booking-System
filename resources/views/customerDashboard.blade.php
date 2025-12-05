<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Stays - Bluebird Hotel</title>

    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">

    {{-- Bootstrap 5 & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* --- GLOBAL STYLES --- */
        body {
            min-height: 100vh;
            background: url('{{ asset('images/Luxury Room.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc; /* Very light gray/white main text */
        }

        /* Darker overlay to ensure text pops regardless of image brightness */
        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(5, 7, 20, 0.95), rgba(10, 20, 40, 0.85));
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
        }

        /* --- NAVBAR --- */
        .navbar {
            background: rgba(10, 15, 30, 0.95); /* Solid dark for readability */
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link {
            font-weight: 500;
            color: #cbd5e1 !important; /* Lighter gray for links */
            transition: all 0.3s ease;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #60a5fa !important;
            transform: translateY(-1px);
        }

        /* --- CARDS --- */
        .dashboard-hero {
            padding-top: 5.5rem;
            padding-bottom: 3rem;
        }

        .glass-card {
            /* Increased opacity for better contrast */
            background: rgba(17, 24, 39, 0.85); 
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        /* --- TEXT UTILITIES --- */
        .text-label {
            color: #94a3b8; /* Specific lighter gray for labels */
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* --- STAT PILLS --- */
        .stat-pill {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #bfdbfe;
            font-size: 0.85rem;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 41, 59, 1);
            color: #60a5fa;
            border: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 1.2rem;
        }

        /* --- BUTTONS --- */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            transform: translateY(-1px);
        }

        /* --- TABLE --- */
        .table-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #e2e8f0;
            --bs-table-border-color: rgba(255, 255, 255, 0.1);
        }
        .table-custom th {
            font-weight: 600;
            color: #94a3b8;
            border-bottom-width: 2px;
        }
        .table-custom td {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        /* --- BADGES --- */
        .badge-soft {
            font-weight: 500;
            padding: 0.5em 0.8em;
            border-radius: 8px;
        }

        /* --- FORM --- */
        .form-control-read {
            background-color: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 12px;
            padding: 0.7rem 1rem;
        }

        footer {
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="page-wrapper">
        {{-- Top Nav --}}
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('main') }}">
                    <img src="{{ asset('images/bluebirdlogo.png') }}" alt="Bluebird Hotel" height="32" class="me-2">
                    Bluebird Hotel
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="customerNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#overview"><i class="fas fa-gauge-high me-1"></i>Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#bookings"><i class="fas fa-calendar-check me-1"></i>My Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#profile"><i class="fas fa-user-circle me-1"></i>Profile</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('memberBooking') }}" class="btn btn-sm btn-gradient">
                                <i class="fas fa-bed me-1"></i> Book a Room
                            </a>
                        </li>
                        @if(session('customer_id'))
                            <li class="nav-item ms-lg-1">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-light rounded-pill px-3" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="dashboard-hero">
            <div class="container">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-25 text-white border-0 backdrop-blur" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-25 text-white border-0 backdrop-blur" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Overview + Quick stats --}}
                <section id="overview" class="mb-5">
                    <div class="row g-4 align-items-stretch">
                        <div class="col-lg-5">
                            <div class="glass-card p-4 p-md-5 h-100 d-flex flex-column justify-content-center">
                                <p class="text-label mb-2"><i class="fas fa-crown me-1 text-warning"></i> Valued Guest</p>
                                <h2 class="display-6 fw-bold mb-2">
                                    Welcome back,<br>
                                    <span class="text-primary" style="color: #60a5fa !important;">
                                        {{ session('name') ?? 'Guest' }}
                                    </span>
                                </h2>
                                <p class="mb-4 text-white-50">
                                    Ready for your next escape? Manage your stays and profile details securely here.
                                </p>
                                
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="stat-pill">
                                        <i class="fas fa-shield-alt me-2"></i>Secure Portal
                                    </span>
                                    <span class="stat-pill">
                                        <i class="fas fa-clock me-2"></i>24/7 Access
                                    </span>
                                </div>

                                <div class="mt-auto d-flex flex-wrap gap-2">
                                    <a href="{{ route('memberBooking') }}" class="btn btn-gradient">
                                        New Booking
                                    </a>
                                    <a href="#bookings" class="btn btn-outline-light rounded-3 px-4">
                                        View History
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row g-3 h-100">
                                <div class="col-md-6">
                                    <div class="glass-card p-4 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="stat-icon">
                                                <i class="fas fa-suitcase"></i>
                                            </span>
                                            <span class="badge badge-soft bg-success bg-opacity-25 text-success">Upcoming</span>
                                        </div>
                                        <p class="text-label mb-1">Next Reservation</p>
                                        @if($nextBooking)
                                            <h5 class="fw-bold mb-1">Room {{ $nextBooking->room_number }}</h5>
                                            <p class="text-white-50 small mb-0">{{ $nextBooking->room_type }}</p>
                                            <hr class="border-secondary opacity-25 my-3">
                                            <div class="d-flex align-items-center text-white-50 small">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                {{ \Carbon\Carbon::parse($nextBooking->check_in_date)->format('M d') }} - 
                                                {{ \Carbon\Carbon::parse($nextBooking->check_out_date)->format('M d, Y') }}
                                            </div>
                                        @else
                                            <h5 class="fw-bold mb-1">No upcoming stays</h5>
                                            <p class="text-white-50 small">Plan your next trip with us.</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column gap-3 h-100">
                                        <div class="glass-card p-3 flex-grow-1">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="stat-icon" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-star text-warning"></i>
                                                </span>
                                                <div>
                                                    <p class="text-label mb-0" style="font-size: 0.75rem;">Status</p>
                                                    <h5 class="fw-bold mb-0">Standard Member</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="glass-card p-3 flex-grow-1">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="stat-icon" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-coins text-info"></i>
                                                </span>
                                                <div>
                                                    <p class="text-label mb-0" style="font-size: 0.75rem;">Balance</p>
                                                    <h5 class="fw-bold mb-0">₱0.00</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Bookings section --}}
                <section id="bookings" class="mb-5">
                    <div class="glass-card p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1">Booking History</h4>
                                <p class="text-white-50 mb-0 small">A record of your past and upcoming visits.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Ref ID</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Stay Dates</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td class="text-info fw-bold">#{{ $booking->id }}</td>
                                            <td>
                                                <span class="d-block fw-semibold">Room {{ $booking->room_number }}</span>
                                                <small class="text-white-50">{{ $booking->room_type }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column small">
                                                    <span><i class="fas fa-sign-in-alt me-1 text-success"></i> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                                    <span><i class="fas fa-sign-out-alt me-1 text-danger"></i> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    $textClass = 'text-white';
                                                    if($booking->status === 'Confirmed') { $badgeClass = 'bg-success'; }
                                                    if($booking->status === 'Pending') { $badgeClass = 'bg-warning'; $textClass = 'text-dark'; }
                                                    if($booking->status === 'Cancelled') { $badgeClass = 'bg-danger'; }
                                                    if($booking->status === 'Occupied') { $badgeClass = 'bg-primary'; }
                                                    if($booking->status === 'Completed') { $badgeClass = 'bg-info'; }
                                                @endphp
                                                <span class="badge badge-soft {{ $badgeClass }} bg-opacity-25 {{ $booking->status === 'Pending' ? 'text-warning' : $textClass }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.viewBooking', $booking->id) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="text-white-50">
                                                    <i class="fas fa-folder-open fa-2x mb-3 opacity-50"></i>
                                                    <p>No bookings found linked to this account.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- Profile section --}}
                <section id="profile" class="mb-5">
                    <div class="glass-card p-4 p-md-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
                                <h4 class="fw-bold mb-2">My Profile</h4>
                                <p class="text-white-50 mb-3">
                                    Current details on file. To update these, please contact the front desk for security verification.
                                </p>
                                <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 d-inline-block">
                                    <i class="fas fa-user-shield fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="text-label mb-2">Full Name</label>
                                        <div class="form-control-read">
                                            <i class="fas fa-user me-2 text-white-50"></i>
                                            {{ session('name') ?? 'Guest User' }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-label mb-2">Email Address</label>
                                        <div class="form-control-read">
                                            <i class="fas fa-envelope me-2 text-white-50"></i>
                                            {{ session('email') ?? 'Not available' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <footer class="text-center pb-4">
                    <small class="text-white-50">© {{ date('Y') }} Bluebird Hotel. Experience Luxury.</small>
                </footer>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>