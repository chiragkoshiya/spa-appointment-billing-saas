@extends('module.layout.app')

@section('title', 'Customers')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Customer Management</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Customers</li>
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
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Customer List</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            <form action="{{ route('customers.index') }}" method="GET" class="d-flex gap-2">
                                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    <option value="normal" {{ request('type') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="member" {{ request('type') == 'member' ? 'selected' : '' }}>Member</option>
                                </select>
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name/phone..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            </form>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add Customer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Wallet Balance</th>
                                <th>Join Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>#CUST{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="fw-medium">{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }} text-uppercase">
                                        {{ $customer->customer_type }}
                                    </span>
                                </td>
                                <td>
                                    @if($customer->customer_type == 'member')
                                        ₹{{ number_format($customer->wallet->balance ?? 0, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $customer->created_at->format('d M, Y') }}</td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="edit-item-btn" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#editModal"
                                               data-id="{{ $customer->id }}"
                                               data-name="{{ $customer->name }}"
                                               data-phone="{{ $customer->phone }}"
                                               data-email="{{ $customer->email }}"
                                               data-type="{{ $customer->customer_type }}">
                                                <i class="ri-pencil-fill align-bottom text-muted"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0">
                                                    <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required placeholder="Enter phone number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email (Optional)</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Type</label>
                        <select name="customer_type" id="create_customer_type" class="form-select" required>
                            <option value="normal">Normal</option>
                            <option value="member">Member (Premium)</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="wallet_balance_div">
                        <label class="form-label">Wallet Membership Amount (RS)</label>
                        <input type="number" step="0.01" name="wallet_balance" class="form-control" placeholder="Enter initial wallet amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Customer</button>
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
                <h5 class="modal-title">Edit Customer</h5>
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
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Type</label>
                        <select name="customer_type" id="edit_type" class="form-select" required>
                            <option value="normal">Normal</option>
                            <option value="member">Member (Premium)</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="edit_wallet_balance_div">
                        <label class="form-label">Wallet Membership Amount (RS)</label>
                        <input type="number" step="0.01" name="wallet_balance" class="form-control" placeholder="Enter wallet amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
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
            form.action = `/customers/${id}`;

            document.getElementById('edit_name').value = button.getAttribute('data-name');
            document.getElementById('edit_phone').value = button.getAttribute('data-phone');
            document.getElementById('edit_email').value = button.getAttribute('data-email');
            document.getElementById('edit_type').value = button.getAttribute('data-type');
        });

        const createTypeSelect = document.getElementById('create_customer_type');
        const walletBalanceDiv = document.getElementById('wallet_balance_div');
        
        createTypeSelect.addEventListener('change', function() {
            if (this.value === 'member') {
                walletBalanceDiv.classList.remove('d-none');
            } else {
                walletBalanceDiv.classList.add('d-none');
            }
        });

        const editTypeSelect = document.getElementById('edit_type');
        const editWalletBalanceDiv = document.getElementById('edit_wallet_balance_div');
        
        editTypeSelect.addEventListener('change', function() {
            if (this.value === 'member') {
                editWalletBalanceDiv.classList.remove('d-none');
            } else {
                editWalletBalanceDiv.classList.add('d-none');
            }
        });
    });
</script>
@endpush
