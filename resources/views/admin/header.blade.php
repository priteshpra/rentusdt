<!-- Header / Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-fluid">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu"></i>
                    </button>
                </li>
                <li class="hide-phone app-search">
                    <form role="search" action="#" method="get">
                        <input type="search" name="search" class="form-control top-search mb-0" placeholder="Search here...">
                        <button type="submit"><i class="iconoir-search"></i></button>
                    </form>
                </li>
            </ul>

            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                        <i class="iconoir-half-moon dark-mode"></i>
                        <i class="iconoir-sun-light light-mode"></i>
                    </a>
                </li>

                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                        <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13">William Martin</h6>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Account</small>
                        <a class="dropdown-item" href="{{ route('profile') }}"><i class="las la-user fs-18 me-1"></i> Profile</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="las la-power-off fs-18 me-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- Top Bar End -->

<!-- Sidebar Start -->
<div class="startbar d-print-none">
    <div class="brand">
        <a href="{{ route('dashboard') }}" class="logo">
            <span>
                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
            <span>
                <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>

    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <ul class="navbar-nav mb-auto w-100">
                <li class="menu-label mt-2"><span>Main</span></li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('admin-dashboard') }}">
                        <i class="iconoir-report-columns menu-icon"></i>
                        <span>Dashboard</span>
                        <span class="badge text-bg-info ms-auto">New</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('payment') ? 'active' : '' }}" href="{{ route('admin/payment') }}">
                        <i class="iconoir-hand-cash menu-icon"></i>
                        <span>Transactions History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('return') ? 'active' : '' }}" href="{{ route('admin/return') }}">
                        <i class="iconoir-plug-type-l menu-icon"></i>
                        <span>Return History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('withdraw') ? 'active' : '' }}" href="{{ route('admin/withdraw') }}">
                        <i class="iconoir-credit-cards menu-icon"></i>
                        <span>Withdrawal History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('return') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="iconoir-credit-cards menu-icon"></i>
                        <span>Manage Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="iconoir-user menu-icon"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
            </ul>

            <div class="update-msg text-center">
                <div class="d-flex justify-content-center align-items-center thumb-lg update-icon-box rounded-circle mx-auto">
                    <img src="{{ asset('admin/assets/images/extra/gold.png') }}" alt="" height="45">
                </div>
                <h5 class="mt-3">Today's <span class="text-white">$2450.00</span></h5>
                <p class="mb-3 text-muted">Total Returns To Users</p>
                <a href="javascript:void(0);" class="btn text-primary shadow-sm rounded-pill px-3">Rent USDT Now</a>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar End -->