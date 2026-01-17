@extends('module.layout.app')

@section('title', 'Rooms')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Room Management</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setup</a></li>
                        <li class="breadcrumb-item active">Rooms</li>
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
                        <h5 class="card-title mb-0">Room List</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1 flex-md-grow-0">
                            <form id="roomSearchForm" action="{{ route('rooms.index') }}" method="GET"
                                class="d-flex gap-2  flex-grow-1 flex-md-grow-0">
                                <select name="status" id="room_status_filter" class="form-select form-select-sm"
                                    style="min-width: 120px; max-width: 140px;">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                <input type="text" name="search" id="room_search_input"
                                    class="form-control form-control-sm" placeholder="Search room name..."
                                    value="{{ request('search') }}" style="min-width: 180px; max-width: 250px;">
                                <button type="submit" class="btn btn-primary btn-sm" id="room_search_btn">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('rooms.index') }}" class="btn btn-light btn-sm"
                                    title="Refresh/Reset Filters">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </form>
                            @if (Auth::user()->isAdmin())
                                <button type="button" class="btn btn-success btn-sm add-btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="ri-add-line align-bottom me-1"></i> <span class="d-none d-sm-inline">Add
                                        Room</span><span class="d-sm-none">Add</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="roomTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @forelse ($rooms as $room)
                                    <tr>
                                        <td class="name">{{ $room->name }}</td>
                                        <td class="slug">{{ $room->slug }}</td>
                                        <td class="status">
                                            <span
                                                class="badge bg-{{ $room->is_active ? 'success' : 'danger' }}-subtle text-{{ $room->is_active ? 'success' : 'danger' }} text-uppercase">
                                                {{ $room->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="date">{{ $room->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @if (Auth::user()->isAdmin())
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="javascript:void(0);" class="edit-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="{{ $room->id }}" data-name="{{ $room->name }}"
                                                            data-status="{{ $room->is_active }}">
                                                            <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="btn btn-link p-0 remove-item-btn" data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal"
                                                            data-action="{{ route('rooms.destroy', $room->id) }}"
                                                            data-message="Are you sure you want to remove this room: {{ $room->name }}?">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @else
                                                <span class="text-muted">View Only</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
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
                    @if ($rooms->hasPages())
                        <div class="pagination-wrapper">
                            {{ $rooms->links() }}
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
                    <h5 class="modal-title" id="createModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Room Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter room name">
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
                        <button type="submit" class="btn btn-success">Save Room</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Room Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
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
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Room Search Form Handler
            const roomSearchForm = document.getElementById('roomSearchForm');
            const roomStatusFilter = document.getElementById('room_status_filter');
            const roomSearchInput = document.getElementById('room_search_input');
            const roomSearchBtn = document.getElementById('room_search_btn');

            // Handle status filter change - auto submit when status changes
            if (roomStatusFilter && roomSearchForm) {
                roomStatusFilter.addEventListener('change', function() {
                    roomSearchForm.submit();
                });
            }

            // Allow Enter key to submit search form
            if (roomSearchInput && roomSearchForm) {
                roomSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        roomSearchForm.submit();
                    }
                });
            }

            // Ensure search button works
            if (roomSearchBtn && roomSearchForm) {
                roomSearchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    roomSearchForm.submit();
                });
            }

            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const status = button.getAttribute('data-status');

                const form = document.getElementById('editForm');
                form.action = `/rooms/${id}`;

                document.getElementById('edit_name').value = name;
                document.getElementById('edit_status').checked = status == '1';
            });
        });
    </script>
@endpush
