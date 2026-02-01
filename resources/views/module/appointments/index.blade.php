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

                                                @if (!$appointment->invoice && Auth::user()->isAdmin())
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
                                                @if (Auth::user()->isAdmin())
                                                    <li class="list-inline-item">
                                                        <button type="button" class="btn btn-sm btn-soft-danger remove-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#deleteRecordModal"
                                                            data-action="{{ route('appointments.destroy', $appointment->id) }}"
                                                            data-message="Are you sure you want to delete this appointment?"
                                                            title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </li>
                                                @endif
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
                        <div class="pagination-wrapper">
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
                            <!-- Customer Selection Section -->
                            <div class="col-lg-12">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-user-heart-line me-2 align-middle text-primary"></i>1. Customer
                                            Information</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <!-- Customer Type Selection -->
                                            <div class="col-lg-12">
                                                <div class="p-2 border rounded bg-light-subtle mb-3">
                                                    <label class="form-label d-block mb-2 fw-semibold">Are you booking for
                                                        an Existing or New Customer?</label>
                                                    <div class="d-flex gap-4">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input border-primary" type="radio"
                                                                name="customer_type_radio" id="existing_customer_radio"
                                                                value="existing">
                                                            <label class="form-check-label fw-medium"
                                                                for="existing_customer_radio">
                                                                <i class="ri-user-search-line me-1"></i> Existing Customer
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input border-primary" type="radio"
                                                                name="customer_type_radio" id="new_customer_radio"
                                                                value="new">
                                                            <label class="form-check-label fw-medium"
                                                                for="new_customer_radio">
                                                                <i class="ri-user-add-line me-1"></i> New Customer
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Existing Customer Sub-Type (shown when Existing Customer is selected) -->
                                            <div class="col-lg-12" id="existing_customer_type_div" style="display: block;">
                                                <div class="p-2 border border-dashed rounded mb-3">
                                                    <label class="form-label d-block mb-2 text-muted">Filter customer by
                                                        type:</label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="existing_customer_type_radio"
                                                                id="customer_type_normal" value="customer">
                                                            <label class="form-check-label" for="customer_type_normal">
                                                                Standard Customer
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="existing_customer_type_radio"
                                                                id="customer_type_member" value="member">
                                                            <label class="form-check-label text-primary fw-medium"
                                                                for="customer_type_member">
                                                                <i class="ri-vip-crown-line me-1"></i> Member Customer
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Fields Container -->
                                            <div class="col-lg-12">
                                                <div class="row g-3">
                                                    <!-- Existing Customer Select Dropdown -->
                                                    <div class="col-lg-6" id="existing_customer_select_div"
                                                        style="display: block;">
                                                        <label class="form-label fw-semibold">Search Registered
                                                            Customer</label>
                                                        <select name="customer_id" id="customer_select"
                                                            class="form-select border-info shadow-none">
                                                            <option value="">-- Start typing or select --</option>
                                                            @foreach ($customers as $c)
                                                                <option value="{{ $c->id }}" data-name="{{ $c->name }}"
                                                                    data-phone="{{ $c->phone }}" data-email="{{ $c->email }}"
                                                                    data-type="{{ $c->customer_type }}"
                                                                    data-balance="{{ $c->wallet->balance ?? 0 }}">
                                                                    {{ $c->name }}
                                                                    @if ($c->customer_type == 'member')
                                                                        (Member - Balance:
                                                                        ₹{{ number_format($c->wallet->balance ?? 0, 2) }})
                                                                    @else
                                                                        (Normal)
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- New Customer Add Icon Button (shown when New Customer is selected) -->
                                                    <div class="col-lg-6" id="new_customer_add_icon_div"
                                                        style="display: none;">
                                                        <label class="form-label d-block text-muted">Create Profile
                                                            First?</label>
                                                        <button type="button" class="btn btn-outline-primary w-100"
                                                            id="add_new_customer_btn">
                                                            <i class="ri-user-add-line align-bottom me-1"></i> Register New
                                                            Customer Profile
                                                        </button>
                                                    </div>

                                                    <!-- New Customer Fields -->
                                                    <div class="col-lg-6" id="new_cust_name_div" style="display: block;">
                                                        <label class="form-label fw-semibold">Customer Full Name <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i
                                                                    class="ri-user-line text-primary"></i></span>
                                                            <input type="text" name="customer_name" id="new_customer_name"
                                                                class="form-control" placeholder="Enter customer name">
                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="col-lg-6" id="new_cust_email_div" style="display: block;">
                                                        <label class="form-label">Email Address <span
                                                                class="text-muted small">(Optional)</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i
                                                                    class="ri-mail-line text-muted"></i></span>
                                                            <input type="email" name="customer_email"
                                                                id="new_customer_email" class="form-control"
                                                                placeholder="Enter email address">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label class="form-label fw-semibold">Contact Phone Number <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i
                                                                    class="ri-phone-line text-success"></i></span>
                                                            <input type="text" name="phone" id="customer_phone"
                                                                class="form-control" placeholder="Enter phone number">
                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Details Section -->
                            <div class="col-lg-12 mt-2">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-calendar-event-line me-2 align-middle text-info"></i>2.
                                            Appointment Details</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Service (Therapy) <span
                                                        class="text-danger">*</span></label>
                                                <select name="service_id" id="service_select"
                                                    class="form-select border-info-subtle">
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
                                                <select name="staff_id" id="staff_select"
                                                    class="form-select border-info-subtle">
                                                    <option value="">Select Staff</option>
                                                    @foreach ($staff as $st)
                                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="staffAvailabilityStatus" class="mt-2" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Room <span class="text-danger">*</span></label>
                                                <select name="room_id" id="room_select"
                                                    class="form-select border-info-subtle">
                                                    <option value="">Select Room</option>
                                                    @foreach ($rooms as $r)
                                                        <option value="{{ $r->id }}" data-room-name="{{ $r->name }}">
                                                            {{ $r->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div id="roomAvailabilityStatus" class="mt-2" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-calendar-line"></i></span>
                                                    <input type="date" name="appointment_date" id="appointment_date"
                                                        class="form-control" value="{{ date('Y-m-d') }}"
                                                        min="{{ date('Y-m-d') }}">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Time In <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-history-line"></i></span>
                                                    <input type="time" name="start_time" id="start_time"
                                                        class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Time Out <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-time-line"></i></span>
                                                    <input type="time" name="end_time" id="end_time" class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Duration</label>
                                                <div class="input-group">
                                                    <input type="number" name="duration" id="duration"
                                                        class="form-control bg-light" placeholder="Auto" min="1" readonly>
                                                    <span class="input-group-text">Min</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Net Amount (₹) <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success-subtle text-success">₹</span>
                                                    <input type="number" step="0.01" name="amount" id="amount"
                                                        class="form-control bg-light fw-bold" placeholder="0.00" min="0"
                                                        readonly>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label text-success">Offer Tag</label>
                                                <select name="offer_id" id="offer_select"
                                                    class="form-select border-success-subtle">
                                                    <option value="">-- No Offer --</option>
                                                    @foreach ($offers as $offer)
                                                        <option value="{{ $offer->id }}"
                                                            data-discount-type="{{ $offer->discount_type }}"
                                                            data-discount-value="{{ $offer->discount_value }}">
                                                            {{ $offer->name }}
                                                            ({{ $offer->discount_type == 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Dynamic Calculation Info -->
                                            <div class="col-lg-12">
                                                <div id="memberWalletInfo"
                                                    class="alert alert-info py-2 mb-2 shadow-sm border-info-subtle"
                                                    style="display: none;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-wallet-3-line fs-18 me-2"></i>
                                                        <span class="fw-medium">Member Balance: </span>
                                                        <span id="memberBalance" class="ms-1 fw-bold">₹0.00</span>
                                                    </div>
                                                </div>
                                                <div id="amountBreakdown"
                                                    class="card border-primary-subtle bg-primary-subtle bg-opacity-10 mb-0"
                                                    style="display: none;">
                                                    <div class="card-body p-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3 border-end">
                                                                <small
                                                                    class="text-muted d-block text-uppercase fw-semibold">Subtotal</small>
                                                                <div class="fw-bold fs-16" id="serviceAmount">₹0.00</div>
                                                            </div>
                                                            <div class="col-sm-3 border-end">
                                                                <small
                                                                    class="text-muted d-block text-uppercase fw-semibold">Wallet
                                                                    Deduction</small>
                                                                <div class="fw-bold text-danger fs-16" id="walletUsed">
                                                                    ₹0.00
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 border-end">
                                                                <small
                                                                    class="text-muted d-block text-uppercase fw-semibold">Offer
                                                                    Disc.</small>
                                                                <div class="fw-bold text-success fs-16" id="offerDiscount">
                                                                    ₹0.00</div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <small
                                                                    class="text-primary d-block text-uppercase fw-bold">Grand
                                                                    Total</small>
                                                                <div class="fw-bold text-primary fs-20" id="finalAmount">
                                                                    ₹0.00</div>
                                                            </div>
                                                            <div class="col-12 mt-2 pt-2 border-top"
                                                                id="remainingBalanceDiv" style="display: none;">
                                                                <small class="text-muted fw-medium">Remaining Wallet
                                                                    Balance
                                                                    after this booking: <span class="text-info fw-bold"
                                                                        id="remainingBalance">₹0.00</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Section Section -->
                            <div class="col-lg-12 mt-2">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-money-rupee-circle-line me-2 align-middle text-success"></i>3.
                                            Payment & Remarks</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Payment Method</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-wallet-line"></i></span>
                                                    <select name="payment_method" class="form-select shadow-none">
                                                        <option value="Cash">Cash</option>
                                                        <option value="Card">Card</option>
                                                        <option value="UPI">UPI</option>
                                                        <option value="Online">Online</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="form-label">Special Notes / Sleep Remarks</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-sticky-note-line"></i></span>
                                                    <input type="text" name="sleep" class="form-control shadow-none"
                                                        placeholder="Any specific requirements or notes...">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-check form-switch form-switch-lg mt-1">
                                                    <input class="form-check-input" type="checkbox" name="is_member"
                                                        value="1" id="isMemberSwitch">
                                                    <label class="form-check-label fw-medium ms-1" for="isMemberSwitch">Tag
                                                        as Member Transaction</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Add New Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCustomerForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="add_customer_name" class="form-control"
                                placeholder="Enter name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="add_customer_phone" class="form-control"
                                placeholder="Enter phone number (10 digits)">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email (Optional)</label>
                            <input type="email" name="email" id="add_customer_email" class="form-control"
                                placeholder="Enter email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                            <select name="customer_type" id="add_customer_type" class="form-select">
                                <option value="normal">Normal</option>
                                <option value="member">Member (Premium)</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-none" id="add_customer_wallet_balance_div">
                            <label class="form-label">Wallet Membership Amount (RS)</label>
                            <input type="number" step="0.01" name="wallet_balance" id="add_customer_wallet_balance"
                                class="form-control" placeholder="Enter initial wallet amount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Customer</button>
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
                            <!-- Customer Information Section -->
                            <div class="col-lg-12">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-user-settings-line me-2 align-middle text-primary"></i>1.
                                            Customer
                                            Information</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <label class="form-label fw-semibold">Customer <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-user-line text-primary"></i></span>
                                                    <select name="customer_id" id="edit_customer_id"
                                                        class="form-select shadow-none">
                                                        <div class="invalid-feedback"></div>
                                                        @foreach ($customers as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label fw-semibold">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-phone-line text-success"></i></span>
                                                    <input type="text" name="phone" id="edit_phone"
                                                        class="form-control shadow-none" placeholder="Contact number">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Appointment Details Section -->
                            <div class="col-lg-12 mt-2">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-calendar-event-line me-2 align-middle text-info"></i>2.
                                            Appointment Details</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Service <span
                                                        class="text-danger">*</span></label>
                                                <select name="service_id" id="edit_service_id"
                                                    class="form-select border-info-subtle">
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
                                                <label class="form-label fw-semibold">Staff <span
                                                        class="text-danger">*</span></label>
                                                <select name="staff_id" id="edit_staff_id"
                                                    class="form-select border-info-subtle">
                                                    <option value="">Select Staff</option>
                                                    @foreach ($staff as $st)
                                                        <option value="{{ $st->id }}">{{ $st->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                                <div id="editStaffAvailabilityStatus" class="mt-2" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Room <span
                                                        class="text-danger">*</span></label>
                                                <select name="room_id" id="edit_room_id"
                                                    class="form-select border-info-subtle">
                                                    <option value="">Select Room</option>
                                                    @foreach ($rooms as $r)
                                                        <option value="{{ $r->id }}" data-room-name="{{ $r->name }}">
                                                            {{ $r->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                                <div id="editRoomAvailabilityStatus" class="mt-2" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Date <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-calendar-line"></i></span>
                                                    <input type="date" name="appointment_date" id="edit_appointment_date"
                                                        class="form-control shadow-none">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Time In <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-history-line"></i></span>
                                                    <input type="time" name="start_time" id="edit_start_time"
                                                        class="form-control shadow-none">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Time Out <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-time-line"></i></span>
                                                    <input type="time" name="end_time" id="edit_end_time"
                                                        class="form-control shadow-none">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Duration</label>
                                                <div class="input-group">
                                                    <input type="number" name="duration" id="edit_duration"
                                                        class="form-control shadow-none" min="1">
                                                    <span class="input-group-text">Min</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Net Amount (₹) <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-text bg-success-subtle text-success fw-bold">₹</span>
                                                    <input type="number" step="0.01" name="amount" id="edit_amount"
                                                        class="form-control shadow-none fw-bold" min="0">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Offer Tag</label>
                                                <select name="offer_id" id="edit_offer_select"
                                                    class="form-select border-success-subtle">
                                                    <option value="">-- No Offer --</option>
                                                    @foreach ($offers as $offer)
                                                        <option value="{{ $offer->id }}"
                                                            data-discount-type="{{ $offer->discount_type }}"
                                                            data-discount-value="{{ $offer->discount_value }}">
                                                            {{ $offer->name }}
                                                            ({{ $offer->discount_type == 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Section Section -->
                            <div class="col-lg-12 mt-2">
                                <div class="card border-light shadow-none mb-0">
                                    <div class="card-header bg-light-subtle py-2">
                                        <h6 class="card-title mb-0"><i
                                                class="ri-money-rupee-circle-line me-2 align-middle text-success"></i>3.
                                            Payment & Remarks</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Payment Method</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-wallet-line text-muted"></i></span>
                                                    <select name="payment_method" id="edit_payment_method"
                                                        class="form-select shadow-none">
                                                        <option value="Cash">Cash</option>
                                                        <option value="Card">Card</option>
                                                        <option value="UPI">UPI</option>
                                                        <option value="Online">Online</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Current Audit Status <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-checkbox-circle-line text-info"></i></span>
                                                    <select name="payment_status" id="edit_payment_status"
                                                        class="form-select shadow-none">
                                                        <option value="pending">Pending</option>
                                                        <option value="paid">Paid</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-semibold">Special Notes</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="ri-sticky-note-line text-muted"></i></span>
                                                    <input type="text" name="sleep" id="edit_sleep"
                                                        class="form-control shadow-none" placeholder="Notes...">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-check form-switch form-switch-lg mt-1">
                                                    <input class="form-check-input" type="checkbox" name="is_member"
                                                        value="1" id="edit_is_member">
                                                    <label class="form-check-label fw-medium ms-1"
                                                        for="edit_is_member">Member Ledger Account Entry</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

                // Initial availability check
                setTimeout(() => {
                    if (typeof checkEditAvailability === 'function') {
                        checkEditAvailability();
                    }
                }, 200);
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
                document.getElementById('editStaffAvailabilityStatus').style.display = 'none';
                document.getElementById('editStaffAvailabilityStatus').innerHTML = '';
            });

            // Create Modal Customer Logic
            const customerSelect = document.getElementById('customer_select');
            const newCustNameDiv = document.getElementById('new_cust_name_div');
            const newCustEmailDiv = document.getElementById('new_cust_email_div');
            const customerPhone = document.getElementById('customer_phone');
            const newCustomerName = document.getElementById('new_customer_name');
            const newCustomerEmail = document.getElementById('new_customer_email');
            const isMemberSwitch = document.getElementById('isMemberSwitch');


            // Customer Type Radio Buttons
            const existingCustomerRadio = document.getElementById('existing_customer_radio');
            const newCustomerRadio = document.getElementById('new_customer_radio');
            const existingCustomerTypeDiv = document.getElementById('existing_customer_type_div');
            const existingCustomerSelectDiv = document.getElementById('existing_customer_select_div');
            const newCustomerAddIconDiv = document.getElementById('new_customer_add_icon_div');
            const customerTypeNormal = document.getElementById('customer_type_normal');
            const customerTypeMember = document.getElementById('customer_type_member');

            // Handle Customer Type Radio Button Changes (Existing/New Customer)
            if (existingCustomerRadio && newCustomerRadio) {
                existingCustomerRadio.addEventListener('change', function () {
                    if (this.checked) {
                        // Show existing customer options
                        existingCustomerTypeDiv.style.display = 'block';
                        existingCustomerSelectDiv.style.display = 'block';
                        // Keep name and email visible as requested
                        newCustNameDiv.style.display = 'block';
                        newCustEmailDiv.style.display = 'block';
                        // Hide the "Register New" button when Existing is selected
                        if (newCustomerAddIconDiv) newCustomerAddIconDiv.style.display = 'none';

                        if (newCustomerName) {
                            newCustomerName.required = false;
                        }
                        // Show all options in customer select but dont clear value if already set
                        if (customerSelect) {
                            const allOptions = customerSelect.querySelectorAll('option');
                            allOptions.forEach(option => {
                                option.style.display = '';
                            });
                        }
                        // Clear fields initially when switch
                        if (newCustomerName) newCustomerName.value = '';
                        if (newCustomerEmail) newCustomerEmail.value = '';
                        if (customerPhone) customerPhone.value = '';
                    }
                });

                newCustomerRadio.addEventListener('change', function () {
                    if (this.checked) {
                        // Show new customer options
                        newCustomerAddIconDiv.style.display = 'block';
                        newCustNameDiv.style.display = 'block';
                        newCustEmailDiv.style.display = 'block';
                        // Hide existing customer options
                        existingCustomerTypeDiv.style.display = 'none';
                        existingCustomerSelectDiv.style.display = 'none';
                        // Reset customer select
                        if (customerSelect) {
                            customerSelect.value = '';
                            const allOptions = customerSelect.querySelectorAll('option');
                            allOptions.forEach(option => {
                                option.style.display = '';
                            });
                        }
                        // Clear customer type radio buttons
                        if (customerTypeNormal) customerTypeNormal.checked = false;
                        if (customerTypeMember) customerTypeMember.checked = false;
                        // Clear customer phone
                        if (customerPhone) customerPhone.value = '';
                    }
                });
            }

            // Handle Existing Customer Type Radio Button Changes (Customer/Member Customer)
            if (customerTypeNormal && customerTypeMember) {
                customerTypeNormal.addEventListener('change', function () {
                    if (this.checked) {
                        // Filter customer select to show only normal customers
                        filterCustomerSelect('normal');
                    }
                });

                customerTypeMember.addEventListener('change', function () {
                    if (this.checked) {
                        // Filter customer select to show only member customers
                        filterCustomerSelect('member');
                    }
                });
            }

            // Function to filter customer select dropdown based on customer type
            function filterCustomerSelect(type) {
                if (!customerSelect) return;

                const currentValue = customerSelect.value;
                const allOptions = customerSelect.querySelectorAll('option');
                let foundMatch = false;

                allOptions.forEach(option => {
                    if (option.value === '') {
                        option.style.display = '';
                    } else {
                        const customerType = option.getAttribute('data-type');
                        if (customerType === type) {
                            option.style.display = '';
                            if (option.value === currentValue) foundMatch = true;
                        } else {
                            option.style.display = 'none';
                        }
                    }
                });

                // Reset selection only if the current selection is now hidden
                if (!foundMatch && currentValue !== '') {
                    customerSelect.value = '';
                    customerSelect.dispatchEvent(new Event('change'));
                }
            }

            // Add Customer Modal Handler
            const addCustomerBtn = document.getElementById('add_new_customer_btn');
            const addCustomerModal = document.getElementById('addCustomerModal');
            const addCustomerForm = document.getElementById('addCustomerForm');
            const addCustomerTypeSelect = document.getElementById('add_customer_type');
            const addCustomerWalletBalanceDiv = document.getElementById('add_customer_wallet_balance_div');

            // Open modal when Add Customer button is clicked
            if (addCustomerBtn && addCustomerModal) {
                addCustomerBtn.addEventListener('click', function () {
                    // Pre-set to Member and disable selection as requested
                    if (addCustomerTypeSelect) {
                        addCustomerTypeSelect.value = 'member';
                        addCustomerTypeSelect.disabled = true;
                        addCustomerTypeSelect.dispatchEvent(new Event('change'));
                    }
                    const modal = new bootstrap.Modal(addCustomerModal);
                    modal.show();
                });
            }

            // Wallet balance toggle for add customer modal
            if (addCustomerTypeSelect && addCustomerWalletBalanceDiv) {
                addCustomerTypeSelect.addEventListener('change', function () {
                    if (this.value === 'member') {
                        addCustomerWalletBalanceDiv.classList.remove('d-none');
                    } else {
                        addCustomerWalletBalanceDiv.classList.add('d-none');
                    }
                });
            }

            // Validation functions for add customer form
            function validateName(name) {
                return /^[a-zA-Z\s]+$/.test(name) && name.trim().length > 0;
            }

            function validatePhone(phone) {
                return /^[0-9]{10}$/.test(phone);
            }

            function validateEmail(email) {
                if (!email) return true; // Optional
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            function setFieldError(field, message) {
                field.classList.add('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = message;
                }
            }

            function clearFieldError(field) {
                field.classList.remove('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }

            // Add Customer Form Submission
            if (addCustomerForm) {
                addCustomerForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    let isValid = true;

                    const nameField = document.getElementById('add_customer_name');
                    const phoneField = document.getElementById('add_customer_phone');
                    const emailField = document.getElementById('add_customer_email');
                    const typeField = document.getElementById('add_customer_type');

                    clearFieldError(nameField);
                    clearFieldError(phoneField);
                    clearFieldError(emailField);
                    clearFieldError(typeField);

                    if (!nameField.value.trim()) {
                        setFieldError(nameField, 'Name is required.');
                        isValid = false;
                    } else if (!validateName(nameField.value)) {
                        setFieldError(nameField, 'Name must contain only alphabets and spaces.');
                        isValid = false;
                    }

                    if (!phoneField.value.trim()) {
                        setFieldError(phoneField, 'Phone number is required.');
                        isValid = false;
                    } else if (!validatePhone(phoneField.value)) {
                        setFieldError(phoneField, 'Phone number must be exactly 10 digits.');
                        isValid = false;
                    }

                    if (emailField.value && !validateEmail(emailField.value)) {
                        setFieldError(emailField, 'Please enter a valid email address.');
                        isValid = false;
                    }

                    if (!typeField.value) {
                        setFieldError(typeField, 'Customer type is required.');
                        isValid = false;
                    }

                    if (isValid) {
                        // Disable submit button
                        const submitBtn = addCustomerForm.querySelector('button[type="submit"]');
                        const originalBtnText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                        // Prepare form data
                        // Temporarily enable for FormData collection if it was disabled
                        const typeWasDisabled = typeField.disabled;
                        if (typeWasDisabled) typeField.disabled = false;

                        const formData = new FormData(addCustomerForm);

                        // Re-disable if it was disabled
                        if (typeWasDisabled) typeField.disabled = true;

                        // Submit via AJAX
                        fetch('{{ route('appointments.create-customer') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.getAttribute('content') || formData.get('_token')
                            }
                        })
                            .then(response => response.json())
                            .then(result => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;

                                if (result.success) {
                                    // Add customer to dropdown
                                    const customer = result.customer;
                                    const option = document.createElement('option');
                                    option.value = customer.id;
                                    option.setAttribute('data-name', customer.name || '');
                                    option.setAttribute('data-phone', customer.phone || '');
                                    option.setAttribute('data-email', customer.email || '');
                                    option.setAttribute('data-type', customer.customer_type);
                                    option.setAttribute('data-balance', customer.wallet?.balance || 0);

                                    let displayText = customer.name;
                                    if (customer.customer_type === 'member') {
                                        displayText +=
                                            ` (Member - Bal: ₹${parseFloat(customer.wallet?.balance || 0).toFixed(2)})`;
                                    } else {
                                        displayText += ' (Normal)';
                                    }
                                    option.textContent = displayText;

                                    // Add to dropdown (before the last option if there's a default empty option)
                                    if (customerSelect) {
                                        customerSelect.appendChild(option);

                                        // 1. Switch radio first
                                        if (existingCustomerRadio && !existingCustomerRadio.checked) {
                                            existingCustomerRadio.checked = true;
                                            existingCustomerRadio.dispatchEvent(new Event('change'));
                                        }

                                        // 2. Set type
                                        if (customer.customer_type === 'member' && customerTypeMember) {
                                            customerTypeMember.checked = true;
                                            customerTypeMember.dispatchEvent(new Event('change'));
                                        } else if (customer.customer_type === 'normal' &&
                                            customerTypeNormal) {
                                            customerTypeNormal.checked = true;
                                            customerTypeNormal.dispatchEvent(new Event('change'));
                                        }

                                        // 3. Select customer
                                        customerSelect.value = customer.id;
                                        customerSelect.dispatchEvent(new Event('change'));
                                    }

                                    // Close modal
                                    const modal = bootstrap.Modal.getInstance(addCustomerModal);
                                    if (modal) {
                                        modal.hide();
                                    }

                                    // Show success message
                                    if (typeof showToast === 'function') {
                                        showToast('success',
                                            'Customer created successfully and selected.');
                                    } else {
                                        alert('Customer created successfully and selected.');
                                    }
                                } else {
                                    // Handle validation errors
                                    if (result.errors) {
                                        Object.keys(result.errors).forEach(field => {
                                            const fieldElement = document.getElementById(
                                                'add_customer_' + field);
                                            if (fieldElement) {
                                                setFieldError(fieldElement, result.errors[field]
                                                [0]);
                                            }
                                        });
                                    }

                                    if (result.message) {
                                        if (typeof showToast === 'function') {
                                            showToast('error', result.message);
                                        } else {
                                            alert(result.message);
                                        }
                                    }
                                }
                            })
                            .catch(error => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;
                                console.error('Error:', error);
                                if (typeof showToast === 'function') {
                                    showToast('error', 'An error occurred. Please try again.');
                                } else {
                                    alert('An error occurred. Please try again.');
                                }
                            });
                    }
                });
            }

            // Real-time validation for add customer form
            const addCustomerNameField = document.getElementById('add_customer_name');
            const addCustomerPhoneField = document.getElementById('add_customer_phone');
            const addCustomerEmailField = document.getElementById('add_customer_email');

            if (addCustomerNameField) {
                addCustomerNameField.addEventListener('blur', function () {
                    if (this.value.trim()) {
                        if (!validateName(this.value)) {
                            setFieldError(this, 'Name must contain only alphabets and spaces.');
                        } else {
                            clearFieldError(this);
                        }
                    }
                });
            }

            if (addCustomerPhoneField) {
                addCustomerPhoneField.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
                addCustomerPhoneField.addEventListener('blur', function () {
                    if (this.value.trim()) {
                        if (!validatePhone(this.value)) {
                            setFieldError(this, 'Phone number must be exactly 10 digits.');
                        } else {
                            clearFieldError(this);
                        }
                    }
                });
            }

            if (addCustomerEmailField) {
                addCustomerEmailField.addEventListener('blur', function () {
                    if (this.value && !validateEmail(this.value)) {
                        setFieldError(this, 'Please enter a valid email address.');
                    } else {
                        clearFieldError(this);
                    }
                });
            }

            // Reset add customer form when modal is closed
            if (addCustomerModal) {
                addCustomerModal.addEventListener('hidden.bs.modal', function () {
                    if (addCustomerForm) {
                        addCustomerForm.reset();
                        addCustomerForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove(
                            'is-invalid'));
                        addCustomerForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent =
                            '');

                        // Re-enable type select for next time
                        if (addCustomerTypeSelect) {
                            addCustomerTypeSelect.disabled = false;
                        }

                        if (addCustomerWalletBalanceDiv) {
                            addCustomerWalletBalanceDiv.classList.add('d-none');
                        }
                    }
                });
            }

            function updateCustomerNameRequirement() {
                const isNewCustomer = newCustomerRadio ? newCustomerRadio.checked : false;
                const isExistingCustomer = existingCustomerRadio ? existingCustomerRadio.checked : false;
                const customerId = customerSelect ? customerSelect.value : '';

                // Name and Email should be visible if either New or Existing is selected
                if (isNewCustomer || isExistingCustomer) {
                    if (newCustNameDiv) newCustNameDiv.style.display = 'block';
                    if (newCustEmailDiv) newCustEmailDiv.style.display = 'block';

                    // Required only for new customer
                    if (newCustomerName) {
                        newCustomerName.required = isNewCustomer;
                    }
                } else {
                    // Hide if no customer type selected yet
                    if (newCustNameDiv) newCustNameDiv.style.display = 'none';
                    if (newCustEmailDiv) newCustEmailDiv.style.display = 'none';
                    if (newCustomerName) newCustomerName.required = false;
                }
            }


            if (customerSelect) {
                customerSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];

                    if (this.value === "") {
                        if (newCustomerName) newCustomerName.value = "";
                        customerPhone.value = "";
                        if (newCustomerEmail) newCustomerEmail.value = "";
                        isMemberSwitch.checked = false;
                        // Hide member wallet info
                        document.getElementById('memberWalletInfo').style.display = 'none';
                        // Clear member wallet data
                        window.memberWalletBalance = 0;
                        calculateFinalAmount();
                    } else {
                        // Check if payment status requires customer name
                        const paymentStatus = 'paid';

                        if (newCustomerName) newCustomerName.value = selectedOption.getAttribute(
                            'data-name') || "";
                        customerPhone.value = selectedOption.getAttribute('data-phone') || "";
                        if (newCustomerEmail) newCustomerEmail.value = selectedOption.getAttribute(
                            'data-email') || "";

                        const isMember = selectedOption.getAttribute('data-type') === 'member';
                        isMemberSwitch.checked = isMember;

                        // Handle member wallet display
                        const memberWalletBalance = parseFloat(selectedOption.getAttribute(
                            'data-balance') ||
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
            }

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

                // Default to Existing Customer
                if (existingCustomerRadio) {
                    existingCustomerRadio.checked = true;
                    existingCustomerRadio.dispatchEvent(new Event('change'));
                }

                if (customerTypeNormal) customerTypeNormal.checked = false;
                if (customerTypeMember) customerTypeMember.checked = false;

                // Show basic fields by default
                if (newCustNameDiv) newCustNameDiv.style.display = 'block';
                if (newCustEmailDiv) newCustEmailDiv.style.display = 'block';

                // Show existing customer select by default
                if (existingCustomerTypeDiv) existingCustomerTypeDiv.style.display = 'block';
                if (existingCustomerSelectDiv) existingCustomerSelectDiv.style.display = 'block';

                // Hide register profile button by default (can still toggle if needed)
                if (newCustomerAddIconDiv) newCustomerAddIconDiv.style.display = 'none';

                // Reset customer select and show all options
                if (customerSelect) {
                    customerSelect.value = '';
                    const allOptions = customerSelect.querySelectorAll('option');
                    allOptions.forEach(option => {
                        option.style.display = '';
                    });
                }

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
                document.getElementById('staffAvailabilityStatus').style.display = 'none';
                document.getElementById('staffAvailabilityStatus').innerHTML = '';
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
                const paymentStatus = 'paid';
                const customerId = customerSelect.value;
                const customerName = newCustomerName.value.trim();

                if ((paymentStatus === 'paid' && customerId === '') && !customerName) {
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
                const errorList = document.getElementById(formType === 'createForm' ? 'createErrorList' :
                    'editErrorList');

                // Clear previous errors
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });

                // Clear general errors
                if (errorDisplay) errorDisplay.style.display = 'none';
                if (errorList) errorList.innerHTML = '';

                const generalErrors = [];

                // Display errors below each field
                Object.keys(errors).forEach(field => {
                    const fieldElement = form.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        const errorMsg = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                        setFieldError(fieldElement, errorMsg);
                    } else {
                        // Collect general errors
                        const errorMsg = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                        generalErrors.push(errorMsg);
                    }
                });

                // Show general errors
                if (generalErrors.length > 0 && errorDisplay && errorList) {
                    generalErrors.forEach(err => {
                        const li = document.createElement('li');
                        li.textContent = err;
                        errorList.appendChild(li);
                    });
                    errorDisplay.style.display = 'block';
                    errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                // Scroll to first field error if no general errors displayed (or after)
                const firstError = form.querySelector('.is-invalid');
                if (firstError && (!generalErrors.length || !errorDisplay)) {
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

                            // Automatically open invoice for printing if generated
                            if (result.data.appointment && result.data.appointment.invoice) {
                                const invoiceId = result.data.appointment.invoice.id;
                                window.open(`/invoices/${invoiceId}/download?print=1`, '_blank');
                            }

                            // Reload page to show new appointment
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000); // Increased delay slightly to allow popup to open first
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

                // Update amount input (this should be the base service amount before wallet/offers for server processing)
                if (amountInput && serviceAmount >= 0) {
                    amountInput.value = serviceAmount.toFixed(2);
                }
            }

            // Room availability checking
            const appointmentDate = document.getElementById('appointment_date');
            const staffSelect = document.getElementById('staff_select');
            const roomSelect = document.getElementById('room_select');
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');
            const staffAvailabilityStatus = document.getElementById('staffAvailabilityStatus');
            const availableRoomsCount = document.getElementById('availableRoomsCount');
            const availableRoomsText = document.getElementById('availableRoomsText');

            let availabilityData = null;

            function checkAvailability() {
                const date = appointmentDate.value;
                const start = startTime.value;
                const end = endTime.value;

                if (date && start && end) {
                    // Show loading
                    [roomAvailabilityStatus, staffAvailabilityStatus].forEach(status => {
                        status.innerHTML =
                            '<small class="text-info"><i class="ri-loader-4-line spin"></i> Checking availability...</small>';
                        status.style.display = 'block';
                    });

                    fetch(`/appointments/availability?date=${date}&start_time=${start}&end_time=${end}`)
                        .then(response => response.json())
                        .then(data => {
                            availabilityData = data;

                            // Update available rooms count card if it exists
                            if (availableRoomsCount) availableRoomsCount.textContent = data.available_rooms
                                .length;
                            if (availableRoomsText) availableRoomsText.textContent =
                                `${data.available_rooms.length} of ${data.total_rooms} rooms available`;

                            // Update dropdowns
                            updateRoomDropdown(data.available_rooms, data.unavailable_rooms);
                            updateStaffDropdown(data.available_staff, data.unavailable_staff);

                            // Show Room Availability Status
                            if (data.available_rooms.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available Rooms:</strong> ' +
                                    data.available_rooms.map(r => r.name).join(', ') + '</small></div>';
                                if (data.unavailable_rooms.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Unavailable:</strong> ' +
                                        data.unavailable_rooms.map(r => r.name + (r.conflict_time ?
                                            ` (${r.conflict_time})` : '')).join(', ') + '</small></div>';
                                }
                                roomAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                roomAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No rooms available at this time!</small></div>';
                            }

                            // Show Staff Availability Status
                            if (data.available_staff.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available Staff:</strong> ' +
                                    data.available_staff.map(s => s.name).join(', ') + '</small></div>';
                                if (data.unavailable_staff.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Busy:</strong> ' +
                                        data.unavailable_staff.map(s => s.name + (s.conflict_time ?
                                            ` (${s.conflict_time})` : '')).join(', ') + '</small></div>';
                                }
                                staffAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                staffAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No staff available at this time!</small></div>';
                            }

                            // Check for conflicts with currently selected room/staff
                            checkSelectedConflicts(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            [roomAvailabilityStatus, staffAvailabilityStatus].forEach(status => {
                                status.innerHTML =
                                    '<small class="text-danger">Error checking availability</small>';
                            });
                        });
                } else {
                    roomAvailabilityStatus.style.display = 'none';
                    staffAvailabilityStatus.style.display = 'none';
                    if (availableRoomsCount) availableRoomsCount.textContent = '{{ $stats['active_rooms'] }}';
                    if (availableRoomsText) availableRoomsText.textContent = 'Select date & time to check';
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

            function updateStaffDropdown(availableStaff, unavailableStaff) {
                const currentValue = staffSelect.value;
                while (staffSelect.options.length > 1) {
                    staffSelect.remove(1);
                }
                availableStaff.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name + ' - Available';
                    option.style.color = '#198754';
                    staffSelect.appendChild(option);
                });
                unavailableStaff.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name + ' - Busy';
                    option.style.color = '#dc3545';
                    option.disabled = true;
                    staffSelect.appendChild(option);
                });
                if (currentValue) {
                    if (availableStaff.some(s => s.id == currentValue)) {
                        staffSelect.value = currentValue;
                    } else {
                        staffSelect.value = '';
                    }
                }
            }

            function checkSelectedConflicts(data) {
                // Check Room Conflict
                const selectedRoomId = roomSelect.value;
                let roomConflict = false;
                if (selectedRoomId) {
                    const selectedRoom = [...data.available_rooms, ...data.unavailable_rooms].find(r => r.id ==
                        selectedRoomId);
                    if (selectedRoom && data.unavailable_rooms.find(r => r.id == selectedRoomId)) {
                        roomConflict = true;
                        roomSelect.classList.add('is-invalid');
                    } else {
                        roomSelect.classList.remove('is-invalid');
                    }
                }

                // Check Staff Conflict
                const selectedStaffId = staffSelect.value;
                let staffConflict = false;
                if (selectedStaffId) {
                    const selectedStaff = [...data.available_staff, ...data.unavailable_staff].find(s => s.id ==
                        selectedStaffId);
                    if (selectedStaff && data.unavailable_staff.find(s => s.id == selectedStaffId)) {
                        staffConflict = true;
                        staffSelect.classList.add('is-invalid');
                    } else {
                        staffSelect.classList.remove('is-invalid');
                    }
                }

                if (roomConflict || staffConflict) {
                    conflictWarning.style.display = 'block';
                    let messages = [];
                    if (roomConflict) messages.push('Selected room is not available.');
                    if (staffConflict) messages.push('Selected staff is busy.');
                    conflictWarning.querySelector('#conflictMessage').textContent = messages.join(' ');
                } else {
                    conflictWarning.style.display = 'none';
                }
            }

            // Check availability when date/time/room/staff changes
            [appointmentDate, startTime, endTime, roomSelect, staffSelect].forEach(el => {
                if (el) {
                    el.addEventListener('change', checkAvailability);
                }
            });

            // Also check on input event for real-time updates (with debounce)
            [startTime, endTime].forEach(el => {
                if (el) {
                    el.addEventListener('input', function () {
                        if (appointmentDate.value && startTime.value && endTime.value) {
                            setTimeout(checkAvailability, 500);
                        }
                    });
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

            // Edit Modal Availability
            const editAppointmentDate = document.getElementById('edit_appointment_date');
            const editStartTime = document.getElementById('edit_start_time');
            const editEndTime = document.getElementById('edit_end_time');
            const editRoomSelect = document.getElementById('edit_room_id');
            const editStaffSelect = document.getElementById('edit_staff_id');
            const editRoomAvailabilityStatus = document.getElementById('editRoomAvailabilityStatus');
            const editStaffAvailabilityStatus = document.getElementById('editStaffAvailabilityStatus');
            const editConflictWarning = document.getElementById('editConflictWarning');
            let editAvailabilityData = null;

            function checkEditAvailability() {
                const date = editAppointmentDate.value;
                const start = editStartTime.value;
                const end = editEndTime.value;
                const formAction = document.getElementById('editForm')?.action;
                const appointmentId = formAction ? formAction.match(/\/appointments\/(\d+)/)?.[1] : null;

                if (date && start && end) {
                    [editRoomAvailabilityStatus, editStaffAvailabilityStatus].forEach(status => {
                        status.innerHTML =
                            '<small class="text-info"><i class="ri-loader-4-line spin"></i> Checking availability...</small>';
                        status.style.display = 'block';
                    });

                    fetch(
                        `/appointments/availability?date=${date}&start_time=${start}&end_time=${end}&exclude_appointment_id=${appointmentId || ''}`)
                        .then(response => response.json())
                        .then(data => {
                            editAvailabilityData = data;

                            // Update dropdowns
                            updateEditRoomDropdown(data.available_rooms, data.unavailable_rooms);
                            updateEditStaffDropdown(data.available_staff, data.unavailable_staff);

                            // Show Room Status
                            if (data.available_rooms.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available Rooms:</strong> ' +
                                    data.available_rooms.map(r => r.name).join(', ') + '</small></div>';
                                if (data.unavailable_rooms.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Unavailable:</strong> ' +
                                        data.unavailable_rooms.map(r => r.name + (r.conflict_time ?
                                            ` (${r.conflict_time})` : '')).join(', ') + '</small></div>';
                                }
                                editRoomAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                editRoomAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No rooms available!</small></div>';
                            }

                            // Show Staff Status
                            if (data.available_staff.length > 0) {
                                let statusHtml =
                                    '<div class="mt-2"><small class="text-success"><i class="ri-checkbox-circle-line"></i> <strong>Available Staff:</strong> ' +
                                    data.available_staff.map(s => s.name).join(', ') + '</small></div>';
                                if (data.unavailable_staff.length > 0) {
                                    statusHtml +=
                                        '<div class="mt-1"><small class="text-danger"><i class="ri-close-circle-line"></i> <strong>Busy:</strong> ' +
                                        data.unavailable_staff.map(s => s.name + (s.conflict_time ?
                                            ` (${s.conflict_time})` : '')).join(', ') + '</small></div>';
                                }
                                editStaffAvailabilityStatus.innerHTML = statusHtml;
                            } else {
                                editStaffAvailabilityStatus.innerHTML =
                                    '<div class="alert alert-danger py-2 mb-0"><small><i class="ri-alert-line"></i> No staff available!</small></div>';
                            }

                            // Check for conflicts with currently selected room/staff
                            checkEditSelectedConflicts(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            [editRoomAvailabilityStatus, editStaffAvailabilityStatus].forEach(status => {
                                status.innerHTML =
                                    '<small class="text-danger">Error checking availability</small>';
                            });
                        });
                } else {
                    editRoomAvailabilityStatus.style.display = 'none';
                    editStaffAvailabilityStatus.style.display = 'none';
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

            function updateEditStaffDropdown(availableStaff, unavailableStaff) {
                const currentValue = editStaffSelect.value;
                while (editStaffSelect.options.length > 1) {
                    editStaffSelect.remove(1);
                }
                availableStaff.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name + ' - Available';
                    option.style.color = '#198754';
                    editStaffSelect.appendChild(option);
                });
                unavailableStaff.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name + ' - Busy';
                    option.style.color = '#dc3545';
                    option.disabled = true;
                    editStaffSelect.appendChild(option);
                });
                if (currentValue) {
                    if (availableStaff.some(s => s.id == currentValue)) {
                        editStaffSelect.value = currentValue;
                    } else {
                        if (availableStaff.length > 0) {
                            editStaffSelect.value = availableStaff[0].id;
                        }
                    }
                } else if (availableStaff.length > 0) {
                    editStaffSelect.value = availableStaff[0].id;
                }
            }

            function checkEditSelectedConflicts(data) {
                // Check Room Conflict
                const selectedRoomId = editRoomSelect.value;
                let roomConflict = false;
                if (selectedRoomId) {
                    const selectedRoom = [...data.available_rooms, ...data.unavailable_rooms].find(r => r.id ==
                        selectedRoomId);
                    if (selectedRoom && data.unavailable_rooms.find(r => r.id == selectedRoomId)) {
                        roomConflict = true;
                        editRoomSelect.classList.add('is-invalid');
                    } else {
                        editRoomSelect.classList.remove('is-invalid');
                    }
                }

                // Check Staff Conflict
                const selectedStaffId = editStaffSelect.value;
                let staffConflict = false;
                if (selectedStaffId) {
                    const selectedStaff = [...data.available_staff, ...data.unavailable_staff].find(s => s.id ==
                        selectedStaffId);
                    if (selectedStaff && data.unavailable_staff.find(s => s.id == selectedStaffId)) {
                        staffConflict = true;
                        editStaffSelect.classList.add('is-invalid');
                    } else {
                        editStaffSelect.classList.remove('is-invalid');
                    }
                }

                if (roomConflict || staffConflict) {
                    editConflictWarning.style.display = 'block';
                    let messages = [];
                    if (roomConflict) messages.push('Selected room is not available.');
                    if (staffConflict) messages.push('Selected staff is busy.');
                    editConflictWarning.querySelector('#conflictMessage').textContent = messages.join(' ');
                } else {
                    editConflictWarning.style.display = 'none';
                }
            }

            // Edit Modal Event Listeners
            [editAppointmentDate, editStartTime, editEndTime, editRoomSelect, editStaffSelect].forEach(el => {
                if (el) {
                    el.addEventListener('change', function () {
                        setTimeout(checkEditAvailability, 100);
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