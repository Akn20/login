USE `hims`;

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

-- ===================== person (UUID) =====================

INSERT INTO patients 
(id, patient_code, first_name, last_name, gender, date_of_birth, mobile, email, blood_group, address, emergency_contact, is_vip, status, merged_to, created_by, updated_by, created_at, updated_at)
VALUES

(UUID(), 'PAT001', 'Rahul', 'Sharma', 'Male', '1990-05-10', '9876543210', 'rahul@example.com', 'B+', 'Delhi', '9876500001', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT002', 'Anita', 'Verma', 'Female', '1988-03-22', '9876543211', 'anita@example.com', 'O+', 'Mumbai', '9876500002', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT003', 'Ravi', 'Kumar', 'Male', '1995-11-15', '9876543212', 'ravi@example.com', 'A+', 'Bangalore', '9876500003', 1, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT004', 'Sneha', 'Nair', 'Female', '1992-07-08', '9876543213', 'sneha@example.com', 'AB+', 'Kochi', '9876500004', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT005', 'Arjun', 'Reddy', 'Male', '1987-01-19', '9876543214', 'arjun@example.com', 'O-', 'Hyderabad', '9876500005', 0, 1, NULL, NULL, NULL, NOW(), NOW()),

(UUID(), 'PAT006', 'Meera', 'Joshi', 'Female', '1993-06-30', '9876543215', 'meera@example.com', 'A-', 'Pune', '9876500006', 1, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT007', 'Kiran', 'Patel', 'Male', '1985-09-14', '9876543216', 'kiran@example.com', 'B-', 'Ahmedabad', '9876500007', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT008', 'Lakshmi', 'Iyer', 'Female', '1991-12-02', '9876543217', 'lakshmi@example.com', 'O+', 'Chennai', '9876500008', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT009', 'Vikram', 'Singh', 'Male', '1989-04-11', '9876543218', 'vikram@example.com', 'B+', 'Jaipur', '9876500009', 1, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT010', 'Pooja', 'Kapoor', 'Female', '1996-08-21', '9876543219', 'pooja@example.com', 'AB-', 'Chandigarh', '9876500010', 0, 1, NULL, NULL, NULL, NOW(), NOW()),

(UUID(), 'PAT011', 'Suresh', 'Menon', 'Male', '1978-10-05', '9876543220', 'suresh@example.com', 'A+', 'Trivandrum', '9876500011', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT012', 'Divya', 'Shetty', 'Female', '1994-02-17', '9876543221', 'divya@example.com', 'O-', 'Mangalore', '9876500012', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT013', 'Manoj', 'Das', 'Male', '1983-05-28', '9876543222', 'manoj@example.com', 'B+', 'Kolkata', '9876500013', 1, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT014', 'Neha', 'Agarwal', 'Female', '1997-07-13', '9876543223', 'neha@example.com', 'A+', 'Lucknow', '9876500014', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT015', 'Aditya', 'Gupta', 'Male', '1986-11-09', '9876543224', 'aditya@example.com', 'O+', 'Kanpur', '9876500015', 0, 1, NULL, NULL, NULL, NOW(), NOW()),

(UUID(), 'PAT016', 'Ritu', 'Malhotra', 'Female', '1990-03-03', '9876543225', 'ritu@example.com', 'B-', 'Delhi', '9876500016', 1, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT017', 'Naveen', 'Bhat', 'Male', '1982-06-18', '9876543226', 'naveen@example.com', 'AB+', 'Udupi', '9876500017', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT018', 'Priya', 'Kulkarni', 'Female', '1995-09-27', '9876543227', 'priya@example.com', 'A-', 'Nagpur', '9876500018', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT019', 'Deepak', 'Yadav', 'Male', '1984-12-25', '9876543228', 'deepak@example.com', 'O+', 'Patna', '9876500019', 0, 1, NULL, NULL, NULL, NOW(), NOW()),
(UUID(), 'PAT020', 'Kavya', 'Rao', 'Female', '1998-01-14', '9876543229', 'kavya@example.com', 'B+', 'Mysore', '9876500020', 0, 1, NULL, NULL, NULL, NOW(), NOW());

-- ===================== medicine (UUID) =====================

INSERT INTO medicines 
(id, medicine_name, generic_name, category, manufacturer, status, created_at, updated_at)
VALUES
(UUID(),'Paracetamol 500mg','Paracetamol','Tablet','Sun Pharma',1,NOW(),NOW()),
(UUID(),'Amoxicillin 250mg','Amoxicillin','Capsule','Cipla',1,NOW(),NOW()),
(UUID(),'Ibuprofen 400mg','Ibuprofen','Tablet','Dr Reddys',1,NOW(),NOW()),
(UUID(),'Azithromycin 500mg','Azithromycin','Tablet','Aurobindo',1,NOW(),NOW()),
(UUID(),'Cetirizine 10mg','Cetirizine','Tablet','Sun Pharma',1,NOW(),NOW()),
(UUID(),'Metformin 500mg','Metformin','Tablet','Lupin',1,NOW(),NOW()),
(UUID(),'Pantoprazole 40mg','Pantoprazole','Tablet','Cipla',1,NOW(),NOW()),
(UUID(),'Omeprazole 20mg','Omeprazole','Capsule','Sun Pharma',1,NOW(),NOW()),
(UUID(),'Atorvastatin 10mg','Atorvastatin','Tablet','Zydus',1,NOW(),NOW()),
(UUID(),'Aspirin 75mg','Aspirin','Tablet','Bayer',1,NOW(),NOW()),

(UUID(),'Diclofenac 50mg','Diclofenac','Tablet','Novartis',1,NOW(),NOW()),
(UUID(),'Dolo 650','Paracetamol','Tablet','Micro Labs',1,NOW(),NOW()),
(UUID(),'Augmentin 625','Amoxicillin + Clavulanic','Tablet','GSK',1,NOW(),NOW()),
(UUID(),'Cough Syrup DX','Dextromethorphan','Syrup','Benadryl',1,NOW(),NOW()),
(UUID(),'Insulin Injection','Insulin','Injection','Novo Nordisk',1,NOW(),NOW()),
(UUID(),'Vitamin C 500mg','Ascorbic Acid','Tablet','Himalaya',1,NOW(),NOW()),
(UUID(),'Calcium Tablet','Calcium Carbonate','Tablet','Shelcal',1,NOW(),NOW()),
(UUID(),'ORS Sachet','Oral Rehydration Salt','Powder','Cipla',1,NOW(),NOW()),
(UUID(),'Ranitidine 150mg','Ranitidine','Tablet','Sun Pharma',1,NOW(),NOW()),
(UUID(),'Levocetirizine 5mg','Levocetirizine','Tablet','Dr Reddys',1,NOW(),NOW()),

(UUID(),'Montelukast 10mg','Montelukast','Tablet','Cipla',1,NOW(),NOW()),
(UUID(),'Clopidogrel 75mg','Clopidogrel','Tablet','Zydus',1,NOW(),NOW()),
(UUID(),'Hydroxychloroquine','Hydroxychloroquine','Tablet','Ipca',1,NOW(),NOW()),
(UUID(),'Folic Acid 5mg','Folic Acid','Tablet','Lupin',1,NOW(),NOW()),
(UUID(),'Iron Tablet','Ferrous Sulphate','Tablet','Ranbaxy',1,NOW(),NOW()),
(UUID(),'Amikacin Injection','Amikacin','Injection','Cipla',1,NOW(),NOW()),
(UUID(),'Salbutamol Inhaler','Salbutamol','Inhaler','GSK',1,NOW(),NOW()),
(UUID(),'Betadine Ointment','Povidone Iodine','Ointment','Win Medicare',1,NOW(),NOW()),
(UUID(),'Loperamide 2mg','Loperamide','Capsule','Sun Pharma',1,NOW(),NOW()),
(UUID(),'Domperidone 10mg','Domperidone','Tablet','Cipla',1,NOW(),NOW());


-- ===================== medicine batches (UUID) =====================

INSERT INTO medicine_batches
(id, medicine_id, batch_number, expiry_date, purchase_price, mrp, quantity, reorder_level, created_at, updated_at)
VALUES
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH001', '2027-01-10', 12.50, 18.00, 150, 40, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH002', '2026-11-20', 8.20, 12.00, 200, 50, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH003', '2027-03-15', 22.00, 30.00, 120, 30, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH004', '2026-09-01', 5.50, 10.00, 80, 25, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH005', '2027-04-25', 15.00, 22.00, 140, 35, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH006', '2027-06-30', 9.50, 14.00, 160, 40, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH007', '2026-12-18', 11.00, 17.00, 90, 30, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH008', '2027-08-14', 18.00, 25.00, 110, 35, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH009', '2027-05-05', 6.50, 11.00, 210, 60, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH010', '2026-10-12', 14.00, 20.00, 70, 25, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH011', '2027-07-01', 7.20, 12.50, 95, 30, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH012', '2026-08-22', 16.00, 24.00, 130, 40, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH013', '2027-02-17', 13.50, 19.00, 145, 35, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH014', '2027-09-10', 10.00, 15.00, 170, 45, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH015', '2026-07-30', 4.80, 9.00, 220, 60, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH016', '2027-03-03', 21.00, 28.00, 60, 20, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH017', '2027-11-11', 8.80, 13.50, 175, 50, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH018', '2026-06-15', 19.00, 26.00, 85, 30, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH019', '2027-01-25', 17.00, 23.00, 125, 35, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH020', '2026-09-29', 6.20, 10.50, 200, 55, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH021', '2027-12-01', 12.80, 18.90, 140, 40, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH022', '2027-04-04', 7.70, 12.30, 190, 50, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH023', '2026-10-05', 9.90, 14.50, 100, 35, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH024', '2027-02-02', 11.50, 16.80, 130, 40, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH025', '2027-05-20', 20.00, 27.00, 75, 25, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH026', '2026-11-09', 14.20, 21.00, 160, 45, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH027', '2027-06-12', 5.90, 10.20, 210, 60, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH028', '2027-03-19', 18.60, 26.00, 120, 35, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH029', '2026-08-08', 16.40, 22.00, 95, 30, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), 'BATCH030', '2027-09-21', 13.00, 19.50, 155, 40, NOW(), NOW());


-- ===================== stock movements (UUID) =====================

INSERT INTO stock_movements 
(id, medicine_id, batch_id, movement_type, quantity, reference_id, created_at, updated_at)
VALUES
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 100, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 20, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 150, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 30, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 80, NULL, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 15, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 200, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 50, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 120, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 25, NULL, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 90, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 40, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 60, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 35, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 110, NULL, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 22, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 140, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 18, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 170, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 45, NULL, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 75, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 28, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 160, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 33, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 95, NULL, NOW(), NOW()),

(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 19, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 130, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 41, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'IN', 180, NULL, NOW(), NOW()),
(UUID(), (SELECT id FROM medicines ORDER BY RAND() LIMIT 1), (SELECT id FROM medicine_batches ORDER BY RAND() LIMIT 1), 'OUT', 26, NULL, NOW(), NOW());


-- ===================== Department master =====================

INSERT INTO department_master
(id, department_code, department_name, description, status, created_at, updated_at)
VALUES
(UUID(),'DEP001','General Medicine','General diagnosis and treatment',1,NOW(),NOW()),
(UUID(),'DEP002','Cardiology','Heart related treatments',1,NOW(),NOW()),
(UUID(),'DEP003','Neurology','Brain and nervous system treatments',1,NOW(),NOW()),
(UUID(),'DEP004','Orthopedics','Bone and joint treatments',1,NOW(),NOW()),
(UUID(),'DEP005','Pediatrics','Child healthcare',1,NOW(),NOW()),
(UUID(),'DEP006','Dermatology','Skin treatments',1,NOW(),NOW()),
(UUID(),'DEP007','Gynecology','Women reproductive healthcare',1,NOW(),NOW()),
(UUID(),'DEP008','ENT','Ear Nose Throat treatments',1,NOW(),NOW()),
(UUID(),'DEP009','Radiology','Medical imaging services',1,NOW(),NOW()),
(UUID(),'DEP010','Oncology','Cancer treatment department',1,NOW(),NOW()),
(UUID(),'DEP011','Nephrology','Kidney related treatments',1,NOW(),NOW()),
(UUID(),'DEP012','Urology','Urinary system treatments',1,NOW(),NOW()),
(UUID(),'DEP013','Pulmonology','Lung and respiratory diseases',1,NOW(),NOW()),
(UUID(),'DEP015','ICU','Intensive care unit',1,NOW(),NOW());


-- ===================== Designation master =====================

INSERT INTO designation_master
(id, designation_code, designation_name, description, status, created_at, updated_at)
VALUES
(UUID(),'DOC001','General Physician','General medical practitioner',1,NOW(),NOW()),
(UUID(),'DOC002','Cardiologist','Heart specialist',1,NOW(),NOW()),
(UUID(),'DOC003','Neurologist','Brain specialist',1,NOW(),NOW()),
(UUID(),'DOC004','Orthopedic Surgeon','Bone and joint surgeon',1,NOW(),NOW()),
(UUID(),'DOC005','Pediatrician','Child health specialist',1,NOW(),NOW()),
(UUID(),'DOC006','Dermatologist','Skin specialist',1,NOW(),NOW()),
(UUID(),'DOC007','Gynecologist','Women health specialist',1,NOW(),NOW()),
(UUID(),'DOC008','ENT Specialist','Ear nose throat specialist',1,NOW(),NOW()),
(UUID(),'DOC009','Radiologist','Medical imaging specialist',1,NOW(),NOW()),
(UUID(),'DOC010','Oncologist','Cancer specialist',1,NOW(),NOW()),

(UUID(),'DOC011','Nephrologist','Kidney specialist',1,NOW(),NOW()),
(UUID(),'DOC012','Urologist','Urinary tract specialist',1,NOW(),NOW()),
(UUID(),'DOC013','Pulmonologist','Lung specialist',1,NOW(),NOW()),
(UUID(),'DOC014','Emergency Physician','Emergency treatment specialist',1,NOW(),NOW()),
(UUID(),'DOC015','Intensivist','ICU specialist',1,NOW(),NOW()),

(UUID(),'DOC016','Cardiac Surgeon','Heart surgeon',1,NOW(),NOW()),
(UUID(),'DOC017','Neurosurgeon','Brain surgeon',1,NOW(),NOW()),
(UUID(),'DOC018','Plastic Surgeon','Reconstructive surgery specialist',1,NOW(),NOW()),
(UUID(),'DOC019','Gastroenterologist','Digestive system specialist',1,NOW(),NOW()),
(UUID(),'DOC020','Endocrinologist','Hormone specialist',1,NOW(),NOW()),

(UUID(),'DOC021','Diabetologist','Diabetes specialist',1,NOW(),NOW()),
(UUID(),'DOC022','Hematologist','Blood disease specialist',1,NOW(),NOW()),
(UUID(),'DOC023','Rheumatologist','Joint autoimmune diseases specialist',1,NOW(),NOW()),
(UUID(),'DOC024','Ophthalmologist','Eye specialist',1,NOW(),NOW()),
(UUID(),'DOC025','Psychiatrist','Mental health specialist',1,NOW(),NOW()),

(UUID(),'DOC026','Anesthesiologist','Anesthesia specialist',1,NOW(),NOW()),
(UUID(),'DOC027','Pathologist','Laboratory diagnosis specialist',1,NOW(),NOW()),
(UUID(),'DOC028','Pediatric Surgeon','Child surgery specialist',1,NOW(),NOW()),
(UUID(),'DOC029','Interventional Cardiologist','Heart procedure specialist',1,NOW(),NOW()),
(UUID(),'DOC030','Vascular Surgeon','Blood vessel surgery specialist',1,NOW(),NOW()),

(UUID(),'DOC031','Colorectal Surgeon','Colon surgery specialist',1,NOW(),NOW()),
(UUID(),'DOC032','Maxillofacial Surgeon','Jaw surgery specialist',1,NOW(),NOW()),
(UUID(),'DOC033','Pain Management Specialist','Pain treatment specialist',1,NOW(),NOW()),
(UUID(),'DOC034','Sleep Medicine Specialist','Sleep disorder specialist',1,NOW(),NOW()),
(UUID(),'DOC035','Sports Medicine Specialist','Sports injury specialist',1,NOW(),NOW()),

(UUID(),'DOC036','Allergist','Allergy specialist',1,NOW(),NOW()),
(UUID(),'DOC037','Infectious Disease Specialist','Infection specialist',1,NOW(),NOW()),
(UUID(),'DOC038','Preventive Medicine Specialist','Disease prevention specialist',1,NOW(),NOW()),
(UUID(),'DOC039','Geriatrician','Elderly care specialist',1,NOW(),NOW()),
(UUID(),'DOC040','Reproductive Specialist','Fertility specialist',1,NOW(),NOW()),

(UUID(),'DOC041','Transplant Surgeon','Organ transplant specialist',1,NOW(),NOW()),
(UUID(),'DOC042','Medical Geneticist','Genetic disease specialist',1,NOW(),NOW()),
(UUID(),'DOC043','Addiction Specialist','Substance abuse specialist',1,NOW(),NOW()),
(UUID(),'DOC044','Clinical Pharmacologist','Drug therapy specialist',1,NOW(),NOW()),
(UUID(),'DOC045','Medical Microbiologist','Microorganism disease specialist',1,NOW(),NOW()),

(UUID(),'DOC046','Toxicologist','Poison treatment specialist',1,NOW(),NOW()),
(UUID(),'DOC047','Occupational Medicine Specialist','Workplace health specialist',1,NOW(),NOW()),
(UUID(),'DOC048','Critical Care Specialist','Critical patient care specialist',1,NOW(),NOW()),
(UUID(),'DOC049','Hand Surgeon','Hand surgery specialist',1,NOW(),NOW()),
(UUID(),'DOC050','Palliative Care Specialist','End of life care specialist',1,NOW(),NOW());

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
INSERT INTO
  `appointments` (
    `id`,
    `patient_id`,
    `doctor_id`,
    `department_id`,
    `appointment_date`,
    `appointment_time`,
    `appointment_status`,
    `consultation_fee`,
    `institution_id`,
    `receptionist_user_id`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    (
      SELECT
        id
      FROM
        patients
      WHERE
        patient_code = 'PAT-001'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '8000000001'
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
    ), CURDATE(), '10:00:00', 'Scheduled', 500.00, (
      SELECT
        id
      FROM
        hospitals
      WHERE
        code = 'HOSP-DH1'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '9000000005'
      LIMIT
        1
    ), NOW(),
    NOW()
  );

-- ===================== OPD (UUID) =====================
INSERT INTO
  `opd` (
    `id`,
    `appointment_id`,
    `patient_id`,
    `doctor_id`,
    `visit_date`,
    `visit_status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    (
      SELECT
        id
      FROM
        appointments
      WHERE
        patient_id = (
          SELECT
            id
          FROM
            patients
          WHERE
            patient_code = 'PAT-001'
          LIMIT
            1
        )
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        patients
      WHERE
        patient_code = 'PAT-001'
      LIMIT
        1
    ), (
      SELECT
        id
      FROM
        users
      WHERE
        mobile = '8000000001'
      LIMIT
        1
    ), CURDATE(), 'Pending', NOW(),
    NOW()
  );

-- ===================== VENDORS (UUID) =====================
INSERT INTO
  `vendors` (
    `id`,
    `vendor_name`,
    `phone_number`,
    `email`,
    `address`,
    `status`,
    `created_by`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'Global Pharma Distributors',
    '1112223333',
    'sales@globalpharma.com',
    'Business Park, Bangalore',
    'Active',
    1,
    NOW(),
    NOW()
  );

-- ===================== MEDICINES (UUID) =====================
INSERT INTO
  `medicines` (
    `id`,
    `medicine_name`,
    `generic_name`,
    `category`,
    `manufacturer`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'Paracetamol 500mg',
    'Paracetamol',
    'Analgesic',
    'PharmaCorp',
    1,
    NOW(),
    NOW()
  );

-- ===================== ITEMS (auto id) =====================
INSERT INTO
  `items` (
    `name`,
    `code`,
    `category`,
    `unit`,
    `purchase_price`,
    `selling_price`,
    `reorder_level`,
    `current_stock`,
    `status`,
    `stock`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    'Medical Gloves',
    'CG-001',
    'Consumable',
    'Box',
    200.00,
    350.00,
    50,
    100,
    'active',
    100,
    NOW(),
    NOW()
  ),
  (
    'Blood Pressure Monitor',
    'EQ-001',
    'Equipment',
    'Unit',
    1500.00,
    2500.00,
    5,
    20,
    'active',
    20,
    NOW(),
    NOW()
  );

-- ===================== WARDS (UUID) =====================
INSERT INTO
  `wards` (
    `id`,
    `ward_name`,
    `ward_type`,
    `floor_number`,
    `total_beds`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'General Ward A',
    'General',
    1,
    10,
    1,
    NOW(),
    NOW()
  ),
  (
    UUID(),
    'ICU',
    'Critical Care',
    2,
    5,
    1,
    NOW(),
    NOW()
  );

-- ===================== BEDS (UUID) =====================
INSERT INTO
  `beds` (
    `id`,
    `bed_code`,
    `ward_id`,
    `room_number`,
    `bed_type`,
    `status`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    UUID(),
    'GW-A-01',
    (
      SELECT
        id
      FROM
        wards
      WHERE
        ward_name = 'General Ward A'
      LIMIT
        1
    ), '101', 'Standard', 'Available', NOW(),
    NOW()
  ),
  (
    UUID(),
    'ICU-01',
    (
      SELECT
        id
      FROM
        wards
      WHERE
        ward_name = 'ICU'
      LIMIT
        1
    ), '201', 'ICU Bed', 'Available', NOW(),
    NOW()
  );

SET
  FOREIGN_KEY_CHECKS = 1;