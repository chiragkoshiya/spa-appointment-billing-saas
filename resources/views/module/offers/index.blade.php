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
                <div class="card-header border-0 mt-n1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="card-title mb-0">Offers List</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1 flex-md-grow-0">
                            <form id="offerSearchForm" action="{{ route('offers.index') }}" method="GET"
                                class="d-flex gap-2  flex-grow-1 flex-md-grow-0">
                                <select name="status" id="offer_status_filter" class="form-select form-select-sm"
                                    style="min-width: 120px; max-width: 140px;">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <select name="discount_type" id="offer_discount_type_filter"
                                    class="form-select form-select-sm" style="min-width: 120px; max-width: 140px;">
                                    <option value="">All Types</option>
                                    <option value="percentage"
                                        {{ request('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                                    </option>
                                    <option value="flat" {{ request('discount_type') == 'flat' ? 'selected' : '' }}>Flat
                                    </option>
                                </select>
                                <input type="text" name="search" id="offer_search_input"
                                    class="form-control form-control-sm" placeholder="Search name..."
                                    value="{{ request('search') }}" style="min-width: 150px; max-width: 200px;">
                                <button type="submit" class="btn btn-primary btn-sm" id="offer_search_btn">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('offers.index') }}" class="btn btn-light btn-sm"
                                    title="Refresh/Reset Filters">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </form>
                            <button class="btn btn-success btn-sm add-btn" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> <span class="d-none d-sm-inline">Create
                                    Offer</span><span class="d-sm-none">Add</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Advanced Date Filter -->
                <div class="card-body border-bottom">
                    <form id="offerDateFilterForm" action="{{ route('offers.index') }}" method="GET"
                        class="d-flex gap-2 flex-wrap align-items-end">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="hidden" name="discount_type" value="{{ request('discount_type') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="mb-2" style="min-width: 160px;">
                            <label class="form-label form-label-sm mb-1">Start Date From</label>
                            <input type="date" name="date_from" id="offer_date_from" class="form-control form-control-sm"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="mb-2" style="min-width: 160px;">
                            <label class="form-label form-label-sm mb-1">End Date To</label>
                            <input type="date" name="date_to" id="offer_date_to" class="form-control form-control-sm"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="ri-calendar-line me-1"></i>Filter Dates
                            </button>
                            @if (request('date_from') || request('date_to'))
                                <a href="{{ route('offers.index', array_merge(request()->except(['date_from', 'date_to']))) }}"
                                    class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="ri-close-line"></i>Clear Dates
                                </a>
                            @endif
                        </div>
                    </form>
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
                    @if ($offers->hasPages())
                        <div class="pagination-wrapper">
                            {{ $offers->links() }}
                        </div>
                    @endif
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
            // Offer Search Form Handler
            const offerSearchForm = document.getElementById('offerSearchForm');
            const offerStatusFilter = document.getElementById('offer_status_filter');
            const offerDiscountTypeFilter = document.getElementById('offer_discount_type_filter');
            const offerSearchInput = document.getElementById('offer_search_input');
            const offerSearchBtn = document.getElementById('offer_search_btn');
            const offerDateFilterForm = document.getElementById('offerDateFilterForm');

            // Handle status filter change - auto submit when status changes
            if (offerStatusFilter && offerSearchForm) {
                offerStatusFilter.addEventListener('change', function() {
                    offerSearchForm.submit();
                });
            }

            // Handle discount type filter change - auto submit when type changes
            if (offerDiscountTypeFilter && offerSearchForm) {
                offerDiscountTypeFilter.addEventListener('change', function() {
                    offerSearchForm.submit();
                });
            }

            // Allow Enter key to submit search form
            if (offerSearchInput && offerSearchForm) {
                offerSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        offerSearchForm.submit();
                    }
                });
            }

            // Ensure search button works
            if (offerSearchBtn && offerSearchForm) {
                offerSearchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    offerSearchForm.submit();
                });
            }

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
