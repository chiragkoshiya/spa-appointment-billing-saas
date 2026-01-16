<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') | SPA Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Professional SPA Appointment and Billing Management System" name="description" />
    <meta content="SPA System" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sm1.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Toastify Css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('module.layout.header')

        @include('module.layout.notification-modal')
        @include('module.layout.delete-modal')

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutConfirmModalLabel">Confirm Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f06548,secondary:#f7b84b" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure you want to logout?</h4>
                                <p class="text-muted mx-4 mb-0">You will need to login again to access your account.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <form id="logout-form-confirm" action="{{ route('logout') }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Yes, Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @include('module.layout.sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('module.layout.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    @include('module.layout.customizer')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Notification Helper -->
    <script>
        function showToast(type, message) {
            let background = "linear-gradient(to right, #0ab39c, #405189)"; // success default
            if (type === 'error' || type === 'danger') {
                background = "linear-gradient(to right, #f06548, #f7b84b)";
            } else if (type === 'warning') {
                background = "linear-gradient(to right, #f7b84b, #ffcc00)";
            } else if (type === 'info') {
                background = "linear-gradient(to right, #299cdb, #1b6aa5)";
            }

            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: background,
                },
                onClick: function() {}
            }).showToast();
        }

        // Handle Session Messages
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
        @endif

        @if (session('error'))
            showToast('error', "{{ session('error') }}");
        @endif

        @if (session('warning'))
            showToast('warning', "{{ session('warning') }}");
        @endif

        @if (session('info'))
            showToast('info', "{{ session('info') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('error', "{{ $error }}");
            @endforeach
        @endif

        // Global Delete Modal Handler
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteRecordModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');
                    const message = button.getAttribute('data-message');

                    const form = deleteModal.querySelector('#delete-form');
                    const messageContainer = deleteModal.querySelector('#delete-message');

                    if (form) form.action = action;
                    if (messageContainer && message) messageContainer.textContent = message;
                });
            }
        });
    </script>

    @stack('scripts')

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
