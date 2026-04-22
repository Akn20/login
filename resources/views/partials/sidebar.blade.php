@php
    $user = auth()->user();
@endphp

<div class="navbar-wrapper">
    {{-- LOGO SECTION --}}
    <div class="m-header">
        <a href="{{ route('admin.dashboard') }}" class="b-brand" up-follow up-target="#main-container">
            <img src="{{ asset('assets/images/logo-full.png') }}" alt="" class="logo logo-lg">
        </a>
    </div>

    {{-- SCROLLABLE CONTENT AREA --}}
    <div class="navbar-content" id="sidebar-scroll-area" up-nav>
        <ul class="nxl-navbar">

            {{-- --- 1. MAIN --- --}}
            <li class="nxl-item nxl-caption"><label>Main</label></li>

            @php
                $user = auth()->user();
                $route = $user && $user->role === 'admin'
                    ? 'admin.dashboard'
                    : 'hr.dashboard';
            @endphp

            <li class="nxl-item {{ request()->routeIs($route) ? 'active' : '' }}">
                <a href="{{ route($route) }}" class="nxl-link" up-follow up-target="#main-container">
                    <span class="nxl-micon"><i class="feather-activity"></i></span>
                    <span class="nxl-mtext">Dashboard</span>
                </a>
            </li>

            {{-- --- 2. FRONT DESK --- --}}
            <li class="nxl-item nxl-caption"><label>Front Desk</label></li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/appointments*', 'admin/tokens*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-check-square"></i></span>
                    <span class="nxl-mtext">Receptionist</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.appointments.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-calendar me-2"></i>Appointments</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.receptionist.ipd.index') }}" class="nxl-link" up-follow 
                    up-target="#main-container"><i class="fas fa-procedures me-2"></i>IPD Admission</a></li>       
                    <li class="nxl-item"><a href="{{ route('admin.tokens.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-list me-2"></i>Token & Queue</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.emergency.create') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-activity me-2"></i>Emergency Cases</a></li>
                </ul>
            </li>
            <li class="nxl-item nxl-hasmenu {{ request()->is('admin/patients*') ? 'active nxl-trigger' : '' }}">
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
                    <li class="nxl-item"><a href="{{ route('admin.patients.duplicates') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-copy me-2"></i>Duplicates</a></li>
                </ul>
            </li>

            {{-- --- 3. MEDICAL SERVICES --- --}}
            <li class="nxl-item nxl-caption"><label>Medical Services</label></li>
            <li class="nxl-item nxl-hasmenu {{ request()->is('doctor/*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-heart"></i></span>
                    <span class="nxl-mtext">Doctor Desk</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('doctor.view-appointment') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-file-text me-2"></i>OPD List</a></li>
                    <li class="nxl-item"><a href="{{ route('doctor.view-consultations') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-message-square me-2"></i>Consultations</a>
                    </li>
                </ul>
            </li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('surgery*', 'ot*', 'postoperative*') ? 'active nxl-trigger' : '' }}">
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
                            up-target="#main-container"><i class="feather-plus-square me-2"></i>Post-Op Notes</a></li>
                </ul>
            </li>
            <li class="nxl-item nxl-hasmenu {{ request()->is('admin/beds*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-layers"></i></span>
                    <span class="nxl-mtext" style="font-size: 12px;">Bed & Ward Management</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.ward.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-box me-2"></i>All Wards</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.ward.create') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-plus-circle me-2"></i>Add Ward</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.beds.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-box me-2"></i>All Beds</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.beds.create') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-plus-circle me-2"></i>Add Bed</a></li>
                </ul>
            </li>

            {{-- --- 4. CLINICAL MANAGEMENT (PHARMACY/INVENTORY) --- --}}
            <li class="nxl-item nxl-caption"><label>Clinical Management</label></li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/pharmacy*', 'admin/vendors*', 'admin/stock*', 'admin/expiry*', 'admin/controlledDrug*', 'admin/prescriptions*', 'admin/salesReturn*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-shopping-bag"></i></span>
                    <span class="nxl-mtext">Pharmacy</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
               <ul class="nxl-submenu">

    <li class="nxl-item">
        <a href="{{ route('admin.pharmacy.dashboard') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.vendors.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-truck me-2"></i> Vendors
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.grn.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-file-text me-2"></i> GRN Entry
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.stock.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-box me-2"></i> Stock
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.expiry.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-alert-triangle me-2"></i> Expiry
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.controlledDrug.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-lock me-2"></i> Controlled Drug
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.prescriptions.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-edit-3 me-2"></i> Prescriptions
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.pharmacy.billing.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-dollar-sign"></i> Billing
        </a>
    </li>

    <li class="nxl-item">
        <a href="{{ route('admin.salesReturn.index') }}" class="nxl-link" up-follow up-target="#main-container">
            <i class="feather-rotate-ccw me-2"></i> Sales Return
        </a>
    </li>
    <!-- ✅ REPORTS DROPDOWN -->
    <li class="nxl-item has-submenu">
        <a href="javascript:void(0);" class="nxl-link">
            <i class="feather-bar-chart-2"></i> Reports
        </a>

        <ul class="nxl-submenu">

            <li class="nxl-item">
                <a href="{{ route('admin.reports.sales') }}" class="nxl-link">Sales Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.medicine') }}" class="nxl-link">Medicine Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.batch') }}" class="nxl-link">Batch Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.expiry') }}" class="nxl-link">Expiry Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.lowstock') }}" class="nxl-link">Low Stock</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.controlled') }}" class="nxl-link">Controlled Drugs</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.vendor') }}" class="nxl-link">Vendor Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.grn') }}" class="nxl-link">GRN Report</a>
            </li>

            <li class="nxl-item">
                <a href="{{ route('admin.reports.billing') }}" class="nxl-link">Billing Report</a>
            </li>

        </ul>
    </li>
    

</ul>
            </li>

            {{-- ================= Nurse Module ================= --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-heart"></i></span>
                        <span class="nxl-mtext">Nurse</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>

                    <ul class="nxl-submenu">
                    <li class="nxl-item">
                        <a href="{{ route('admin.nursing-notes.index') }}" class="nxl-link">
                            <span class="nxl-micon">
                                <i class="feather-calendar"></i>
                            </span>
                            <span class="nxl-mtext">Nursing Notes </span>
                        </a>
                    </li>
                </ul>

                    <ul class="nxl-submenu">

                        <li class="nxl-item">
                            <a href="{{ route('admin.patientMonitoring.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-activity"></i></span>
                                <span class="nxl-mtext">Patient Monitoring</span>
                            </a>
                        </li>

                    </ul>

                    <ul class="nxl-submenu">

                        <li class="nxl-item">
                            <a href="{{ route('admin.medication.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="feather-activity"></i></span>
                                <span class="nxl-mtext">Medication Administration</span>
                            </a>
                        </li>

                    </ul>

                    

                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.nurse-shifts.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="nav-icon fas fa-clock"></i></span>
                                <span class="nxl-mtext">Shift Management</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.nurse-discharge.index') }}" class="nxl-link">
                                <span class="nxl-micon"><i class="fas fa-procedures"></i></span>
                                <span class="nxl-mtext">Discharge Preparation</span>
                            </a>
                        </li>
                   

                    <li class="nxl-item has-submenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <i class="feather-bar-chart-2"></i> Reports
                        </a>

                        <ul class="nxl-submenu">
                            <li class="nxl-item">
                                <a href="{{ route('admin.nurse-reports.vitals') }}" class="nxl-link"> Vitals Report</a>
                            </li>

                            <li class="nxl-item">
                                <a href="{{ route('admin.nurse-reports.medications') }}" class="nxl-link">Medication Report </a>
                            </li>
                            
                            <li class="nxl-item">
                                <a href="{{ route('admin.nurse-reports.shift') }}" class="nxl-link">Shift Report</a>
                            </li>

                            <li class="nxl-item">
                                <a href="{{ route('admin.nurse-reports.patient-summary') }}" class="nxl-link">Patient Summary</a>
                            </li>
                        </ul>
                    </li>
                    </ul>
                                    
                   
                </li> 

            <li class="nxl-item nxl-hasmenu {{ request()->is('admin/inventory*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-package"></i></span>
                    <span class="nxl-mtext">Inventory</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.inventory.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-grid me-2"></i>All Items</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.inventory.purchase-orders.index') }}" class="nxl-link"
                            up-follow up-target="#main-container"><i class="feather-shopping-cart me-2"></i>Purchase
                            Orders</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.inventory-vendors.index') }}" class="nxl-link"
                            up-follow up-target="#main-container"><i class="feather-users me-2"></i>Inv. Vendors</a>
                    </li>
                    <li class="nxl-item"><a href="{{ route('admin.inventory.grns.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-file-text me-2"></i>GRN List</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.inventory.reports') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-pie-chart me-2"></i>Inv. Reports</a></li>
                </ul>
            </li>

            {{-- --- 5. HR MANAGEMENT --- --}}
            <li class="nxl-item nxl-caption"><label>Human Resources</label></li>
            <li class="nxl-item {{ request()->is('hr/staff-management*') ? 'active' : '' }}">
                <a href="{{ route('hr.staff-management.index') }}" class="nxl-link" up-follow
                    up-target="#main-container">
                    <span class="nxl-micon"><i class="feather-user-check"></i></span>
                    <span class="nxl-mtext">Staff Directory</span>
                </a>
            </li>
            <li class="nxl-item {{ request()->is('hr/edm*') ? 'active' : '' }}">
                <a href="{{ route('hr.edm.index') }}" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-folder"></i></span>
                    <span class="nxl-mtext">Employee Documents</span>
                </a>
            </li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('hr/leave-*', 'hr/weekends*', 'hr/holidays*', 'hr/compoffs*', 'hr/leave-report*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-clock"></i></span>
                    <span class="nxl-mtext">Leave Management</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('hr.leave-application.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-mail me-2"></i>Applications</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.leave-approvals.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-check-circle me-2"></i>Approvals</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.leave-approvals.approved') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-thumbs-up me-2"></i>Approved Leave</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.leave-adjustments.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-sliders me-2"></i>Adjustments</a></li>
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
                    <li class="nxl-item">
                        <a href="{{ route('hr.leave-report.index') }}" class="nxl-link" up-follow
                            up-target="#main-container">
                            <i class="feather-bar-chart-2 me-2"></i>Leave Report
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nxl-item nxl-hasmenu {{ request()->is('hr/attendance*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-calendar"></i></span>
                    <span class="nxl-mtext">Attendance</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('hr.attendance.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-edit me-2"></i>Entry</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.attendance.lateEntries') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-watch me-2"></i>Late Entries</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.attendance.overtime') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-trending-up me-2"></i>Overtime</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.attendance.dailyReport') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-file me-2"></i>Daily Report</a></li>
                    <li class="nxl-item"><a href="{{ route('hr.attendance.monthlyReport') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-bar-chart me-2"></i>Monthly Report</a></li>
                </ul>
            </li>

            {{-- --- 6. SHIFT SCHEDULING --- --}}
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/shifts*', 'admin/shift-*', 'admin/weekly-offs*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-watch"></i></span>
                    <span class="nxl-mtext">Shift Scheduling</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.shifts.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-clock me-2"></i>Shift Types</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.shift-assignments.index') }}" class="nxl-link"
                            up-follow up-target="#main-container"><i class="feather-user me-2"></i>Assignments</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.shift-rotations.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-refresh-cw me-2"></i>Rotations</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.weekly-offs.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-sun me-2"></i>Weekly Offs</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.shift-conflicts.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-alert-octagon me-2"></i>Conflicts</a></li>
                </ul>
            </li>

            <li class="nxl-item nxl-hasmenu {{ request()->is('hr/payroll*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-dollar-sign"></i></span>
                    <span class="nxl-mtext">Payroll</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
             <ul class="nxl-submenu">

  

    <li class="nxl-item {{ request('type') == 'fixed' ? 'active' : '' }}">
        <a href="{{ route('hr.payroll.allowance.index',['type' => 'fixed']) }}"
           class="nxl-link">
            <i class="feather-dollar-sign me-2"></i>
            Fixed Allowances
        </a>
    </li>

    <li class="nxl-item {{ request('type') == 'variable' ? 'active' : '' }}">
        <a href="{{ route('hr.payroll.allowance.index',['type' => 'variable']) }}"
           class="nxl-link">
            <i class="feather-repeat me-2"></i>
            Variable Allowances
        </a>
    </li>



    {{-- DEDUCTION --}}
    <li class="nxl-item">
        <a href="{{ route('hr.payroll.deduction.index') }}"
           class="nxl-link {{ request()->routeIs('hr.payroll.deduction.index') ? 'active' : '' }}"
           up-follow up-target="#main-container">
            <i class="feather-minus-circle me-2"></i>Deductions
        </a>
    </li>

</ul>
            </li>



            {{-- --- 7. SYSTEM ADMINISTRATION --- --}}
            <li class="nxl-item nxl-caption"><label>Administration</label></li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/users*', 'admin/roles*') ? 'active nxl-trigger' : '' }}">
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
                    <li class="nxl-item"><a href="{{ route('admin.users.biometrics') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-fingerprint me-2"></i>Biometrics</a>
                    </li>
                </ul>
            </li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/financial-years*', 'admin/hospitals*', 'admin/organization*', 'admin/institutions*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-settings"></i></span>
                    <span class="nxl-mtext">System Config</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.financial-years.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-hash me-2"></i>Fin.
                            Years</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.financial-years.mapping') }}" class="nxl-link"
                            up-follow up-target="#main-container"><i class="feather-link me-2"></i>FY
                            Mapping</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.hospitals.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-home me-2"></i>Hospitals</a>
                    </li>
                    <li class="nxl-item"><a href="{{ route('admin.organization.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-briefcase me-2"></i>Organizations</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.institutions.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-aperture me-2"></i>Institutions</a></li>
                </ul>
            </li>
            <li
                class="nxl-item nxl-hasmenu {{ request()->is('admin/religion*', 'admin/job-type*', 'admin/work-status*', 'admin/designation*', 'admin/masters/blood-groups*', 'admin/departments*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-database"></i></span>
                    <span class="nxl-mtext">Master Data</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.religion.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-heart me-2"></i>Religion</a>
                    </li>
                    <li class="nxl-item"><a href="{{ route('admin.job-type.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-briefcase me-2"></i>Job
                            Type</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.work-status.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-user-check me-2"></i>Work
                            Status</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.designation.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-award me-2"></i>Designation</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.blood-groups.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-droplet me-2"></i>Blood
                            Group</a></li>
                    <li class="nxl-item"><a href="{{ route('admin.departments.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-layers me-2"></i>Department</a></li>
                </ul>
            </li>

            {{-- --- DYNAMIC MODULES --- --}}
            <li class="nxl-item nxl-caption"><label>External Modules</label></li>
            <li class="nxl-item nxl-hasmenu {{ request()->is('admin/modules*') ? 'active nxl-trigger' : '' }}">
                <a href="javascript:void(0);" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-layers"></i></span>
                    <span class="nxl-mtext">Module Management</span>
                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                </a>
                <ul class="nxl-submenu">
                    <li class="nxl-item"><a href="{{ route('admin.modules.index') }}" class="nxl-link" up-follow
                            up-target="#main-container"><i class="feather-grid me-2"></i>Add Modules</a></li>
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
                                            up-target="#main-container">{{ $child->module_display_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>

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

{{-- SCRIPT: Scroll Persistence & Unpoly Safety --}}
<script>
    (function () {
        const storageKey = 'sidebar_scroll_pos';

        function initSidebarLogic() {
            const scrollArea = document.getElementById('sidebar-scroll-area');
            if (!scrollArea) return;

            // Restore position
            scrollArea.scrollTop = localStorage.getItem(storageKey) || 0;

            // Save position on scroll
            scrollArea.addEventListener('scroll', function () {
                localStorage.setItem(storageKey, scrollArea.scrollTop);
            });
        }

        document.addEventListener("DOMContentLoaded", initSidebarLogic);

        // Maintenance during AJAX Loads
        if (window.up) {
            up.on('up:link:follow', function () {
                const scrollArea = document.getElementById('sidebar-scroll-area');
                if (scrollArea) localStorage.setItem(storageKey, scrollArea.scrollTop);
            });

            // Prevent blank page bug: reload if container is lost
            up.on('up:fragment:inserted', function (event) {
                if (!document.getElementById('main-container')) {
                    window.location.reload();
                }
            });
        }
    })();
</script>