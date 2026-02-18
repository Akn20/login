<style>
    /* Sidebar scroll with page */
    .nxl-navigation .navbar-content {
        height: 100vh;
        /* full viewport height */
        overflow-y: auto;
        /* vertical scroll when content is taller */
    }

    .nxl-navigation .navbar-wrapper {
        height: 100vh;
        overflow-y: auto;
    }
</style>

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" alt="" class="logo logo-lg">
                <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- Section: Main --}}
                <li class="nxl-item nxl-caption">
                    <label>Main</label>
                </li>

                <li class="nxl-item">
                    <a href="{{ route('admin.dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- Section: Access Control --}}
                <li class="nxl-item nxl-caption">
                    <label>Access Control</label>
                </li>

                {{-- Users --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Users</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.users.index') }}" class="nxl-link">All Users</a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.users.create') }}" class="nxl-link">Add User</a>
                        </li>
                    </ul>
                </li>

                {{-- Roles --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shield"></i></span>
                        <span class="nxl-mtext">Roles &amp; Permissions</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.roles.index') }}" class="nxl-link">All Roles</a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.roles.create') }}" class="nxl-link">Add Role</a>
                        </li>
                    </ul>
                </li>

                {{-- Section: App Management --}}
                <li class="nxl-item nxl-caption">
                    <label>App Management</label>
                </li>

                {{-- System (Financial Years) --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">System</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.financial-years.index') }}" class="nxl-link">
                                Financial Years
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.financial-years.mapping') }}" class="nxl-link">
                                FY–Hospital Mapping
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Section: Navigation --}}
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                {{-- ================= ORGANIZATION ================= --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-cast"></i></span>
                        <span class="nxl-mtext">Organization</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.organization.index') }}">
                                All Organizations
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.organization.create') }}">
                                Add Organization
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= INSTITUTION ================= --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-send"></i></span>
                        <span class="nxl-mtext">Institution</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.institutions.index') }}">
                                All Institutions
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.institutions.create') }}">
                                Add Institution
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= MODULE MANAGEMENT ================= --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.modules.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Module Management</span>
                    </a>
                </li>


                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-cast"></i></span>
                        <span class="nxl-mtext">Configuration</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">

                {{-- Religion --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.religion.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Religion</span>
                    </a>
                </li>

                {{-- Job Type --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.job-type.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-cast"></i></span>
                        <span class="nxl-mtext">Job Type</span>
                    </a>
                </li>

                {{-- Work Status --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.work-status.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-send"></i></span>
                        <span class="nxl-mtext">Work Status</span>
                    </a>
                </li>

                {{-- Designation --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.designation.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-send"></i></span>
                        <span class="nxl-mtext">Designation</span>
                    </a>
                </li>

                {{-- Blood Group --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.blood-groups.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-droplet"></i></span>
                        <span class="nxl-mtext">Blood Group</span>
                    </a>
                </li>

                {{-- Department --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.departments.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Department</span>
                    </a>
                </li>
                    </ul>
                </li>

                {{-- Section: Account --}}
                <li class="nxl-item nxl-caption">
                    <label>Account</label>
                </li>

                <li class="nxl-item">
                    <a href="#" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-user"></i></span>
                        <span class="nxl-mtext">Profile</span>
                    </a>
                </li>

                <li class="nxl-item">
                    <a href="#" class="nxl-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="nxl-micon"><i class="feather-log-out"></i></span>
                        <span class="nxl-mtext">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>