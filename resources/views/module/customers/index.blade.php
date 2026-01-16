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
                                        <option value="normal" {{ request('type') == 'normal' ? 'selected' : '' }}>Normal
                                        </option>
                                        <option value="member" {{ request('type') == 'member' ? 'selected' : '' }}>Member
                                        </option>
                                    </select>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search name/phone..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                </form>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
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
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>#CUST{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="fw-medium">{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->email ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }}-subtle text-{{ $customer->customer_type == 'member' ? 'primary' : 'info' }} text-uppercase">
                                                {{ $customer->customer_type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($customer->customer_type == 'member')
                                                ₹{{ number_format($customer->wallet->balance ?? 0, 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $customer->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('customers.show', $customer->id) }}"
                                                        class="btn btn-link p-0" title="View Details">
                                                        <i class="ri-eye-fill align-bottom text-primary"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="edit-item-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                                        data-phone="{{ $customer->phone }}"
                                                        data-email="{{ $customer->email }}"
                                                        data-type="{{ $customer->customer_type }}">
                                                        <i class="ri-pencil-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="btn btn-link p-0 remove-item-btn" data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal"
                                                        data-action="{{ route('customers.destroy', $customer->id) }}"
                                                        data-message="Are you sure you want to remove customer: {{ $customer->name }}?">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
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
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="create_name" class="form-control"
                                placeholder="Enter name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="create_phone" class="form-control"
                                placeholder="Enter phone number (10 digits)">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email (Optional)</label>
                            <input type="email" name="email" id="create_email" class="form-control"
                                placeholder="Enter email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                            <select name="customer_type" id="create_customer_type" class="form-select">
                                <option value="normal">Normal</option>
                                <option value="member">Member (Premium)</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-none" id="wallet_balance_div">
                            <label class="form-label">Wallet Membership Amount (RS)</label>
                            <input type="number" step="0.01" name="wallet_balance" class="form-control"
                                placeholder="Enter initial wallet amount">
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
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="edit_phone" class="form-control"
                                placeholder="Enter phone number (10 digits)">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                            <select name="customer_type" id="edit_type" class="form-select">
                                <option value="normal">Normal</option>
                                <option value="member">Member (Premium)</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-none" id="edit_wallet_balance_div">
                            <label class="form-label">Wallet Membership Amount (RS)</label>
                            <input type="number" step="0.01" name="wallet_balance" class="form-control"
                                placeholder="Enter wallet amount">
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
            // Validation functions
            function validateName(name) {
                return /^[a-zA-Z\s]+$/.test(name) && name.trim().length > 0;
            }

            function validatePhone(phone) {
                return /^[0-9]{10}$/.test(phone);
            }

            function validateEmail(email) {
                if (!email) return true; // Optional
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            function setFieldError(field, message) {
                field.classList.add('is-invalid');
                field.nextElementSibling.textContent = message;
            }

            function clearFieldError(field) {
                field.classList.remove('is-invalid');
                field.nextElementSibling.textContent = '';
            }

            // Create form validation
            const createForm = document.querySelector('form[action="{{ route('customers.store') }}"]');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let isValid = true;

                    const nameField = document.getElementById('create_name');
                    const phoneField = document.getElementById('create_phone');
                    const emailField = document.getElementById('create_email');
                    const typeField = document.getElementById('create_customer_type');

                    clearFieldError(nameField);
                    clearFieldError(phoneField);
                    clearFieldError(emailField);
                    clearFieldError(typeField);

                    if (!nameField.value.trim()) {
                        setFieldError(nameField, 'Name is required.');
                        isValid = false;
                    } else if (!validateName(nameField.value)) {
                        setFieldError(nameField, 'Name must contain only alphabets and spaces.');
                        isValid = false;
                    }

                    if (!phoneField.value.trim()) {
                        setFieldError(phoneField, 'Phone number is required.');
                        isValid = false;
                    } else if (!validatePhone(phoneField.value)) {
                        setFieldError(phoneField, 'Phone number must be exactly 10 digits.');
                        isValid = false;
                    }

                    if (emailField.value && !validateEmail(emailField.value)) {
                        setFieldError(emailField, 'Please enter a valid email address.');
                        isValid = false;
                    }

                    if (!typeField.value) {
                        setFieldError(typeField, 'Customer type is required.');
                        isValid = false;
                    }

                    if (isValid) {
                        createForm.submit();
                    }
                });
            }

            // Edit form validation
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                editForm.action = `/customers/${id}`;

                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_phone').value = button.getAttribute('data-phone');
                document.getElementById('edit_email').value = button.getAttribute('data-email');
                document.getElementById('edit_type').value = button.getAttribute('data-type');
            });

            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let isValid = true;

                    const nameField = document.getElementById('edit_name');
                    const phoneField = document.getElementById('edit_phone');
                    const emailField = document.getElementById('edit_email');
                    const typeField = document.getElementById('edit_type');

                    clearFieldError(nameField);
                    clearFieldError(phoneField);
                    clearFieldError(emailField);
                    clearFieldError(typeField);

                    if (!nameField.value.trim()) {
                        setFieldError(nameField, 'Name is required.');
                        isValid = false;
                    } else if (!validateName(nameField.value)) {
                        setFieldError(nameField, 'Name must contain only alphabets and spaces.');
                        isValid = false;
                    }

                    if (!phoneField.value.trim()) {
                        setFieldError(phoneField, 'Phone number is required.');
                        isValid = false;
                    } else if (!validatePhone(phoneField.value)) {
                        setFieldError(phoneField, 'Phone number must be exactly 10 digits.');
                        isValid = false;
                    }

                    if (emailField.value && !validateEmail(emailField.value)) {
                        setFieldError(emailField, 'Please enter a valid email address.');
                        isValid = false;
                    }

                    if (!typeField.value) {
                        setFieldError(typeField, 'Customer type is required.');
                        isValid = false;
                    }

                    if (isValid) {
                        editForm.submit();
                    }
                });
            }

            // Wallet balance toggle
            const createTypeSelect = document.getElementById('create_customer_type');
            const walletBalanceDiv = document.getElementById('wallet_balance_div');

            if (createTypeSelect) {
                createTypeSelect.addEventListener('change', function() {
                    if (this.value === 'member') {
                        walletBalanceDiv.classList.remove('d-none');
                    } else {
                        walletBalanceDiv.classList.add('d-none');
                    }
                });
            }

            const editTypeSelect = document.getElementById('edit_type');
            const editWalletBalanceDiv = document.getElementById('edit_wallet_balance_div');

            if (editTypeSelect) {
                editTypeSelect.addEventListener('change', function() {
                    if (this.value === 'member') {
                        editWalletBalanceDiv.classList.remove('d-none');
                    } else {
                        editWalletBalanceDiv.classList.add('d-none');
                    }
                });
            }

            // Real-time validation
            const nameFields = ['create_name', 'edit_name'];
            const phoneFields = ['create_phone', 'edit_phone'];
            const emailFields = ['create_email', 'edit_email'];

            nameFields.forEach(id => {
                const field = document.getElementById(id);
                if (field) {
                    field.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            if (!validateName(this.value)) {
                                setFieldError(this, 'Name must contain only alphabets and spaces.');
                            } else {
                                clearFieldError(this);
                            }
                        }
                    });
                }
            });

            phoneFields.forEach(id => {
                const field = document.getElementById(id);
                if (field) {
                    field.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                    field.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            if (!validatePhone(this.value)) {
                                setFieldError(this, 'Phone number must be exactly 10 digits.');
                            } else {
                                clearFieldError(this);
                            }
                        }
                    });
                }
            });

            emailFields.forEach(id => {
                const field = document.getElementById(id);
                if (field) {
                    field.addEventListener('blur', function() {
                        if (this.value && !validateEmail(this.value)) {
                            setFieldError(this, 'Please enter a valid email address.');
                        } else {
                            clearFieldError(this);
                        }
                    });
                }
            });
        });
    </script>
@endpush
