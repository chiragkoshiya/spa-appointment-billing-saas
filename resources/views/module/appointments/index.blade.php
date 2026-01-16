@extends('module.layout.app')

@section('title', 'Appointments Management')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Appointments Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if (session('success'))
        <script>
            showToast('success', '{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            showToast('error', '{{ session('error') }}');
        </script>
    @endif

    @if ($errors->has('conflict'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            {{ $errors->first('conflict') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Today's Appointments</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['today'] }}</h4>
                            <p class="text-muted mb-0"><small>Revenue:
                                    ₹{{ number_format($stats['today_revenue'], 2) }}</small></p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="ri-calendar-check-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">This Week</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['week'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="ri-calendar-event-line text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">This Month</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['month'] }}</h4>
                            <p class="text-muted mb-0"><small>Revenue:
                                    ₹{{ number_format($stats['month_revenue'], 2) }}</small></p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="ri-calendar-star-line text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Status Overview</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['completed'] }}/{{ $stats['total'] }}
                            </h4>
                            <p class="text-muted mb-0"><small>{{ $stats['pending'] }} Pending</small></p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="ri-file-list-3-line text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Rooms</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['total_rooms'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-secondary-subtle rounded fs-3">
                                <i class="ri-hotel-bed-line text-secondary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Active Rooms</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['active_rooms'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="ri-checkbox-circle-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Inactive Rooms</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['inactive_rooms'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle rounded fs-3">
                                <i class="ri-close-circle-line text-danger"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Available Rooms</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="availableRoomsCount">
                                {{ $stats['active_rooms'] }}
                            </h4>
                            <p class="text-muted mb-0"><small id="availableRoomsText">Select date & time to check</small>
                            </p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="ri-time-line text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Advanced Filters</h5>
                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterCollapse" aria-expanded="false">
                            <i class="ri-filter-line"></i> Toggle Filters
                        </button>
                    </div>
                </div>
                <div class="collapse {{ request()->hasAny(['search', 'status', 'customer_id', 'staff_id', 'room_id', 'service_id', 'payment_status', 'date_from', 'date_to']) ? 'show' : '' }}"
                    id="filterCollapse">
                    <div class="card-body">
                        <form method="GET" action="{{ route('appointments.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Customer name, phone, ID..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All</option>
                                        <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>
                                            Created</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Customer</label>
                                    <select name="customer_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Staff</label>
                                    <select name="staff_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($staff as $s)
                                            <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Room</label>
                                    <select name="room_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                                {{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Service</label>
                                    <select name="service_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Date From</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Date To</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sort By</label>
                                    <select name="sort_by" class="form-select">
                                        <option value="appointment_date" {{ request('sort_by') == 'appointment_date' ? 'selected' : '' }}>Date</option>
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                            Created</option>
                                        <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>
                                            Amount</option>
                                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>
                                            Status</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sort Order</label>
                                    <select name="sort_order" class="form-select">
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                            Descending</option>
                                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                            Ascending</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('appointments.index') }}" class="btn btn-light">
                                        <i class="ri-refresh-line me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Appointment List</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('appointments.index') }}" class="btn btn-light me-1"
                                title="Refresh/Reset Filters">
                                <i class="ri-refresh-line"></i>
                            </a>
                            <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Create Appointment
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Appointment ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Date & Time</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $index => $appointment)
                                    <tr>
                                        <td>{{ $appointments->firstItem() + $index }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="fw-semibold link-primary">
                                                #APP{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-medium">{{ $appointment->customer->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $appointment->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info">
                                                {{ $appointment->service->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $appointment->staff->name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->room->name ?? 'N/A' }}</td>
                                        <td>
                                            <div>
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}
                                            </div>
                                            <small class="text-muted">{{ $appointment->start_time }} -
                                                {{ $appointment->end_time }}</small>
                                            @if ($appointment->duration)
                                                <br><small class="text-muted">({{ $appointment->duration }} min)</small>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">₹{{ number_format($appointment->amount, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $appointment->status == 'completed' ? 'success' : 'warning' }}-subtle text-{{ $appointment->status == 'completed' ? 'success' : 'warning' }} text-uppercase">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                            @if ($appointment->invoice)
                                                <br><small class="text-success"><i class="ri-file-list-3-line"></i>
                                                    Invoiced</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $appointment->payment_status == 'paid' ? 'success' : 'danger' }}-subtle text-{{ $appointment->payment_status == 'paid' ? 'success' : 'danger' }}">
                                                {{ ucfirst($appointment->payment_status) }}
                                            </span>
                                            @if ($appointment->payment_method)
                                                <br><small class="text-muted">{{ $appointment->payment_method }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0 justify-content-end">
                                                @if ($appointment->status == 'created' && $appointment->payment_status != 'paid')
                                                    <li class="list-inline-item">
                                                        <form action="{{ route('appointments.updateStatus', $appointment->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="btn btn-sm btn-soft-success"
                                                                onclick="return confirm('Mark this appointment as completed? Invoice will be generated automatically. Note: After generating invoice, you cannot edit this appointment.')"
                                                                title="Mark as Completed">
                                                                <i class="ri-check-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if (!$appointment->invoice)
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0);" class="edit-item-btn btn btn-sm btn-soft-info"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="{{ $appointment->id }}"
                                                            data-customer_id="{{ $appointment->customer_id }}"
                                                            data-phone="{{ $appointment->phone }}"
                                                            data-service_id="{{ $appointment->service_id }}"
                                                            data-room_id="{{ $appointment->room_id }}"
                                                            data-staff_id="{{ $appointment->staff_id }}"
                                                            data-date="{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' }}"
                                                            data-start_time="{{ $appointment->start_time }}"
                                                            data-end_time="{{ $appointment->end_time }}"
                                                            data-duration="{{ $appointment->duration }}"
                                                            data-amount="{{ $appointment->amount }}"
                                                            data-payment_method="{{ $appointment->payment_method }}"
                                                            data-payment_status="{{ $appointment->payment_status }}"
                                                            data-is_member="{{ $appointment->is_member }}"
                                                            data-offer_id="{{ $appointment->offer_id }}"
                                                            data-sleep="{{ $appointment->sleep }}" title="Edit">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($appointment->invoice)
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('invoices.show', $appointment->invoice->id) }}"
                                                            class="btn btn-sm btn-soft-primary" title="View Invoice">
                                                            <i class="ri-file-list-3-line"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="list-inline-item">
                                                    <button type="button" class="btn btn-sm btn-soft-danger remove-item-btn"
                                                        data-bs-toggle="modal" data-bs-target="#deleteRecordModal"
                                                        data-action="{{ route('appointments.destroy', $appointment->id) }}"
                                                        data-message="Are you sure you want to delete this appointment?"
                                                        title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-inbox-line fs-48"></i>
                                                <p class="mt-2">No data found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($appointments->hasPages())
                        <div class="d-flex justify-content-end">
                            {{ $appointments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store') }}" method="POST" id="createForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Error Display Area -->
                        <div id="createFormErrors" class="alert alert-danger" style="display: none;">
                            <h6 class="alert-heading"><i class="ri-error-warning-line me-1"></i> Please fix the following
                                errors:</h6>
                            <ul class="mb-0" id="createErrorList"></ul>
                        </div>
                        <div class="row g-3">
                            <!-- Customer Selection -->
                            <div class="col-lg-12">
                                <h6 class="mb-3"><i class="ri-user-line me-1"></i> Customer Information</h6>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Select Registered Customer <span
                                        class="text-muted">(Optional)</span></label>
                                <select name="customer_id" id="customer_select" class="form-select">
                                    <option value="">-- New / Walk-in Customer --</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}" data-phone="{{ $c->phone }}" data-email="{{ $c->email }}"
                                            data-type="{{ $c->customer_type }}" data-balance="{{ $c->wallet->balance ?? 0 }}">
                                            {{ $c->name }}
                                            @if ($c->customer_type == 'member')
                                                (Member - Bal: ₹{{ number_format($c->wallet->balance ?? 0, 2) }})
                                            @else
                                                (Normal)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6" id="new_cust_name_div">
                                <label class="form-label">Customer Name (New)</label>
                                <input type="text" name="customer_name" id="new_customer_name" class="form-control"
                                    placeholder="Enter customer name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-6" id="new_cust_email_div">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="customer_email" id="new_customer_email" class="form-control"
                                    placeholder="Enter email address">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="customer_phone" class="form-control"
                                    placeholder="Enter phone number">
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Appointment Details -->
                            <div class="col-lg-12 mt-3">
                                <h6 class="mb-3"><i class="ri-calendar-line me-1"></i> Appointment Details</h6>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Service (Therapy) <span class="text-danger">*</span></label>
                                <select name="service_id" id="service_select" class="form-select">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $s)
                                        <option value="{{ $s->id }}" data-price="{{ $s->price }}"
                                            data-duration="{{ $s->duration_minutes }}">
                                            {{ $s->name }} - ₹{{ number_format($s->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Staff <span class="text-danger">*</span></label>
                                <select name="staff_id" id="staff_select" class="form-select">
                                    <option value="">Select Staff</option>
                                    @foreach ($staff as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Room <span class="text-danger">*</span></label>
                                <select name="room_id" id="room_select" class="form-select">
                                    <option value="">Select Room</option>
                                    @foreach ($rooms as $r)
                                        <option value="{{ $r->id }}" data-room-name="{{ $r->name }}">
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="roomAvailabilityStatus" class="mt-2" style="display: none;"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Duration (Minutes)</label>
                                <input type="number" name="duration" id="duration" class="form-control"
                                    placeholder="Auto-calculated" min="1">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control"
                                    placeholder="0.00" min="0" readonly>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Offer (Optional)</label>
                                <select name="offer_id" id="offer_select" class="form-select">
                                    <option value="">-- Select Offer --</option>
                                    @foreach ($offers as $offer)
                                        <option value="{{ $offer->id }}" data-discount-type="{{ $offer->discount_type }}"
                                            data-discount-value="{{ $offer->discount_value }}">
                                            {{ $offer->name }}
                                            ({{ $offer->discount_type == 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div id="memberWalletInfo" class="alert alert-info py-2 mb-0" style="display: none;">
                                    <small>
                                        <i class="ri-wallet-line"></i>
                                        <strong>Member Wallet Balance:</strong>
                                        <span id="memberBalance">₹0.00</span>
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div id="amountBreakdown" class="card border-primary mb-0" style="display: none;">
                                    <div class="card-body py-2">
                                        <h6 class="card-title mb-2"><i class="ri-calculator-line"></i> Amount Breakdown
                                        </h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Service Amount:</small>
                                                <div class="fw-bold" id="serviceAmount">₹0.00</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Member Wallet Used:</small>
                                                <div class="fw-bold text-warning" id="walletUsed">₹0.00</div>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <small class="text-muted">Offer Discount:</small>
                                                <div class="fw-bold text-success" id="offerDiscount">₹0.00</div>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <small class="text-muted">Final Amount:</small>
                                                <div class="fw-bold text-primary fs-5" id="finalAmount">₹0.00</div>
                                            </div>
                                            <div class="col-12 mt-2" id="remainingBalanceDiv" style="display: none;">
                                                <small class="text-muted">Remaining Wallet Balance:</small>
                                                <div class="fw-bold text-info" id="remainingBalance">₹0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="col-lg-12 mt-3">
                                <h6 class="mb-3"><i class="ri-money-rupee-circle-line me-1"></i> Payment Information
                                </h6>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" id="payment_status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Sleep / Notes</label>
                                <input type="text" name="sleep" class="form-control" placeholder="Additional notes">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_member" value="1"
                                        id="isMemberSwitch">
                                    <label class="form-check-label" for="isMemberSwitch">Is Member Customer?</label>
                                </div>
                            </div>
                        </div>
                        <div id="conflictWarning" class="alert alert-warning mt-3" style="display: none;">
                            <i class="ri-alert-line me-1"></i>
                            <strong>Warning:</strong> <span id="conflictMessage"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Error Display Area -->
                        <div id="editFormErrors" class="alert alert-danger" style="display: none;">
                            <h6 class="alert-heading"><i class="ri-error-warning-line me-1"></i> Please fix the following
                                errors:</h6>
                            <ul class="mb-0" id="editErrorList"></ul>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <h6 class="mb-3"><i class="ri-user-line me-1"></i> Customer Information</h6>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" id="edit_customer_id" class="form-select">
                                    <div class="invalid-feedback"></div>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="edit_phone" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <h6 class="mb-3"><i class="ri-calendar-line me-1"></i> Appointment Details</h6>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Service <span class="text-danger">*</span></label>
                                <select name="service_id" id="edit_service_id" class="form-select">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $s)
                                        <option value="{{ $s->id }}" data-price="{{ $s->price }}">
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Staff <span class="text-danger">*</span></label>
                                <select name="staff_id" id="edit_staff_id" class="form-select">
                                    <option value="">Select Staff</option>
                                    @foreach ($staff as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Room <span class="text-danger">*</span></label>
                                <select name="room_id" id="edit_room_id" class="form-select">
                                    <option value="">Select Room</option>
                                    @foreach ($rooms as $r)
                                        <option value="{{ $r->id }}" data-room-name="{{ $r->name }}">
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                                <div id="editRoomAvailabilityStatus" class="mt-2" style="display: none;"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" id="edit_appointment_date" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="edit_start_time" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="edit_end_time" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Duration (Minutes)</label>
                                <input type="number" name="duration" id="edit_duration" class="form-control" min="1">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" id="edit_amount" class="form-control"
                                    min="0">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Offer (Optional)</label>
                                <select name="offer_id" id="edit_offer_select" class="form-select">
                                    <option value="">-- Select Offer --</option>
                                    @foreach ($offers as $offer)
                                        <option value="{{ $offer->id }}" data-discount-type="{{ $offer->discount_type }}"
                                            data-discount-value="{{ $offer->discount_value }}">
                                            {{ $offer->name }}
                                            ({{ $offer->discount_type == 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <h6 class="mb-3"><i class="ri-money-rupee-circle-line me-1"></i> Payment Information
                                </h6>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" id="edit_payment_method" class="form-select">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" id="edit_payment_status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Sleep / Notes</label>
                                <input type="text" name="sleep" id="edit_sleep" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_member" value="1"
                                        id="edit_is_member">
                                    <label class="form-check-label" for="edit_is_member">Is Member Customer?</label>
                                </div>
                            </div>
                        </div>
                        <div id="editConflictWarning" class="alert alert-warning mt-3" style="display: none;">
                            <i class="ri-alert-line me-1"></i>
                            <strong>Warning:</strong> <span id="editConflictMessage"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Status Change Confirmation Modal -->
    <div class="modal fade" id="paymentStatusConfirmModal" tabindex="-1" aria-labelledby="paymentStatusConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-subtle">
                    <h5 class="modal-title text-primary" id="paymentStatusConfirmModalLabel">
                        <i class="ri-money-rupee-circle-line me-2"></i>Confirm Payment Status Change
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle font-size-24">
                                <i class="ri-alert-line"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">Change Payment Status to Paid?</h5>
                        <p class="text-muted mb-0">
                            When you change the payment status to <strong class="text-success">Paid</strong>,
                            an invoice will be automatically generated for this appointment.
                        </p>
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="ri-information-line me-1"></i>
                            <strong>Note:</strong> After generating the invoice, you won't be able to edit this appointment.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentStatusChange">
                        <i class="ri-check-line me-1"></i> Yes, Change to Paid
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Edit Modal Handler
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');

            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                editForm.action = `/appointments/${id}`;

                // Clear any previous validation errors
                editForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.getElementById('editConflictWarning').style.display = 'none';

                // Set form values
                document.getElementById('edit_customer_id').value = button.getAttribute(
                    'data-customer_id') || '';
                document.getElementById('edit_phone').value = button.getAttribute('data-phone') || '';
                document.getElementById('edit_service_id').value = button.getAttribute('data-service_id') ||
                    '';
                document.getElementById('edit_staff_id').value = button.getAttribute('data-staff_id') || '';
                document.getElementById('edit_room_id').value = button.getAttribute('data-room_id') || '';

                // Format date properly for date input (Y-m-d format)
                const appointmentDate = button.getAttribute('data-date') || '';
                document.getElementById('edit_appointment_date').value = appointmentDate;

                document.getElementById('edit_start_time').value = button.getAttribute('data-start_time') ||
                    '';
                document.getElementById('edit_end_time').value = button.getAttribute('data-end_time') || '';
                document.getElementById('edit_duration').value = button.getAttribute('data-duration') || '';
                document.getElementById('edit_amount').value = button.getAttribute('data-amount') || '';
                document.getElementById('edit_payment_method').value = button.getAttribute(
                    'data-payment_method') || 'Cash';
                document.getElementById('edit_payment_status').value = button.getAttribute(
                    'data-payment_status') || 'pending';
                document.getElementById('edit_offer_select').value = button.getAttribute('data-offer_id') ||
                    '';
                document.getElementById('edit_sleep').value = button.getAttribute('data-sleep') || '';
                document.getElementById('edit_is_member').checked = button.getAttribute('data-is_member') ==
                    '1';

                // Store original payment status
                const originalPaymentStatus = button.getAttribute('data-payment_status') || 'pending';
                editForm.setAttribute('data-original-payment-status', originalPaymentStatus);
            });

            // Payment Status Change Confirmation
            const paymentStatusConfirmModal = document.getElementById('paymentStatusConfirmModal');
            const editPaymentStatusSelect = document.getElementById('edit_payment_status');
            let pendingFormSubmit = false;

            // Handle payment status change in edit form
            if (editPaymentStatusSelect) {
                editPaymentStatusSelect.addEventListener('change', function () {
                    const newStatus = this.value;
                    const originalStatus = editForm.getAttribute('data-original-payment-status') ||
                        'pending';

                    // If changing to "paid" from any other status, mark for confirmation
                    if (newStatus === 'paid' && originalStatus !== 'paid') {
                        pendingFormSubmit = true;
                    } else {
                        pendingFormSubmit = false;
                    }
                });
            }

            // Comprehensive JavaScript Validation Function for Edit Form
            function validateEditForm() {
                let isValid = true;
                const errors = {};

                // Clear previous validation
                editForm.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                editForm.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });
                document.getElementById('editFormErrors').style.display = 'none';
                document.getElementById('editErrorList').innerHTML = '';

                // Customer validation
                const customerIdEl = document.getElementById('edit_customer_id');
                const customerId = customerIdEl.value;
                if (!customerId) {
                    errors.customer_id = ['Customer is required.'];
                    setFieldError(customerIdEl, 'Customer is required.');
                    isValid = false;
                } else {
                    clearFieldError(customerIdEl);
                }

                // Phone validation
                const phoneEl = document.getElementById('edit_phone');
                const phone = phoneEl.value.trim();
                if (!phone) {
                    errors.phone = ['Phone number is required.'];
                    setFieldError(phoneEl, 'Phone number is required.');
                    isValid = false;
                } else if (phone.length > 20) {
                    errors.phone = ['Phone number must not exceed 20 characters.'];
                    setFieldError(phoneEl, 'Phone number must not exceed 20 characters.');
                    isValid = false;
                } else {
                    clearFieldError(phoneEl);
                }

                // Service validation
                const serviceIdEl = document.getElementById('edit_service_id');
                const serviceId = serviceIdEl.value;
                if (!serviceId) {
                    errors.service_id = ['Service is required.'];
                    setFieldError(serviceIdEl, 'Service is required.');
                    isValid = false;
                } else {
                    clearFieldError(serviceIdEl);
                }

                // Staff validation
                const staffIdEl = document.getElementById('edit_staff_id');
                const staffId = staffIdEl.value;
                if (!staffId) {
                    errors.staff_id = ['Staff is required.'];
                    setFieldError(staffIdEl, 'Staff is required.');
                    isValid = false;
                } else {
                    clearFieldError(staffIdEl);
                }

                // Room validation
                const roomIdEl = document.getElementById('edit_room_id');
                const roomId = roomIdEl.value;
                if (!roomId) {
                    errors.room_id = ['Room is required.'];
                    setFieldError(roomIdEl, 'Room is required.');
                    isValid = false;
                } else {
                    clearFieldError(roomIdEl);
                }

                // Appointment date validation
                const appointmentDateEl = document.getElementById('edit_appointment_date');
                const appointmentDate = appointmentDateEl.value;
                if (!appointmentDate) {
                    errors.appointment_date = ['Appointment date is required.'];
                    setFieldError(appointmentDateEl, 'Appointment date is required.');
                    isValid = false;
                } else {
                    clearFieldError(appointmentDateEl);
                }

                // Start time validation
                const startTimeEl = document.getElementById('edit_start_time');
                const startTime = startTimeEl.value;
                if (!startTime) {
                    errors.start_time = ['Start time is required.'];
                    setFieldError(startTimeEl, 'Start time is required.');
                    isValid = false;
                } else {
                    clearFieldError(startTimeEl);
                }

                // End time validation
                const endTimeEl = document.getElementById('edit_end_time');
                const endTime = endTimeEl.value;
                if (!endTime) {
                    errors.end_time = ['End time is required.'];
                    setFieldError(endTimeEl, 'End time is required.');
                    isValid = false;
                } else if (startTime && endTime && endTime <= startTime) {
                    errors.end_time = ['End time must be after start time.'];
                    setFieldError(endTimeEl, 'End time must be after start time.');
                    isValid = false;
                } else {
                    clearFieldError(endTimeEl);
                }

                // Amount validation
                const amountEl = document.getElementById('edit_amount');
                const amount = amountEl.value;
                if (!amount || parseFloat(amount) < 0) {
                    errors.amount = ['Amount is required and must be greater than or equal to 0.'];
                    setFieldError(amountEl, 'Amount is required and must be greater than or equal to 0.');
                    isValid = false;
                } else {
                    clearFieldError(amountEl);
                }

                // Payment status validation
                const paymentStatus = editPaymentStatusSelect ? editPaymentStatusSelect.value : '';
                if (!paymentStatus) {
                    errors.payment_status = ['Payment status is required.'];
                    if (editPaymentStatusSelect) {
                        setFieldError(editPaymentStatusSelect, 'Payment status is required.');
                    }
                    isValid = false;
                } else if (editPaymentStatusSelect) {
                    clearFieldError(editPaymentStatusSelect);
                }

                // Hide top error display (errors are shown below each field)
                document.getElementById('editFormErrors').style.display = 'none';

                // Scroll to first error if validation failed
                if (!isValid) {
                    const firstError = editForm.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                }

                return isValid;
            }

            // Intercept edit form submission
            if (editForm) {
                editForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const currentStatus = editPaymentStatusSelect ? editPaymentStatusSelect.value :
                        'pending';
                    const originalStatus = editForm.getAttribute('data-original-payment-status') ||
                        'pending';

                    // If changing to "paid" from any other status, show confirmation first
                    if (currentStatus === 'paid' && originalStatus !== 'paid' && pendingFormSubmit) {
                        // Show confirmation modal
                        const modal = new bootstrap.Modal(paymentStatusConfirmModal);
                        modal.show();
                        return false;
                    }

                    // First validate with JavaScript
                    if (!validateEditForm()) {
                        return false;
                    }

                    // Disable submit button
                    const submitBtn = editForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="ri-loader-4-line spin me-1"></i> Updating...';

                    // Prepare form data
                    const formData = new FormData(editForm);

                    // AJAX submission
                    fetch(editForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            return response.json().then(data => ({
                                status: response.status,
                                data: data
                            }));
                        })
                        .then(result => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;

                            if (result.status === 200 && result.data.success) {
                                // Show success message
                                if (typeof showToast === 'function') {
                                    showToast('success', result.data.message);
                                }

                                // Close modal
                                const modal = bootstrap.Modal.getInstance(editModal);
                                if (modal) {
                                    modal.hide();
                                }

                                // Reload page to show updated appointment
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            } else if (result.status === 422) {
                                // Validation errors
                                if (result.data.errors) {
                                    displayValidationErrors(result.data.errors, 'editForm');
                                } else if (result.data.message) {
                                    if (typeof showToast === 'function') {
                                        showToast('error', result.data.message);
                                    }
                                }
                            } else {
                                // Other errors
                                if (typeof showToast === 'function') {
                                    showToast('error', result.data.message ||
                                        'An error occurred. Please try again.');
                                }
                            }
                        })
                        .catch(error => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;

                            if (typeof showToast === 'function') {
                                showToast('error',
                                    'Network error. Please check your connection and try again.');
                            }
                            console.error('Error:', error);
                        });
                });
            }

            // Confirm payment status change
            const confirmPaymentBtn = document.getElementById('confirmPaymentStatusChange');
            if (confirmPaymentBtn) {
                confirmPaymentBtn.addEventListener('click', function () {
                    // Close confirmation modal
                    const modal = bootstrap.Modal.getInstance(paymentStatusConfirmModal);
                    if (modal) {
                        modal.hide();
                    }

                    // Validate and submit the form via AJAX
                    if (editForm && pendingFormSubmit) {
                        pendingFormSubmit = false;

                        // Validate first
                        if (!validateEditForm()) {
                            return false;
                        }

                        // Disable submit button
                        const submitBtn = editForm.querySelector('button[type="submit"]');
                        const originalBtnText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="ri-loader-4-line spin me-1"></i> Updating...';

                        // Prepare form data
                        const formData = new FormData(editForm);

                        // AJAX submission
                        fetch(editForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => {
                                return response.json().then(data => ({
                                    status: response.status,
                                    data: data
                                }));
                            })
                            .then(result => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;

                                if (result.status === 200 && result.data.success) {
                                    // Show success message
                                    if (typeof showToast === 'function') {
                                        showToast('success', result.data.message);
                                    }

                                    // Close modals
                                    const editModalInstance = bootstrap.Modal.getInstance(editModal);
                                    if (editModalInstance) {
                                        editModalInstance.hide();
                                    }

                                    // Reload page
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 500);
                                } else if (result.status === 422) {
                                    // Validation errors
                                    if (result.data.errors) {
                                        displayValidationErrors(result.data.errors, 'editForm');
                                    } else if (result.data.message) {
                                        if (typeof showToast === 'function') {
                                            showToast('error', result.data.message);
                                        }
                                    }
                                } else {
                                    // Other errors
                                    if (typeof showToast === 'function') {
                                        showToast('error', result.data.message ||
                                            'An error occurred. Please try again.');
                                    }
                                }
                            })
                            .catch(error => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;

                                if (typeof showToast === 'function') {
                                    showToast('error',
                                        'Network error. Please check your connection and try again.'
                                    );
                                }
                                console.error('Error:', error);
                            });
                    }
                });
            }

            // Reset pending submit when confirmation modal is closed without confirmation
            if (paymentStatusConfirmModal) {
                paymentStatusConfirmModal.addEventListener('hidden.bs.modal', function () {
                    if (pendingFormSubmit) {
                        // Revert payment status to original
                        const originalStatus = editForm.getAttribute('data-original-payment-status') ||
                            'pending';
                        if (editPaymentStatusSelect) {
                            editPaymentStatusSelect.value = originalStatus;
                        }
                        pendingFormSubmit = false;
                    }
                });
            }

            // Reset edit form when modal is hidden
            editModal.addEventListener('hidden.bs.modal', function () {
                editForm.reset();
                editForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.getElementById('editConflictWarning').style.display = 'none';
                document.getElementById('editRoomAvailabilityStatus').style.display = 'none';
                document.getElementById('editRoomAvailabilityStatus').innerHTML = '';
            });

            // Create Modal Customer Logic
            const customerSelect = document.getElementById('customer_select');
            const newCustNameDiv = document.getElementById('new_cust_name_div');
            const newCustEmailDiv = document.getElementById('new_cust_email_div');
            const customerPhone = document.getElementById('customer_phone');
            const newCustomerName = document.getElementById('new_customer_name');
            const newCustomerEmail = document.getElementById('new_customer_email');
            const isMemberSwitch = document.getElementById('isMemberSwitch');

            // Payment status change handler
            const paymentStatusSelect = document.getElementById('payment_status');

            function updateCustomerNameRequirement() {
                const paymentStatus = paymentStatusSelect.value;
                const customerId = customerSelect.value;

                // Logic simplified: just manage visibility if needed, or do nothing for 'required' attribute
                if (paymentStatus === 'paid' || customerId === '') {
                    newCustNameDiv.style.display = 'block';
                }
            }

            paymentStatusSelect.addEventListener('change', updateCustomerNameRequirement);

            customerSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value === "") {
                    newCustNameDiv.style.display = 'block';
                    newCustEmailDiv.style.display = 'block';
                    newCustomerName.required = true;
                    customerPhone.value = "";
                    isMemberSwitch.checked = false;
                    // Hide member wallet info
                    document.getElementById('memberWalletInfo').style.display = 'none';
                    // Clear member wallet data
                    window.memberWalletBalance = 0;
                    calculateFinalAmount();
                } else {
                    newCustNameDiv.style.display = 'none';
                    newCustEmailDiv.style.display = 'none';
                    // Check if payment status requires customer name
                    const paymentStatus = paymentStatusSelect.value;
                    newCustomerName.required = paymentStatus === 'paid';

                    customerPhone.value = selectedOption.getAttribute('data-phone') || "";
                    newCustomerEmail.value = selectedOption.getAttribute('data-email') || "";
                    const isMember = selectedOption.getAttribute('data-type') === 'member';
                    isMemberSwitch.checked = isMember;

                    // Handle member wallet display
                    const memberWalletBalance = parseFloat(selectedOption.getAttribute('data-balance') ||
                        0);
                    window.memberWalletBalance = isMember ? memberWalletBalance : 0;

                    if (isMember && memberWalletBalance > 0) {
                        document.getElementById('memberWalletInfo').style.display = 'block';
                        document.getElementById('memberBalance').textContent = '₹' + memberWalletBalance
                            .toFixed(2);
                    } else {
                        document.getElementById('memberWalletInfo').style.display = 'none';
                    }
                    calculateFinalAmount();
                }

                // Update customer name requirement based on payment status
                updateCustomerNameRequirement();
            });

            // Service selection - auto-fill price and duration
            const serviceSelect = document.getElementById('service_select');
            const amountInput = document.getElementById('amount');
            const durationInput = document.getElementById('duration');

            serviceSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const duration = selectedOption.getAttribute('data-duration');
                    if (price) {
                        window.serviceAmount = parseFloat(price);
                        amountInput.value = price;
                    }
                    if (duration) durationInput.value = duration;
                    calculateFinalAmount();
                } else {
                    window.serviceAmount = 0;
                    amountInput.value = '';
                    calculateFinalAmount();
                }
            });

            // Offer selection - calculate discount
            const offerSelect = document.getElementById('offer_select');
            offerSelect.addEventListener('change', function () {
                calculateFinalAmount();
            });

            // Initialize service amount
            window.serviceAmount = 0;
            window.memberWalletBalance = 0;

            // Create Modal - Reset form when opened
            const createModal = document.getElementById('createModal');
            const createForm = document.getElementById('createForm');

            createModal.addEventListener('show.bs.modal', function () {
                // Reset form
                createForm.reset();

                // Clear validation errors
                createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.getElementById('conflictWarning').style.display = 'none';
                document.getElementById('roomAvailabilityStatus').style.display = 'none';
                document.getElementById('roomAvailabilityStatus').innerHTML = '';

                // Reset calculation variables
                window.serviceAmount = 0;
                window.memberWalletBalance = 0;

                // Reset UI elements
                document.getElementById('memberWalletInfo').style.display = 'none';
                document.getElementById('amountBreakdown').style.display = 'none';

                // Reset form fields to defaults
                document.getElementById('appointment_date').value = new Date().toISOString().split('T')[0];
                document.getElementById('appointment_date').min = new Date().toISOString().split('T')[0];
                document.getElementById('isMemberSwitch').checked = false;
                document.getElementById('customer_select').value = '';
                document.getElementById('payment_status').value = 'pending';
                document.getElementById('new_cust_name_div').style.display = 'block';
                document.getElementById('new_cust_email_div').style.display = 'block';
                document.getElementById('new_customer_name').classList.remove('is-invalid');

                // Update customer name requirement
                updateCustomerNameRequirement();

                // Recalculate
                calculateFinalAmount();
            });

            // Reset create form when modal is hidden
            createModal.addEventListener('hidden.bs.modal', function () {
                createForm.reset();
                createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.getElementById('conflictWarning').style.display = 'none';
                document.getElementById('roomAvailabilityStatus').style.display = 'none';
                document.getElementById('roomAvailabilityStatus').innerHTML = '';
                document.getElementById('memberWalletInfo').style.display = 'none';
                document.getElementById('amountBreakdown').style.display = 'none';
                window.serviceAmount = 0;
                window.memberWalletBalance = 0;
            });

            // Helper functions to set and clear field errors
            function setFieldError(fieldElement, errorMessage) {
                if (!fieldElement) return;

                fieldElement.classList.add('is-invalid');
                fieldElement.classList.remove('is-valid');

                // Find or create invalid-feedback element
                let feedback = fieldElement.nextElementSibling;
                if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                    // Look in parent for invalid-feedback
                    const parent = fieldElement.parentElement;
                    feedback = parent.querySelector('.invalid-feedback');
                    if (!feedback) {
                        // Create invalid-feedback if it doesn't exist
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        fieldElement.parentNode.insertBefore(feedback, fieldElement.nextSibling);
                    }
                }

                if (feedback) {
                    feedback.textContent = errorMessage;
                }
            }

            function clearFieldError(fieldElement) {
                if (!fieldElement) return;

                fieldElement.classList.remove('is-invalid');
                const feedback = fieldElement.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }

            // Comprehensive JavaScript Validation Function
            function validateCreateForm() {
                let isValid = true;
                const errors = {};

                // Clear previous validation
                createForm.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                createForm.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });
                document.getElementById('createFormErrors').style.display = 'none';
                document.getElementById('createErrorList').innerHTML = '';

                // Phone validation
                const phone = customerPhone.value.trim();
                if (!phone) {
                    errors.phone = ['Phone number is required.'];
                    customerPhone.classList.add('is-invalid');
                    setFieldError(customerPhone, 'Phone number is required.');
                    isValid = false;
                } else if (phone.length > 20) {
                    errors.phone = ['Phone number must not exceed 20 characters.'];
                    customerPhone.classList.add('is-invalid');
                    setFieldError(customerPhone, 'Phone number must not exceed 20 characters.');
                    isValid = false;
                } else {
                    clearFieldError(customerPhone);
                }

                // Customer name validation
                const paymentStatus = paymentStatusSelect.value;
                const customerId = customerSelect.value;
                const customerName = newCustomerName.value.trim();

                if ((paymentStatus === 'paid' || customerId === '') && !customerName) {
                    const errorMsg = paymentStatus === 'paid' ?
                        'Customer name is required when payment status is paid.' :
                        'Customer name is required.';
                    errors.customer_name = [errorMsg];
                    setFieldError(newCustomerName, errorMsg);
                    isValid = false;
                } else {
                    clearFieldError(newCustomerName);
                }

                // Service validation
                const serviceId = serviceSelect.value;
                if (!serviceId) {
                    errors.service_id = ['Service is required.'];
                    setFieldError(serviceSelect, 'Service is required.');
                    isValid = false;
                } else {
                    clearFieldError(serviceSelect);
                }

                // Staff validation
                const staffId = staffSelect.value;
                if (!staffId) {
                    errors.staff_id = ['Staff is required.'];
                    setFieldError(staffSelect, 'Staff is required.');
                    isValid = false;
                } else {
                    clearFieldError(staffSelect);
                }

                // Room validation
                const roomId = roomSelect.value;
                if (!roomId) {
                    errors.room_id = ['Room is required.'];
                    setFieldError(roomSelect, 'Room is required.');
                    isValid = false;
                } else {
                    clearFieldError(roomSelect);
                }

                // Appointment date validation
                const appointmentDateEl = document.getElementById('appointment_date');
                const appointmentDate = appointmentDateEl.value;
                if (!appointmentDate) {
                    errors.appointment_date = ['Appointment date is required.'];
                    setFieldError(appointmentDateEl, 'Appointment date is required.');
                    isValid = false;
                } else {
                    const selectedDate = new Date(appointmentDate);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    if (selectedDate < today) {
                        errors.appointment_date = ['Appointment date must be today or later.'];
                        setFieldError(appointmentDateEl, 'Appointment date must be today or later.');
                        isValid = false;
                    } else {
                        clearFieldError(appointmentDateEl);
                    }
                }

                // Start time validation
                const startTimeEl = document.getElementById('start_time');
                const startTime = startTimeEl.value;
                if (!startTime) {
                    errors.start_time = ['Start time is required.'];
                    setFieldError(startTimeEl, 'Start time is required.');
                    isValid = false;
                } else {
                    clearFieldError(startTimeEl);
                }

                // End time validation
                const endTimeEl = document.getElementById('end_time');
                const endTime = endTimeEl.value;
                if (!endTime) {
                    errors.end_time = ['End time is required.'];
                    setFieldError(endTimeEl, 'End time is required.');
                    isValid = false;
                } else if (startTime && endTime && endTime <= startTime) {
                    errors.end_time = ['End time must be after start time.'];
                    setFieldError(endTimeEl, 'End time must be after start time.');
                    isValid = false;
                } else {
                    clearFieldError(endTimeEl);
                }

                // Amount validation
                const amount = amountInput.value;
                if (!amount || parseFloat(amount) < 0) {
                    errors.amount = ['Amount is required and must be greater than or equal to 0.'];
                    setFieldError(amountInput, 'Amount is required and must be greater than or equal to 0.');
                    isValid = false;
                } else {
                    clearFieldError(amountInput);
                }

                // Payment status validation
                if (!paymentStatus) {
                    errors.payment_status = ['Payment status is required.'];
                    setFieldError(paymentStatusSelect, 'Payment status is required.');
                    isValid = false;
                } else {
                    clearFieldError(paymentStatusSelect);
                }

                // Customer email validation (if provided)
                const customerEmail = newCustomerEmail.value.trim();
                if (customerEmail && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(customerEmail)) {
                    errors.customer_email = ['Please enter a valid email address.'];
                    setFieldError(newCustomerEmail, 'Please enter a valid email address.');
                    isValid = false;
                } else if (customerEmail) {
                    clearFieldError(newCustomerEmail);
                }

                // Hide top error display (errors are shown below each field)
                document.getElementById('createFormErrors').style.display = 'none';

                // Scroll to first error if validation failed
                if (!isValid) {
                    const firstError = createForm.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                }

                return isValid;
            }

            // Function to display validation errors from server (show below each field)
            function displayValidationErrors(errors, formType) {
                const form = formType === 'createForm' ? createForm : editForm;
                const errorDisplay = document.getElementById(formType === 'createForm' ? 'createFormErrors' :
                    'editFormErrors');

                // Clear previous errors
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });

                // Display errors below each field
                Object.keys(errors).forEach(field => {
                    const fieldElement = form.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        const errorMsg = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                        setFieldError(fieldElement, errorMsg);
                    }
                });

                // Hide top error display
                if (errorDisplay) {
                    errorDisplay.style.display = 'none';
                }

                // Scroll to first error
                const firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }

            // AJAX Form Submission for Create
            createForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // First validate with JavaScript
                if (!validateCreateForm()) {
                    return false;
                }

                // Disable submit button
                const submitBtn = createForm.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line spin me-1"></i> Creating...';

                // Prepare form data
                const formData = new FormData(createForm);

                // AJAX submission
                fetch(createForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        return response.json().then(data => ({
                            status: response.status,
                            data: data
                        }));
                    })
                    .then(result => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        if (result.status === 200 && result.data.success) {
                            // Show success message
                            if (typeof showToast === 'function') {
                                showToast('success', result.data.message);
                            }

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(createModal);
                            if (modal) {
                                modal.hide();
                            }

                            // Reload page to show new appointment
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        } else if (result.status === 422) {
                            // Validation errors
                            if (result.data.errors) {
                                displayValidationErrors(result.data.errors, 'createForm');
                            } else if (result.data.message) {
                                if (typeof showToast === 'function') {
                                    showToast('error', result.data.message);
                                }
                            }
                        } else {
                            // Other errors
                            if (typeof showToast === 'function') {
                                showToast('error', result.data.message ||
                                    'An error occurred. Please try again.');
                            }
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        if (typeof showToast === 'function') {
                            showToast('error',
                                'Network error. Please check your connection and try again.');
                        }
                        console.error('Error:', error);
                    });
            });

            // Function to calculate final amount
            function calculateFinalAmount() {
                const serviceAmount = window.serviceAmount || 0;
                const memberBalance = window.memberWalletBalance || 0;
                const offerSelect = document.getElementById('offer_select');
                const selectedOfferOption = offerSelect.options[offerSelect.selectedIndex];

                // Calculate offer discount
                let offerDiscount = 0;
                if (selectedOfferOption.value) {
                    const discountType = selectedOfferOption.getAttribute('data-discount-type');
                    const discountValue = parseFloat(selectedOfferOption.getAttribute('data-discount-value') || 0);

                    if (discountType === 'percentage') {
                        offerDiscount = (serviceAmount * discountValue) / 100;
                    } else {
                        offerDiscount = discountValue;
                    }
                }

                // Calculate amounts after offer discount
                let amountAfterOffer = serviceAmount - offerDiscount;
                if (amountAfterOffer < 0) amountAfterOffer = 0;

                // Calculate wallet usage (can only use up to remaining amount after offer)
                let walletUsed = 0;
                if (memberBalance > 0 && amountAfterOffer > 0) {
                    walletUsed = Math.min(memberBalance, amountAfterOffer);
                }

                // Calculate final amount
                const finalAmount = amountAfterOffer - walletUsed;
                const remainingBalance = memberBalance - walletUsed;

                // Update display
                document.getElementById('serviceAmount').textContent = '₹' + serviceAmount.toFixed(2);
                document.getElementById('offerDiscount').textContent = '-₹' + offerDiscount.toFixed(2);
                document.getElementById('walletUsed').textContent = '-₹' + walletUsed.toFixed(2);
                document.getElementById('finalAmount').textContent = '₹' + (finalAmount >= 0 ? finalAmount.toFixed(
                    2) : '0.00');

                // Show/hide breakdown
                if (serviceAmount > 0 || offerDiscount > 0 || walletUsed > 0) {
                    document.getElementById('amountBreakdown').style.display = 'block';
                } else {
                    document.getElementById('amountBreakdown').style.display = 'none';
                }

                // Show remaining balance if member and wallet used
                if (memberBalance > 0 && walletUsed > 0) {
                    document.getElementById('remainingBalanceDiv').style.display = 'block';
                    document.getElementById('remainingBalance').textContent = '₹' + remainingBalance.toFixed(2);
                } else {
                    document.getElementById('remainingBalanceDiv').style.display = 'none';
                }

                // Update amount input (this will be the final payable amount)
                if (amountInput && finalAmount >= 0) {
                    amountInput.value = finalAmount.toFixed(2);
                }
            }

            // Room availability checking
            const appointmentDate = document.getElementById('appointment_date');
            const staffSelect = document.getElementById('staff_select');
            const roomSelect = document.getElementById('room_select');
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');
            const conflictWarning = document.getElementById('conflictWarning');
            const roomAvailabilityStatus = document.getElementById('roomAvailabilityStatus');
            const availableRoomsCount = document.getElementById('availableRoomsCount');
            const availableRoomsText = document.getElementById('availableRoomsText');

            let roomAvailabilityData = null;

            function checkRoomAvailability() {
                const date = appointmentDate.value;
                const start = startTime.value;
                const end = endTime.value;

                if (date && start && end) {
                    // Show loading
                    roomAvailabilityStatus.innerHTML =
                        '<small class="text-info"><i class="ri-loader-4-line spin"></i> Checking availability...</small>';
                    roomAvailabilityStatus.style.display = 'block';

                    fetch(`/appointments/availability?date=${date}&start_time=${start}&end_time=${end}`)
                        .then(response => response.json())
                        .then(data => {
                            roomAvailabilityData = data;

                            // Update available rooms count card
                            availableRoomsCount.textContent = data.available_rooms.length;
                            availableRoomsText.textContent =
                                `${data.available_rooms.length} of ${data.total_rooms} rooms available`;

                            // Update room dropdown with availability status
                            updateRoomDropdown(data.available_rooms, data.unavailable_rooms);

                            // Show room availability status
                            if (data.available_rooms.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available Rooms:</strong> ';
                                statusHtml += data.available_rooms.map(r => r.name).join(', ');
                                statusHtml += '</small></div>';

                                if (data.unavailable_rooms.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Unavailable:</strong> ';
                                    statusHtml += data.unavailable_rooms.map(r => {
                                        let msg = r.name;
                                        if (r.conflict_time) msg += ` (${r.conflict_time})`;
                                        return msg;
                                    }).join(', ');
                                    statusHtml += '</small></div>';
                                }

                                roomAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                roomAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No rooms available at this time!</small></div>';
                            }

                            // Check for conflicts with selected room
                            checkSelectedRoomConflict(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            roomAvailabilityStatus.innerHTML =
                                '<small class="text-danger">Error checking availability</small>';
                        });
                } else {
                    roomAvailabilityStatus.style.display = 'none';
                    availableRoomsCount.textContent = '{{ $stats['active_rooms'] }}';
                    availableRoomsText.textContent = 'Select date & time to check';
                }
            }

            function updateRoomDropdown(availableRooms, unavailableRooms) {
                const currentValue = roomSelect.value;

                // Clear existing options except first
                while (roomSelect.options.length > 1) {
                    roomSelect.remove(1);
                }

                // Add available rooms first with green "Available" text
                availableRooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.name + ' - Available';
                    option.className = 'text-success';
                    option.setAttribute('data-available', 'true');
                    option.style.color = '#198754'; // Green color
                    roomSelect.appendChild(option);
                });

                // Add unavailable rooms with red "Booked" text
                unavailableRooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.name + ' - Booked';
                    option.className = 'text-danger';
                    option.setAttribute('data-available', 'false');
                    option.style.color = '#dc3545'; // Red color
                    option.disabled = true;
                    roomSelect.appendChild(option);
                });

                // Restore previous selection if still valid and available
                if (currentValue) {
                    const isStillAvailable = availableRooms.some(r => r.id == currentValue);
                    if (isStillAvailable) {
                        roomSelect.value = currentValue;
                    } else {
                        // If previously selected room is now unavailable, select first available or empty
                        if (availableRooms.length > 0) {
                            roomSelect.value = availableRooms[0].id;
                        } else {
                            roomSelect.value = '';
                        }
                    }
                } else if (availableRooms.length > 0) {
                    // Auto-select first available room if none was selected
                    roomSelect.value = availableRooms[0].id;
                }
            }

            function checkSelectedRoomConflict(data) {
                const selectedRoomId = roomSelect.value;
                if (!selectedRoomId) return;

                const selectedRoom = [...data.available_rooms, ...data.unavailable_rooms].find(r => r.id ==
                    selectedRoomId);

                if (selectedRoom && data.unavailable_rooms.find(r => r.id == selectedRoomId)) {
                    // Selected room is unavailable
                    conflictWarning.style.display = 'block';
                    conflictWarning.querySelector('#conflictMessage').textContent =
                        `Selected room "${selectedRoom.name}" is not available at this time. Please select an available room.`;
                    roomSelect.classList.add('is-invalid');
                } else {
                    conflictWarning.style.display = 'none';
                    roomSelect.classList.remove('is-invalid');
                }
            }

            // Check availability when date/time changes - automatically update room dropdown
            [appointmentDate, startTime, endTime].forEach(el => {
                if (el) {
                    el.addEventListener('change', function () {
                        // Small delay to ensure all values are set
                        setTimeout(checkRoomAvailability, 100);
                    });
                }
            });

            // Also check on input event for real-time updates
            [startTime, endTime].forEach(el => {
                if (el) {
                    el.addEventListener('input', function () {
                        if (appointmentDate.value && startTime.value && endTime.value) {
                            setTimeout(checkRoomAvailability, 300); // Debounce
                        }
                    });
                }
            });

            // Check for conflicts when room is selected
            roomSelect.addEventListener('change', function () {
                if (roomAvailabilityData) {
                    checkSelectedRoomConflict(roomAvailabilityData);
                }
            });

            // Calculate duration automatically
            startTime.addEventListener('change', calculateDuration);
            endTime.addEventListener('change', calculateDuration);

            function calculateDuration() {
                if (startTime.value && endTime.value) {
                    const start = new Date('2000-01-01 ' + startTime.value);
                    const end = new Date('2000-01-01 ' + endTime.value);
                    const diff = (end - start) / 60000; // minutes
                    if (diff > 0) {
                        durationInput.value = Math.round(diff);
                    }
                }
            }

            // Edit Modal Room Availability
            const editAppointmentDate = document.getElementById('edit_appointment_date');
            const editStartTime = document.getElementById('edit_start_time');
            const editEndTime = document.getElementById('edit_end_time');
            const editRoomSelect = document.getElementById('edit_room_id');
            const editRoomAvailabilityStatus = document.getElementById('editRoomAvailabilityStatus');
            let editRoomAvailabilityData = null;

            function checkEditRoomAvailability() {
                const date = editAppointmentDate.value;
                const start = editStartTime.value;
                const end = editEndTime.value;
                const formAction = document.getElementById('editForm')?.action;
                const appointmentId = formAction ? formAction.match(/\/appointments\/(\d+)/)?.[1] : null;

                if (date && start && end) {
                    editRoomAvailabilityStatus.innerHTML =
                        '<small class="text-info"><i class="ri-loader-4-line spin"></i> Checking availability...</small>';
                    editRoomAvailabilityStatus.style.display = 'block';

                    fetch(
                        `/appointments/availability?date=${date}&start_time=${start}&end_time=${end}&exclude_appointment_id=${appointmentId || ''}`
                    )
                        .then(response => response.json())
                        .then(data => {
                            editRoomAvailabilityData = data;

                            // Update room dropdown
                            updateEditRoomDropdown(data.available_rooms, data.unavailable_rooms);

                            // Show status
                            if (data.available_rooms.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available:</strong> ';
                                statusHtml += data.available_rooms.map(r => r.name).join(', ');
                                statusHtml += '</small></div>';

                                if (data.unavailable_rooms.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Unavailable:</strong> ';
                                    statusHtml += data.unavailable_rooms.map(r => {
                                        let msg = r.name;
                                        if (r.conflict_time) msg += ` (${r.conflict_time})`;
                                        return msg;
                                    }).join(', ');
                                    statusHtml += '</small></div>';
                                }

                                editRoomAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                editRoomAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No rooms available!</small></div>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            editRoomAvailabilityStatus.innerHTML =
                                '<small class="text-danger">Error checking availability</small>';
                        });
                } else {
                    editRoomAvailabilityStatus.style.display = 'none';
                }
            }

            function updateEditRoomDropdown(availableRooms, unavailableRooms) {
                const currentValue = editRoomSelect.value;

                while (editRoomSelect.options.length > 1) {
                    editRoomSelect.remove(1);
                }

                // Add available rooms first with green "Available" text
                availableRooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.name + ' - Available';
                    option.className = 'text-success';
                    option.style.color = '#198754'; // Green color
                    editRoomSelect.appendChild(option);
                });

                // Add unavailable rooms with red "Booked" text
                unavailableRooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.name + ' - Booked';
                    option.className = 'text-danger';
                    option.style.color = '#dc3545'; // Red color
                    option.disabled = true;
                    editRoomSelect.appendChild(option);
                });

                // Restore previous selection if still valid and available
                if (currentValue) {
                    const isStillAvailable = availableRooms.some(r => r.id == currentValue);
                    if (isStillAvailable) {
                        editRoomSelect.value = currentValue;
                    } else {
                        // If previously selected room is now unavailable, select first available or keep current
                        if (availableRooms.length > 0) {
                            editRoomSelect.value = availableRooms[0].id;
                        }
                    }
                } else if (availableRooms.length > 0) {
                    // Auto-select first available room if none was selected
                    editRoomSelect.value = availableRooms[0].id;
                }
            }

            // Check availability when date/time changes in edit modal
            [editAppointmentDate, editStartTime, editEndTime].forEach(el => {
                if (el) {
                    el.addEventListener('change', function () {
                        setTimeout(checkEditRoomAvailability, 100);
                    });
                }
            });

            // Also check on input event for real-time updates in edit modal
            [editStartTime, editEndTime].forEach(el => {
                if (el) {
                    el.addEventListener('input', function () {
                        if (editAppointmentDate.value && editStartTime.value && editEndTime.value) {
                            setTimeout(checkEditRoomAvailability, 300); // Debounce
                        }
                    });
                }
            });

            // Note: Modal reset handlers are already set above for createModal and editModal
        });
    </script>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        /* Style for available rooms in dropdown */
        select option.text-success {
            color: #198754 !important;
            font-weight: 500;
        }

        /* Style for booked rooms in dropdown */
        select option.text-danger {
            color: #dc3545 !important;
            font-weight: 500;
        }

        /* Ensure colors are visible in select dropdown */
        #room_select option[data-available="true"],
        #edit_room_id option[data-available="true"] {
            color: #198754 !important;
        }

        #room_select option[data-available="false"],
        #edit_room_id option[data-available="false"] {
            color: #dc3545 !important;
        }
    </style>
@endpush