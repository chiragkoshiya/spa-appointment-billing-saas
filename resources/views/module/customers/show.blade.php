@extends('module.layout.app')

@section('title', 'Customer Details')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Customer Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <div class="avatar-lg mx-auto mb-4">
                        <div class="avatar-title bg-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }} rounded-circle display-5">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-3">
                        <span class="badge bg-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }} text-uppercase">
                            {{ $customer->customer_type }} Customer
                        </span>
                    </p>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-0" scope="row">Customer ID:</th>
                                <td class="text-muted">#CUST{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Phone:</th>
                                <td class="text-muted">{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Email:</th>
                                <td class="text-muted">{{ $customer->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Member Since:</th>
                                <td class="text-muted">{{ $customer->created_at->format('d M, Y') }}</td>
                            </tr>
                            @if($customer->customer_type == 'member' && $customer->wallet)
                            <tr>
                                <th class="ps-0" scope="row">Wallet Balance:</th>
                                <td class="text-muted">
                                    <span class="fw-bold text-success">₹{{ number_format($customer->wallet->balance, 2) }}</span>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('customers.index') }}" class="btn btn-soft-primary w-100">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-9">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Appointments</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-calendar-check-line fs-18 align-middle"></i>
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $totalAppointments }}">{{ $totalAppointments }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Completed</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-checkbox-circle-line fs-18 align-middle"></i>
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $completedAppointments }}">{{ $completedAppointments }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-warning fs-14 mb-0">
                                    <i class="ri-time-line fs-18 align-middle"></i>
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendingAppointments }}">{{ $pendingAppointments }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Spending</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-info fs-14 mb-0">
                                    <i class="ri-money-rupee-circle-line fs-18 align-middle"></i>
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹<span class="counter-value" data-target="{{ $totalSpending }}">{{ number_format($totalSpending, 2) }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <!-- Invoice Summary -->
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Total Invoices</p>
                                <h4 class="mt-2 mb-0">{{ $totalInvoices }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                                        <i class="ri-file-list-3-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Total Invoice Amount</p>
                                <h4 class="mt-2 mb-0">₹{{ number_format($totalInvoiceAmount, 2) }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-18">
                                        <i class="ri-money-dollar-circle-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            @if($customer->customer_type == 'member')
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Total Wallet Used</p>
                                <h4 class="mt-2 mb-0 text-success">₹{{ number_format($totalWalletDeduction, 2) }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-18">
                                        <i class="ri-wallet-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            @endif
        </div>
        <!--end row-->

        <!-- Recent Appointments -->
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Appointments</h4>
                <div class="flex-shrink-0">
                    <a href="{{ route('appointments.index', ['customer_id' => $customer->id]) }}" class="btn btn-soft-primary btn-sm">
                        View All <i class="ri-arrow-right-line align-middle"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentAppointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Service</th>
                                <th scope="col">Staff</th>
                                <th scope="col">Room</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAppointments as $appointment)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $appointment->appointment_date ? $appointment->appointment_date->format('d M, Y') : 'N/A' }}</h6>
                                            <small class="text-muted">{{ $appointment->start_time }} - {{ $appointment->end_time }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->staff->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->room->name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($appointment->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'pending' ? 'warning' : 'danger') }}-subtle text-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $appointment->payment_status == 'paid' ? 'success' : 'warning' }}-subtle text-{{ $appointment->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($appointment->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <div class="avatar-md mx-auto mb-4">
                        <div class="avatar-title bg-light text-primary rounded-circle fs-24">
                            <i class="ri-calendar-line"></i>
                        </div>
                    </div>
                    <h5>No Appointments Found</h5>
                    <p class="text-muted">This customer hasn't booked any appointments yet.</p>
                </div>
                @endif
            </div>
        </div>
        <!--end card-->

        <!-- Wallet Transactions (For Members) -->
        @if($customer->customer_type == 'member' && $walletTransactions->count() > 0)
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Wallet Transactions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Service</th>
                                <th scope="col">Invoice #</th>
                                <th scope="col">Amount Used</th>
                                <th scope="col">Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $runningBalance = $customer->wallet->balance;
                            @endphp
                            @foreach($walletTransactions as $invoice)
                            @php
                                $walletUsed = $invoice->wallet_deduction ?? 0;
                                $runningBalance += $walletUsed; // Add back to show balance before transaction
                            @endphp
                            <tr>
                                <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                                <td>{{ $invoice->appointment->service->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="text-primary">
                                        #INV{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td class="text-danger">-₹{{ number_format($walletUsed, 2) }}</td>
                                <td class="text-muted">₹{{ number_format($runningBalance, 2) }}</td>
                            </tr>
                            @php
                                $runningBalance -= $walletUsed; // Subtract for next iteration
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->
        @endif

        <!-- Invoices List -->
        @if($invoices->count() > 0)
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Invoices</h4>
                <div class="flex-shrink-0">
                    <a href="{{ route('invoices.index', ['customer_id' => $customer->id]) }}" class="btn btn-soft-primary btn-sm">
                        View All <i class="ri-arrow-right-line align-middle"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Invoice #</th>
                                <th scope="col">Date</th>
                                <th scope="col">Service</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Wallet Used</th>
                                <th scope="col">Payable</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices->take(5) as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="text-primary fw-semibold">
                                        #INV{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                                <td>{{ $invoice->appointment->service->name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>
                                    @if($invoice->wallet_deduction > 0)
                                        <span class="text-success">-₹{{ number_format($invoice->wallet_deduction, 2) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">₹{{ number_format($invoice->payable_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-soft-primary">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->
        @endif
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@push('scripts')
<script>
    // Counter animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter-value');
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    if (target % 1 === 0) {
                        counter.textContent = Math.floor(current);
                    } else {
                        counter.textContent = current.toFixed(2);
                    }
                    requestAnimationFrame(updateCounter);
                } else {
                    if (target % 1 === 0) {
                        counter.textContent = Math.floor(target);
                    } else {
                        counter.textContent = target.toFixed(2);
                    }
                }
            };
            
            updateCounter();
        });
    });
</script>
@endpush

