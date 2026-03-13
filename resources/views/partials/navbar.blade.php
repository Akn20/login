<header class="nxl-header">
    <div class="header-wrapper">
        <div class="header-left d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>

            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>

            <div class="nxl-drp-link nxl-lavel-mega-menu">
                <div class="nxl-lavel-mega-menu-wrapper d-flex gap-3">
                    <div class="dropdown nxl-h-item nxl-lavel-menu">
                        <a href="javascript:void(0);" class="avatar-text avatar-md bg-primary text-white"
                            data-bs-toggle="dropdown">
                            <i class="feather-plus"></i>
                        </a>
                        <div class="dropdown-menu nxl-h-dropdown">
                            <a href="{{ route('hr.staff-management.create') }}" class="dropdown-item">
                                <i class="feather-user-plus me-3"></i><span>Add New Staff</span>
                            </a>
                            <a href="{{ route('hr.leave-approvals.index') }}" class="dropdown-item">
                                <i class="feather-calendar me-3"></i><span>Process Leaves</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="feather-file-text me-3"></i><span>Generate Payroll</span>
                            </a>
                        </div>
                    </div>

                    <div class="d-none d-md-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0"><i class="feather-search"></i></span>
                            <input type="text" class="form-control border-0 bg-transparent"
                                placeholder="Search Employee ID...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-right ms-auto">
            <div class="d-flex align-items-center gap-2">

                <div class="nxl-h-item d-none d-sm-flex">
                    <a href="javascript:void(0);" class="nxl-head-link me-0"
                        onclick="$('body').fullScreenHelper('toggle');">
                        <i class="feather-maximize maximize"></i>
                    </a>
                </div>

                <div class="nxl-h-item dark-light-theme">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button"><i
                            class="feather-moon"></i></a>
                    <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none"><i
                            class="feather-sun"></i></a>
                </div>

                <div class="dropdown nxl-h-item">
                    <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button">
                        <i class="feather-bell"></i>
                        <span class="badge bg-danger nxl-h-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">Pending Approvals</h6>
                        </div>
                        <div class="notifications-item">
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line">
                                    <span class="fw-semibold text-dark">John Doe</span> applied for Casual Leave.
                                </a>
                                <div class="notifications-date text-muted">2 mins ago</div>
                            </div>
                        </div>
                        <div class="text-center notifications-footer">
                            <a href="{{ route('hr.leave-approvals.index') }}"
                                class="fs-13 fw-semibold text-primary">View All Requests</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button">
                        <span class="">{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar" />
                                <div>
                                    <h6 class="text-dark mb-0">{{ auth()->user()->name }}</h6>
                                    <span
                                        class="fs-12 fw-medium text-muted text-uppercase">{{ auth()->user()->roles?->first()?->name ?? 'Staff' }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="feather-user"></i> <span>My Profile</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="feather-settings"></i> <span>System Settings</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="feather-log-out"></i> <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>