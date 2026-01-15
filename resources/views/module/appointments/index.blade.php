@extends('module.layout.app')

@section('title', 'Appointments')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Appointments</h4>

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

<div class="row">
    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Today's Appointments</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $todayCount }}</h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="bx bx-calendar text-success"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Weekly Appointments</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $weekCount }}</h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="bx bx-calendar-event text-info"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Monthly Appointments</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $monthCount }}</h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="bx bx-calendar-star text-warning"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0 mt-n1">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Appointment List</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            <form action="{{ route('appointments.index') }}" method="GET" class="d-flex gap-2">
                                <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Appointments</option>
                                    <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>This Week</option>
                                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>This Month</option>
                                </select>
                            </form>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Create Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <table class="table align-middle table-nowrap mb-0" id="appointmentTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="sort" data-sort="id">ID</th>
                                <th class="sort" data-sort="customer">Customer</th>
                                <th class="sort" data-sort="phone">Phone</th>
                                <th class="sort" data-sort="service">Therapy</th>
                                <th class="sort" data-sort="room">Room</th>
                                <th class="sort" data-sort="staff">Staff</th>
                                <th class="sort" data-sort="date">Date & Time</th>
                                <th class="sort" data-sort="duration">Min</th>
                                <th class="sort" data-sort="amount">RS</th>
                                <th class="sort" data-sort="payment">Payment</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($appointments as $appointment)
                            <tr>
                                <td class="id"><a href="#" class="fw-medium link-primary">#APP{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</a></td>
                                <td class="customer">{{ $appointment->customer->name ?? 'N/A' }}</td>
                                <td class="phone">{{ $appointment->phone ?? 'N/A' }}</td>
                                <td class="service">{{ $appointment->service->name ?? 'N/A' }}</td>
                                <td class="room">{{ $appointment->room->name ?? 'N/A' }}</td>
                                <td class="staff">{{ $appointment->staff->name ?? 'N/A' }}</td>
                                <td class="date">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }} <br>
                                    <small class="text-muted">{{ $appointment->start_time }} - {{ $appointment->end_time }}</small>
                                </td>
                                <td class="duration">{{ $appointment->duration }}</td>
                                <td class="amount">₹{{ number_format($appointment->amount, 2) }}</td>
                                <td class="payment">
                                    <span class="badge bg-{{ $appointment->payment_status == 'paid' ? 'success' : 'warning' }}-subtle text-{{ $appointment->payment_status == 'paid' ? 'success' : 'warning' }} text-uppercase">
                                        {{ $appointment->payment_status }}
                                    </span>
                                    <br><small>{{ $appointment->payment_method }}</small>
                                </td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="edit-item-btn" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#editModal"
                                               data-id="{{ $appointment->id }}"
                                               data-customer_id="{{ $appointment->customer_id }}"
                                               data-phone="{{ $appointment->phone }}"
                                               data-service_id="{{ $appointment->service_id }}"
                                               data-room_id="{{ $appointment->room_id }}"
                                               data-staff_id="{{ $appointment->staff_id }}"
                                               data-date="{{ $appointment->appointment_date }}"
                                               data-start_time="{{ $appointment->start_time }}"
                                               data-end_time="{{ $appointment->end_time }}"
                                               data-duration="{{ $appointment->duration }}"
                                               data-amount="{{ $appointment->amount }}"
                                               data-payment_method="{{ $appointment->payment_method }}"
                                               data-payment_status="{{ $appointment->payment_status }}"
                                               data-is_member="{{ $appointment->is_member }}"
                                               data-sleep="{{ $appointment->sleep }}">
                                                <i class="ri-pencil-fill align-bottom text-muted"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0">
                                                    <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label class="form-label">Customer Name</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Therapy (Service)</label>
                            <select name="service_id" class="form-select" required>
                                <option value="">Select Service</option>
                                @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} - ₹{{ $s->price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Staff (Signature Provider)</label>
                            <select name="staff_id" class="form-select" required>
                                <option value="">Select Staff</option>
                                @foreach($staff as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Room</label>
                            <select name="room_id" class="form-select" required>
                                <option value="">Select Room</option>
                                @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Time In</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Time Out</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" name="duration" class="form-control" placeholder="60">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Amount (RS)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Sleep (Functionality)</label>
                            <input type="text" name="sleep" class="form-control" placeholder="e.g. Sleep status">
                        </div>
                        <div class="col-lg-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_member" value="1" id="isMemberSwitch">
                                <label class="form-check-label" for="isMemberSwitch">Is Member?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label class="form-label">Customer Name</label>
                            <select name="customer_id" id="edit_customer_id" class="form-select" required>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Therapy (Service)</label>
                            <select name="service_id" id="edit_service_id" class="form-select" required>
                                @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Staff (Signature Provider)</label>
                            <select name="staff_id" id="edit_staff_id" class="form-select" required>
                                @foreach($staff as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Room</label>
                            <select name="room_id" id="edit_room_id" class="form-select" required>
                                @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="edit_appointment_date" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Time In</label>
                            <input type="time" name="start_time" id="edit_start_time" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Time Out</label>
                            <input type="time" name="end_time" id="edit_end_time" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" name="duration" id="edit_duration" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Amount (RS)</label>
                            <input type="number" step="0.01" name="amount" id="edit_amount" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" id="edit_payment_method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" id="edit_payment_status" class="form-select" required>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Sleep</label>
                            <input type="text" name="sleep" id="edit_sleep" class="form-control">
                        </div>
                        <div class="col-lg-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_member" value="1" id="edit_is_member">
                                <label class="form-check-label" for="edit_is_member">Is Member?</label>
                            </div>
                        </div>
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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('editForm');
            form.action = `/appointments/${id}`;

            document.getElementById('edit_customer_id').value = button.getAttribute('data-customer_id');
            document.getElementById('edit_phone').value = button.getAttribute('data-phone');
            document.getElementById('edit_service_id').value = button.getAttribute('data-service_id');
            document.getElementById('edit_staff_id').value = button.getAttribute('data-staff_id');
            document.getElementById('edit_room_id').value = button.getAttribute('data-room_id');
            document.getElementById('edit_appointment_date').value = button.getAttribute('data-date');
            document.getElementById('edit_start_time').value = button.getAttribute('data-start_time');
            document.getElementById('edit_end_time').value = button.getAttribute('data-end_time');
            document.getElementById('edit_duration').value = button.getAttribute('data-duration');
            document.getElementById('edit_amount').value = button.getAttribute('data-amount');
            document.getElementById('edit_payment_method').value = button.getAttribute('data-payment_method');
            document.getElementById('edit_payment_status').value = button.getAttribute('data-payment_status');
            document.getElementById('edit_sleep').value = button.getAttribute('data-sleep');
            document.getElementById('edit_is_member').checked = button.getAttribute('data-is_member') == '1';
        });
    });
</script>
@endpush
