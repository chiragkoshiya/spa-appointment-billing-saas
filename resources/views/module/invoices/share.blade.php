<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Invoice Details" />
    
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        @media print {
            .no-print { display: none !important; }
        }
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title no-print">
                            <div class="mb-4">
                                <h4 class="mb-1">Invoice #{{ $invoice->invoice_number }}</h4>
                                <p class="text-muted mb-0">Date: {{ $invoice->created_at->format('d M, Y h:i A') }}</p>
                            </div>
                            <div class="text-end">
                                <button onclick="window.print()" class="btn btn-success">
                                    <i class="ri-printer-line me-1"></i> Print
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h6 class="mb-3">Bill From:</h6>
                                    <address>
                                        <strong>SPA Management System</strong><br>
                                        Your Business Address<br>
                                        City, State, ZIP<br>
                                        <abbr title="Phone">P:</abbr> +91-XXXXXXXXXX
                                    </address>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end">
                                    <h6 class="mb-3">Bill To:</h6>
                                    <address>
                                        <strong>{{ $invoice->customer->name }}</strong><br>
                                        @if($invoice->customer->email)
                                        {{ $invoice->customer->email }}<br>
                                        @endif
                                        {{ $invoice->customer->phone }}<br>
                                        <span class="badge bg-{{ $invoice->customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $invoice->customer->customer_type == 'member' ? 'primary' : 'info' }}">
                                            {{ ucfirst($invoice->customer->customer_type) }} Customer
                                        </span>
                                    </address>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;">#</th>
                                                <th>Description</th>
                                                <th class="text-end" style="width: 120px;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoice->items as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td class="text-end">₹{{ number_format($item->amount, 2) }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="border-0 text-end">
                                                    <strong>Sub Total:</strong>
                                                </td>
                                                <td class="border-0 text-end">
                                                    <strong>₹{{ number_format($invoice->total_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @if($invoice->wallet_deduction > 0)
                                            <tr>
                                                <td colspan="2" class="border-0 text-end">
                                                    <strong>Wallet Deduction:</strong>
                                                </td>
                                                <td class="border-0 text-end text-success">
                                                    <strong>-₹{{ number_format($invoice->wallet_deduction, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th colspan="2" class="border-0 text-end">
                                                    <h5 class="m-0 fw-semibold">Total Payable:</h5>
                                                </th>
                                                <th class="border-0 text-end">
                                                    <h5 class="m-0 fw-semibold">₹{{ number_format($invoice->payable_amount, 2) }}</h5>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <h6 class="mb-3">Appointment Details:</h6>
                                    @if($invoice->appointment)
                                    <p class="text-muted mb-1">
                                        <strong>Date:</strong> {{ $invoice->appointment->appointment_date->format('d M, Y') }}
                                    </p>
                                    <p class="text-muted mb-1">
                                        <strong>Time:</strong> {{ $invoice->appointment->start_time }} - {{ $invoice->appointment->end_time }}
                                    </p>
                                    @if($invoice->appointment->staff)
                                    <p class="text-muted mb-1">
                                        <strong>Staff:</strong> {{ $invoice->appointment->staff->name }}
                                    </p>
                                    @endif
                                    @if($invoice->appointment->room)
                                    <p class="text-muted mb-1">
                                        <strong>Room:</strong> {{ $invoice->appointment->room->name }}
                                    </p>
                                    @endif
                                    @else
                                    <p class="text-muted">No appointment details available</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end">
                                    <h6 class="mb-3">Payment Information:</h6>
                                    <p class="text-muted mb-1">
                                        <strong>Payment Mode:</strong> 
                                        <span class="badge bg-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }}-subtle text-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }}">
                                            {{ ucfirst($invoice->payment_mode) }}
                                        </span>
                                    </p>
                                    <p class="text-muted mb-1">
                                        <strong>Status:</strong> 
                                        @if($invoice->isPaid())
                                            <span class="badge bg-success-subtle text-success">Paid</span>
                                        @elseif($invoice->wallet_deduction > 0)
                                            <span class="badge bg-warning-subtle text-warning">Partial Payment</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top text-center no-print">
                            <p class="text-muted mb-0">
                                <small>This is a shared invoice. Generated on {{ $invoice->created_at->format('d M, Y h:i A') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

