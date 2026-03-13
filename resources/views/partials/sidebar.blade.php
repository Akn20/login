@php
    $user = auth()->user();
@endphp

<style>
    /* 1. Sidebar Container */
    .nxl-navigation {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 260px;
        height: 100vh;
        /* Lock to viewport height */
        z-index: 1000;
        background: #ffffff;
        border-right: 1px solid #e3e7ed;
        display: flex;
        /* Crucial for child height calculation */
        flex-direction: column;
    }

    .nxl-navigation .navbar-wrapper {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        /* Occupy full sidebar height */
        overflow: hidden;
        /* Prevent wrapper from scrolling */
    }

    /* 2. THE SCROLL AREA - This is where the fix happens */
    .nxl-navigation .navbar-content {
        flex: 1;
        /* Take up all remaining space below the logo */
        overflow-y: auto !important;
        /* Force vertical scroll */
        overflow-x: hidden;
        padding-bottom: 100px;
        /* Space for the last menu items */
        display: block;
        height: auto;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
        /* Smooth scroll for mobile */
    }

    /* Ensure the UL inside doesn't collapse */
    .nxl-navbar {
        display: block;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    /* Custom Scrollbar */
    .nxl-navigation .navbar-content::-webkit-scrollbar {
        width: 5px;
    }

    .nxl-navigation .navbar-content::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
</style>

<nav class="nxl-navigation" id="sidebar-nav">
    <div class="navbar-wrapper">

        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" alt="" class="logo logo-lg">
            </a>
        </div>

        <div class="navbar-content" id="sidebar-scroll-area" up-nav>
            <ul class="nxl-navbar">

                {{-- --- 1. MAIN --- --}}
                <li class="nxl-item nxl-caption"><label>Main</label></li>
                <li class="nxl-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nxl-link" up-follow up-target="#main-container">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- --- 2. FRONT DESK --- --}}
                <li class="nxl-item nxl-caption"><label>Front Desk</label></li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-check-square"></i></span>
                        <span class="nxl-mtext">Receptionist</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.appointments.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-calendar me-2"></i>Appointments</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.tokens.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-list me-2"></i>Token & Queue</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Patient Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.patients.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-users me-2"></i>All Patients</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.patients.create') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-user-plus me-2"></i>Add Patient</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.patients.duplicates') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-copy me-2"></i>Duplicates</a>
                        </li>
                    </ul>
                </li>

                {{-- --- 3. MEDICAL SERVICES --- --}}
                <li class="nxl-item nxl-caption"><label>Medical Services</label></li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-heart"></i></span>
                        <span class="nxl-mtext">Doctor Desk</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('doctor.view-appointment') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-file-text me-2"></i>OPD List</a></li>
                        <li class="nxl-item"><a href="{{ route('doctor.view-consultations') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-message-square me-2"></i>Consultations</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-star"></i></span>
                        <span class="nxl-mtext">Surgery & OT</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('surgery.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-clipboard me-2"></i>Surgery List</a></li>
                        <li class="nxl-item"><a href="{{ route('surgery.create') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-plus-circle me-2"></i>Schedule Surgery</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('ot.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-map me-2"></i>OT Management</a></li>
                        <li class="nxl-item"><a href="{{ route('post.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-plus-square me-2"></i>Post-Op Notes</a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Bed Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.beds.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-box me-2"></i>All Beds</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.beds.create') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-plus-circle me-2"></i>Add Bed</a></li>
                    </ul>
                </li>

                {{-- --- 4. CLINICAL MANAGEMENT (PHARMACY/INVENTORY) --- --}}
                <li class="nxl-item nxl-caption"><label>Clinical Management</label></li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shopping-bag"></i></span>
                        <span class="nxl-mtext">Pharmacy</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.vendors.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-truck me-2"></i>Vendors</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.grn.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-file-text me-2"></i>GRN Entry</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.stock.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-box me-2"></i>Stock</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.expiry.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-alert-triangle me-2"></i>Expiry</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.controlledDrug.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-lock me-2"></i>Controlled
                                Drug</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.prescriptions.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-edit-3 me-2"></i>Prescriptions</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.salesReturn.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-rotate-ccw me-2"></i>Sales Return</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-package"></i></span>
                        <span class="nxl-mtext">Inventory</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.inventory.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-grid me-2"></i>All Items</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.inventory.purchase-orders.index') }}"
                                class="nxl-link" up-follow up-target="#main-container"><i
                                    class="feather-shopping-cart me-2"></i>Purchase Orders</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.inventory-vendors.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-users me-2"></i>Inv. Vendors</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.inventory.grns.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-file-text me-2"></i>GRN List</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.inventory.reports') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-pie-chart me-2"></i>Inv. Reports</a></li>
                    </ul>
                </li>

                {{-- --- 5. HR MANAGEMENT --- --}}
                <li class="nxl-item nxl-caption"><label>Human Resources</label></li>
                <li class="nxl-item">
                    <a href="{{ route('hr.staff-management.index') }}" class="nxl-link" up-follow
                        up-target="#main-container">
                        <span class="nxl-micon"><i class="feather-user-check"></i></span>
                        <span class="nxl-mtext">Staff Directory</span>
                    </a>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-clock"></i></span>
                        <span class="nxl-mtext">Leave Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('hr.leave-application.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-mail me-2"></i>Applications</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-approvals.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-check-circle me-2"></i>Approvals</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-approvals.approved') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-thumbs-up me-2"></i>Approved
                                Leave</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-adjustments.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-sliders me-2"></i>Adjustments</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.weekends.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-sun me-2"></i>Weekends</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.holidays.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-flag me-2"></i>Holidays</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.compoffs.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-plus me-2"></i>Comp-Off</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-type.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-tag me-2"></i>Leave Type</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.leave-mappings.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-map me-2"></i>Leave Mappings</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-calendar"></i></span>
                        <span class="nxl-mtext">Attendance</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('hr.attendance.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-edit me-2"></i>Entry</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.attendance.lateEntries') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-watch me-2"></i>Late Entries</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('hr.attendance.overtime') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-trending-up me-2"></i>Overtime</a></li>
                        <li class="nxl-item"><a href="{{ route('hr.attendance.dailyReport') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-file me-2"></i>Daily Report</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('hr.attendance.monthlyReport') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-bar-chart me-2"></i>Monthly
                                Report</a></li>
                    </ul>
                </li>

                {{-- --- 6. SHIFT SCHEDULING --- --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-watch"></i></span>
                        <span class="nxl-mtext">Shift Scheduling</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.shifts.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-clock me-2"></i>Shift Types</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-assignments.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-user me-2"></i>Assignments</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-rotations.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-refresh-cw me-2"></i>Rotations</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.weekly-offs.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-sun me-2"></i>Weekly Offs</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.shift-conflicts.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-alert-octagon me-2"></i>Conflicts</a></li>
                    </ul>
                </li>

                {{-- --- 7. SYSTEM ADMINISTRATION --- --}}
                <li class="nxl-item nxl-caption"><label>Administration</label></li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shield"></i></span>
                        <span class="nxl-mtext">Access Control</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.users.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-user me-2"></i>All Users</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.roles.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-lock me-2"></i>Roles & Perms</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">System Config</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.financial-years.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-hash me-2"></i>Fin. Years</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.financial-years.mapping') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-link me-2"></i>FY Mapping</a>
                        </li>
                        <li class="nxl-item"><a href="{{ route('admin.modules.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-grid me-2"></i>Modules</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.hospitals.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-home me-2"></i>Hospitals</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.organization.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-briefcase me-2"></i>Organizations</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.institutions.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i
                                    class="feather-aperture me-2"></i>Institutions</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-database"></i></span>
                        <span class="nxl-mtext">Master Data</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a href="{{ route('admin.religion.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-heart me-2"></i>Religion</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.job-type.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-briefcase me-2"></i>Job Type</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.work-status.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-user-check me-2"></i>Work Status</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.designation.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-award me-2"></i>Designation</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.blood-groups.index') }}" class="nxl-link"
                                up-follow up-target="#main-container"><i class="feather-droplet me-2"></i>Blood
                                Group</a></li>
                        <li class="nxl-item"><a href="{{ route('admin.departments.index') }}" class="nxl-link" up-follow
                                up-target="#main-container"><i class="feather-layers me-2"></i>Department</a></li>
                    </ul>
                </li>

                {{-- --- DYNAMIC MODULES --- --}}
                <li class="nxl-item nxl-caption"><label>External Modules</label></li>
                @foreach($sidebarModules as $module)
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-menu"></i></span>
                            <span class="nxl-mtext">{{ $module->module_display_name }}</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            @foreach($module->children as $child)
                                <li class="nxl-item"><a href="{{ url($child->file_url) }}" class="nxl-link" up-follow
                                        up-target="#main-container">{{ $child->module_display_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                {{-- --- ACCOUNT --- --}}
                <li class="nxl-item nxl-caption"><label>Account</label></li>
                <li class="nxl-item">
                    <a href="#" class="nxl-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="nxl-micon text-danger"><i class="feather-log-out"></i></span>
                        <span class="nxl-mtext text-danger">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>

{{-- SCROLL PERSISTENCE SCRIPT --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollArea = document.getElementById('sidebar-scroll-area');
        const storageKey = 'sidebar_scroll_pos';

        // Restore position
        const savedPos = localStorage.getItem(storageKey);
        if (savedPos) { scrollArea.scrollTop = savedPos; }

        // Save position on scroll
        scrollArea.addEventListener('scroll', function () {
            localStorage.setItem(storageKey, scrollArea.scrollTop);
        });

        // Maintain position during Unpoly AJAX loads
        if (window.up) {
            up.on('up:link:follow', function () {
                localStorage.setItem(storageKey, scrollArea.scrollTop);
            });
        }
    });
</script>