USE `hims_main`;

-- Helpful: disable FK checks while seeding
SET
  FOREIGN_KEY_CHECKS = 0;

-- ===================== ORGANIZATIONS (UUID) =====================
INSERT INTO
  `organizations` (
    `id`,
    `name`,
    `type`,
    `registration_number`,
    `gst`,
    `address`,
    `city`,
    `state`,
    `country`,
    `pincode`,
    `contact_number`,
    `email`,
    `timezone`,
    `organization_url`,
    `software_url`,
    `logo`,
    `language`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'Demo Health Group',
    'Healthcare Group',
    'REG-001',
    'GST-001',
    NULL,
    'Mangalore',
    'Karnataka',
    'India',
    '575001',
    '9876543210',
    'info@demohealth.com',
    'Asia/Kolkata',
    NULL,
    NULL,
    NULL,
    'English',
    1,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== INSTITUTIONS (UUID, FK via subquery) =====================
INSERT INTO
  `institutions` (
    `id`,
    `organization_id`,
    `code`,
    `name`,
    `address`,
    `city`,
    `state`,
    `country`,
    `pincode`,
    `contact_number`,
    `email`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    (
      SELECT
        id
      FROM
        organizations
      LIMIT
        1
    ), 'INST-HQ', 'Demo Health HQ', 'Main Road, Someshwara', 'Mangalore', 'Karnataka', 'India', '575001', '9876543210', 'hq@demohealth.com', NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    (
      SELECT
        id
      FROM
        organizations
      LIMIT
        1
    ), 'INST-CLINIC', 'Demo Health Clinic', 'Near Bus Stand, Mangalore', 'Mangalore', 'Karnataka', 'India', '575001', '9876543210', 'clinic@demohealth.com', NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    (
      SELECT
        id
      FROM
        organizations
      LIMIT
        1
    ), 'INST-DIAG', 'Demo Diagnostics Center', 'City Center, Mangalore', 'Mangalore', 'Karnataka', 'India', '575002', '9876543211', 'diagnostics@demohealth.com', NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    (
      SELECT
        id
      FROM
        organizations
      LIMIT
        1
    ), 'INST-REHAB', 'Demo Rehabilitation Center', 'Beach Road, Mangalore', 'Mangalore', 'Karnataka', 'India', '575003', '9876543212', 'rehab@demohealth.com', NOW(),
    NOW(),
    NULL
  );

-- ===================== HOSPITALS (UUID, FK via subquery) =====================
INSERT INTO
  `hospitals` (
    `id`,
    `name`,
    `code`,
    `address`,
    `contact_number`,
    `institution_id`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'General Hospital',
    'HOSP-DH1',
    'Near Bus Stand, Mangalore',
    '9876543210',
    (
      SELECT
        id
      FROM
        institutions
      WHERE
        code = 'INST-HQ'
      LIMIT
        1
    ), 1, NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Critical Care Hospital',
    'HOSP-DH2',
    'City Center, Mangalore',
    '9876543211',
    (
      SELECT
        id
      FROM
        institutions
      WHERE
        code = 'INST-HQ'
      LIMIT
        1
    ), 1, NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Specialty Clinic',
    'HOSP-DH3',
    'Beach Road, Mangalore',
    '9876543212',
    (
      SELECT
        id
      FROM
        institutions
      WHERE
        code = 'INST-CLINIC'
      LIMIT
        1
    ), 1, NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Women & Children Hospital',
    'HOSP-DH4',
    'Market Road, Mangalore',
    '9876543213',
    (
      SELECT
        id
      FROM
        institutions
      WHERE
        code = 'INST-DIAG'
      LIMIT
        1
    ), 1, NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Rehabilitation Hospital',
    'HOSP-DH5',
    'Hilltop, Mangalore',
    '9876543214',
    (
      SELECT
        id
      FROM
        institutions
      WHERE
        code = 'INST-REHAB'
      LIMIT
        1
    ), 1, NOW(),
    NOW(),
    NULL
  );

-- ===================== MODULES (bigint auto / labels stable) =====================
INSERT INTO
  `modules` (
    `id`,
    `module_label`,
    `module_display_name`,
    `parent_module`,
    `priority`,
    `icon`,
    `file_url`,
    `page_name`,
    `type`,
    `access_for`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'dashboard',
    'Dashboard',
    NULL,
    1,
    'feather-activity',
    '/admin/dashboard',
    'Dashboard',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'access_control',
    'Access Control',
    NULL,
    2,
    'feather-lock',
    '/admin/access-control',
    'AccessControl',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'users',
    'Users',
    NULL,
    3,
    'feather-users',
    '/admin/users',
    'Users',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'roles',
    'Roles & Permissions',
    NULL,
    4,
    'feather-shield',
    '/admin/roles',
    'Roles',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'organization',
    'Organization',
    NULL,
    5,
    'feather-briefcase',
    '/admin/organization',
    'Organization',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'hospitals',
    'Hospitals',
    NULL,
    6,
    'feather-home',
    '/admin/hospitals',
    'Hospitals',
    'admin',
    'both',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'institutions',
    'Institutions',
    NULL,
    7,
    'feather-aperture',
    '/admin/institutions',
    'Institutions',
    'admin',
    'web',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'departments',
    'Departments',
    NULL,
    8,
    'feather-grid',
    '/admin/departments',
    'Departments',
    'admin',
    'web',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'staff',
    'Staff Management',
    NULL,
    9,
    'feather-user-check',
    '/hr/staff-management',
    'StaffManagement',
    'admin',
    'web',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'patients',
    'Patient Management',
    NULL,
    10,
    'feather-users',
    '/admin/patients',
    'Patients',
    'admin',
    'web',
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'inventory',
    'Inventory',
    NULL,
    11,
    'feather-package',
    '/admin/inventory',
    'Inventory',
    'admin',
    ('web'),
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'pharmacy',
    'Pharmacy',
    NULL,
    12,
    'feather-shopping-bag',
    '/admin/pharmacy',
    ('Pharmacy'),
    ('admin'),
    ('web'),
    1,
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'leave_mgmt',
    'Leave Management',
    NULL,
    13,
    'feather-clock',
    '/admin/leave-mappings',
    'LeaveManagement',
    'admin',
    'web',
    1,
    NOW(),
    NULL,
    NULL
  );

-- Link HQ institution to all modules by label
INSERT INTO
  `institution_module` (
    `institution_id`,
    `module_id`,
    `created_at`,
    `updated_at`
  )
SELECT
  (
    SELECT
      id
    FROM
      institutions
    WHERE
      code = 'INST-HQ'
    LIMIT
      1
  ) AS institution_id,
  m.id AS module_id,
  NOW(),
  NOW()
FROM
  modules m;

-- ===================== DEPARTMENT_MASTER (UUID) =====================
INSERT INTO
  `department_master` (
    `id`,
    `department_code`,
    `department_name`,
    `description`,
    `status`,
    `created_by`,
    `updated_by`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'OPD',
    'Outpatient Department (OPD)',
    'Outpatient Department',
    1,
    NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'IPD',
    'Inpatient Department (IPD)',
    'Inpatient Department',
    1,
    NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'EMERGENCY',
    'Emergency',
    'Emergency Department',
    1,
    NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'PHARMACY',
    'Pharmacy',
    'Pharmacy Department',
    1,
    NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'LAB',
    'Laboratory',
    'Laboratory / Diagnostics Dept',
    1,
    NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== DESIGNATION_MASTER (UUID, FK via subquery) =====================
INSERT INTO
  `designation_master` (
    `id`,
    `designation_code`,
    `designation_name`,
    `department_id`,
    `description`,
    `status`,
    `created_by`,
    `updated_by`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'DOC',
    'Doctor',
    (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), 'Medical Doctor', 1, NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'NUR',
    'Nurse',
    (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), 'Registered Nurse', 1, NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'PHARM',
    'Pharmacist',
    (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'PHARMACY'
      LIMIT
        1
    ), 'Pharmacy Incharge', 1, NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'REC',
    'Receptionist',
    (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), 'Front Desk / Reception Staff', 1, NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'ADMIN',
    'Administrator',
    (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), 'Hospital / System Administrator', 1, NULL,
    NULL,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== BLOOD_GROUP_MASTER (UUID + created_by) =====================
INSERT INTO
  `blood_group_master` (
    `id`,
    `blood_group_name`,
    `status`,
    `created_by`,
    `updated_by`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'A+',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'A-',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'B+',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'B-',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'O+',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'O-',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'AB+',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'AB-',
    'Active',
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== RELIGION_MASTER (UUID) =====================
INSERT INTO
  `religion_master` (
    `id`,
    `religion_name`,
    `status`,
    `display_order`,
    `created_by`,
    `updated_by`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'Hindu',
    'Active',
    1,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Christian',
    'Active',
    2,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Muslim',
    'Active',
    3,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Buddhist',
    'Active',
    4,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Jain',
    'Active',
    5,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Other',
    'Active',
    6,
    1,
    NULL,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== ROLES (UUID, enum status) =====================
INSERT INTO
  `roles` (
    `id`,
    `name`,
    `description`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'super_admin',
    'Super administrator with full access',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'hr',
    'Human resource',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'manager',
    'Manager role',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'hod',
    'Head of Department',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'doctor',
    'Doctor role',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'nurse',
    'Nurse role',
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'receptionist',
    'Reception / front desk',
    'active',
    NOW(),
    NOW(),
    NULL
  );

-- ===================== USER_ROLES (UUID FKs via subquery) =====================
INSERT INTO
  `users` (
    `id`,
    `name`,
    `mobile`,
    `email`,
    `role_id`,
    `mpin`,
    `is_enrolled`,
    `status`,
    `failed_attempts`,
    `locked_until`,
    `created_at`,
    `updated_at`,
    `deleted_at`,
    `biometric_updated_at`
  )
VALUES
  (
    UUID(),
    'Super Admin',
    '9000000001',
    'superadmin@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'super_admin'
      LIMIT
        1
    ), NULL,
    0,
    'active',
    0,
    NULL,
    NOW(),
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'HR Manager',
    '9000000002',
    'hr@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'hr'
      LIMIT
        1
    ), NULL,
    0,
    'active',
    0,
    NULL,
    NOW(),
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'General Manager',
    '9000000003',
    'manager@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'manager'
      LIMIT
        1
    ), NULL,
    0,
    'active',
    0,
    NULL,
    NOW(),
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'OPD HOD',
    '9000000004',
    'hod@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'hod'
      LIMIT
        1
    ), NULL,
    0,
    'active',
    0,
    NULL,
    NOW(),
    NOW(),
    NULL,
    NULL
  ),
  (
    UUID(),
    'Front Desk',
    '9000000005',
    'reception@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'receptionist'
      LIMIT
        1
    ), NULL,
    0,
    'active',
    0,
    NULL,
    NOW(),
    NOW(),
    NULL,
    NULL
  );

-- ===================== FINANCIAL_YEARS (UUID) =====================
INSERT INTO
  `financial_years` (
    `id`,
    `code`,
    `start_date`,
    `end_date`,
    `is_active`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'FY 2024-25',
    '2024-04-01',
    '2025-03-31',
    1,
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'FY 2025-26',
    '2025-04-01',
    '2026-03-31',
    1,
    NOW(),
    NOW(),
    NULL
  );

-- ===================== HOSPITAL_FINANCIAL_YEARS (UUID FKs via subquery) =====================
INSERT INTO
  `hospital_financial_years` (
    `hospital_id`,
    `financial_year_id`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    (
      SELECT
        id
      FROM
        hospitals
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        financial_years
      WHERE
        code = 'FY 2024-25'
      LIMIT
        1
    ), NOW(),
    NOW(),
    NULL
  ),
  (
    (
      SELECT
        id
      FROM
        hospitals
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        financial_years
      WHERE
        code = 'FY 2025-26'
      LIMIT
        1
    ), NOW(),
    NOW(),
    NULL
  );

-- ===================== WEEKENDS (UUID, JSON days) =====================
INSERT INTO
  `weekends` (
    `id`,
    `name`,
    `days`,
    `status`,
    `deleted_at`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'Default Weekend',
    JSON_ARRAY('Saturday', 'Sunday'),
    'active',
    NULL,
    NOW(),
    NOW()
  ),
  (
    UUID(),
    'Middle East Weekend',
    JSON_ARRAY('Friday', 'Saturday'),
    'inactive',
    NULL,
    NOW(),
    NOW()
  );

-- ===================== HOLIDAYS (UUID) =====================
INSERT INTO
  `holidays` (
    `id`,
    `name`,
    `start_date`,
    `end_date`,
    `details`,
    `document`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  )
VALUES
  (
    UUID(),
    'New Year',
    '2026-01-01',
    '2026-01-01',
    'New Year public holiday',
    NULL,
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Independence Day',
    '2026-08-15',
    '2026-08-15',
    'National holiday',
    NULL,
    'active',
    NOW(),
    NOW(),
    NULL
  ),
  (
    UUID(),
    'Annual Maintenance Break',
    '2026-05-01',
    '2026-05-03',
    'Planned hospital maintenance shutdown',
    NULL,
    'inactive',
    NOW(),
    NOW(),
    NULL
  );

-- ===================== LEAVE_TYPES (UUID) =====================
INSERT INTO
  `leave_types` (
    `id`,
    `display_name`,
    `description`,
    `allow_half_day`,
    `min_leave_unit`,
    `max_continuous_days`,
    `count_weekends`,
    `count_holidays`,
    `sandwich_enabled`,
    `approval_required`,
    `approval_level`,
    `attendance_code`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'Casual Leave',
    'Standard casual leave',
    1,
    0.5,
    3,
    0,
    0,
    0,
    1,
    'Single',
    'CL',
    NOW(),
    NOW()
  ),
  (
    UUID(),
    'Sick Leave',
    'Medical leave',
    1,
    0.5,
    15,
    0,
    0,
    0,
    1,
    'Sequential',
    'SL',
    NOW(),
    NOW()
  ),
  (
    UUID(),
    'Earned Leave',
    'Privilege leave',
    0,
    1,
    30,
    1,
    1,
    1,
    1,
    'Sequential',
    'EL',
    NOW(),
    NOW()
  );

-- ===================== STAFF (bigint id, UUID FKs) =====================
INSERT INTO
  `staff` (
    `id`,
    `user_id`,
    `employee_id`,
    `name`,
    `role_id`,
    `department_id`,
    `designation_id`,
    `level1_supervisor_id`,
    `level2_supervisor_id`,
    `level3_supervisor_id`,
    `joining_date`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000001'
      LIMIT
        1
    ), 'EMP-001', 'Super Admin', (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'super_admin'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        designation_master
      WHERE
        designation_code = 'ADMIN'
      LIMIT
        1
    ), NULL,
    NULL,
    NULL,
    '2024-01-01',
    'Active',
    NOW(),
    NOW()
  ),
  (
    2,
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000002'
      LIMIT
        1
    ), 'EMP-002', 'HR Manager', (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'hr'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        designation_master
      WHERE
        designation_code = 'REC'
      LIMIT
        1
    ), NULL,
    NULL,
    NULL,
    '2024-01-01',
    'Active',
    NOW(),
    NOW()
  ),
  (
    3,
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000003'
      LIMIT
        1
    ), 'EMP-003', 'General Manager', (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'manager'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        designation_master
      WHERE
        designation_code = 'ADMIN'
      LIMIT
        1
    ), NULL,
    NULL,
    NULL,
    '2024-01-01',
    'Active',
    NOW(),
    NOW()
  ),
  (
    4,
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000004'
      LIMIT
        1
    ), 'EMP-004', 'OPD HOD', (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'hod'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        designation_master
      WHERE
        designation_code = 'DOC'
      LIMIT
        1
    ), NULL,
    NULL,
    NULL,
    '2024-01-01',
    'Active',
    NOW(),
    NOW()
  );

-- Add a regular staff member who applies for leave
INSERT INTO
  `users` (
    `id`,
    `name`,
    `mobile`,
    `email`,
    `role_id`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'John Staff',
    '8000000001',
    'john@example.com',
    (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'doctor'
      LIMIT
        1
    ), 'active', NOW(),
    NOW()
  );

INSERT INTO
  `staff` (
    `id`,
    `user_id`,
    `employee_id`,
    `name`,
    `role_id`,
    `department_id`,
    `designation_id`,
    `level1_supervisor_id`,
    `level2_supervisor_id`,
    `level3_supervisor_id`,
    `joining_date`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    5,
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '8000000001'
      LIMIT
        1
    ), 'EMP-005', 'John Staff', (
      SELECT
        id
      FROM
        roles
      WHERE
        name = 'doctor'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        department_master
      WHERE
        department_code = 'OPD'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        designation_master
      WHERE
        designation_code = 'DOC'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000003'
      LIMIT
        1
    ), -- Manager
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000002'
      LIMIT
        1
    ), -- HR
    (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000004'
      LIMIT
        1
    ), -- HOD
    '2024-06-01', 'Active', NOW(),
    NOW()
  );

-- ===================== LEAVE_ADJUSTMENTS (UUID) =====================
INSERT INTO
  `leave_adjustments` (
    `id`,
    `staff_id`,
    `leave_type_id`,
    `credit`,
    `debit`,
    `remarks`,
    `year`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    5,
    (
      SELECT
        id
      FROM
        leave_types
      WHERE
        display_name = 'Casual Leave'
      LIMIT
        1
    ), 12, 0, 'Opening Balance', 2026, NOW(),
    NOW()
  ),
  (
    UUID(),
    5,
    (
      SELECT
        id
      FROM
        leave_types
      WHERE
        display_name = 'Sick Leave'
      LIMIT
        1
    ), 10, 0, 'Opening Balance', 2026, NOW(),
    NOW()
  );

-- ===================== LEAVE_APPLICATIONS (UUID) =====================
INSERT INTO
  `leave_applications` (
    `id`,
    `staff_id`,
    `leave_type_id`,
    `leave_duration`,
    `from_date`,
    `to_date`,
    `leave_days`,
    `reason`,
    `status`,
    `current_approval_level`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    5,
    (
      SELECT
        id
      FROM
        leave_types
      WHERE
        display_name = 'Casual Leave'
      LIMIT
        1
    ), 'full_day', '2026-03-20', '2026-03-21', 2.0, 'Personal work', 'pending', 1, NOW(),
    NOW()
  ),
  (
    UUID(),
    5,
    (
      SELECT
        id
      FROM
        leave_types
      WHERE
        display_name = 'Sick Leave'
      LIMIT
        1
    ), 'full_day', '2026-03-25', '2026-03-25', 1.0, 'Fever', 'pending', 1, NOW(),
    NOW()
  );

-- ===================== PATIENTS (UUID) =====================
INSERT INTO
  `patients` (
    `id`,
    `patient_code`,
    `first_name`,
    `last_name`,
    `gender`,
    `date_of_birth`,
    `mobile`,
    `email`,
    `blood_group`,
    `address`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'PAT-001',
    'Jane',
    'Doe',
    'Female',
    '1995-08-15',
    '8888888888',
    'jane.doe@example.com',
    'A+',
    'Beach Road, Mangalore',
    1,
    NOW(),
    NOW()
  );

-- ===================== APPOINTMENTS (UUID) =====================
-- INSERT INTO
--   `appointments` (
--     `id`,
--     `patient_id`,
--     `doctor_id`,
--     `department_id`,
--     `appointment_date`,
--     `appointment_time`,
--     `appointment_status`,
--     `consultation_fee`,
--     `institution_id`,
--     `receptionist_user_id`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     (
--       SELECT
--         id
--       FROM
--         patients
--       WHERE
--         patient_code = 'PAT-001'
--       LIMIT
--         1
--     ), (
--       SELECT
--         id
--       FROM
--         users
--       WHERE
--         mobile = '8000000001'
--       LIMIT
--         1
--     ), (
--       SELECT
--         id
--       FROM
--         department_master
--       WHERE
--         department_code = 'OPD'
--       LIMIT
--         1
--     ), CURDATE(), '10:00:00', 'Scheduled', 500.00, (
--       SELECT
--         id
--       FROM
--         hospitals
--       WHERE
--         code = 'HOSP-DH1'
--       LIMIT
--         1
--     ), (
--       SELECT
--         id
--       FROM
--         users
--       WHERE
--         mobile = '9000000005'
--       LIMIT
--         1
--     ), NOW(),
--     NOW()
--   );

-- -- ===================== OPD (UUID) =====================
-- INSERT INTO
--   `opd` (
--     `id`,
--     `appointment_id`,
--     `patient_id`,
--     `doctor_id`,
--     `visit_date`,
--     `visit_status`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     (
--       SELECT
--         id
--       FROM
--         appointments
--       WHERE
--         patient_id = (
--           SELECT
--             id
--           FROM
--             patients
--           WHERE
--             patient_code = 'PAT-001'
--           LIMIT
--             1
--         )
--       LIMIT
--         1
--     ), (
--       SELECT
--         id
--       FROM
--         patients
--       WHERE
--         patient_code = 'PAT-001'
--       LIMIT
--         1
--     ), (
--       SELECT
--         id
--       FROM
--         users
--       WHERE
--         mobile = '8000000001'
--       LIMIT
--         1
--     ), CURDATE(), 'Pending', NOW(),
--     NOW()
--   );

-- -- ===================== VENDORS (UUID) =====================
-- INSERT INTO
--   `vendors` (
--     `id`,
--     `vendor_name`,
--     `phone_number`,
--     `email`,
--     `address`,
--     `status`,
--     `created_by`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     'Global Pharma Distributors',
--     '1112223333',
--     'sales@globalpharma.com',
--     'Business Park, Bangalore',
--     'Active',
--     1,
--     NOW(),
--     NOW()
--   );

-- -- ===================== MEDICINES (UUID) =====================
-- INSERT INTO
--   `medicines` (
--     `id`,
--     `medicine_name`,
--     `generic_name`,
--     `category`,
--     `manufacturer`,
--     `status`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     'Paracetamol 500mg',
--     'Paracetamol',
--     'Analgesic',
--     'PharmaCorp',
--     1,
--     NOW(),
--     NOW()
--   );

-- -- ===================== ITEMS (auto id) =====================
-- INSERT INTO
--   `items` (
--     `name`,
--     `code`,
--     `category`,
--     `unit`,
--     `purchase_price`,
--     `selling_price`,
--     `reorder_level`,
--     `current_stock`,
--     `status`,
--     `stock`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     'Medical Gloves',
--     'CG-001',
--     'Consumable',
--     'Box',
--     200.00,
--     350.00,
--     50,
--     100,
--     'active',
--     100,
--     NOW(),
--     NOW()
--   ),
--   (
--     'Blood Pressure Monitor',
--     'EQ-001',
--     'Equipment',
--     'Unit',
--     1500.00,
--     2500.00,
--     5,
--     20,
--     'active',
--     20,
--     NOW(),
--     NOW()
--   );

-- -- ===================== WARDS (UUID) =====================
-- INSERT INTO
--   `wards` (
--     `id`,
--     `ward_name`,
--     `ward_type`,
--     `floor_number`,
--     `total_beds`,
--     `status`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     'General Ward A',
--     'General',
--     1,
--     10,
--     1,
--     NOW(),
--     NOW()
--   ),
--   (
--     UUID(),
--     'ICU',
--     'Critical Care',
--     2,
--     5,
--     1,
--     NOW(),
--     NOW()
--   );

-- -- ===================== BEDS (UUID) =====================
-- INSERT INTO
--   `beds` (
--     `id`,
--     `bed_code`,
--     `ward_id`,
--     `room_number`,
--     `bed_type`,
--     `status`,
--     `created_at`,
--     `updated_at`
--   )
-- VALUES
--   (
--     UUID(),
--     'GW-A-01',
--     (
--       SELECT
--         id
--       FROM
--         wards
--       WHERE
--         ward_name = 'General Ward A'
--       LIMIT
--         1
--     ), '101', 'Standard', 'Available', NOW(),
--     NOW()
--   ),
--   (
--     UUID(),
--     'ICU-01',
--     (
--       SELECT
--         id
--       FROM
--         wards
--       WHERE
--         ward_name = 'ICU'
--       LIMIT
--         1
--     ), '201', 'ICU Bed', 'Available', NOW(),
--     NOW()
--   );

SET FOREIGN_KEY_CHECKS = 1;