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

                {{-- ================= MAIN ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Main</label>
                </li>

                <li class="nxl-item">
                    <a href="{{ route('admin.dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- ================= ACCESS CONTROL ================= --}}
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
                            <a href="{{ route('admin.users.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Users</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.users.create') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-user-plus"></i></span>
                                <span class="nxl-mtext">Add User</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.users.biometrics') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-user-check"></i></span>
                                <span class="nxl-mtext">Enroll User Biometrics</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Roles & Permissions --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shield"></i></span>
                        <span class="nxl-mtext">Roles &amp; Permissions</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.roles.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Roles</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.roles.create') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Role</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= ORGANIZATION ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Organization</label>
                </li>

                {{-- System (Financial Years, Mapping) --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0)" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">System</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.financial-years.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-calendar"></i></span>
                                <span class="nxl-mtext">Financial Years</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.financial-years.mapping') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-layers"></i></span>
                                <span class="nxl-mtext">FY–Hospital Mapping</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Hospitals --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Hospitals</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.hospitals.index') }}">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Hospitals</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.hospitals.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Hospital</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Organization --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                        <span class="nxl-mtext">Organization</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.organization.index') }}">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Organizations</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.organization.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Organization</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Institution --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-aperture"></i></span>
                        <span class="nxl-mtext">Institution</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.institutions.index') }}">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Institutions</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.institutions.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Institution</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Module Management --}}
                <li class="nxl-item">
                    <a href="{{ route('admin.modules.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Module Management</span>
                    </a>
                </li>

                {{-- ================= STAFF & HR ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Staff &amp; HR</label>
                </li>

                {{-- HR Management --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">HR Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('hr.staff-management.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-user-check"></i></span>
                                <span class="nxl-mtext">Staff Management</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Leave Management --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-clock"></i></span>
                        <span class="nxl-mtext">Leave Management</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.weekends.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-sun"></i></span>
                                <span class="nxl-mtext">Weekend Holiday</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.holidays.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-calendar"></i></span>
                                <span class="nxl-mtext">Holidays</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.leave-type.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-file-text"></i></span>
                                <span class="nxl-mtext">Leave Type</span>
                            </a>
                        </li>
                        <li class="nxl-item {{ request()->routeIs('admin.leave-mappings.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.leave-mappings.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-map"></i></span>
                                <span class="nxl-mtext">Leave Mapping</span>
                            </a>
                        </li>
                        <li class="nxl-item {{ request()->routeIs('admin.leave-adjustments.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.leave-adjustments.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-repeat"></i></span>
                                <span class="nxl-mtext">Leave Adjustment</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= CLINICAL OPERATIONS ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Clinical Operations</label>
                </li>

                {{-- Receptionist --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Receptionist</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.tokens.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">Token &amp; Queue Management</span>
                            </a>
                        </li>
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
                        <li class="nxl-item">
                            <a href="{{ route('admin.patients.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Patients</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.patients.create') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-user-plus"></i></span>
                                <span class="nxl-mtext">Add Patient</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.patients.duplicates') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-copy"></i></span>
                                <span class="nxl-mtext">Duplicate Patients</span>
                            </a>
                        </li>
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
                        <li class="nxl-item">
                            <a href="{{ route('admin.beds.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Beds</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.beds.create') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Bed</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.expiry.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-alert-triangle"></i></span>
                                <span class="nxl-mtext">Expiry Management</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.controlledDrug.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-shield"></i></span>
                                <span class="nxl-mtext">Controlled Drug Management</span>
                            </a>
                        </li>
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
                        <li class="nxl-item">
                            <a href="{{ route('admin.vendors.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-truck"></i></span>
                                <span class="nxl-mtext">Vendor Management</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.grn.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-file-plus"></i></span>
                                <span class="nxl-mtext">Goods Receipt (GRN)</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.stock.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-package"></i></span>
                                <span class="nxl-mtext">Stock Management</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= INVENTORY ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Inventory</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-package"></i></span>
                        <span class="nxl-mtext">Inventory</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        {{-- Items --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.index') }}">
                                <span class="nxl-micon"><i class="feather-list"></i></span>
                                <span class="nxl-mtext">All Items</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Item</span>
                            </a>
                        </li>

                        {{-- Purchase Orders --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.purchase-orders.index') }}">
                                <span class="nxl-micon"><i class="feather-file-text"></i></span>
                                <span class="nxl-mtext">Purchase Orders</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.purchase-orders.create') }}">
                                <span class="nxl-micon"><i class="feather-file-plus"></i></span>
                                <span class="nxl-mtext">Create Purchase Order</span>
                            </a>
                        </li>

                        {{-- Inventory Vendors --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory-vendors.index') }}">
                                <span class="nxl-micon"><i class="feather-truck"></i></span>
                                <span class="nxl-mtext">Vendors</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory-vendors.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Add Vendor</span>
                            </a>
                        </li>

                        {{-- GRN --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.grns.index') }}">
                                <span class="nxl-micon"><i class="feather-file-text"></i></span>
                                <span class="nxl-mtext">GRN List</span>
                            </a>
                        </li>

                        {{-- Stock Transfers --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.stock-transfers.index') }}">
                                <span class="nxl-micon"><i class="feather-repeat"></i></span>
                                <span class="nxl-mtext">Stock Transfers</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.stock-transfers.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">Create Stock Transfer</span>
                            </a>
                        </li>

                        {{-- Stock Audit --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.stock-audits.index') }}">
                                <span class="nxl-micon"><i class="feather-check-circle"></i></span>
                                <span class="nxl-mtext">Stock Audits</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.stock-audits.create') }}">
                                <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                                <span class="nxl-mtext">New Stock Audit</span>
                            </a>
                        </li>

                        {{-- Reports --}}
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.inventory.reports') }}">
                                <span class="nxl-micon"><i class="feather-bar-chart-2"></i></span>
                                <span class="nxl-mtext">Reports Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= CONFIGURATION ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Configuration</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-sliders"></i></span>
                        <span class="nxl-mtext">Configuration</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.religion.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-book"></i></span>
                                <span class="nxl-mtext">Religion</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.job-type.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                                <span class="nxl-mtext">Job Type</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.work-status.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-activity"></i></span>
                                <span class="nxl-mtext">Work Status</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.designation.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-tag"></i></span>
                                <span class="nxl-mtext">Designation</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.blood-groups.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-droplet"></i></span>
                                <span class="nxl-mtext">Blood Group</span>
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.departments.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-grid"></i></span>
                                <span class="nxl-mtext">Department</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= MODULES (DYNAMIC) ================= --}}
                <li class="nxl-item nxl-caption">
                    <label>Modules</label>
                </li>

                @foreach($sidebarModules as $module)
                    @if($module->children->count() > 0)
                        <li class="nxl-item nxl-hasmenu">
                            <a href="javascript:void(0);" class="nxl-link">
                                <span class="nxl-micon">
                                    <i class="{{ $module->icon ?? 'feather-layers' }}"></i>
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
                                            <span class="nxl-micon">
                                                <i class="{{ $child->icon ?? 'feather-circle' }}"></i>
                                            </span>
                                            <span class="nxl-mtext">{{ $child->module_display_name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
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

                {{-- ================= ACCOUNT ================= --}}
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
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>