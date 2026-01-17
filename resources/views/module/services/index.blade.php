@extends('module.layout.app')

@section('title', 'Services (Therapy)')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Services (Therapy)</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Services</li>
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
                        <h5 class="card-title mb-0">Service List</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1 flex-md-grow-0">
                            <form id="serviceSearchForm" action="{{ route('services.index') }}" method="GET"
                                class="d-flex gap-2 flex-grow-1 flex-md-grow-0">
                                <select name="status" id="service_status_filter" class="form-select form-select-sm"
                                    style="min-width: 120px; max-width: 140px;">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <input type="text" name="search" id="service_search_input"
                                    class="form-control form-control-sm" placeholder="Search service name..."
                                    value="{{ request('search') }}" style="min-width: 150px; max-width: 200px;">
                                <button type="submit" class="btn btn-primary btn-sm" id="service_search_btn">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('services.index') }}" class="btn btn-light btn-sm"
                                    title="Refresh/Reset Filters">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </form>
                            <button class="btn btn-success btn-sm add-btn" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> <span class="d-none d-sm-inline">Add
                                    Service</span><span class="d-sm-none">Add</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Advanced Filters -->
                <div class="card-body border-bottom">
                    <form id="serviceAdvancedFilterForm" action="{{ route('services.index') }}" method="GET"
                        class="d-flex gap-2 flex-wrap align-items-end">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="mb-2" style="min-width: 150px;">
                            <label class="form-label form-label-sm mb-1">Price From (₹)</label>
                            <input type="number" step="0.01" min="0" name="price_min" id="service_price_min"
                                class="form-control form-control-sm" placeholder="Min price"
                                value="{{ request('price_min') }}">
                        </div>
                        <div class="mb-2" style="min-width: 150px;">
                            <label class="form-label form-label-sm mb-1">Price To (₹)</label>
                            <input type="number" step="0.01" min="0" name="price_max" id="service_price_max"
                                class="form-control form-control-sm" placeholder="Max price"
                                value="{{ request('price_max') }}">
                        </div>
                        <div class="mb-2" style="min-width: 150px;">
                            <label class="form-label form-label-sm mb-1">Duration From (Min)</label>
                            <input type="number" step="1" min="0" name="duration_min" id="service_duration_min"
                                class="form-control form-control-sm" placeholder="Min duration"
                                value="{{ request('duration_min') }}">
                        </div>
                        <div class="mb-2" style="min-width: 150px;">
                            <label class="form-label form-label-sm mb-1">Duration To (Min)</label>
                            <input type="number" step="1" min="0" name="duration_max" id="service_duration_max"
                                class="form-control form-control-sm" placeholder="Max duration"
                                value="{{ request('duration_max') }}">
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="ri-filter-line me-1"></i>Apply Filters
                            </button>
                            @if (request('price_min') || request('price_max') || request('duration_min') || request('duration_max'))
                                <a href="{{ route('services.index', array_merge(request()->except(['price_min', 'price_max', 'duration_min', 'duration_max']))) }}"
                                    class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="ri-close-line"></i>Clear Advanced
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price (₹)</th>
                                    <th scope="col">Duration (Min)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $index => $service)
                                    <tr>
                                        <td>{{ $services->firstItem() + $index }}</td>
                                        <td class="fw-medium">{{ $service->name }}</td>
                                        <td>₹{{ number_format($service->price, 2) }}</td>
                                        <td>{{ $service->duration_minutes ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}-subtle text-{{ $service->is_active ? 'success' : 'danger' }} text-uppercase">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="edit-item-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $service->id }}" data-name="{{ $service->name }}"
                                                        data-price="{{ $service->price }}"
                                                        data-duration="{{ $service->duration_minutes }}"
                                                        data-active="{{ $service->is_active }}">
                                                        <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="btn btn-link p-0 remove-item-btn" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#deleteRecordModal" 
                                                       data-action="{{ route('services.destroy', $service->id) }}"
                                                       data-message="Are you sure you want to delete the service: {{ $service->name }}?">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
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
                    @if ($services->hasPages())
                        <div class="pagination-wrapper">
                            {{ $services->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter service name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="price"
                                class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"
                                value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" step="1" min="1" name="duration_minutes"
                                class="form-control @error('duration_minutes') is-invalid @enderror"
                                placeholder="Enter duration in minutes" value="{{ old('duration_minutes') }}">
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="create_is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="create_is_active">
                                    Active Status
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Service</button>
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
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="price" id="edit_price"
                                class="form-control @error('price') is-invalid @enderror" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" step="1" min="1" name="duration_minutes"
                                id="edit_duration" class="form-control @error('duration_minutes') is-invalid @enderror">
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active"
                                    value="1">
                                <label class="form-check-label" for="edit_is_active">
                                    Active Status
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Service Search Form Handler
            const serviceSearchForm = document.getElementById('serviceSearchForm');
            const serviceStatusFilter = document.getElementById('service_status_filter');
            const serviceSearchInput = document.getElementById('service_search_input');
            const serviceSearchBtn = document.getElementById('service_search_btn');
            const serviceAdvancedFilterForm = document.getElementById('serviceAdvancedFilterForm');

            // Handle status filter change - auto submit when status changes
            if (serviceStatusFilter && serviceSearchForm) {
                serviceStatusFilter.addEventListener('change', function() {
                    serviceSearchForm.submit();
                });
            }

            // Allow Enter key to submit search form
            if (serviceSearchInput && serviceSearchForm) {
                serviceSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        serviceSearchForm.submit();
                    }
                });
            }

            // Ensure search button works
            if (serviceSearchBtn && serviceSearchForm) {
                serviceSearchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    serviceSearchForm.submit();
                });
            }

            // Edit Modal Handler
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('editForm');
                form.action = `/services/${id}`;

                // Populate form fields
                document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
                document.getElementById('edit_price').value = button.getAttribute('data-price') || '';
                document.getElementById('edit_duration').value = button.getAttribute('data-duration') || '';

                // Handle active status checkbox
                const isActive = button.getAttribute('data-active') === '1' || button.getAttribute(
                    'data-active') === 'true';
                document.getElementById('edit_is_active').checked = isActive;
            });

            // Reset create modal on close
            const createModal = document.getElementById('createModal');
            createModal.addEventListener('hidden.bs.modal', function() {
                const form = createModal.querySelector('form');
                form.reset();
                // Reset validation classes
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            });

            // Reset edit modal on close
            editModal.addEventListener('hidden.bs.modal', function() {
                const form = editModal.querySelector('form');
                form.reset();
                // Reset validation classes
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            });
        });
    </script>
@endpush
