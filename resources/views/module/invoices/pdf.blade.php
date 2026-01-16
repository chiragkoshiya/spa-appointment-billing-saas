<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .logo-section h1 {
            color: #405189;
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .logo-section p {
            margin: 5px 0 0;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }

        .invoice-info p {
            margin: 5px 0;
            color: #666;
        }

        .billing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .billing-block h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .billing-block p {
            margin: 0;
            font-weight: 500;
        }

        .billing-block address {
            font-style: normal;
            color: #555;
        }

        .table-container {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
            color: #405189;
            border-bottom: 2px solid #e9ecef;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .text-right {
            text-align: right;
        }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .totals-table {
            width: 300px;
        }

        .totals-table tr td {
            padding: 8px 0;
            border-bottom: none;
        }

        .totals-table tr.total td {
            border-top: 2px solid #405189;
            padding-top: 15px;
            font-weight: 800;
            font-size: 18px;
            color: #405189;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid #f0f0f0;
            padding-top: 20px;
            color: #999;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d1f2e1;
            color: #188a53;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-primary {
            background: #e0e7ff;
            color: #4338ca;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .container {
                box-shadow: none;
                margin: 0;
                width: 100%;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 24px;
            background: #405189;
            color: #fff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(64, 81, 137, 0.3);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: #354471;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="print-btn no-print">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print / Download PDF
    </button>

    <div class="container">
        <div class="header">
            <div class="logo-section">
                {{-- Use absolute path for logo in PDF --}}
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="SPA Management System Logo"
                    style="height: 40px; margin-bottom: 5px;">
                <p>Wellness & Relaxation Center</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p>#{{ $invoice->invoice_number }}</p>
                <p>Date: {{ $invoice->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="billing-grid">
            <div class="billing-block">
                <h3>Bill From</h3>
                <address>
                    <strong>SPA Management System</strong><br>
                    123 Wellness Street, Serenity Hub<br>
                    State, Country - 100101<br>
                    Phone: +91 98765 43210
                </address>
            </div>
            <div class="billing-block" style="text-align: right;">
                <h3>Bill To</h3>
                <address>
                    <strong>{{ $invoice->customer->name }}</strong><br>
                    @if ($invoice->customer->email)
                        {{ $invoice->customer->email }}<br>
                    @endif
                    Phone: {{ $invoice->customer->phone }}<br>
                    <span
                        class="badge {{ $invoice->customer->customer_type == 'member' ? 'badge-primary' : 'badge-success' }}">
                        {{ ucfirst($invoice->customer->customer_type) }} Customer
                    </span>
                </address>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Description</th>
                        <th class="text-right" style="width: 150px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->description }}</strong>
                                @if ($invoice->appointment && $loop->first)
                                    <div style="font-size: 11px; color: #888; margin-top: 4px;">
                                        APT #{{ str_pad($invoice->appointment->id, 4, '0', STR_PAD_LEFT) }} |
                                        {{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('d M, Y') }}
                                        |
                                        {{ $invoice->appointment->start_time }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">₹{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Sub Total</td>
                    <td class="text-right">₹{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                @if ($invoice->wallet_deduction > 0)
                    <tr>
                        <td>Wallet Deduction</td>
                        <td class="text-right text-success">-₹{{ number_format($invoice->wallet_deduction, 2) }}</td>
                    </tr>
                @endif
                <tr class="total">
                    <td>Payable Amount</td>
                    <td class="text-right">₹{{ number_format($invoice->payable_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid #f0f0f0; padding-top: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <h3 style="font-size: 12px; text-transform: uppercase; color: #999; margin-bottom: 10px;">Payment
                        Status</h3>
                    <p>
                        @if ($invoice->isPaid())
                            <span class="badge badge-success">Fully Paid</span>
                        @elseif($invoice->wallet_deduction > 0)
                            <span class="badge badge-warning">Partial Payment</span>
                        @else
                            <span class="badge badge-danger">Unpaid</span>
                        @endif
                        <span style="margin-left: 10px; color: #666; font-size: 12px;">Method:
                            {{ ucfirst($invoice->payment_mode) }}</span>
                    </p>
                </div>
                <div style="text-align: right;">
                    @if ($invoice->appointment && $invoice->appointment->staff)
                        <h3 style="font-size: 12px; text-transform: uppercase; color: #999; margin-bottom: 10px;">Served
                            By
                        </h3>
                        <p><strong>{{ $invoice->appointment->staff->name }}</strong></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing SPA System. We hope to see you again soon!</p>
            <p style="margin-top: 5px;">This is a computer-generated invoice and doesn't require a physical signature.
            </p>
        </div>
    </div>

</body>

</html>
