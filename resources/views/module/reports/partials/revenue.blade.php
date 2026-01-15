@if(isset($data['invoices']) && $data['invoices']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Date</th>
                <th class="text-end">Total Amount</th>
                <th class="text-end">Wallet Deduction</th>
                <th class="text-end">Payable</th>
                <th>Payment Mode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['invoices'] as $invoice)
            <tr>
                <td class="fw-semibold">{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->customer->name }}</td>
                <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                <td class="text-end">₹{{ number_format($invoice->total_amount, 2) }}</td>
                <td class="text-end text-success">-₹{{ number_format($invoice->wallet_deduction, 2) }}</td>
                <td class="text-end fw-semibold">₹{{ number_format($invoice->payable_amount, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }}-subtle text-{{ $invoice->payment_mode == 'cash' ? 'info' : 'primary' }}">
                        {{ ucfirst($invoice->payment_mode) }}
                    </span>
                </td>
                <td>
                    @if($invoice->payable_amount <= 0)
                        <span class="badge bg-success-subtle text-success">Paid</span>
                    @elseif($invoice->wallet_deduction > 0)
                        <span class="badge bg-warning-subtle text-warning">Partial</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No revenue data found for the selected period</p>
</div>
@endif

