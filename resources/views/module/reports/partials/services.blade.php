@if(isset($data['usage']) && $data['usage']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Service Name</th>
                <th class="text-center">Bookings</th>
                <th class="text-end">Revenue</th>
                <th class="text-end">Avg. Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['usage'] as $service)
            <tr>
                <td class="fw-semibold">{{ $service->name }}</td>
                <td class="text-center">
                    <span class="badge bg-primary-subtle text-primary">{{ $service->count }}</span>
                </td>
                <td class="text-end fw-semibold">₹{{ number_format($service->revenue ?? 0, 2) }}</td>
                <td class="text-end">₹{{ number_format(($service->revenue ?? 0) / max($service->count, 1), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No service data found for the selected period</p>
</div>
@endif


