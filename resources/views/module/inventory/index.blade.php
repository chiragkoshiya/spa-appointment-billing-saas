@extends('module.layout.app')

@section('title', 'Inventory Management')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Inventory Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Items</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['total_items'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="ri-archive-line text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">In Stock</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['in_stock'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="ri-checkbox-circle-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Low Stock</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $stats['low_stock'] }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="ri-alert-line text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Value</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">₹{{ number_format($stats['total_value'], 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="ri-money-rupee-circle-line text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Advanced Filters</h5>
                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterCollapse" aria-expanded="false">
                            <i class="ri-filter-line"></i> Toggle Filters
                        </button>
                    </div>
                </div>
                <div class="collapse {{ request()->hasAny(['search', 'stock_status', 'quantity_min', 'quantity_max', 'amount_min', 'amount_max', 'date_from', 'date_to']) ? 'show' : '' }}"
                    id="filterCollapse">
                    <div class="card-body">
                        <form method="GET" action="{{ route('inventory.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Search Item</label>
                                    <input type="text" name="search" class="form-control" placeholder="Item name..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Stock Status</label>
                                    <select name="stock_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quantity Min</label>
                                    <input type="number" name="quantity_min" class="form-control" placeholder="Min"
                                        value="{{ request('quantity_min') }}" min="0">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quantity Max</label>
                                    <input type="number" name="quantity_max" class="form-control" placeholder="Max"
                                        value="{{ request('quantity_max') }}" min="0">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sort By</label>
                                    <select name="sort_by" class="form-select">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                            Date</option>
                                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name
                                        </option>
                                        <option value="quantity" {{ request('sort_by') == 'quantity' ? 'selected' : '' }}>
                                            Quantity</option>
                                        <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>Amount
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sort Order</label>
                                    <select name="sort_order" class="form-select">
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                            Descending</option>
                                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Amount Min (₹)</label>
                                    <input type="number" step="0.01" name="amount_min" class="form-control"
                                        placeholder="Min amount" value="{{ request('amount_min') }}" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Amount Max (₹)</label>
                                    <input type="number" step="0.01" name="amount_max" class="form-control"
                                        placeholder="Max amount" value="{{ request('amount_max') }}" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date From</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date To</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('inventory.index') }}" class="btn btn-light">
                                        <i class="ri-refresh-line me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Items Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Inventory Items</h5>
                        <div class="flex-shrink-0">
                            <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add Item
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
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit Price (₹)</th>
                                    <th scope="col">Total Value (₹)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $index }}</td>
                                        <td class="fw-medium">{{ $item->name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $item->isOutOfStock() ? 'danger' : ($item->isLowStock() ? 'warning' : 'success') }}-subtle text-{{ $item->isOutOfStock() ? 'danger' : ($item->isLowStock() ? 'warning' : 'success') }}">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td>₹{{ number_format($item->amount, 2) }}</td>
                                        <td class="fw-semibold">₹{{ number_format($item->quantity * $item->amount, 2) }}</td>
                                        <td>
                                            @if($item->isOutOfStock())
                                                <span class="badge bg-danger-subtle text-danger text-uppercase">Out of Stock</span>
                                            @elseif($item->isLowStock())
                                                <span class="badge bg-warning-subtle text-warning text-uppercase">Low Stock</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success text-uppercase">In Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0 justify-content-end">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="edit-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#editModal" data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}" data-amount="{{ $item->amount }}">
                                                        <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="adjust-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#adjustModal" data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">
                                                        <i class="ri-add-subtract-line align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="movement-history-btn"
                                                        data-bs-toggle="modal" data-bs-target="#movementModal"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                        <i class="ri-history-line align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="btn btn-link p-0 remove-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal"
                                                        data-action="{{ route('inventory.destroy', $item->id) }}"
                                                        data-message="Are you sure you want to delete inventory item: {{ $item->name }}?">
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
                                                <p class="mt-2">No inventory items found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($items->hasPages())
                        <div class="d-flex justify-content-end">
                            {{ $items->links() }}
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
                    <h5 class="modal-title">Add New Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required
                                placeholder="Enter item name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Initial Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="1" min="0" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" required
                                placeholder="Enter initial quantity" value="{{ old('quantity') }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="amount"
                                class="form-control @error('amount') is-invalid @enderror" required
                                placeholder="Enter unit price" value="{{ old('amount') }}">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Item</button>
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
                    <h5 class="modal-title">Edit Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="amount" id="edit_amount"
                                class="form-control @error('amount') is-invalid @enderror" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info">
                            <i class="ri-information-line me-1"></i>
                            <strong>Note:</strong> To adjust quantity, use the Adjust Stock button.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Adjust Quantity Modal -->
    <div class="modal fade" id="adjustModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adjust Stock Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="adjustForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" id="adjust_item_name" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Quantity</label>
                            <input type="text" id="adjust_current_qty" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adjustment Type</label>
                            <select id="adjust_type" class="form-select">
                                <option value="add">Add Stock (+)</option>
                                <option value="subtract">Subtract Stock (-)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="1" min="1" name="change_qty" id="adjust_qty"
                                class="form-control @error('change_qty') is-invalid @enderror" required
                                placeholder="Enter quantity">
                            @error('change_qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="3"
                                required placeholder="Enter reason for adjustment"></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Adjust Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Movement History Modal -->
    <div class="modal fade" id="movementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Movement History - <span id="movement_item_name"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="movement_loading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="movement_content" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Change</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody id="movement_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Edit Modal Handler
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('editForm');
                form.action = `/inventory/${id}`;

                document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
                document.getElementById('edit_amount').value = button.getAttribute('data-amount') || '';
            });

            // Adjust Modal Handler
            const adjustModal = document.getElementById('adjustModal');
            adjustModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = document.getElementById('adjustForm');
                form.action = `/inventory/${id}/adjust`;

                document.getElementById('adjust_item_name').value = button.getAttribute('data-name') || '';
                document.getElementById('adjust_current_qty').value = button.getAttribute('data-quantity') || '0';
                document.getElementById('adjust_qty').value = '';
                document.getElementById('adjustForm').querySelector('textarea[name="reason"]').value = '';
            });

            // Handle adjustment type change
            document.getElementById('adjust_type').addEventListener('change', function () {
                const qtyInput = document.getElementById('adjust_qty');
                if (this.value === 'subtract') {
                    qtyInput.setAttribute('data-type', 'negative');
                } else {
                    qtyInput.removeAttribute('data-type');
                }
            });

            // Adjust form submission - convert to negative if subtract
            document.getElementById('adjustForm').addEventListener('submit', function (e) {
                const adjustType = document.getElementById('adjust_type').value;
                const qtyInput = document.getElementById('adjust_qty');
                const currentQty = parseInt(document.getElementById('adjust_current_qty').value) || 0;

                if (adjustType === 'subtract') {
                    const qty = parseInt(qtyInput.value) || 0;
                    if (qty > currentQty) {
                        e.preventDefault();
                        showToast('error', 'Cannot subtract more than current quantity!');
                        return false;
                    }
                    qtyInput.value = -Math.abs(qty);
                } else {
                    qtyInput.value = Math.abs(parseInt(qtyInput.value) || 0);
                }
            });

            // Movement History Modal Handler
            const movementModal = document.getElementById('movementModal');
            movementModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');

                document.getElementById('movement_item_name').textContent = name;
                document.getElementById('movement_loading').style.display = 'block';
                document.getElementById('movement_content').style.display = 'none';

                // Fetch movement history
                fetch(`/inventory/${id}/movements`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('movement_tbody');
                        tbody.innerHTML = '';

                        if (data.data && data.data.length > 0) {
                            data.data.forEach(movement => {
                                const row = document.createElement('tr');
                                const changeClass = movement.change_qty > 0 ? 'text-success' : 'text-danger';
                                const changeIcon = movement.change_qty > 0 ? '+' : '';
                                const date = new Date(movement.created_at).toLocaleString();

                                row.innerHTML = `
                                    <td>${date}</td>
                                    <td>${movement.user ? movement.user.name : 'N/A'}</td>
                                    <td class="${changeClass} fw-semibold">${changeIcon}${movement.change_qty}</td>
                                    <td>${movement.reason || 'N/A'}</td>
                                `;
                                tbody.appendChild(row);
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No movement history found</td></tr>';
                        }

                        document.getElementById('movement_loading').style.display = 'none';
                        document.getElementById('movement_content').style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('movement_loading').innerHTML = '<p class="text-danger">Error loading movement history</p>';
                    });
            });

            // Reset modals on close
            [editModal, adjustModal].forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    const form = modal.querySelector('form');
                    if (form) {
                        form.reset();
                        form.querySelectorAll('.is-invalid').forEach(el => {
                            el.classList.remove('is-invalid');
                        });
                    }
                });
            });
        });
    </script>
@endpush