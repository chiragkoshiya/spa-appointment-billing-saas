@extends('module.layout.app')

@section('title', 'Invoice Details')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Invoice Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    <div class="mb-4">
                        <h4 class="mb-1">Invoice #{{ $invoice->invoice_number }}</h4>
                        <p class="text-muted mb-0">Invoice Date: {{ $invoice->created_at->format('d M, Y h:i A') }}</p>
                        @if($invoice->appointment)
                        <p class="text-muted mb-0">Appointment ID: #APT{{ str_pad($invoice->appointment->id, 4, '0', STR_PAD_LEFT) }}</p>
                        @endif
                    </div>
                    <div class="text-end">
                        <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-success me-2" target="_blank">
                            <i class="ri-download-line me-1"></i> Download
                        </a>
                        <a href="javascript:void(0);" class="btn btn-warning share-invoice-btn" data-invoice-id="{{ $invoice->id }}">
                            <i class="ri-share-line me-1"></i> Share
                        </a>
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
                                <strong>Date:</strong> 
                                @if($invoice->appointment->appointment_date)
                                    @if(is_string($invoice->appointment->appointment_date))
                                        {{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('d M, Y') }}
                                    @else
                                        {{ $invoice->appointment->appointment_date->format('d M, Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
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
                                <strong>Payment Status:</strong> 
                                @if($invoice->isPaid())
                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                @elseif($invoice->wallet_deduction > 0)
                                    <span class="badge bg-warning-subtle text-warning">Partial Payment</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                @endif
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Created By:</strong> {{ $invoice->creator->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-end">
                        <a href="{{ route('invoices.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line me-1"></i> Back to List
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary edit-item-btn" 
                           data-bs-toggle="modal" 
                           data-bs-target="#editModal"
                           data-id="{{ $invoice->id }}"
                           data-payment-mode="{{ $invoice->payment_mode }}"
                           data-payable-amount="{{ $invoice->payable_amount }}">
                            <i class="ri-pencil-line me-1"></i> Edit Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                        <select name="payment_mode" id="edit_payment_mode" class="form-select" required>
                            <option value="cash" {{ $invoice->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="online" {{ $invoice->payment_mode == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payable Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="payable_amount" id="edit_payable_amount" 
                               class="form-control" required value="{{ $invoice->payable_amount }}">
                        <small class="text-muted">Note: This is the remaining amount to be paid</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Shareable Link</label>
                    <div class="input-group">
                        <input type="text" id="share_url" class="form-control" readonly>
                        <button class="btn btn-primary" type="button" id="copy_share_link">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="ri-information-line me-1"></i>
                    <strong>Note:</strong> This link can be shared with customers. Anyone with this link can view the invoice.
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Share Invoice Handler
        const shareModal = document.getElementById('shareModal');
        document.querySelectorAll('.share-invoice-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const invoiceId = this.getAttribute('data-invoice-id');
                
                fetch(`/invoices/${invoiceId}/share`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('share_url').value = data.share_url;
                            const shareModalInstance = new bootstrap.Modal(shareModal);
                            shareModalInstance.show();
                        } else {
                            showToast('error', 'Error generating share link');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Error generating share link');
                    });
            });
        });

        // Copy Share Link
        document.getElementById('copy_share_link').addEventListener('click', function() {
            const shareUrl = document.getElementById('share_url');
            shareUrl.select();
            shareUrl.setSelectionRange(0, 99999);
            document.execCommand('copy');
            showToast('success', 'Link copied to clipboard!');
        });
    });
</script>
@endpush


