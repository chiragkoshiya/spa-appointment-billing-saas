@if(isset($data['appointments']) && $data['appointments']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Staff</th>
                <th>Room</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['appointments'] as $appointment)
            <tr>
                <td>
                    <div>{{ $appointment->appointment_date->format('d M, Y') }}</div>
                    <small class="text-muted">{{ $appointment->start_time }} - {{ $appointment->end_time }}</small>
                </td>
                <td>{{ $appointment->customer->name ?? 'N/A' }}</td>
                <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                <td>{{ $appointment->staff->name ?? 'N/A' }}</td>
                <td>{{ $appointment->room->name ?? 'N/A' }}</td>
                <td class="text-end">₹{{ number_format($appointment->amount ?? 0, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : 'info' }}-subtle text-{{ $appointment->status == 'completed' ? 'success' : 'info' }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No appointments found for the selected period</p>
</div>
@endif


