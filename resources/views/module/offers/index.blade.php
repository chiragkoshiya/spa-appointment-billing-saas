@extends('module.layout.app')

@section('title', 'Offers & Promotions')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Offers & Promotions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Marketing</a></li>
                        <li class="breadcrumb-item active">Offers</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Offers List</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('offers.index') }}" class="btn btn-light me-1" title="Refresh">
                                <i class="ri-refresh-line"></i>
                            </a>
                            <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Create Offer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Offer Name</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offers as $offer)
                                    <tr>
                                        <td class="fw-medium">{{ $offer->name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-info-subtle text-info text-capitalize">{{ $offer->discount_type }}</span>
                                        </td>
                                        <td>{{ $offer->discount_type == 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($offer->start_date)->format('d M, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($offer->end_date)->format('d M, Y') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $offer->is_active ? 'success' : 'danger' }}-subtle text-{{ $offer->is_active ? 'success' : 'danger' }} text-uppercase">
                                                {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="javascript:void(0);" class="edit-item-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $offer->id }}" data-name="{{ $offer->name }}"
                                                        data-type="{{ $offer->discount_type }}"
                                                        data-value="{{ $offer->discount_value }}"
                                                        data-start="{{ $offer->start_date }}"
                                                        data-end="{{ $offer->end_date }}"
                                                        data-status="{{ $offer->is_active }}">
                                                        <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="btn btn-link p-0 remove-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal"
                                                        data-action="{{ route('offers.destroy', $offer->id) }}"
                                                        data-message="Are you sure you want to remove this offer: {{ $offer->name }}?">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
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
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $offers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('offers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Offer Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Diwali Special"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type</label>
                                <select name="discount_type" class="form-select" required>
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="flat">Flat Amount (₹)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value</label>
                                <input type="number" name="discount_value" step="0.01" class="form-control"
                                    placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    id="isActiveSwitch" checked>
                                <label class="form-check-label" for="isActiveSwitch">Is Active?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Offer Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type</label>
                                <select name="discount_type" id="edit_type" class="form-select" required>
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="flat">Flat Amount (₹)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value</label>
                                <input type="number" name="discount_value" id="edit_value" step="0.01"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="edit_start" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="edit_end" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    id="edit_status">
                                <label class="form-check-label" for="edit_status">Is Active?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('editForm');
                form.action = `/offers/${id}`;

                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_type').value = button.getAttribute('data-type');
                document.getElementById('edit_value').value = button.getAttribute('data-value');
                document.getElementById('edit_start').value = button.getAttribute('data-start');
                document.getElementById('edit_end').value = button.getAttribute('data-end');
                document.getElementById('edit_status').checked = button.getAttribute('data-status') == '1';
            });
        });
    </script>
@endpush
