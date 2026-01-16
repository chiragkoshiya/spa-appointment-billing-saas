@extends('module.layout.app')

@section('title', 'Dashboard')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Today Appointments -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('appointments.index', ['filter' => 'today']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                <i class="ri-calendar-check-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Today Appointments</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['today_appointments'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week Appointments -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('appointments.index', ['filter' => 'week']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                <i class="ri-calendar-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Week Appointments</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['week_appointments'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Appointments -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('appointments.index', ['filter' => 'month']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded-2 fs-2">
                                <i class="ri-calendar-2-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Month Appointments</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['month_appointments'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Member Customers -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('customers.index', ['type' => 'member']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                <i class="ri-user-star-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Member Customers</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['total_member_customers'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Wallet Balance -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('customers.index', ['type' => 'member']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-secondary-subtle text-secondary rounded-2 fs-2">
                                <i class="ri-wallet-3-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Wallet Balance</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">₹{{ number_format($stats['total_wallet_balance'], 2) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Invoices -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer" onclick="location.href='{{ route('invoices.index') }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle text-danger rounded-2 fs-2">
                                <i class="ri-file-list-3-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Invoices</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['total_invoices'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Paid Amount -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('invoices.index', ['payment_status' => 'paid']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded-2 fs-2">
                                <i class="ri-money-rupee-circle-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Paid Amount</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">₹{{ number_format($stats['total_paid_amount'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Unpaid Amount -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer"
                onclick="location.href='{{ route('invoices.index', ['payment_status' => 'unpaid']) }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                <i class="ri-money-dollar-circle-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Unpaid Amount</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">₹{{ number_format($stats['total_unpaid_amount'], 2) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Inventory -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer" onclick="location.href='{{ route('inventory.index') }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                <i class="ri-stack-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Inventory</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['total_inventory_count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Offers -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate cursor-pointer" onclick="location.href='{{ route('offers.index') }}'">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                <i class="ri-gift-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Active Offers</p>
                            <h4 class="fs-4 flex-grow-1 mb-0 mt-2">{{ $stats['total_active_offers'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Appointments & Revenue (Last 7 Days)</h4>
                </div>
                <div class="card-body">
                    <div id="appointments-chart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Quick View</h4>
                </div>
                <div class="card-body">
                    <!-- Rooms Availability Card -->
                    <div class="card border border-primary-subtle mb-3 cursor-pointer" onclick="openRoomsModal()"
                        style="cursor: pointer;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="ri-home-4-line me-2 text-primary"></i>Rooms Availability
                                    </h6>
                                    <p class="text-muted mb-0 small">
                                        <span class="badge bg-success-subtle text-success">{{ $stats['available_rooms'] }}
                                            Available</span>
                                        <span class="badge bg-danger-subtle text-danger ms-1">{{ $stats['booked_rooms'] }}
                                            Booked</span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h4 class="mb-0">{{ $stats['total_rooms'] }}</h4>
                                    <small class="text-muted">Total Rooms</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Availability Card -->
                    <div class="card border border-warning-subtle cursor-pointer" onclick="openStaffModal()"
                        style="cursor: pointer;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="ri-user-line me-2 text-warning"></i>Staff Availability
                                    </h6>
                                    <p class="text-muted mb-0 small">
                                        <span class="badge bg-success-subtle text-success">{{ $stats['available_staff'] }}
                                            Available</span>
                                        <span class="badge bg-warning-subtle text-warning ms-1">{{ $stats['busy_staff'] }}
                                            Busy</span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h4 class="mb-0">{{ $stats['total_staff'] }}</h4>
                                    <small class="text-muted">Total Staff</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Rooms Availability Modal -->
    <div class="modal fade" id="roomsModal" tabindex="-1" aria-labelledby="roomsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomsModalLabel">
                        <i class="ri-home-4-line me-2"></i>Rooms Availability - {{ date('d M, Y') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @forelse($rooms as $room)
                            <div class="col-md-6">
                                <div class="card border {{ $room['is_booked'] ? 'border-danger' : 'border-success' }}">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h6 class="mb-0">{{ $room['name'] }}</h6>
                                            @if ($room['is_booked'])
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-time-line me-1"></i>Booked
                                                </span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>Available
                                                </span>
                                            @endif
                                        </div>

                                        @if ($room['current_appointment'])
                                            <div class="mt-2 p-2 bg-light rounded">
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-user-line me-1"></i>
                                                    <strong>Customer:</strong>
                                                    {{ $room['current_appointment']['customer'] }}
                                                </p>
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-service-line me-1"></i>
                                                    <strong>Service:</strong> {{ $room['current_appointment']['service'] }}
                                                </p>
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-time-line me-1"></i>
                                                    <strong>Time:</strong>
                                                    {{ \Carbon\Carbon::parse($room['current_appointment']['start_time'])->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($room['current_appointment']['end_time'])->format('h:i A') }}
                                                </p>
                                                <p class="text-muted mb-0 small">
                                                    <i class="ri-user-settings-line me-1"></i>
                                                    <strong>Staff:</strong> {{ $room['current_appointment']['staff'] }}
                                                </p>
                                            </div>
                                        @elseif($room['next_appointment'])
                                            <div class="mt-2">
                                                <p class="text-info mb-0 small">
                                                    <i class="ri-arrow-right-line me-1"></i>
                                                    <strong>Next:</strong> {{ $room['next_appointment']['service'] }} at
                                                    {{ \Carbon\Carbon::parse($room['next_appointment']['start_time'])->format('h:i A') }}
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-muted mb-0 small">No bookings scheduled</p>
                                        @endif
                                        <div class="mt-2">
                                            <small class="text-muted">Total bookings today:
                                                {{ $room['total_bookings_today'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title bg-light text-primary rounded-circle fs-24">
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">No rooms available</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Availability Modal -->
    <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staffModalLabel">
                        <i class="ri-user-line me-2"></i>Staff Availability - {{ date('d M, Y') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @forelse($staff as $staffMember)
                            <div class="col-md-6">
                                <div class="card border {{ $staffMember['is_busy'] ? 'border-warning' : 'border-success' }}">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h6 class="mb-0">{{ $staffMember['name'] }}</h6>
                                            @if ($staffMember['is_busy'])
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>Busy
                                                </span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>Available
                                                </span>
                                            @endif
                                        </div>

                                        @if ($staffMember['current_appointment'])
                                            <div class="mt-2 p-2 bg-light rounded">
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-user-line me-1"></i>
                                                    <strong>Customer:</strong>
                                                    {{ $staffMember['current_appointment']['customer'] }}
                                                </p>
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-service-line me-1"></i>
                                                    <strong>Service:</strong>
                                                    {{ $staffMember['current_appointment']['service'] }}
                                                </p>
                                                <p class="text-muted mb-1 small">
                                                    <i class="ri-time-line me-1"></i>
                                                    <strong>Time:</strong>
                                                    {{ \Carbon\Carbon::parse($staffMember['current_appointment']['start_time'])->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($staffMember['current_appointment']['end_time'])->format('h:i A') }}
                                                </p>
                                                @if ($staffMember['current_appointment']['duration'])
                                                    <p class="text-muted mb-1 small">
                                                        <i class="ri-timer-line me-1"></i>
                                                        <strong>Duration:</strong>
                                                        {{ $staffMember['current_appointment']['duration'] }} min
                                                    </p>
                                                @endif
                                                <p class="text-muted mb-0 small">
                                                    <i class="ri-home-4-line me-1"></i>
                                                    <strong>Room:</strong>
                                                    {{ $staffMember['current_appointment']['room'] }}
                                                </p>
                                            </div>
                                        @elseif($staffMember['next_appointment'])
                                            <div class="mt-2">
                                                <p class="text-info mb-0 small">
                                                    <i class="ri-arrow-right-line me-1"></i>
                                                    <strong>Next:</strong>
                                                    {{ $staffMember['next_appointment']['service'] }} at
                                                    {{ \Carbon\Carbon::parse($staffMember['next_appointment']['start_time'])->format('h:i A') }}
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-muted mb-0 small">No appointments scheduled</p>
                                        @endif
                                        <div class="mt-2">
                                            <small class="text-muted">Total appointments today:
                                                {{ $staffMember['total_appointments_today'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title bg-light text-primary rounded-circle fs-24">
                                            <i class="ri-user-line"></i>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">No staff available</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        // Chart data
        const chartData = {
            dates: @json($chartData['dates']),
            appointments: @json($chartData['appointments']),
            revenue: @json($chartData['revenue'])
        };

        // Initialize chart
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Appointments',
                    type: 'column',
                    data: chartData.appointments
                }, {
                    name: 'Revenue (₹)',
                    type: 'line',
                    data: chartData.revenue
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: [0, 4]
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                labels: chartData.dates,
                xaxis: {
                    type: 'category'
                },
                yaxis: [{
                    title: {
                        text: 'Appointments',
                    },
                }, {
                    opposite: true,
                    title: {
                        text: 'Revenue (₹)'
                    }
                }],
                colors: ['#405189', '#0ab39c'],
                legend: {
                    show: true,
                    position: 'top'
                }
            };

            var chart = new ApexCharts(document.querySelector("#appointments-chart"), options);
            chart.render();

            // Auto-refresh dashboard every 60 seconds
            let refreshInterval = setInterval(function () {
                if (!document.hidden) {
                    location.reload();
                }
            }, 60000);

            // Clear interval when page is hidden
            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    clearInterval(refreshInterval);
                } else {
                    refreshInterval = setInterval(function () {
                        if (!document.hidden) {
                            location.reload();
                        }
                    }, 60000);
                }
            });
        });

        // Modal functions
        function openRoomsModal() {
            const modal = new bootstrap.Modal(document.getElementById('roomsModal'));
            modal.show();
        }

        function openStaffModal() {
            const modal = new bootstrap.Modal(document.getElementById('staffModal'));
            modal.show();
        }
    </script>
@endpush