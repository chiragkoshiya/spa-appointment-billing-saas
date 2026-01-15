@extends('module.layout.app')

@section('title', 'Staff Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Staff Management</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Staff List</h5>
                    <div class="flex-shrink-0">
                        <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="ri-add-line align-bottom me-1"></i> Add Staff
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff as $member)
                            <tr>
                                <td class="fw-medium">{{ $member->name }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->email ?? 'N/A' }}</td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="edit-item-btn"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
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
