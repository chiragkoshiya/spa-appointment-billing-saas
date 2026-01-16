@if(isset($data['items']) && $data['items']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Item Name</th>
                <th class="text-center">Quantity</th>
                <th class="text-end">Unit Price</th>
                <th class="text-end">Total Value</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['items'] as $item)
            <tr>
                <td class="fw-semibold">{{ $item->name }}</td>
                <td class="text-center">
                    <span class="badge bg-{{ $item->quantity <= 0 ? 'danger' : ($item->quantity < 10 ? 'warning' : 'success') }}-subtle text-{{ $item->quantity <= 0 ? 'danger' : ($item->quantity < 10 ? 'warning' : 'success') }}">
                        {{ $item->quantity }}
                    </span>
                </td>
                <td class="text-end">₹{{ number_format($item->amount, 2) }}</td>
                <td class="text-end fw-semibold">₹{{ number_format($item->quantity * $item->amount, 2) }}</td>
                <td>
                    @if($item->quantity <= 0)
                        <span class="badge bg-danger-subtle text-danger">Out of Stock</span>
                    @elseif($item->quantity < 10)
                        <span class="badge bg-warning-subtle text-warning">Low Stock</span>
                    @else
                        <span class="badge bg-success-subtle text-success">In Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if(isset($data['low_stock']) && $data['low_stock']->count() > 0)
<div class="alert alert-warning mt-3">
    <h6 class="alert-heading"><i class="ri-alert-line me-1"></i> Low Stock Items ({{ $data['low_stock']->count() }})</h6>
    <ul class="mb-0">
        @foreach($data['low_stock'] as $item)
        <li>{{ $item->name }} - {{ $item->quantity }} units remaining</li>
        @endforeach
    </ul>
</div>
@endif

@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No inventory data found</p>
</div>
@endif


