<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.4;
            background-color: #fff;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-logo {
            height: 50px;
        }

        .header-title {
            text-align: right;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .form-row {
            display: flex;
            margin-bottom: 8px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }

        .form-label {
            font-weight: bold;
            min-width: 120px;
            display: inline-block;
        }

        .form-value {
            flex: 1;
            border-bottom: 1px dotted #000;
            min-height: 18px;
            padding-left: 5px;
        }

        .form-value-empty {
            border-bottom: 1px dotted #ccc;
            min-height: 18px;
        }

        .two-column {
            display: flex;
            gap: 30px;
        }

        .two-column .column {
            flex: 1;
        }

        .billing-section {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .billing-item {
            text-align: center;
        }

        .billing-label {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .billing-value {
            border-bottom: 2px solid #000;
            min-height: 20px;
            padding: 2px;
            font-weight: bold;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .checkbox {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            display: inline-block;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature-box {
            width: 200px;
        }

        .signature-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            min-height: 40px;
            margin-bottom: 5px;
        }

        .signature-sub-label {
            font-size: 10px;
            text-align: center;
        }

        .feedback-section {
            margin-top: 15px;
        }

        .feedback-options {
            display: flex;
            gap: 15px;
            margin-top: 5px;
        }

        .disclaimer {
            font-size: 8px;
            line-height: 1.3;
            margin-top: 15px;
            text-align: justify;
            border: 1px solid #ddd;
            padding: 8px;
        }

        .client-signature {
            margin-top: 20px;
            text-align: center;
        }

        .client-signature-line {
            border-bottom: 1px solid #000;
            width: 300px;
            margin: 10px auto;
            min-height: 30px;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                padding: 1cm;
            }

            .invoice-container {
                border: none;
                padding: 15px;
            }

            .no-print {
                display: none !important;
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
    <script>
        window.onload = function () {
            if (window.location.search.indexOf('print=1') > -1) {
                setTimeout(function () {
                    window.print();
                }, 500);
                window.onafterprint = function () {
                    window.close();
                };
            }
        }
    </script>

    <button onclick="window.print()" class="print-btn no-print">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print / Download PDF
    </button>

    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div>
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Gentle Glow Wellness Spa Logo"
                    class="header-logo">
            </div>
            <div class="header-title">
                <h1>Gentle Glow Wellness Spa</h1>
            </div>
        </div>

        @if($invoice->appointment)
            @php
                $appointment = $invoice->appointment;
                $customer = $invoice->customer;
                $service = $appointment->service;
                $staff = $appointment->staff;
                $room = $appointment->room;
            @endphp

            <!-- Guest Information -->
            <div class="section">
                <div class="section-title">Guest Information</div>
                <div class="form-row">
                    <span class="form-label">Guest Name:</span>
                    <span class="form-value">{{ $customer->name ?? '' }}</span>
                </div>
                <div class="form-row">
                    <span class="form-label">Membership No.:</span>
                    <span class="form-value">
                        @if($customer && $customer->customer_type == 'member')
                            #M{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                        @else
                            &nbsp;
                        @endif
                    </span>
                </div>
            </div>

            <!-- Treatment Details -->
            <div class="section">
                <div class="section-title">Treatment Details</div>
                <div class="form-row">
                    <span class="form-label">Treatment / Therapy</span>
                    <span
                        class="form-value">{{ $service->name ?? ($appointment->services->first()->service->name ?? '') }}</span>
                </div>
                <div class="two-column">
                    <div class="column">
                        <div class="form-row">
                            <span class="form-label">S.NO.</span>
                            <span class="form-value">{{ $appointment->id ?? '' }}</span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Date:</span>
                            <span class="form-value">
                                @if($appointment->appointment_date)
                                    {{ $appointment->appointment_date->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Contact No.</span>
                            <span class="form-value">{{ $appointment->phone ?? $customer->phone ?? '' }}</span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="form-row">
                            <span class="form-label">Time In:</span>
                            <span class="form-value">{{ $appointment->start_time ?? '' }}</span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Time Out:</span>
                            <span class="form-value">{{ $appointment->end_time ?? '' }}</span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Duration:</span>
                            <span class="form-value">
                                @if($appointment->duration)
                                    {{ $appointment->duration }}m
                                @elseif($appointment->start_time && $appointment->end_time)
                                    @php
                                        $start = \Carbon\Carbon::parse($appointment->start_time);
                                        $end = \Carbon\Carbon::parse($appointment->end_time);
                                        $duration = $start->diffInMinutes($end);
                                    @endphp
                                    {{ $duration }}m
                                @else
                                    &nbsp;
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Provider -->
            <div class="section">
                <div class="section-title">Service Provider</div>
                <div class="two-column">
                    <div class="column">
                        <div class="form-row">
                            <span class="form-label">Name:</span>
                            <span class="form-value">{{ $staff->name ?? '' }}</span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="form-row">
                            <span class="form-label">Sign:</span>
                            <span class="form-value-empty">&nbsp;</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="section">
                <div class="section-title">Billing Information</div>
                <div class="billing-section">
                    <div class="billing-item">
                        <div class="billing-label">Amount</div>
                        <div class="billing-value">{{ number_format($appointment->amount ?? $invoice->total_amount, 2) }}
                        </div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Tariff</div>
                        <div class="billing-value">
                            @if($service)
                                {{ number_format($service->price ?? $appointment->amount ?? 0, 2) }}
                            @else
                                {{ number_format($appointment->amount ?? 0, 2) }}
                            @endif
                        </div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Disc</div>
                        <div class="billing-value">
                            @if($appointment->offer)
                                @if($appointment->offer->discount_type == 'percentage')
                                    {{ number_format(($appointment->amount * $appointment->offer->discount_value / 100), 2) }}
                                @else
                                    {{ number_format($appointment->offer->discount_value, 2) }}
                                @endif
                            @else
                                0.00
                            @endif
                        </div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Tax</div>
                        <div class="billing-value">0.00</div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Total</div>
                        <div class="billing-value">{{ number_format($invoice->payable_amount, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Preparation and Checking -->
            <div class="section">
                <div class="two-column">
                    <div class="column">
                        <div class="section-title">Prepared By</div>
                        <div class="form-row">
                            <span class="form-label">Name:</span>
                            <span class="form-value-empty">&nbsp;</span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Sign:</span>
                            <span class="form-value-empty">&nbsp;</span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="section-title">Checked by</div>
                        <div class="form-row">
                            <span class="form-label">Name:</span>
                            <span class="form-value-empty">&nbsp;</span>
                        </div>
                        <div class="form-row">
                            <span class="form-label">Sign.:</span>
                            <span class="form-value-empty">&nbsp;</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment -->
            <div class="section">
                <div class="section-title">Payment</div>
                <div class="form-row">
                    <span class="form-label">Payment By</span>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <span class="checkbox"
                                style="{{ strtolower($invoice->payment_mode ?? $appointment->payment_method ?? '') == 'cash' ? 'background-color: #000;' : '' }}"></span>
                            <span>Cash</span>
                        </div>
                        <div class="checkbox-item">
                            <span class="checkbox"
                                style="{{ in_array(strtolower($invoice->payment_mode ?? $appointment->payment_method ?? ''), ['card', 'online', 'upi']) ? 'background-color: #000;' : '' }}"></span>
                            <span>Card</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Feedback -->
            <div class="section feedback-section">
                <div class="section-title">Guest Feedback</div>
                <div class="form-row">
                    <span class="form-label">How do you feel our Service?</span>
                </div>
                <div class="feedback-options">
                    <div class="checkbox-item">
                        <span class="checkbox"></span>
                        <span>1. Excellent</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox"></span>
                        <span>2. Very Good</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox"></span>
                        <span>3. Good</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox"></span>
                        <span>4. Poor</span>
                    </div>
                </div>
            </div>

            <!-- Disclaimer -->
            <div class="disclaimer">
                <strong>Disclaimer:</strong> The spa treatment services and/or facilities received or utilized at Wellness
                Spa or any of subsidiaries brand/unit are intended for general purposes only and are not intended to be a
                substitute for professional medical treatments, diagnosis, or advice. We are not responsible for any loss or
                damage to personal belongings. Guests are expected to maintain proper decorum and follow spa etiquette. By
                using our services, you agree to our terms & conditions, SPA etiquettes, disclaimer & privacy policy. For
                more information, visit www.thebodycarefamilyspa.com
            </div>

            <!-- Client Signature -->
            <div class="client-signature">
                <div class="client-signature-line"></div>
                <div style="font-weight: bold; margin-top: 5px;">CLIENT SIGNATURE</div>
            </div>

        @else
            <!-- Fallback if no appointment -->
            <div class="section">
                <div class="section-title">Guest Information</div>
                <div class="form-row">
                    <span class="form-label">Guest Name:</span>
                    <span class="form-value">{{ $invoice->customer->name ?? '' }}</span>
                </div>
                <div class="form-row">
                    <span class="form-label">Membership No.:</span>
                    <span class="form-value">
                        @if($invoice->customer && $invoice->customer->customer_type == 'member')
                            #M{{ str_pad($invoice->customer->id, 4, '0', STR_PAD_LEFT) }}
                        @else
                            &nbsp;
                        @endif
                    </span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Billing Information</div>
                <div class="billing-section">
                    <div class="billing-item">
                        <div class="billing-label">Amount</div>
                        <div class="billing-value">{{ number_format($invoice->total_amount, 2) }}</div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Tariff</div>
                        <div class="billing-value">{{ number_format($invoice->total_amount, 2) }}</div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Disc</div>
                        <div class="billing-value">0.00</div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Tax</div>
                        <div class="billing-value">0.00</div>
                    </div>
                    <div class="billing-item">
                        <div class="billing-label">Total</div>
                        <div class="billing-value">{{ number_format($invoice->payable_amount, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Payment</div>
                <div class="form-row">
                    <span class="form-label">Payment By</span>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <span class="checkbox"
                                style="{{ strtolower($invoice->payment_mode ?? '') == 'cash' ? 'background-color: #000;' : '' }}"></span>
                            <span>Cash</span>
                        </div>
                        <div class="checkbox-item">
                            <span class="checkbox"
                                style="{{ in_array(strtolower($invoice->payment_mode ?? ''), ['card', 'online', 'upi']) ? 'background-color: #000;' : '' }}"></span>
                            <span>Card</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</body>

</html>