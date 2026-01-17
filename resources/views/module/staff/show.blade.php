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
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="avatar-title bg-light text-primary display-4 rounded-circle">
                            <i class="ri-user-3-fill"></i>
                        </div>
                    </div>
                    <h5 class="fs-16 mb-1">{{ $staff->name }}</h5>
                    <p class="text-muted mb-0">Staff Member</p>
                </div>
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-light text-primary rounded-circle">
                                <i class="ri-phone-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Phone</h6>
                            <p class="text-muted mb-0">{{ $staff->phone }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-light text-primary rounded-circle">
                                <i class="ri-mail-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Email</h6>
                            <p class="text-muted mb-0">{{ $staff->email }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-light text-primary rounded-circle">
                                <i class="ri-map-pin-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Address</h6>
                            <p class="text-muted mb-0">{{ $staff->address }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 avatar-xs">
                            <div class="avatar-title bg-light text-primary rounded-circle">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Status</h6>
                            <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }}-subtle text-{{ $staff->is_active ? 'success' : 'danger' }}">
                                {{ $staff->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        @if(Auth::user()->isAdmin())
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Staff Documents (Admin Only)</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="ri-upload-2-line align-bottom me-1"></i> Upload Document
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Document Type</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff->documents as $doc)
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
                                <td>{{ $doc->created_at->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                        <i class="ri-eye-fill align-bottom"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No documents uploaded</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
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
    @endif
</div>
@endsection
