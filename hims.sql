-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 07:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hims`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountant_payments`
--
USE `superadmin`;
CREATE TABLE `accountant_payments` (
  `id` char(36) NOT NULL,
  `bill_id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accountant_payments`
--

INSERT INTO `accountant_payments` (`id`, `bill_id`, `patient_id`, `amount`, `payment_mode`, `transaction_id`, `payment_date`, `created_by`, `created_at`, `updated_at`) VALUES
('24588c20-49a9-4e99-9ea9-41eea6bca385', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '500.00', 'upi', 'UPI621', '2026-05-05 07:24:25', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:24:25', '2026-05-05 07:24:25'),
('4ed86f55-066f-4b54-99ac-e0b9b975e1dc', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '50.00', 'cash', NULL, '2026-05-05 08:51:25', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 08:51:25', '2026-05-05 08:51:25'),
('4ff08667-d514-4557-aaee-1b65708237ff', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '100.00', 'cash', NULL, '2026-05-05 07:33:11', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:33:11', '2026-05-05 07:33:11'),
('6363de93-fc9e-4d5c-88e1-30e2896d7971', '9bcf64df-5bc1-4a3c-92e5-3c0d6f581b19', '97b05690-3587-11f1-ade1-40c2ba22e44a', '1499.00', 'cash', NULL, '2026-05-04 10:37:00', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-04 10:37:00', '2026-05-04 10:37:00'),
('73f3954d-1ccb-4eb2-bd4b-b66d859173a4', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '73.00', 'upi', 'UPI778811', '2026-05-05 07:23:32', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:23:32', '2026-05-05 07:23:32'),
('75fc28f1-3ea7-4827-803f-4687055ebb9a', 'a9cf44c4-2537-477b-89f3-1e46437ca7dc', '26e2ce73-4789-11f1-80af-48684ad9278a', '500.00', 'cash', NULL, '2026-05-08 14:43:06', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-08 14:43:06', '2026-05-08 14:43:06'),
('798afd56-fe8f-4afd-bb25-567adc789fd1', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '100.00', 'cash', NULL, '2026-05-05 07:31:30', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:31:30', '2026-05-05 07:31:30'),
('9afa3dc5-742c-4e52-b1b2-3148bca27b2c', '0a78ec11-597e-42fc-950e-01abea12cebf', '26e2cee8-4789-11f1-80af-48684ad9278a', '3710.00', 'cash', NULL, '2026-05-08 06:13:17', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-08 06:13:17', '2026-05-08 06:13:17'),
('9b80ef0a-c814-4573-a74b-a4730771779d', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '100.00', 'upi', 'UPI88', '2026-05-05 07:36:11', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:36:11', '2026-05-05 07:36:11'),
('e0cf70dd-d31c-4014-815b-d3b5dfbae392', '7e25ffe5-e18b-4d0f-a02b-bff5db17d6fa', '97b07edf-3587-11f1-ade1-40c2ba22e44a', '50.00', 'upi', 'UPI77', '2026-05-05 07:36:50', '39ddc769-6ae6-436d-937f-43e9024c6108', '2026-05-05 07:36:50', '2026-05-05 07:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `alert_audit_logs`
--

CREATE TABLE `alert_audit_logs` (
  `id` char(36) NOT NULL,
  `alert_id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('fixed','variable') NOT NULL DEFAULT 'fixed',
  `nature` enum('fixed','variable') NOT NULL DEFAULT 'fixed',
  `start_date` date DEFAULT NULL,
  `pay_frequency` enum('monthly','quarterly','yearly','one_time') DEFAULT NULL,
  `calculation_type` enum('fixed','percentage','balancing') DEFAULT NULL,
  `calculation_base` enum('basic','gross') DEFAULT NULL,
  `calculation_value` decimal(12,2) DEFAULT NULL,
  `rounding_rule` enum('nearest','up','down','none') DEFAULT NULL,
  `max_limit` decimal(12,2) DEFAULT NULL,
  `lop_impact` tinyint(1) NOT NULL DEFAULT 0,
  `prorata` tinyint(1) NOT NULL DEFAULT 0,
  `taxable` tinyint(1) NOT NULL DEFAULT 0,
  `tax_exemption_section` varchar(255) DEFAULT NULL,
  `pf_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `esi_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `pt_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `tds_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_payslip` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) DEFAULT NULL,
  `effective_from` date DEFAULT NULL,
  `effective_to` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `name`, `display_name`, `description`, `type`, `nature`, `start_date`, `pay_frequency`, `calculation_type`, `calculation_base`, `calculation_value`, `rounding_rule`, `max_limit`, `lop_impact`, `prorata`, `taxable`, `tax_exemption_section`, `pf_applicable`, `esi_applicable`, `pt_applicable`, `tds_applicable`, `show_in_payslip`, `display_order`, `effective_from`, `effective_to`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('5091ce48-f1db-452d-88f3-d545862200f1', 'Basic Salary', 'Basic', NULL, 'fixed', 'fixed', '2026-05-01', 'monthly', 'fixed', 'basic', NULL, 'nearest', NULL, 0, 0, 1, NULL, 1, 0, 1, 1, 1, 1, '2026-05-01', NULL, 1, '2026-05-04 07:27:10', '2026-05-04 07:27:10', NULL),
('5e3559ff-18f0-46f9-95c6-d794069b4758', 'HRA', 'House Rent Allowance', NULL, 'fixed', 'fixed', '2026-05-01', 'monthly', 'fixed', 'basic', '40.00', 'nearest', '20000.00', 1, 1, 1, '10(3A)', 0, 0, 1, 1, 1, 2, '2026-05-01', NULL, 1, '2026-05-04 07:29:26', '2026-05-04 07:29:26', NULL),
('6622c41f-82bf-41a1-858b-4759fa218800', 'Performance Bonus', 'Bonus', 'Monthly performance incentive', 'variable', 'fixed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, 0, 0, 0, 0, 1, 1, NULL, NULL, 1, '2026-05-04 07:31:46', '2026-05-04 07:31:46', NULL),
('afe3c47a-aa17-43a4-83fa-27d9290d4362', 'Sales Incentive', 'Incentive', 'Based on sales target achievement', 'variable', 'fixed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, 0, 0, 0, 0, 1, 2, NULL, NULL, 1, '2026-05-04 07:33:07', '2026-05-04 07:33:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` char(36) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_status` enum('Scheduled','Cancelled','Completed') NOT NULL DEFAULT 'Scheduled',
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `institution_id` char(36) DEFAULT NULL,
  `receptionist_user_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `date` date NOT NULL,
  `checkin_time` timestamp NULL DEFAULT NULL,
  `checkout_time` timestamp NULL DEFAULT NULL,
  `checkin_lat` decimal(10,7) DEFAULT NULL,
  `checkin_lng` decimal(10,7) DEFAULT NULL,
  `distance` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` char(36) NOT NULL,
  `designation_id` char(36) NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `late_minutes` int(11) NOT NULL DEFAULT 0,
  `overtime_minutes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` char(36) NOT NULL,
  `bed_code` varchar(255) NOT NULL,
  `ward_id` char(36) NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `bed_type` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `bed_code`, `ward_id`, `room_number`, `bed_type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('9c917162-1b5d-4835-aeef-736da59d3f1a', 'A-1-001', '95c93edf-4f92-4fa5-8e1f-e569399885b3', '101', 'General', 'occupied', '2026-05-05 10:54:21', '2026-05-08 06:07:19', NULL),
('c740f849-ae19-4c25-9019-0c50a88edb01', 'A-2-001', 'a9a922d7-7224-4def-9015-68870db3fe3b', '101', 'Private', 'occupied', '2026-05-07 05:28:57', '2026-05-07 05:31:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bed_allocations`
--

CREATE TABLE `bed_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` char(36) NOT NULL,
  `bed_id` char(36) NOT NULL,
  `admission_date` datetime NOT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `status` enum('Active','Transferred','Discharged') NOT NULL DEFAULT 'Active',
  `allocated_by` char(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biometric_images`
--

CREATE TABLE `biometric_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `slot` tinyint(3) UNSIGNED NOT NULL COMMENT '1,2,3',
  `path` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blood_group_master`
--

CREATE TABLE `blood_group_master` (
  `id` char(36) NOT NULL,
  `blood_group_name` varchar(10) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_group_master`
--

INSERT INTO `blood_group_master` (`id`, `blood_group_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26bc507f-4789-11f1-80af-48684ad9278a', 'A+', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc6620-4789-11f1-80af-48684ad9278a', 'A-', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc6727-4789-11f1-80af-48684ad9278a', 'B+', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc6780-4789-11f1-80af-48684ad9278a', 'B-', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc67d1-4789-11f1-80af-48684ad9278a', 'O+', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc6821-4789-11f1-80af-48684ad9278a', 'O-', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc6879-4789-11f1-80af-48684ad9278a', 'AB+', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26bc68c3-4789-11f1-80af-48684ad9278a', 'AB-', 'Active', 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comp_offs`
--

CREATE TABLE `comp_offs` (
  `id` char(36) NOT NULL,
  `employee_id` char(36) NOT NULL,
  `worked_on` date NOT NULL,
  `comp_off_credited` decimal(5,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comp_offs`
--

INSERT INTO `comp_offs` (`id`, `employee_id`, `worked_on`, `comp_off_credited`, `expiry_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
('b53ad994-695f-4799-b002-8aa195655e39', '7', '2026-05-05', '3.00', '2027-07-09', '2026-05-09 03:48:17', '2026-05-09 05:27:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `doctor_id` char(36) NOT NULL,
  `referral_doctor_id` char(36) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `tests` text DEFAULT NULL,
  `consultation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `doctor_id`, `referral_doctor_id`, `symptoms`, `diagnosis`, `tests`, `consultation_date`, `created_at`, `updated_at`) VALUES
('1e9d4cd1-8626-4abb-8d32-7db9e7a9f318', '97b07dac-3587-11f1-ade1-40c2ba22e44a', '3', '1', 'fever', 'fever', 'Blood test', '2026-04-21 05:26:50', '2026-04-21 05:26:50', '2026-04-21 05:26:50'),
('6686c371-9df8-49c0-9b22-c2e9c589fef4', '97b078ed-3587-11f1-ade1-40c2ba22e44a', '3', '3', 'fever, cold', 'paracetamol given', 'Blood test', '2026-04-17 08:18:22', '2026-04-17 08:11:45', '2026-04-17 08:18:22'),
('6b2b472a-fdd5-48b5-9450-5f650da1718d', '97b07b56-3587-11f1-ade1-40c2ba22e44a', '3', '1', 'stomach pain, head pain, vomitting', 'scanning required.', '', '2026-04-17 05:18:16', '2026-04-17 05:18:16', '2026-04-17 05:18:16'),
('6d907190-14f2-4032-900d-dd8c13fc712b', '97b07b56-3587-11f1-ade1-40c2ba22e44a', '3', '1', 'stomach pain, head pain, vomitting', 'scanning required.', '', '2026-04-17 05:15:47', '2026-04-17 05:15:47', '2026-04-17 05:15:47'),
('a457b8b4-2ee3-408a-b698-0ccca346dec0', '97b07b56-3587-11f1-ade1-40c2ba22e44a', '3', '3', 'stomach pain, head pain, vomitting', 'scanning required.', '', '2026-04-17 05:10:10', '2026-04-17 05:10:10', '2026-04-17 05:10:10'),
('daa27520-3053-4d1b-bc78-48065ea5fea0', '97b07b56-3587-11f1-ade1-40c2ba22e44a', '3', '3', 'stomach pain, head pain, vomitting', 'scanning required.', '', '2026-04-17 05:10:59', '2026-04-17 05:10:59', '2026-04-17 05:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_medicines`
--

CREATE TABLE `consultation_medicines` (
  `id` char(36) NOT NULL,
  `consultation_id` char(36) NOT NULL,
  `medicine_id` char(36) NOT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `controlled_drug`
--

CREATE TABLE `controlled_drug` (
  `controlled_drug_id` char(36) NOT NULL,
  `batch_number` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `supplier_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `drug_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `controlled_drug_dispense`
--

CREATE TABLE `controlled_drug_dispense` (
  `dispense_id` char(36) NOT NULL,
  `controlled_drug_id` char(36) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `quantity_dispensed` int(11) NOT NULL,
  `dispense_date` date NOT NULL,
  `pharmacist_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `controlled_drug_log`
--

CREATE TABLE `controlled_drug_log` (
  `log_id` char(36) NOT NULL,
  `controlled_drug_id` char(36) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `pharmacist_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `critical_value_alerts`
--

CREATE TABLE `critical_value_alerts` (
  `id` char(36) NOT NULL,
  `report_id` char(36) NOT NULL,
  `parameter_name` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `threshold_min` double DEFAULT NULL,
  `threshold_max` double DEFAULT NULL,
  `doctor_id` char(36) DEFAULT NULL,
  `acknowledged_by` char(36) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `acknowledged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_usage_consents`
--

CREATE TABLE `data_usage_consents` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `purpose` enum('Treatment','Billing','Insurance','Research','Internal Usage') NOT NULL,
  `consent_status` enum('Granted','Refused','Pending') NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `consent_taken_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recorded_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `nature` enum('FIXED','VARIABLE') NOT NULL DEFAULT 'FIXED',
  `category` enum('RECURRING','ADHOC') NOT NULL DEFAULT 'RECURRING',
  `lop_impact` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `prorata_applicable` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `tax_deductible` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `pf_impact` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `esi_impact` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `pt_impact` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `rule_set_code` varchar(255) DEFAULT NULL,
  `show_in_payslip` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `payslip_order` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `name`, `display_name`, `description`, `nature`, `category`, `lop_impact`, `prorata_applicable`, `tax_deductible`, `pf_impact`, `esi_impact`, `pt_impact`, `rule_set_code`, `show_in_payslip`, `payslip_order`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
('0f72a8f8-8348-477a-b40e-6ca946d35b09', 'loan EMI', 'EMI', 'Monthly loan repayment', 'VARIABLE', 'RECURRING', 'NO', 'NO', 'NO', 'NO', 'NO', 'NO', NULL, 'YES', 2, 'ACTIVE', NULL, '2026-05-04 09:41:09', '2026-05-04 09:41:09'),
('5f28f03e-375b-4909-b648-049095325db7', 'proident fund', 'pf', 'employee pf contribution', 'FIXED', 'RECURRING', 'YES', 'YES', 'YES', 'YES', 'NO', 'NO', 'pf_rule_01', 'YES', 1, 'ACTIVE', NULL, '2026-05-04 09:40:10', '2026-05-12 05:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `deduction_rule_sets`
--

CREATE TABLE `deduction_rule_sets` (
  `id` char(36) NOT NULL,
  `rule_set_code` varchar(255) NOT NULL,
  `rule_set_name` varchar(255) NOT NULL,
  `rule_category` varchar(255) NOT NULL,
  `calculation_type` varchar(255) NOT NULL,
  `calculation_base` varchar(255) DEFAULT NULL,
  `calculation_value` decimal(10,2) DEFAULT NULL,
  `calculation_applies_on` varchar(255) DEFAULT NULL,
  `slab_reference` varchar(255) DEFAULT NULL,
  `maximum_limit` decimal(10,2) DEFAULT NULL,
  `minimum_limit` decimal(10,2) DEFAULT NULL,
  `rounding_rule` varchar(255) DEFAULT NULL,
  `prorata_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `lop_impact` tinyint(1) NOT NULL DEFAULT 0,
  `editable_at_payroll` tinyint(1) NOT NULL DEFAULT 0,
  `skip_if_insufficient_salary` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(11) DEFAULT NULL,
  `max_percent_net_salary` decimal(10,2) DEFAULT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deduction_rule_sets`
--

INSERT INTO `deduction_rule_sets` (`id`, `rule_set_code`, `rule_set_name`, `rule_category`, `calculation_type`, `calculation_base`, `calculation_value`, `calculation_applies_on`, `slab_reference`, `maximum_limit`, `minimum_limit`, `rounding_rule`, `prorata_applicable`, `lop_impact`, `editable_at_payroll`, `skip_if_insufficient_salary`, `priority`, `max_percent_net_salary`, `effective_from`, `effective_to`, `status`, `remarks`, `deleted_at`, `created_at`, `updated_at`) VALUES
('156bf4bc-d19c-46b4-8323-c1505deb1221', 'ESI_RULE_001', 'ESI 0.75 Percent Rule', 'Statutory', 'Percentage', 'Gross', '20.00', 'Pre', NULL, NULL, NULL, NULL, 0, 1, 1, 0, NULL, NULL, '2026-04-29', NULL, 'active', 'esi deduction rule', NULL, '2026-05-04 09:58:41', '2026-05-12 06:50:32'),
('dfe8556d-fc9a-4b3f-ad19-29e3b57d0dd1', 'PF_RULE_001', '12 percent Rule', 'Statutory', 'Percentage', 'Basic', '12.00', 'Pre', 'slab01', '1800.00', '0.00', 'Nearest', 1, 0, 0, 1, 1, '1.00', '2026-05-20', NULL, 'active', 'pf deduction rule', NULL, '2026-05-04 09:56:34', '2026-05-04 09:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `department_master`
--

CREATE TABLE `department_master` (
  `id` char(36) NOT NULL,
  `department_code` varchar(20) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(36) DEFAULT NULL,
  `updated_by` varchar(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_master`
--

INSERT INTO `department_master` (`id`, `department_code`, `department_name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('271db7a1-4789-11f1-80af-48684ad9278a', 'DEP001', 'General Medicine', 'General diagnosis and treatment', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfb35-4789-11f1-80af-48684ad9278a', 'DEP002', 'Cardiology', 'Heart related treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfc73-4789-11f1-80af-48684ad9278a', 'DEP003', 'Neurology', 'Brain and nervous system treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfcfc-4789-11f1-80af-48684ad9278a', 'DEP004', 'Orthopedics', 'Bone and joint treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfd7c-4789-11f1-80af-48684ad9278a', 'DEP005', 'Pediatrics', 'Child healthcare', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfdf8-4789-11f1-80af-48684ad9278a', 'DEP006', 'Dermatology', 'Skin treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfe5f-4789-11f1-80af-48684ad9278a', 'DEP007', 'Gynecology', 'Women reproductive healthcare', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dfec0-4789-11f1-80af-48684ad9278a', 'DEP008', 'ENT', 'Ear Nose Throat treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dff25-4789-11f1-80af-48684ad9278a', 'DEP009', 'Radiology', 'Medical imaging services', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dff8a-4789-11f1-80af-48684ad9278a', 'DEP010', 'Oncology', 'Cancer treatment department', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271dffeb-4789-11f1-80af-48684ad9278a', 'DEP011', 'Nephrology', 'Kidney related treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271e0053-4789-11f1-80af-48684ad9278a', 'DEP012', 'Urology', 'Urinary system treatments', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271e00be-4789-11f1-80af-48684ad9278a', 'DEP013', 'Pulmonology', 'Lung and respiratory diseases', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('271e0128-4789-11f1-80af-48684ad9278a', 'DEP015', 'ICU', 'Intensive care unit', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation_master`
--

CREATE TABLE `designation_master` (
  `id` char(36) NOT NULL,
  `designation_code` varchar(20) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `department_id` char(36) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` char(36) DEFAULT NULL,
  `updated_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation_master`
--

INSERT INTO `designation_master` (`id`, `designation_code`, `designation_name`, `department_id`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2726240d-4789-11f1-80af-48684ad9278a', 'DOC001', 'General Physician', NULL, 'General medical practitioner', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272648e5-4789-11f1-80af-48684ad9278a', 'DOC002', 'Cardiologist', NULL, 'Heart specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264a16-4789-11f1-80af-48684ad9278a', 'DOC003', 'Neurologist', NULL, 'Brain specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264a88-4789-11f1-80af-48684ad9278a', 'DOC004', 'Orthopedic Surgeon', NULL, 'Bone and joint surgeon', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264b09-4789-11f1-80af-48684ad9278a', 'DOC005', 'Pediatrician', NULL, 'Child health specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264b7c-4789-11f1-80af-48684ad9278a', 'DOC006', 'Dermatologist', NULL, 'Skin specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264be2-4789-11f1-80af-48684ad9278a', 'DOC007', 'Gynecologist', NULL, 'Women health specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264c43-4789-11f1-80af-48684ad9278a', 'DOC008', 'ENT Specialist', NULL, 'Ear nose throat specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264cab-4789-11f1-80af-48684ad9278a', 'DOC009', 'Radiologist', NULL, 'Medical imaging specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264d0d-4789-11f1-80af-48684ad9278a', 'DOC010', 'Oncologist', NULL, 'Cancer specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264d6a-4789-11f1-80af-48684ad9278a', 'DOC011', 'Nephrologist', NULL, 'Kidney specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264dc4-4789-11f1-80af-48684ad9278a', 'DOC012', 'Urologist', NULL, 'Urinary tract specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264e27-4789-11f1-80af-48684ad9278a', 'DOC013', 'Pulmonologist', NULL, 'Lung specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264e82-4789-11f1-80af-48684ad9278a', 'DOC014', 'Emergency Physician', NULL, 'Emergency treatment specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264eee-4789-11f1-80af-48684ad9278a', 'DOC015', 'Intensivist', NULL, 'ICU specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264f4c-4789-11f1-80af-48684ad9278a', 'DOC016', 'Cardiac Surgeon', NULL, 'Heart surgeon', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27264fac-4789-11f1-80af-48684ad9278a', 'DOC017', 'Neurosurgeon', NULL, 'Brain surgeon', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265019-4789-11f1-80af-48684ad9278a', 'DOC018', 'Plastic Surgeon', NULL, 'Reconstructive surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265085-4789-11f1-80af-48684ad9278a', 'DOC019', 'Gastroenterologist', NULL, 'Digestive system specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272650e4-4789-11f1-80af-48684ad9278a', 'DOC020', 'Endocrinologist', NULL, 'Hormone specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265148-4789-11f1-80af-48684ad9278a', 'DOC021', 'Diabetologist', NULL, 'Diabetes specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272651a7-4789-11f1-80af-48684ad9278a', 'DOC022', 'Hematologist', NULL, 'Blood disease specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265207-4789-11f1-80af-48684ad9278a', 'DOC023', 'Rheumatologist', NULL, 'Joint autoimmune diseases specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265262-4789-11f1-80af-48684ad9278a', 'DOC024', 'Ophthalmologist', NULL, 'Eye specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272652fc-4789-11f1-80af-48684ad9278a', 'DOC025', 'Psychiatrist', NULL, 'Mental health specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('2726535e-4789-11f1-80af-48684ad9278a', 'DOC026', 'Anesthesiologist', NULL, 'Anesthesia specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272653bd-4789-11f1-80af-48684ad9278a', 'DOC027', 'Pathologist', NULL, 'Laboratory diagnosis specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265423-4789-11f1-80af-48684ad9278a', 'DOC028', 'Pediatric Surgeon', NULL, 'Child surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265488-4789-11f1-80af-48684ad9278a', 'DOC029', 'Interventional Cardiologist', NULL, 'Heart procedure specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272654ed-4789-11f1-80af-48684ad9278a', 'DOC030', 'Vascular Surgeon', NULL, 'Blood vessel surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('2726554b-4789-11f1-80af-48684ad9278a', 'DOC031', 'Colorectal Surgeon', NULL, 'Colon surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272655ac-4789-11f1-80af-48684ad9278a', 'DOC032', 'Maxillofacial Surgeon', NULL, 'Jaw surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265611-4789-11f1-80af-48684ad9278a', 'DOC033', 'Pain Management Specialist', NULL, 'Pain treatment specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('2726566e-4789-11f1-80af-48684ad9278a', 'DOC034', 'Sleep Medicine Specialist', NULL, 'Sleep disorder specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272656d3-4789-11f1-80af-48684ad9278a', 'DOC035', 'Sports Medicine Specialist', NULL, 'Sports injury specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265733-4789-11f1-80af-48684ad9278a', 'DOC036', 'Allergist', NULL, 'Allergy specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('2726579b-4789-11f1-80af-48684ad9278a', 'DOC037', 'Infectious Disease Specialist', NULL, 'Infection specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265803-4789-11f1-80af-48684ad9278a', 'DOC038', 'Preventive Medicine Specialist', NULL, 'Disease prevention specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265863-4789-11f1-80af-48684ad9278a', 'DOC039', 'Geriatrician', NULL, 'Elderly care specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272658c1-4789-11f1-80af-48684ad9278a', 'DOC040', 'Reproductive Specialist', NULL, 'Fertility specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265925-4789-11f1-80af-48684ad9278a', 'DOC041', 'Transplant Surgeon', NULL, 'Organ transplant specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265983-4789-11f1-80af-48684ad9278a', 'DOC042', 'Medical Geneticist', NULL, 'Genetic disease specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('272659e7-4789-11f1-80af-48684ad9278a', 'DOC043', 'Addiction Specialist', NULL, 'Substance abuse specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265a48-4789-11f1-80af-48684ad9278a', 'DOC044', 'Clinical Pharmacologist', NULL, 'Drug therapy specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265aac-4789-11f1-80af-48684ad9278a', 'DOC045', 'Medical Microbiologist', NULL, 'Microorganism disease specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265b10-4789-11f1-80af-48684ad9278a', 'DOC046', 'Toxicologist', NULL, 'Poison treatment specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265b6c-4789-11f1-80af-48684ad9278a', 'DOC047', 'Occupational Medicine Specialist', NULL, 'Workplace health specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265e94-4789-11f1-80af-48684ad9278a', 'DOC048', 'Critical Care Specialist', NULL, 'Critical patient care specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265f11-4789-11f1-80af-48684ad9278a', 'DOC049', 'Hand Surgeon', NULL, 'Hand surgery specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('27265f72-4789-11f1-80af-48684ad9278a', 'DOC050', 'Palliative Care Specialist', NULL, 'End of life care specialist', 1, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('JKDVBCCXGP5AGUJCWWKCA8LEJHIIVR', 'NURS', 'Nurse', 'KLUFP85RQLFAN60HE4R6FL182C8FQP', NULL, 1, '1', NULL, '2026-04-11 09:29:18', '2026-04-11 09:29:18', NULL),
('QSL4TC1J1NXSKJP9FDJMSHAAIPJ2E3', 'DOC', 'doctor', 'KLUFP85RQLFAN60HE4R6FL182C8FQP', NULL, 1, '1', NULL, '2026-04-11 09:28:17', '2026-04-11 09:28:17', NULL),
('YX6XLKYSBPXOMLRBTS8D2MVKLCWZCX', 'NUR', 'Nurse', 'VR0OVAZZXREMFVXUZFQTBPUPXFZJAS', NULL, 1, '1', NULL, '2026-04-11 09:28:45', '2026-04-11 09:28:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discharge_preparations`
--

CREATE TABLE `discharge_preparations` (
  `id` char(36) NOT NULL,
  `hospital_id` char(36) DEFAULT NULL,
  `patient_id` char(36) NOT NULL,
  `ipd_admission_id` char(36) NOT NULL,
  `nurse_id` char(36) NOT NULL,
  `checklist` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`checklist`)),
  `belongings_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','in_progress','ready') NOT NULL DEFAULT 'pending',
  `is_ready` tinyint(1) NOT NULL DEFAULT 0,
  `prepared_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discharge_preparations`
--

INSERT INTO `discharge_preparations` (`id`, `hospital_id`, `patient_id`, `ipd_admission_id`, `nurse_id`, `checklist`, `belongings_status`, `status`, `is_ready`, `prepared_at`, `created_at`, `updated_at`) VALUES
('25e54f73-a39f-4825-b585-993f30c63a87', NULL, '97b06b47-3587-11f1-ade1-40c2ba22e44a', '5a9cdc97-bfc1-4abd-b835-1cac8676e92a', '39ddc769-6ae6-436d-937f-43e9024c6108', '{\"iv_removed\":\"on\",\"catheter_removed\":\"on\",\"dressing_done\":\"on\",\"vitals_recorded\":\"on\"}', 1, 'ready', 1, '2026-04-13 11:30:03', '2026-04-13 11:02:36', '2026-04-13 11:30:03'),
('7fbab615-7a1e-4e02-883d-c3df713c1421', NULL, '97b078ed-3587-11f1-ade1-40c2ba22e44a', '7befb061-6f4b-4f19-944d-eb40d067da04', '39ddc769-6ae6-436d-937f-43e9024c6108', '{\"iv_removed\":true,\"catheter_removed\":true,\"dressing_done\":true,\"vitals_recorded\":true}', 1, 'in_progress', 0, NULL, '2026-04-13 17:03:12', '2026-04-13 17:03:12'),
('9ab56115-119b-4bec-a21b-57666a9b20ff', NULL, '97b07e7a-3587-11f1-ade1-40c2ba22e44a', 'ef36bb11-1005-4097-856e-bcc599c23aa0', '39ddc769-6ae6-436d-937f-43e9024c6108', '{\"iv_removed\":true,\"catheter_removed\":true,\"dressing_done\":true,\"vitals_recorded\":true}', 1, 'ready', 1, '2026-04-13 17:10:41', '2026-04-13 17:04:15', '2026-04-13 17:10:41'),
('ab106277-04a8-466f-982d-51c4881e5102', NULL, '97b07f43-3587-11f1-ade1-40c2ba22e44a', '0654d908-7662-4491-baa0-bcedc7e96064', '39ddc769-6ae6-436d-937f-43e9024c6108', '{\"iv_removed\":\"on\",\"catheter_removed\":\"on\",\"dressing_done\":\"on\",\"vitals_recorded\":\"on\"}', 0, 'ready', 1, '2026-04-28 05:25:03', '2026-04-13 16:03:47', '2026-04-28 05:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_cases`
--

CREATE TABLE `emergency_cases` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `emergency_type` varchar(255) NOT NULL,
  `arrival_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `uploaded_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_assignments`
--

CREATE TABLE `employee_salary_assignments` (
  `id` char(36) NOT NULL,
  `employee_id` char(36) NOT NULL,
  `salary_structure_id` char(36) NOT NULL,
  `salary_basis` varchar(255) NOT NULL,
  `salary_amount` decimal(10,2) NOT NULL,
  `pay_frequency` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'INR',
  `hourly_pay_eligible` tinyint(1) NOT NULL DEFAULT 0,
  `overtime_eligible` tinyint(1) NOT NULL DEFAULT 0,
  `allowed_work_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_work_types`)),
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_salary_assignments`
--

INSERT INTO `employee_salary_assignments` (`id`, `employee_id`, `salary_structure_id`, `salary_basis`, `salary_amount`, `pay_frequency`, `currency`, `hourly_pay_eligible`, `overtime_eligible`, `allowed_work_types`, `effective_from`, `effective_to`, `status`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
('28ce9732-c617-471e-9dec-6804a36f377c', '5', '2f47aa7a-81b6-4eab-8b2c-8a92652151ec', 'Ctc', '50000.00', 'Monthly', 'INR', 1, 1, '[\"4fdee241-4393-4593-b022-4f6697307fcf\"]', '2026-04-28', NULL, 'active', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-04 10:17:09', '2026-05-04 10:17:09'),
('e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', '4', 'c5b3036a-853b-4c0e-984f-1b7581076bc5', 'Gross', '30000.00', 'Monthly', 'INR', 1, 1, '[\"e097ff44-1c3c-4d84-aba6-acfbd2ae2cf8\"]', '2026-04-28', NULL, 'active', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-04 10:17:38', '2026-05-04 10:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` char(36) NOT NULL,
  `equipment_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `condition_status` enum('Active','Under Maintenance','Out of Service') NOT NULL DEFAULT 'Active',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_breakdowns`
--

CREATE TABLE `equipment_breakdowns` (
  `id` char(36) NOT NULL,
  `equipment_id` char(36) NOT NULL,
  `description` text NOT NULL,
  `reported_by` varchar(255) NOT NULL,
  `breakdown_date` date NOT NULL,
  `severity` enum('Low','Medium','High','Critical') NOT NULL,
  `status` enum('Reported','Under Repair','Resolved') NOT NULL DEFAULT 'Reported',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_calibrations`
--

CREATE TABLE `equipment_calibrations` (
  `id` char(36) NOT NULL,
  `equipment_id` char(36) NOT NULL,
  `calibration_type` varchar(255) NOT NULL,
  `calibration_date` date NOT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `result` enum('Pass','Fail') NOT NULL,
  `next_due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_maintenance`
--

CREATE TABLE `equipment_maintenance` (
  `id` char(36) NOT NULL,
  `equipment_id` char(36) NOT NULL,
  `maintenance_type` enum('Preventive','Corrective') NOT NULL,
  `maintenance_date` date NOT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expiry_logs`
--

CREATE TABLE `expiry_logs` (
  `id` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` enum('EXPIRED','EXPIRING','PENDING','APPROVED','COMPLETED') NOT NULL DEFAULT 'EXPIRING',
  `remarks` text DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `updated_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_audit_logs`
--

CREATE TABLE `file_audit_logs` (
  `id` char(36) NOT NULL,
  `report_id` char(36) DEFAULT NULL,
  `sample_id` varchar(255) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` char(36) NOT NULL,
  `code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `code`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26d0a7e6-4789-11f1-80af-48684ad9278a', 'FY 2024-25', '2024-04-01', '2025-03-31', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26d0ec02-4789-11f1-80af-48684ad9278a', 'FY 2025-26', '2025-04-01', '2026-03-31', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geofences`
--

CREATE TABLE `geofences` (
  `id` char(36) NOT NULL,
  `institution_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `center_lat` decimal(10,7) NOT NULL,
  `center_lng` decimal(10,7) NOT NULL,
  `radius` int(11) NOT NULL DEFAULT 100,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grns`
--

CREATE TABLE `grns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grn_no` varchar(255) NOT NULL,
  `grn_date` date NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_file` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `remarks` text DEFAULT NULL,
  `verify_remarks` varchar(255) DEFAULT NULL,
  `reject_reason` varchar(255) DEFAULT NULL,
  `sub_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grn_items`
--

CREATE TABLE `grn_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grn_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `expiry` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `free_qty` int(11) NOT NULL DEFAULT 0,
  `purchase_rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(6,2) NOT NULL DEFAULT 0.00,
  `tax_percent` decimal(6,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `staff` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`staff`)),
  `details` text DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `start_date`, `end_date`, `roles`, `staff`, `details`, `document`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26dbf7a9-4789-11f1-80af-48684ad9278a', 'New Year', '2026-01-01', '2026-01-01', NULL, NULL, 'New Year public holiday', NULL, 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26dc059b-4789-11f1-80af-48684ad9278a', 'Independence Day', '2026-08-15', '2026-08-15', NULL, NULL, 'National holiday', NULL, 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26dc0682-4789-11f1-80af-48684ad9278a', 'Annual Maintenance Break', '2026-05-01', '2026-05-03', NULL, NULL, 'Planned hospital maintenance shutdown', NULL, 'inactive', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `institution_id` char(36) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `code`, `address`, `contact_number`, `institution_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26ac2ebd-4789-11f1-80af-48684ad9278a', 'General Hospital', 'HOSP-DH1', 'Near Bus Stand, Mangalore', '9876543210', '26a6fa1e-4789-11f1-80af-48684ad9278a', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26ac55df-4789-11f1-80af-48684ad9278a', 'Critical Care Hospital', 'HOSP-DH2', 'City Center, Mangalore', '9876543211', '26a6fa1e-4789-11f1-80af-48684ad9278a', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26ac58c5-4789-11f1-80af-48684ad9278a', 'Specialty Clinic', 'HOSP-DH3', 'Beach Road, Mangalore', '9876543212', '26a71e2e-4789-11f1-80af-48684ad9278a', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26ac59e4-4789-11f1-80af-48684ad9278a', 'Women & Children Hospital', 'HOSP-DH4', 'Market Road, Mangalore', '9876543213', '26a72127-4789-11f1-80af-48684ad9278a', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26ac5add-4789-11f1-80af-48684ad9278a', 'Rehabilitation Hospital', 'HOSP-DH5', 'Hilltop, Mangalore', '9876543214', '26a7220f-4789-11f1-80af-48684ad9278a', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospital_financial_years`
--

CREATE TABLE `hospital_financial_years` (
  `hospital_id` char(36) NOT NULL,
  `financial_year_id` char(36) NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospital_financial_years`
--

INSERT INTO `hospital_financial_years` (`hospital_id`, `financial_year_id`, `is_current`, `locked`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26ac2ebd-4789-11f1-80af-48684ad9278a', '26d0a7e6-4789-11f1-80af-48684ad9278a', 0, 0, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26ac2ebd-4789-11f1-80af-48684ad9278a', '26d0ec02-4789-11f1-80af-48684ad9278a', 0, 0, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hourly_pays`
--

CREATE TABLE `hourly_pays` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `is_taxable` tinyint(1) NOT NULL DEFAULT 0,
  `pf_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `esi_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `pt_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `is_prorata` tinyint(1) NOT NULL DEFAULT 0,
  `lop_impact` tinyint(1) NOT NULL DEFAULT 0,
  `earning_type` enum('fixed','variable') NOT NULL DEFAULT 'fixed',
  `show_in_payslip` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `payslip_label` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hourly_pays`
--

INSERT INTO `hourly_pays` (`id`, `name`, `code`, `category`, `is_taxable`, `pf_applicable`, `esi_applicable`, `pt_applicable`, `is_prorata`, `lop_impact`, `earning_type`, `show_in_payslip`, `display_order`, `created_at`, `updated_at`, `deleted_at`, `payslip_label`, `status`) VALUES
('4fdee241-4393-4593-b022-4f6697307fcf', 'Overtime work', 'HR;002', 'Overtime', 0, 0, 1, 1, 0, 0, 'variable', 1, 2, '2026-05-04 09:46:00', '2026-05-09 10:16:00', NULL, 'OT Pay', 'active'),
('e097ff44-1c3c-4d84-aba6-acfbd2ae2cf8', 'Regular hourly work', 'HRL001', 'Hourly', 1, 1, 0, 0, 0, 0, 'fixed', 1, 2, '2026-05-04 09:44:57', '2026-05-12 05:44:28', NULL, 'hourly pay', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `hourly_pay_approvals`
--

CREATE TABLE `hourly_pay_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` char(36) NOT NULL,
  `work_type_code` varchar(255) NOT NULL,
  `payroll_month` varchar(255) NOT NULL,
  `attendance_date` date NOT NULL,
  `approved_hours` decimal(5,2) NOT NULL,
  `shift_code` varchar(255) DEFAULT NULL,
  `day_type` enum('Working','Weekend','Holiday') NOT NULL DEFAULT 'Working',
  `source_type` enum('Biometric','Manual') NOT NULL DEFAULT 'Biometric',
  `approval_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `approved_by` char(36) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `locked_for_payroll` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hourly_pay_approvals`
--

INSERT INTO `hourly_pay_approvals` (`id`, `staff_id`, `work_type_code`, `payroll_month`, `attendance_date`, `approved_hours`, `shift_code`, `day_type`, `source_type`, `approval_status`, `approved_by`, `approved_date`, `locked_for_payroll`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2', 'HR;002', '2026-02', '2026-04-28', '4.90', NULL, 'Weekend', 'Manual', 'Pending', '2', '2026-05-04', 0, '2026-05-04 09:47:45', '2026-05-04 09:47:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `infection_control_logs`
--

CREATE TABLE `infection_control_logs` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `infection_type` varchar(255) NOT NULL,
  `severity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `organization_id` char(36) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `institution_url` varchar(255) DEFAULT NULL,
  `login_template` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_mobile` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `mou_copy` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `po_start_date` date DEFAULT NULL,
  `po_end_date` date DEFAULT NULL,
  `subscription_plan` varchar(255) DEFAULT NULL,
  `invoice_type` varchar(255) DEFAULT NULL,
  `invoice_frequency` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `invoice_amount` decimal(12,2) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_received` tinyint(1) NOT NULL DEFAULT 0,
  `payment_date` date DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `poc_name` varchar(255) DEFAULT NULL,
  `poc_email` varchar(255) DEFAULT NULL,
  `poc_contact` varchar(255) DEFAULT NULL,
  `support_sla` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `code`, `organization_id`, `gst_number`, `address`, `city`, `state`, `country`, `pincode`, `contact_number`, `email`, `timezone`, `institution_url`, `login_template`, `logo`, `default_language`, `admin_name`, `admin_email`, `admin_mobile`, `role`, `status`, `mou_copy`, `po_number`, `po_start_date`, `po_end_date`, `subscription_plan`, `invoice_type`, `invoice_frequency`, `payment_mode`, `invoice_amount`, `payment_status`, `payment_received`, `payment_date`, `transaction_reference`, `poc_name`, `poc_email`, `poc_contact`, `support_sla`, `deleted_at`, `created_at`, `updated_at`) VALUES
('26a6fa1e-4789-11f1-80af-48684ad9278a', 'Demo Health HQ', 'INST-HQ', '26a0f3e3-4789-11f1-80af-48684ad9278a', NULL, 'Main Road, Someshwara', 'Mangalore', 'Karnataka', 'India', '575001', '9876543210', 'hq@demohealth.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 07:16:20', '2026-05-04 07:16:20'),
('26a71e2e-4789-11f1-80af-48684ad9278a', 'Demo Health Clinic', 'INST-CLINIC', '26a0f3e3-4789-11f1-80af-48684ad9278a', NULL, 'Near Bus Stand, Mangalore', 'Mangalore', 'Karnataka', 'India', '575001', '9876543210', 'clinic@demohealth.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 07:16:20', '2026-05-04 07:16:20'),
('26a72127-4789-11f1-80af-48684ad9278a', 'Demo Diagnostics Center', 'INST-DIAG', '26a0f3e3-4789-11f1-80af-48684ad9278a', NULL, 'City Center, Mangalore', 'Mangalore', 'Karnataka', 'India', '575002', '9876543211', 'diagnostics@demohealth.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 07:16:20', '2026-05-04 07:16:20'),
('26a7220f-4789-11f1-80af-48684ad9278a', 'Demo Rehabilitation Center', 'INST-REHAB', '26a0f3e3-4789-11f1-80af-48684ad9278a', NULL, 'Beach Road, Mangalore', 'Mangalore', 'Karnataka', 'India', '575003', '9876543212', 'rehab@demohealth.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 07:16:20', '2026-05-04 07:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `institution_module`
--

CREATE TABLE `institution_module` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` char(36) NOT NULL,
  `module_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institution_module`
--

INSERT INTO `institution_module` (`id`, `institution_id`, `module_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b42983-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(2, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b44271-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(3, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b444a8-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(4, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b4452a-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(5, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b445a8-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(6, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b445fe-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(7, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b446e0-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(8, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b44861-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(9, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b44dc3-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(10, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b44ebd-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(11, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b44f85-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(12, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b4504f-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
(13, '26a6fa1e-4789-11f1-80af-48684ad9278a', '26b45121-4789-11f1-80af-48684ad9278a', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_documents`
--

CREATE TABLE `insurance_documents` (
  `id` char(36) NOT NULL,
  `insurance_id` char(36) NOT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_vendors`
--

CREATE TABLE `inventory_vendors` (
  `id` char(36) NOT NULL,
  `vendor_name` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_admissions`
--

CREATE TABLE `ipd_admissions` (
  `id` char(36) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `doctor_id` char(36) DEFAULT NULL,
  `department_id` char(36) DEFAULT NULL,
  `ward_id` char(36) DEFAULT NULL,
  `room_id` char(36) DEFAULT NULL,
  `bed_id` char(36) DEFAULT NULL,
  `admission_type` enum('planned','emergency') NOT NULL DEFAULT 'planned',
  `status` enum('active','discharged','cancelled') NOT NULL DEFAULT 'active',
  `admission_date` datetime NOT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `advance_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `insurance_flag` tinyint(1) NOT NULL DEFAULT 0,
  `insurance_provider` varchar(255) DEFAULT NULL,
  `policy_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_admissions`
--

INSERT INTO `ipd_admissions` (`id`, `admission_id`, `patient_id`, `doctor_id`, `department_id`, `ward_id`, `room_id`, `bed_id`, `admission_type`, `status`, `admission_date`, `discharge_date`, `advance_amount`, `insurance_flag`, `insurance_provider`, `policy_number`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
('0bd0d959-57e9-4b74-bb9b-68f8944ab82c', 'IPD-2026-003', '26e2ce73-4789-11f1-80af-48684ad9278a', '5', '271dff8a-4789-11f1-80af-48684ad9278a', 'a9a922d7-7224-4def-9015-68870db3fe3b', 'b37776b6-4870-11f1-aaf6-e7644015a707', 'c740f849-ae19-4c25-9019-0c50a88edb01', 'planned', 'discharged', '2026-05-07 11:00:00', NULL, '3000.00', 0, NULL, NULL, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-07 05:31:35', '2026-05-07 05:42:47'),
('0bfdf3e8-48fd-11f1-b27d-48684ad9278a', 'ADM001', '26c52b2c-4789-11f1-80af-48684ad9278a', '6', '271dfe15-4789-11f1-80af-48684ad9278a', NULL, NULL, NULL, 'planned', 'active', '2026-05-06 09:08:29', NULL, '1000.00', 0, NULL, NULL, NULL, 'admin', '2026-05-06 03:38:29', '2026-05-06 03:38:29'),
('659644df-9d13-48a5-8889-727b082b1f43', 'IPD-2026-001', '26e2cfc6-4789-11f1-80af-48684ad9278a', '82b0ab0d-4792-11f1-80af-48684ad9278a', '271dff25-4789-11f1-80af-48684ad9278a', '95c93edf-4f92-4fa5-8e1f-e569399885b3', 'b37776b6-4870-11f1-aaf6-e7644015a707', '9c917162-1b5d-4835-aeef-736da59d3f1a', 'planned', 'discharged', '2026-05-05 16:27:00', NULL, '0.00', 0, NULL, NULL, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-05 10:58:35', '2026-05-07 05:55:52'),
('dbad6e92-0cc0-4022-a273-5b69f9852ad7', 'IPD-2026-004', '26e2cee8-4789-11f1-80af-48684ad9278a', '9', '271dff25-4789-11f1-80af-48684ad9278a', '95c93edf-4f92-4fa5-8e1f-e569399885b3', 'b37776b6-4870-11f1-aaf6-e7644015a707', '9c917162-1b5d-4835-aeef-736da59d3f1a', 'planned', 'active', '2026-05-06 11:35:00', NULL, '2500.00', 0, NULL, NULL, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-08 06:07:19', '2026-05-08 06:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_bills`
--

CREATE TABLE `ipd_bills` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `bill_date` date NOT NULL,
  `status` enum('interim','final') NOT NULL DEFAULT 'interim',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payable_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_by` char(36) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_bills`
--

INSERT INTO `ipd_bills` (`id`, `patient_id`, `ipd_id`, `bill_no`, `bill_date`, `status`, `total_amount`, `discount_percent`, `tax_percent`, `discount`, `tax`, `grand_total`, `payable_amount`, `created_by`, `notes`, `created_at`, `updated_at`) VALUES
('1', '1', '0bd0d959-57e9-4b74-bb9b-68f8944ab82c', 'BILL-1001', '2026-05-08', '', '6000.00', '0.00', '0.00', '0.00', '0.00', '6000.00', '6000.00', NULL, NULL, NULL, NULL),
('2a3589fa-4af3-11f1-a288-cffa76628988', '', 'dbad6e92-0cc0-4022-a273-5b69f9852ad7', 'BILL-2002', '2026-05-09', 'interim', '0.00', '0.00', '0.00', '0.00', '0.00', '12000.00', '0.00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ipd_bill_items`
--

CREATE TABLE `ipd_bill_items` (
  `id` char(36) NOT NULL,
  `bill_id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` char(36) DEFAULT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_bill_items`
--

INSERT INTO `ipd_bill_items` (`id`, `bill_id`, `type`, `reference_type`, `reference_id`, `description`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
('1', '1', 'service', 'manual', '1', 'Room Charges', 1, '3000.00', '3000.00', NULL, NULL),
('2', '1', 'medicine', 'manual', '2', 'Paracetamol 500mg', 1, '3000.00', '3000.00', NULL, NULL),
('2a3d8e02-4af3-11f1-a288-cffa76628988', '2a3589fa-4af3-11f1-a288-cffa76628988', '', NULL, NULL, 'ICU Charges', 1, '7000.00', '7000.00', NULL, NULL),
('2a42fb0f-4af3-11f1-a288-cffa76628988', '2a3589fa-4af3-11f1-a288-cffa76628988', '', NULL, NULL, 'Injection', 1, '5000.00', '5000.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ipd_discharges`
--

CREATE TABLE `ipd_discharges` (
  `id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `treatment_given` text DEFAULT NULL,
  `medication_advice` text DEFAULT NULL,
  `follow_up` text DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_discharges`
--

INSERT INTO `ipd_discharges` (`id`, `ipd_id`, `diagnosis`, `treatment_given`, `medication_advice`, `follow_up`, `doctor_name`, `date`, `created_at`, `updated_at`) VALUES
('3705be8f-671e-4a0d-ae7b-cf8b3aea9460', '0bd0d959-57e9-4b74-bb9b-68f8944ab82c', 'fever', 'paracetmol', NULL, NULL, 'Super Admin', '2026-05-07', '2026-05-07 05:42:47', '2026-05-07 05:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_notes`
--

CREATE TABLE `ipd_notes` (
  `id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `doctor_id` char(36) DEFAULT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_payments`
--

CREATE TABLE `ipd_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `transaction_type` enum('advance','additional') NOT NULL DEFAULT 'advance',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_payments`
--

INSERT INTO `ipd_payments` (`id`, `patient_id`, `ipd_id`, `amount`, `payment_mode`, `transaction_type`, `created_at`, `updated_at`) VALUES
(1, '', '0bd0d959-57e9-4b74-bb9b-68f8944ab82c', '6000.00', 'upi', 'advance', NULL, NULL),
(2, '', 'dbad6e92-0cc0-4022-a273-5b89f9852ad7', '12000.00', 'card', 'advance', NULL, NULL),
(5, '', 'dbad6e92-0cc0-4022-a273-5b69f9852ad7', '0.00', 'cash', 'advance', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ipd_prescriptions`
--

CREATE TABLE `ipd_prescriptions` (
  `id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `doctor_id` char(36) NOT NULL,
  `prescription_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_prescriptions`
--

INSERT INTO `ipd_prescriptions` (`id`, `ipd_id`, `patient_id`, `doctor_id`, `prescription_date`, `status`, `created_at`, `updated_at`) VALUES
('0af42542-2d1c-41ee-a65b-22e78d025d1a', '659644df-9d13-48a5-8889-727b082b1f43', '26e2cfc6-4789-11f1-80af-48684ad9278a', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-05', 'Dispensed', '2026-05-05 11:00:51', '2026-05-05 11:03:12'),
('18c1ce3c-690a-4170-906f-b3e96adcc7fd', 'dbad6e92-0cc0-4022-a273-5b69f9852ad7', '26e2cee8-4789-11f1-80af-48684ad9278a', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-08', 'Dispensed', '2026-05-08 06:08:42', '2026-05-08 06:09:43'),
('31de2c6a-74fd-4e18-834b-46418b20c59e', 'dbad6e92-0cc0-4022-a273-5b69f9852ad7', '26e2cee8-4789-11f1-80af-48684ad9278a', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-08', 'Pending', '2026-05-08 14:39:40', '2026-05-08 14:39:40'),
('bdb44534-f199-4ad2-aaa2-4715ca2cb281', '0bd0d959-57e9-4b74-bb9b-68f8944ab82c', '26e2ce73-4789-11f1-80af-48684ad9278a', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-07', 'Dispensed', '2026-05-07 05:33:18', '2026-05-07 05:36:06');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_prescription_items`
--

CREATE TABLE `ipd_prescription_items` (
  `id` char(36) NOT NULL,
  `prescription_id` char(36) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_prescription_items`
--

INSERT INTO `ipd_prescription_items` (`id`, `prescription_id`, `medicine_name`, `dosage`, `frequency`, `duration`, `instructions`, `created_at`, `updated_at`) VALUES
('021fbe55-707c-4ca4-8552-6952e34b713b', '31de2c6a-74fd-4e18-834b-46418b20c59e', 'Ibuprofen 400mg', '150', '1-0-0', NULL, NULL, '2026-05-08 14:39:40', '2026-05-08 14:39:40'),
('33e5c515-ce7f-4b38-987d-10c67e60e031', '0af42542-2d1c-41ee-a65b-22e78d025d1a', 'Paracetamol 500mg', '150', '1-0-0', '3', 'beforre food', '2026-05-05 11:00:51', '2026-05-05 11:00:51'),
('79a9c964-9570-4c2d-975f-c26732108ca5', 'bdb44534-f199-4ad2-aaa2-4715ca2cb281', 'Paracetamol 500mg', '150', '1-0-0', '3', NULL, '2026-05-07 05:33:18', '2026-05-07 05:33:18'),
('b14d5254-ec13-4954-bc42-c993aff78cfe', '18c1ce3c-690a-4170-906f-b3e96adcc7fd', 'Diclofenac 50mg', '300', '1-0-0', '10', NULL, '2026-05-08 06:08:42', '2026-05-08 06:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_treatments`
--

CREATE TABLE `ipd_treatments` (
  `id` char(36) NOT NULL,
  `ipd_id` char(36) NOT NULL,
  `treatment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_treatments`
--

INSERT INTO `ipd_treatments` (`id`, `ipd_id`, `treatment`, `created_at`, `updated_at`) VALUES
('3a7afc9b-339b-4d41-8d18-e7aa1907fac6', 'dbad6e92-0cc0-4022-a273-5b69f9852ad7', 'hang scan', '2026-05-08 06:08:12', '2026-05-08 06:08:12'),
('6bf9c2bd-c678-4b92-a8a2-01771ea3df6e', '659644df-9d13-48a5-8889-727b082b1f43', 'nasal clean', '2026-05-05 10:59:56', '2026-05-05 10:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `isolation_records`
--

CREATE TABLE `isolation_records` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `isolation_type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `stock` int(11) NOT NULL DEFAULT 0,
  `minimum_stock` int(11) NOT NULL DEFAULT 10,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_type_master`
--

CREATE TABLE `job_type_master` (
  `id` char(36) NOT NULL,
  `job_type_code` varchar(50) NOT NULL,
  `job_type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `display_order` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_reports`
--

CREATE TABLE `lab_reports` (
  `id` char(36) NOT NULL,
  `sample_id` char(36) NOT NULL,
  `result_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result_data`)),
  `status` enum('Draft','In Progress','Completed') NOT NULL DEFAULT 'Draft',
  `entered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `verification_status` enum('Pending','Verified','Rejected','Finalized') NOT NULL DEFAULT 'Pending',
  `verified_by` char(36) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verification_notes` text DEFAULT NULL,
  `digital_signature` varchar(255) DEFAULT NULL,
  `finalized_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_requests`
--

CREATE TABLE `lab_requests` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `consultation_id` char(36) NOT NULL,
  `test_name` text NOT NULL,
  `priority` enum('routine','urgent','stat') NOT NULL DEFAULT 'routine',
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_tests`
--

CREATE TABLE `lab_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `test_code` varchar(255) NOT NULL,
  `test_category` varchar(255) DEFAULT NULL,
  `sample_type` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `turnaround_time` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_adjustments`
--

CREATE TABLE `leave_adjustments` (
  `id` char(36) NOT NULL,
  `staff_id` char(36) NOT NULL,
  `leave_type_id` char(36) NOT NULL,
  `credit` int(11) NOT NULL DEFAULT 0,
  `debit` int(11) NOT NULL DEFAULT 0,
  `remarks` text NOT NULL,
  `year` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_adjustments`
--

INSERT INTO `leave_adjustments` (`id`, `staff_id`, `leave_type_id`, `credit`, `debit`, `remarks`, `year`, `created_at`, `updated_at`) VALUES
('27409020-4789-11f1-80af-48684ad9278a', '5', '272bc103-4789-11f1-80af-48684ad9278a', 12, 2, 'Opening Balance', 2026, '2026-05-04 07:16:21', '2026-05-09 04:52:32'),
('2740b4fd-4789-11f1-80af-48684ad9278a', '5', '272bce39-4789-11f1-80af-48684ad9278a', 10, 0, 'Opening Balance', 2026, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('36c4efea-c98d-4e6e-9af1-65fedbcd68fc', '5', '272bce39-4789-11f1-80af-48684ad9278a', 9, 0, 'b', 2026, '2026-05-09 04:27:18', '2026-05-09 04:27:18'),
('9a4f4073-6f79-4ba9-9b1f-f9e6b0b45027', '7', '272bce39-4789-11f1-80af-48684ad9278a', 2, 0, 'bonus', 2026, '2026-05-09 03:46:24', '2026-05-09 03:46:24'),
('acb91c23-d283-47a6-a525-57c73c121a9a', '7', '272bce39-4789-11f1-80af-48684ad9278a', 0, 1, 'penalty', 2026, '2026-05-09 03:47:03', '2026-05-09 03:47:03'),
('f7d97b9b-fb39-4845-b10b-66e051eba20a', '7', '272bce39-4789-11f1-80af-48684ad9278a', 2, 0, 'bonus', 2026, '2026-05-09 04:24:37', '2026-05-09 04:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` char(36) NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` char(36) NOT NULL,
  `leave_duration` enum('full_day','first_half','second_half') NOT NULL DEFAULT 'full_day',
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `balance_before` decimal(5,2) DEFAULT NULL,
  `balance_after` decimal(5,2) DEFAULT NULL,
  `leave_days` decimal(4,1) NOT NULL,
  `reason` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','withdrawn') NOT NULL DEFAULT 'pending',
  `current_approval_level` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `staff_id`, `leave_type_id`, `leave_duration`, `from_date`, `to_date`, `balance_before`, `balance_after`, `leave_days`, `reason`, `attachment`, `status`, `current_approval_level`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2745e05d-4789-11f1-80af-48684ad9278a', 5, '272bc103-4789-11f1-80af-48684ad9278a', 'full_day', '2026-03-20', '2026-03-21', NULL, NULL, '2.0', 'Personal work', NULL, 'approved', 4, '2026-05-04 07:16:22', '2026-05-09 04:52:32', NULL),
('2746196a-4789-11f1-80af-48684ad9278a', 5, '272bce39-4789-11f1-80af-48684ad9278a', 'full_day', '2026-03-25', '2026-03-25', NULL, NULL, '1.0', 'Fever', NULL, 'pending', 1, '2026-05-04 07:16:22', '2026-05-04 07:16:22', NULL),
('67ff43f1-23d2-45fa-ae1b-61fba5e68ee4', 7, '98e89bbf-7afd-4809-a6e3-6e92b97c6f53', 'full_day', '2026-05-18', '2026-05-19', '4.00', '2.00', '2.0', NULL, NULL, 'rejected', 4, '2026-05-09 05:22:00', '2026-05-09 05:22:43', NULL),
('74c1b218-24bc-463f-a2f1-9a48b82d7010', 7, '272bc103-4789-11f1-80af-48684ad9278a', 'full_day', '2026-05-11', '2026-05-13', '6.00', '3.00', '3.0', NULL, NULL, 'approved', 4, '2026-05-09 04:46:15', '2026-05-09 04:52:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_mappings`
--

CREATE TABLE `leave_mappings` (
  `id` char(36) NOT NULL,
  `leave_type_id` char(36) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `employee_status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`employee_status`)),
  `designations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`designations`)),
  `gender` varchar(255) DEFAULT NULL,
  `employment_type` varchar(255) DEFAULT NULL,
  `employee_category` varchar(255) DEFAULT NULL,
  `accrual_frequency` varchar(255) NOT NULL,
  `accrual_value` int(11) NOT NULL,
  `leave_nature` varchar(255) NOT NULL,
  `carry_forward_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `carry_forward_limit` int(11) DEFAULT NULL,
  `carry_forward_expiry_days` int(11) DEFAULT NULL,
  `encashment_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `encashment_trigger` varchar(255) DEFAULT NULL,
  `min_leave_per_application` int(11) NOT NULL DEFAULT 1,
  `max_leave_per_application` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_mappings`
--

INSERT INTO `leave_mappings` (`id`, `leave_type_id`, `priority`, `employee_status`, `designations`, `gender`, `employment_type`, `employee_category`, `accrual_frequency`, `accrual_value`, `leave_nature`, `carry_forward_allowed`, `carry_forward_limit`, `carry_forward_expiry_days`, `encashment_allowed`, `encashment_trigger`, `min_leave_per_application`, `max_leave_per_application`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('70a28062-ecc1-40c5-af49-94c45ef0a8d3', '272bce39-4789-11f1-80af-48684ad9278a', 1, '[\"Permanent\"]', '[\"QSL4TC1J1NXSKJP9FDJMSHAAIPJ2E3\"]', 'Male', 'Full-time', NULL, 'Monthly', -2, 'Paid', 0, NULL, NULL, 0, NULL, 1, 5, 'inactive', '2026-05-09 03:39:41', '2026-05-09 03:39:41', NULL),
('c2a17d4f-2fc8-4b49-93b5-18d893ac5e8d', '98e89bbf-7afd-4809-a6e3-6e92b97c6f53', 3, '[\"Permanent\"]', '[\"2726240d-4789-11f1-80af-48684ad9278a\"]', 'Female', 'Full-time', NULL, 'Monthly', 4, 'Paid', 0, NULL, NULL, 0, NULL, 1, NULL, 'inactive', '2026-05-09 05:20:27', '2026-05-09 05:20:27', NULL),
('e2409a82-3fc8-4305-8f4d-05f8c9798af3', '272bc103-4789-11f1-80af-48684ad9278a', 2, '[\"Permanent\"]', '[\"2726240d-4789-11f1-80af-48684ad9278a\"]', 'Female', 'Full-time', NULL, 'Monthly', 6, 'Paid', 0, NULL, NULL, 0, NULL, 1, NULL, 'inactive', '2026-05-09 04:44:58', '2026-05-09 04:44:58', NULL),
('ebbfab19-5f81-4cc8-a6cc-0a32bf8f24a3', '272bce39-4789-11f1-80af-48684ad9278a', 1, '[\"Permanent\"]', '[\"2726240d-4789-11f1-80af-48684ad9278a\"]', 'Female', 'Full-time', NULL, 'Monthly', 5, 'Paid', 0, NULL, NULL, 0, NULL, 1, NULL, 'inactive', '2026-05-09 03:45:41', '2026-05-09 05:25:56', '2026-05-09 05:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `leave_request_approvals`
--

CREATE TABLE `leave_request_approvals` (
  `id` char(36) NOT NULL,
  `leave_request_id` char(36) NOT NULL,
  `approver_id` char(36) NOT NULL,
  `level` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_request_approvals`
--

INSERT INTO `leave_request_approvals` (`id`, `leave_request_id`, `approver_id`, `level`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
('b70ca4ec-94af-4a82-ab6b-d4f98ce942df', '74c1b218-24bc-463f-a2f1-9a48b82d7010', '26ccb79a-4789-11f1-80af-48684ad9278a', 1, 'approved', 'No remarks provided.', '2026-05-09 04:52:13', '2026-05-09 04:52:13'),
('d867651f-1cf9-4ce9-ae0d-fa3b23b0789b', '2745e05d-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', 1, 'approved', 'No remarks provided.', '2026-05-09 04:52:32', '2026-05-09 04:52:32'),
('f299a0e6-9316-4cbb-a80f-1e84fca28f8e', '67ff43f1-23d2-45fa-ae1b-61fba5e68ee4', '26ccb79a-4789-11f1-80af-48684ad9278a', 4, 'rejected', 'NO', '2026-05-09 05:22:43', '2026-05-09 05:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` char(36) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `allow_half_day` tinyint(1) NOT NULL DEFAULT 0,
  `min_leave_unit` decimal(2,1) NOT NULL DEFAULT 1.0,
  `max_continuous_days` int(11) DEFAULT NULL,
  `count_weekends` tinyint(1) NOT NULL DEFAULT 0,
  `count_holidays` tinyint(1) NOT NULL DEFAULT 0,
  `sandwich_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `sandwich_applies_on` varchar(255) DEFAULT NULL,
  `approval_required` tinyint(1) NOT NULL DEFAULT 1,
  `approval_level` varchar(255) NOT NULL DEFAULT 'Single',
  `allow_backdate` tinyint(1) NOT NULL DEFAULT 0,
  `max_backdate_days` int(11) DEFAULT NULL,
  `attendance_code` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `display_name`, `description`, `allow_half_day`, `min_leave_unit`, `max_continuous_days`, `count_weekends`, `count_holidays`, `sandwich_enabled`, `sandwich_applies_on`, `approval_required`, `approval_level`, `allow_backdate`, `max_backdate_days`, `attendance_code`, `deleted_at`, `created_at`, `updated_at`) VALUES
('272bc103-4789-11f1-80af-48684ad9278a', 'Casual Leave', 'Standard casual leave', 1, '0.5', 3, 0, 0, 0, NULL, 1, 'Single', 0, NULL, 'CL', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('272bce39-4789-11f1-80af-48684ad9278a', 'Sick Leave', 'Medical leave', 1, '0.5', 15, 0, 0, 0, NULL, 1, 'Sequential', 0, NULL, 'SL', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('272bcf27-4789-11f1-80af-48684ad9278a', 'Earned Leave', 'Privilege leave', 0, '1.0', 30, 1, 1, 1, NULL, 1, 'Sequential', 0, NULL, 'EL', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('98e89bbf-7afd-4809-a6e3-6e92b97c6f53', 'Comp Off', 'Compensatory leave for holiday work', 0, '1.0', NULL, 1, 1, 0, 'Weekend', 1, 'Single', 1, 5, 'cmp_ath', NULL, '2026-05-09 05:19:22', '2026-05-09 05:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `medication_administration`
--

CREATE TABLE `medication_administration` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `prescription_item_id` char(36) NOT NULL,
  `scheduled_time` time DEFAULT NULL,
  `administered_time` datetime DEFAULT NULL,
  `status` enum('pending','administered','missed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` char(36) NOT NULL,
  `medicine_name` varchar(150) NOT NULL,
  `generic_name` varchar(150) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `manufacturer` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicine_name`, `generic_name`, `category`, `manufacturer`, `status`, `created_at`, `updated_at`) VALUES
('26eb7ee9-4789-11f1-80af-48684ad9278a', 'Paracetamol 500mg', 'Paracetamol', 'Tablet', 'Sun Pharma', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9c78-4789-11f1-80af-48684ad9278a', 'Amoxicillin 250mg', 'Amoxicillin', 'Capsule', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9d78-4789-11f1-80af-48684ad9278a', 'Ibuprofen 400mg', 'Ibuprofen', 'Tablet', 'Dr Reddys', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9e0e-4789-11f1-80af-48684ad9278a', 'Azithromycin 500mg', 'Azithromycin', 'Tablet', 'Aurobindo', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9e53-4789-11f1-80af-48684ad9278a', 'Cetirizine 10mg', 'Cetirizine', 'Tablet', 'Sun Pharma', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9e91-4789-11f1-80af-48684ad9278a', 'Metformin 500mg', 'Metformin', 'Tablet', 'Lupin', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9ecb-4789-11f1-80af-48684ad9278a', 'Pantoprazole 40mg', 'Pantoprazole', 'Tablet', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9eff-4789-11f1-80af-48684ad9278a', 'Omeprazole 20mg', 'Omeprazole', 'Capsule', 'Sun Pharma', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9f3d-4789-11f1-80af-48684ad9278a', 'Atorvastatin 10mg', 'Atorvastatin', 'Tablet', 'Zydus', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9f71-4789-11f1-80af-48684ad9278a', 'Aspirin 75mg', 'Aspirin', 'Tablet', 'Bayer', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9fac-4789-11f1-80af-48684ad9278a', 'Diclofenac 50mg', 'Diclofenac', 'Tablet', 'Novartis', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eb9fe4-4789-11f1-80af-48684ad9278a', 'Dolo 650', 'Paracetamol', 'Tablet', 'Micro Labs', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba019-4789-11f1-80af-48684ad9278a', 'Augmentin 625', 'Amoxicillin + Clavulanic', 'Tablet', 'GSK', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba054-4789-11f1-80af-48684ad9278a', 'Cough Syrup DX', 'Dextromethorphan', 'Syrup', 'Benadryl', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba089-4789-11f1-80af-48684ad9278a', 'Insulin Injection', 'Insulin', 'Injection', 'Novo Nordisk', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba0c0-4789-11f1-80af-48684ad9278a', 'Vitamin C 500mg', 'Ascorbic Acid', 'Tablet', 'Himalaya', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba105-4789-11f1-80af-48684ad9278a', 'Calcium Tablet', 'Calcium Carbonate', 'Tablet', 'Shelcal', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba159-4789-11f1-80af-48684ad9278a', 'ORS Sachet', 'Oral Rehydration Salt', 'Powder', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba1a3-4789-11f1-80af-48684ad9278a', 'Ranitidine 150mg', 'Ranitidine', 'Tablet', 'Sun Pharma', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba1de-4789-11f1-80af-48684ad9278a', 'Levocetirizine 5mg', 'Levocetirizine', 'Tablet', 'Dr Reddys', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba211-4789-11f1-80af-48684ad9278a', 'Montelukast 10mg', 'Montelukast', 'Tablet', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba243-4789-11f1-80af-48684ad9278a', 'Clopidogrel 75mg', 'Clopidogrel', 'Tablet', 'Zydus', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba278-4789-11f1-80af-48684ad9278a', 'Hydroxychloroquine', 'Hydroxychloroquine', 'Tablet', 'Ipca', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba2ae-4789-11f1-80af-48684ad9278a', 'Folic Acid 5mg', 'Folic Acid', 'Tablet', 'Lupin', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba2e3-4789-11f1-80af-48684ad9278a', 'Iron Tablet', 'Ferrous Sulphate', 'Tablet', 'Ranbaxy', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba31b-4789-11f1-80af-48684ad9278a', 'Amikacin Injection', 'Amikacin', 'Injection', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba354-4789-11f1-80af-48684ad9278a', 'Salbutamol Inhaler', 'Salbutamol', 'Inhaler', 'GSK', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba386-4789-11f1-80af-48684ad9278a', 'Betadine Ointment', 'Povidone Iodine', 'Ointment', 'Win Medicare', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba3bc-4789-11f1-80af-48684ad9278a', 'Loperamide 2mg', 'Loperamide', 'Capsule', 'Sun Pharma', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26eba3f3-4789-11f1-80af-48684ad9278a', 'Domperidone 10mg', 'Domperidone', 'Tablet', 'Cipla', 1, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('7b877c64-cee1-4762-be7f-ed986269f701', 'origano', 'origano', 'ji', 'mmkk', 1, '2026-05-05 11:06:10', '2026-05-05 11:06:10'),
('adfeaa82-bd57-4e47-8139-5666f048d13c', 'origano', 'origano', 'ji', 'mmkk', 1, '2026-05-05 11:06:11', '2026-05-05 11:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_batches`
--

CREATE TABLE `medicine_batches` (
  `id` char(36) NOT NULL,
  `medicine_id` char(36) NOT NULL,
  `batch_number` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_batches`
--

INSERT INTO `medicine_batches` (`id`, `medicine_id`, `batch_number`, `expiry_date`, `purchase_price`, `mrp`, `quantity`, `reorder_level`, `created_at`, `updated_at`, `deleted_at`) VALUES
('019df7d1-1f63-7251-8dae-408ccb835424', '7b877c64-cee1-4762-be7f-ed986269f701', '577575577001', '2026-05-08', '67.00', '87.00', 34, 0, '2026-05-05 11:06:10', '2026-05-05 11:06:10', NULL),
('019df7d1-22d2-7164-8a77-359c4ab970a3', 'adfeaa82-bd57-4e47-8139-5666f048d13c', '577575577001', '2026-05-08', '67.00', '87.00', 34, 0, '2026-05-05 11:06:11', '2026-05-05 11:06:11', NULL),
('26f94a8c-4789-11f1-80af-48684ad9278a', '26eba1a3-4789-11f1-80af-48684ad9278a', 'BATCH001', '2027-01-10', '12.50', '18.00', 150, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f96b8c-4789-11f1-80af-48684ad9278a', '26eb9d78-4789-11f1-80af-48684ad9278a', 'BATCH002', '2026-11-20', '8.20', '12.00', 200, 50, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9720a-4789-11f1-80af-48684ad9278a', '26eb9fe4-4789-11f1-80af-48684ad9278a', 'BATCH003', '2027-03-15', '22.00', '30.00', 120, 30, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f97566-4789-11f1-80af-48684ad9278a', '26eba386-4789-11f1-80af-48684ad9278a', 'BATCH004', '2026-09-01', '5.50', '10.00', 80, 25, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9793e-4789-11f1-80af-48684ad9278a', '26eba3f3-4789-11f1-80af-48684ad9278a', 'BATCH005', '2027-04-25', '15.00', '22.00', 140, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9d374-4789-11f1-80af-48684ad9278a', '26eb9ecb-4789-11f1-80af-48684ad9278a', 'BATCH006', '2027-06-30', '9.50', '14.00', 160, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9dcde-4789-11f1-80af-48684ad9278a', '26eba2e3-4789-11f1-80af-48684ad9278a', 'BATCH007', '2026-12-18', '11.00', '17.00', 90, 30, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9e3b6-4789-11f1-80af-48684ad9278a', '26eba243-4789-11f1-80af-48684ad9278a', 'BATCH008', '2027-08-14', '18.00', '25.00', 110, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9e9f8-4789-11f1-80af-48684ad9278a', '26eba159-4789-11f1-80af-48684ad9278a', 'BATCH009', '2027-05-05', '6.50', '11.00', 210, 60, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9f06a-4789-11f1-80af-48684ad9278a', '26eba3f3-4789-11f1-80af-48684ad9278a', 'BATCH010', '2026-10-12', '14.00', '20.00', 70, 25, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9f6bd-4789-11f1-80af-48684ad9278a', '26eb9e53-4789-11f1-80af-48684ad9278a', 'BATCH011', '2027-07-01', '7.20', '12.50', 95, 30, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26f9fd29-4789-11f1-80af-48684ad9278a', '26eb9f71-4789-11f1-80af-48684ad9278a', 'BATCH012', '2026-08-22', '16.00', '24.00', 130, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa02f5-4789-11f1-80af-48684ad9278a', '26eba31b-4789-11f1-80af-48684ad9278a', 'BATCH013', '2027-02-17', '13.50', '19.00', 145, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa09c3-4789-11f1-80af-48684ad9278a', '26eba1de-4789-11f1-80af-48684ad9278a', 'BATCH014', '2027-09-10', '10.00', '15.00', 170, 45, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa0fb4-4789-11f1-80af-48684ad9278a', '26eb9c78-4789-11f1-80af-48684ad9278a', 'BATCH015', '2026-07-30', '4.80', '9.00', 220, 60, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa2c47-4789-11f1-80af-48684ad9278a', '26eb9e53-4789-11f1-80af-48684ad9278a', 'BATCH016', '2027-03-03', '21.00', '28.00', 60, 20, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa4128-4789-11f1-80af-48684ad9278a', '26eb9e53-4789-11f1-80af-48684ad9278a', 'BATCH017', '2027-11-11', '8.80', '13.50', 175, 50, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa48dd-4789-11f1-80af-48684ad9278a', '26eb9e0e-4789-11f1-80af-48684ad9278a', 'BATCH018', '2026-06-15', '19.00', '26.00', 85, 30, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa4ea4-4789-11f1-80af-48684ad9278a', '26eba2ae-4789-11f1-80af-48684ad9278a', 'BATCH019', '2027-01-25', '17.00', '23.00', 125, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa52e6-4789-11f1-80af-48684ad9278a', '26eba019-4789-11f1-80af-48684ad9278a', 'BATCH020', '2026-09-29', '6.20', '10.50', 200, 55, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa5789-4789-11f1-80af-48684ad9278a', '26eb9c78-4789-11f1-80af-48684ad9278a', 'BATCH021', '2027-12-01', '12.80', '18.90', 140, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa5b97-4789-11f1-80af-48684ad9278a', '26eba278-4789-11f1-80af-48684ad9278a', 'BATCH022', '2027-04-04', '7.70', '12.30', 190, 50, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa5fe3-4789-11f1-80af-48684ad9278a', '26eb9e91-4789-11f1-80af-48684ad9278a', 'BATCH023', '2026-10-05', '9.90', '14.50', 100, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa644b-4789-11f1-80af-48684ad9278a', '26eba054-4789-11f1-80af-48684ad9278a', 'BATCH024', '2027-02-02', '11.50', '16.80', 130, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa6880-4789-11f1-80af-48684ad9278a', '26eba3f3-4789-11f1-80af-48684ad9278a', 'BATCH025', '2027-05-20', '20.00', '27.00', 75, 25, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa6cf2-4789-11f1-80af-48684ad9278a', '26eba105-4789-11f1-80af-48684ad9278a', 'BATCH026', '2026-11-09', '14.20', '21.00', 160, 45, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa710f-4789-11f1-80af-48684ad9278a', '26eba105-4789-11f1-80af-48684ad9278a', 'BATCH027', '2027-06-12', '5.90', '10.20', 210, 60, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa751c-4789-11f1-80af-48684ad9278a', '26eba2ae-4789-11f1-80af-48684ad9278a', 'BATCH028', '2027-03-19', '18.60', '26.00', 120, 35, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa7945-4789-11f1-80af-48684ad9278a', '26eb9ecb-4789-11f1-80af-48684ad9278a', 'BATCH029', '2026-08-08', '16.40', '22.00', 95, 30, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26fa7d4b-4789-11f1-80af-48684ad9278a', '26eba159-4789-11f1-80af-48684ad9278a', 'BATCH030', '2027-09-21', '13.00', '19.50', 155, 40, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_02_10_064138_create_roles_table', 1),
(4, '2026_02_10_064356_create_otps_table', 1),
(5, '2026_02_10_081756_create_users_table', 1),
(6, '2026_02_10_081923_create_religion_master_table', 1),
(7, '2026_02_10_082713_create_sessions_table', 1),
(8, '2026_02_10_103541_create_organizations_table', 1),
(9, '2026_02_11_091042_create_institutions_table', 1),
(10, '2026_02_11_103445_create_modules_table', 1),
(11, '2026_02_11_131218_create_job_type_master_table', 1),
(12, '2026_02_11_131218_create_work_status_master_table', 1),
(13, '2026_02_12_114401_create_designation_master_table', 1),
(14, '2026_02_12_133848_create_blood_group_master_table', 1),
(15, '2026_02_12_134100_create_department_master_table', 1),
(16, '2026_02_13_105118_create_institution_module_table', 1),
(17, '2026_02_16_093000_create_hospitals_table', 1),
(18, '2026_02_18_085214_create_financial_years_table', 1),
(19, '2026_02_18_124238_create_transactions_table', 1),
(20, '2026_02_19_085443_create_financial_year_hospital_table', 1),
(21, '2026_02_24_114849_create_weekends_table', 1),
(22, '2026_02_24_152717_create_holidays_table', 1),
(23, '2026_02_24_154834_create_wards_table', 1),
(24, '2026_02_25_100001_create_vendors_table', 1),
(25, '2026_02_25_100002_create_purchases_table', 1),
(26, '2026_02_25_100003_create_payments_table', 1),
(27, '2026_02_25_102534_create_beds_table', 1),
(28, '2026_02_25_121823_create_staff_table', 1),
(29, '2026_02_25_122401_create_items_table', 1),
(30, '2026_02_25_122708_create_patients_table', 1),
(31, '2026_02_25_131908_create_purchase_orders_table', 1),
(32, '2026_02_25_132111_create_purchase_order_items_table', 1),
(33, '2026_02_25_161019_create_medicines_table', 1),
(34, '2026_02_25_161322_create_medicine_batches_table', 1),
(35, '2026_02_25_161418_create_stock_movements_table', 1),
(36, '2026_02_25_162211_create_stock_transfers_table', 1),
(37, '2026_02_25_162249_create_stock_transfer_items_table', 1),
(38, '2026_02_25_165223_create_stock_audits_table', 1),
(39, '2026_02_26_021527_create_grns_table', 1),
(40, '2026_02_26_021533_create_grn_items_table', 1),
(41, '2026_02_26_232401_create_rooms_table', 1),
(42, '2026_02_27_133937_create_leave_types_table', 1),
(43, '2026_02_27_162925_create_personal_access_tokens_table', 1),
(44, '2026_03_02_120255_create_user_biometrics_table', 1),
(45, '2026_03_02_123138_create_controlled_drug_table', 1),
(46, '2026_03_02_123148_create_controlled_drug_dispense_table', 1),
(47, '2026_03_02_123154_create_controlled_drug_log_table', 1),
(48, '2026_03_02_133751_create_expiries_table', 1),
(49, '2026_03_02_133956_create_returns_table', 1),
(50, '2026_03_02_160106_create_leave_mappings_table', 1),
(51, '2026_03_02_162222_add_drugname_status_to_controlled_drug_table', 1),
(52, '2026_03_02_164103_create_attendances_table', 1),
(53, '2026_03_03_000000_change_category_to_string_in_items_table', 1),
(54, '2026_03_03_100626_create_geofences_table', 1),
(55, '2026_03_04_100001_create_inventory_vendors_table', 1),
(56, '2026_03_04_100002_add_inventory_vendor_id_to_tables', 1),
(57, '2026_03_04_150000_create_sales_bills_table', 1),
(58, '2026_03_05_151456_create_sales_returns_table', 1),
(59, '2026_03_05_151801_create_sales_bill_items_table', 1),
(60, '2026_03_05_155001_create_sales_return_items_table', 1),
(61, '2026_03_06_000002_create_appointments_table', 1),
(62, '2026_03_06_000004_create_opd_table', 1),
(63, '2026_03_06_094232_create_bed_allocations_table', 1),
(64, '2026_03_06_114702_create_leave_adjustments_table', 1),
(65, '2026_03_06_135915_create_tokens_table', 1),
(66, '2026_03_06_225135_create_biometric_imagess_table', 1),
(67, '2026_03_09_111733_create_surgeries_table', 1),
(68, '2026_03_09_113117_create_leave_applications_table', 1),
(69, '2026_03_09_114829_create_pre_operatives_table', 1),
(70, '2026_03_09_121211_create_ot_management_table', 1),
(71, '2026_03_09_122205_create_post_operatives_table', 1),
(72, '2026_03_09_132210_modify_doctor_id_in_appointments_table', 1),
(73, '2026_03_09_152213_create_shifts_table', 1),
(74, '2026_03_09_161506_create_shift_assignments_table', 1),
(75, '2026_03_09_192055_modify_appointments_replace_hospital_with_institution', 1),
(76, '2026_03_09_210540_modify_appointments_replace_hospital_with_institution', 1),
(77, '2026_03_10_120628_create_shift_rotations_table', 1),
(78, '2026_03_10_133925_create_leave__request__approvals_table', 1),
(79, '2026_03_10_144718_create_consultations_table', 1),
(80, '2026_03_10_154957_create_weekly_offs_table', 1),
(81, '2026_03_10_160257_create_consultation_medicines_table', 1),
(82, '2026_03_11_104449_add_referral_doctor_to_consultations_table', 1),
(83, '2026_03_11_123014_create_offline_prescriptions_table', 1),
(84, '2026_03_11_123027_create_offline_prescription_items_table', 1),
(85, '2026_03_11_124958_add_gender_employment_type_to_leave_mappings_table', 1),
(86, '2026_03_11_151432_create_lab_requests_table', 1),
(87, '2026_03_11_153248_add_deleted_at_to_shift_assignments_table', 1),
(88, '2026_03_11_160333_add_deleted_at_to_shift_rotations_table', 1),
(89, '2026_03_11_161658_add_deleted_at_to_weekly_offs_table', 1),
(90, '2026_03_11_163339_add_patient_to_sales_bills', 1),
(91, '2026_03_12_124942_create_vitals_table', 1),
(92, '2026_03_12_130015_create_prescription_status_table', 1),
(93, '2026_03_12_144232_create_comp_offs_table', 1),
(94, '2026_03_12_162013_rename_hospital_id_to_institution_id_in_vitals_table', 1),
(95, '2026_03_13_111311_create_nurse_notes', 1),
(96, '2026_03_13_144705_create_attendance_records_table', 1),
(97, '2026_03_13_203502_update_attendance_records_table', 1),
(98, '2026_03_16_102301_add_priority_to_lab_requests_table', 1),
(99, '2026_03_16_114743_create_lab_tests_table', 1),
(100, '2026_03_30_135140_create_medication_administration_table', 1),
(101, '2026_03_31_102925_update_supplier_id_in_controlled_drug_table', 1),
(102, '2026_03_31_104037_add_total_refund_and_status_to_sales_returns', 1),
(103, '2026_03_31_104803_remove_drug_id_from_controlled_drug_table', 1),
(104, '2026_03_31_111633_create_sample_collections_table', 1),
(105, '2026_03_31_120642_create_deductions_table', 1),
(106, '2026_03_31_124107_create_allowances_table', 1),
(107, '2026_04_01_115137_create_infection_control_logs_table', 1),
(108, '2026_04_01_115856_create_emergency_cases_table', 1),
(109, '2026_04_01_132704_add_columns_to_sales_bills', 1),
(110, '2026_04_01_142621_create_employee_documents_table', 1),
(111, '2026_04_01_203414_add_patient_name_to_sales_bills_table', 1),
(112, '2026_04_01_203640_create_hourly_pays_table', 1),
(113, '2026_04_01_213246_create_equipment_table', 1),
(114, '2026_04_01_233913_create_equipment_maintenance_table', 1),
(115, '2026_04_02_005652_create_equipment_calibrations_table', 1),
(116, '2026_04_02_095917_add_unique_sample_id', 1),
(117, '2026_04_02_102436_create_equipment_breakdowns_table', 1),
(118, '2026_04_02_110030_create_isolation_records_table', 1),
(119, '2026_04_02_111208_create_preventive_maintenance_table', 1),
(120, '2026_04_02_120854_create_ppe_compliance_logs_table', 1),
(121, '2026_04_02_143354_create_lab_reports_table', 1),
(122, '2026_04_05_115345_add_payslip_label_and_status_to_hourly_pays', 1),
(123, '2026_04_06_112945_create_hourly_pay_approvals_table', 1),
(124, '2026_04_06_114212_add_fields_to_hourly_pay_approvals_table', 1),
(125, '2026_04_06_125808_create_parameters_table', 1),
(126, '2026_04_06_125908_create_test_parameters_table', 1),
(127, '2026_04_07_100915_create_scan_types_table', 1),
(128, '2026_04_07_103207_create_scan_requests_table', 1),
(129, '2026_04_07_112430_create_deduction_rule_sets_table', 1),
(130, '2026_04_07_114824_create_scan_uploads_table', 1),
(131, '2026_04_07_120527_create_report_files_table', 1),
(132, '2026_04_07_120645_create_file_audit_logs_table', 1),
(133, '2026_04_07_123808_create_radiology_reports_table', 1),
(134, '2026_04_07_165052_create_scan_schedules_table', 1),
(135, '2026_04_08_111500_create_nurse_shift_handover_table', 1),
(136, '2026_04_08_115238_create_ipd_admissions_table', 1),
(137, '2026_04_08_115638_create_ipd_payments_table', 1),
(138, '2026_04_10_113546_create_report_logs_table', 1),
(139, '2026_04_10_114999_create_statutory_deductions_table', 1),
(140, '2026_04_10_115400_update_file_audit_logs_table', 1),
(141, '2026_04_10_152958_create_patient_insurances_table', 1),
(142, '2026_04_10_153032_create_insurance_documents_table', 1),
(143, '2026_04_10_161943_alter_created_by_column', 1),
(144, '2026_04_10_162418_change_id_to_uuid_in_insurance_documents', 1),
(145, '2026_04_10_163524_change_patient_id_to_uuid_in_patient_insurances', 1),
(146, '2026_04_10_203521_create_statutory_contributions_table', 1),
(147, '2026_04_14_095903_create_critical_value_alerts_table', 1),
(148, '2026_04_14_111817_create_salary_structures_table', 1),
(149, '2026_04_14_115316_create_receptionist_billing_table', 1),
(150, '2026_04_14_142429_add_acknowledged_by_to_critical_value_alerts', 1),
(151, '2026_04_14_143024_create_alert_audit_logs_table', 1),
(152, '2026_04_14_145210_create_notifications_table', 1),
(153, '2026_04_14_170354_add_updated_at_to_notifications', 1),
(154, '2026_04_16_155710_create_patient_medical_flags_table', 1),
(155, '2026_04_17_085651_fix_appointments_table', 1),
(156, '2026_04_17_092515_make_institution_id_nullable_in_appointments', 1),
(157, '2026_04_17_112448_create_employee_salary_assignments_table', 1),
(158, '2026_04_17_122552_create_rate_employee_mappings_table', 1),
(159, '2026_04_21_144812_create_pre_payroll_adjustments_table', 1),
(160, '2026_04_25_140125_create_payroll_results_table', 1),
(161, '2026_04_27_114349_create_payroll_result_earnings_table', 1),
(162, '2026_04_29_121331_create_payroll_result_deductions_table', 1),
(163, '2026_04_10_175000_add_verification_fields_to_lab_reports', 2),
(164, '2026_04_13_080835_create_discharge_preparations_table', 2),
(165, '2026_04_23_151628_create_ipd_notes_table', 2),
(166, '2026_04_23_151647_create_ipd_prescriptions_table', 2),
(167, '2026_04_23_151655_create_ipd_prescription_items_table', 2),
(168, '2026_04_23_151704_create_ipd_discharges_table', 2),
(169, '2026_04_23_152546_create_ipd_treatments_table', 2),
(170, '2026_04_27_152222_create_pharmacy_ipd_dispense_table', 2),
(171, '2026_04_27_154853_create_ipd_bills_table', 2),
(172, '2026_04_27_154854_create_ipd_bill_items_table', 2),
(173, '2026_04_27_161642_add_status_to_ipd_prescriptions', 2),
(174, '2026_05_01_024213_alter_ipd_bills_table_add_fields', 2),
(175, '2026_05_01_024215_alter_ipd_bill_items_table_add_fields', 2),
(176, '2026_05_04_120311_create_accountant_payments_table', 2),
(177, '2026_04_30_203027_create_surgery_consents_table', 3),
(178, '2026_05_01_092522_create_data_usage_consents_table', 3),
(179, '2026_05_11_130458_add_salary_columns_to_pre_payroll_adjustments_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` char(36) NOT NULL,
  `module_label` varchar(255) NOT NULL,
  `module_display_name` varchar(255) NOT NULL,
  `parent_module` char(36) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `access_for` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_label`, `module_display_name`, `parent_module`, `priority`, `icon`, `file_url`, `page_name`, `type`, `access_for`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
('26b42983-4789-11f1-80af-48684ad9278a', 'dashboard', 'Dashboard', NULL, 1, 'feather-activity', '/admin/dashboard', 'Dashboard', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b44271-4789-11f1-80af-48684ad9278a', 'access_control', 'Access Control', NULL, 2, 'feather-lock', '/admin/access-control', 'AccessControl', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b444a8-4789-11f1-80af-48684ad9278a', 'users', 'Users', NULL, 3, 'feather-users', '/admin/users', 'Users', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b4452a-4789-11f1-80af-48684ad9278a', 'roles', 'Roles & Permissions', NULL, 4, 'feather-shield', '/admin/roles', 'Roles', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b445a8-4789-11f1-80af-48684ad9278a', 'organization', 'Organization', NULL, 5, 'feather-briefcase', '/admin/organization', 'Organization', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b445fe-4789-11f1-80af-48684ad9278a', 'hospitals', 'Hospitals', NULL, 6, 'feather-home', '/admin/hospitals', 'Hospitals', 'admin', 'both', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b446e0-4789-11f1-80af-48684ad9278a', 'institutions', 'Institutions', NULL, 7, 'feather-aperture', '/admin/institutions', 'Institutions', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b44861-4789-11f1-80af-48684ad9278a', 'departments', 'Departments', NULL, 8, 'feather-grid', '/admin/departments', 'Departments', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b44dc3-4789-11f1-80af-48684ad9278a', 'staff', 'Staff Management', NULL, 9, 'feather-user-check', '/hr/staff-management', 'StaffManagement', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b44ebd-4789-11f1-80af-48684ad9278a', 'patients', 'Patient Management', NULL, 10, 'feather-users', '/admin/patients', 'Patients', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b44f85-4789-11f1-80af-48684ad9278a', 'inventory', 'Inventory', NULL, 11, 'feather-package', '/admin/inventory', 'Inventory', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b4504f-4789-11f1-80af-48684ad9278a', 'pharmacy', 'Pharmacy', NULL, 12, 'feather-shopping-bag', '/admin/pharmacy', 'Pharmacy', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL),
('26b45121-4789-11f1-80af-48684ad9278a', 'leave_mgmt', 'Leave Management', NULL, 13, 'feather-clock', '/admin/leave-mappings', 'LeaveManagement', 'admin', 'web', 1, NULL, '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurse_notes`
--

CREATE TABLE `nurse_notes` (
  `id` char(36) NOT NULL,
  `institution_id` char(36) DEFAULT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `shift` enum('Morning','Evening','Night') NOT NULL,
  `patient_condition` text DEFAULT NULL,
  `intake_details` text DEFAULT NULL,
  `output_details` text DEFAULT NULL,
  `wound_care_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurse_shift_handover`
--

CREATE TABLE `nurse_shift_handover` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` char(36) DEFAULT NULL,
  `nurse_id` char(36) NOT NULL,
  `shift_assignment_id` bigint(20) UNSIGNED NOT NULL,
  `entry_type` enum('note','task') NOT NULL DEFAULT 'note',
  `description` text NOT NULL,
  `task_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_prescriptions`
--

CREATE TABLE `offline_prescriptions` (
  `id` char(36) NOT NULL,
  `prescription_number` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_phone` varchar(255) DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `prescription_date` date NOT NULL,
  `uploaded_prescription` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Verified','Dispensed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_prescription_items`
--

CREATE TABLE `offline_prescription_items` (
  `id` char(36) NOT NULL,
  `offline_prescription_id` char(36) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opd`
--

CREATE TABLE `opd` (
  `id` char(36) NOT NULL,
  `appointment_id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `doctor_id` char(36) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `organization_url` varchar(255) DEFAULT NULL,
  `software_url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'English',
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_mobile` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `mou_copy` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `po_start_date` date DEFAULT NULL,
  `po_end_date` date DEFAULT NULL,
  `plan_type` varchar(255) DEFAULT NULL,
  `enabled_modules` text DEFAULT NULL,
  `invoice_type` varchar(255) DEFAULT NULL,
  `invoice_frequency` varchar(255) DEFAULT NULL,
  `invoice_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `poc_name` varchar(255) DEFAULT NULL,
  `poc_email` varchar(255) DEFAULT NULL,
  `poc_contact` varchar(255) DEFAULT NULL,
  `support_sla` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `type`, `registration_number`, `gst`, `address`, `city`, `state`, `country`, `pincode`, `contact_number`, `email`, `timezone`, `organization_url`, `software_url`, `logo`, `language`, `admin_name`, `admin_email`, `admin_mobile`, `status`, `mou_copy`, `po_number`, `po_start_date`, `po_end_date`, `plan_type`, `enabled_modules`, `invoice_type`, `invoice_frequency`, `invoice_amount`, `payment_status`, `payment_date`, `transaction_reference`, `poc_name`, `poc_email`, `poc_contact`, `support_sla`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26a0f3e3-4789-11f1-80af-48684ad9278a', 'Demo Health Group', 'Healthcare Group', 'REG-001', 'GST-001', NULL, 'Mangalore', 'Karnataka', 'India', '575001', '9876543210', 'info@demohealth.com', 'Asia/Kolkata', NULL, NULL, NULL, 'English', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-04 07:16:20', '2026-05-04 07:16:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` char(36) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` int(11) NOT NULL DEFAULT 0,
  `resends` int(11) NOT NULL DEFAULT 0,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `last_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `mobile`, `otp`, `expires_at`, `attempts`, `resends`, `used`, `last_sent_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
('19d7ca2a-e5d1-4838-a671-6a8aefa4d621', '9000000003', '$2y$12$9GJcpjiSCDiDmOJuOmH9dO9/eVPkHo0k.VOXEAs6bBqPtSAPAG.Iy', '2026-05-09 04:49:27', 0, 0, 1, '2026-05-09 04:49:16', '2026-05-09 04:49:16', '2026-05-09 04:49:27', NULL),
('bc2232a1-ff29-4f1f-aff2-eb395a59b55d', '9000000002', '$2y$12$wJht5W3QpPYCIJEvGKPMMOA7F/ZKnUQmhu7jRq9Qx89Gr7uWAVXL.', '2026-05-04 10:36:48', 0, 1, 1, '2026-05-04 10:36:40', '2026-05-04 10:36:17', '2026-05-04 10:36:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ot_management`
--

CREATE TABLE `ot_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surgery_id` char(36) NOT NULL,
  `ot_room_used` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `equipment_used` varchar(255) DEFAULT NULL,
  `approval_status` enum('Approved','Not Approved') NOT NULL DEFAULT 'Not Approved',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `min_value` double DEFAULT NULL,
  `max_value` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` char(36) NOT NULL,
  `patient_code` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `merged_to` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `updated_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_code`, `first_name`, `last_name`, `gender`, `date_of_birth`, `mobile`, `email`, `blood_group`, `address`, `emergency_contact`, `is_vip`, `status`, `merged_to`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26e2b3b2-4789-11f1-80af-48684ad9278a', 'PAT001', 'Rahul', 'Sharma', 'Male', '1990-05-10', '9876543210', 'rahul@example.com', 'B+', 'Delhi', '9876500001', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2cca9-4789-11f1-80af-48684ad9278a', 'PAT002', 'Anita', 'Verma', 'Female', '1988-03-22', '9876543211', 'anita@example.com', 'O+', 'Mumbai', '9876500002', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2cdf6-4789-11f1-80af-48684ad9278a', 'PAT003', 'Ravi', 'Kumar', 'Male', '1995-11-15', '9876543212', 'ravi@example.com', 'A+', 'Bangalore', '9876500003', 1, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2ce73-4789-11f1-80af-48684ad9278a', 'PAT004', 'Sneha', 'Nair', 'Female', '1992-07-08', '9876543213', 'sneha@example.com', 'AB+', 'Kochi', '9876500004', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2cee8-4789-11f1-80af-48684ad9278a', 'PAT005', 'Arjun', 'Reddy', 'Male', '1987-01-19', '9876543214', 'arjun@example.com', 'O-', 'Hyderabad', '9876500005', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2cf58-4789-11f1-80af-48684ad9278a', 'PAT006', 'Meera', 'Joshi', 'Female', '1993-06-30', '9876543215', 'meera@example.com', 'A-', 'Pune', '9876500006', 1, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2cfc6-4789-11f1-80af-48684ad9278a', 'PAT007', 'Kiran', 'Patel', 'Male', '1985-09-14', '9876543216', 'kiran@example.com', 'B-', 'Ahmedabad', '9876500007', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d031-4789-11f1-80af-48684ad9278a', 'PAT008', 'Lakshmi', 'Iyer', 'Female', '1991-12-02', '9876543217', 'lakshmi@example.com', 'O+', 'Chennai', '9876500008', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d09d-4789-11f1-80af-48684ad9278a', 'PAT009', 'Vikram', 'Singh', 'Male', '1989-04-11', '9876543218', 'vikram@example.com', 'B+', 'Jaipur', '9876500009', 1, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d0ff-4789-11f1-80af-48684ad9278a', 'PAT010', 'Pooja', 'Kapoor', 'Female', '1996-08-21', '9876543219', 'pooja@example.com', 'AB-', 'Chandigarh', '9876500010', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d166-4789-11f1-80af-48684ad9278a', 'PAT011', 'Suresh', 'Menon', 'Male', '1978-10-05', '9876543220', 'suresh@example.com', 'A+', 'Trivandrum', '9876500011', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d1c0-4789-11f1-80af-48684ad9278a', 'PAT012', 'Divya', 'Shetty', 'Female', '1994-02-17', '9876543221', 'divya@example.com', 'O-', 'Mangalore', '9876500012', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d21b-4789-11f1-80af-48684ad9278a', 'PAT013', 'Manoj', 'Das', 'Male', '1983-05-28', '9876543222', 'manoj@example.com', 'B+', 'Kolkata', '9876500013', 1, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d278-4789-11f1-80af-48684ad9278a', 'PAT014', 'Neha', 'Agarwal', 'Female', '1997-07-13', '9876543223', 'neha@example.com', 'A+', 'Lucknow', '9876500014', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d2d2-4789-11f1-80af-48684ad9278a', 'PAT015', 'Aditya', 'Gupta', 'Male', '1986-11-09', '9876543224', 'aditya@example.com', 'O+', 'Kanpur', '9876500015', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d332-4789-11f1-80af-48684ad9278a', 'PAT016', 'Ritu', 'Malhotra', 'Female', '1990-03-03', '9876543225', 'ritu@example.com', 'B-', 'Delhi', '9876500016', 1, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d38d-4789-11f1-80af-48684ad9278a', 'PAT017', 'Naveen', 'Bhat', 'Male', '1982-06-18', '9876543226', 'naveen@example.com', 'AB+', 'Udupi', '9876500017', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d427-4789-11f1-80af-48684ad9278a', 'PAT018', 'Priya', 'Kulkarni', 'Female', '1995-09-27', '9876543227', 'priya@example.com', 'A-', 'Nagpur', '9876500018', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d485-4789-11f1-80af-48684ad9278a', 'PAT019', 'Deepak', 'Yadav', 'Male', '1984-12-25', '9876543228', 'deepak@example.com', 'O+', 'Patna', '9876500019', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26e2d4dc-4789-11f1-80af-48684ad9278a', 'PAT020', 'Kavya', 'Rao', 'Female', '1998-01-14', '9876543229', 'kavya@example.com', 'B+', 'Mysore', '9876500020', 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('2749834c-4789-11f1-80af-48684ad9278a', 'PAT-001', 'Jane', 'Doe', 'Female', '1995-08-15', '8888888888', 'jane.doe@example.com', 'A+', 'Beach Road, Mangalore', NULL, 0, 1, NULL, NULL, NULL, '2026-05-04 07:16:22', '2026-05-04 07:16:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_insurances`
--

CREATE TABLE `patient_insurances` (
  `id` char(36) NOT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `insurance_type` varchar(255) DEFAULT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `policy_number` varchar(255) DEFAULT NULL,
  `policy_holder_name` varchar(255) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `sum_insured` decimal(12,2) DEFAULT NULL,
  `tpa_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_medical_flags`
--

CREATE TABLE `patient_medical_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` char(36) NOT NULL,
  `type` enum('allergy','chronic') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `severity` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` char(36) NOT NULL,
  `vendor_id` char(36) NOT NULL,
  `inventory_vendor_id` char(36) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `payment_status` enum('Paid','Pending') NOT NULL DEFAULT 'Pending',
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_results`
--

CREATE TABLE `payroll_results` (
  `id` char(36) NOT NULL,
  `payroll_run_id` varchar(50) NOT NULL,
  `staff_id` char(36) NOT NULL,
  `payroll_month` varchar(20) NOT NULL,
  `financial_year` varchar(20) NOT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `salary_assignment_id` varchar(50) NOT NULL,
  `salary_structure_code` varchar(50) NOT NULL,
  `working_days` int(11) NOT NULL,
  `paid_days` int(11) NOT NULL,
  `lop_days` int(11) NOT NULL,
  `overtime_hours` decimal(5,2) DEFAULT NULL,
  `fixed_earnings_total` decimal(10,2) NOT NULL,
  `variable_earnings_total` decimal(10,2) DEFAULT NULL,
  `gross_earnings` decimal(10,2) NOT NULL,
  `fixed_deductions_total` decimal(10,2) NOT NULL,
  `variable_deductions_total` decimal(10,2) DEFAULT NULL,
  `pf_employee` decimal(10,2) DEFAULT NULL,
  `esi_employee` decimal(10,2) DEFAULT NULL,
  `professional_tax` decimal(10,2) DEFAULT NULL,
  `tds_amount` decimal(10,2) DEFAULT NULL,
  `total_deductions` decimal(10,2) NOT NULL,
  `net_payable` decimal(10,2) NOT NULL,
  `status` enum('Locked','Reversed') NOT NULL,
  `locked_on` datetime NOT NULL,
  `locked_by` char(36) NOT NULL,
  `created_on` datetime NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_results`
--

INSERT INTO `payroll_results` (`id`, `payroll_run_id`, `staff_id`, `payroll_month`, `financial_year`, `academic_year`, `salary_assignment_id`, `salary_structure_code`, `working_days`, `paid_days`, `lop_days`, `overtime_hours`, `fixed_earnings_total`, `variable_earnings_total`, `gross_earnings`, `fixed_deductions_total`, `variable_deductions_total`, `pf_employee`, `esi_employee`, `professional_tax`, `tds_amount`, `total_deductions`, `net_payable`, `status`, `locked_on`, `locked_by`, `created_on`, `remarks`) VALUES
('18604cfb-63e4-459a-8b42-8234b271388d', 'RUN-202605', '5', '2026-03', 'FY 2026-27', NULL, 'e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', 'c5b3036a-853b-4c0e-984f-1b7581076bc5', 30, 28, 2, '5.00', '30000.00', '2000.00', '32000.00', '1999.00', '500.00', '1800.00', '500.00', '200.00', '1000.00', '2499.00', '29501.00', 'Locked', '2026-05-04 16:08:17', '26ccb475-4789-11f1-80af-48684ad9278a', '2026-05-04 16:08:17', 'Generated from Pre Payroll'),
('31497a5c-716c-42c2-8006-a748ae82055e', 'RUN-202605', '2', '2026-06', 'FY 2026-27', NULL, '265481ac-6944-430d-a0ee-458f05a70dc3', '7afb1947-cf14-4dda-a322-d6fef0aa313b', 30, 20, 2, '3.00', '20000.00', '10000.00', '30000.00', '0.00', '1000.00', '500.00', '1000.00', '1000.00', '500.00', '4000.00', '26000.00', 'Locked', '2026-05-11 12:37:36', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-11 12:37:36', 'Generated from Pre Payroll'),
('5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'RUN-202605', '8', '2026-11', 'FY 2026-27', NULL, '265481ac-6944-430d-a0ee-458f05a70dc3', '7afb1947-cf14-4dda-a322-d6fef0aa313b', 30, 20, 2, '5.00', '20000.00', '2000.00', '22000.00', '1000.00', '1000.00', '200.00', '100.00', '100.00', '1000.00', '3400.00', '17148.00', 'Locked', '2026-05-11 13:18:45', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-11 13:18:45', 'Generated from Pre Payroll'),
('a17bd684-934a-4e88-938f-d1755ea2acbf', 'RUN-202605', '4', '2026-05', 'FY 2026-27', NULL, '28ce9732-c617-471e-9dec-6804a36f377c', '2f47aa7a-81b6-4eab-8b2c-8a92652151ec', 30, 26, 4, '8.00', '30000.00', '3000.00', '33000.00', '2500.00', '800.00', '1100.00', '600.00', '200.00', '12000.00', '3300.00', '29700.00', 'Locked', '2026-05-04 16:00:15', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-04 16:00:15', 'Generated from Pre Payroll'),
('d334ec04-bd4a-4db9-b2e3-3a573f2e4897', 'RUN-202605', '7', '2026-05', 'FY 2026-27', NULL, 'e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', 'c5b3036a-853b-4c0e-984f-1b7581076bc5', 30, 20, 2, '5.00', '50000.00', '20000.00', '70000.00', '0.00', '0.00', NULL, NULL, NULL, NULL, '0.00', '65333.33', 'Locked', '2026-05-11 16:36:24', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 16:36:24', 'Generated from Pre Payroll');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_result_deductions`
--

CREATE TABLE `payroll_result_deductions` (
  `id` char(36) NOT NULL,
  `payroll_result_id` char(36) NOT NULL,
  `deduction_code` varchar(255) NOT NULL,
  `deduction_name` varchar(255) NOT NULL,
  `deduction_type` enum('Fixed','Variable','Statutory') NOT NULL,
  `rule_set_code` varchar(255) DEFAULT NULL,
  `calculation_base` enum('Gross') DEFAULT NULL,
  `calculation_logic` enum('%','Slab','EMI') DEFAULT NULL,
  `calculation_value` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `editable_flag` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_result_deductions`
--

INSERT INTO `payroll_result_deductions` (`id`, `payroll_result_id`, `deduction_code`, `deduction_name`, `deduction_type`, `rule_set_code`, `calculation_base`, `calculation_logic`, `calculation_value`, `amount`, `editable_flag`, `display_order`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('019df294-5e07-73ef-a3b3-731a8dacbfec', 'a17bd684-934a-4e88-938f-d1755ea2acbf', 'DR01', 'PF dummy', 'Variable', NULL, 'Gross', '%', '20000.00', '6600000.00', 1, 1, '26ccb475-4789-11f1-80af-48684ad9278a', '2026-05-04 10:41:42', '2026-05-04 14:30:55', '2026-05-04 14:30:55'),
('019df365-0a5c-70cf-9e11-5547bca8b0a4', '18604cfb-63e4-459a-8b42-8234b271388d', 'DR014', 'PF dummy2', 'Variable', 'ESI_RULE_001', 'Gross', '%', '20.00', '6400.00', 1, 1, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-04 14:29:38', '2026-05-04 18:52:36', NULL),
('019df44e-1660-71d3-a2b6-d0d9a837c511', '18604cfb-63e4-459a-8b42-8234b271388d', 'Dumy app', 'Hehe.', 'Variable', NULL, 'Gross', '%', '20.00', '6400.00', 1, 100, NULL, '2026-05-04 18:44:11', '2026-05-04 18:44:55', '2026-05-04 18:44:55'),
('019df456-af77-715c-94c1-7a049563a368', 'a17bd684-934a-4e88-938f-d1755ea2acbf', 'Dummy', 'Dummy', 'Variable', 'PF_RULE_001', 'Gross', '%', '20.00', '6600.00', 1, 100, NULL, '2026-05-04 18:53:34', '2026-05-04 18:53:34', NULL),
('019df45d-5d12-7045-817e-95b1d38ba515', '18604cfb-63e4-459a-8b42-8234b271388d', 'Vtycc', 'Cytctc', 'Fixed', NULL, NULL, NULL, NULL, '822882.00', 1, 2820, NULL, '2026-05-04 19:00:52', '2026-05-04 19:20:56', '2026-05-04 19:20:56'),
('019df470-461f-73c6-83de-301ef7d45bf1', '18604cfb-63e4-459a-8b42-8234b271388d', 'Heyyyy', 'Hwruuca', 'Variable', 'ESI_RULE_001', 'Gross', 'EMI', '20.00', '20.00', 1, 86, NULL, '2026-05-04 19:21:31', '2026-05-05 05:35:56', '2026-05-05 05:35:56'),
('019df69e-e008-73f5-a920-48fac2dceda6', '18604cfb-63e4-459a-8b42-8234b271388d', 'DR018988', 'PF dummyyyyy', 'Statutory', 'ESI_RULE_001', 'Gross', 'EMI', '20.00', '20.00', 1, 88, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-05 05:31:40', '2026-05-05 05:33:24', NULL),
('019e16b8-40ed-701b-b618-e64bc1b66493', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'PF', 'Provident Fund (Employee)', 'Statutory', NULL, 'Gross', '%', '12.00', '200.00', 0, 1, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:07:14', '2026-05-11 11:07:14', NULL),
('019e16b8-40f9-715c-938e-a4c38a6a4c26', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'ESI', 'ESI (Employee)', 'Statutory', NULL, 'Gross', '%', '0.75', '100.00', 0, 2, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:07:14', '2026-05-11 11:07:14', NULL),
('019e16b8-40fc-7044-bc84-66122c705707', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'PT', 'Professional Tax', 'Statutory', NULL, 'Gross', 'Slab', NULL, '100.00', 0, 3, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:07:14', '2026-05-11 11:07:14', NULL),
('019e16b8-4100-73a7-b6cd-0e845ab44018', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'TDS', 'TDS', 'Statutory', NULL, 'Gross', '%', NULL, '1000.00', 0, 4, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:07:14', '2026-05-11 11:07:14', NULL),
('019e16b8-4103-71be-bc3f-4caff1787e69', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'EMI', 'EMI / Loan Deduction', 'Fixed', NULL, NULL, 'EMI', NULL, '2000.00', 1, 5, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:07:14', '2026-05-11 11:07:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_result_earnings`
--

CREATE TABLE `payroll_result_earnings` (
  `id` char(36) NOT NULL,
  `payroll_result_id` char(36) NOT NULL,
  `earning_code` varchar(255) NOT NULL,
  `earning_name` varchar(255) NOT NULL,
  `earning_type` enum('Fixed','Variable','OT') NOT NULL,
  `calculation_base` varchar(255) DEFAULT NULL,
  `calculation_value` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `taxable` tinyint(1) NOT NULL DEFAULT 1,
  `pf_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `esi_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_result_earnings`
--

INSERT INTO `payroll_result_earnings` (`id`, `payroll_result_id`, `earning_code`, `earning_name`, `earning_type`, `calculation_base`, `calculation_value`, `amount`, `taxable`, `pf_applicable`, `esi_applicable`, `display_order`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('019df28e-9277-71f2-a934-1b61499826b8', 'a17bd684-934a-4e88-938f-d1755ea2acbf', 'BASIC_01', 'Basic Salary', 'Fixed', NULL, NULL, '24999.99', 1, 0, 0, 1, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-04 10:35:23', '2026-05-04 10:35:23', NULL),
('019df2a7-09c0-7033-b4e1-f6e6990107d8', '18604cfb-63e4-459a-8b42-8234b271388d', 'BASIC_01', 'Basic Salary', 'Variable', 'gross', '2', '640.00', 1, 0, 0, NULL, '26ccb475-4789-11f1-80af-48684ad9278a', '2026-05-04 11:02:06', '2026-05-04 11:02:06', NULL),
('019df361-a787-73c1-bd72-a08d63003fed', '18604cfb-63e4-459a-8b42-8234b271388d', 'BASIC_06', 'Basic Salary test', 'Variable', 'basic', '2', '600.00', 1, 0, 0, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-04 14:25:56', '2026-05-04 14:25:56', NULL),
('019df417-784e-702b-9a37-5a98580272de', 'a17bd684-934a-4e88-938f-d1755ea2acbf', 'Dummy', 'App', 'Variable', 'basic', '2', '600.00', 1, 1, 1, 20, NULL, '2026-05-04 17:44:32', '2026-05-04 17:44:32', NULL),
('019df41d-517d-72e0-b05b-a76597d776be', '18604cfb-63e4-459a-8b42-8234b271388d', 'Dummy2', 'E', 'Fixed', NULL, NULL, '26999.00', 1, 1, 1, 100, NULL, '2026-05-04 17:50:55', '2026-05-04 17:50:55', NULL),
('019df41f-6253-70a8-a065-33b2be409fd9', '18604cfb-63e4-459a-8b42-8234b271388d', 'newwww', 'Dtysydyd', 'Fixed', NULL, NULL, '500055.00', 0, 0, 0, 100, NULL, '2026-05-04 17:53:10', '2026-05-04 18:27:27', NULL),
('019df461-99a2-73d9-83b4-c075f5e73429', '18604cfb-63e4-459a-8b42-8234b271388d', 'Dummyy 6', 'Earn', 'Variable', 'basic', '25', '7500.00', 1, 1, 1, 52, NULL, '2026-05-04 19:05:30', '2026-05-04 19:05:30', NULL),
('019df46f-804f-73cf-9202-759bfacf918e', '18604cfb-63e4-459a-8b42-8234b271388d', 'Hehehehe', 'Hehehe', 'Variable', 'gross', '86', '27520.00', 1, 1, 1, 589, NULL, '2026-05-04 19:20:41', '2026-05-04 19:20:41', NULL),
('019df69d-9673-71fa-a380-1456f6e6ddab', '18604cfb-63e4-459a-8b42-8234b271388d', 'BASIC_0198', 'Basic Salary', 'Fixed', NULL, NULL, '399899.99', 1, 1, 0, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-05 05:30:16', '2026-05-05 05:30:16', NULL),
('019e16b4-4db0-7144-8510-a998d3d2fca3', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'BASIC', 'Basic Salary', 'Fixed', 'Gross', '50%', '10000.00', 1, 1, 1, 1, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:02:55', '2026-05-11 11:02:55', NULL),
('019e16b4-4de3-7335-80b9-5b615337e91f', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'HRA', 'House Rent Allowance', 'Fixed', 'Gross', '20%', '4000.00', 1, 0, 0, 2, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:02:55', '2026-05-11 11:02:55', NULL),
('019e16b4-4de7-70fd-81d8-f493beed4dfa', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'DA', 'Dearness Allowance', 'Fixed', 'Gross', '10%', '2000.00', 1, 1, 1, 3, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:02:55', '2026-05-11 11:02:55', NULL),
('019e16b4-4deb-7172-b40f-4229aa4a06ef', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'SA', 'Special Allowance', 'Fixed', 'Remaining', NULL, '4000.00', 1, 0, 0, 4, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:02:55', '2026-05-11 11:02:55', NULL),
('019e16b4-4def-717e-9974-69e3b50a4b61', '5c3ebb1a-f811-44a1-a4f1-b9a2c73ec4e6', 'VAR', 'Variable Earnings', 'Variable', 'Gross', NULL, '2000.00', 1, 0, 0, 5, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:02:55', '2026-05-11 11:02:55', NULL),
('019e16b5-011f-7069-9155-aff1646372bf', '31497a5c-716c-42c2-8006-a748ae82055e', 'BASIC', 'Basic Salary', 'Fixed', 'Gross', '50%', '10000.00', 1, 1, 1, 1, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:03:41', '2026-05-11 11:03:41', NULL),
('019e16b5-012d-70ff-94c0-45992c30a713', '31497a5c-716c-42c2-8006-a748ae82055e', 'HRA', 'House Rent Allowance', 'Fixed', 'Gross', '20%', '4000.00', 1, 0, 0, 2, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:03:41', '2026-05-11 11:03:41', NULL),
('019e16b5-0131-7100-a6dc-6620e7c50a01', '31497a5c-716c-42c2-8006-a748ae82055e', 'DA', 'Dearness Allowance', 'Fixed', 'Gross', '10%', '2000.00', 1, 1, 1, 3, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:03:41', '2026-05-11 11:03:41', NULL),
('019e16b5-0135-73a0-ad57-31875e4ba601', '31497a5c-716c-42c2-8006-a748ae82055e', 'SA', 'Special Allowance', 'Fixed', 'Remaining', NULL, '4000.00', 1, 0, 0, 4, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:03:41', '2026-05-11 11:03:41', NULL),
('019e16b5-0139-7058-85e8-811cd73cb30b', '31497a5c-716c-42c2-8006-a748ae82055e', 'VAR', 'Variable Earnings', 'Variable', 'Gross', NULL, '10000.00', 1, 0, 0, 5, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:03:41', '2026-05-11 11:03:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` char(36) NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_ipd_dispense`
--

CREATE TABLE `pharmacy_ipd_dispense` (
  `id` char(36) NOT NULL,
  `prescription_id` char(36) NOT NULL,
  `patient_id` char(36) DEFAULT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `medicine_id` char(36) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `dispensed_quantity` int(11) NOT NULL DEFAULT 0,
  `batch_id` char(36) DEFAULT NULL,
  `dispensed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacy_ipd_dispense`
--

INSERT INTO `pharmacy_ipd_dispense` (`id`, `prescription_id`, `patient_id`, `medicine_name`, `medicine_id`, `quantity`, `dispensed_quantity`, `batch_id`, `dispensed_at`, `created_at`, `updated_at`) VALUES
('240987be-f6be-4e6f-8c9e-beaff659c500', '0af42542-2d1c-41ee-a65b-22e78d025d1a', '26e2cfc6-4789-11f1-80af-48684ad9278a', '', '26eb7ee9-4789-11f1-80af-48684ad9278a', 0, 3, NULL, '2026-05-05 11:03:12', '2026-05-05 11:03:12', '2026-05-05 11:03:12'),
('293c301f-4103-4c4d-b489-ca4aade19937', 'bdb44534-f199-4ad2-aaa2-4715ca2cb281', '26e2ce73-4789-11f1-80af-48684ad9278a', '', '26eb7ee9-4789-11f1-80af-48684ad9278a', 0, 3, NULL, '2026-05-07 05:36:06', '2026-05-07 05:36:06', '2026-05-07 05:36:06'),
('adda2c2e-9dc2-46e4-a35b-26695beab4a5', '18c1ce3c-690a-4170-906f-b3e96adcc7fd', '26e2cee8-4789-11f1-80af-48684ad9278a', '', '26eb9fac-4789-11f1-80af-48684ad9278a', 0, 10, NULL, '2026-05-08 06:09:43', '2026-05-08 06:09:43', '2026-05-08 06:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `post_operatives`
--

CREATE TABLE `post_operatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surgery_id` char(36) NOT NULL,
  `procedure_performed` text DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `blood_loss` varchar(255) DEFAULT NULL,
  `patient_condition` text DEFAULT NULL,
  `recovery_instructions` text DEFAULT NULL,
  `complication_type` varchar(255) DEFAULT NULL,
  `complication_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppe_compliance_logs`
--

CREATE TABLE `ppe_compliance_logs` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `ppe_used` tinyint(1) NOT NULL,
  `ppe_type` varchar(255) DEFAULT NULL,
  `compliance_status` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_status`
--

CREATE TABLE `prescription_status` (
  `id` char(36) NOT NULL,
  `consultation_id` char(36) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preventive_maintenance`
--

CREATE TABLE `preventive_maintenance` (
  `id` char(36) NOT NULL,
  `equipment_id` char(36) NOT NULL,
  `frequency` enum('Monthly','Quarterly','Yearly') NOT NULL,
  `next_maintenance_date` date NOT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operatives`
--

CREATE TABLE `pre_operatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surgery_id` char(36) NOT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `heart_rate` varchar(255) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `consent_obtained` tinyint(1) NOT NULL DEFAULT 0,
  `fasting_status` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `risk_factors` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_payroll_adjustments`
--

CREATE TABLE `pre_payroll_adjustments` (
  `id` char(36) NOT NULL,
  `pre_payroll_code` varchar(255) NOT NULL,
  `payroll_run_id` char(36) DEFAULT NULL,
  `payroll_month` varchar(255) NOT NULL,
  `employee_id` char(36) NOT NULL,
  `salary_assignment_id` char(36) NOT NULL,
  `pay_type` enum('Monthly','Hourly') NOT NULL,
  `working_days` int(11) NOT NULL,
  `days_paid` int(11) NOT NULL,
  `lop_days` decimal(5,2) DEFAULT NULL,
  `ot_hours` decimal(5,2) DEFAULT NULL,
  `fixed_earnings_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fixed_deductions_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pf_employee` decimal(10,2) DEFAULT NULL,
  `esi_employee` decimal(10,2) DEFAULT NULL,
  `professional_tax` decimal(10,2) DEFAULT NULL,
  `tds_amount` decimal(10,2) DEFAULT NULL,
  `adhoc_earnings` decimal(10,2) DEFAULT NULL,
  `earnings_remarks` text DEFAULT NULL,
  `adhoc_deductions` decimal(10,2) DEFAULT NULL,
  `deduction_remarks` text DEFAULT NULL,
  `gross_earnings` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_payable` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Draft','Submitted','Approved') NOT NULL DEFAULT 'Draft',
  `submitted_by` char(36) DEFAULT NULL,
  `approved_by` char(36) DEFAULT NULL,
  `approved_on` timestamp NULL DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `per_day_salary` decimal(10,2) DEFAULT NULL,
  `absence_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pre_payroll_adjustments`
--

INSERT INTO `pre_payroll_adjustments` (`id`, `pre_payroll_code`, `payroll_run_id`, `payroll_month`, `employee_id`, `salary_assignment_id`, `pay_type`, `working_days`, `days_paid`, `lop_days`, `ot_hours`, `fixed_earnings_total`, `fixed_deductions_total`, `pf_employee`, `esi_employee`, `professional_tax`, `tds_amount`, `adhoc_earnings`, `earnings_remarks`, `adhoc_deductions`, `deduction_remarks`, `gross_earnings`, `total_deductions`, `net_payable`, `status`, `submitted_by`, `approved_by`, `approved_on`, `created_by`, `deleted_at`, `created_at`, `updated_at`, `per_day_salary`, `absence_amount`) VALUES
('6beedad9-1bd3-481f-bed3-99598c8f5ed7', 'PPR_9121', NULL, '2026-11', '8', '265481ac-6944-430d-a0ee-458f05a70dc3', 'Monthly', 30, 20, '1.98', '5.00', '20000.00', '1000.00', '200.00', '100.00', '100.00', '1000.00', '2000.00', NULL, '1000.00', NULL, '22000.00', '3400.00', '17148.00', 'Approved', '26ccb79a-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-11 07:48:01', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, '2026-05-11 07:47:45', '2026-05-11 07:48:01', '733.33', '1452.00'),
('7fcdd681-e433-41c6-bfc1-6c0b40a28cd8', 'PPR_3788', NULL, '2026-05', '4', '28ce9732-c617-471e-9dec-6804a36f377c', 'Monthly', 30, 26, '4.00', '8.00', '30000.00', '2500.00', '1100.00', '600.00', '200.00', '12000.00', '3000.00', 'Performance bonus', '800.00', 'loan recovery', '33000.00', '3300.00', '29700.00', 'Approved', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-04 10:28:36', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-04 10:26:40', '2026-05-04 10:28:36', NULL, NULL),
('87803c73-d32b-4328-bdad-3b2bfb90b519', 'PPR_7460', NULL, '2026-05', '7', 'e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', 'Monthly', 30, 20, '2.00', '5.00', '50000.00', '0.00', NULL, NULL, NULL, NULL, '20000.00', NULL, '0.00', NULL, '70000.00', '0.00', '65333.33', 'Approved', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', '2026-05-11 11:05:56', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-11 11:05:47', '2026-05-11 11:05:56', '2333.33', '4666.67'),
('abc6c1f5-0027-44c5-a83b-687987c02c1a', 'PPR_5459', NULL, '2026-06', '2', '265481ac-6944-430d-a0ee-458f05a70dc3', 'Monthly', 30, 20, '2.00', '3.00', '20000.00', '0.00', '500.00', '1000.00', '1000.00', '500.00', '10000.00', NULL, '1000.00', NULL, '30000.00', '4000.00', '26000.00', 'Approved', '26ccb79a-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', '2026-05-11 07:06:15', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, '2026-05-11 06:51:21', '2026-05-11 07:06:15', NULL, NULL),
('bb7e74da-f9a2-4227-bb40-b4d128f3be70', 'PPR_1211', NULL, '2026-03', '5', 'e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', 'Monthly', 30, 28, '2.00', '5.00', '30000.00', '1999.00', '1800.00', '500.00', '200.00', '1000.00', '2000.00', 'bonus', '500.00', 'late penalty', '32000.00', '2499.00', '29501.00', 'Approved', '26ccb475-4789-11f1-80af-48684ad9278a', '26ccb475-4789-11f1-80af-48684ad9278a', '2026-05-04 10:37:58', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-04 10:24:25', '2026-05-04 10:37:58', NULL, NULL),
('d9745c87-93d2-42a2-99a8-312a7f626d58', 'PPR_3329', NULL, '2026-05', '7', 'e7f309e6-ddce-46f6-a8aa-0ef33b9514e2', 'Monthly', 30, 20, '2.00', '4.99', '25000.00', '2000.00', '2100.00', '213.00', '200.00', '100.00', '3000.00', 'bonus', '1500.00', 'penalty', '28000.00', '3500.00', '24500.00', 'Submitted', 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, NULL, 'e8216c51-8119-4dd0-9817-d8ffb22a011c', NULL, '2026-05-08 17:09:03', '2026-05-08 17:09:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` char(36) NOT NULL,
  `vendor_id` char(36) NOT NULL,
  `inventory_vendor_id` char(36) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `vendor_id` char(36) DEFAULT NULL,
  `inventory_vendor_id` char(36) DEFAULT NULL,
  `order_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','approved','ordered','completed','cancelled') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radiology_reports`
--

CREATE TABLE `radiology_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scan_request_id` char(36) NOT NULL,
  `observations` text DEFAULT NULL,
  `findings` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `radiologist_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate_employee_mappings`
--

CREATE TABLE `rate_employee_mappings` (
  `id` char(36) NOT NULL,
  `rule_set_code` varchar(50) NOT NULL,
  `rule_set_name` varchar(100) NOT NULL,
  `work_type_code` varchar(50) NOT NULL,
  `rate_type` varchar(20) NOT NULL,
  `base_rate_source` varchar(50) NOT NULL,
  `base_rate_value` decimal(10,2) DEFAULT NULL,
  `multiplier_value` decimal(5,2) DEFAULT NULL,
  `maximum_hours` int(11) DEFAULT NULL,
  `round_off_rule` varchar(20) DEFAULT NULL,
  `employee_type` varchar(50) NOT NULL,
  `employee_id` char(36) DEFAULT NULL,
  `employee_category` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rate_employee_mappings`
--

INSERT INTO `rate_employee_mappings` (`id`, `rule_set_code`, `rule_set_name`, `work_type_code`, `rate_type`, `base_rate_source`, `base_rate_value`, `multiplier_value`, `maximum_hours`, `round_off_rule`, `employee_type`, `employee_id`, `employee_category`, `deleted_at`, `created_at`, `updated_at`) VALUES
('019df27d-17eb-703f-96e2-c25dc638cd14', 'PF_RULE_001', '12 percent Rule', 'HRL001', 'Flat', 'Employee Rate', '14.01', NULL, NULL, 'Nearest', 'Permanent', '1', 'Full Time', NULL, '2026-05-04 10:16:17', '2026-05-04 10:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist_billing`
--

CREATE TABLE `receptionist_billing` (
  `id` char(36) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `visit_id` char(36) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) NOT NULL DEFAULT 'CASH',
  `collected_by` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `religion_master`
--

CREATE TABLE `religion_master` (
  `id` char(36) NOT NULL,
  `religion_name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religion_master`
--

INSERT INTO `religion_master` (`id`, `religion_name`, `status`, `display_order`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26c0cf21-4789-11f1-80af-48684ad9278a', 'Hindu', 'Active', 1, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c0e469-4789-11f1-80af-48684ad9278a', 'Christian', 'Active', 2, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c0e56b-4789-11f1-80af-48684ad9278a', 'Muslim', 'Active', 3, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c0e5bd-4789-11f1-80af-48684ad9278a', 'Buddhist', 'Active', 4, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c0e609-4789-11f1-80af-48684ad9278a', 'Jain', 'Active', 5, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c0e65a-4789-11f1-80af-48684ad9278a', 'Other', 'Active', 6, 1, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_files`
--

CREATE TABLE `report_files` (
  `id` char(36) NOT NULL,
  `lab_report_id` char(36) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `uploaded_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_logs`
--

CREATE TABLE `report_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` char(36) NOT NULL,
  `action` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `return_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26c5895a-4789-11f1-80af-48684ad9278a', 'super_admin', 'Super administrator with full access', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59ad6-4789-11f1-80af-48684ad9278a', 'hr', 'Human resource', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59bb3-4789-11f1-80af-48684ad9278a', 'manager', 'Manager role', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59c1d-4789-11f1-80af-48684ad9278a', 'hod', 'Head of Department', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59c80-4789-11f1-80af-48684ad9278a', 'doctor', 'Doctor role', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59cef-4789-11f1-80af-48684ad9278a', 'nurse', 'Nurse role', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('26c59d69-4789-11f1-80af-48684ad9278a', 'receptionist', 'Reception / front desk', 'active', '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL),
('52b30ccf-8549-41f2-8fa6-491ebd04107f', 'admin', 'Super Administrator', 'active', '2026-05-04 07:14:48', '2026-05-04 07:14:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` char(36) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `ward_id` char(36) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `total_beds` int(11) NOT NULL DEFAULT 0,
  `status` enum('available','occupied','maintenance','cleaning') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `ward_id`, `room_type`, `total_beds`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('b37776b6-4870-11f1-aaf6-e7644015a707', '101', '95c93edf-4f92-4fa5-8e1f-e569399885b3', 'General', 2, 'available', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salary_structures`
--

CREATE TABLE `salary_structures` (
  `id` char(36) NOT NULL,
  `salary_structure_code` varchar(255) NOT NULL,
  `salary_structure_name` varchar(255) NOT NULL,
  `structure_category` enum('monthly','hourly') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `fixed_allowance_components` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`fixed_allowance_components`)),
  `variable_allowance_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `residual_component_id` varchar(255) NOT NULL,
  `hourly_pay_eligible` tinyint(1) NOT NULL DEFAULT 0,
  `overtime_eligible` tinyint(1) NOT NULL DEFAULT 0,
  `allowed_work_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_work_types`)),
  `fixed_deduction_components` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fixed_deduction_components`)),
  `variable_deduction_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `pf_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `esi_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `pt_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `tds_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `effective_from` date DEFAULT NULL,
  `effective_to` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_structures`
--

INSERT INTO `salary_structures` (`id`, `salary_structure_code`, `salary_structure_name`, `structure_category`, `status`, `fixed_allowance_components`, `variable_allowance_allowed`, `residual_component_id`, `hourly_pay_eligible`, `overtime_eligible`, `allowed_work_types`, `fixed_deduction_components`, `variable_deduction_allowed`, `pf_applicable`, `esi_applicable`, `pt_applicable`, `tds_applicable`, `effective_from`, `effective_to`, `deleted_at`, `created_at`, `updated_at`) VALUES
('2f47aa7a-81b6-4eab-8b2c-8a92652151ec', 'SAL_STR_002', 'Hourly worker structure', 'hourly', 'active', '[\"5e3559ff-18f0-46f9-95c6-d794069b4758\",\"6622c41f-82bf-41a1-858b-4759fa218800\"]', 1, '5e3559ff-18f0-46f9-95c6-d794069b4758', 1, 1, '[\"e097ff44-1c3c-4d84-aba6-acfbd2ae2cf8\"]', '[\"0f72a8f8-8348-477a-b40e-6ca946d35b09\",\"5f28f03e-375b-4909-b648-049095325db7\"]', 1, 0, 0, 0, 1, '2026-04-30', NULL, NULL, '2026-05-04 10:14:32', '2026-05-04 10:14:32'),
('c5b3036a-853b-4c0e-984f-1b7581076bc5', 'SAL_STR_001', 'Standard employee structure', 'monthly', 'active', '[\"5091ce48-f1db-452d-88f3-d545862200f1\",\"5e3559ff-18f0-46f9-95c6-d794069b4758\",\"6622c41f-82bf-41a1-858b-4759fa218800\"]', 1, '5091ce48-f1db-452d-88f3-d545862200f1', 1, 1, '[\"4fdee241-4393-4593-b022-4f6697307fcf\"]', '[\"0f72a8f8-8348-477a-b40e-6ca946d35b09\"]', 1, 1, 0, 1, 0, '2026-04-27', NULL, NULL, '2026-05-04 10:13:14', '2026-05-12 07:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `sales_bills`
--

CREATE TABLE `sales_bills` (
  `bill_id` char(36) NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_bill_items`
--

CREATE TABLE `sales_bill_items` (
  `id` char(36) NOT NULL,
  `sales_bill_id` char(36) NOT NULL,
  `medicine_id` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` char(36) NOT NULL,
  `return_number` varchar(255) NOT NULL,
  `bill_id` char(36) NOT NULL,
  `patient_id` char(36) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` char(36) NOT NULL,
  `sales_return_id` char(36) NOT NULL,
  `medicine_id` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `quantity` int(11) NOT NULL,
  `refund_amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_collections`
--

CREATE TABLE `sample_collections` (
  `id` char(36) NOT NULL,
  `lab_request_id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `sample_id` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `collection_time` datetime DEFAULT NULL,
  `status` enum('Pending','Collected','In Process','Completed','Rejected') NOT NULL DEFAULT 'Pending',
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scan_requests`
--

CREATE TABLE `scan_requests` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `scan_type_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` char(36) NOT NULL,
  `body_part` varchar(255) NOT NULL,
  `reason` text DEFAULT NULL,
  `priority` enum('Normal','Urgent') NOT NULL DEFAULT 'Normal',
  `status` enum('Pending','Scheduled','Uploaded','Under Review','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scan_schedules`
--

CREATE TABLE `scan_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scan_request_id` char(36) NOT NULL,
  `scan_date` date NOT NULL,
  `scan_time` time NOT NULL,
  `technician_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scan_types`
--

CREATE TABLE `scan_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scan_uploads`
--

CREATE TABLE `scan_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scan_request_id` char(36) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `grace_minutes` int(11) DEFAULT NULL,
  `break_minutes` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shift_assignments`
--

CREATE TABLE `shift_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shift_rotations`
--

CREATE TABLE `shift_rotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `first_shift_id` bigint(20) UNSIGNED NOT NULL,
  `second_shift_id` bigint(20) UNSIGNED NOT NULL,
  `rotation_days` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role_id` char(36) DEFAULT NULL,
  `department_id` char(36) DEFAULT NULL,
  `designation_id` char(36) DEFAULT NULL,
  `level1_supervisor_id` char(36) DEFAULT NULL,
  `level2_supervisor_id` char(36) DEFAULT NULL,
  `level3_supervisor_id` char(36) DEFAULT NULL,
  `joining_date` date NOT NULL,
  `basic_salary` decimal(15,2) DEFAULT NULL,
  `hra` decimal(15,2) DEFAULT NULL,
  `allowance` decimal(15,2) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `employee_id`, `name`, `role_id`, `department_id`, `designation_id`, `level1_supervisor_id`, `level2_supervisor_id`, `level3_supervisor_id`, `joining_date`, `basic_salary`, `hra`, `allowance`, `document_path`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '26cc9c5e-4789-11f1-80af-48684ad9278a', 'EMP-001', 'Super Admin', '26c5895a-4789-11f1-80af-48684ad9278a', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
(2, '26ccb475-4789-11f1-80af-48684ad9278a', 'EMP-002', 'HR Manager', '26c59ad6-4789-11f1-80af-48684ad9278a', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
(3, '26ccb79a-4789-11f1-80af-48684ad9278a', 'EMP-003', 'General Manager', '26c59bb3-4789-11f1-80af-48684ad9278a', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
(4, '26ccb9d0-4789-11f1-80af-48684ad9278a', 'EMP-004', 'OPD HOD', '26c59c1d-4789-11f1-80af-48684ad9278a', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
(5, '27376f0a-4789-11f1-80af-48684ad9278a', 'EMP-005', 'John Staff', '26c59c80-4789-11f1-80af-48684ad9278a', '271db7a1-4789-11f1-80af-48684ad9278a', 'QSL4TC1J1NXSKJP9FDJMSHAAIPJ2E3', '26ccb79a-4789-11f1-80af-48684ad9278a', '26ccb475-4789-11f1-80af-48684ad9278a', '26ccb9d0-4789-11f1-80af-48684ad9278a', '2024-06-01', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-04 07:16:21', '2026-05-09 03:42:31'),
(6, '671e37c6-d1b0-43aa-886e-1e209d3da828', 'EMP-0006', 'Sia Kumari', '26c59c80-4789-11f1-80af-48684ad9278a', '271dff8a-4789-11f1-80af-48684ad9278a', 'QSL4TC1J1NXSKJP9FDJMSHAAIPJ2E3', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, NULL, '2022-05-07', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-07 05:50:02', '2026-05-07 05:50:02'),
(7, '0306fbb6-a2fb-4b31-ab3c-598396cb13a8', 'EMP-0007', 'Shivani', '26c59c80-4789-11f1-80af-48684ad9278a', '271e0053-4789-11f1-80af-48684ad9278a', '2726240d-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, NULL, '2026-04-27', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-08 06:02:07', '2026-05-08 06:02:07'),
(8, '3a7e6274-8315-442f-8c08-c4a67ba9b68d', 'EMP-0008', 'isha', '26c59c80-4789-11f1-80af-48684ad9278a', '271dfb35-4789-11f1-80af-48684ad9278a', '27264f4c-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, NULL, '2026-05-04', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-08 06:03:18', '2026-05-08 06:03:18'),
(9, '7052f611-1189-4262-8cbc-66160c2ba094', 'EMP-0009', 'Dishanth', '26c59c80-4789-11f1-80af-48684ad9278a', '271dff25-4789-11f1-80af-48684ad9278a', '27264be2-4789-11f1-80af-48684ad9278a', '26ccb79a-4789-11f1-80af-48684ad9278a', NULL, NULL, '2026-05-04', NULL, NULL, NULL, NULL, 'Active', NULL, '2026-05-08 06:04:08', '2026-05-08 06:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `statutory_contributions`
--

CREATE TABLE `statutory_contributions` (
  `id` char(36) NOT NULL,
  `contribution_code` varchar(255) NOT NULL,
  `contribution_name` varchar(255) NOT NULL,
  `statutory_category` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rule_set_code` varchar(255) NOT NULL,
  `eligibility_flag` tinyint(1) NOT NULL DEFAULT 1,
  `salary_ceiling_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `salary_ceiling_amount` decimal(10,2) DEFAULT NULL,
  `state_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `applicable_states` text DEFAULT NULL,
  `prorata_applicable` tinyint(1) NOT NULL DEFAULT 1,
  `lop_impact` tinyint(1) NOT NULL DEFAULT 0,
  `rounding_rule` varchar(255) DEFAULT NULL,
  `show_in_payslip` tinyint(1) NOT NULL DEFAULT 1,
  `payslip_order` int(11) DEFAULT NULL,
  `included_in_ctc` tinyint(1) NOT NULL DEFAULT 1,
  `compliance_head` varchar(255) NOT NULL,
  `statutory_code` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statutory_contributions`
--

INSERT INTO `statutory_contributions` (`id`, `contribution_code`, `contribution_name`, `statutory_category`, `status`, `rule_set_code`, `eligibility_flag`, `salary_ceiling_applicable`, `salary_ceiling_amount`, `state_applicable`, `applicable_states`, `prorata_applicable`, `lop_impact`, `rounding_rule`, `show_in_payslip`, `payslip_order`, `included_in_ctc`, `compliance_head`, `statutory_code`, `deleted_at`, `created_at`, `updated_at`) VALUES
('2eb898ff-a174-4ec8-9bd5-ee26d084355c', 'pf_001', 'provident fund', 'PF', 'Active', 'PF_RULE_001', 1, 1, '15000.00', 1, '[\"KA\"]', 1, 1, NULL, 1, 1, 1, 'pf', 'pf-ka-001', '2026-05-12 06:04:10', '2026-05-04 10:01:36', '2026-05-12 06:04:10'),
('c48736b6-73b3-4401-bd92-fe0c8aab3ff2', 'ESI001', 'Employee state Insurance', 'ESI', 'Active', 'ESI_RULE_001', 1, 1, '21000.00', 1, '[\"KL\",\"AP\"]', 1, 1, NULL, 1, NULL, 1, 'ESI', 'ESI_IND_02', NULL, '2026-05-04 10:03:22', '2026-05-04 10:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `statutory_deductions`
--

CREATE TABLE `statutory_deductions` (
  `id` char(36) NOT NULL,
  `statutory_code` varchar(255) NOT NULL,
  `statutory_name` varchar(255) NOT NULL,
  `statutory_category` varchar(255) NOT NULL,
  `rule_set_id` char(36) DEFAULT NULL,
  `eligibility_flag` tinyint(1) NOT NULL DEFAULT 0,
  `salary_ceiling_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `state_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_payslip` tinyint(1) NOT NULL DEFAULT 1,
  `salary_ceiling_amount` decimal(10,2) DEFAULT NULL,
  `applicable_states` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_states`)),
  `prorata_applicable` tinyint(1) NOT NULL DEFAULT 0,
  `lop_impact` tinyint(1) NOT NULL DEFAULT 0,
  `rounding_rule` varchar(255) DEFAULT NULL,
  `payslip_order` int(11) DEFAULT NULL,
  `compliance_head` varchar(255) DEFAULT NULL,
  `authority_code` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statutory_deductions`
--

INSERT INTO `statutory_deductions` (`id`, `statutory_code`, `statutory_name`, `statutory_category`, `rule_set_id`, `eligibility_flag`, `salary_ceiling_applicable`, `state_applicable`, `show_in_payslip`, `salary_ceiling_amount`, `applicable_states`, `prorata_applicable`, `lop_impact`, `rounding_rule`, `payslip_order`, `compliance_head`, `authority_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('b94b71a7-cf0a-4e78-ad0c-ce5c292f7613', 'PF_DED_001', 'PF deduction', 'PF', 'dfe8556d-fc9a-4b3f-ad19-29e3b57d0dd1', 1, 1, 1, 1, '15000.00', '[\"Telangana\",\"Tamil Nadu\"]', 1, 1, 'nearest', 1, 'PF', 'PF-AUTH-001', 'active', '2026-05-04 10:08:10', '2026-05-04 10:08:10', NULL),
('c7a9e6ab-1c2c-4c59-a397-d57dd4e42c47', 'ESI_DED_001', 'ESI Deduction', 'ESI', '156bf4bc-d19c-46b4-8323-c1505deb1221', 1, 0, 1, 1, NULL, '[\"Tamil Nadu\"]', 1, 1, 'nearest', 2, 'PF', 'esi_rule', 'active', '2026-05-04 10:09:49', '2026-05-04 10:09:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_audits`
--

CREATE TABLE `stock_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_date` date NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `system_stock` int(11) NOT NULL,
  `physical_stock` int(11) NOT NULL,
  `difference` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` char(36) NOT NULL,
  `medicine_id` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `movement_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reference_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `medicine_id`, `batch_id`, `movement_type`, `quantity`, `reference_id`, `created_at`, `updated_at`) VALUES
('27102e51-4789-11f1-80af-48684ad9278a', '26eb9fac-4789-11f1-80af-48684ad9278a', '26fa5b97-4789-11f1-80af-48684ad9278a', 'IN', 100, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('271092e6-4789-11f1-80af-48684ad9278a', '26eb9fe4-4789-11f1-80af-48684ad9278a', '26f94a8c-4789-11f1-80af-48684ad9278a', 'OUT', 20, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27109e82-4789-11f1-80af-48684ad9278a', '26eba278-4789-11f1-80af-48684ad9278a', '26fa0fb4-4789-11f1-80af-48684ad9278a', 'IN', 150, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710a8db-4789-11f1-80af-48684ad9278a', '26eb9fe4-4789-11f1-80af-48684ad9278a', '26fa5b97-4789-11f1-80af-48684ad9278a', 'OUT', 30, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710b6c5-4789-11f1-80af-48684ad9278a', '26eb9fac-4789-11f1-80af-48684ad9278a', '26fa6880-4789-11f1-80af-48684ad9278a', 'IN', 80, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710c5af-4789-11f1-80af-48684ad9278a', '26eba054-4789-11f1-80af-48684ad9278a', '26fa7945-4789-11f1-80af-48684ad9278a', 'OUT', 15, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710d3b2-4789-11f1-80af-48684ad9278a', '26eba2ae-4789-11f1-80af-48684ad9278a', '26fa751c-4789-11f1-80af-48684ad9278a', 'IN', 200, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710e22e-4789-11f1-80af-48684ad9278a', '26eba0c0-4789-11f1-80af-48684ad9278a', '26fa5fe3-4789-11f1-80af-48684ad9278a', 'OUT', 50, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2710efa5-4789-11f1-80af-48684ad9278a', '26eb9fac-4789-11f1-80af-48684ad9278a', '26fa0fb4-4789-11f1-80af-48684ad9278a', 'IN', 120, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('271184ca-4789-11f1-80af-48684ad9278a', '26eba105-4789-11f1-80af-48684ad9278a', '26fa7d4b-4789-11f1-80af-48684ad9278a', 'OUT', 25, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27119a42-4789-11f1-80af-48684ad9278a', '26eb9ecb-4789-11f1-80af-48684ad9278a', '26fa02f5-4789-11f1-80af-48684ad9278a', 'IN', 90, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2711ac23-4789-11f1-80af-48684ad9278a', '26eba3bc-4789-11f1-80af-48684ad9278a', '26fa0fb4-4789-11f1-80af-48684ad9278a', 'OUT', 40, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2711ed22-4789-11f1-80af-48684ad9278a', '26eba2ae-4789-11f1-80af-48684ad9278a', '26fa2c47-4789-11f1-80af-48684ad9278a', 'IN', 60, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27121274-4789-11f1-80af-48684ad9278a', '26eb7ee9-4789-11f1-80af-48684ad9278a', '26fa6cf2-4789-11f1-80af-48684ad9278a', 'OUT', 35, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27122480-4789-11f1-80af-48684ad9278a', '26eba2e3-4789-11f1-80af-48684ad9278a', '26fa5789-4789-11f1-80af-48684ad9278a', 'IN', 110, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27123258-4789-11f1-80af-48684ad9278a', '26eba019-4789-11f1-80af-48684ad9278a', '26fa48dd-4789-11f1-80af-48684ad9278a', 'OUT', 22, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27124701-4789-11f1-80af-48684ad9278a', '26eba386-4789-11f1-80af-48684ad9278a', '26f9e9f8-4789-11f1-80af-48684ad9278a', 'IN', 140, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('271254f1-4789-11f1-80af-48684ad9278a', '26eb9e0e-4789-11f1-80af-48684ad9278a', '26fa02f5-4789-11f1-80af-48684ad9278a', 'OUT', 18, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('271263ce-4789-11f1-80af-48684ad9278a', '26eba1a3-4789-11f1-80af-48684ad9278a', '26f94a8c-4789-11f1-80af-48684ad9278a', 'IN', 170, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27127169-4789-11f1-80af-48684ad9278a', '26eba019-4789-11f1-80af-48684ad9278a', '26fa4128-4789-11f1-80af-48684ad9278a', 'OUT', 45, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27127f70-4789-11f1-80af-48684ad9278a', '26eba243-4789-11f1-80af-48684ad9278a', '26fa2c47-4789-11f1-80af-48684ad9278a', 'IN', 75, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27128e2d-4789-11f1-80af-48684ad9278a', '26eb9d78-4789-11f1-80af-48684ad9278a', '26f9e9f8-4789-11f1-80af-48684ad9278a', 'OUT', 28, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27129c0c-4789-11f1-80af-48684ad9278a', '26eba054-4789-11f1-80af-48684ad9278a', '26fa48dd-4789-11f1-80af-48684ad9278a', 'IN', 160, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712ab26-4789-11f1-80af-48684ad9278a', '26eba105-4789-11f1-80af-48684ad9278a', '26f9f06a-4789-11f1-80af-48684ad9278a', 'OUT', 33, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712b956-4789-11f1-80af-48684ad9278a', '26eba243-4789-11f1-80af-48684ad9278a', '26fa5789-4789-11f1-80af-48684ad9278a', 'IN', 95, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712c8fc-4789-11f1-80af-48684ad9278a', '26eb9c78-4789-11f1-80af-48684ad9278a', '26f96b8c-4789-11f1-80af-48684ad9278a', 'OUT', 19, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712d642-4789-11f1-80af-48684ad9278a', '26eba2ae-4789-11f1-80af-48684ad9278a', '26f94a8c-4789-11f1-80af-48684ad9278a', 'IN', 130, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712e7df-4789-11f1-80af-48684ad9278a', '26eb9fe4-4789-11f1-80af-48684ad9278a', '26f9dcde-4789-11f1-80af-48684ad9278a', 'OUT', 41, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2712f54f-4789-11f1-80af-48684ad9278a', '26eb9e53-4789-11f1-80af-48684ad9278a', '26fa7d4b-4789-11f1-80af-48684ad9278a', 'IN', 180, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('27130371-4789-11f1-80af-48684ad9278a', '26eb7ee9-4789-11f1-80af-48684ad9278a', '26fa02f5-4789-11f1-80af-48684ad9278a', 'OUT', 26, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('2abf5f42-babb-47d6-9b5a-1995326a0323', '7b877c64-cee1-4762-be7f-ed986269f701', '019df7d1-1f63-7251-8dae-408ccb835424', 'OPENING', 34, NULL, '2026-05-05 11:06:10', '2026-05-05 11:06:10'),
('e5bf874a-aaa9-46ce-a908-18a8f2b13eaf', 'adfeaa82-bd57-4e47-8139-5666f048d13c', '019df7d1-22d2-7164-8a77-359c4ab970a3', 'OPENING', 34, NULL, '2026-05-05 11:06:11', '2026-05-05 11:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_number` varchar(255) NOT NULL,
  `transfer_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_items`
--

CREATE TABLE `stock_transfer_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surgeries`
--

CREATE TABLE `surgeries` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `surgery_type` varchar(255) NOT NULL,
  `surgery_date` date NOT NULL,
  `surgery_time` time NOT NULL,
  `ot_room` varchar(255) NOT NULL,
  `surgeon_id` bigint(20) UNSIGNED NOT NULL,
  `assistant_doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `anesthetist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` enum('Normal','Emergency') NOT NULL DEFAULT 'Normal',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surgery_consents`
--

CREATE TABLE `surgery_consents` (
  `id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `surgery_id` char(36) NOT NULL,
  `consent_status` enum('Granted','Refused','Pending') NOT NULL DEFAULT 'Pending',
  `procedure_explained` text DEFAULT NULL,
  `risks_explained` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `consent_taken_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recorded_by` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_parameters`
--

CREATE TABLE `test_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `parameter_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` char(36) NOT NULL,
  `appointment_id` char(36) NOT NULL,
  `token_number` int(11) NOT NULL,
  `status` enum('WAITING','SKIPPED','COMPLETED') NOT NULL DEFAULT 'WAITING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` char(36) NOT NULL,
  `hospital_id` char(36) NOT NULL,
  `financial_year_id` char(36) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_id` char(36) NOT NULL,
  `mpin` varchar(255) DEFAULT NULL,
  `is_enrolled` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `failed_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `biometric_updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `role_id`, `mpin`, `is_enrolled`, `status`, `failed_attempts`, `locked_until`, `created_at`, `updated_at`, `deleted_at`, `biometric_updated_at`) VALUES
('0306fbb6-a2fb-4b31-ab3c-598396cb13a8', 'Shivani', '9898989892', NULL, '26c59c80-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-08 06:02:07', '2026-05-08 06:02:07', NULL, NULL),
('26cc9c5e-4789-11f1-80af-48684ad9278a', 'Super Admin', '9000000001', 'superadmin@example.com', '26c5895a-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL, NULL),
('26ccb475-4789-11f1-80af-48684ad9278a', 'HR Manager', '9000000002', 'hr@example.com', '26c59ad6-4789-11f1-80af-48684ad9278a', '$2y$12$siuZqL8o.iS9Y4xMyALRQeRMWfdtdLqzplayE2.4pq9iO2f9fdvT6', 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-04 10:36:57', NULL, NULL),
('26ccb79a-4789-11f1-80af-48684ad9278a', 'General Manager', '9000000003', 'manager@example.com', '26c59bb3-4789-11f1-80af-48684ad9278a', '$2y$12$VvfXl8Nqnztsdxv2UUtHcePoMuSURA9gfyWgXKyDOeB4tXg0G8GYe', 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-09 04:49:36', NULL, NULL),
('26ccb9d0-4789-11f1-80af-48684ad9278a', 'OPD HOD', '9000000004', 'hod@example.com', '26c59c1d-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL, NULL),
('26ccbbf0-4789-11f1-80af-48684ad9278a', 'Front Desk', '9000000005', 'reception@example.com', '26c59d69-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21', NULL, NULL),
('27376f0a-4789-11f1-80af-48684ad9278a', 'John Staff', '8000000001', 'john@example.com', '26c59c80-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-04 07:16:21', '2026-05-09 03:42:31', NULL, NULL),
('3a7e6274-8315-442f-8c08-c4a67ba9b68d', 'isha', '9000000009', NULL, '26c59c80-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-08 06:03:18', '2026-05-08 06:03:18', NULL, NULL),
('671e37c6-d1b0-43aa-886e-1e209d3da828', 'Sia Kumari', '9876787659', NULL, '26c59c80-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-07 05:50:02', '2026-05-07 05:50:02', NULL, NULL),
('7052f611-1189-4262-8cbc-66160c2ba094', 'Dishanth', '9123456787', NULL, '26c59c80-4789-11f1-80af-48684ad9278a', NULL, 0, 'active', 0, NULL, '2026-05-08 06:04:08', '2026-05-08 06:04:08', NULL, NULL),
('e8216c51-8119-4dd0-9817-d8ffb22a011c', 'Super Admin', '9999999999', NULL, '52b30ccf-8549-41f2-8fa6-491ebd04107f', '$2y$12$2MRCrKZ1k7Y9w1A7Qm42d.7iT/4E8.KHIlve6dt8fXYJt1ibqQgRm', 0, 'active', 0, NULL, '2026-05-04 07:14:49', '2026-05-05 16:51:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_biometrics`
--

CREATE TABLE `user_biometrics` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `face_embeddings` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` char(36) NOT NULL,
  `vendor_name` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE `vitals` (
  `id` char(36) NOT NULL,
  `institution_id` char(36) NOT NULL,
  `patient_id` char(36) NOT NULL,
  `nurse_id` char(36) NOT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `blood_pressure_systolic` int(11) DEFAULT NULL,
  `blood_pressure_diastolic` int(11) DEFAULT NULL,
  `pulse_rate` int(11) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `spo2` int(11) DEFAULT NULL,
  `blood_sugar` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `recorded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` char(36) NOT NULL,
  `ward_name` varchar(255) NOT NULL,
  `ward_type` varchar(255) DEFAULT NULL,
  `floor_number` int(11) DEFAULT NULL,
  `total_beds` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `ward_name`, `ward_type`, `floor_number`, `total_beds`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
('95c93edf-4f92-4fa5-8e1f-e569399885b3', 'A-1', 'General', 2, 1, 1, NULL, '2026-05-05 10:50:32', '2026-05-05 10:54:21'),
('a9a922d7-7224-4def-9015-68870db3fe3b', 'A-2', 'Private', 2, 1, 1, NULL, '2026-05-07 05:28:08', '2026-05-07 05:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `weekends`
--

CREATE TABLE `weekends` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`days`)),
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `staff` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`staff`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekends`
--

INSERT INTO `weekends` (`id`, `name`, `days`, `status`, `roles`, `staff`, `deleted_at`, `created_at`, `updated_at`) VALUES
('26d89231-4789-11f1-80af-48684ad9278a', 'Default Weekend', '[\"Saturday\", \"Sunday\"]', 'active', NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21'),
('26d8a7c8-4789-11f1-80af-48684ad9278a', 'Middle East Weekend', '[\"Friday\", \"Saturday\"]', 'inactive', NULL, NULL, NULL, '2026-05-04 07:16:21', '2026-05-04 07:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_offs`
--

CREATE TABLE `weekly_offs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `week_day` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_status_master`
--

CREATE TABLE `work_status_master` (
  `id` char(36) NOT NULL,
  `work_status_code` varchar(50) NOT NULL,
  `work_status_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `display_order` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountant_payments`
--
ALTER TABLE `accountant_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alert_audit_logs`
--
ALTER TABLE `alert_audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alert_audit_logs_alert_id_foreign` (`alert_id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `allowances_name_unique` (`name`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_department_id_foreign` (`department_id`),
  ADD KEY `appointments_receptionist_user_id_foreign` (`receptionist_user_id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_date_unique` (`user_id`,`date`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_records_employee_id_foreign` (`employee_id`),
  ADD KEY `attendance_records_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beds_ward_id_foreign` (`ward_id`);

--
-- Indexes for table `bed_allocations`
--
ALTER TABLE `bed_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bed_allocations_patient_id_foreign` (`patient_id`),
  ADD KEY `bed_allocations_bed_id_foreign` (`bed_id`);

--
-- Indexes for table `biometric_images`
--
ALTER TABLE `biometric_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `biometric_images_user_id_slot_unique` (`user_id`,`slot`);

--
-- Indexes for table `blood_group_master`
--
ALTER TABLE `blood_group_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blood_group_master_blood_group_name_unique` (`blood_group_name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `comp_offs`
--
ALTER TABLE `comp_offs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultation_medicines`
--
ALTER TABLE `consultation_medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `controlled_drug`
--
ALTER TABLE `controlled_drug`
  ADD PRIMARY KEY (`controlled_drug_id`);

--
-- Indexes for table `controlled_drug_dispense`
--
ALTER TABLE `controlled_drug_dispense`
  ADD PRIMARY KEY (`dispense_id`);

--
-- Indexes for table `controlled_drug_log`
--
ALTER TABLE `controlled_drug_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `critical_value_alerts`
--
ALTER TABLE `critical_value_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_usage_consents`
--
ALTER TABLE `data_usage_consents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_usage_consents_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deductions_name_unique` (`name`);

--
-- Indexes for table `deduction_rule_sets`
--
ALTER TABLE `deduction_rule_sets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deduction_rule_sets_rule_set_code_unique` (`rule_set_code`);

--
-- Indexes for table `department_master`
--
ALTER TABLE `department_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_master_department_code_unique` (`department_code`),
  ADD UNIQUE KEY `department_master_department_name_unique` (`department_name`);

--
-- Indexes for table `designation_master`
--
ALTER TABLE `designation_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designation_master_designation_code_unique` (`designation_code`),
  ADD KEY `designation_master_department_id_index` (`department_id`);

--
-- Indexes for table `discharge_preparations`
--
ALTER TABLE `discharge_preparations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discharge_preparations_patient_id_index` (`patient_id`),
  ADD KEY `discharge_preparations_ipd_admission_id_index` (`ipd_admission_id`);

--
-- Indexes for table `emergency_cases`
--
ALTER TABLE `emergency_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emergency_cases_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `employee_salary_assignments`
--
ALTER TABLE `employee_salary_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipment_equipment_code_unique` (`equipment_code`);

--
-- Indexes for table `equipment_breakdowns`
--
ALTER TABLE `equipment_breakdowns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_breakdowns_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `equipment_calibrations`
--
ALTER TABLE `equipment_calibrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_calibrations_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `equipment_maintenance`
--
ALTER TABLE `equipment_maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_maintenance_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `expiry_logs`
--
ALTER TABLE `expiry_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expiry_logs_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_audit_logs`
--
ALTER TABLE `file_audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `financial_years_code_unique` (`code`);

--
-- Indexes for table `geofences`
--
ALTER TABLE `geofences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `geofences_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `grns`
--
ALTER TABLE `grns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grns_grn_no_unique` (`grn_no`);

--
-- Indexes for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grn_items_grn_id_foreign` (`grn_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hospitals_code_unique` (`code`),
  ADD KEY `hospitals_institution_id_index` (`institution_id`);

--
-- Indexes for table `hospital_financial_years`
--
ALTER TABLE `hospital_financial_years`
  ADD UNIQUE KEY `hospital_financial_years_hospital_id_financial_year_id_unique` (`hospital_id`,`financial_year_id`),
  ADD KEY `hospital_financial_years_financial_year_id_foreign` (`financial_year_id`);

--
-- Indexes for table `hourly_pays`
--
ALTER TABLE `hourly_pays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hourly_pay_approvals`
--
ALTER TABLE `hourly_pay_approvals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infection_control_logs`
--
ALTER TABLE `infection_control_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `institutions_code_unique` (`code`);

--
-- Indexes for table `institution_module`
--
ALTER TABLE `institution_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institution_module_institution_id_module_id_index` (`institution_id`,`module_id`);

--
-- Indexes for table `insurance_documents`
--
ALTER TABLE `insurance_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_documents_insurance_id_foreign` (`insurance_id`);

--
-- Indexes for table `inventory_vendors`
--
ALTER TABLE `inventory_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_admissions`
--
ALTER TABLE `ipd_admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ipd_admissions_admission_id_unique` (`admission_id`),
  ADD KEY `ipd_admissions_patient_id_index` (`patient_id`),
  ADD KEY `ipd_admissions_doctor_id_index` (`doctor_id`),
  ADD KEY `ipd_admissions_bed_id_index` (`bed_id`),
  ADD KEY `ipd_admissions_status_index` (`status`);

--
-- Indexes for table `ipd_bills`
--
ALTER TABLE `ipd_bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ipd_bills_bill_no_unique` (`bill_no`);

--
-- Indexes for table `ipd_bill_items`
--
ALTER TABLE `ipd_bill_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_discharges`
--
ALTER TABLE `ipd_discharges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_notes`
--
ALTER TABLE `ipd_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_payments`
--
ALTER TABLE `ipd_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ipd_payments_patient_id_index` (`patient_id`),
  ADD KEY `ipd_payments_ipd_id_index` (`ipd_id`);

--
-- Indexes for table `ipd_prescriptions`
--
ALTER TABLE `ipd_prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_prescription_items`
--
ALTER TABLE `ipd_prescription_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_treatments`
--
ALTER TABLE `ipd_treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isolation_records`
--
ALTER TABLE `isolation_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_code_unique` (`code`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_type_master`
--
ALTER TABLE `job_type_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_type_master_job_type_code_unique` (`job_type_code`);

--
-- Indexes for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_reports_sample_id_unique` (`sample_id`);

--
-- Indexes for table `lab_requests`
--
ALTER TABLE `lab_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_tests`
--
ALTER TABLE `lab_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_tests_test_code_unique` (`test_code`);

--
-- Indexes for table `leave_adjustments`
--
ALTER TABLE `leave_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_applications_staff_id_foreign` (`staff_id`),
  ADD KEY `leave_applications_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `leave_mappings`
--
ALTER TABLE `leave_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_mappings_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `leave_request_approvals`
--
ALTER TABLE `leave_request_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_request_approvals_leave_request_id_foreign` (`leave_request_id`),
  ADD KEY `leave_request_approvals_approver_id_foreign` (`approver_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medication_administration`
--
ALTER TABLE `medication_administration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medication_administration_patient_id_foreign` (`patient_id`),
  ADD KEY `medication_administration_nurse_id_foreign` (`nurse_id`),
  ADD KEY `medication_administration_prescription_item_id_foreign` (`prescription_item_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_batches_medicine_id_foreign` (`medicine_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_module_label_unique` (`module_label`),
  ADD KEY `modules_parent_module_index` (`parent_module`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nurse_shift_handover`
--
ALTER TABLE `nurse_shift_handover`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_prescriptions`
--
ALTER TABLE `offline_prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offline_prescriptions_prescription_number_unique` (`prescription_number`);

--
-- Indexes for table `offline_prescription_items`
--
ALTER TABLE `offline_prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_prescription_items_offline_prescription_id_foreign` (`offline_prescription_id`);

--
-- Indexes for table `opd`
--
ALTER TABLE `opd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opd_appointment_id_foreign` (`appointment_id`),
  ADD KEY `opd_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ot_management`
--
ALTER TABLE `ot_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_patient_code_unique` (`patient_code`);

--
-- Indexes for table `patient_insurances`
--
ALTER TABLE `patient_insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_medical_flags`
--
ALTER TABLE `patient_medical_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_medical_flags_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_vendor_id_foreign` (`vendor_id`),
  ADD KEY `payments_inventory_vendor_id_foreign` (`inventory_vendor_id`);

--
-- Indexes for table `payroll_results`
--
ALTER TABLE `payroll_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_result_deductions`
--
ALTER TABLE `payroll_result_deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prd_result_code_unique` (`payroll_result_id`,`deduction_code`);

--
-- Indexes for table `payroll_result_earnings`
--
ALTER TABLE `payroll_result_earnings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pre_payroll_earning_unique` (`payroll_result_id`,`earning_code`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `pharmacy_ipd_dispense`
--
ALTER TABLE `pharmacy_ipd_dispense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_operatives`
--
ALTER TABLE `post_operatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppe_compliance_logs`
--
ALTER TABLE `ppe_compliance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_status`
--
ALTER TABLE `prescription_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preventive_maintenance`
--
ALTER TABLE `preventive_maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preventive_maintenance_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `pre_operatives`
--
ALTER TABLE `pre_operatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_payroll_adjustments`
--
ALTER TABLE `pre_payroll_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pre_payroll_adjustments_pre_payroll_code_unique` (`pre_payroll_code`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_vendor_id_foreign` (`vendor_id`),
  ADD KEY `purchases_inventory_vendor_id_foreign` (`inventory_vendor_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  ADD KEY `purchase_orders_vendor_id_foreign` (`vendor_id`),
  ADD KEY `purchase_orders_inventory_vendor_id_foreign` (`inventory_vendor_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `radiology_reports_scan_request_id_foreign` (`scan_request_id`),
  ADD KEY `radiology_reports_radiologist_id_foreign` (`radiologist_id`);

--
-- Indexes for table `rate_employee_mappings`
--
ALTER TABLE `rate_employee_mappings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rate_employee_mappings_rule_set_code_unique` (`rule_set_code`);

--
-- Indexes for table `receptionist_billing`
--
ALTER TABLE `receptionist_billing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receptionist_billing_receipt_no_unique` (`receipt_no`);

--
-- Indexes for table `religion_master`
--
ALTER TABLE `religion_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `religion_master_religion_name_unique` (`religion_name`);

--
-- Indexes for table `report_files`
--
ALTER TABLE `report_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_files_lab_report_id_foreign` (`lab_report_id`);

--
-- Indexes for table `report_logs`
--
ALTER TABLE `report_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_ward_id_foreign` (`ward_id`);

--
-- Indexes for table `salary_structures`
--
ALTER TABLE `salary_structures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `salary_structures_salary_structure_code_unique` (`salary_structure_code`);

--
-- Indexes for table `sales_bills`
--
ALTER TABLE `sales_bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `sales_bill_items`
--
ALTER TABLE `sales_bill_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_bill_items_sales_bill_id_foreign` (`sales_bill_id`),
  ADD KEY `sales_bill_items_medicine_id_foreign` (`medicine_id`),
  ADD KEY `sales_bill_items_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_returns_return_number_unique` (`return_number`),
  ADD KEY `sales_returns_bill_id_foreign` (`bill_id`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_items_sales_return_id_foreign` (`sales_return_id`),
  ADD KEY `sales_return_items_medicine_id_foreign` (`medicine_id`),
  ADD KEY `sales_return_items_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `sample_collections`
--
ALTER TABLE `sample_collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sample_collections_sample_id_unique` (`sample_id`);

--
-- Indexes for table `scan_requests`
--
ALTER TABLE `scan_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scan_requests_patient_id_foreign` (`patient_id`),
  ADD KEY `scan_requests_scan_type_id_foreign` (`scan_type_id`),
  ADD KEY `scan_requests_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `scan_schedules`
--
ALTER TABLE `scan_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scan_schedules_scan_request_id_foreign` (`scan_request_id`);

--
-- Indexes for table `scan_types`
--
ALTER TABLE `scan_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scan_types_name_unique` (`name`);

--
-- Indexes for table `scan_uploads`
--
ALTER TABLE `scan_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scan_uploads_scan_request_id_foreign` (`scan_request_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_assignments`
--
ALTER TABLE `shift_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shift_assignments_staff_id_foreign` (`staff_id`),
  ADD KEY `shift_assignments_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `shift_rotations`
--
ALTER TABLE `shift_rotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shift_rotations_staff_id_foreign` (`staff_id`),
  ADD KEY `shift_rotations_first_shift_id_foreign` (`first_shift_id`),
  ADD KEY `shift_rotations_second_shift_id_foreign` (`second_shift_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  ADD KEY `staff_role_id_foreign` (`role_id`),
  ADD KEY `staff_department_id_foreign` (`department_id`),
  ADD KEY `staff_designation_id_foreign` (`designation_id`),
  ADD KEY `staff_level1_supervisor_id_foreign` (`level1_supervisor_id`),
  ADD KEY `staff_level2_supervisor_id_foreign` (`level2_supervisor_id`),
  ADD KEY `staff_level3_supervisor_id_foreign` (`level3_supervisor_id`);

--
-- Indexes for table `statutory_contributions`
--
ALTER TABLE `statutory_contributions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statutory_contributions_contribution_code_unique` (`contribution_code`);

--
-- Indexes for table `statutory_deductions`
--
ALTER TABLE `statutory_deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statutory_deductions_statutory_code_unique` (`statutory_code`),
  ADD KEY `statutory_deductions_rule_set_id_foreign` (`rule_set_id`);

--
-- Indexes for table `stock_audits`
--
ALTER TABLE `stock_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_audits_item_id_foreign` (`item_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_medicine_id_foreign` (`medicine_id`),
  ADD KEY `stock_movements_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_items_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `surgeries`
--
ALTER TABLE `surgeries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surgery_consents`
--
ALTER TABLE `surgery_consents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surgery_consents_patient_id_foreign` (`patient_id`),
  ADD KEY `surgery_consents_surgery_id_foreign` (`surgery_id`);

--
-- Indexes for table `test_parameters`
--
ALTER TABLE `test_parameters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_parameters_test_name_parameter_id_unique` (`test_name`,`parameter_id`),
  ADD KEY `test_parameters_parameter_id_foreign` (`parameter_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_financial_year_id_foreign` (`financial_year_id`),
  ADD KEY `transactions_hospital_id_financial_year_id_index` (`hospital_id`,`financial_year_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_biometrics`
--
ALTER TABLE `user_biometrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_biometrics_user_id_foreign` (`user_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekends`
--
ALTER TABLE `weekends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weekends_name_unique` (`name`);

--
-- Indexes for table `weekly_offs`
--
ALTER TABLE `weekly_offs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_offs_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `work_status_master`
--
ALTER TABLE `work_status_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_status_master_work_status_code_unique` (`work_status_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_allocations`
--
ALTER TABLE `bed_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biometric_images`
--
ALTER TABLE `biometric_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grns`
--
ALTER TABLE `grns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grn_items`
--
ALTER TABLE `grn_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hourly_pay_approvals`
--
ALTER TABLE `hourly_pay_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `institution_module`
--
ALTER TABLE `institution_module`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ipd_payments`
--
ALTER TABLE `ipd_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `nurse_shift_handover`
--
ALTER TABLE `nurse_shift_handover`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_management`
--
ALTER TABLE `ot_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_medical_flags`
--
ALTER TABLE `patient_medical_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_operatives`
--
ALTER TABLE `post_operatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_operatives`
--
ALTER TABLE `pre_operatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_logs`
--
ALTER TABLE `report_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scan_schedules`
--
ALTER TABLE `scan_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scan_types`
--
ALTER TABLE `scan_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scan_uploads`
--
ALTER TABLE `scan_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_assignments`
--
ALTER TABLE `shift_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_rotations`
--
ALTER TABLE `shift_rotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_audits`
--
ALTER TABLE `stock_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_parameters`
--
ALTER TABLE `test_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_offs`
--
ALTER TABLE `weekly_offs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alert_audit_logs`
--
ALTER TABLE `alert_audit_logs`
  ADD CONSTRAINT `alert_audit_logs_alert_id_foreign` FOREIGN KEY (`alert_id`) REFERENCES `critical_value_alerts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department_master` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_receptionist_user_id_foreign` FOREIGN KEY (`receptionist_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`);

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bed_allocations`
--
ALTER TABLE `bed_allocations`
  ADD CONSTRAINT `bed_allocations_bed_id_foreign` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bed_allocations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biometric_images`
--
ALTER TABLE `biometric_images`
  ADD CONSTRAINT `biometric_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_usage_consents`
--
ALTER TABLE `data_usage_consents`
  ADD CONSTRAINT `data_usage_consents_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emergency_cases`
--
ALTER TABLE `emergency_cases`
  ADD CONSTRAINT `emergency_cases_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_breakdowns`
--
ALTER TABLE `equipment_breakdowns`
  ADD CONSTRAINT `equipment_breakdowns_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_calibrations`
--
ALTER TABLE `equipment_calibrations`
  ADD CONSTRAINT `equipment_calibrations_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_maintenance`
--
ALTER TABLE `equipment_maintenance`
  ADD CONSTRAINT `equipment_maintenance_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expiry_logs`
--
ALTER TABLE `expiry_logs`
  ADD CONSTRAINT `expiry_logs_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `geofences`
--
ALTER TABLE `geofences`
  ADD CONSTRAINT `geofences_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD CONSTRAINT `grn_items_grn_id_foreign` FOREIGN KEY (`grn_id`) REFERENCES `grns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hospital_financial_years`
--
ALTER TABLE `hospital_financial_years`
  ADD CONSTRAINT `hospital_financial_years_financial_year_id_foreign` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospital_financial_years_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `insurance_documents`
--
ALTER TABLE `insurance_documents`
  ADD CONSTRAINT `insurance_documents_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `patient_insurances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD CONSTRAINT `lab_reports_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `sample_collections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `leave_applications_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_applications_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_mappings`
--
ALTER TABLE `leave_mappings`
  ADD CONSTRAINT `leave_mappings_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_request_approvals`
--
ALTER TABLE `leave_request_approvals`
  ADD CONSTRAINT `leave_request_approvals_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_request_approvals_leave_request_id_foreign` FOREIGN KEY (`leave_request_id`) REFERENCES `leave_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medication_administration`
--
ALTER TABLE `medication_administration`
  ADD CONSTRAINT `medication_administration_nurse_id_foreign` FOREIGN KEY (`nurse_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `medication_administration_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `medication_administration_prescription_item_id_foreign` FOREIGN KEY (`prescription_item_id`) REFERENCES `offline_prescription_items` (`id`);

--
-- Constraints for table `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD CONSTRAINT `medicine_batches_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offline_prescription_items`
--
ALTER TABLE `offline_prescription_items`
  ADD CONSTRAINT `offline_prescription_items_offline_prescription_id_foreign` FOREIGN KEY (`offline_prescription_id`) REFERENCES `offline_prescriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opd`
--
ALTER TABLE `opd`
  ADD CONSTRAINT `opd_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_medical_flags`
--
ALTER TABLE `patient_medical_flags`
  ADD CONSTRAINT `patient_medical_flags_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_inventory_vendor_id_foreign` FOREIGN KEY (`inventory_vendor_id`) REFERENCES `inventory_vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll_result_deductions`
--
ALTER TABLE `payroll_result_deductions`
  ADD CONSTRAINT `payroll_result_deductions_payroll_result_id_foreign` FOREIGN KEY (`payroll_result_id`) REFERENCES `payroll_results` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll_result_earnings`
--
ALTER TABLE `payroll_result_earnings`
  ADD CONSTRAINT `payroll_result_earnings_payroll_result_id_foreign` FOREIGN KEY (`payroll_result_id`) REFERENCES `payroll_results` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `preventive_maintenance`
--
ALTER TABLE `preventive_maintenance`
  ADD CONSTRAINT `preventive_maintenance_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_inventory_vendor_id_foreign` FOREIGN KEY (`inventory_vendor_id`) REFERENCES `inventory_vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_inventory_vendor_id_foreign` FOREIGN KEY (`inventory_vendor_id`) REFERENCES `inventory_vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_orders_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  ADD CONSTRAINT `radiology_reports_radiologist_id_foreign` FOREIGN KEY (`radiologist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `radiology_reports_scan_request_id_foreign` FOREIGN KEY (`scan_request_id`) REFERENCES `scan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_files`
--
ALTER TABLE `report_files`
  ADD CONSTRAINT `report_files_lab_report_id_foreign` FOREIGN KEY (`lab_report_id`) REFERENCES `lab_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_bill_items`
--
ALTER TABLE `sales_bill_items`
  ADD CONSTRAINT `sales_bill_items_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_bill_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_bill_items_sales_bill_id_foreign` FOREIGN KEY (`sales_bill_id`) REFERENCES `sales_bills` (`bill_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD CONSTRAINT `sales_returns_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `sales_bills` (`bill_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD CONSTRAINT `sales_return_items_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_return_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_return_items_sales_return_id_foreign` FOREIGN KEY (`sales_return_id`) REFERENCES `sales_returns` (`bill_id`) ON DELETE CASCADE;

--
-- Constraints for table `scan_requests`
--
ALTER TABLE `scan_requests`
  ADD CONSTRAINT `scan_requests_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scan_requests_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scan_requests_scan_type_id_foreign` FOREIGN KEY (`scan_type_id`) REFERENCES `scan_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scan_schedules`
--
ALTER TABLE `scan_schedules`
  ADD CONSTRAINT `scan_schedules_scan_request_id_foreign` FOREIGN KEY (`scan_request_id`) REFERENCES `scan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scan_uploads`
--
ALTER TABLE `scan_uploads`
  ADD CONSTRAINT `scan_uploads_scan_request_id_foreign` FOREIGN KEY (`scan_request_id`) REFERENCES `scan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shift_assignments`
--
ALTER TABLE `shift_assignments`
  ADD CONSTRAINT `shift_assignments_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shift_assignments_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shift_rotations`
--
ALTER TABLE `shift_rotations`
  ADD CONSTRAINT `shift_rotations_first_shift_id_foreign` FOREIGN KEY (`first_shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shift_rotations_second_shift_id_foreign` FOREIGN KEY (`second_shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shift_rotations_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department_master` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designation_master` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_level1_supervisor_id_foreign` FOREIGN KEY (`level1_supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_level2_supervisor_id_foreign` FOREIGN KEY (`level2_supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_level3_supervisor_id_foreign` FOREIGN KEY (`level3_supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statutory_deductions`
--
ALTER TABLE `statutory_deductions`
  ADD CONSTRAINT `statutory_deductions_rule_set_id_foreign` FOREIGN KEY (`rule_set_id`) REFERENCES `deduction_rule_sets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_audits`
--
ALTER TABLE `stock_audits`
  ADD CONSTRAINT `stock_audits_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD CONSTRAINT `stock_transfer_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `stock_transfer_items_stock_transfer_id_foreign` FOREIGN KEY (`stock_transfer_id`) REFERENCES `stock_transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surgery_consents`
--
ALTER TABLE `surgery_consents`
  ADD CONSTRAINT `surgery_consents_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surgery_consents_surgery_id_foreign` FOREIGN KEY (`surgery_id`) REFERENCES `surgeries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `test_parameters`
--
ALTER TABLE `test_parameters`
  ADD CONSTRAINT `test_parameters_parameter_id_foreign` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_financial_year_id_foreign` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_biometrics`
--
ALTER TABLE `user_biometrics`
  ADD CONSTRAINT `user_biometrics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_offs`
--
ALTER TABLE `weekly_offs`
  ADD CONSTRAINT `weekly_offs_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
