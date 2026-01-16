@extends('module.layout.app')

@section('title', 'Profile')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Profile</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <div class="col-auto">
            <div class="avatar-lg">
                <img src="{{ $user->profile_picture_url }}" alt="user-img" class="img-thumbnail rounded-circle" />
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ $user->name }}</h3>
                <p class="text-white text-opacity-75">{{ $user->role->name ?? 'User' }}</p>
                <div class="hstack text-white-50 gap-1">
                    <div class="me-2"><i class="ri-mail-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $user->email }}</div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-12 col-lg-auto order-last order-lg-0">
            <div class="row text text-white-50 text-center">
                <div class="col-lg-6 col-4">
                    <div class="p-2">
                        <h4 class="text-white mb-1">{{ $user->created_at->format('M Y') }}</h4>
                        <p class="fs-14 mb-0">Member Since</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="d-flex profile-wrapper">
                <div class="flex-shrink-0">
                    <a href="{{ route('profile.settings') }}" class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content pt-4 text-muted">
                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Info</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">Full Name :</th>
                                                    <td class="text-muted">{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">E-mail :</th>
                                                    <td class="text-muted">{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Role :</th>
                                                    <td class="text-muted">{{ $user->role->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Status</th>
                                                    <td class="text-muted">
                                                        @if($user->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Joining Date</th>
                                                    <td class="text-muted">{{ $user->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">About</h5>
                                    <p>Welcome to your profile page. Here you can view and manage your account information.</p>
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <div class="d-flex mt-4">
                                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary material-shadow">
                                                        <i class="ri-user-2-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="mb-1">Designation :</p>
                                                    <h6 class="text-truncate mb-0">{{ $user->role->name ?? 'User' }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-md-4">
                                            <div class="d-flex mt-4">
                                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary material-shadow">
                                                        <i class="ri-mail-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="mb-1">Email :</p>
                                                    <a href="mailto:{{ $user->email }}" class="fw-semibold">{{ $user->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

