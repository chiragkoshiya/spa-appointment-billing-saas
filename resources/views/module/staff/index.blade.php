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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0 mt-n1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="card-title mb-0">Staff Members</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1 flex-md-grow-0">
                            <form id="staffSearchForm" action="{{ route('staff.index') }}" method="GET"
                                class="d-flex gap-2  flex-grow-1 flex-md-grow-0">
                                <select name="status" id="staff_status_filter" class="form-select form-select-sm"
                                    style="min-width: 120px; max-width: 140px;">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <input type="text" name="search" id="staff_search_input"
                                    class="form-control form-control-sm" placeholder="Search name/phone/email..."
                                    value="{{ request('search') }}" style="min-width: 180px; max-width: 250px;">
                                <button type="submit" class="btn btn-primary btn-sm" id="staff_search_btn">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('staff.index') }}" class="btn btn-light btn-sm"
                                    title="Refresh/Reset Filters">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </form>
                            @if (Auth::user()->isAdmin())
                                <button type="button" class="btn btn-success btn-sm add-btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="ri-add-line align-bottom me-1"></i> <span class="d-none d-sm-inline">Add
                                        Staff</span><span class="d-sm-none">Add</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="staffTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @forelse($staff as $member)
                                    <tr>
                                        <td class="name">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 ms-2 name">{{ $member->name }}</div>
                                            </div>
                                        </td>
                                        <td class="phone">{{ $member->phone }}</td>
                                        <td class="email">{{ $member->email }}</td>
                                        <td class="status">
                                            <span
                                                class="badge bg-{{ $member->is_active ? 'success' : 'danger' }}-subtle text-{{ $member->is_active ? 'success' : 'danger' }} text-uppercase">
                                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="date">{{ $member->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View Documents">
                                                    <a href="{{ route('staff.show', $member->id) }}"
                                                        class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                @if (Auth::user()->isAdmin())
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="javascript:void(0);" class="edit-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="{{ $member->id }}" data-name="{{ $member->name }}"
                                                            data-phone="{{ $member->phone }}"
                                                            data-email="{{ $member->email }}"
                                                            data-address="{{ $member->address }}"
                                                            data-status="{{ $member->is_active }}">
                                                            <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="btn btn-link p-0 remove-item-btn" data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal"
                                                            data-action="{{ route('staff.destroy', $member->id) }}"
                                                            data-message="Are you sure you want to remove staff member: {{ $member->name }}?">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($staff->hasPages())
                        <div class="pagination-wrapper">
                            {{ $staff->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
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

            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('editForm');
                form.action = `/staff/${id}`;

                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_phone').value = button.getAttribute('data-phone');
                document.getElementById('edit_email').value = button.getAttribute('data-email');
                document.getElementById('edit_address').value = button.getAttribute('data-address');
                document.getElementById('edit_status').checked = button.getAttribute('data-status') == '1';
            });
        });
    </script>
@endpush
