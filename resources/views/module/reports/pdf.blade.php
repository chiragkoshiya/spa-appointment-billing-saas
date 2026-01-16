<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ ucwords(str_replace('_', ' ', $reportType)) }} Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; }
        }
        body {
            background: #fff;
            padding: 20px;
        }
        .report-header {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="report-header">
            <div class="row">
                <div class="col-6">
                    <h3>SPA Management System</h3>
                    <p class="text-muted mb-0">{{ ucwords(str_replace('_', ' ', $reportType)) }} Report</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-0"><strong>Period:</strong> {{ $dateRange['label'] ?? $period }}</p>
                    <p class="mb-0"><strong>Generated:</strong> {{ now()->format('d M, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        @if(isset($summary) && !empty($summary))
        <div class="row mb-4">
            <div class="col-12">
                <h5>Summary</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $key => $value)
                            <tr>
                                <td><strong>{{ ucwords(str_replace('_', ' ', $key)) }}</strong></td>
                                <td>
                                    @if(is_numeric($value))
                                        @if(strpos($key, 'amount') !== false || strpos($key, 'revenue') !== false || strpos($key, 'balance') !== false || strpos($key, 'value') !== false)
                                            ₹{{ number_format($value, 2) }}
                                        @else
                                            {{ number_format($value) }}
                                        @endif
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h5>Report Data</h5>
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

        <div class="row mt-4 no-print">
            <div class="col-12 text-center">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ri-printer-line me-1"></i> Print Report
                </button>
            </div>
        </div>
    </div>
</body>
</html>


