<style>
/* FIXED SIDEBAR LAYOUT */
.nxl-navigation {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 260px;
    height: 100vh;
}

/* HEADER (logo) */
.nxl-navigation .m-header {
    height: 70px;
    flex-shrink: 0;
}

/* WRAPPER FLEX */
.nxl-navigation .navbar-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* ONLY THIS AREA SCROLLS */
.nxl-navigation .navbar-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding-bottom: 40px;
}

/* Smooth scroll */
.nxl-navigation .navbar-content::-webkit-scrollbar {
    width: 6px;
}
.nxl-navigation .navbar-content::-webkit-scrollbar-thumb {
    background: rgba(120,120,120,.4);
    border-radius: 10px;
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

                {{-- ================= HOSPITAL ================= --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-cast"></i></span>
                        <span class="nxl-mtext">Hospitals</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.hospitals.index') }}">
                                All Hospitals
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.hospitals.create') }}">
                                Add Hospital
                            </a>
                        </li>
                    </ul>
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
        {{-- SCROLL AREA (IMPORTANT) --}}
        <div class="navbar-content">
            <ul class="nxl-navbar">

                <li class="nxl-item nxl-caption">
                    <label>Modules</label>
                </li>

                @foreach($sidebarModules as $module)

                    {{-- PARENT --}}
                    @if($module->children->count() > 0)

                        <li class="nxl-item nxl-hasmenu">
                            <a href="javascript:void(0);" class="nxl-link">
                                <span class="nxl-micon">
                                    <i class="{{ $module->icon ?? 'feather-grid' }}"></i>
                                </span>
                                <span class="nxl-mtext">{{ $module->module_display_name }}</span>
                                <span class="nxl-arrow">
                                    <i class="feather-chevron-right"></i>
                                </span>
                            </a>

                            <ul class="nxl-submenu">
                                @foreach($module->children as $child)
                                    <li class="nxl-item">
                                        <a href="{{ url($child->file_url) }}" class="nxl-link">
                                            {{ $child->module_display_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    @else

                        {{-- SINGLE --}}
                        <li class="nxl-item">
                            <a href="{{ url($module->file_url) }}" class="nxl-link">
                                <span class="nxl-micon">
                                    <i class="{{ $module->icon ?? 'feather-circle' }}"></i>
                                </span>
                                <span class="nxl-mtext">{{ $module->module_display_name }}</span>
                            </a>
                        </li>

                    @endif

                @endforeach

                {{-- ================= CONFIGURATION ================= --}}
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

                {{-- ================Bed Management================== --}}
<li class="nxl-item nxl-hasmenu">
    <a href="javascript:void(0);" class="nxl-link">
        <span class="nxl-micon"><i class="feather-layers"></i></span>
        <span class="nxl-mtext">Bed Management</span>
        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
    </a>

    <ul class="nxl-submenu">

        {{-- All Beds --}}
        <li class="nxl-item">
            <a href="{{ route('admin.beds.index') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-list"></i></span>
                <span class="nxl-mtext">All Beds</span>
            </a>
        </li>

        {{-- Add Bed --}}
        <li class="nxl-item">
            <a href="{{ route('admin.beds.create') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                <span class="nxl-mtext">Add Bed</span>
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