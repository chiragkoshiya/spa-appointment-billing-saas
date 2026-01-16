@if(isset($data['performance']) && $data['performance']->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Staff Name</th>
                <th class="text-center">Appointments</th>
                <th class="text-end">Revenue Generated</th>
                <th class="text-end">Avg. per Appointment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['performance'] as $staff)
            <tr>
                <td class="fw-semibold">{{ $staff->name }}</td>
                <td class="text-center">
                    <span class="badge bg-success-subtle text-success">{{ $staff->appointments }}</span>
                </td>
                <td class="text-end fw-semibold">₹{{ number_format($staff->revenue ?? 0, 2) }}</td>
                <td class="text-end">₹{{ number_format(($staff->revenue ?? 0) / max($staff->appointments, 1), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4">
    <i class="ri-inbox-line fs-48 text-muted"></i>
    <p class="text-muted mt-2">No staff performance data found for the selected period</p>
</div>
@endif


