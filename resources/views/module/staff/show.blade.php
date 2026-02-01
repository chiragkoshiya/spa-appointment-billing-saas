@extends('module.layout.app')

@section('title', 'Staff Details')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Staff Member Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <!-- Profile Card -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <div class="avatar-lg mx-auto mb-3 position-relative">
                        <div class="avatar-title bg-{{ $staff->is_active ? 'success' : 'danger' }}-subtle text-{{ $staff->is_active ? 'success' : 'danger' }} display-4 rounded-circle">
                            <i class="ri-user-3-fill"></i>
                        </div>
                        <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }} position-absolute top-0 start-100 translate-middle rounded-pill">
                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <h4 class="mb-1">{{ $staff->name }}</h4>
                    <p class="text-muted mb-3">Staff Member</p>
                    
                    @if (Auth::user()->isAdmin())
                        <div class="d-flex gap-2 justify-content-center mb-3">
                            <a href="javascript:void(0);" class="btn btn-soft-info btn-sm edit-item-btn"
                                data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $staff->id }}" 
                                data-name="{{ $staff->name }}"
                                data-phone="{{ $staff->phone }}"
                                data-email="{{ $staff->email }}"
                                data-address="{{ $staff->address }}"
                                data-status="{{ $staff->is_active }}">
                                <i class="ri-pencil-fill me-1"></i> Edit
                            </a>
                            <a class="btn btn-soft-danger btn-sm remove-item-btn" 
                                data-bs-toggle="modal"
                                data-bs-target="#deleteRecordModal"
                                data-action="{{ route('staff.destroy', $staff->id) }}"
                                data-message="Are you sure you want to remove staff member: {{ $staff->name }}?">
                                <i class="ri-delete-bin-fill me-1"></i> Delete
                            </a>
                        </div>
                    @endif
                </div>

                <div class="border-top pt-4 mt-4">
                    <h5 class="fs-16 mb-3">Contact Information</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                <i class="ri-phone-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-0">Phone</h6>
                            <p class="text-muted mb-0">{{ $staff->phone }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                <i class="ri-mail-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-0">Email</h6>
                            <p class="text-muted mb-0">{{ $staff->email }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                <i class="ri-map-pin-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-0">Address</h6>
                            <p class="text-muted mb-0">{{ $staff->address }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                <i class="ri-calendar-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-0">Joined Date</h6>
                            <p class="text-muted mb-0">{{ $staff->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="col-xl-8">
        @if(Auth::user()->isAdmin())
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="ri-file-list-3-line me-2"></i>Staff Documents
                </h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="ri-upload-2-line align-bottom me-1"></i> Upload Document
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($staff->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Document Type</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff->documents as $doc)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <div class="avatar-title bg-danger-subtle text-danger rounded fs-16">
                                                    <i class="ri-file-pdf-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fs-14 mb-0">{{ $doc->document_type }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $doc->created_at->format('d M, Y') }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="ri-eye-fill align-bottom me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-light text-muted display-4 rounded-circle">
                                <i class="ri-file-list-line"></i>
                            </div>
                        </div>
                        <h5 class="text-muted">No Documents</h5>
                        <p class="text-muted mb-0">No documents have been uploaded for this staff member</p>
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="avatar-lg mx-auto mb-3">
                    <div class="avatar-title bg-light text-muted display-4 rounded-circle">
                        <i class="ri-lock-line"></i>
                    </div>
                </div>
                <h5 class="text-muted">Access Restricted</h5>
                <p class="text-muted mb-0">Document management is only available for administrators</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Back Button -->
<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('staff.index') }}" class="btn btn-light">
            <i class="ri-arrow-left-line me-1"></i> Back to Staff List
        </a>
    </div>
</div>

<!-- Upload Modal -->
@if(Auth::user()->isAdmin())
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Staff Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.documents.store', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Document Type</label>
                        <select name="document_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="ID Proof">ID Proof</option>
                            <option value="Agreement">Agreement</option>
                            <option value="Contract">Contract</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select File</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Allowed: PDF, JPG, PNG, DOC (Max 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Upload</button>
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
            <form id="editForm" method="POST" action="{{ route('staff.update', $staff->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="{{ $staff->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" value="{{ $staff->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" value="{{ $staff->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="3" required>{{ $staff->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="edit_status" {{ $staff->is_active ? 'checked' : '' }}>
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
@endif

@endsection
