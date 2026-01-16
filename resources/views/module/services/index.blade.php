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
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Service List</h5>
                        <div class="flex-shrink-0">
                            <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add Service
                            </button>
                        </div>
                    </div>
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
                        <div class="d-flex justify-content-end">
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
