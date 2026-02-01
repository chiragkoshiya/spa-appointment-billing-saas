@extends('module.layout.app')

@section('title', 'Staff Management')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Staff Management</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setup</a></li>
                        <li class="breadcrumb-item active">Staff</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Filters and Add Button -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <form id="staffSearchForm" action="{{ route('staff.index') }}" method="GET"
                            class="d-flex gap-2 flex-grow-1">
                            <select name="status" id="staff_status_filter" class="form-select form-select-sm"
                                style="min-width: 140px;">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            <input type="text" name="search" id="staff_search_input"
                                class="form-control form-control-sm" placeholder="Search name/phone/email..."
                                value="{{ request('search') }}" style="min-width: 200px;">
                            <button type="submit" class="btn btn-primary btn-sm" id="staff_search_btn">
                                <i class="ri-search-line me-1"></i>Search
                            </button>
                            <a href="{{ route('staff.index') }}" class="btn btn-light btn-sm" title="Refresh/Reset Filters">
                                <i class="ri-refresh-line"></i>
                            </a>
                        </form>
                        @if (Auth::user()->isAdmin())
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add Staff
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Cards Grid -->
    <div class="row">
        @if (isset($managers) && $managers->isNotEmpty())
            @foreach ($managers as $manager)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card border border-primary h-100">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="avatar-lg mx-auto mb-3 position-relative">
                                    <div class="avatar-title bg-primary-subtle text-primary display-4 rounded-circle">
                                        <i class="ri-user-star-fill"></i>
                                    </div>
                                    <span
                                        class="badge bg-primary position-absolute top-0 start-100 translate-middle rounded-pill">
                                        Manager
                                    </span>
                                </div>
                                <h5 class="mb-1">{{ $manager->name }}</h5>
                                <p class="text-muted mb-2 small">Manager</p>
                                <span class="badge bg-success-subtle text-success">Active</span>
                            </div>

                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <i class="ri-phone-fill text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <small class="text-muted d-block">Phone</small>
                                        <span class="text-dark">{{ $manager->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-mail-fill text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <small class="text-muted d-block">Email</small>
                                        <span class="text-dark small">{{ Str::limit($manager->email, 20) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('staff.show', $manager->id) }}" class="btn btn-soft-primary btn-sm"
                                        data-bs-toggle="tooltip" title="View Profile">
                                        <i class="ri-eye-fill"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-soft-info btn-sm edit-item-btn"
                                        data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $manager->id }}"
                                        data-name="{{ $manager->name }}" data-phone="" data-email="{{ $manager->email }}"
                                        data-address="" data-status="{{ $manager->is_active }}" data-is-manager="true"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="ri-pencil-fill"></i>
                                    </a>
                                    <a class="btn btn-soft-danger btn-sm remove-item-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteRecordModal"
                                        data-action="{{ route('staff.manager.destroy', $manager->id) }}"
                                        data-message="Are you sure you want to remove manager: {{ $manager->name }}?"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @forelse($staff as $member)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div
                    class="card border h-100 {{ $member->is_active ? 'border-success-subtle' : 'border-danger-subtle' }}">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar-lg mx-auto mb-3">
                                <div
                                    class="avatar-title bg-{{ $member->is_active ? 'success' : 'danger' }}-subtle text-{{ $member->is_active ? 'success' : 'danger' }} display-4 rounded-circle">
                                    <i class="ri-user-3-fill"></i>
                                </div>
                            </div>
                            <h5 class="mb-1">{{ $member->name }}</h5>
                            <p class="text-muted mb-2 small">Staff Member</p>
                            <span
                                class="badge bg-{{ $member->is_active ? 'success' : 'danger' }}-subtle text-{{ $member->is_active ? 'success' : 'danger' }}">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <i class="ri-phone-fill text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted d-block">Phone</small>
                                    <span class="text-dark">{{ $member->phone }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <i class="ri-mail-fill text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted d-block">Email</small>
                                    <span class="text-dark small">{{ Str::limit($member->email, 20) }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-calendar-fill text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted d-block">Joined</small>
                                    <span class="text-dark small">{{ $member->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('staff.show', $member->id) }}" class="btn btn-soft-primary btn-sm"
                                    data-bs-toggle="tooltip" title="View Profile">
                                    <i class="ri-eye-fill"></i>
                                </a>
                                @if (Auth::user()->isAdmin())
                                    <a href="javascript:void(0);" class="btn btn-soft-info btn-sm edit-item-btn"
                                        data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $member->id }}"
                                        data-name="{{ $member->name }}" data-phone="{{ $member->phone }}"
                                        data-email="{{ $member->email }}" data-address="{{ $member->address }}"
                                        data-status="{{ $member->is_active }}" data-bs-toggle="tooltip" title="Edit">
                                        <i class="ri-pencil-fill"></i>
                                    </a>
                                    <a class="btn btn-soft-danger btn-sm remove-item-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteRecordModal"
                                        data-action="{{ route('staff.destroy', $member->id) }}"
                                        data-message="Are you sure you want to remove staff member: {{ $member->name }}?"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-light text-muted display-4 rounded-circle">
                                <i class="ri-user-search-line"></i>
                            </div>
                        </div>
                        <h5 class="text-muted">No Staff Members Found</h5>
                        <p class="text-muted mb-0">Try adjusting your search or filters</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($staff->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $staff->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- Add Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('staff.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" placeholder="Enter address" rows="3" required></textarea>
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
                        <button type="submit" class="btn btn-success">Save Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3" id="edit_phone_wrapper">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3" id="edit_address_wrapper">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="edit_address" class="form-control" rows="3" required></textarea>
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
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Staff Search Form Handler
            const staffSearchForm = document.getElementById('staffSearchForm');
            const staffStatusFilter = document.getElementById('staff_status_filter');
            const staffSearchInput = document.getElementById('staff_search_input');
            const staffSearchBtn = document.getElementById('staff_search_btn');

            // Handle status filter change - auto submit when status changes
            if (staffStatusFilter && staffSearchForm) {
                staffStatusFilter.addEventListener('change', function() {
                    staffSearchForm.submit();
                });
            }

            // Allow Enter key to submit search form
            if (staffSearchInput && staffSearchForm) {
                staffSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        staffSearchForm.submit();
                    }
                });
            }

            // Ensure search button works
            if (staffSearchBtn && staffSearchForm) {
                staffSearchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    staffSearchForm.submit();
                });
            }

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const isManager = button.getAttribute('data-is-manager') === 'true';
                const form = document.getElementById('editForm');

                if (isManager) {
                    form.action = `/staff/manager/${id}`;
                    document.getElementById('edit_phone_wrapper').style.display = 'none';
                    document.getElementById('edit_address_wrapper').style.display = 'none';
                    document.getElementById('edit_phone').removeAttribute('required');
                    document.getElementById('edit_address').removeAttribute('required');
                } else {
                    form.action = `/staff/${id}`;
                    document.getElementById('edit_phone_wrapper').style.display = 'block';
                    document.getElementById('edit_address_wrapper').style.display = 'block';
                    document.getElementById('edit_phone').setAttribute('required', 'required');
                    document.getElementById('edit_address').setAttribute('required', 'required');
                }

                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_phone').value = button.getAttribute('data-phone');
                document.getElementById('edit_email').value = button.getAttribute('data-email');
                document.getElementById('edit_address').value = button.getAttribute('data-address');
                document.getElementById('edit_status').checked = button.getAttribute('data-status') == '1';
            });
        });
    </script>
@endpush
