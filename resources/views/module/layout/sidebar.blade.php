        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm1.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm1.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div class="dropdown sidebar-user m-1 rounded">
                <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center gap-2">
                        <img class="rounded header-profile-user" src="{{ Auth::user()->profile_picture_url }}"
                            alt="Header Avatar">
                        <span class="text-start">
                            <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                            <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                                    class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                                    class="align-middle">Online</span></span>
                        </span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                            class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#logoutConfirmModal"><i
                            class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                            data-key="t-logout">Logout</span></a>
                </div>
            </div>
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>
                        </li>

                        <!-- Appointments -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}"
                                href="{{ route('appointments.index') }}">
                                <i class="ri-calendar-check-line"></i> <span
                                    data-key="t-appointments">Appointments</span>
                            </a>
                        </li>

                        <!-- Customers -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                                href="{{ route('customers.index') }}">
                                <i class="ri-user-heart-line"></i> <span data-key="t-customers">Customers</span>
                            </a>
                        </li>

                        <!-- Services (Therapy) -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('services.*') ? 'active' : '' }}"
                                href="{{ route('services.index') }}">
                                <i class="ri-hand-heart-line"></i> <span data-key="t-services">Services (Therapy)</span>
                            </a>
                        </li>

                        <!-- Staff -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('staff.*') ? 'active' : '' }}"
                                href="{{ route('staff.index') }}">
                                <i class="ri-team-line"></i> <span data-key="t-staff">Staff Management</span>
                            </a>
                        </li>

                        <!-- Rooms -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}"
                                href="{{ route('rooms.index') }}">
                                <i class="ri-hotel-bed-line"></i> <span data-key="t-rooms">Rooms</span>
                            </a>
                        </li>

                        <!-- Inventory -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
                                href="{{ route('inventory.index') }}">
                                <i class="ri-archive-line"></i> <span data-key="t-inventory">Inventory</span>
                            </a>
                        </li>

                        <!-- Invoices -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}"
                                href="{{ route('invoices.index') }}">
                                <i class="ri-file-list-3-line"></i> <span data-key="t-invoices">Invoices</span>
                            </a>
                        </li>

                        <!-- Offers -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('offers.*') ? 'active' : '' }}"
                                href="{{ route('offers.index') }}">
                                <i class="ri-price-tag-3-line"></i> <span data-key="t-offers">Offers</span>
                            </a>
                        </li>

                        <!-- Reports -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                                href="{{ route('reports.index') }}">
                                <i class="ri-bar-chart-line"></i> <span data-key="t-reports">Reports</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
