@if(isset($data['customers']) && $data['customers']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Type</th>
                <th class="text-end">Wallet Balance</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['customers'] as $customer)
            <tr>
                <td class="fw-semibold">{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}">
                        {{ ucfirst($customer->customer_type) }}
                    </span>
                </td>
                <td class="text-end">
                    @if($customer->customer_type == 'member' && $customer->wallet)
                        ₹{{ number_format($customer->wallet->balance, 2) }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $customer->created_at->format('d M, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No customers found for the selected period</p>
</div>
@endif


