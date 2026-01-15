@extends('module.layout.app')

@section('title', 'Services (Therapy)')

@section('content')
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
                                <th>Name</th>
                                <th>Price (RS)</th>
                                <th>Duration (Min)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td class="fw-medium">{{ $service->name }}</td>
                                <td>₹{{ number_format($service->price, 2) }}</td>
                                <td>{{ $service->duration_minutes ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}-subtle text-{{ $service->is_active ? 'success' : 'danger' }} text-uppercase">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="edit-item-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration_minutes }}" data-active="{{ $service->is_active }}">
                                                <i class="ri-pencil-fill align-bottom text-muted"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
