@extends('module.layout.app')

@section('title', 'Reports & Analytics')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Reports & Analytics</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Report Filters -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <h5 class="card-title mb-0">Generate Report</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.index') }}" id="reportForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Report Type <span class="text-danger">*</span></label>
                            <select name="report_type" id="report_type" class="form-select" required>
                                <option value="revenue" {{ $reportType == 'revenue' ? 'selected' : '' }}>Revenue Report</option>
                                <option value="appointments" {{ $reportType == 'appointments' ? 'selected' : '' }}>Appointments Report</option>
                                <option value="customers" {{ $reportType == 'customers' ? 'selected' : '' }}>Customers Report</option>
                                <option value="services" {{ $reportType == 'services' ? 'selected' : '' }}>Services Report</option>
                                <option value="staff" {{ $reportType == 'staff' ? 'selected' : '' }}>Staff Performance Report</option>
                                <option value="inventory" {{ $reportType == 'inventory' ? 'selected' : '' }}>Inventory Report</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Time Period <span class="text-danger">*</span></label>
                            <select name="period" id="period" class="form-select" required>
                                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ $period == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                <option value="this_week" {{ $period == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="last_week" {{ $period == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                <option value="this_month" {{ $period == 'this_month' ? 'selected' : '' }}>This Month</option>
                                <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                <option value="this_year" {{ $period == 'this_year' ? 'selected' : '' }}>This Year</option>
                                <option value="last_year" {{ $period == 'last_year' ? 'selected' : '' }}>Last Year</option>
                                <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="ri-search-line me-1"></i> Generate Report
                                </button>
                                <button type="button" class="btn btn-success" id="downloadBtn">
                                    <i class="ri-download-line me-1"></i> Download
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6" id="customDateRange" style="display: {{ $period == 'custom' ? 'block' : 'none' }};">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                        </div>
                        <div class="col-md-6" id="customDateRangeTo" style="display: {{ $period == 'custom' ? 'block' : 'none' }};">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
@if(isset($summary) && !empty($summary))
<div class="row">
    @foreach($summary as $key => $value)
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            @if(is_numeric($value))
                                @if(strpos($key, 'amount') !== false || strpos($key, 'revenue') !== false || strpos($key, 'balance') !== false || strpos($key, 'value') !== false)
                                    ₹{{ number_format($value, 2) }}
                                @else
                                    {{ number_format($value) }}
                                @endif
                            @else
                                {{ $value }}
                            @endif
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="ri-bar-chart-line text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Report Data -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">
                        {{ ucwords(str_replace('_', ' ', $reportType)) }} Report
                    </h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" onclick="downloadReport('pdf')">
                            <i class="ri-file-pdf-line me-1"></i> PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-info" onclick="downloadReport('csv')">
                            <i class="ri-file-excel-line me-1"></i> CSV
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($reportType == 'revenue')
                    @include('module.reports.partials.revenue')
                @elseif($reportType == 'appointments')
                    @include('module.reports.partials.appointments')
                @elseif($reportType == 'customers')
                    @include('module.reports.partials.customers')
                @elseif($reportType == 'services')
                    @include('module.reports.partials.services')
                @elseif($reportType == 'staff')
                    @include('module.reports.partials.staff')
                @elseif($reportType == 'inventory')
                    @include('module.reports.partials.inventory')
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Download Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('reports.download') }}" id="downloadForm">
                    <input type="hidden" name="report_type" value="{{ $reportType }}">
                    <input type="hidden" name="period" value="{{ $period }}">
                    <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                    <input type="hidden" name="date_to" value="{{ $dateTo }}">
                    <input type="hidden" name="format" id="download_format" value="pdf">
                    
                    <div class="mb-3">
                        <label class="form-label">Select Format</label>
                        <select class="form-select" id="formatSelect" required>
                            <option value="pdf">PDF Document</option>
                            <option value="csv">CSV (Excel)</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="ri-information-line me-1"></i>
                        The report will be downloaded in the selected format.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitDownload()">Download</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide custom date range
        document.getElementById('period').addEventListener('change', function() {
            const customRange = document.getElementById('customDateRange');
            const customRangeTo = document.getElementById('customDateRangeTo');
            if (this.value === 'custom') {
                customRange.style.display = 'block';
                customRangeTo.style.display = 'block';
            } else {
                customRange.style.display = 'none';
                customRangeTo.style.display = 'none';
            }
        });

        // Download button handler
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('downloadModal'));
            modal.show();
        });

        // Format select handler
        document.getElementById('formatSelect').addEventListener('change', function() {
            document.getElementById('download_format').value = this.value;
        });
    });

    function downloadReport(format) {
        document.getElementById('download_format').value = format;
        document.getElementById('downloadForm').submit();
    }

    function submitDownload() {
        document.getElementById('downloadForm').submit();
    }
</script>
@endpush
