@extends('module.layout.app')

@section('title', 'Invoices')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Invoice Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Invoices</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['total_invoices'] }}</h4>
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

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Revenue</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹{{ number_format($stats['total_revenue'], 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="ri-money-rupee-circle-line text-success"></i>
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
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending Amount</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹{{ number_format($stats['total_pending'], 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="ri-time-line text-warning"></i>
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
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Today's Revenue</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹{{ number_format($stats['today_revenue'], 2) }}
                            </h4>
                            <p class="text-muted mb-0"><small>{{ $stats['today_invoices'] }} invoices</small></p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="ri-calendar-check-line text-info"></i>
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
                <div class="collapse {{ request()->hasAny(['search', 'customer_id', 'payment_mode', 'payment_status', 'amount_min', 'amount_max', 'date_from', 'date_to']) ? 'show' : '' }}"
                    id="filterCollapse">
                    <div class="card-body">
                        <form method="GET" action="{{ route('invoices.index') }}" id="filterForm" class="filter-form">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Invoice ID, Customer name/phone..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Payment Mode</label>
                                    <select name="payment_mode" class="form-select">
                                        <option value="">All</option>
                                        <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="online" {{ request('payment_mode') == 'online' ? 'selected' : '' }}>
                                            Online</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                            Unpaid</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Sort By</label>
                                    <select name="sort_by" class="form-select">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                            Date</option>
                                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Invoice ID
                                        </option>
                                        <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Amount</option>
                                        <option value="payable_amount" {{ request('sort_by') == 'payable_amount' ? 'selected' : '' }}>Payable</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Amount Min (₹)</label>
                                    <input type="number" step="0.01" name="amount_min" class="form-control"
                                        placeholder="Min" value="{{ request('amount_min') }}" min="0">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Amount Max (₹)</label>
                                    <input type="number" step="0.01" name="amount_max" class="form-control"
                                        placeholder="Max" value="{{ request('amount_max') }}" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date From</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date To</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sort Order</label>
                                    <select name="sort_order" class="form-select">
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                            Descending</option>
                                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-light">
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

    <!-- Invoices Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Invoice List</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('invoices.index') }}" class="btn btn-light me-1 btn-sm"
                                title="Refresh/Reset Filters">
                                <i class="ri-refresh-line"></i>
                            </a>
                            <small class="text-muted">Invoices are auto-generated when appointments are completed</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Invoice #</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Wallet Deduction</th>
                                    <th scope="col">Payable</th>
                                    <th scope="col">Payment Mode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $invoices->firstItem() + $index }}</td>
                                        <td class="fw-semibold">{{ $invoice->invoice_number }}</td>
                                        <td>
                                            <div>
                                                <div class="fw-medium">{{ $invoice->customer->name }}</div>
                                                <small class="text-muted">{{ $invoice->customer->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($invoice->appointment && $invoice->appointment->appointment_date)
                                                @if(is_string($invoice->appointment->appointment_date))
                                                    {{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('d M, Y') }}
                                                @else
                                                    {{ $invoice->appointment->appointment_date->format('d M, Y') }}
                                                @endif
                                                <br><small class="text-muted">{{ $invoice->appointment->start_time }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">₹{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            @if($invoice->wallet_deduction > 0)
                                                <span
                                                    class="text-success">-₹{{ number_format($invoice->wallet_deduction, 2) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">₹{{ number_format($invoice->payable_amount, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }}-subtle text-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }} text-uppercase">
                                                {{ ucfirst($invoice->payment_mode) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($invoice->isPaid())
                                                <span class="badge bg-success-subtle text-success text-uppercase">Paid</span>
                                            @elseif($invoice->wallet_deduction > 0)
                                                <span class="badge bg-warning-subtle text-warning text-uppercase">Partial</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger text-uppercase">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0 justify-content-end">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                                        class="btn btn-sm btn-soft-primary">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                                        class="btn btn-sm btn-soft-primary">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>
                                                @if(Auth::user()->isAdmin())
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="edit-item-btn btn btn-sm btn-soft-info"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $invoice->id }}"
                                                        data-payment-mode="{{ $invoice->payment_mode }}"
                                                        data-payable-amount="{{ $invoice->payable_amount }}">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                <li class="list-inline-item">
                                                    <a href="{{ route('invoices.download', $invoice->id) }}"
                                                        class="btn btn-sm btn-soft-success" target="_blank">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);"
                                                        class="share-invoice-btn btn btn-sm btn-soft-warning"
                                                        data-invoice-id="{{ $invoice->id }}">
                                                        <i class="ri-share-line"></i>
                                                    </a>
                                                </li>
                                                @if(Auth::user()->isAdmin())
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="Remove">
                                                    <a class="btn btn-sm btn-soft-danger remove-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal"
                                                        data-action="{{ route('invoices.destroy', $invoice->id) }}"
                                                        data-message="Are you sure you want to delete invoice: {{ $invoice->invoice_number }}?">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
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
                    @if($invoices->hasPages())
                        <div class="pagination-wrapper">
                            {{ $invoices->links() }}
                        </div>
                    @endif
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
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" id="edit_payment_mode"
                                class="form-select @error('payment_mode') is-invalid @enderror" required>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                            @error('payment_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payable Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="payable_amount" id="edit_payable_amount"
                                class="form-control @error('payable_amount') is-invalid @enderror" required>
                            @error('payable_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        <strong>Note:</strong> This link can be shared with customers. Anyone with this link can view the
                        invoice.
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
        document.addEventListener('DOMContentLoaded', function () {
            // Edit Modal Handler
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('editForm');
                form.action = `/invoices/${id}`;

                document.getElementById('edit_payment_mode').value = button.getAttribute('data-payment-mode') || 'cash';
                document.getElementById('edit_payable_amount').value = button.getAttribute('data-payable-amount') || '0';
            });

            // Share Invoice Handler
            const shareModal = document.getElementById('shareModal');
            document.querySelectorAll('.share-invoice-btn').forEach(btn => {
                btn.addEventListener('click', function () {
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
            document.getElementById('copy_share_link').addEventListener('click', function () {
                const shareUrl = document.getElementById('share_url');
                shareUrl.select();
                shareUrl.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
                showToast('success', 'Link copied to clipboard!');
            });

            // Reset modals on close
            editModal.addEventListener('hidden.bs.modal', function () {
                const form = editModal.querySelector('form');
                if (form) {
                    form.reset();
                    form.querySelectorAll('.is-invalid').forEach(el => {
                        el.classList.remove('is-invalid');
                    });
                }
            });
        });
    </script>
@endpush