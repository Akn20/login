@php
    $user = auth()->user();
@endphp

<style>
    .nxl-navigation {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 260px;
        height: 100vh;
    }

    .nxl-navigation .m-header {
        height: 70px;
        flex-shrink: 0;
    }

    .nxl-navigation .navbar-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .nxl-navigation .navbar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 40px;
    }

    .nxl-navigation .navbar-content::-webkit-scrollbar {
        width: 6px;
    }

    .nxl-navigation .navbar-content::-webkit-scrollbar-thumb {
        background: rgba(120, 120, 120, .4);
        border-radius: 10px;
    }
</style>

<nav class="nxl-navigation">
    <div class="navbar-wrapper">

        {{-- HEADER / LOGO --}}
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" alt="" class="logo logo-lg">
                <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm">
            </a>
        </div>

        {{-- MAIN SCROLLABLE CONTENT --}}
        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- MAIN --}}
                <li class="nxl-item nxl-caption">
                    <label>Main</label>
                </li>

                <li class="nxl-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- ACCESS CONTROL --}}
                <li class="nxl-item nxl-caption">
                    <label>Access Control</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Users</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.users.index') }}" class="nxl-link">All Users</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.users.create') }}" class="nxl-link">Add User</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shield"></i></span>
                        <span class="nxl-mtext">Roles &amp; Permissions</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.roles.index') }}" class="nxl-link">All Roles</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.roles.create') }}" class="nxl-link">Add Role</a>
                        </li>
                    </ul>
                </li>

                {{-- APP MANAGEMENT --}}
                <li class="nxl-item nxl-caption">
                    <label>App Management</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">System</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.financial-years.index') }}"
                                class="nxl-link">Financial Years</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.financial-years.mapping') }}"
                                class="nxl-link">FY–Hospital Mapping</a></li>
                    </ul>
                </li>

                {{-- NAVIGATION --}}
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Hospitals</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.hospitals.index') }}">All
                                Hospitals</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.hospitals.create') }}">Add
                                Hospital</a></li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                        <span class="nxl-mtext">Organization</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.organization.index') }}">All
                                Organizations</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.organization.create') }}">Add
                                Organization</a></li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-aperture"></i></span>
                        <span class="nxl-mtext">Institution</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.institutions.index') }}">All
                                Institutions</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.institutions.create') }}">Add
                                Institution</a></li>
                    </ul>
                </li>

                {{-- MODULES MANAGEMENT --}}
                <li class="nxl-item nxl-caption">
                    <label>Modules</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Modules Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.modules.index') }}" class="nxl-link">Manage
                                Modules</a></li>
                        @foreach($sidebarModules as $module)
                            @if($module->children->count() > 0)
                                <li class="nxl-item nxl-hasmenu">
                                    <a href="javascript:void(0);" class="nxl-link">
                                        <span class="nxl-mtext">{{ $module->module_display_name }}</span>
                                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                                    </a>
                                    <ul class="nxl-submenu">
                                        @foreach($module->children as $child)
                                            <li class="nxl-item"><a href="{{ url($child->file_url) }}"
                                                    class="nxl-link">{{ $child->module_display_name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nxl-item"><a href="{{ url($module->file_url) }}"
                                        class="nxl-link">{{ $module->module_display_name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                {{-- CLINICAL MANAGEMENT --}}
                <li class="nxl-item nxl-caption">
                    <label>Clinical Management</label>
                </li>

                {{-- Inventory --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-package"></i></span>
                        <span class="nxl-mtext">Inventory</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.inventory.index') }}">All
                                Items</a></li>
                        <li class="nxl-item"><a class="nxl-link"
                                href="{{ route('admin.inventory.purchase-orders.index') }}">Purchase Orders</a></li>
                        <li class="nxl-item"><a class="nxl-link"
                                href="{{ route('admin.inventory-vendors.index') }}">Vendors</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.inventory.grns.index') }}">GRN
                                List</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.inventory.reports') }}">Reports
                                Dashboard</a></li>
                    </ul>
                </li>

                {{-- Configuration --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-sliders"></i></span>
                        <span class="nxl-mtext">Configuration</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.religion.index') }}" class="nxl-link">Religion</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.job-type.index') }}" class="nxl-link">Job Type</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.work-status.index') }}" class="nxl-link">Work
                                Status</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.designation.index') }}"
                                class="nxl-link">Designation</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.blood-groups.index') }}" class="nxl-link">Blood
                                Group</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.departments.index') }}"
                                class="nxl-link">Department</a></li>
                    </ul>
                </li>

                {{-- Pharmacy --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shopping-bag"></i></span>
                        <span class="nxl-mtext">Pharmacy</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.vendors.index') }}" class="nxl-link">Vendor
                                Management</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.grn.index') }}" class="nxl-link">Goods
                                Receipt(GRN)</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.stock.index') }}" class="nxl-link">Stock
                                Management</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.expiry.index') }}" class="nxl-link">Expiry
                                Management</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.controlledDrug.index') }}"
                                class="nxl-link">Controlled Drug</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.prescriptions.index') }}"
                                class="nxl-link">Prescriptions</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.salesReturn.index') }}" class="nxl-link">Sales
                                Return</a></li>
                    </ul>
                </li>

                {{-- Bed Management --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Bed Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.beds.index') }}" class="nxl-link">All Beds</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.beds.create') }}" class="nxl-link">Add Bed</a>
                        </li>
                    </ul>
                </li>

                {{-- Receptionist --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-check-square"></i></span>
                        <span class="nxl-mtext">Receptionist</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.appointments.index') }}"
                                class="nxl-link">Appointments</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.tokens.index') }}" class="nxl-link">Token &
                                Queue</a></li>
                    </ul>
                </li>

                {{-- Patient Management --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Patient Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.patients.index') }}" class="nxl-link">All
                                Patients</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.patients.create') }}" class="nxl-link">Add
                                Patient</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.patients.duplicates') }}"
                                class="nxl-link">Duplicate Patients</a></li>
                    </ul>
                </li>

                {{-- HR MANAGEMENT --}}
                <li class="nxl-item nxl-caption">
                    <label>HR Management</label>
                </li>

                <li class="nxl-item {{ request()->routeIs('hr.staff-management.*') ? 'active' : '' }}">
                    <a href="{{ route('hr.staff-management.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-user-check"></i></span>
                        <span class="nxl-mtext">Staff Management</span>
                    </a>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-clock"></i></span>
                        <span class="nxl-mtext">Leave Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('hr.weekends.index') }}" class="nxl-link">Weekend
                                Holiday</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.holidays.index') }}" class="nxl-link">Holidays
                                List</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.compoffs.index') }}" class="nxl-link">Comp-Off</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-type.index') }}" class="nxl-link">Leave
                                Type</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-application.index') }}"
                                class="nxl-link">Application</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-approvals.index') }}"
                                class="nxl-link">Approvals</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-approvals.approved') }}"
                                class="nxl-link">Approved Leave</a></li>
                    </ul>
                </li>

                {{-- SHIFT MANAGEMENT
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-watch"></i></span>
                        <span class="nxl-mtext">Shift Scheduling</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.shifts.index') }}" class="nxl-link">Shift
                                Types</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-assignments.index') }}"
                                class="nxl-link">Shift Assignments</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-rotations.index') }}"
                                class="nxl-link">Rotational Shifts</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.weekly-offs.index') }}" class="nxl-link">Weekly
                                Offs</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-conflicts.index') }}"
                                class="nxl-link">Conflicts</a></li>
                    </ul>
                </li> --}}

                {{-- DOCTOR & SURGERY --}}
                <li class="nxl-item nxl-caption">
                    <label>Medical Services</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Surgery Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('surgery.index') }}" class="nxl-link">Surgery List</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('surgery.create') }}" class="nxl-link">Schedule
                                Surgery</a></li>
                        <li class="nxl-item"><a href="{{ route('ot.index') }}" class="nxl-link">OT Management</a></li>
                        <li class="nxl-item"><a href="{{ route('post.index') }}" class="nxl-link">Post-Op Notes</a></li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-heart"></i></span>
                        <span class="nxl-mtext">Doctor Desk</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('doctor.view-appointment') }}" class="nxl-link">OPD
                                Appointments</a></li>
                        <li class="nxl-item"><a href="{{ route('doctor.view-consultations') }}"
                                class="nxl-link">Consultations</a></li>
                    </ul>
                </li>

                {{-- ACCOUNT --}}
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
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>