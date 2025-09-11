-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 03:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danish`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_08_28_095436_create_consumables_table', 1),
(2, '2025_09_04_174446_create_customer_contact_infos_table', 1),
(3, '2025_09_05_105629_create_supplier_contact_infos_table', 2),
(4, '2025_09_08_114939_create_material_types_table', 3),
(5, '2025_09_08_161319_create_tools_table', 4),
(6, '2025_09_09_114045_create_drawing_parameters_table', 5),
(7, '2025_09_09_120017_create_drawing_parameters_table', 6),
(8, '2025_09_08_123106_instrument_categories', 7),
(9, '2025_09_08_141637_create_instruments_table', 7),
(10, '2025_09_08_144236_rename_name_to_instrument_name_in_tbl_instruments_table', 7),
(11, '2025_09_08_171552_add_del_status_column_to_instruments_table', 7),
(12, '2025_09_08_172550_change_calibration_to_calibration_due_column_to_instruments_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `opening_balance` float(10,2) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `company_id`, `name`, `opening_balance`, `description`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, NULL, 'Danish', 0.00, NULL, NULL, '2025-07-07 17:37:32', '2025-07-07 17:37:32', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_settings`
--

CREATE TABLE `tbl_admin_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_company_name` varchar(255) NOT NULL,
  `contact_person` varchar(200) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `ssi_no` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `base_color` varchar(50) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `first_section_image` varchar(255) DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `date_format` varchar(255) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `currency_position` varchar(10) DEFAULT 'Before',
  `precision` varchar(10) DEFAULT NULL,
  `decimals_separator` varchar(20) DEFAULT NULL,
  `thousands_separator` varchar(20) DEFAULT NULL,
  `time_zone` varchar(255) NOT NULL,
  `web_site` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_settings`
--

INSERT INTO `tbl_admin_settings` (`id`, `name_company_name`, `contact_person`, `phone`, `email`, `gst_no`, `pan_no`, `ssi_no`, `address`, `logo`, `base_color`, `favicon`, `first_section_image`, `footer`, `date_format`, `currency`, `currency_position`, `precision`, `decimals_separator`, `thousands_separator`, `time_zone`, `web_site`, `created_at`, `del_status`, `updated_at`) VALUES
(1, 'Danish Industries', 'Danish', '+9894867672', 'info@danish.com', '33AEIPR2079E1ZI', 'AEIPR2079E', '18/15/04212', '105, Vadugapatti Village Viralimalai, Pudukottai (Dt) Tamil Nadu - 621316', '', '#6ab04c', '1597255952_favicon.ico', 'a1e38ee1494380b96242260c6e1cc2b2.png', 'Developed by DoorSoft', 'd/m/Y', '₹', 'Before', '2', '.', ',', 'Asia/Dhaka', 'https://www.danishindustries.in/', '2020-08-04 22:18:53', 'Live', '2025-07-10 23:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_user_menus`
--

CREATE TABLE `tbl_admin_user_menus` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `controller_name` varchar(50) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attachments`
--

CREATE TABLE `tbl_attachments` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live',
  `is_closed` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `contact_person` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `ssi_no` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `date_format` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `system_featured_photo` varchar(300) DEFAULT NULL,
  `is_white_label_change_able` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`id`, `company_name`, `contact_person`, `phone`, `email`, `gst_no`, `pan_no`, `ssi_no`, `website`, `address`, `currency`, `timezone`, `date_format`, `logo`, `system_featured_photo`, `is_white_label_change_able`) VALUES
(1, 'Danish Industries', 'Danish', '+9894867672', 'info@danish.com', '33AEIPR2079E1ZI', 'AEIPR2079E', '18/15/04212', 'https://www.danishindustries.in/', '105, Vadugapatti Village Viralimalai, Pudukottai (Dt) Tamil Nadu - 621316', NULL, NULL, NULL, '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_consumables`
--

CREATE TABLE `tbl_consumables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ppcrc_no` varchar(50) NOT NULL,
  `production_stage` int(11) NOT NULL,
  `qty` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE `tbl_currency` (
  `id` int(11) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `conversion_rate` varchar(50) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 1,
  `del_status` varchar(50) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `gst_no` varchar(16) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `hsn_sac_no` varchar(20) DEFAULT NULL,
  `ecc_no` varchar(20) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `opening_balance` float DEFAULT NULL,
  `opening_balance_type` varchar(50) DEFAULT NULL,
  `credit_limit` float DEFAULT NULL,
  `date_of_birth` varchar(30) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `permanent_address` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `date_of_anniversary` varchar(30) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`id`, `customer_id`, `name`, `phone`, `email`, `address`, `gst_no`, `pan_no`, `hsn_sac_no`, `ecc_no`, `area`, `opening_balance`, `opening_balance_type`, `credit_limit`, `date_of_birth`, `customer_type`, `permanent_address`, `company_id`, `photo`, `date_of_anniversary`, `discount`, `note`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'CUS0001', 'Usha', '9655333787', '', 'No 2, kamarajar salai.', '29GGGGG1314R9Z6', '', '', '', '', NULL, NULL, NULL, NULL, 'Retail', NULL, NULL, NULL, NULL, NULL, '', 1, '2025-08-12 21:04:24', '2025-08-14 23:33:45', 'Deleted'),
(2, 'CUS0002', 'ANDERSON GREENWOOD CROSBY SANNER LTD', '04339 222444', 'nv7@sanmargroup.com', '88/1 B, Vadugappti Village Viralimalai, Viralimalai, Pudukottai (Dt) PIN- 621316.', '33AAACT7409H1ZH', 'AAACT7409H', '', '', '', NULL, NULL, NULL, NULL, 'Retail', NULL, NULL, NULL, NULL, NULL, '', 1, '2025-08-14 23:40:07', '2025-08-14 23:40:07', 'Live'),
(3, 'CUS0003', 'Sai Tech', '09897888888', 'admin@gmail.com', 'maduraiuuuuuuuuuuuuuuu', '', '', '', '', '', NULL, NULL, NULL, NULL, 'Retail', NULL, NULL, NULL, NULL, NULL, 'PRASANNA - 98230948435954 - BH - PRASANN&GMAIL\r\nELAKKIYA- TECHNICAL HEAD- 9893333', 1, '2025-09-01 17:19:19', '2025-09-01 17:20:09', 'Live'),
(5, 'CUS0004', 'MA SANDALWOOD LTD', '9633663366', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 'Wholesale', NULL, NULL, NULL, NULL, NULL, '', 1, '2025-09-04 12:36:10', '2025-09-04 12:36:10', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_contact_info`
--

CREATE TABLE `tbl_customer_contact_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `cp_name` varchar(50) DEFAULT NULL,
  `cp_department` varchar(30) DEFAULT NULL,
  `cp_designation` varchar(30) DEFAULT NULL,
  `cp_phone` text DEFAULT NULL,
  `cp_email` varchar(128) DEFAULT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_contact_info`
--

INSERT INTO `tbl_customer_contact_info` (`id`, `customer_id`, `cp_name`, `cp_department`, `cp_designation`, `cp_phone`, `cp_email`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Usha Devi', 'Sales', 'Sales Manager', '9878585858', '', 'Live', '2025-09-05 04:43:07', '2025-09-05 04:45:50'),
(2, 5, 'Ashok', 'HR', 'Manager', '9865666666', '', 'Live', '2025-09-05 04:45:50', '2025-09-05 08:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_due_receives`
--

CREATE TABLE `tbl_customer_due_receives` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` float(10,2) DEFAULT NULL,
  `pay_amount` float(10,2) NOT NULL,
  `balance_amount` float(10,2) DEFAULT NULL,
  `payment_type` varchar(10) NOT NULL,
  `note` varchar(200) DEFAULT NULL,
  `payment_proof` varchar(150) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `due_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` varchar(50) DEFAULT 'Live',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_due_receives`
--

INSERT INTO `tbl_customer_due_receives` (`id`, `order_id`, `reference_no`, `order_date`, `customer_id`, `total_amount`, `pay_amount`, `balance_amount`, `payment_type`, `note`, `payment_proof`, `user_id`, `account_id`, `company_id`, `due_date_time`, `del_status`, `created_at`) VALUES
(1, 1, '6500149072/1', '2025-09-11', 2, 1792.00, 1792.00, 0.00, 'UPI', '', NULL, 1, NULL, NULL, '2025-09-11 13:18:38', 'Live', '2025-09-11 13:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_orders`
--

CREATE TABLE `tbl_customer_orders` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_type` varchar(50) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT 0 COMMENT '0-default,1-confirmed,2-cancelled',
  `total_product` int(11) DEFAULT NULL,
  `total_amount` float(10,2) DEFAULT NULL,
  `quotation_note` text DEFAULT NULL,
  `internal_note` text DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_orders`
--

INSERT INTO `tbl_customer_orders` (`id`, `reference_no`, `customer_id`, `order_type`, `po_date`, `delivery_date`, `delivery_address`, `order_status`, `total_product`, `total_amount`, `quotation_note`, `internal_note`, `file`, `created_by`, `updated_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, '6500149072', 2, 'Quotation', '2025-09-11', NULL, '88/1 B, Vadugappti Village Viralimalai, Viralimalai, Pudukottai (Dt) PIN- 621316.', 0, 2, 2912.00, '', '', NULL, 1, NULL, '2025-09-11 00:52:35', NULL, 'Live'),
(2, '6500150191', 2, 'Work Order', '2025-09-11', NULL, '88/1 B, Vadugappti Village Viralimalai, Viralimalai, Pudukottai (Dt) PIN- 621316.', 0, 1, 17700.00, '', '', NULL, 1, NULL, '2025-09-11 00:55:13', NULL, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_order_deliveries`
--

CREATE TABLE `tbl_customer_order_deliveries` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_note` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_order_details`
--

CREATE TABLE `tbl_customer_order_details` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) DEFAULT NULL,
  `line_item_no` varchar(30) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `raw_material_id` int(11) NOT NULL,
  `raw_qty` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sale_price` float(10,2) NOT NULL,
  `price` float(10,2) NOT NULL,
  `tax_type` int(11) DEFAULT NULL,
  `inter_state` varchar(1) DEFAULT NULL,
  `cgst` varchar(3) DEFAULT NULL,
  `sgst` varchar(3) DEFAULT NULL,
  `igst` varchar(3) DEFAULT NULL,
  `discount_percent` float DEFAULT NULL,
  `sub_total` float(10,2) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `tax_amount` float(10,2) NOT NULL,
  `production_status` varchar(50) DEFAULT NULL,
  `delivered_qty` int(11) DEFAULT NULL,
  `last_update_date` timestamp NULL DEFAULT current_timestamp(),
  `order_status` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_order_details`
--

INSERT INTO `tbl_customer_order_details` (`id`, `customer_order_id`, `line_item_no`, `product_id`, `raw_material_id`, `raw_qty`, `quantity`, `sale_price`, `price`, `tax_type`, `inter_state`, `cgst`, `sgst`, `igst`, `discount_percent`, `sub_total`, `delivery_date`, `tax_amount`, `production_status`, `delivered_qty`, `last_update_date`, `order_status`, `del_status`) VALUES
(1, 1, '1', 13, 22, 4, 2, 800.00, 1600.00, 1, 'N', '6', '6', '', 0, 1792.00, NULL, 192.00, '0', 0, '2025-09-11 12:52:35', 1, 'Live'),
(2, 1, '2', 8, 10, 2, 1, 1000.00, 1000.00, 1, 'N', '6', '6', '', 0, 1120.00, NULL, 120.00, '0', 0, '2025-09-11 12:52:35', 0, 'Live'),
(3, 2, '18', 31, 18, 2, 1, 15000.00, 15000.00, 2, 'N', '9', '9', '', 0, 17700.00, NULL, 2700.00, '0', 0, '2025-09-11 12:55:13', 1, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_order_invoices`
--

CREATE TABLE `tbl_customer_order_invoices` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) DEFAULT NULL,
  `invoice_type` varchar(50) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `paid_amount` float(10,2) DEFAULT NULL,
  `due_amount` float(10,2) DEFAULT NULL,
  `order_due_amount` float(10,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_order_invoices`
--

INSERT INTO `tbl_customer_order_invoices` (`id`, `customer_order_id`, `invoice_type`, `amount`, `paid_amount`, `due_amount`, `order_due_amount`, `invoice_date`, `updated_at`, `updated_by`, `del_status`) VALUES
(1, 1, 'Quotation', 1792.00, 1792.00, 0.00, NULL, '2025-09-11', '2025-09-11 12:52:35', NULL, 'Live'),
(2, 2, 'Quotation', 1120.00, 0.00, 1120.00, NULL, '2025-09-11', '2025-09-11 12:52:35', NULL, 'Live'),
(3, 3, 'Quotation', 17700.00, 0.00, 17700.00, NULL, '2025-09-11', '2025-09-11 12:55:13', NULL, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deposits`
--

CREATE TABLE `tbl_deposits` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 0,
  `del_status` varchar(11) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_deposits`
--

INSERT INTO `tbl_deposits` (`id`, `reference_no`, `date`, `type`, `note`, `amount`, `account_id`, `user_id`, `company_id`, `del_status`) VALUES
(1, '900656', '2025-07-07', 'Deposit', '', 50000, 1, 1, 1, 'Live'),
(2, '900545', '2025-07-07', 'Withdraw', '', 40000, 1, 1, 1, 'Live'),
(3, '900555', '2025-07-23', 'Withdraw', '', 10000, 1, 1, 1, 'Live'),
(4, 'TEst001', '2025-08-04', 'Deposit', 'Purpose', 500, 1, 1, 1, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drawers`
--

CREATE TABLE `tbl_drawers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `drawer_no` varchar(50) NOT NULL,
  `revision_no` varchar(30) NOT NULL,
  `revision_date` date NOT NULL,
  `drawer_loc` varchar(100) NOT NULL,
  `program_code` text NOT NULL,
  `drawer_img` varchar(150) DEFAULT NULL,
  `tools_id` text DEFAULT NULL,
  `stage_id` text NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_drawers`
--

INSERT INTO `tbl_drawers` (`id`, `drawer_no`, `revision_no`, `revision_date`, `drawer_loc`, `program_code`, `drawer_img`, `tools_id`, `stage_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'SF1-123457', 'A', '2025-08-12', 'Rack 1', '', NULL, '', '', 'Live', '2025-08-12 21:08:54', '2025-08-12 21:08:54'),
(2, 'E-134495', 'BA', '2025-08-14', 'R80', '', '1755170258_WhatsApp Image 2025-07-08 at 12.54.09 PM.jpeg', '', '', 'Live', '2025-08-14 23:47:38', '2025-08-14 23:47:38'),
(3, 'F-102717', 'EC', '2025-08-14', 'P8', '', '1756003748_F-102717_0001.jpg', '', '', 'Live', '2025-08-15 00:57:56', '2025-08-24 15:19:08'),
(4, 'E-136977', 'C', '2025-08-24', 'F11', '', '1756003513_E-136977_0001.jpg', '', '', 'Live', '2025-08-24 15:15:13', '2025-08-24 15:15:13'),
(5, 'SA-F-10845', 'B', '2025-08-24', 'I48', '', '1756004433_SA-F-10845_0002.jpg', '', '', 'Live', '2025-08-24 15:30:33', '2025-08-24 15:30:33'),
(6, 'SA-E-56873', '', '2025-08-24', 'M14', '', '1756004733_SA-E-56873_0001.jpg', '', '', 'Live', '2025-08-24 15:35:33', '2025-08-24 15:35:33'),
(7, 'SF1-150411', '', '2025-08-24', 'A125', '', '1756004857_SF1-150411_0001.jpg', '', '', 'Live', '2025-08-24 15:37:37', '2025-08-24 15:37:37'),
(8, 'SF1-151153', '', '2025-08-24', 'A36', '', '1756004989_SF1-151153_0001.jpg', '', '', 'Live', '2025-08-24 15:39:49', '2025-08-24 15:39:49'),
(9, 'E-102712', 'FM', '2025-08-24', 'M21', '', '1756005086_E-102712_0001.jpg', '', '', 'Live', '2025-08-24 15:41:26', '2025-08-24 15:41:26'),
(10, 'SF1-ASL851', 'O', '2025-08-24', 'NIL', '', NULL, '', '', 'Live', '2025-08-24 15:46:14', '2025-08-24 20:19:08'),
(11, 'F-102801', 'B', '2025-08-24', 'M74', '', '1756005775_F-102801_0001.jpg', '', '', 'Live', '2025-08-24 15:52:55', '2025-08-24 15:52:55'),
(12, 'C-104817', 'A', '2025-08-24', 'LOC-01', '', NULL, '', '', 'Live', '2025-08-24 17:39:00', '2025-08-24 17:39:00'),
(13, 'E-144394', '', '2025-08-25', 'N1', '', NULL, '', '', 'Live', '2025-08-26 01:07:26', '2025-08-26 01:07:26'),
(14, 'F-103105', '', '2025-08-25', 'B37', '', NULL, '', '', 'Live', '2025-08-26 01:08:06', '2025-08-26 01:08:43'),
(15, 'G-56984', '', '2025-08-25', 'C1', '', NULL, '', '', 'Live', '2025-08-26 01:09:16', '2025-08-26 01:09:16'),
(16, 'SF-56869', '', '2025-08-25', 'I2', '', NULL, '', '', 'Live', '2025-08-26 01:09:46', '2025-08-26 01:09:46'),
(17, 'E-137305', 'B', '2025-08-25', 'B43', '', NULL, '', '', 'Live', '2025-08-26 01:10:21', '2025-08-26 01:10:35'),
(18, 'E-145872', '', '2025-08-25', 'F14', '', NULL, '', '', 'Live', '2025-08-26 01:12:40', '2025-08-26 01:12:40'),
(19, 'E-103010', 'A', '2025-08-25', 'B72', '', NULL, '', '', 'Live', '2025-08-26 01:13:04', '2025-08-26 01:13:24'),
(20, 'E-136980', 'A', '2025-08-26', 'F53', '', NULL, '', '', 'Live', '2025-08-26 01:13:59', '2025-08-26 01:13:59'),
(21, 'E-144395', 'A', '2025-08-25', 'J3', '', NULL, '', '', 'Live', '2025-08-26 01:14:25', '2025-08-26 01:14:25'),
(22, 'E-138145', 'B', '2025-08-26', 'B17', '', NULL, '', '', 'Live', '2025-08-26 01:14:49', '2025-08-26 01:14:49'),
(23, 'E-103055', 'BA', '2025-08-26', 'P97', '', NULL, '', '', 'Live', '2025-08-26 01:15:13', '2025-08-26 01:15:13'),
(24, 'E-144393', 'A', '2025-08-26', 'N29', '', NULL, '', '', 'Live', '2025-08-26 01:15:40', '2025-08-26 01:15:40'),
(25, 'C-122570', 'A', '2025-08-26', 'D28', '', NULL, '', '', 'Live', '2025-08-26 01:16:10', '2025-08-26 01:16:10'),
(26, 'SF1-143718', '', '2025-08-25', 'A164', '', NULL, '', '', 'Live', '2025-08-26 01:16:47', '2025-08-26 01:16:47'),
(27, 'SF1-112051', '', '2025-08-25', 'A88', '', NULL, '', '', 'Live', '2025-08-26 01:17:19', '2025-08-26 01:17:19'),
(28, 'E-138144', 'A', '2025-08-26', 'B5', '', NULL, '', '', 'Live', '2025-08-26 01:17:42', '2025-08-26 01:17:42'),
(29, 'E-137306', 'B', '2025-08-26', 'B36', '', NULL, '', '', 'Live', '2025-08-26 01:18:17', '2025-08-26 01:18:17'),
(30, 'SF1-00258', '1', '2025-09-08', '3', '[\"a\",\"b\",\"c\"]', NULL, '2,1', '', 'Live', '2025-09-08 12:13:21', '2025-09-08 12:38:11'),
(31, 'SF-12345', 'AB', '2025-09-09', 'Rack 1', '[\"TF-98\",\"TF-99\"]', NULL, '7,6', '1,2', 'Live', '2025-09-09 06:50:50', '2025-09-09 06:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drawing_parameters`
--

CREATE TABLE `tbl_drawing_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `drawing_id` int(11) NOT NULL,
  `di_param` varchar(50) NOT NULL,
  `di_spec` varchar(100) NOT NULL,
  `di_method` varchar(100) NOT NULL,
  `ap_param` varchar(50) NOT NULL,
  `ap_spec` varchar(100) NOT NULL,
  `ap_method` varchar(100) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_drawing_parameters`
--

INSERT INTO `tbl_drawing_parameters` (`id`, `drawing_id`, `di_param`, `di_spec`, `di_method`, `ap_param`, `ap_spec`, `ap_method`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 31, 'OD-1', '0.85', '', 'Radius-1', '0.005', '', 'Deleted', '2025-09-09 06:50:50', '2025-09-10 03:54:30'),
(2, 31, 'OD-1', '0.85', '', 'Radius-1', '0.005', '', 'Deleted', '2025-09-09 08:24:49', '2025-09-10 03:54:30'),
(3, 31, 'OD-1', '0.85', '', 'Radius-1', '0.005', '', 'Deleted', '2025-09-10 03:50:13', '2025-09-10 03:54:30'),
(4, 31, '', '', '', '', '', '', 'Deleted', '2025-09-10 03:50:13', '2025-09-10 03:54:30'),
(5, 31, '', '', '', '', '', '', 'Deleted', '2025-09-10 03:50:13', '2025-09-10 03:54:30'),
(6, 31, 'OD-1', '0.85', '', 'Radius-1', '0.005', '', 'Live', '2025-09-10 03:54:30', '2025-09-10 03:54:30'),
(7, 31, 'OD-2', '0.21', '', 'Radius-2', '0.640', '', 'Live', '2025-09-10 03:54:30', '2025-09-10 03:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT 0,
  `added_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`id`, `date`, `amount`, `category_id`, `employee_id`, `note`, `user_id`, `company_id`, `account_id`, `added_date_time`, `del_status`) VALUES
(1, '2025-07-04', 500, 1, 2, '', 1, 1, 0, '2025-07-04 05:19:14', 'Live'),
(2, '2025-07-22', 1000, 2, 2, 'For purchase materials', 1, 1, 0, '2025-07-23 03:48:38', 'Live'),
(3, '2025-08-18', 1500, 3, 1, '', 1, 1, 0, '2025-08-18 12:08:21', 'Live'),
(4, '2025-08-26', 450, 4, 3, '', 1, 1, 0, '2025-08-26 05:05:20', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_items`
--

CREATE TABLE `tbl_expense_items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_expense_items`
--

INSERT INTO `tbl_expense_items` (`id`, `name`, `description`, `user_id`, `company_id`, `del_status`) VALUES
(1, 'Snacks', '', 1, 1, 'Live'),
(2, 'Transport allowance', '', 1, 1, 'Live'),
(3, 'Maintenance', '', 1, 1, 'Live'),
(4, 'Flower', '', 1, 1, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_finished_products_noninventory`
--

CREATE TABLE `tbl_finished_products_noninventory` (
  `id` int(11) NOT NULL,
  `noninvemtory_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `nin_cost` float(10,2) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_finished_products_productionstage`
--

CREATE TABLE `tbl_finished_products_productionstage` (
  `id` int(11) NOT NULL,
  `productionstage_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `stage_month` int(11) DEFAULT NULL,
  `stage_day` int(11) DEFAULT NULL,
  `stage_hours` int(11) DEFAULT NULL,
  `stage_minute` int(11) DEFAULT NULL,
  `required_time` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_finished_products_productionstage`
--

INSERT INTO `tbl_finished_products_productionstage` (`id`, `productionstage_id`, `finish_product_id`, `stage_month`, `stage_day`, `stage_hours`, `stage_minute`, `required_time`, `company_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 14, 1, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-21 00:38:53', '2025-08-21 00:38:53'),
(2, 13, 1, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-21 00:38:53', '2025-08-21 00:38:53'),
(3, 12, 1, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-21 00:38:53', '2025-08-21 00:38:53'),
(4, 5, 2, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-21 00:41:20', '2025-08-26 01:00:31'),
(5, 14, 2, 0, 0, 0, 12, NULL, 1, 'Deleted', '2025-08-21 00:41:20', '2025-08-26 01:00:31'),
(6, 13, 2, 0, 0, 0, 12, NULL, 1, 'Deleted', '2025-08-21 00:41:20', '2025-08-26 01:00:31'),
(7, 9, 2, 0, 0, 0, 18, NULL, 1, 'Deleted', '2025-08-21 00:41:20', '2025-08-26 01:00:31'),
(8, 5, 3, 0, 0, 0, 2, NULL, 1, 'Deleted', '2025-08-24 17:04:35', '2025-08-25 22:01:30'),
(9, 14, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-24 17:04:35', '2025-08-25 22:01:30'),
(10, 13, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-24 17:04:35', '2025-08-25 22:01:30'),
(11, 12, 3, 0, 0, 0, 5, NULL, 1, 'Deleted', '2025-08-24 17:04:35', '2025-08-25 22:01:30'),
(12, 14, 4, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(13, 13, 4, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(14, 12, 4, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(15, 19, 4, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(16, 20, 4, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(17, 21, 4, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(18, 5, 5, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(19, 14, 5, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(20, 13, 5, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(21, 8, 5, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(22, 19, 5, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(23, 20, 5, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(24, 21, 5, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(25, 14, 6, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(26, 13, 6, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(27, 7, 6, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(28, 9, 6, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(29, 20, 6, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(30, 21, 6, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(31, 7, 7, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(32, 14, 7, 0, 0, 0, 30, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(33, 13, 7, 0, 0, 0, 30, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(34, 20, 7, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(35, 21, 7, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(36, 14, 8, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(37, 13, 8, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(38, 9, 8, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(39, 20, 8, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(40, 21, 8, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(41, 14, 9, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(42, 13, 9, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(43, 12, 9, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(44, 19, 9, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(45, 20, 9, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(46, 21, 9, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(47, 11, 10, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(48, 14, 10, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(49, 13, 10, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(50, 20, 10, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(51, 21, 10, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(52, 5, 11, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(53, 14, 11, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(54, 13, 11, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(55, 20, 11, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(56, 21, 11, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(57, 14, 12, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(58, 13, 12, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(59, 12, 12, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(60, 19, 12, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(61, 20, 12, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(62, 21, 12, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(63, 5, 3, 0, 0, 0, 2, NULL, 1, 'Deleted', '2025-08-25 21:56:41', '2025-08-25 22:01:30'),
(64, 14, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:56:41', '2025-08-25 22:01:30'),
(65, 13, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:56:41', '2025-08-25 22:01:30'),
(66, 12, 3, 0, 0, 0, 5, NULL, 1, 'Deleted', '2025-08-25 21:56:41', '2025-08-25 22:01:30'),
(67, 5, 3, 0, 0, 0, 2, NULL, 1, 'Deleted', '2025-08-25 21:56:56', '2025-08-25 22:01:30'),
(68, 14, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:56:56', '2025-08-25 22:01:30'),
(69, 13, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:56:56', '2025-08-25 22:01:30'),
(70, 12, 3, 0, 0, 0, 5, NULL, 1, 'Deleted', '2025-08-25 21:56:56', '2025-08-25 22:01:30'),
(71, 5, 3, 0, 0, 0, 2, NULL, 1, 'Deleted', '2025-08-25 21:59:29', '2025-08-25 22:01:30'),
(72, 14, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:59:29', '2025-08-25 22:01:30'),
(73, 13, 3, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-25 21:59:29', '2025-08-25 22:01:30'),
(74, 12, 3, 0, 0, 0, 5, NULL, 1, 'Deleted', '2025-08-25 21:59:29', '2025-08-25 22:01:30'),
(75, 5, 3, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-25 22:01:30', '2025-08-25 22:01:30'),
(76, 14, 3, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-25 22:01:30', '2025-08-25 22:01:30'),
(77, 13, 3, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-25 22:01:30', '2025-08-25 22:01:30'),
(78, 12, 3, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-25 22:01:30', '2025-08-25 22:01:30'),
(79, 5, 2, 0, 0, 0, 10, NULL, 1, 'Deleted', '2025-08-26 01:00:21', '2025-08-26 01:00:31'),
(80, 14, 2, 0, 0, 0, 12, NULL, 1, 'Deleted', '2025-08-26 01:00:21', '2025-08-26 01:00:31'),
(81, 13, 2, 0, 0, 0, 12, NULL, 1, 'Deleted', '2025-08-26 01:00:21', '2025-08-26 01:00:31'),
(82, 9, 2, 0, 0, 0, 18, NULL, 1, 'Deleted', '2025-08-26 01:00:21', '2025-08-26 01:00:31'),
(83, 5, 2, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 01:00:31', '2025-08-26 01:00:31'),
(84, 14, 2, 0, 0, 0, 12, NULL, 1, 'Live', '2025-08-26 01:00:31', '2025-08-26 01:00:31'),
(85, 13, 2, 0, 0, 0, 12, NULL, 1, 'Live', '2025-08-26 01:00:31', '2025-08-26 01:00:31'),
(86, 9, 2, 0, 0, 0, 18, NULL, 1, 'Live', '2025-08-26 01:00:31', '2025-08-26 01:00:31'),
(87, 14, 13, 0, 0, 0, 6, NULL, 1, 'Live', '2025-08-26 01:36:15', '2025-08-26 01:36:15'),
(88, 19, 13, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:36:15', '2025-08-26 01:36:15'),
(89, 20, 13, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:36:15', '2025-08-26 01:36:15'),
(90, 21, 13, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:36:15', '2025-08-26 01:36:15'),
(91, 14, 14, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(92, 13, 14, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(93, 19, 14, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(94, 20, 14, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(95, 21, 14, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(96, 14, 15, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(97, 13, 15, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(98, 19, 15, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(99, 20, 15, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(100, 21, 15, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(101, 14, 16, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(102, 13, 16, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(103, 19, 16, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(104, 20, 16, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(105, 21, 16, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(106, 14, 17, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:44:46', '2025-08-26 01:44:46'),
(107, 19, 17, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:44:46', '2025-08-26 01:44:46'),
(108, 20, 17, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:44:46', '2025-08-26 01:44:46'),
(109, 21, 17, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:44:46', '2025-08-26 01:44:46'),
(110, 5, 18, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(111, 14, 18, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(112, 13, 18, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(113, 19, 18, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(114, 20, 18, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(115, 21, 18, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(116, 5, 19, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(117, 14, 19, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(118, 13, 19, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(119, 19, 19, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(120, 20, 19, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(121, 21, 19, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(122, 15, 20, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(123, 14, 20, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(124, 13, 20, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(125, 19, 20, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(126, 20, 20, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(127, 21, 20, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(128, 5, 21, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(129, 14, 21, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(130, 13, 21, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(131, 19, 21, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(132, 20, 21, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(133, 21, 21, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(134, 14, 22, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 01:59:17', '2025-08-26 01:59:17'),
(135, 19, 22, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:59:17', '2025-08-26 01:59:17'),
(136, 20, 22, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:59:17', '2025-08-26 01:59:17'),
(137, 21, 22, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 01:59:17', '2025-08-26 01:59:17'),
(138, 14, 23, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(139, 13, 23, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(140, 19, 23, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(141, 20, 23, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(142, 21, 23, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(143, 11, 24, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(144, 14, 24, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(145, 13, 24, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(146, 19, 24, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(147, 20, 24, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(148, 21, 24, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(149, 14, 25, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(150, 13, 25, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(151, 19, 25, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(152, 20, 25, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(153, 21, 25, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(154, 14, 26, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(155, 13, 26, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(156, 19, 26, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(157, 20, 26, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(158, 21, 26, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(159, 11, 27, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(160, 14, 27, 0, 0, 0, 25, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(161, 19, 27, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(162, 20, 27, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(163, 21, 27, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(164, 5, 28, 0, 0, 0, 10, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(165, 11, 28, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(166, 14, 28, 0, 0, 0, 20, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(167, 19, 28, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(168, 20, 28, 0, 0, 0, 3, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(169, 21, 28, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(170, 14, 29, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(171, 13, 29, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(172, 19, 29, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(173, 20, 29, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(174, 21, 29, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(175, 14, 30, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(176, 13, 30, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(177, 19, 30, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(178, 20, 30, 0, 0, 0, 2, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(179, 21, 30, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(180, 14, 31, 0, 0, 0, 15, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40'),
(181, 13, 31, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40'),
(182, 19, 31, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40'),
(183, 20, 31, 0, 0, 0, 5, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40'),
(184, 21, 31, 0, 0, 0, 1, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_finished_products_rmaterials`
--

CREATE TABLE `tbl_finished_products_rmaterials` (
  `id` int(11) NOT NULL,
  `mat_cat_id` int(11) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `unit_price` float(10,2) DEFAULT NULL,
  `consumption` float(10,2) DEFAULT NULL,
  `total_cost` float(10,2) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_finished_products_rmaterials`
--

INSERT INTO `tbl_finished_products_rmaterials` (`id`, `mat_cat_id`, `rmaterials_id`, `finish_product_id`, `unit_price`, `consumption`, `total_cost`, `company_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 9, 3, 1, NULL, NULL, NULL, 1, 'Live', '2025-08-21 00:38:53', '2025-08-21 00:38:53'),
(2, 9, 4, 2, NULL, NULL, NULL, 1, 'Deleted', '2025-08-21 00:41:20', '2025-08-26 01:00:31'),
(3, 13, 11, 3, NULL, NULL, NULL, 1, 'Deleted', '2025-08-24 17:04:35', '2025-08-25 22:01:30'),
(4, 7, 9, 4, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:13:11', '2025-08-24 17:13:11'),
(5, 19, 5, 5, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:16:57', '2025-08-24 17:16:57'),
(6, 18, 6, 6, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:22:43', '2025-08-24 17:22:43'),
(7, 20, 7, 7, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:25:46', '2025-08-24 17:25:46'),
(8, 14, 10, 8, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:29:47', '2025-08-24 17:29:47'),
(9, 12, 12, 9, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:32:27', '2025-08-24 17:32:27'),
(10, 14, 10, 10, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:34:38', '2025-08-24 17:34:38'),
(11, 11, 13, 11, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:37:16', '2025-08-24 17:37:16'),
(12, 10, 14, 12, NULL, NULL, NULL, 1, 'Live', '2025-08-24 17:41:00', '2025-08-24 17:41:00'),
(13, 13, 11, 3, NULL, NULL, NULL, 1, 'Deleted', '2025-08-25 21:56:41', '2025-08-25 22:01:30'),
(14, 13, 11, 3, NULL, NULL, NULL, 1, 'Deleted', '2025-08-25 21:56:56', '2025-08-25 22:01:30'),
(15, 13, 11, 3, NULL, NULL, NULL, 1, 'Deleted', '2025-08-25 21:59:29', '2025-08-25 22:01:30'),
(16, 13, 11, 3, NULL, NULL, NULL, 1, 'Live', '2025-08-25 22:01:30', '2025-08-25 22:01:30'),
(17, 9, 4, 2, NULL, NULL, NULL, 1, 'Deleted', '2025-08-26 01:00:21', '2025-08-26 01:00:31'),
(18, 9, 4, 2, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:00:31', '2025-08-26 01:00:31'),
(19, 34, 22, 13, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:36:15', '2025-08-26 01:36:15'),
(20, 34, 23, 14, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:39:44', '2025-08-26 01:39:44'),
(21, 34, 24, 15, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:41:53', '2025-08-26 01:41:53'),
(22, 34, 25, 16, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:43:05', '2025-08-26 01:43:05'),
(23, 34, 26, 17, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:44:46', '2025-08-26 01:44:46'),
(24, 22, 27, 18, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:49:33', '2025-08-26 01:49:33'),
(25, 24, 28, 19, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:51:24', '2025-08-26 01:51:24'),
(26, 34, 29, 20, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:56:10', '2025-08-26 01:56:10'),
(27, 25, 30, 21, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:57:50', '2025-08-26 01:57:50'),
(28, 34, 31, 22, NULL, NULL, NULL, 1, 'Live', '2025-08-26 01:59:17', '2025-08-26 01:59:17'),
(29, 34, 32, 23, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:01:14', '2025-08-26 02:01:14'),
(30, 18, 33, 24, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:02:54', '2025-08-26 02:02:54'),
(31, 34, 34, 25, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:04:59', '2025-08-26 02:04:59'),
(32, 34, 35, 26, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:06:52', '2025-08-26 02:06:52'),
(33, 34, 21, 27, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:09:12', '2025-08-26 02:09:12'),
(34, 10, 36, 28, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:13:11', '2025-08-26 02:13:11'),
(35, 34, 20, 29, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:15:07', '2025-08-26 02:15:07'),
(36, 34, 19, 30, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:16:41', '2025-08-26 02:16:41'),
(37, 34, 18, 31, NULL, NULL, NULL, 1, 'Live', '2025-08-26 02:17:40', '2025-08-26 02:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_finish_products`
--

CREATE TABLE `tbl_finish_products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `customer_code` varchar(30) DEFAULT NULL,
  `hsn_sac_no` varchar(50) DEFAULT NULL,
  `size` float DEFAULT NULL,
  `danish_sin_no` varchar(20) DEFAULT NULL,
  `rev` varchar(30) DEFAULT NULL,
  `operation` varchar(50) DEFAULT NULL,
  `drawer_no` varchar(50) DEFAULT NULL,
  `scope` text DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `stock_method` varchar(50) DEFAULT NULL,
  `unit` varchar(40) DEFAULT NULL,
  `rmcost_total` float(10,2) DEFAULT NULL,
  `noninitem_total` float(10,2) DEFAULT NULL,
  `total_cost` float(10,2) DEFAULT NULL,
  `profit_margin` float DEFAULT NULL,
  `sale_price` float(10,2) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `tax_type` varchar(10) DEFAULT NULL,
  `inter_state` varchar(1) DEFAULT 'N',
  `tax_information` text DEFAULT NULL,
  `current_total_stock` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_finish_products`
--

INSERT INTO `tbl_finish_products` (`id`, `code`, `added_by`, `name`, `category`, `customer_code`, `hsn_sac_no`, `size`, `danish_sin_no`, `rev`, `operation`, `drawer_no`, `scope`, `description`, `remarks`, `stock_method`, `unit`, `rmcost_total`, `noninitem_total`, `total_cost`, `profit_margin`, `sale_price`, `company_id`, `photo`, `tax_type`, `inter_state`, `tax_information`, `current_total_stock`, `created_at`, `updated_at`, `del_status`) VALUES
(1, '10063076', 1, 'CAP L GRP', 6, NULL, '7325', NULL, '', 'BA', 'M/cg', 'E-134495', 'Maching as per drawing', 'CAP L GRP', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 5, '2025-08-21 00:38:53', '2025-08-25 18:19:53', 'Live'),
(2, 'T19066', 1, 'CAP', 6, '', '', NULL, '', 'EC', 'M/cg', 'F-102717', 'Maching as per drawing', 'CAP', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-21 00:41:20', '2025-08-26 01:00:31', 'Live'),
(3, 'T14122', 1, 'SPINDLE POINT', 9, '', '', NULL, 'DCH 001-009', 'REVISION', '', 'E-102712', 'FULL MACHINING', 'DS', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 9, '2025-08-24 17:04:35', '2025-08-26 17:53:23', 'Live'),
(4, 'S87477', 1, 'DUIDE ASSY', 11, NULL, '', NULL, '', '', '', 'SA-E-56873', '', 'DS-01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 10, '2025-08-24 17:13:11', '2025-08-24 19:12:14', 'Live'),
(5, 'T18401-A16-SF', 1, 'DISC INSERT', 14, NULL, '', NULL, '', '', '', 'E-136977', 'MACHINIG AS PER DRAWING', 'DI-02', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 6, '2025-08-24 17:16:57', '2025-08-24 19:18:35', 'Live'),
(6, '11131178', 1, 'CAP-01', 6, NULL, '', NULL, '', '', '', 'F-102717', '', 'CAP-DS 01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 37, '2025-08-24 17:22:43', '2025-08-24 19:50:41', 'Live'),
(7, 'S45137-SF', 1, 'DISC ASSY', 13, NULL, '', NULL, '', '', '', 'SA-F-10845', '', 'DSSY-01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-24 17:25:46', '2025-08-24 19:49:57', 'Live'),
(8, '150411-I-SF', 1, 'NOZZLE', 8, NULL, '', NULL, '', '', '', 'SF1-150411', '', 'NZ-01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-24 17:29:47', '2025-08-24 19:50:13', 'Live'),
(9, 'T19285-SF1', 1, 'NOZZLE CRBY STD', 8, NULL, '', NULL, '', '', '', 'SF1-ASL851', '', 'NZ CR', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 2, '2025-08-24 17:32:27', '2025-08-24 19:50:28', 'Live'),
(10, '151153-I-SF', 1, 'NOZZLE IBR;2500#RTJ', 8, NULL, '', NULL, '', '', '', 'SF1-151153', '', 'NZ RTJ-01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-24 17:34:38', '2025-08-24 19:28:00', 'Live'),
(11, '104865', 1, 'SPINDLE POINT-01', 9, NULL, '', NULL, '', '', '', 'F-102801', '', 'SP-02', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-24 17:37:16', '2025-08-24 19:06:45', 'Live'),
(12, '104817-SF', 1, 'NOZZLE CROBY STD', 8, NULL, '', NULL, '', '', '', 'C-104817', '', 'NZ-03', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-24 17:41:00', '2025-08-24 19:00:50', 'Live'),
(13, '144394', 1, 'DISC HOLDER RETAINER', 17, NULL, '', NULL, '', '', '', 'E-144394', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 2, '2025-08-26 01:36:15', '2025-09-11 13:09:00', 'Live'),
(14, '140712', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'F-103105', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:39:44', '2025-08-26 01:39:44', 'Live'),
(15, '56984', 1, 'GUIDE RING', 16, NULL, '', NULL, '', '', '', 'G-56984', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:41:53', '2025-08-26 01:41:53', 'Live'),
(16, '100562-SF', 1, 'DISC HOLDER', 17, NULL, '', NULL, '', '', '', 'SF-56869', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:43:05', '2025-08-26 01:43:05', 'Live'),
(17, '10063058', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-137305', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:44:46', '2025-08-26 01:44:46', 'Live'),
(18, '139762', 1, 'SPINDLE POINT', 9, NULL, '', NULL, '', '', '', 'F-102801', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:49:33', '2025-08-26 01:49:33', 'Live'),
(19, 'T18194-790-SF', 1, 'DISC INSERT', 14, NULL, '', NULL, '', '', '', 'E-145872', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:51:24', '2025-08-26 01:51:24', 'Live'),
(20, '103010', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-103010', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:56:10', '2025-08-26 01:56:10', 'Live'),
(21, 'T13502-734-SF', 1, 'DISC INSERT', 14, NULL, '', NULL, '', '', '', 'E-136980', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:57:50', '2025-08-26 01:57:50', 'Live'),
(22, '144395', 1, 'LIFT STOP', 18, NULL, '', NULL, '', '', '', 'E-144395', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 01:59:17', '2025-08-26 01:59:17', 'Live'),
(23, '138145', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-138145', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:01:14', '2025-08-26 02:01:14', 'Live'),
(24, '111311190', 1, 'CAP', 6, NULL, '', NULL, '', '', '', 'E-103055', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 1, '2025-08-26 02:02:54', '2025-09-04 09:36:37', 'Live'),
(25, '144393', 1, 'DISC HOLDER RETAINER', 15, NULL, '', NULL, '', '', '', 'E-144393', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:04:59', '2025-08-26 02:04:59', 'Live'),
(26, '122570', 1, 'GUIDE', 19, NULL, '', NULL, '', '', '', 'C-122570', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:06:52', '2025-08-26 02:06:52', 'Live'),
(27, '143718-K43-SF', 1, 'NOZZLE CRBY STD', 8, NULL, '', NULL, '', '', '', 'SF1-143718', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:09:12', '2025-08-26 02:09:12', 'Live'),
(28, '112051Y1-341-SF', 1, 'NOZZLE FORGED', 8, NULL, '', NULL, '', '', '', 'SF1-112051', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:13:11', '2025-08-26 02:13:11', 'Live'),
(29, '138144', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-138144', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:15:07', '2025-08-26 02:15:07', 'Live'),
(30, '137300', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-137306', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, NULL, '2025-08-26 02:16:41', '2025-08-26 02:16:41', 'Live'),
(31, '137305', 1, 'NOZZLE RING', 7, NULL, '', NULL, '', '', '', 'E-137305', 'MACHINING AS PER DRAWING', 'MACHINING AS PER DRAWING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'N', NULL, 2, '2025-08-26 02:17:40', '2025-09-11 09:34:15', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fnunits`
--

CREATE TABLE `tbl_fnunits` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fpcategory`
--

CREATE TABLE `tbl_fpcategory` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_fpcategory`
--

INSERT INTO `tbl_fpcategory` (`id`, `company_id`, `name`, `description`, `created_at`, `updated_at`, `del_status`) VALUES
(1, NULL, 'Steel Components', '', '2025-06-20 18:50:40', '2025-06-20 18:50:40', 'Live'),
(2, NULL, 'Machined Parts', '', '2025-06-20 18:50:58', '2025-06-20 18:50:58', 'Live'),
(3, NULL, 'Precision Fittings', '', '2025-06-20 18:51:21', '2025-06-20 18:51:21', 'Live'),
(4, NULL, 'Flexible Molds', '', '2025-07-03 21:09:39', '2025-07-03 21:09:39', 'Live'),
(5, NULL, 'Furniture', NULL, '2025-07-21 22:02:33', '2025-07-21 22:02:33', 'Live'),
(6, NULL, 'CAP', 'CATEGORY DISCRIPTION', '2025-07-28 18:57:25', '2025-07-28 19:02:59', 'Live'),
(7, NULL, 'Nozzle Ring', '', '2025-07-29 20:06:03', '2025-07-29 20:06:03', 'Live'),
(8, NULL, 'NOZZLE', '', '2025-08-24 01:18:59', '2025-08-24 01:18:59', 'Live'),
(9, NULL, 'SPINDLE POINT', '', '2025-08-24 01:19:22', '2025-08-24 01:19:22', 'Live'),
(10, NULL, 'SPINDLE ROD', '', '2025-08-24 01:19:43', '2025-08-24 01:19:43', 'Live'),
(11, NULL, 'GUIDE ASSY', '', '2025-08-24 01:20:08', '2025-08-24 01:20:08', 'Live'),
(12, NULL, 'PROTECTOR BOTTOM HALF', '', '2025-08-24 01:20:34', '2025-08-24 01:20:34', 'Live'),
(13, NULL, 'DISC ASSY', '', '2025-08-24 01:20:46', '2025-08-24 01:20:46', 'Live'),
(14, NULL, 'DISC INSERT', 'DI-DS', '2025-08-24 17:14:44', '2025-08-24 17:14:44', 'Live'),
(15, NULL, 'DISC HOLDER RETAINER', '', '2025-08-26 01:02:56', '2025-08-26 01:02:56', 'Live'),
(16, NULL, 'GUIDE RING', '', '2025-08-26 01:03:29', '2025-08-26 01:03:29', 'Live'),
(17, NULL, 'DISC HOLDER', '', '2025-08-26 01:03:40', '2025-08-26 01:03:40', 'Live'),
(18, NULL, 'LIFT STOP', '', '2025-08-26 01:04:19', '2025-08-26 01:04:19', 'Live'),
(19, NULL, 'GUIDE', '', '2025-08-26 01:04:39', '2025-08-26 01:04:51', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fpwastes`
--

CREATE TABLE `tbl_fpwastes` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `responsible_person` int(11) DEFAULT NULL,
  `total_loss` float(10,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_production_cost` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fpwastes_fp`
--

CREATE TABLE `tbl_fpwastes_fp` (
  `id` int(11) NOT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `fp_waste_amount` decimal(11,0) DEFAULT NULL,
  `last_production_cost` decimal(11,0) DEFAULT NULL,
  `last_purchase_price` decimal(11,0) DEFAULT NULL,
  `loss_amount` decimal(11,0) DEFAULT NULL,
  `fpwaste_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inpection_params`
--

CREATE TABLE `tbl_inpection_params` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inspect_id` int(11) NOT NULL,
  `di_param` varchar(30) DEFAULT NULL,
  `di_spec` varchar(100) DEFAULT NULL,
  `di_method` varchar(100) DEFAULT NULL,
  `ap_param` varchar(30) DEFAULT NULL,
  `ap_spec` varchar(100) DEFAULT NULL,
  `ap_method` varchar(100) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inpection_params`
--

INSERT INTO `tbl_inpection_params` (`id`, `inspect_id`, `di_param`, `di_spec`, `di_method`, `ap_param`, `ap_spec`, `ap_method`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'OD-1', '0.84', 'Tool', 'Radius', '0.005', '', 'Live', '2025-08-12 21:25:14', '2025-08-12 21:25:14'),
(2, 1, 'OD-2', '0.52', 'Field', 'Radius-1', '0.009', '', 'Live', '2025-08-12 21:25:14', '2025-08-12 21:25:14'),
(3, 1, 'OD-3', '0.14', '', '', '', '', 'Live', '2025-08-12 21:25:14', '2025-08-12 21:25:14'),
(4, 1, 'Length - 1', '0.66', '', '', '', '', 'Live', '2025-08-12 21:25:14', '2025-08-12 21:25:14'),
(5, 2, 'OD-1', '0.813', '', 'Radius-1', '0.22', '', 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(6, 2, 'OD-2', '0.987/0.985', '', 'Radius-2', '0.11', '', 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(7, 2, 'OD-3', '1.064', '', 'Taper', '0.11', '', 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(8, 2, 'ID-1', '0.250-20UNC-2B', '', '', '', '', 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(9, 2, 'INNER THREAD', '0.87', '', '', '', '', 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(10, 3, 'ID-1', '2.500/2.510', '', 'VISUAL', '-', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(11, 3, 'ID-2', '.125', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(12, 3, 'ID-3', '.625', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(13, 3, 'ID-4', '4.188/4.15', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(14, 3, 'ID-5', '.719', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(15, 3, 'THICKNESS', '.719', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(16, 3, 'LENGTH-2', '.250', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(17, 3, 'LENGTH-3', '.063 APPROX', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(18, 3, 'TOTAL LENGTH', '11.469', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(19, 3, 'BCD', '5.375', '', '', '', '', 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(20, 4, 'ID -1', '2.00', '', 'VISUAL', '1', '', 'Live', '2025-08-15 01:04:05', '2025-08-15 01:04:05'),
(21, 4, 'ID-2', '1.656', '', '', '', '', 'Live', '2025-08-15 01:04:05', '2025-08-15 01:04:05'),
(22, 4, 'ID-3', '1.500', '', '', '', '', 'Live', '2025-08-15 01:04:05', '2025-08-15 01:04:05'),
(23, 5, 'SERIAL NO', '-', '-', 'TAPER', '140 DEG', 'EYE', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(24, 5, 'OD-1', '1.125\"', 'VERNIER', 'RADIUS', '0.565 \"', 'EYE', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(25, 5, 'OD-2', '0.562\"', 'VERNIER', 'VISUAL', 'NIL', 'EYE', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(26, 5, 'ID-1', '0.781\" (+0.015 / -0.0)', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(27, 5, 'ID THREAD', '0.500\"-20 UNF -2B', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(28, 5, 'LENGTH-1', '0.437\"', 'VERINER', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(29, 5, 'LENGTH-2', '0.937\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(30, 5, 'LENGTH MIN', '0.593\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(31, 5, 'LENGTH-3', '2.031\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(32, 6, 'SERIAL NO', '-', '-', 'RADIUS-1', '1.000\"', 'EYE', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(33, 6, 'OD-1', '3.625\"', 'VERNIER', 'RADIUS-2', '0.125\"', 'EYE', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(34, 6, 'OD-2', '2.469\"', 'VERNIER', 'TAPER', '3 DEG', 'EYE', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(35, 6, 'ID-1', '2.000\"', 'VERNIER', 'CHAMFER', '0.031 X 45 DEG', 'EYE', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(36, 6, 'ID-2', '1.121\"', 'VERNIER', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(37, 6, 'THICKNESS', '0.866\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(38, 6, 'LENGTH-1', '6.048\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(39, 6, 'LENGTH-2', '4.750 / 4.625', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(40, 7, 'SERIAL NO', '-', '-', 'CHAMFER', '45 DEG', 'EYE', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(41, 7, 'OD-1', '0.297\"', 'VERNIER', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(42, 7, 'OD-2', '0.375\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(43, 7, 'ID-1', '0.1405\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(44, 7, 'OD-3', '0.156\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(45, 7, 'MAJOR DIA', '0.3667\" / 0.3739\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(46, 7, 'OD THREAD', '0.375\" -24 UNF-2A', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(47, 7, 'LENGTH F.T-1', '1.750\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(48, 7, 'LENGTH F.T-2', '0.844\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(49, 7, 'LENGTH-1', '0.438\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(50, 7, 'LENGTH-2', '0.344\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(51, 7, 'LENGTH-3', '0.031\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(52, 7, 'TOTAL LENGTH', '10.438\" (+/- 0.031)', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(53, 8, 'SERIAL', '-', '-', 'RADIUS-1', '1.000\"', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(54, 8, 'OD-1', '3.969\"', 'VERNIER', 'RADIUS-2', '0.063\" / 0.031\"', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(55, 8, 'OD-2', '6.656\" / 6.625\"', 'VERNIER', 'CHAMFER', '0.031\" X 45 DEG', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(56, 8, 'ID-1', '1.902\"', 'VERNIER', 'TAPER-1', '15 DEG', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(57, 8, 'ID-2', '5.005\" / 4.995\"', 'VERNIER', 'TAPER-2', '23 DEG +/- 5 DEG', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(58, 8, 'THICKNESS', '0.830\"', 'VERNIER', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(59, 8, 'LENGTH-1', '9.455\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(60, 8, 'LENGTH-2', '6.202\" / 6.077\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(61, 8, 'WIDTH', '0.539\" / 0.523\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(62, 8, 'DEPTH', '0.391\" / 0.375\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(63, 8, 'ID-3', '3.000\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(64, 9, 'SERIAL NO', '-', '-', 'RADIUS-1', '0.125\"', 'EYE', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(65, 9, 'OD-1', '3.344\"', 'VERNIER', 'RADIUS-2', '1.250\"', 'EYE', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(66, 9, 'OD-2', '5.406\" / 5.375\"', 'VERNIER', 'RADIUS-3', '0.031\" MAX', 'EYE', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(67, 9, 'ID-1', '1.640\"', 'VERNIER', 'CHAMFER', '0.031\" X 45 DEG', 'EYE', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(68, 9, 'ID-2', '1.875\"', 'VERNIER', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(69, 9, 'ID-3', '2.500\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(70, 9, 'ID-4', '4.255\" / 4.245\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(71, 9, 'THICKNESS', '0.830\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(72, 9, 'WIDTH', '0.469\" +/- 0.008', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(73, 9, 'DEPTH', '0.313\" (+0.016 / -0.000)', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(74, 9, 'LENGTH-1', '9.330\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(75, 9, 'LENGTH-2', '6.801\" / 6.676\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(76, 10, 'SERIAL NO', '-', '-', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(77, 10, 'OD-1', '3.553\" / 3.551\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(78, 10, 'OD-2', '3.539\" / 3.534\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(79, 10, 'OD-3', '3.381\" / 3.382\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(80, 10, 'ID-1', '1.031\" / 1.032\"', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(81, 10, 'ID-2', '3.384\" / 3.386\"', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(82, 10, 'ID-3', '2.362\" / 2.366\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(83, 10, 'ID-4', '0.4995\" / 0.5005\"', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(84, 10, 'ID-5', '1.062\" / 1.063\"', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(85, 10, 'LENGTH-1', '2.062\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(86, 10, 'LENGTH-2', '0.062\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(87, 10, 'LENGTH-3', '0.593\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(88, 10, 'LENGTH-4', '1.250\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(89, 10, 'LENGTH-5', '0.500\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(90, 10, 'LENGTH-6', '0.514\" / 0.515\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(91, 11, 'SERIAL NO', '-', '-', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(92, 11, 'OD-1', '2.000\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(93, 11, 'ID-1', '1.656\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(94, 11, 'ID MINOR DIA', '1.553\" / 1.535\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(95, 11, 'ID THREAD', '1.625\"-12 UN-2B', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(96, 11, 'THICKNESS', '1.605\" / 1.625\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(97, 11, 'LENGTH-1', '7.063\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(98, 11, 'LENGTH-2', '5.750\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(99, 11, 'LENGTH-3', '1.625\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(100, 11, 'LENGTH-4', '1.125\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(101, 11, 'LENGTH-5', '2.500\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(102, 11, 'WIDTH', '0.750\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(103, 12, 'SERIAL NO', '-', '-', 'TAPER', '45 DEG', 'EYE', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(104, 12, 'OD-1', '0.469\"', 'VERNIER', 'RADIUS-1', '0.005\"', 'EYE', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(105, 12, 'OD-2', '0.661\" / 0.665\"', 'VERNIER', 'RADIUS-2', '0.005\" / 0.015\"', 'EYE', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(106, 12, 'OD-3', '0.560\" / 0.564\"', 'VERNIER', 'SPHER', '0.380\" / 0.370\"', 'EYE', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(107, 12, 'ID-1', '0.583\" / 0.587\"', 'VERNIER', 'VISUAL', '-', 'EYE', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(108, 12, 'DRILL DIA', '0.156\"', 'VERNIER', 'RESULT', '-', '-', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(109, 12, 'ID THREAD', 'NO.10-24 UNC-2B', 'GAUGE', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(110, 12, 'TOTAL LENGTH', '0.453\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(111, 12, 'LENGTH-1', '0.189\" / 0.193\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(112, 12, 'LENGTH-2', '0.099\" / 0.104\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(113, 12, 'LENGTH F.T-1', '0.094\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(114, 12, 'DRILL LENGTH', '0.219\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(115, 12, 'LENGTH-3', '0.110\" / 0.114\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(116, 12, 'LENGTH-4', '0.021\" / 0.023\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(117, 12, 'LENGTH-5', '0.340\" / 0.342\"', 'VERNIER', '', '', '', 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(118, 13, 'OD-1', '0.254', '', 'Radius-1', '0.21', '', 'Live', '2025-09-04 09:40:22', '2025-09-04 09:40:22'),
(119, 13, 'OD-2', '0.11', '', 'Radius Spher', '45º', '', 'Live', '2025-09-04 09:40:22', '2025-09-04 09:40:22'),
(120, 13, 'length', '0.324', '', '', '', '', 'Live', '2025-09-04 09:40:22', '2025-09-04 09:40:22'),
(121, 14, 'OD-1', '0.25', '', 'RADIUS-1', '0.640', '', 'Live', '2025-09-11 09:31:59', '2025-09-11 09:31:59'),
(122, 15, 'Length-1', '0.813', '', 'Radius Spher', '45', '', 'Live', '2025-09-11 13:13:32', '2025-09-11 13:13:32'),
(123, 16, 'OD-1', '0.85', '', 'Radius-1', '0.640', '', 'Live', '2025-09-11 13:15:51', '2025-09-11 13:15:51'),
(124, 16, 'Length-1', '0.813', '', 'Radius Spher', '45', '', 'Live', '2025-09-11 13:15:51', '2025-09-11 13:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inspections`
--

CREATE TABLE `tbl_inspections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mat_type` int(11) NOT NULL,
  `ins_type` int(11) DEFAULT NULL,
  `mat_id` int(11) NOT NULL,
  `mat_code` varchar(20) NOT NULL,
  `drawer_id` int(11) NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inspections`
--

INSERT INTO `tbl_inspections` (`id`, `mat_type`, `ins_type`, `mat_id`, `mat_code`, `drawer_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 'MAT0001', 1, 'Live', '2025-08-12 21:25:14', '2025-08-12 21:25:14'),
(2, 1, 0, 2, 'MAT0002', 1, 'Live', '2025-08-14 01:27:12', '2025-08-14 01:27:12'),
(3, 1, 0, 3, 'FRCT1074-E005', 2, 'Live', '2025-08-14 23:58:41', '2025-08-14 23:58:41'),
(4, 1, 0, 4, 'ROD', 3, 'Live', '2025-08-15 01:04:05', '2025-08-15 01:04:05'),
(5, 1, 0, 13, '360041250 ROD', 11, 'Live', '2025-08-24 16:03:07', '2025-08-24 16:03:07'),
(6, 1, 0, 12, '54504M100 ROD', 10, 'Live', '2025-08-24 16:09:17', '2025-08-24 16:09:17'),
(7, 1, 0, 11, '826040625 ROD', 9, 'Live', '2025-08-24 16:15:08', '2025-08-24 16:15:08'),
(8, 1, 0, 10, 'FRCT10197-I69', 8, 'Live', '2025-08-24 16:23:03', '2025-08-24 16:23:03'),
(9, 1, 0, 10, 'FRCT10197-I69', 7, 'Live', '2025-08-24 16:29:56', '2025-08-24 16:29:56'),
(10, 1, 0, 7, 'FRC125564', 5, 'Live', '2025-08-24 16:36:38', '2025-08-24 16:36:38'),
(11, 1, 0, 6, 'FRGM056191-331', 3, 'Live', '2025-08-24 16:40:55', '2025-08-24 16:40:55'),
(12, 1, 0, 5, 'T01041000-A16', 4, 'Live', '2025-08-24 16:48:00', '2025-08-24 16:48:00'),
(13, 1, 0, 33, 'FRGM100145-331', 4, 'Live', '2025-09-04 09:40:22', '2025-09-04 09:40:22'),
(14, 1, 0, 18, 'FRC142695', 1, 'Live', '2025-09-11 09:31:59', '2025-09-11 09:31:59'),
(15, 1, 0, 34, 'FRC143774', 1, 'Live', '2025-09-11 13:13:32', '2025-09-11 13:13:32'),
(16, 1, 0, 22, 'FRC144961', 2, 'Live', '2025-09-11 13:15:51', '2025-09-11 13:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inspection_approves`
--

CREATE TABLE `tbl_inspection_approves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inspect_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `inspected_by` int(11) NOT NULL,
  `checked_by` int(11) NOT NULL,
  `remarks` varchar(150) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inspection_approves`
--

INSERT INTO `tbl_inspection_approves` (`id`, `inspect_id`, `manufacture_id`, `mat_id`, `inspected_by`, `checked_by`, `remarks`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 22, 5, 5, '', '2', 'Live', '2025-09-11 13:16:36', '2025-09-11 13:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inspection_observed_dimensions`
--

CREATE TABLE `tbl_inspection_observed_dimensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `set_no` int(11) NOT NULL,
  `inspect_id` int(11) NOT NULL,
  `inspect_param_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `di_observed_dimension` varchar(30) NOT NULL,
  `ap_observed_dimension` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inspection_observed_dimensions`
--

INSERT INTO `tbl_inspection_observed_dimensions` (`id`, `set_no`, `inspect_id`, `inspect_param_id`, `manufacture_id`, `mat_id`, `di_observed_dimension`, `ap_observed_dimension`, `created_at`, `updated_at`) VALUES
(1, 1, 16, 123, 1, 22, '0.55', '0.123', '2025-09-11 13:16:16', '2025-09-11 13:16:16'),
(2, 1, 16, 124, 1, 22, '0.52', '0.22', '2025-09-11 13:16:16', '2025-09-11 13:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inspection_report_files`
--

CREATE TABLE `tbl_inspection_report_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instruments`
--

CREATE TABLE `tbl_instruments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `instrument_name` varchar(50) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `owner_type` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `range` varchar(50) NOT NULL,
  `accuracy` varchar(25) NOT NULL,
  `make` varchar(25) NOT NULL,
  `calibration_due` date DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_instruments`
--

INSERT INTO `tbl_instruments` (`id`, `code`, `instrument_name`, `type`, `category`, `unit`, `owner_type`, `customer_id`, `range`, `accuracy`, `make`, `calibration_due`, `remarks`, `del_status`, `created_at`, `updated_at`) VALUES
(1, '19901', 'Ruler', 2, 2, 2, 2, 5, '2.5', '80', '70', '2025-09-10', 'OK', 'Live', '2025-09-10 04:14:33', '2025-09-10 04:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instrument_categories`
--

CREATE TABLE `tbl_instrument_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_instrument_categories`
--

INSERT INTO `tbl_instrument_categories` (`id`, `type`, `category`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Weight', 'Live', '2025-09-10 03:55:04', '2025-09-10 03:57:56'),
(2, 2, 'Length', 'Live', '2025-09-10 03:58:31', '2025-09-10 03:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_card_entries`
--

CREATE TABLE `tbl_job_card_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mail_settings`
--

CREATE TABLE `tbl_mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_driver` varchar(50) DEFAULT NULL,
  `mail_host` varchar(100) DEFAULT NULL,
  `mail_port` smallint(6) DEFAULT NULL,
  `mail_encryption` varchar(50) DEFAULT NULL,
  `mail_username` varchar(100) DEFAULT NULL,
  `mail_password` varchar(100) DEFAULT NULL,
  `mail_from` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mail_settings`
--

INSERT INTO `tbl_mail_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_encryption`, `mail_username`, `mail_password`, `mail_from`, `from_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'smtp', '*********', 0, 'tls', '*********', '*********', '*********', '*********', NULL, NULL, NULL, '2024-07-23 00:07:18', '2024-07-23 00:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_main_modules`
--

CREATE TABLE `tbl_main_modules` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `del_status` varchar(15) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufactures`
--

CREATE TABLE `tbl_manufactures` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `manufacture_type` varchar(50) DEFAULT NULL,
  `manufacture_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_order_id` int(11) DEFAULT NULL,
  `stk_mat_type` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `drawer_no` varchar(50) DEFAULT NULL,
  `rev` varchar(30) DEFAULT NULL,
  `operation` varchar(30) DEFAULT NULL,
  `dc_no` varchar(50) DEFAULT NULL,
  `stock_method` varchar(20) DEFAULT NULL,
  `stage_name` varchar(20) DEFAULT NULL,
  `product_quantity` float DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `stage_counter` int(11) NOT NULL DEFAULT 0,
  `consumed_time` varchar(50) DEFAULT NULL,
  `expiry_days` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `complete_date` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `mrmcost_total` float DEFAULT NULL,
  `mnoninitem_total` float DEFAULT NULL,
  `mtotal_cost` float DEFAULT NULL,
  `mprofit_margin` float DEFAULT NULL,
  `msale_price` float DEFAULT NULL,
  `tax_type` varchar(10) DEFAULT NULL,
  `tax_value` decimal(10,0) DEFAULT NULL,
  `tax_information` text DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `partially_done_quantity` int(9) DEFAULT 0,
  `production_loss` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_manufactures`
--

INSERT INTO `tbl_manufactures` (`id`, `reference_no`, `manufacture_type`, `manufacture_status`, `customer_id`, `customer_order_id`, `stk_mat_type`, `product_id`, `drawer_no`, `rev`, `operation`, `dc_no`, `stock_method`, `stage_name`, `product_quantity`, `batch_no`, `stage_counter`, `consumed_time`, `expiry_days`, `start_date`, `complete_date`, `expiry_date`, `mrmcost_total`, `mnoninitem_total`, `mtotal_cost`, `mprofit_margin`, `msale_price`, `tax_type`, `tax_value`, `tax_information`, `note`, `file`, `partially_done_quantity`, `production_loss`, `created_at`, `added_by`, `updated_by`, `updated_at`, `del_status`) VALUES
(1, 'L00000001', NULL, 'done', 2, 1, 1, 13, 'E-144394', '', '', NULL, NULL, 'PACKING', 2, '0', 4, ' Hour(s):  Min.(s) :18', 0, '2025-09-11', '2025-09-11', NULL, 0, 0, 0, 0, 0, '0', 0, NULL, '', NULL, 0, NULL, '2025-09-11 12:56:29', 1, NULL, '2025-09-11 13:09:00', 'Live'),
(2, 'S00000001', NULL, 'draft', 2, 3, 1, 31, 'E-137305', '', '', NULL, NULL, 'Finishing -1', 1, '0', 1, ' Hour(s): 0 Min.(s) :27', 0, '2025-09-12', NULL, NULL, 0, 0, 0, 0, 0, '0', 0, NULL, '', NULL, 0, NULL, '2025-09-11 13:07:46', 1, NULL, '2025-09-11 13:07:47', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufactures_noninventory`
--

CREATE TABLE `tbl_manufactures_noninventory` (
  `id` int(11) NOT NULL,
  `noninvemtory_id` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `nin_cost` float(10,2) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufactures_rmaterials`
--

CREATE TABLE `tbl_manufactures_rmaterials` (
  `id` int(11) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `stock_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `unit_price` float(10,2) DEFAULT NULL,
  `consumption` float(10,2) DEFAULT NULL,
  `total_cost` float(10,2) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_manufactures_rmaterials`
--

INSERT INTO `tbl_manufactures_rmaterials` (`id`, `rmaterials_id`, `manufacture_id`, `stock_id`, `stock`, `unit_price`, `consumption`, `total_cost`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 22, 1, 1, 4, NULL, 4.00, NULL, 'Deleted', '2025-09-11 12:56:29', '2025-09-11 13:09:00'),
(2, 18, 2, 2, 2, NULL, 2.00, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(3, 22, 1, 1, 4, NULL, 4.00, NULL, 'Deleted', '2025-09-11 13:08:47', '2025-09-11 13:09:00'),
(4, 22, 1, 1, 4, NULL, 4.00, NULL, 'Live', '2025-09-11 13:09:00', '2025-09-11 13:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufactures_stages`
--

CREATE TABLE `tbl_manufactures_stages` (
  `id` int(11) NOT NULL,
  `productionstage_id` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `stage_check` int(11) DEFAULT NULL,
  `stage_month` int(11) DEFAULT NULL,
  `stage_day` int(11) DEFAULT NULL,
  `stage_hours` int(11) DEFAULT NULL,
  `stage_minute` int(11) DEFAULT NULL,
  `required_time` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_manufactures_stages`
--

INSERT INTO `tbl_manufactures_stages` (`id`, `productionstage_id`, `manufacture_id`, `stage_check`, `stage_month`, `stage_day`, `stage_hours`, `stage_minute`, `required_time`, `company_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 14, 1, NULL, 0, 0, 0, 12, NULL, NULL, 'Deleted', '2025-09-11 12:56:29', '2025-09-11 13:09:00'),
(2, 19, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 12:56:29', '2025-09-11 13:09:00'),
(3, 20, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 12:56:29', '2025-09-11 13:09:00'),
(4, 21, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 12:56:29', '2025-09-11 13:09:00'),
(5, 14, 2, NULL, 0, 0, 0, 15, NULL, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(6, 13, 2, NULL, 0, 0, 0, 5, NULL, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(7, 19, 2, NULL, 0, 0, 0, 1, NULL, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(8, 20, 2, NULL, 0, 0, 0, 5, NULL, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(9, 21, 2, NULL, 0, 0, 0, 1, NULL, NULL, 'Live', '2025-09-11 13:07:46', '2025-09-11 13:07:46'),
(10, 14, 1, NULL, 0, 0, 0, 12, NULL, NULL, 'Deleted', '2025-09-11 13:08:47', '2025-09-11 13:09:00'),
(11, 19, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 13:08:47', '2025-09-11 13:09:00'),
(12, 20, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 13:08:47', '2025-09-11 13:09:00'),
(13, 21, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Deleted', '2025-09-11 13:08:47', '2025-09-11 13:09:00'),
(14, 14, 1, NULL, 0, 0, 0, 12, NULL, NULL, 'Live', '2025-09-11 13:09:00', '2025-09-11 13:09:00'),
(15, 19, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Live', '2025-09-11 13:09:00', '2025-09-11 13:09:00'),
(16, 20, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Live', '2025-09-11 13:09:00', '2025-09-11 13:09:00'),
(17, 21, 1, NULL, 0, 0, 0, 2, NULL, NULL, 'Live', '2025-09-11 13:09:00', '2025-09-11 13:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacture_product`
--

CREATE TABLE `tbl_manufacture_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'fefo, batch_control',
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` varchar(50) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_stocks`
--

CREATE TABLE `tbl_material_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mat_cat_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `stock_type` varchar(20) NOT NULL,
  `owner_type` int(11) NOT NULL,
  `reference_no` varchar(50) NOT NULL,
  `line_item_no` varchar(30) DEFAULT NULL,
  `old_mat_no` varchar(100) DEFAULT NULL,
  `dc_no` varchar(50) DEFAULT NULL,
  `heat_no` text DEFAULT NULL,
  `dc_date` date DEFAULT NULL,
  `mat_doc_no` varchar(100) NOT NULL,
  `mat_type` int(11) NOT NULL COMMENT 'Material|Raw Material|Insert',
  `ins_type` int(11) DEFAULT NULL COMMENT 'Consumable|Non',
  `customer_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `close_qty` int(11) DEFAULT NULL,
  `current_stock` int(11) NOT NULL,
  `float_stock` int(11) DEFAULT NULL,
  `dc_inward_price` float DEFAULT NULL,
  `material_price` float DEFAULT NULL,
  `hsn_no` varchar(50) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `added_by` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_material_stocks`
--

INSERT INTO `tbl_material_stocks` (`id`, `mat_cat_id`, `mat_id`, `stock_type`, `owner_type`, `reference_no`, `line_item_no`, `old_mat_no`, `dc_no`, `heat_no`, `dc_date`, `mat_doc_no`, `mat_type`, `ins_type`, `customer_id`, `unit_id`, `close_qty`, `current_stock`, `float_stock`, `dc_inward_price`, `material_price`, `hsn_no`, `del_status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 34, 22, 'customer', 2, '6500149072', '1', '144961-043', '123', '1234', '2025-09-11', '', 1, NULL, 2, 2, 0, 0, 4, 0, 0, '', 'Live', 1, '2025-09-11 12:54:15', '2025-09-11 12:56:29'),
(2, 34, 18, 'customer', 2, '6500150191', '18', '142695-043', '321', '4321', '2025-09-11', '', 1, NULL, 2, 2, 0, 0, 2, 0, 0, '', 'Live', 1, '2025-09-11 13:03:54', '2025-09-11 13:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_types`
--

CREATE TABLE `tbl_material_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_material_types`
--

INSERT INTO `tbl_material_types` (`id`, `type_name`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'Raw Material', 'Live', '2025-09-08 07:06:39', '2025-09-08 07:06:39'),
(2, 'Consumables', 'Live', '2025-09-08 07:06:50', '2025-09-08 07:45:32'),
(3, 'Asset', 'Deleted', '2025-09-08 07:07:05', '2025-09-08 07:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Home', NULL, NULL, NULL),
(2, 'Dashboard', NULL, NULL, NULL),
(3, 'Profile', NULL, NULL, NULL),
(4, 'Production', NULL, NULL, NULL),
(5, 'Item Setup', NULL, NULL, NULL),
(6, 'Material Stock', NULL, NULL, NULL),
(9, 'Sales', NULL, NULL, NULL),
(10, 'Purchases', NULL, NULL, NULL),
(11, 'Orders', NULL, NULL, NULL),
(12, 'Accounting', NULL, NULL, NULL),
(14, 'Supplier Payment', NULL, NULL, NULL),
(15, 'Customer Receives', NULL, NULL, NULL),
(18, 'Expense', NULL, NULL, NULL),
(19, 'Users', NULL, NULL, NULL),
(20, 'Settings', NULL, NULL, NULL),
(21, 'Parties', NULL, NULL, NULL),
(22, 'Delivery Challan', NULL, NULL, NULL),
(23, 'Payroll', NULL, NULL, NULL),
(24, 'Master', NULL, NULL, NULL),
(25, 'Inspection', NULL, NULL, NULL),
(26, 'Instruments', NULL, NULL, NULL),
(27, 'Consumable', NULL, NULL, NULL),
(28, 'Reports', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_activities`
--

CREATE TABLE `tbl_menu_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `activity_name` varchar(191) NOT NULL,
  `route_name` varchar(191) NOT NULL,
  `is_dependant` varchar(191) NOT NULL DEFAULT 'No',
  `auto_select` varchar(191) NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menu_activities`
--

INSERT INTO `tbl_menu_activities` (`id`, `menu_id`, `activity_name`, `route_name`, `is_dependant`, `auto_select`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', 'user-home', 'Yes', 'Yes', NULL, NULL),
(2, 2, 'Dashboard', 'dashboard', 'No', 'No', NULL, NULL),
(3, 3, 'Change Password', 'change-password', 'No', 'No', NULL, NULL),
(4, 3, 'Edit Profile', 'edit-profile', 'No', 'No', NULL, NULL),
(5, 3, 'Update Profile', 'update-profile', 'Yes', 'No', NULL, NULL),
(6, 3, 'Set Security Question', 'set-security-question', 'Yes', 'No', NULL, NULL),
(7, 3, 'Save Security Question', 'save-security-question', 'Yes', 'No', NULL, NULL),
(8, 4, 'Add Production', 'productions.create', 'No', 'No', NULL, NULL),
(9, 4, 'List Production', 'productions.index', 'No', 'No', NULL, NULL),
(10, 4, 'Edit Production', 'productions.edit', 'No', 'No', NULL, NULL),
(11, 4, 'Delete Production', 'productions.delete', 'No', 'No', NULL, NULL),
(12, 4, 'View Production', 'productions.view', 'No', 'No', NULL, NULL),
(13, 4, 'Duplicate Manufacture', 'manufacture.duplicate', 'Yes', 'No', NULL, NULL),
(14, 4, 'Print Production', 'productions.print', 'No', 'No', NULL, NULL),
(15, 5, 'Add RM Category', 'rmcategory.create', 'No', 'No', NULL, NULL),
(16, 5, 'List RM Category', 'rmcategory.index', 'No', 'No', NULL, NULL),
(17, 5, 'Edit RM Category', 'rmcategory.edit', 'No', 'No', NULL, NULL),
(18, 5, 'Delete RM Category', 'rmcategory.delete', 'No', 'No', NULL, NULL),
(19, 5, 'Add RM', 'rm.create', 'No', 'No', NULL, NULL),
(20, 5, 'List RM', 'rm.index', 'No', 'No', NULL, NULL),
(21, 5, 'Edit RM', 'rm.edit', 'No', 'No', NULL, NULL),
(22, 5, 'Delete RM', 'rm.delete', 'No', 'No', NULL, NULL),
(23, 5, 'Add Non Inventory Item', 'noi.create', 'No', 'No', NULL, NULL),
(24, 5, 'List Non Inventory Item', 'noi.index', 'No', 'No', NULL, NULL),
(25, 5, 'Edit Non Inventory Item', 'noi.edit', 'No', 'No', NULL, NULL),
(26, 5, 'Delete Non Inventory Item', 'noi.delete', 'No', 'No', NULL, NULL),
(27, 6, 'RM Stock', 'rm.stock', 'Yes', 'No', NULL, NULL),
(28, 6, 'Low Stock', 'low.stock', 'Yes', 'No', NULL, NULL),
(29, 6, 'Add Stock Adjustment', 'stock-adjustment.create', 'Yes', 'No', NULL, NULL),
(30, 6, 'List Stock Adjustment', 'stock-adjustment.index', 'Yes', 'No', NULL, NULL),
(31, 6, 'Edit Stock Adjustment', 'stock-adjustment.edit', 'Yes', 'No', NULL, NULL),
(32, 7, 'Product Stock', 'product.stock', 'No', 'No', NULL, NULL),
(33, 8, 'Add Production Loss', 'production-loss.create', 'No', 'No', NULL, NULL),
(34, 8, 'List Production Loss', 'production-loss.index', 'No', 'No', NULL, NULL),
(35, 8, 'Add RM Waste', 'rmwaste.create', 'No', 'No', NULL, NULL),
(36, 8, 'List RM Waste', 'rmwaste.index', 'No', 'No', NULL, NULL),
(37, 8, 'Edit RM Waste', 'rmwaste.edit', 'No', 'No', NULL, NULL),
(38, 8, 'Delete RM Waste', 'rmwaste.delete', 'No', 'No', NULL, NULL),
(39, 8, 'Add Product Waste', 'productwaste.create', 'No', 'No', NULL, NULL),
(40, 8, 'List Product Waste', 'productwaste.index', 'No', 'No', NULL, NULL),
(41, 8, 'Edit Product Waste', 'productwaste.edit', 'No', 'No', NULL, NULL),
(42, 8, 'Delete Product Waste', 'productwaste.delete', 'No', 'No', NULL, NULL),
(43, 9, 'Add Sale', 'sale.create', 'No', 'No', NULL, NULL),
(44, 9, 'List Sale', 'sale.index', 'No', 'No', NULL, NULL),
(45, 9, 'Edit Sale', 'sale.edit', 'No', 'No', NULL, NULL),
(46, 9, 'Delete Sale', 'sale.delete', 'No', 'No', NULL, NULL),
(47, 9, 'Sale Print Invoice', 'sale.print-invoice', 'No', 'No', NULL, NULL),
(48, 9, 'Sale Download Invoice', 'sale.download-invoice', 'No', 'No', NULL, NULL),
(49, 9, 'Sale View Details', 'sale.view-details', 'No', 'No', NULL, NULL),
(50, 9, 'Sale Chalan Print', 'sale.chalan-print', 'Yes', 'No', NULL, NULL),
(51, 9, 'Sale Chalan Download', 'sale.chalan-download', 'Yes', 'No', NULL, NULL),
(52, 21, 'Add Customer', 'customer.create', 'No', 'No', NULL, NULL),
(53, 21, 'List Customer', 'customer.index', 'No', 'No', NULL, NULL),
(54, 21, 'Edit Customer', 'customer.edit', 'No', 'No', NULL, NULL),
(55, 21, 'Delete Customer', 'customer.delete', 'No', 'No', NULL, NULL),
(56, 21, 'Customer Due Report', 'customer.due-report', 'Yes', 'No', NULL, NULL),
(57, 21, 'Customer Ledger', 'customer.ledger', 'Yes', 'No', NULL, NULL),
(58, 21, 'Add Supplier', 'supplier.create', 'No', 'No', NULL, NULL),
(59, 21, 'List Supplier', 'supplier.index', 'No', 'No', NULL, NULL),
(60, 21, 'Edit Supplier', 'supplier.edit', 'No', 'No', NULL, NULL),
(61, 21, 'Delete Supplier', 'supplier.delete', 'No', 'No', NULL, NULL),
(62, 21, 'Supplier Due Report', 'supplier.due-report', 'Yes', 'No', NULL, NULL),
(63, 21, 'Supplier Ledger', 'supplier.ledger', 'Yes', 'No', NULL, NULL),
(64, 21, 'Supplier Balance Report', 'supplier.balance-report', 'Yes', 'No', NULL, NULL),
(65, 10, 'Demand Forecasting By Order', 'demand-forecasting.order', 'Yes', 'No', NULL, NULL),
(66, 10, 'Demand Forecasting By Product', 'demand-forecasting.product', 'Yes', 'No', NULL, NULL),
(67, 10, 'Raw Material Price History', 'rm-price-history', 'Yes', 'No', NULL, NULL),
(68, 11, 'Add Order', 'order.create', 'No', 'No', NULL, NULL),
(69, 11, 'List Order', 'order.index', 'No', 'No', NULL, NULL),
(70, 11, 'Edit Order', 'order.edit', 'No', 'No', NULL, NULL),
(71, 11, 'Delete Order', 'order.delete', 'No', 'No', NULL, NULL),
(72, 11, 'Print Order Invoice', 'order.print-invoice', 'No', 'No', NULL, NULL),
(73, 11, 'Download Order Invoice', 'order.download-invoice', 'No', 'No', NULL, NULL),
(74, 11, 'View Order Details', 'order.view-details', 'No', 'No', NULL, NULL),
(75, 11, 'Order Status', 'order-status', 'No', 'No', NULL, NULL),
(76, 22, 'Add Delivery Challan', 'quotations.create', 'No', 'No', NULL, NULL),
(77, 22, 'List Delivery Challan', 'quotations.index', 'No', 'No', NULL, NULL),
(78, 22, 'Edit Delivery Challan', 'quotations.edit', 'No', 'No', NULL, NULL),
(79, 22, 'Delete Delivery Challan', 'quotations.delete', 'No', 'No', NULL, NULL),
(80, 11, 'Product Order By Low Stock', 'product.low-stock', 'Yes', 'No', NULL, NULL),
(81, 11, 'Product Order By Work Order', 'product.work-order', 'Yes', 'No', NULL, NULL),
(82, 11, 'Product Order By Production', 'product.production', 'Yes', 'No', NULL, NULL),
(83, 11, 'Product Order By Multiple Product', 'product.multiple-product', 'Yes', 'No', NULL, NULL),
(84, 12, 'Add Account', 'account.create', 'No', 'No', NULL, NULL),
(85, 12, 'Account List', 'account.index', 'No', 'No', NULL, NULL),
(86, 12, 'Edit Account', 'account.edit', 'No', 'No', NULL, NULL),
(87, 12, 'Delete Account', 'account.delete', 'No', 'No', NULL, NULL),
(88, 12, 'Add Deposit Withdraw', 'deposit.create', 'No', 'No', NULL, NULL),
(89, 12, 'List Deposit Withdraw', 'deposit.index', 'No', 'No', NULL, NULL),
(90, 12, 'Edit Deposit Withdrwaw', 'deposit.edit', 'No', 'No', NULL, NULL),
(91, 12, 'Delete Deposit Withdraw', 'deposit.delete', 'No', 'No', NULL, NULL),
(92, 12, 'Balance Sheet', 'balancesheet', 'No', 'No', NULL, NULL),
(93, 12, 'Trial Balance', 'trialbalance', 'Yes', 'No', NULL, NULL),
(94, 13, 'Add Attendance', 'attendance.create', 'No', 'No', NULL, NULL),
(95, 13, 'List Attendance', 'attendance.index', 'No', 'No', NULL, NULL),
(96, 13, 'Edit Attendance', 'attendance.edit', 'No', 'No', NULL, NULL),
(97, 13, 'Delete Attendance', 'attendance.delete', 'No', 'No', NULL, NULL),
(98, 23, 'Add Payroll', 'payroll.create', 'No', 'No', NULL, NULL),
(99, 23, 'List Payroll', 'payroll.index', 'No', 'No', NULL, NULL),
(100, 23, 'Edit Payroll', 'payroll.edit', 'No', 'No', NULL, NULL),
(101, 14, 'Add Supplier Payment', 'supplier-payment.create', 'No', 'No', NULL, NULL),
(102, 14, 'List Supplier Payment', 'supplier-payment.index', 'No', 'No', NULL, NULL),
(103, 14, 'Edit Supplier Payment', 'supplier-payment.edit', 'No', 'No', NULL, NULL),
(104, 14, 'Delete Supplier Payment', 'supplier-payment.delete', 'No', 'No', NULL, NULL),
(105, 15, 'Add Customer Received', 'customer-received.create', 'Yes', 'No', NULL, NULL),
(106, 15, 'List Customer Received', 'customer-received.index', 'No', 'No', NULL, NULL),
(107, 15, 'Edit Customer Received', 'customer-received.edit', 'Yes', 'No', NULL, NULL),
(108, 15, 'Delete Customer Received', 'customer-received.delete', 'No', 'No', NULL, NULL),
(109, 5, 'Add Product Category', 'productcategory.create', 'No', 'No', NULL, NULL),
(110, 5, 'List Product Category', 'productcategory.index', 'No', 'No', NULL, NULL),
(111, 5, 'Edit Product Category', 'productcategory.edit', 'No', 'No', NULL, NULL),
(112, 5, 'Delete Product Category', 'productcategory.delete', 'No', 'No', NULL, NULL),
(113, 5, 'Add Product', 'product.create', 'No', 'No', NULL, NULL),
(114, 5, 'List Product', 'product.index', 'No', 'No', NULL, NULL),
(115, 5, 'Edit Product', 'product.edit', 'No', 'No', NULL, NULL),
(116, 5, 'Delete Product', 'product.delete', 'No', 'No', NULL, NULL),
(117, 5, 'Duplicate Product', 'product.duplicate', 'Yes', 'No', NULL, NULL),
(118, 17, 'RM Purchase Report', 'rmpurchase.report', 'No', 'No', NULL, NULL),
(119, 17, 'RM Item Purchase Report', 'rmpurchaseitem.report', 'No', 'No', NULL, NULL),
(120, 17, 'RM Stock Report', 'rmstock.report', 'No', 'No', NULL, NULL),
(121, 17, 'Supplier Due Report', 'supplierdue.report', 'No', 'No', NULL, NULL),
(122, 17, 'Supplier Ledger', 'supplierledger.report', 'No', 'No', NULL, NULL),
(123, 17, 'Production Report', 'production.report', 'No', 'No', NULL, NULL),
(124, 17, 'Finished Product Production Report', 'fpp.report', 'No', 'No', NULL, NULL),
(125, 17, 'Finished Product Sale Report', 'fpsale.report', 'No', 'No', NULL, NULL),
(126, 17, 'Finished Product Item Sale Report', 'fpitemsale.report', 'No', 'No', NULL, NULL),
(127, 17, 'Customer Due Report', 'customerdue.report', 'No', 'No', NULL, NULL),
(128, 17, 'Customer Ledger', 'customerledger', 'No', 'No', NULL, NULL),
(129, 17, 'Profit & Loss Report', 'profit-loss', 'No', 'No', NULL, NULL),
(130, 17, 'Production Profit Report', 'production-profit.report', 'No', 'No', NULL, NULL),
(131, 17, 'Attendance Report', 'attandance.report', 'No', 'No', NULL, NULL),
(132, 17, 'Expense Report', 'expense-report', 'No', 'No', NULL, NULL),
(133, 17, 'Salary Report', 'salary-report', 'No', 'No', NULL, NULL),
(134, 17, 'RM Waste Report', 'rmwaste-report', 'No', 'No', NULL, NULL),
(135, 17, 'Product Waste Report', 'productwaste-report', 'No', 'No', NULL, NULL),
(136, 17, 'ABC Analysis Report', 'abcanalysis-report', 'No', 'No', NULL, NULL),
(137, 17, 'Product Price History', 'product-price-history', 'No', 'No', NULL, NULL),
(138, 17, 'RM Price History', 'rm-price-history', 'No', 'No', NULL, NULL),
(139, 18, 'Add Expense Category', 'expense-category.create', 'No', 'No', NULL, NULL),
(140, 18, 'Edit Expense Category', 'expense-category.edit', 'No', 'No', NULL, NULL),
(141, 18, 'List Expense Category', 'expense-category.index', 'No', 'No', NULL, NULL),
(142, 18, 'Delete Expense Category', 'expense-category.delete', 'No', 'No', NULL, NULL),
(143, 18, 'Add Expense', 'expense.create', 'No', 'No', NULL, NULL),
(144, 18, 'Edit Expense', 'expense.edit', 'No', 'No', NULL, NULL),
(145, 18, 'List Expense', 'expense.index', 'No', 'No', NULL, NULL),
(146, 18, 'Delete Expense', 'expense.delete', 'No', 'No', NULL, NULL),
(147, 19, 'Add Role', 'role.create', 'No', 'No', NULL, NULL),
(148, 19, 'Edit Role', 'role.edit', 'No', 'No', NULL, NULL),
(149, 19, 'List Role', 'role.index', 'No', 'No', NULL, NULL),
(150, 19, 'Delete Role', 'role.delete', 'No', 'No', NULL, NULL),
(151, 19, 'Add User', 'user.create', 'No', 'No', NULL, NULL),
(152, 19, 'Edit User', 'user.edit', 'No', 'No', NULL, NULL),
(153, 19, 'List User', 'user.index', 'No', 'No', NULL, NULL),
(154, 19, 'Delete User', 'user.delete', 'No', 'No', NULL, NULL),
(155, 24, 'Add Unit', 'units.create', 'No', 'No', NULL, NULL),
(156, 24, 'List Unit', 'units.index', 'No', 'No', NULL, NULL),
(157, 24, 'Edit Unit', 'units.edit', 'No', 'No', NULL, NULL),
(158, 24, 'Delete Unit', 'units.delete', 'No', 'No', NULL, NULL),
(159, 20, 'White Label', 'white-label', 'No', 'No', NULL, NULL),
(160, 24, 'Add Production Stage', 'productionstage.create', 'No', 'No', NULL, NULL),
(161, 24, 'List Production Stage', 'productionstage.list', 'No', 'No', NULL, NULL),
(162, 24, 'Edit Production Stage', 'productionstage.edit', 'No', 'No', NULL, NULL),
(163, 24, 'Delete Production Stage', 'productionstage.delete', 'No', 'No', NULL, NULL),
(164, 20, 'Mail Settings', 'mail-settings', 'Yes', 'No', NULL, NULL),
(165, 20, 'Tax Settings', 'tax-settings', 'No', 'No', NULL, NULL),
(166, 20, 'Company Profile', 'company-profile', 'No', 'No', NULL, NULL),
(167, 20, 'Data Import', 'data-import', 'No', 'No', NULL, NULL),
(168, 10, 'Add Purchase', 'purchase.create', 'No', 'No', NULL, NULL),
(169, 10, 'List Purchase', 'purchase.index', 'No', 'No', NULL, NULL),
(170, 10, 'Edit Purchase', 'purchase.edit', 'No', 'No', NULL, NULL),
(171, 10, 'Delete Purchase', 'purchase.delete', 'No', 'No', NULL, NULL),
(172, 10, 'View Purchase', 'purchase.view', 'No', 'No', NULL, NULL),
(173, 10, 'Generate Purchase', 'purchase.generate', 'Yes', 'No', NULL, NULL),
(174, 10, 'Print Purchase', 'purchase.print', 'No', 'No', NULL, NULL),
(175, 10, 'Download Purchase', 'purchase.download', 'No', 'No', NULL, NULL),
(176, 24, 'Add Drawer', 'drawers.create', 'No', 'No', NULL, NULL),
(177, 24, 'Drawer List', 'drawers.index', 'No', 'No', NULL, NULL),
(178, 24, 'Edit Drawer', 'drawers.edit', 'No', 'No', NULL, NULL),
(179, 24, 'Delete Drawer', 'drawers.delete', 'No', 'No', NULL, NULL),
(180, 6, 'Add Material Stock', 'material_stocks.create', 'No', 'No', NULL, NULL),
(181, 6, 'Material Stock List', 'material_stocks.index', 'No', 'No', NULL, NULL),
(182, 6, 'Edit Material Stock', 'material_stocks.edit', 'No', 'No', NULL, NULL),
(183, 6, 'Delete Material Stock', 'material_stocks.delete', 'No', 'No', NULL, NULL),
(184, 24, 'Add Inspection', 'inspections.create', 'No', 'No', NULL, NULL),
(185, 24, 'Inspection List', 'inspections.index', 'No', 'No', NULL, NULL),
(186, 24, 'Edit Inspection', 'inspections.edit', 'No', 'No', NULL, NULL),
(187, 24, 'Delete Inspection', 'inspections.delete', 'No', 'No', NULL, NULL),
(188, 24, 'Generate Inspection', 'inspection-generate.index', 'No', 'No', NULL, NULL),
(189, 25, 'Inspection Report', 'inspection-generate.index', 'No', 'No', NULL, NULL),
(190, 5, 'Add Material Type', 'materialtypes.create', 'No', 'No', NULL, NULL),
(191, 5, 'List Material Type', 'materialtypes.index', 'No', 'No', NULL, NULL),
(192, 5, 'Edit Material Type', 'materialtype.edit', 'No', 'No', NULL, NULL),
(193, 5, 'Delete Material Type', 'materialtype.delete', 'No', 'No', NULL, NULL),
(194, 24, 'Add Tools/Gauges', 'tools.create', 'No', 'No', NULL, NULL),
(195, 24, 'Tools/Gauges List', 'tools.index', 'No', 'No', NULL, NULL),
(196, 24, 'Edit Tools/Gauges', 'tools.edit', 'No', 'No', NULL, NULL),
(197, 24, 'Delete Tools/Gauges', 'tools.delete', 'No', 'No', NULL, NULL),
(198, 26, 'Add Instrument', 'instruments.create', 'No', 'No', NULL, NULL),
(199, 26, 'Instruments List', 'instruments.index', 'No', 'No', NULL, NULL),
(200, 26, 'Edit Instrument', 'instruments.edit', 'No', 'No', NULL, NULL),
(201, 26, 'Delete Instrument', 'instruments.delete', 'No', 'No', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_non_inventory_items`
--

CREATE TABLE `tbl_non_inventory_items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_non_inventory_items`
--

INSERT INTO `tbl_non_inventory_items` (`id`, `name`, `description`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'Internal Expenses', '', 1, '2025-05-29 12:01:33', '2025-05-29 12:01:33', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `row_id` int(11) NOT NULL,
  `created_by` varchar(6) NOT NULL,
  `created_for` varchar(6) NOT NULL,
  `updated_by` varchar(6) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_read_doctor` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_settings`
--

CREATE TABLE `tbl_payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `method` varchar(255) NOT NULL,
  `type` enum('live','sandbox') NOT NULL DEFAULT 'sandbox',
  `app_username` text DEFAULT NULL,
  `app_password` text DEFAULT NULL,
  `app_secret_key` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(20) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productions`
--

CREATE TABLE `tbl_productions` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `production_stage` int(11) DEFAULT NULL,
  `production_stage_text` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `finished_product` int(11) DEFAULT NULL,
  `quantity` float(10,2) DEFAULT NULL,
  `rmcost_total` float(10,2) DEFAULT NULL,
  `noninitem_total` float(10,2) DEFAULT NULL,
  `total_cost` float(10,2) DEFAULT NULL,
  `sale_price` float(10,2) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `file_paths` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_history`
--

CREATE TABLE `tbl_production_history` (
  `id` int(11) NOT NULL,
  `work_order_id` int(11) NOT NULL,
  `produced_quantity` int(11) NOT NULL,
  `produced_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_noninventory`
--

CREATE TABLE `tbl_production_noninventory` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `ni_id` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `totalamount` float(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_qc_scheduling`
--

CREATE TABLE `tbl_production_qc_scheduling` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheduling_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `production_stage_id` int(11) NOT NULL,
  `qc_user_id` int(11) NOT NULL,
  `qc_status` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `complete_date` date NOT NULL,
  `note` varchar(250) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_rmaterials`
--

CREATE TABLE `tbl_production_rmaterials` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `rm_id` int(11) DEFAULT NULL,
  `unit_price` float(10,2) DEFAULT NULL,
  `consumption` float(10,2) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_scheduling`
--

CREATE TABLE `tbl_production_scheduling` (
  `id` int(9) NOT NULL,
  `manufacture_id` int(9) NOT NULL,
  `production_stage_id` int(9) NOT NULL,
  `task` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_hours` int(11) NOT NULL,
  `task_note` varchar(100) DEFAULT NULL,
  `task_status` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-pending,2-in progress,3-completed,4-move to next task',
  `move_to_next` varchar(1) NOT NULL DEFAULT 'N',
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `del_status` varchar(191) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_production_scheduling`
--

INSERT INTO `tbl_production_scheduling` (`id`, `manufacture_id`, `production_stage_id`, `task`, `user_id`, `task_hours`, `task_note`, `task_status`, `move_to_next`, `start_date`, `end_date`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'Task one', 2, 5, '', '3', 'N', '2025-09-11', '2025-09-11', 'Live', '2025-09-11 12:56:29', '2025-09-11 12:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_stages`
--

CREATE TABLE `tbl_production_stages` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_production_stages`
--

INSERT INTO `tbl_production_stages` (`id`, `name`, `description`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'Grinding', 'Grinding in the steel core industry removes excess material.', '2025-06-05 13:11:02', '2025-06-05 13:13:02', 'Live'),
(2, 'Rework', 'Precision grinding for smooth, accurate steel cores.', '2025-06-05 13:11:11', '2025-06-05 13:13:42', 'Live'),
(3, 'Slotting', 'Slotting creates precise slots or grooves in steel cores.', '2025-06-05 13:11:25', '2025-06-05 13:14:07', 'Live'),
(4, 'Spot Facing', 'Spot facing smooths a flat surface around holes for bolts.', '2025-06-05 13:14:29', '2025-06-05 13:14:29', 'Live'),
(5, 'Cutting', 'Cutting shapes or sizes steel cores using precise tools.', '2025-06-05 13:14:55', '2025-06-05 13:14:55', 'Live'),
(6, 'Special Operation', 'Special operation involves custom processes.', '2025-06-05 13:15:35', '2025-06-05 13:15:35', 'Live'),
(7, 'Milling', 'Milling shapes steel cores by removing material with rotary cutters.', '2025-06-05 13:20:14', '2025-06-05 13:20:14', 'Live'),
(8, 'Drilling / Tap', 'Drilling/Tap creates holes and threads in steel cores for assembly.', '2025-06-05 13:20:45', '2025-06-05 13:20:45', 'Live'),
(9, 'Drilling', 'Drilling creates round holes in steel cores using a rotating drill bit.', '2025-06-05 13:21:08', '2025-06-05 13:21:08', 'Live'),
(10, 'Roughing -2', 'Roughing prepares the steel core for finer, precise finishing processes.', '2025-06-05 13:21:36', '2025-06-05 13:21:36', 'Live'),
(11, 'Roughing-1', 'Initial machining step that removes bulk material quickly to shape the steel core roughly.', '2025-06-05 13:22:12', '2025-06-05 13:22:12', 'Live'),
(12, 'Finishing -3', 'Finishing prepares the steel core for final inspection or assembly.', '2025-06-05 13:22:36', '2025-06-05 13:22:36', 'Live'),
(13, 'Finishing -2', 'Finishing ensures precise dimensions and high-quality finish', '2025-06-05 13:23:02', '2025-06-05 13:23:02', 'Live'),
(14, 'Finishing -1', 'Finishing gives the steel core a smooth, precise final surface.', '2025-06-05 13:23:31', '2025-06-05 13:23:31', 'Live'),
(15, 'Skin Tum', 'Machining process that removes a thin outer layer from steel cores.', '2025-06-05 13:27:20', '2025-06-05 13:27:20', 'Live'),
(16, 'New Stage', 'Notes', '2025-06-05 15:17:56', '2025-06-12 12:55:06', 'Deleted'),
(17, 'NOZZLE', 'Cutting', '2025-06-07 15:56:25', '2025-06-07 15:57:12', 'Deleted'),
(18, 'Seven Stages', 'Seven Stages', '2025-07-03 20:55:56', '2025-07-03 20:56:20', 'Deleted'),
(19, 'DE-BURRING', 'TO REMOVE THE BURR', '2025-08-24 17:09:58', '2025-08-24 17:09:58', 'Live'),
(20, 'FINAL INSPECTION', 'FINAL QUALITY CHECKING', '2025-08-24 17:10:49', '2025-08-24 17:10:49', 'Live'),
(21, 'PACKING', 'TO PACKING THE FINISHED GOODS', '2025-08-24 17:11:29', '2025-08-24 17:11:29', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products_services`
--

CREATE TABLE `tbl_products_services` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT 'Veg No',
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proposal_invoice`
--

CREATE TABLE `tbl_proposal_invoice` (
  `id` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'Proposal/Invoice',
  `date` date NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `subtotal` float UNSIGNED NOT NULL,
  `discount_type` varchar(50) NOT NULL COMMENT 'Fixed/Percentage',
  `discount_value` float NOT NULL,
  `tax` varchar(500) NOT NULL COMMENT 'total tax',
  `shipping_other` float NOT NULL,
  `grand_total` float NOT NULL,
  `proposal_no` varchar(20) NOT NULL,
  `proposal_status` varchar(20) NOT NULL DEFAULT 'N/A' COMMENT 'Accepted, Declined, N/A',
  `template_bg_color` varchar(50) NOT NULL DEFAULT '#45818E',
  `template_text_color` varchar(50) NOT NULL DEFAULT '#FFFFFF',
  `proposal_user_id` int(11) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `proposal_id` bigint(20) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL COMMENT 'Paid/Unpaid',
  `invoice_user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(50) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proposal_invoice_products_services`
--

CREATE TABLE `tbl_proposal_invoice_products_services` (
  `id` bigint(20) NOT NULL,
  `product_service_id` int(11) DEFAULT NULL,
  `quantity_amount` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `total` float NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `proposal_invoice_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(50) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proposal_pdf`
--

CREATE TABLE `tbl_proposal_pdf` (
  `id` bigint(20) NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `attachment_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(50) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proposal_photo`
--

CREATE TABLE `tbl_proposal_photo` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  `proposal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `del_status` varchar(50) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase`
--

CREATE TABLE `tbl_purchase` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `subtotal` float(10,2) DEFAULT NULL,
  `other` float(10,2) DEFAULT NULL,
  `grand_total` float(10,2) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `paid` float(10,2) DEFAULT NULL,
  `due` float(10,2) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Draft',
  `added_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `mat_type` text DEFAULT NULL COMMENT 'Raw Material, Insert',
  `ins_type` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return`
--

CREATE TABLE `tbl_purchase_return` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `pur_ref_no` varchar(255) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `purchase_date` varchar(55) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `return_status` varchar(100) DEFAULT NULL,
  `total_return_amount` float DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL DEFAULT 1,
  `payment_method_type` varchar(255) DEFAULT NULL,
  `account_type` varchar(20) DEFAULT NULL,
  `note` varchar(300) DEFAULT NULL,
  `added_date` varchar(55) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 0,
  `del_status` varchar(11) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return_details`
--

CREATE TABLE `tbl_purchase_return_details` (
  `id` int(11) NOT NULL,
  `pur_return_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `expiry_imei_serial` varchar(255) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `return_quantity_amount` varchar(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `return_status` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 0,
  `del_status` varchar(11) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_rmaterials`
--

CREATE TABLE `tbl_purchase_rmaterials` (
  `id` int(11) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `mat_unit` varchar(10) NOT NULL,
  `unit_price` float(10,2) DEFAULT NULL,
  `quantity_amount` float DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qc_statuses`
--

CREATE TABLE `tbl_qc_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_qc_statuses`
--

INSERT INTO `tbl_qc_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Accepted', NULL, NULL),
(2, 'Blow Hole', NULL, NULL),
(3, 'RMI', NULL, NULL),
(4, 'Rejected', NULL, NULL),
(5, 'RMR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotations`
--

CREATE TABLE `tbl_quotations` (
  `id` int(11) NOT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_address` varchar(250) NOT NULL,
  `customer_gst` varchar(16) NOT NULL,
  `challan_date` date NOT NULL,
  `material_doc_no` varchar(50) NOT NULL,
  `subtotal` float(10,2) DEFAULT NULL,
  `other` float(10,2) DEFAULT NULL,
  `grand_total` float(10,2) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `due` float(10,2) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `challan_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=Pending, 2=Progress, 3=Verified',
  `file` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quotations`
--

INSERT INTO `tbl_quotations` (`id`, `challan_no`, `customer_id`, `customer_address`, `customer_gst`, `challan_date`, `material_doc_no`, `subtotal`, `other`, `grand_total`, `discount`, `due`, `note`, `challan_status`, `file`, `user_id`, `company_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, '3210', 2, '88/1 B, Vadugappti Village Viralimalai, Viralimalai, Pudukottai (Dt) PIN- 621316.', '33AAACT7409H1ZH', '2025-09-11', '8054522558', 0.00, 0.00, 0.00, '0', NULL, '', 3, NULL, 1, 1, 'Live', '2025-09-11 13:17:35', '2025-09-11 13:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_details`
--

CREATE TABLE `tbl_quotation_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_order_id` int(11) NOT NULL,
  `product_quantity` varchar(10) DEFAULT NULL,
  `raw_qty` varchar(10) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `po_no` varchar(50) NOT NULL,
  `line_item_no` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `po_date` date DEFAULT NULL,
  `dc_ref` varchar(20) DEFAULT NULL,
  `dc_ref_date` date DEFAULT NULL,
  `challan_ref` varchar(150) DEFAULT NULL,
  `sale_price` float(10,2) DEFAULT NULL,
  `disc_val` float(10,2) DEFAULT NULL,
  `tax_amount` float(10,2) DEFAULT NULL,
  `tax_type` varchar(20) DEFAULT NULL,
  `tax_rate` float(10,2) DEFAULT NULL,
  `msale_price` float(10,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL COMMENT 'remarks (changes after client req)',
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quotation_details`
--

INSERT INTO `tbl_quotation_details` (`id`, `product_id`, `customer_order_id`, `product_quantity`, `raw_qty`, `unit_id`, `po_no`, `line_item_no`, `price`, `po_date`, `dc_ref`, `dc_ref_date`, `challan_ref`, `sale_price`, `disc_val`, `tax_amount`, `tax_type`, `tax_rate`, `msale_price`, `quotation_id`, `description`, `company_id`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 13, 1, '2', NULL, 2, '6500149072', '1', 0.00, '2025-09-11', '6500567467', '2025-09-12', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'ok', NULL, 'Live', '2025-09-11 13:17:35', '2025-09-11 13:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_qc_logs`
--

CREATE TABLE `tbl_quotation_qc_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `challan_id` int(11) NOT NULL,
  `qc_user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `note` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rawmaterials`
--

CREATE TABLE `tbl_rawmaterials` (
  `id` int(11) NOT NULL,
  `mat_type_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `insert_type` int(11) DEFAULT NULL,
  `diameter` varchar(30) DEFAULT NULL,
  `heat_no` varchar(50) DEFAULT NULL,
  `old_mat_no` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `consumption_unit` float DEFAULT NULL,
  `unit` float DEFAULT NULL,
  `rate_per_unit` float DEFAULT NULL,
  `consumption_check` float DEFAULT 0,
  `conversion_rate` float(10,2) DEFAULT NULL,
  `rate_per_consumption_unit` float(10,2) DEFAULT NULL,
  `opening_stock` float DEFAULT NULL,
  `alert_level` float DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rawmaterials`
--

INSERT INTO `tbl_rawmaterials` (`id`, `mat_type_id`, `name`, `category`, `insert_type`, `diameter`, `heat_no`, `old_mat_no`, `remarks`, `consumption_unit`, `unit`, `rate_per_unit`, `consumption_check`, `conversion_rate`, `rate_per_consumption_unit`, `opening_stock`, `alert_level`, `code`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 1, 'Carbon Steel', 3, NULL, NULL, NULL, '1001', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'MAT0001', 1, '2025-08-12 21:09:50', '2025-09-11 12:15:24', 'Deleted'),
(2, 1, 'Stainless Steel', 3, NULL, NULL, NULL, '1002', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'MAT0002', 1, '2025-08-14 00:47:43', '2025-09-11 12:15:24', 'Live'),
(3, 1, 'CAP L', 9, NULL, NULL, NULL, '015192-E005', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRCT1074-E005', 1, '2025-08-14 23:44:58', '2025-09-11 12:15:24', 'Live'),
(4, 1, 'ROD', 9, NULL, '60MM', NULL, '', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'ROD', 1, '2025-08-15 01:01:43', '2025-09-11 12:15:24', 'Live'),
(5, 1, 'ROD', 19, NULL, '1&quot;', NULL, 'T0104000-A16', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'T01041000-A16', 1, '2025-08-24 00:57:37', '2025-09-11 12:15:24', 'Live'),
(6, 1, 'FORGED BLANK', 18, NULL, 'DIA 56MM X 191MM L', NULL, '056191-F-BK-331', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRGM056191-331', 1, '2025-08-24 00:59:01', '2025-09-11 12:15:24', 'Live'),
(7, 1, 'DISC HOLDER CASTING', 20, NULL, NULL, NULL, '122563-053', 'REMARK', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC125564', 1, '2025-08-24 01:02:44', '2025-09-11 12:15:24', 'Live'),
(8, 1, 'PIPE', 15, NULL, '20&quot;', NULL, '20NBSCH30-065', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'NB500S30-065', 1, '2025-08-24 01:03:54', '2025-09-11 12:15:24', 'Live'),
(9, 1, 'GUID CASTING', 7, NULL, NULL, NULL, '25604T0001', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '504634853 ROD', 1, '2025-08-24 01:08:28', '2025-09-11 12:15:24', 'Live'),
(10, 1, 'NOZZLE CASTING', 14, NULL, NULL, NULL, 'T10197-I69', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRCT10197-I69', 1, '2025-08-24 01:10:39', '2025-09-11 12:15:24', 'Live'),
(11, 1, 'ROD 16MM', 13, NULL, '16MM', NULL, '826040625-836', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '826040625 ROD', 1, '2025-08-24 01:11:59', '2025-09-11 12:15:24', 'Live'),
(12, 1, 'ROD 100MM', 12, NULL, NULL, NULL, '0MM100-R-RD-R43', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '54504M100 ROD', 1, '2025-08-24 01:12:49', '2025-09-11 12:15:24', 'Live'),
(13, 1, 'ROD 1 250 INCH DIA', 11, NULL, '31.75MM', NULL, '360041250-R52', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '360041250 ROD', 1, '2025-08-24 01:14:52', '2025-09-11 12:15:24', 'Live'),
(14, 1, 'NOZZLE BLANK CROSBY STD', 10, NULL, NULL, NULL, 'FRGC85102-343', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRGC85102-343', 1, '2025-08-24 01:18:08', '2025-09-11 12:15:24', 'Live'),
(15, 1, 'Gey', 19, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'gfe54-', 1, '2025-08-25 18:09:43', '2025-09-11 12:15:24', 'Deleted'),
(16, 1, 'Hruyertuy-8418', 19, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'gfe54-', 1, '2025-08-25 18:10:32', '2025-09-11 12:15:24', 'Deleted'),
(17, 1, 'CAP', 21, NULL, NULL, NULL, '014602-048', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '014602-048 CAP', 1, '2025-08-26 00:32:36', '2025-09-11 12:15:24', 'Live'),
(18, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '142695-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC142695', 1, '2025-08-26 00:35:25', '2025-09-11 06:55:03', 'Live'),
(19, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '142697-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC142697', 1, '2025-08-26 00:36:16', '2025-09-11 12:15:24', 'Live'),
(20, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '078275-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRGC78275', 1, '2025-08-26 00:36:52', '2025-09-11 12:15:24', 'Live'),
(21, 1, 'NOZZLE CASTING', 34, NULL, NULL, NULL, '0P8601-K43', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC0P8601-K43', 1, '2025-08-26 00:37:53', '2025-09-11 12:15:24', 'Live'),
(22, 1, 'DISC HOLDER RETAINER CASTING INV', 34, NULL, NULL, NULL, '144961-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC144961', 1, '2025-08-26 00:43:41', '2025-09-11 12:15:24', 'Live'),
(23, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '103104-048', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC140711', 1, '2025-08-26 00:44:12', '2025-09-11 12:15:24', 'Live'),
(24, 1, 'GUIDE RING CASTING', 34, NULL, NULL, NULL, '073499-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC73499', 1, '2025-08-26 00:47:47', '2025-09-11 12:15:24', 'Live'),
(25, 1, 'DISC HOLDER CASTING', 34, NULL, NULL, NULL, '014451-1-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '502600900 CAST', 1, '2025-08-26 00:49:03', '2025-09-11 12:15:24', 'Live'),
(26, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '142695-E003', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC142695-E003', 1, '2025-08-26 00:49:38', '2025-09-11 12:15:24', 'Live'),
(27, 1, 'SPINDLE POINT ROD', 22, NULL, '30MM DIA', NULL, '0MM030-R-RD-R56', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '26204M030 ROD', 1, '2025-08-26 00:51:16', '2025-09-11 12:15:24', 'Live'),
(28, 1, 'DISC INSERT ROD', 24, NULL, NULL, NULL, '120050-F-BK-790', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRGM120050-790', 1, '2025-08-26 00:52:33', '2025-09-11 12:15:24', 'Live'),
(29, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '103009-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC103009', 1, '2025-08-26 00:53:04', '2025-09-11 12:15:24', 'Live'),
(30, 1, 'DISC INSERT ROD', 25, NULL, NULL, NULL, 'T02042125-734', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'T02042125-734', 1, '2025-08-26 00:54:26', '2025-09-11 12:15:24', 'Live'),
(31, 1, 'LIFT STOP CASTING', 34, NULL, NULL, NULL, '144960-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC144960', 1, '2025-08-26 00:55:10', '2025-09-11 12:15:24', 'Live'),
(32, 1, 'NOZZLE RING CASTING', 34, NULL, NULL, NULL, '147615-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC147615', 1, '2025-08-26 00:55:40', '2025-09-11 12:15:24', 'Live'),
(33, 1, 'CAP FORGED BLANK', 18, NULL, NULL, NULL, '100145-F-BK-331', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRGM100145-331', 1, '2025-08-26 00:56:38', '2025-09-11 12:15:24', 'Live'),
(34, 1, 'DISC HOLDER RETAINER CASTING INV', 34, NULL, NULL, NULL, '143774-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC143774', 1, '2025-08-26 00:57:11', '2025-09-11 12:15:24', 'Live'),
(35, 1, 'GUIDE CASTING', 34, NULL, NULL, NULL, '122550-043', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRC122550-043', 1, '2025-08-26 00:58:24', '2025-09-11 12:15:24', 'Live'),
(36, 1, 'NOZZLE FORGED ROD', 10, NULL, NULL, NULL, '0P1129Y1-341', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'FRG0P1129Y1-341', 1, '2025-08-26 01:01:08', '2025-09-08 09:11:28', 'Live'),
(37, 1, 'CARBIDE INSERT', 35, 1, NULL, NULL, '', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'CNMG190606', 1, '2025-08-26 23:05:24', '2025-09-08 09:08:52', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rmcategory`
--

CREATE TABLE `tbl_rmcategory` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `mat_type_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rmcategory`
--

INSERT INTO `tbl_rmcategory` (`id`, `company_id`, `mat_type_id`, `name`, `description`, `created_at`, `updated_at`, `del_status`) VALUES
(1, NULL, 1, 'Insert', 'Default Category', '2025-06-20 06:01:36', '2025-09-11 12:16:25', 'Live'),
(2, NULL, 1, 'SA494 GRCW12MW', '', '2025-06-20 18:33:57', '2025-09-11 12:16:25', 'Live'),
(3, NULL, 1, 'SA106 GRB', 'CARBON STEEL', '2025-06-20 18:34:36', '2025-09-11 12:16:25', 'Live'),
(4, NULL, 1, 'HVDI', 'SUPER DUPLEX', '2025-07-03 20:58:07', '2025-09-11 12:16:25', 'Live'),
(5, NULL, 1, 'SA182 GR F316/316L', 'ASTM A182 is a material specification for forged or rolled alloy and stainless steel pipe flanges, forged fittings, and valves and parts intended for high-temperature service', '2025-07-22 19:01:42', '2025-09-11 12:16:25', 'Deleted'),
(6, NULL, 1, 'SS416 CON T/SS440C', 'high-carbon martensitic stainless steel', '2025-07-22 19:20:09', '2025-09-11 12:16:25', 'Deleted'),
(7, NULL, 1, 'SA995 GR6A', 'DUPLEX', '2025-07-22 19:30:23', '2025-09-11 12:16:25', 'Live'),
(8, NULL, 1, 'A351 GRCF8M', 'AUSTENTIC STEEL', '2025-08-08 19:11:02', '2025-09-11 12:16:25', 'Live'),
(9, NULL, 1, 'SA216 GRWCB', 'CARBON STEEL', '2025-08-14 23:42:50', '2025-09-11 12:16:25', 'Live'),
(10, NULL, 1, 'SA182 F316', 'SS316', '2025-08-24 00:44:11', '2025-09-08 09:11:12', 'Live'),
(11, NULL, 1, 'SA564 UNS S17400', '17-4 PH', '2025-08-24 00:45:04', '2025-09-11 12:16:25', 'Live'),
(12, NULL, 1, 'SA479 TP316/316L', 'SS316', '2025-08-24 00:46:07', '2025-09-11 12:16:25', 'Live'),
(13, NULL, 1, 'SA479 UNS S31803', 'DUPLEX', '2025-08-24 00:47:02', '2025-09-11 12:16:25', 'Live'),
(14, NULL, 1, 'SA351 GRCF8C', 'SS304', '2025-08-24 00:49:52', '2025-09-11 12:16:25', 'Live'),
(15, NULL, 1, 'SA106 GR B', 'MILD STEEL', '2025-08-24 00:51:44', '2025-09-11 12:16:25', 'Live'),
(16, NULL, 1, 'SS440C', '', '2025-08-24 00:52:20', '2025-09-11 12:16:25', 'Live'),
(17, NULL, 1, 'SA494 GRM35-1', 'MONEL', '2025-08-24 00:53:12', '2025-09-11 12:16:25', 'Live'),
(18, NULL, 1, 'SA105', 'MILD STEEL', '2025-08-24 00:53:44', '2025-09-11 12:16:25', 'Live'),
(19, NULL, 1, 'SA479 UNS S32760', 'SUPER DUPLEX', '2025-08-24 00:55:30', '2025-09-11 12:16:25', 'Live'),
(20, NULL, 1, 'SA494 GRM-25S', 'S MONEL', '2025-08-24 01:01:51', '2025-09-11 12:16:25', 'Live'),
(21, NULL, 1, 'SA351 GrCF3M', 'SS304', '2025-08-25 23:15:35', '2025-09-11 12:16:25', 'Live'),
(22, NULL, 1, 'B574 UNS N10276', 'HASTELLOY-C', '2025-08-25 23:17:35', '2025-09-11 12:16:25', 'Live'),
(23, NULL, 1, 'B865 UNS N05500', 'INCONEL', '2025-08-25 23:18:29', '2025-09-11 12:16:25', 'Live'),
(24, NULL, 1, 'SB446 UNS N06625', 'INCONEL', '2025-08-25 23:20:47', '2025-09-11 12:16:25', 'Live'),
(25, NULL, 1, 'SA479 UNS S32205', 'DUPLEX', '2025-08-25 23:46:43', '2025-09-11 12:16:25', 'Live'),
(26, NULL, 1, 'B164 UNS N04400', 'MONEL', '2025-08-25 23:47:24', '2025-09-11 12:16:25', 'Live'),
(27, NULL, 1, 'SB425 N08825', 'INCONEL', '2025-08-25 23:59:25', '2025-09-11 12:16:25', 'Live'),
(28, NULL, 1, 'SA217 GRC12A', 'ALLOY STEEL', '2025-08-26 00:02:10', '2025-09-11 12:16:25', 'Live'),
(29, NULL, 1, 'SA995-6A', 'DUPLEX', '2025-08-26 00:02:45', '2025-09-11 12:16:25', 'Live'),
(30, NULL, 1, 'SA182 GRC317L', 'SS317-L', '2025-08-26 00:03:10', '2025-09-11 12:16:25', 'Live'),
(31, NULL, 1, 'SA479 TP321', '', '2025-08-26 00:03:31', '2025-09-11 12:16:25', 'Live'),
(32, NULL, 1, 'SA217 GRWC9', 'STEEL', '2025-08-26 00:04:12', '2025-09-11 12:16:25', 'Live'),
(33, NULL, 1, 'A182 GRF316', 'FORGED 316', '2025-08-26 00:04:53', '2025-09-11 12:16:25', 'Live'),
(34, NULL, 1, 'SA351 GRCF8M', 'SS', '2025-08-26 00:34:28', '2025-09-11 06:52:35', 'Live'),
(35, NULL, 1, 'BORING BAR', 'TOOLS', '2025-08-26 17:45:34', '2025-09-08 08:05:17', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rmstock_adjustment_rmaterials`
--

CREATE TABLE `tbl_rmstock_adjustment_rmaterials` (
  `id` int(11) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `consumption_amount` float(10,2) DEFAULT NULL,
  `inventory_adjustment_id` int(11) DEFAULT NULL,
  `consumption_status` enum('Plus','Minus','','') DEFAULT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rmunits`
--

CREATE TABLE `tbl_rmunits` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rmunits`
--

INSERT INTO `tbl_rmunits` (`id`, `company_id`, `name`, `description`, `created_at`, `updated_at`, `del_status`) VALUES
(1, NULL, 'NOS', 'Number of Weight', '2025-06-05 13:10:06', '2025-06-05 13:10:06', 'Live'),
(2, NULL, 'KG', 'Amount of Kilogram', '2025-06-05 13:10:22', '2025-06-05 13:10:22', 'Live'),
(3, NULL, 'PCS', 'Pieces', '2025-06-05 15:15:46', '2025-06-20 18:29:44', 'Live'),
(4, NULL, 'Test', '', '2025-06-09 18:02:27', '2025-06-09 18:02:32', 'Deleted'),
(5, NULL, 'CM', '', '2025-07-03 20:42:08', '2025-07-03 20:56:48', 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(2, 'Operators', '2025-06-12 13:13:37', '2025-06-12 13:13:37'),
(3, 'Quality Control', '2025-06-12 13:13:55', '2025-06-12 13:13:55'),
(4, 'Management', '2025-07-04 18:11:57', '2025-07-04 18:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_permissions`
--

CREATE TABLE `tbl_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role_permissions`
--

INSERT INTO `tbl_role_permissions` (`id`, `role_id`, `menu_id`, `activity_id`, `created_at`, `updated_at`) VALUES
(149, 2, 4, 8, NULL, NULL),
(150, 2, 4, 9, NULL, NULL),
(151, 2, 4, 10, NULL, NULL),
(152, 2, 4, 11, NULL, NULL),
(153, 2, 4, 12, NULL, NULL),
(154, 2, 4, 14, NULL, NULL),
(155, 2, 11, 68, NULL, NULL),
(156, 2, 11, 69, NULL, NULL),
(157, 2, 11, 70, NULL, NULL),
(158, 2, 11, 71, NULL, NULL),
(159, 2, 11, 72, NULL, NULL),
(160, 2, 11, 73, NULL, NULL),
(161, 2, 11, 74, NULL, NULL),
(162, 2, 11, 75, NULL, NULL),
(163, 2, 1, 1, NULL, NULL),
(164, 2, 3, 5, NULL, NULL),
(165, 2, 3, 6, NULL, NULL),
(166, 2, 3, 7, NULL, NULL),
(167, 2, 4, 13, NULL, NULL),
(168, 2, 9, 50, NULL, NULL),
(169, 2, 9, 51, NULL, NULL),
(170, 2, 21, 56, NULL, NULL),
(171, 2, 21, 57, NULL, NULL),
(172, 2, 21, 62, NULL, NULL),
(173, 2, 21, 63, NULL, NULL),
(174, 2, 21, 64, NULL, NULL),
(175, 2, 10, 65, NULL, NULL),
(176, 2, 10, 66, NULL, NULL),
(177, 2, 10, 67, NULL, NULL),
(178, 2, 11, 80, NULL, NULL),
(179, 2, 11, 81, NULL, NULL),
(180, 2, 11, 82, NULL, NULL),
(181, 2, 11, 83, NULL, NULL),
(182, 2, 12, 93, NULL, NULL),
(183, 2, 5, 117, NULL, NULL),
(184, 2, 20, 164, NULL, NULL),
(185, 2, 10, 173, NULL, NULL),
(186, 3, 2, 2, NULL, NULL),
(187, 3, 3, 3, NULL, NULL),
(188, 3, 3, 4, NULL, NULL),
(189, 3, 4, 8, NULL, NULL),
(190, 3, 4, 9, NULL, NULL),
(191, 3, 4, 10, NULL, NULL),
(192, 3, 4, 11, NULL, NULL),
(193, 3, 4, 12, NULL, NULL),
(194, 3, 4, 14, NULL, NULL),
(195, 3, 5, 15, NULL, NULL),
(196, 3, 5, 16, NULL, NULL),
(197, 3, 5, 17, NULL, NULL),
(198, 3, 5, 18, NULL, NULL),
(199, 3, 5, 19, NULL, NULL),
(200, 3, 5, 20, NULL, NULL),
(201, 3, 5, 21, NULL, NULL),
(202, 3, 5, 22, NULL, NULL),
(203, 3, 5, 23, NULL, NULL),
(204, 3, 5, 24, NULL, NULL),
(205, 3, 5, 25, NULL, NULL),
(206, 3, 5, 26, NULL, NULL),
(207, 3, 5, 109, NULL, NULL),
(208, 3, 5, 110, NULL, NULL),
(209, 3, 5, 111, NULL, NULL),
(210, 3, 5, 112, NULL, NULL),
(211, 3, 5, 113, NULL, NULL),
(212, 3, 5, 114, NULL, NULL),
(213, 3, 5, 115, NULL, NULL),
(214, 3, 5, 116, NULL, NULL),
(215, 3, 6, 27, NULL, NULL),
(216, 3, 6, 28, NULL, NULL),
(217, 3, 6, 29, NULL, NULL),
(218, 3, 6, 30, NULL, NULL),
(219, 3, 6, 31, NULL, NULL),
(220, 3, 7, 32, NULL, NULL),
(221, 3, 9, 43, NULL, NULL),
(222, 3, 9, 44, NULL, NULL),
(223, 3, 9, 45, NULL, NULL),
(224, 3, 9, 46, NULL, NULL),
(225, 3, 9, 47, NULL, NULL),
(226, 3, 9, 48, NULL, NULL),
(227, 3, 9, 49, NULL, NULL),
(228, 3, 10, 168, NULL, NULL),
(229, 3, 10, 169, NULL, NULL),
(230, 3, 10, 170, NULL, NULL),
(231, 3, 10, 171, NULL, NULL),
(232, 3, 10, 172, NULL, NULL),
(233, 3, 10, 174, NULL, NULL),
(234, 3, 10, 175, NULL, NULL),
(235, 3, 11, 68, NULL, NULL),
(236, 3, 11, 69, NULL, NULL),
(237, 3, 11, 70, NULL, NULL),
(238, 3, 11, 71, NULL, NULL),
(239, 3, 11, 72, NULL, NULL),
(240, 3, 11, 73, NULL, NULL),
(241, 3, 11, 74, NULL, NULL),
(242, 3, 11, 75, NULL, NULL),
(243, 3, 12, 84, NULL, NULL),
(244, 3, 12, 85, NULL, NULL),
(245, 3, 12, 86, NULL, NULL),
(246, 3, 12, 87, NULL, NULL),
(247, 3, 12, 88, NULL, NULL),
(248, 3, 12, 89, NULL, NULL),
(249, 3, 12, 90, NULL, NULL),
(250, 3, 12, 91, NULL, NULL),
(251, 3, 12, 92, NULL, NULL),
(252, 3, 13, 94, NULL, NULL),
(253, 3, 13, 95, NULL, NULL),
(254, 3, 13, 96, NULL, NULL),
(255, 3, 13, 97, NULL, NULL),
(256, 3, 14, 101, NULL, NULL),
(257, 3, 14, 102, NULL, NULL),
(258, 3, 14, 103, NULL, NULL),
(259, 3, 14, 104, NULL, NULL),
(260, 3, 15, 105, NULL, NULL),
(261, 3, 15, 106, NULL, NULL),
(262, 3, 15, 107, NULL, NULL),
(263, 3, 15, 108, NULL, NULL),
(264, 3, 18, 139, NULL, NULL),
(265, 3, 18, 140, NULL, NULL),
(266, 3, 18, 141, NULL, NULL),
(267, 3, 18, 142, NULL, NULL),
(268, 3, 18, 143, NULL, NULL),
(269, 3, 18, 144, NULL, NULL),
(270, 3, 18, 145, NULL, NULL),
(271, 3, 18, 146, NULL, NULL),
(272, 3, 19, 147, NULL, NULL),
(273, 3, 19, 148, NULL, NULL),
(274, 3, 19, 149, NULL, NULL),
(275, 3, 19, 150, NULL, NULL),
(276, 3, 19, 151, NULL, NULL),
(277, 3, 19, 152, NULL, NULL),
(278, 3, 19, 153, NULL, NULL),
(279, 3, 19, 154, NULL, NULL),
(280, 3, 20, 159, NULL, NULL),
(281, 3, 20, 165, NULL, NULL),
(282, 3, 20, 166, NULL, NULL),
(283, 3, 20, 167, NULL, NULL),
(284, 3, 21, 52, NULL, NULL),
(285, 3, 21, 53, NULL, NULL),
(286, 3, 21, 54, NULL, NULL),
(287, 3, 21, 55, NULL, NULL),
(288, 3, 21, 58, NULL, NULL),
(289, 3, 21, 59, NULL, NULL),
(290, 3, 21, 60, NULL, NULL),
(291, 3, 21, 61, NULL, NULL),
(292, 3, 22, 76, NULL, NULL),
(293, 3, 22, 77, NULL, NULL),
(294, 3, 22, 78, NULL, NULL),
(295, 3, 22, 79, NULL, NULL),
(296, 3, 23, 98, NULL, NULL),
(297, 3, 23, 99, NULL, NULL),
(298, 3, 23, 100, NULL, NULL),
(299, 3, 24, 155, NULL, NULL),
(300, 3, 24, 156, NULL, NULL),
(301, 3, 24, 157, NULL, NULL),
(302, 3, 24, 158, NULL, NULL),
(303, 3, 24, 160, NULL, NULL),
(304, 3, 24, 161, NULL, NULL),
(305, 3, 24, 162, NULL, NULL),
(306, 3, 24, 163, NULL, NULL),
(307, 3, 24, 176, NULL, NULL),
(308, 3, 24, 177, NULL, NULL),
(309, 3, 24, 178, NULL, NULL),
(310, 3, 24, 179, NULL, NULL),
(311, 3, 1, 1, NULL, NULL),
(312, 3, 3, 5, NULL, NULL),
(313, 3, 3, 6, NULL, NULL),
(314, 3, 3, 7, NULL, NULL),
(315, 3, 4, 13, NULL, NULL),
(316, 3, 9, 50, NULL, NULL),
(317, 3, 9, 51, NULL, NULL),
(318, 3, 21, 56, NULL, NULL),
(319, 3, 21, 57, NULL, NULL),
(320, 3, 21, 62, NULL, NULL),
(321, 3, 21, 63, NULL, NULL),
(322, 3, 21, 64, NULL, NULL),
(323, 3, 10, 65, NULL, NULL),
(324, 3, 10, 66, NULL, NULL),
(325, 3, 10, 67, NULL, NULL),
(326, 3, 11, 80, NULL, NULL),
(327, 3, 11, 81, NULL, NULL),
(328, 3, 11, 82, NULL, NULL),
(329, 3, 11, 83, NULL, NULL),
(330, 3, 12, 93, NULL, NULL),
(331, 3, 5, 117, NULL, NULL),
(332, 3, 20, 164, NULL, NULL),
(333, 3, 10, 173, NULL, NULL),
(450, 4, 2, 2, NULL, NULL),
(451, 4, 3, 3, NULL, NULL),
(452, 4, 3, 4, NULL, NULL),
(453, 4, 4, 8, NULL, NULL),
(454, 4, 4, 9, NULL, NULL),
(455, 4, 4, 10, NULL, NULL),
(456, 4, 4, 11, NULL, NULL),
(457, 4, 4, 12, NULL, NULL),
(458, 4, 4, 14, NULL, NULL),
(459, 4, 5, 15, NULL, NULL),
(460, 4, 5, 16, NULL, NULL),
(461, 4, 5, 17, NULL, NULL),
(462, 4, 5, 18, NULL, NULL),
(463, 4, 5, 19, NULL, NULL),
(464, 4, 5, 20, NULL, NULL),
(465, 4, 5, 21, NULL, NULL),
(466, 4, 5, 22, NULL, NULL),
(467, 4, 5, 23, NULL, NULL),
(468, 4, 5, 24, NULL, NULL),
(469, 4, 5, 25, NULL, NULL),
(470, 4, 5, 26, NULL, NULL),
(471, 4, 5, 109, NULL, NULL),
(472, 4, 5, 110, NULL, NULL),
(473, 4, 5, 111, NULL, NULL),
(474, 4, 5, 112, NULL, NULL),
(475, 4, 5, 113, NULL, NULL),
(476, 4, 5, 114, NULL, NULL),
(477, 4, 5, 115, NULL, NULL),
(478, 4, 5, 116, NULL, NULL),
(479, 4, 6, 27, NULL, NULL),
(480, 4, 6, 28, NULL, NULL),
(481, 4, 6, 29, NULL, NULL),
(482, 4, 6, 30, NULL, NULL),
(483, 4, 6, 31, NULL, NULL),
(484, 4, 9, 43, NULL, NULL),
(485, 4, 9, 44, NULL, NULL),
(486, 4, 9, 45, NULL, NULL),
(487, 4, 9, 46, NULL, NULL),
(488, 4, 9, 47, NULL, NULL),
(489, 4, 9, 48, NULL, NULL),
(490, 4, 9, 49, NULL, NULL),
(491, 4, 10, 168, NULL, NULL),
(492, 4, 10, 169, NULL, NULL),
(493, 4, 10, 170, NULL, NULL),
(494, 4, 10, 171, NULL, NULL),
(495, 4, 10, 172, NULL, NULL),
(496, 4, 10, 174, NULL, NULL),
(497, 4, 10, 175, NULL, NULL),
(498, 4, 11, 68, NULL, NULL),
(499, 4, 11, 69, NULL, NULL),
(500, 4, 11, 70, NULL, NULL),
(501, 4, 11, 71, NULL, NULL),
(502, 4, 11, 72, NULL, NULL),
(503, 4, 11, 73, NULL, NULL),
(504, 4, 11, 74, NULL, NULL),
(505, 4, 11, 75, NULL, NULL),
(506, 4, 12, 84, NULL, NULL),
(507, 4, 12, 85, NULL, NULL),
(508, 4, 12, 86, NULL, NULL),
(509, 4, 12, 87, NULL, NULL),
(510, 4, 12, 88, NULL, NULL),
(511, 4, 12, 89, NULL, NULL),
(512, 4, 12, 90, NULL, NULL),
(513, 4, 12, 91, NULL, NULL),
(514, 4, 12, 92, NULL, NULL),
(515, 4, 14, 101, NULL, NULL),
(516, 4, 14, 102, NULL, NULL),
(517, 4, 14, 103, NULL, NULL),
(518, 4, 14, 104, NULL, NULL),
(519, 4, 15, 105, NULL, NULL),
(520, 4, 15, 106, NULL, NULL),
(521, 4, 15, 107, NULL, NULL),
(522, 4, 15, 108, NULL, NULL),
(523, 4, 18, 139, NULL, NULL),
(524, 4, 18, 140, NULL, NULL),
(525, 4, 18, 141, NULL, NULL),
(526, 4, 18, 142, NULL, NULL),
(527, 4, 18, 143, NULL, NULL),
(528, 4, 18, 144, NULL, NULL),
(529, 4, 18, 145, NULL, NULL),
(530, 4, 18, 146, NULL, NULL),
(531, 4, 22, 76, NULL, NULL),
(532, 4, 22, 77, NULL, NULL),
(533, 4, 22, 78, NULL, NULL),
(534, 4, 22, 79, NULL, NULL),
(535, 4, 23, 98, NULL, NULL),
(536, 4, 23, 99, NULL, NULL),
(537, 4, 23, 100, NULL, NULL),
(538, 4, 1, 1, NULL, NULL),
(539, 4, 3, 5, NULL, NULL),
(540, 4, 3, 6, NULL, NULL),
(541, 4, 3, 7, NULL, NULL),
(542, 4, 4, 13, NULL, NULL),
(543, 4, 9, 50, NULL, NULL),
(544, 4, 9, 51, NULL, NULL),
(545, 4, 21, 56, NULL, NULL),
(546, 4, 21, 57, NULL, NULL),
(547, 4, 21, 62, NULL, NULL),
(548, 4, 21, 63, NULL, NULL),
(549, 4, 21, 64, NULL, NULL),
(550, 4, 10, 65, NULL, NULL),
(551, 4, 10, 66, NULL, NULL),
(552, 4, 10, 67, NULL, NULL),
(553, 4, 11, 80, NULL, NULL),
(554, 4, 11, 81, NULL, NULL),
(555, 4, 11, 82, NULL, NULL),
(556, 4, 11, 83, NULL, NULL),
(557, 4, 12, 93, NULL, NULL),
(558, 4, 5, 117, NULL, NULL),
(559, 4, 20, 164, NULL, NULL),
(560, 4, 10, 173, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_route_card_entries`
--

CREATE TABLE `tbl_route_card_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salaries`
--

CREATE TABLE `tbl_salaries` (
  `id` int(11) NOT NULL,
  `month` varchar(11) DEFAULT NULL,
  `year` varchar(11) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `details_info` mediumtext DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 0,
  `del_status` varchar(11) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_salaries`
--

INSERT INTO `tbl_salaries` (`id`, `month`, `year`, `date`, `total_amount`, `details_info`, `account_id`, `user_id`, `company_id`, `del_status`) VALUES
(1, 'June', '2025', '2025-07-04', 92000, '[{\"p_status\":1,\"user_id\":\"1\",\"name\":\"Admin\",\"salary\":\"0.00\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"0.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"2\",\"name\":\"Kannan\",\"salary\":\"12000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"12000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"3\",\"name\":\"Kumar\",\"salary\":\"15000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"15000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"4\",\"name\":\"Robert\",\"salary\":\"30000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"30000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"5\",\"name\":\"Amirtha\",\"salary\":\"35000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"35000.00\",\"notes\":\"\"},{\"p_status\":\"\",\"user_id\":\"7\",\"name\":\"Sridhar\",\"salary\":\"40000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"40000.00\",\"notes\":\"\"}]', NULL, 1, 1, 'Live'),
(2, 'April', '2022', '2025-07-07', 131900, '[{\"p_status\":\"\",\"user_id\":\"1\",\"name\":\"Admin\",\"salary\":\"0.00\",\"additional\":\"500\",\"subtraction\":\"0.00\",\"total\":\"500.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"2\",\"name\":\"Kannan\",\"salary\":\"12000\",\"additional\":\"0.00\",\"subtraction\":\"100\",\"total\":\"11900.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"3\",\"name\":\"Kumar\",\"salary\":\"15000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"15000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"4\",\"name\":\"Robert\",\"salary\":\"30000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"30000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"5\",\"name\":\"Amirtha\",\"salary\":\"35000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"35000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"7\",\"name\":\"Sridhar\",\"salary\":\"40000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"40000.00\",\"notes\":\"\"}]', NULL, 1, 1, 'Live'),
(3, 'November', '2025', '2025-07-23', NULL, NULL, NULL, 1, 1, 'Deleted'),
(4, 'July', '2025', '2025-07-23', 132000, '[{\"p_status\":1,\"user_id\":\"1\",\"name\":\"Admin\",\"salary\":\"0.00\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"0.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"2\",\"name\":\"Kannan\",\"salary\":\"12000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"12000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"3\",\"name\":\"Kumar\",\"salary\":\"15000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"15000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"4\",\"name\":\"Robert\",\"salary\":\"30000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"30000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"5\",\"name\":\"Amirtha\",\"salary\":\"35000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"35000.00\",\"notes\":\"\"},{\"p_status\":1,\"user_id\":\"7\",\"name\":\"Sridhar\",\"salary\":\"40000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"40000.00\",\"notes\":\"\"}]', NULL, 1, 1, 'Live'),
(5, 'January', '2025', '2025-07-26', NULL, NULL, NULL, 1, 1, 'Deleted'),
(6, 'February', '2019', '2025-08-09', 0, '[{\"p_status\":\"\",\"user_id\":\"1\",\"name\":\"Admin\",\"salary\":\"0.00\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"0.00\",\"notes\":\"\"},{\"p_status\":\"\",\"user_id\":\"2\",\"name\":\"Kannan\",\"salary\":\"12000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"12000.00\",\"notes\":\"\"},{\"p_status\":\"\",\"user_id\":\"3\",\"name\":\"Kumar\",\"salary\":\"15000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"15000.00\",\"notes\":\"\"},{\"p_status\":\"\",\"user_id\":\"4\",\"name\":\"Robert\",\"salary\":\"30000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"30000.00\",\"notes\":\"\"},{\"p_status\":\"\",\"user_id\":\"5\",\"name\":\"Amirtha\",\"salary\":\"35000\",\"additional\":\"0.00\",\"subtraction\":\"0.00\",\"total\":\"35000.00\",\"notes\":\"\"}]', NULL, 1, 1, 'Live'),
(7, 'January', '2018', '2025-08-25', NULL, NULL, NULL, 1, 1, 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `challan_id` int(11) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `other` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `grand_total` float DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `paid` float DEFAULT NULL,
  `due` float DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `manufacture_details` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`id`, `reference_no`, `challan_id`, `product_id`, `customer_id`, `sale_date`, `status`, `product_quantity`, `subtotal`, `other`, `discount`, `grand_total`, `account_id`, `paid`, `due`, `note`, `manufacture_details`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'L/001/25-26', 1, NULL, 2, '2025-09-11', NULL, 2, 1792, 0, 0, 1792, NULL, 1792, 0, '', NULL, 1, '2025-09-11 13:19:06', '2025-09-11 13:19:06', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_consumptions_of_menus`
--

CREATE TABLE `tbl_sale_consumptions_of_menus` (
  `id` bigint(20) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `consumption` float(10,2) DEFAULT NULL,
  `sale_consumption_id` int(11) DEFAULT NULL,
  `sales_id` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL COMMENT '1=new order,2=invoiced order, 3=closed order',
  `food_menu_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_consumptions_of_modifiers_of_menus`
--

CREATE TABLE `tbl_sale_consumptions_of_modifiers_of_menus` (
  `id` bigint(20) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `consumption` float(10,2) DEFAULT NULL,
  `sale_consumption_id` int(11) DEFAULT NULL,
  `sales_id` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL COMMENT '1=new order,2=invoiced order, 3=closed order',
  `food_menu_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_details`
--

CREATE TABLE `tbl_sale_details` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `unit_price` float(10,2) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `total_amount` float(10,2) DEFAULT NULL,
  `srn` varchar(50) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sale_details`
--

INSERT INTO `tbl_sale_details` (`id`, `sale_id`, `product_id`, `order_id`, `manufacture_id`, `unit_price`, `product_quantity`, `total_amount`, `srn`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 1, 1, 1792.00, 2, 1792.00, 'ABC Chemicals Ltd.', 'Live', '2025-09-11 13:19:07', '2025-09-11 13:19:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sessions`
--

CREATE TABLE `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_adjust_logs`
--

CREATE TABLE `tbl_stock_adjust_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mat_stock_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '1.addition 2.subtraction',
  `stock_type` varchar(20) NOT NULL,
  `reference_no` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `dc_no` varchar(50) DEFAULT NULL,
  `heat_no` text DEFAULT NULL,
  `dc_date` date DEFAULT NULL,
  `mat_doc_no` varchar(100) DEFAULT NULL,
  `dc_inward_price` float DEFAULT NULL,
  `material_price` float DEFAULT NULL,
  `hsn_no` varchar(50) DEFAULT NULL,
  `del_status` varchar(255) NOT NULL DEFAULT 'Live',
  `added_by` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `id` int(11) NOT NULL,
  `supplier_id` varchar(30) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `contact_person` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `gst_no` varchar(16) DEFAULT NULL,
  `ecc_no` varchar(20) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `opening_balance` int(11) DEFAULT NULL,
  `opening_balance_type` varchar(50) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `credit_limit` float(10,2) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`id`, `supplier_id`, `name`, `contact_person`, `phone`, `email`, `address`, `gst_no`, `ecc_no`, `area`, `note`, `opening_balance`, `opening_balance_type`, `added_by`, `company_id`, `created_at`, `updated_at`, `credit_limit`, `del_status`) VALUES
(1, 'SUP0001', 'Muthamil', '', '9655335656', '', '', '', '', '', '', 0, '', 1, 1, '2025-08-12 21:07:51', '2025-08-14 23:33:51', 0.00, 'Deleted'),
(2, 'SUP0002', 'Sai Technologies', 'Elakkiya', '9894867672', 'elakkiya.saitech@gmail.com', 'Vilangudi, Madurai', '', '', '', '', 0, '', 1, 1, '2025-08-15 01:10:30', '2025-08-15 01:10:30', 0.00, 'Live'),
(3, 'SUP0003', 'MS Construction', '', '9966336699', '', '', '', '', '', '', 0, '', 1, 1, '2025-09-05 07:47:49', '2025-09-05 07:47:56', 0.00, 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_contact_info`
--

CREATE TABLE `tbl_supplier_contact_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `scp_name` varchar(50) NOT NULL,
  `scp_department` varchar(30) NOT NULL,
  `scp_designation` varchar(30) NOT NULL,
  `scp_phone` text NOT NULL,
  `scp_email` varchar(128) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier_contact_info`
--

INSERT INTO `tbl_supplier_contact_info` (`id`, `supplier_id`, `scp_name`, `scp_department`, `scp_designation`, `scp_phone`, `scp_email`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Praveen', 'HR', 'Manager', '9876543210', '', 'Deleted', '2025-09-05 05:56:29', '2025-09-05 09:02:43'),
(2, 2, 'Sridhar', 'CEO', 'Management', '9874563210', '', 'Deleted', '2025-09-05 05:57:33', '2025-09-05 09:02:43'),
(3, 2, 'Praveen', 'HR', 'Manager', '9876543210', '', 'Deleted', '2025-09-05 06:09:09', '2025-09-05 09:02:43'),
(4, 2, 'Sridhar', 'CEO', 'Management', '9874563210', '', 'Deleted', '2025-09-05 06:09:09', '2025-09-05 09:02:43'),
(5, 3, 'Kumar', 'Purchase', 'Management', '9693969396', '', 'Deleted', '2025-09-05 07:47:49', '2025-09-05 07:47:55'),
(6, 2, 'Praveen', 'HR', 'Manager', '9876543210', '', 'Deleted', '2025-09-05 08:15:12', '2025-09-05 09:02:43'),
(7, 2, 'Praveen', 'HR', 'Manager', '9876543210', '', 'Live', '2025-09-05 09:02:43', '2025-09-05 09:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payments`
--

CREATE TABLE `tbl_supplier_payments` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `purchase_no` varchar(20) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `pay_amount` float(10,2) NOT NULL,
  `bal_amount` float(10,2) NOT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=Hold,2=Initiated,3=Partially Paid,4=paid',
  `pay_type` varchar(10) DEFAULT NULL,
  `payment_proof` varchar(150) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taxes`
--

CREATE TABLE `tbl_taxes` (
  `id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `tax` varchar(50) NOT NULL,
  `tax_rate` float(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(100) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_taxes`
--

INSERT INTO `tbl_taxes` (`id`, `tax_id`, `tax`, `tax_rate`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 1, 'CGST', 6.00, '2025-05-22 10:09:47', '2025-07-23 17:00:16', 'Live'),
(2, 1, 'SGST', 6.00, '2025-05-22 10:09:47', '2025-07-23 17:00:16', 'Live'),
(3, 1, 'IGST', 12.00, '2025-05-22 10:09:47', '2025-07-23 17:00:16', 'Live'),
(4, 2, 'CGST', 9.00, '2025-05-22 17:32:08', '2025-05-23 06:30:19', 'Live'),
(5, 2, 'SGST', 9.00, '2025-05-22 17:32:08', '2025-05-23 06:30:19', 'Live'),
(6, 2, 'IGST', 18.00, '2025-05-22 17:32:08', '2025-05-23 06:30:19', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax_items`
--

CREATE TABLE `tbl_tax_items` (
  `id` int(11) NOT NULL,
  `collect_tax` varchar(50) DEFAULT NULL,
  `tax_registration_number` varchar(50) DEFAULT NULL,
  `tax_type` varchar(45) NOT NULL,
  `tax_value` decimal(10,0) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tax_items`
--

INSERT INTO `tbl_tax_items` (`id`, `collect_tax`, `tax_registration_number`, `tax_type`, `tax_value`, `added_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'Yes', NULL, 'Labor', 12, NULL, '2025-05-22 10:09:47', '2025-07-23 17:00:16', 'Live'),
(2, 'Yes', NULL, 'Sales', 18, NULL, '2025-05-22 17:30:43', '2025-06-09 19:06:46', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time_zone`
--

CREATE TABLE `tbl_time_zone` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `zone_name` varchar(35) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_time_zone`
--

INSERT INTO `tbl_time_zone` (`id`, `country_code`, `zone_name`, `del_status`) VALUES
(1, 'AD', 'Europe/Andorra', 'Live'),
(2, 'AE', 'Asia/Dubai', 'Live'),
(3, 'AF', 'Asia/Kabul', 'Live'),
(4, 'AG', 'America/Antigua', 'Live'),
(5, 'AI', 'America/Anguilla', 'Live'),
(6, 'AL', 'Europe/Tirane', 'Live'),
(7, 'AM', 'Asia/Yerevan', 'Live'),
(8, 'AO', 'Africa/Luanda', 'Live'),
(9, 'AQ', 'Antarctica/McMurdo', 'Live'),
(10, 'AQ', 'Antarctica/Casey', 'Live'),
(11, 'AQ', 'Antarctica/Davis', 'Live'),
(12, 'AQ', 'Antarctica/DumontDUrville', 'Live'),
(13, 'AQ', 'Antarctica/Mawson', 'Live'),
(14, 'AQ', 'Antarctica/Palmer', 'Live'),
(15, 'AQ', 'Antarctica/Rothera', 'Live'),
(16, 'AQ', 'Antarctica/Syowa', 'Live'),
(17, 'AQ', 'Antarctica/Troll', 'Live'),
(18, 'AQ', 'Antarctica/Vostok', 'Live'),
(19, 'AR', 'America/Argentina/Buenos_Aires', 'Live'),
(20, 'AR', 'America/Argentina/Cordoba', 'Live'),
(21, 'AR', 'America/Argentina/Salta', 'Live'),
(22, 'AR', 'America/Argentina/Jujuy', 'Live'),
(23, 'AR', 'America/Argentina/Tucuman', 'Live'),
(24, 'AR', 'America/Argentina/Catamarca', 'Live'),
(25, 'AR', 'America/Argentina/La_Rioja', 'Live'),
(26, 'AR', 'America/Argentina/San_Juan', 'Live'),
(27, 'AR', 'America/Argentina/Mendoza', 'Live'),
(28, 'AR', 'America/Argentina/San_Luis', 'Live'),
(29, 'AR', 'America/Argentina/Rio_Gallegos', 'Live'),
(30, 'AR', 'America/Argentina/Ushuaia', 'Live'),
(31, 'AS', 'Pacific/Pago_Pago', 'Live'),
(32, 'AT', 'Europe/Vienna', 'Live'),
(33, 'AU', 'Australia/Lord_Howe', 'Live'),
(34, 'AU', 'Antarctica/Macquarie', 'Live'),
(35, 'AU', 'Australia/Hobart', 'Live'),
(36, 'AU', 'Australia/Currie', 'Live'),
(37, 'AU', 'Australia/Melbourne', 'Live'),
(38, 'AU', 'Australia/Sydney', 'Live'),
(39, 'AU', 'Australia/Broken_Hill', 'Live'),
(40, 'AU', 'Australia/Brisbane', 'Live'),
(41, 'AU', 'Australia/Lindeman', 'Live'),
(42, 'AU', 'Australia/Adelaide', 'Live'),
(43, 'AU', 'Australia/Darwin', 'Live'),
(44, 'AU', 'Australia/Perth', 'Live'),
(45, 'AU', 'Australia/Eucla', 'Live'),
(46, 'AW', 'America/Aruba', 'Live'),
(47, 'AX', 'Europe/Mariehamn', 'Live'),
(48, 'AZ', 'Asia/Baku', 'Live'),
(49, 'BA', 'Europe/Sarajevo', 'Live'),
(50, 'BB', 'America/Barbados', 'Live'),
(51, 'BD', 'Asia/Dhaka', 'Live'),
(52, 'BE', 'Europe/Brussels', 'Live'),
(53, 'BF', 'Africa/Ouagadougou', 'Live'),
(54, 'BG', 'Europe/Sofia', 'Live'),
(55, 'BH', 'Asia/Bahrain', 'Live'),
(56, 'BI', 'Africa/Bujumbura', 'Live'),
(57, 'BJ', 'Africa/Porto-Novo', 'Live'),
(58, 'BL', 'America/St_Barthelemy', 'Live'),
(59, 'BM', 'Atlantic/Bermuda', 'Live'),
(60, 'BN', 'Asia/Brunei', 'Live'),
(61, 'BO', 'America/La_Paz', 'Live'),
(62, 'BQ', 'America/Kralendijk', 'Live'),
(63, 'BR', 'America/Noronha', 'Live'),
(64, 'BR', 'America/Belem', 'Live'),
(65, 'BR', 'America/Fortaleza', 'Live'),
(66, 'BR', 'America/Recife', 'Live'),
(67, 'BR', 'America/Araguaina', 'Live'),
(68, 'BR', 'America/Maceio', 'Live'),
(69, 'BR', 'America/Bahia', 'Live'),
(70, 'BR', 'America/Sao_Paulo', 'Live'),
(71, 'BR', 'America/Campo_Grande', 'Live'),
(72, 'BR', 'America/Cuiaba', 'Live'),
(73, 'BR', 'America/Santarem', 'Live'),
(74, 'BR', 'America/Porto_Velho', 'Live'),
(75, 'BR', 'America/Boa_Vista', 'Live'),
(76, 'BR', 'America/Manaus', 'Live'),
(77, 'BR', 'America/Eirunepe', 'Live'),
(78, 'BR', 'America/Rio_Branco', 'Live'),
(79, 'BS', 'America/Nassau', 'Live'),
(80, 'BT', 'Asia/Thimphu', 'Live'),
(81, 'BW', 'Africa/Gaborone', 'Live'),
(82, 'BY', 'Europe/Minsk', 'Live'),
(83, 'BZ', 'America/Belize', 'Live'),
(84, 'CA', 'America/St_Johns', 'Live'),
(85, 'CA', 'America/Halifax', 'Live'),
(86, 'CA', 'America/Glace_Bay', 'Live'),
(87, 'CA', 'America/Moncton', 'Live'),
(88, 'CA', 'America/Goose_Bay', 'Live'),
(89, 'CA', 'America/Blanc-Sablon', 'Live'),
(90, 'CA', 'America/Toronto', 'Live'),
(91, 'CA', 'America/Nipigon', 'Live'),
(92, 'CA', 'America/Thunder_Bay', 'Live'),
(93, 'CA', 'America/Iqaluit', 'Live'),
(94, 'CA', 'America/Pangnirtung', 'Live'),
(95, 'CA', 'America/Atikokan', 'Live'),
(96, 'CA', 'America/Winnipeg', 'Live'),
(97, 'CA', 'America/Rainy_River', 'Live'),
(98, 'CA', 'America/Resolute', 'Live'),
(99, 'CA', 'America/Rankin_Inlet', 'Live'),
(100, 'CA', 'America/Regina', 'Live'),
(101, 'CA', 'America/Swift_Current', 'Live'),
(102, 'CA', 'America/Edmonton', 'Live'),
(103, 'CA', 'America/Cambridge_Bay', 'Live'),
(104, 'CA', 'America/Yellowknife', 'Live'),
(105, 'CA', 'America/Inuvik', 'Live'),
(106, 'CA', 'America/Creston', 'Live'),
(107, 'CA', 'America/Dawson_Creek', 'Live'),
(108, 'CA', 'America/Fort_Nelson', 'Live'),
(109, 'CA', 'America/Vancouver', 'Live'),
(110, 'CA', 'America/Whitehorse', 'Live'),
(111, 'CA', 'America/Dawson', 'Live'),
(112, 'CC', 'Indian/Cocos', 'Live'),
(113, 'CD', 'Africa/Kinshasa', 'Live'),
(114, 'CD', 'Africa/Lubumbashi', 'Live'),
(115, 'CF', 'Africa/Bangui', 'Live'),
(116, 'CG', 'Africa/Brazzaville', 'Live'),
(117, 'CH', 'Europe/Zurich', 'Live'),
(118, 'CI', 'Africa/Abidjan', 'Live'),
(119, 'CK', 'Pacific/Rarotonga', 'Live'),
(120, 'CL', 'America/Santiago', 'Live'),
(121, 'CL', 'America/Punta_Arenas', 'Live'),
(122, 'CL', 'Pacific/Easter', 'Live'),
(123, 'CM', 'Africa/Douala', 'Live'),
(124, 'CN', 'Asia/Shanghai', 'Live'),
(125, 'CN', 'Asia/Urumqi', 'Live'),
(126, 'CO', 'America/Bogota', 'Live'),
(127, 'CR', 'America/Costa_Rica', 'Live'),
(128, 'CU', 'America/Havana', 'Live'),
(129, 'CV', 'Atlantic/Cape_Verde', 'Live'),
(130, 'CW', 'America/Curacao', 'Live'),
(131, 'CX', 'Indian/Christmas', 'Live'),
(132, 'CY', 'Asia/Nicosia', 'Live'),
(133, 'CY', 'Asia/Famagusta', 'Live'),
(134, 'CZ', 'Europe/Prague', 'Live'),
(135, 'DE', 'Europe/Berlin', 'Live'),
(136, 'DE', 'Europe/Busingen', 'Live'),
(137, 'DJ', 'Africa/Djibouti', 'Live'),
(138, 'DK', 'Europe/Copenhagen', 'Live'),
(139, 'DM', 'America/Dominica', 'Live'),
(140, 'DO', 'America/Santo_Domingo', 'Live'),
(141, 'DZ', 'Africa/Algiers', 'Live'),
(142, 'EC', 'America/Guayaquil', 'Live'),
(143, 'EC', 'Pacific/Galapagos', 'Live'),
(144, 'EE', 'Europe/Tallinn', 'Live'),
(145, 'EG', 'Africa/Cairo', 'Live'),
(146, 'EH', 'Africa/El_Aaiun', 'Live'),
(147, 'ER', 'Africa/Asmara', 'Live'),
(148, 'ES', 'Europe/Madrid', 'Live'),
(149, 'ES', 'Africa/Ceuta', 'Live'),
(150, 'ES', 'Atlantic/Canary', 'Live'),
(151, 'ET', 'Africa/Addis_Ababa', 'Live'),
(152, 'FI', 'Europe/Helsinki', 'Live'),
(153, 'FJ', 'Pacific/Fiji', 'Live'),
(154, 'FK', 'Atlantic/Stanley', 'Live'),
(155, 'FM', 'Pacific/Chuuk', 'Live'),
(156, 'FM', 'Pacific/Pohnpei', 'Live'),
(157, 'FM', 'Pacific/Kosrae', 'Live'),
(158, 'FO', 'Atlantic/Faroe', 'Live'),
(159, 'FR', 'Europe/Paris', 'Live'),
(160, 'GA', 'Africa/Libreville', 'Live'),
(161, 'GB', 'Europe/London', 'Live'),
(162, 'GD', 'America/Grenada', 'Live'),
(163, 'GE', 'Asia/Tbilisi', 'Live'),
(164, 'GF', 'America/Cayenne', 'Live'),
(165, 'GG', 'Europe/Guernsey', 'Live'),
(166, 'GH', 'Africa/Accra', 'Live'),
(167, 'GI', 'Europe/Gibraltar', 'Live'),
(168, 'GL', 'America/Godthab', 'Live'),
(169, 'GL', 'America/Danmarkshavn', 'Live'),
(170, 'GL', 'America/Scoresbysund', 'Live'),
(171, 'GL', 'America/Thule', 'Live'),
(172, 'GM', 'Africa/Banjul', 'Live'),
(173, 'GN', 'Africa/Conakry', 'Live'),
(174, 'GP', 'America/Guadeloupe', 'Live'),
(175, 'GQ', 'Africa/Malabo', 'Live'),
(176, 'GR', 'Europe/Athens', 'Live'),
(177, 'GS', 'Atlantic/South_Georgia', 'Live'),
(178, 'GT', 'America/Guatemala', 'Live'),
(179, 'GU', 'Pacific/Guam', 'Live'),
(180, 'GW', 'Africa/Bissau', 'Live'),
(181, 'GY', 'America/Guyana', 'Live'),
(182, 'HK', 'Asia/Hong_Kong', 'Live'),
(183, 'HN', 'America/Tegucigalpa', 'Live'),
(184, 'HR', 'Europe/Zagreb', 'Live'),
(185, 'HT', 'America/Port-au-Prince', 'Live'),
(186, 'HU', 'Europe/Budapest', 'Live'),
(187, 'ID', 'Asia/Jakarta', 'Live'),
(188, 'ID', 'Asia/Pontianak', 'Live'),
(189, 'ID', 'Asia/Makassar', 'Live'),
(190, 'ID', 'Asia/Jayapura', 'Live'),
(191, 'IE', 'Europe/Dublin', 'Live'),
(192, 'IL', 'Asia/Jerusalem', 'Live'),
(193, 'IM', 'Europe/Isle_of_Man', 'Live'),
(194, 'IN', 'Asia/Kolkata', 'Live'),
(195, 'IO', 'Indian/Chagos', 'Live'),
(196, 'IQ', 'Asia/Baghdad', 'Live'),
(197, 'IR', 'Asia/Tehran', 'Live'),
(198, 'IS', 'Atlantic/Reykjavik', 'Live'),
(199, 'IT', 'Europe/Rome', 'Live'),
(200, 'JE', 'Europe/Jersey', 'Live'),
(201, 'JM', 'America/Jamaica', 'Live'),
(202, 'JO', 'Asia/Amman', 'Live'),
(203, 'JP', 'Asia/Tokyo', 'Live'),
(204, 'KE', 'Africa/Nairobi', 'Live'),
(205, 'KG', 'Asia/Bishkek', 'Live'),
(206, 'KH', 'Asia/Phnom_Penh', 'Live'),
(207, 'KI', 'Pacific/Tarawa', 'Live'),
(208, 'KI', 'Pacific/Enderbury', 'Live'),
(209, 'KI', 'Pacific/Kiritimati', 'Live'),
(210, 'KM', 'Indian/Comoro', 'Live'),
(211, 'KN', 'America/St_Kitts', 'Live'),
(212, 'KP', 'Asia/Pyongyang', 'Live'),
(213, 'KR', 'Asia/Seoul', 'Live'),
(214, 'KW', 'Asia/Kuwait', 'Live'),
(215, 'KY', 'America/Cayman', 'Live'),
(216, 'KZ', 'Asia/Almaty', 'Live'),
(217, 'KZ', 'Asia/Qyzylorda', 'Live'),
(218, 'KZ', 'Asia/Aqtobe', 'Live'),
(219, 'KZ', 'Asia/Aqtau', 'Live'),
(220, 'KZ', 'Asia/Atyrau', 'Live'),
(221, 'KZ', 'Asia/Oral', 'Live'),
(222, 'LA', 'Asia/Vientiane', 'Live'),
(223, 'LB', 'Asia/Beirut', 'Live'),
(224, 'LC', 'America/St_Lucia', 'Live'),
(225, 'LI', 'Europe/Vaduz', 'Live'),
(226, 'LK', 'Asia/Colombo', 'Live'),
(227, 'LR', 'Africa/Monrovia', 'Live'),
(228, 'LS', 'Africa/Maseru', 'Live'),
(229, 'LT', 'Europe/Vilnius', 'Live'),
(230, 'LU', 'Europe/Luxembourg', 'Live'),
(231, 'LV', 'Europe/Riga', 'Live'),
(232, 'LY', 'Africa/Tripoli', 'Live'),
(233, 'MA', 'Africa/Casablanca', 'Live'),
(234, 'MC', 'Europe/Monaco', 'Live'),
(235, 'MD', 'Europe/Chisinau', 'Live'),
(236, 'ME', 'Europe/Podgorica', 'Live'),
(237, 'MF', 'America/Marigot', 'Live'),
(238, 'MG', 'Indian/Antananarivo', 'Live'),
(239, 'MH', 'Pacific/Majuro', 'Live'),
(240, 'MH', 'Pacific/Kwajalein', 'Live'),
(241, 'MK', 'Europe/Skopje', 'Live'),
(242, 'ML', 'Africa/Bamako', 'Live'),
(243, 'MM', 'Asia/Yangon', 'Live'),
(244, 'MN', 'Asia/Ulaanbaatar', 'Live'),
(245, 'MN', 'Asia/Hovd', 'Live'),
(246, 'MN', 'Asia/Choibalsan', 'Live'),
(247, 'MO', 'Asia/Macau', 'Live'),
(248, 'MP', 'Pacific/Saipan', 'Live'),
(249, 'MQ', 'America/Martinique', 'Live'),
(250, 'MR', 'Africa/Nouakchott', 'Live'),
(251, 'MS', 'America/Montserrat', 'Live'),
(252, 'MT', 'Europe/Malta', 'Live'),
(253, 'MU', 'Indian/Mauritius', 'Live'),
(254, 'MV', 'Indian/Maldives', 'Live'),
(255, 'MW', 'Africa/Blantyre', 'Live'),
(256, 'MX', 'America/Mexico_City', 'Live'),
(257, 'MX', 'America/Cancun', 'Live'),
(258, 'MX', 'America/Merida', 'Live'),
(259, 'MX', 'America/Monterrey', 'Live'),
(260, 'MX', 'America/Matamoros', 'Live'),
(261, 'MX', 'America/Mazatlan', 'Live'),
(262, 'MX', 'America/Chihuahua', 'Live'),
(263, 'MX', 'America/Ojinaga', 'Live'),
(264, 'MX', 'America/Hermosillo', 'Live'),
(265, 'MX', 'America/Tijuana', 'Live'),
(266, 'MX', 'America/Bahia_Banderas', 'Live'),
(267, 'MY', 'Asia/Kuala_Lumpur', 'Live'),
(268, 'MY', 'Asia/Kuching', 'Live'),
(269, 'MZ', 'Africa/Maputo', 'Live'),
(270, 'NA', 'Africa/Windhoek', 'Live'),
(271, 'NC', 'Pacific/Noumea', 'Live'),
(272, 'NE', 'Africa/Niamey', 'Live'),
(273, 'NF', 'Pacific/Norfolk', 'Live'),
(274, 'NG', 'Africa/Lagos', 'Live'),
(275, 'NI', 'America/Managua', 'Live'),
(276, 'NL', 'Europe/Amsterdam', 'Live'),
(277, 'NO', 'Europe/Oslo', 'Live'),
(278, 'NP', 'Asia/Kathmandu', 'Live'),
(279, 'NR', 'Pacific/Nauru', 'Live'),
(280, 'NU', 'Pacific/Niue', 'Live'),
(281, 'NZ', 'Pacific/Auckland', 'Live'),
(282, 'NZ', 'Pacific/Chatham', 'Live'),
(283, 'OM', 'Asia/Muscat', 'Live'),
(284, 'PA', 'America/Panama', 'Live'),
(285, 'PE', 'America/Lima', 'Live'),
(286, 'PF', 'Pacific/Tahiti', 'Live'),
(287, 'PF', 'Pacific/Marquesas', 'Live'),
(288, 'PF', 'Pacific/Gambier', 'Live'),
(289, 'PG', 'Pacific/Port_Moresby', 'Live'),
(290, 'PG', 'Pacific/Bougainville', 'Live'),
(291, 'PH', 'Asia/Manila', 'Live'),
(292, 'PK', 'Asia/Karachi', 'Live'),
(293, 'PL', 'Europe/Warsaw', 'Live'),
(294, 'PM', 'America/Miquelon', 'Live'),
(295, 'PN', 'Pacific/Pitcairn', 'Live'),
(296, 'PR', 'America/Puerto_Rico', 'Live'),
(297, 'PS', 'Asia/Gaza', 'Live'),
(298, 'PS', 'Asia/Hebron', 'Live'),
(299, 'PT', 'Europe/Lisbon', 'Live'),
(300, 'PT', 'Atlantic/Madeira', 'Live'),
(301, 'PT', 'Atlantic/Azores', 'Live'),
(302, 'PW', 'Pacific/Palau', 'Live'),
(303, 'PY', 'America/Asuncion', 'Live'),
(304, 'QA', 'Asia/Qatar', 'Live'),
(305, 'RE', 'Indian/Reunion', 'Live'),
(306, 'RO', 'Europe/Bucharest', 'Live'),
(307, 'RS', 'Europe/Belgrade', 'Live'),
(308, 'RU', 'Europe/Kaliningrad', 'Live'),
(309, 'RU', 'Europe/Moscow', 'Live'),
(310, 'RU', 'Europe/Simferopol', 'Live'),
(311, 'RU', 'Europe/Volgograd', 'Live'),
(312, 'RU', 'Europe/Kirov', 'Live'),
(313, 'RU', 'Europe/Astrakhan', 'Live'),
(314, 'RU', 'Europe/Saratov', 'Live'),
(315, 'RU', 'Europe/Ulyanovsk', 'Live'),
(316, 'RU', 'Europe/Samara', 'Live'),
(317, 'RU', 'Asia/Yekaterinburg', 'Live'),
(318, 'RU', 'Asia/Omsk', 'Live'),
(319, 'RU', 'Asia/Novosibirsk', 'Live'),
(320, 'RU', 'Asia/Barnaul', 'Live'),
(321, 'RU', 'Asia/Tomsk', 'Live'),
(322, 'RU', 'Asia/Novokuznetsk', 'Live'),
(323, 'RU', 'Asia/Krasnoyarsk', 'Live'),
(324, 'RU', 'Asia/Irkutsk', 'Live'),
(325, 'RU', 'Asia/Chita', 'Live'),
(326, 'RU', 'Asia/Yakutsk', 'Live'),
(327, 'RU', 'Asia/Khandyga', 'Live'),
(328, 'RU', 'Asia/Vladivostok', 'Live'),
(329, 'RU', 'Asia/Ust-Nera', 'Live'),
(330, 'RU', 'Asia/Magadan', 'Live'),
(331, 'RU', 'Asia/Sakhalin', 'Live'),
(332, 'RU', 'Asia/Srednekolymsk', 'Live'),
(333, 'RU', 'Asia/Kamchatka', 'Live'),
(334, 'RU', 'Asia/Anadyr', 'Live'),
(335, 'RW', 'Africa/Kigali', 'Live'),
(336, 'SA', 'Asia/Riyadh', 'Live'),
(337, 'SB', 'Pacific/Guadalcanal', 'Live'),
(338, 'SC', 'Indian/Mahe', 'Live'),
(339, 'SD', 'Africa/Khartoum', 'Live'),
(340, 'SE', 'Europe/Stockholm', 'Live'),
(341, 'SG', 'Asia/Singapore', 'Live'),
(342, 'SH', 'Atlantic/St_Helena', 'Live'),
(343, 'SI', 'Europe/Ljubljana', 'Live'),
(344, 'SJ', 'Arctic/Longyearbyen', 'Live'),
(345, 'SK', 'Europe/Bratislava', 'Live'),
(346, 'SL', 'Africa/Freetown', 'Live'),
(347, 'SM', 'Europe/San_Marino', 'Live'),
(348, 'SN', 'Africa/Dakar', 'Live'),
(349, 'SO', 'Africa/Mogadishu', 'Live'),
(350, 'SR', 'America/Paramaribo', 'Live'),
(351, 'SS', 'Africa/Juba', 'Live'),
(352, 'ST', 'Africa/Sao_Tome', 'Live'),
(353, 'SV', 'America/El_Salvador', 'Live'),
(354, 'SX', 'America/Lower_Princes', 'Live'),
(355, 'SY', 'Asia/Damascus', 'Live'),
(356, 'SZ', 'Africa/Mbabane', 'Live'),
(357, 'TC', 'America/Grand_Turk', 'Live'),
(358, 'TD', 'Africa/Ndjamena', 'Live'),
(359, 'TF', 'Indian/Kerguelen', 'Live'),
(360, 'TG', 'Africa/Lome', 'Live'),
(361, 'TH', 'Asia/Bangkok', 'Live'),
(362, 'TJ', 'Asia/Dushanbe', 'Live'),
(363, 'TK', 'Pacific/Fakaofo', 'Live'),
(364, 'TL', 'Asia/Dili', 'Live'),
(365, 'TM', 'Asia/Ashgabat', 'Live'),
(366, 'TN', 'Africa/Tunis', 'Live'),
(367, 'TO', 'Pacific/Tongatapu', 'Live'),
(368, 'TR', 'Europe/Istanbul', 'Live'),
(369, 'TT', 'America/Port_of_Spain', 'Live'),
(370, 'TV', 'Pacific/Funafuti', 'Live'),
(371, 'TW', 'Asia/Taipei', 'Live'),
(372, 'TZ', 'Africa/Dar_es_Salaam', 'Live'),
(373, 'UA', 'Europe/Kiev', 'Live'),
(374, 'UA', 'Europe/Uzhgorod', 'Live'),
(375, 'UA', 'Europe/Zaporozhye', 'Live'),
(376, 'UG', 'Africa/Kampala', 'Live'),
(377, 'UM', 'Pacific/Midway', 'Live'),
(378, 'UM', 'Pacific/Wake', 'Live'),
(379, 'US', 'America/New_York', 'Live'),
(380, 'US', 'America/Detroit', 'Live'),
(381, 'US', 'America/Kentucky/Louisville', 'Live'),
(382, 'US', 'America/Kentucky/Monticello', 'Live'),
(383, 'US', 'America/Indiana/Indianapolis', 'Live'),
(384, 'US', 'America/Indiana/Vincennes', 'Live'),
(385, 'US', 'America/Indiana/Winamac', 'Live'),
(386, 'US', 'America/Indiana/Marengo', 'Live'),
(387, 'US', 'America/Indiana/Petersburg', 'Live'),
(388, 'US', 'America/Indiana/Vevay', 'Live'),
(389, 'US', 'America/Chicago', 'Live'),
(390, 'US', 'America/Indiana/Tell_City', 'Live'),
(391, 'US', 'America/Indiana/Knox', 'Live'),
(392, 'US', 'America/Menominee', 'Live'),
(393, 'US', 'America/North_Dakota/Center', 'Live'),
(394, 'US', 'America/North_Dakota/New_Salem', 'Live'),
(395, 'US', 'America/North_Dakota/Beulah', 'Live'),
(396, 'US', 'America/Denver', 'Live'),
(397, 'US', 'America/Boise', 'Live'),
(398, 'US', 'America/Phoenix', 'Live'),
(399, 'US', 'America/Los_Angeles', 'Live'),
(400, 'US', 'America/Anchorage', 'Live'),
(401, 'US', 'America/Juneau', 'Live'),
(402, 'US', 'America/Sitka', 'Live'),
(403, 'US', 'America/Metlakatla', 'Live'),
(404, 'US', 'America/Yakutat', 'Live'),
(405, 'US', 'America/Nome', 'Live'),
(406, 'US', 'America/Adak', 'Live'),
(407, 'US', 'Pacific/Honolulu', 'Live'),
(408, 'UY', 'America/Montevideo', 'Live'),
(409, 'UZ', 'Asia/Samarkand', 'Live'),
(410, 'UZ', 'Asia/Tashkent', 'Live'),
(411, 'VA', 'Europe/Vatican', 'Live'),
(412, 'VC', 'America/St_Vincent', 'Live'),
(413, 'VE', 'America/Caracas', 'Live'),
(414, 'VG', 'America/Tortola', 'Live'),
(415, 'VI', 'America/St_Thomas', 'Live'),
(416, 'VN', 'Asia/Ho_Chi_Minh', 'Live'),
(417, 'VU', 'Pacific/Efate', 'Live'),
(418, 'WF', 'Pacific/Wallis', 'Live'),
(419, 'WS', 'Pacific/Apia', 'Live'),
(420, 'YE', 'Asia/Aden', 'Live'),
(421, 'YT', 'Indian/Mayotte', 'Live'),
(422, 'ZA', 'Africa/Johannesburg', 'Live'),
(423, 'ZM', 'Africa/Lusaka', 'Live'),
(424, 'ZW', 'Africa/Harare', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tools`
--

CREATE TABLE `tbl_tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tool_name` varchar(100) NOT NULL,
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tools`
--

INSERT INTO `tbl_tools` (`id`, `tool_name`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'Vernier Caliper', 'Live', '2025-09-08 11:04:28', '2025-09-08 11:04:28'),
(2, 'Drill Bits', 'Live', '2025-09-08 11:04:52', '2025-09-08 11:04:52'),
(3, 'Broaches', 'Deleted', '2025-09-08 11:05:05', '2025-09-08 11:06:10'),
(4, 'Broaches', 'Live', '2025-09-09 03:58:15', '2025-09-09 03:58:15'),
(5, 'Taps & Dies', 'Live', '2025-09-09 03:58:24', '2025-09-09 03:58:24'),
(6, 'Boring Bars', 'Live', '2025-09-09 03:59:09', '2025-09-09 03:59:09'),
(7, 'Turning Tools', 'Live', '2025-09-09 03:59:25', '2025-09-09 03:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

CREATE TABLE `tbl_units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(10) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_code` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `role` int(10) DEFAULT NULL COMMENT '1. Admin 2. Staff',
  `permission_role` int(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `alt_phone_number` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `salary` float DEFAULT NULL,
  `address` varchar(250) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
  `is_first_login` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live',
  `language` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `emp_code`, `name`, `designation`, `role`, `permission_role`, `email`, `username`, `password`, `remember_token`, `email_verified_at`, `phone_number`, `alt_phone_number`, `type`, `salary`, `address`, `company_id`, `photo`, `question`, `answer`, `status`, `is_first_login`, `created_at`, `updated_at`, `del_status`, `language`) VALUES
(1, '', 'Admin', 'Super Admin', NULL, NULL, 'admin@gmail.com', '', '$2y$10$QlEQF1wYE8w87hOlq0KLd.OZPEPKxt8cOYIBwxDCC3oGWnQqg8LVq', NULL, NULL, '01812391633', '', 'Admin', NULL, '', 1, '1724527113_man (4) (1).png', 'What is the name of the town you were born?', 'Dhaka', 'Active', 0, '2020-08-04 22:18:53', '2025-07-23 17:34:04', 'Live', 'en'),
(2, 'EMP-001', 'Kannan', 'Employee', 2, 2, 'kannan@gmail.com', '8014141414', '$2y$10$h5RinUGsuQwTeXx1rwh4r.gI9n9s4p/4m.i4nh1QzaXxMM/I9ibEe', NULL, NULL, '8014141414', '', 'User', 12000, 'Virudhunagar', 1, NULL, NULL, NULL, 'Active', 1, '2025-06-12 13:14:54', '2025-06-12 13:14:54', 'Live', NULL),
(3, 'EMP-002', 'Kumar', 'Employee', 2, 2, 'kumar@gmail.com', '9032565252', '$2y$10$KvcYhoFkLVscm5qHu06rlerNwfFbpJ0X7nBpDgNpxQHwqMFFjTXnG', NULL, NULL, '9032565252', '', 'User', 15000, 'Dindigul', 1, NULL, NULL, NULL, 'Active', 1, '2025-06-12 13:15:38', '2025-06-12 13:15:38', 'Live', NULL),
(4, 'EMP-003', 'Robert', 'Quality analyst', 2, 3, 'robertsj@gmail.com', '6253525252', '$2y$10$P.RzmG5qhUdgE6asiAsbR.FdZ3KYhGoK48XMEQiZdF1wji64XBicu', NULL, NULL, '6253525252', '', 'User', 30000, 'Dindigul', 1, NULL, NULL, NULL, 'Active', 1, '2025-06-12 13:16:39', '2025-06-12 13:16:39', 'Live', NULL),
(5, 'EMP-004', 'Amirtha', 'Testing Engineer', 2, 3, 'amir@gmail.com', '9014525263', '$2y$10$11AFoyNCn9SBuUT27chwieNQDRxVTtuXrBzzAn1y7vMu7S19OJfR2', NULL, NULL, '9014525263', '', 'User', 35000, 'Madurai', 1, NULL, NULL, NULL, 'Active', 1, '2025-06-12 13:17:24', '2025-06-12 13:17:24', 'Live', NULL),
(6, 'EMP-005', 'Sridhar', 'Manager', 2, 1, 'sridhar@gmail.com-deleted', '9878787885', '$2y$10$NKW2oVk6jbG2ixJXQSmYseUuMgwHsKaUhzjF4UbKF3Mmoi.Hwwraa', NULL, NULL, '9878787885', '', 'User', 40000, 'Madurai', 1, NULL, 'What is the name of your first pet?', 'dog', 'Active', 0, '2025-07-04 18:08:11', '2025-07-04 18:10:52', 'Deleted', NULL),
(7, 'EMP-006', 'Sridhar', 'Manager', 2, 4, 'sridhar@gmail.com-deleted7', '9685748585', '$2y$10$pRp54rcML0.BrALZqgFu9egB8SxlXtIscnYHElTNdR5/fih3PzGti', NULL, NULL, '9685748585', '', 'User', 40000, 'Madurai', 1, NULL, 'Where is your favorite place to vacation?', 'Switzerland', 'Active', 0, '2025-07-04 18:12:36', '2025-07-28 23:12:35', 'Deleted', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_old`
--

CREATE TABLE `tbl_users_old` (
  `id` int(11) NOT NULL,
  `full_name` varchar(25) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `will_login` varchar(20) NOT NULL DEFAULT 'No',
  `role` varchar(25) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_creation_date` datetime NOT NULL,
  `language` varchar(100) NOT NULL DEFAULT 'english',
  `last_login` datetime NOT NULL,
  `active_status` varchar(25) NOT NULL DEFAULT 'Active',
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

CREATE TABLE `tbl_user_access` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `access_parent_id` int(11) DEFAULT NULL,
  `access_child_id` int(11) DEFAULT NULL,
  `del_status` varchar(11) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_menu_access`
--

CREATE TABLE `tbl_user_menu_access` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wastes`
--

CREATE TABLE `tbl_wastes` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `responsible_person` int(11) DEFAULT NULL,
  `total_loss` float(10,2) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `del_status` varchar(50) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_waste_materials`
--

CREATE TABLE `tbl_waste_materials` (
  `id` int(11) NOT NULL,
  `rmaterials_id` int(11) DEFAULT NULL,
  `waste_amount` float(10,2) DEFAULT NULL,
  `last_purchase_price` float(10,2) DEFAULT NULL,
  `loss_amount` float(10,2) DEFAULT NULL,
  `waste_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_white_label_settings`
--

CREATE TABLE `tbl_white_label_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `mini_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(150) DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_white_label_settings`
--

INSERT INTO `tbl_white_label_settings` (`id`, `site_title`, `logo`, `mini_logo`, `favicon`, `footer`, `company_name`, `company_website`, `created_at`, `del_status`, `updated_at`) VALUES
(1, 'Danish - Production & Manufacture Management Software', 'logo.png', 'mini_logo.png', 'favicon.png', 'Danish - Production & Manufacture Management Software', 'Door Soft', 'https://doorsoft.co', NULL, 'Live', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdraw_deposits`
--

CREATE TABLE `tbl_withdraw_deposits` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(11) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `del_status` varchar(10) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_settings`
--
ALTER TABLE `tbl_admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_user_menus`
--
ALTER TABLE `tbl_admin_user_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_attachments`
--
ALTER TABLE `tbl_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_consumables`
--
ALTER TABLE `tbl_consumables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_contact_info`
--
ALTER TABLE `tbl_customer_contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_due_receives`
--
ALTER TABLE `tbl_customer_due_receives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_orders`
--
ALTER TABLE `tbl_customer_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_order_deliveries`
--
ALTER TABLE `tbl_customer_order_deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_order_details`
--
ALTER TABLE `tbl_customer_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_order_invoices`
--
ALTER TABLE `tbl_customer_order_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_deposits`
--
ALTER TABLE `tbl_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_drawers`
--
ALTER TABLE `tbl_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_drawing_parameters`
--
ALTER TABLE `tbl_drawing_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_expense_items`
--
ALTER TABLE `tbl_expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_finished_products_noninventory`
--
ALTER TABLE `tbl_finished_products_noninventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_finished_products_productionstage`
--
ALTER TABLE `tbl_finished_products_productionstage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_finished_products_rmaterials`
--
ALTER TABLE `tbl_finished_products_rmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_finish_products`
--
ALTER TABLE `tbl_finish_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fnunits`
--
ALTER TABLE `tbl_fnunits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fpcategory`
--
ALTER TABLE `tbl_fpcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fpwastes`
--
ALTER TABLE `tbl_fpwastes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fpwastes_fp`
--
ALTER TABLE `tbl_fpwastes_fp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inpection_params`
--
ALTER TABLE `tbl_inpection_params`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inspections`
--
ALTER TABLE `tbl_inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inspection_approves`
--
ALTER TABLE `tbl_inspection_approves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inspection_observed_dimensions`
--
ALTER TABLE `tbl_inspection_observed_dimensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inspection_report_files`
--
ALTER TABLE `tbl_inspection_report_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_instruments`
--
ALTER TABLE `tbl_instruments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_instrument_categories`
--
ALTER TABLE `tbl_instrument_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_job_card_entries`
--
ALTER TABLE `tbl_job_card_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mail_settings`
--
ALTER TABLE `tbl_mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_main_modules`
--
ALTER TABLE `tbl_main_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufactures`
--
ALTER TABLE `tbl_manufactures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufactures_noninventory`
--
ALTER TABLE `tbl_manufactures_noninventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufactures_rmaterials`
--
ALTER TABLE `tbl_manufactures_rmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufactures_stages`
--
ALTER TABLE `tbl_manufactures_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufacture_product`
--
ALTER TABLE `tbl_manufacture_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_material_stocks`
--
ALTER TABLE `tbl_material_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_material_types`
--
ALTER TABLE `tbl_material_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu_activities`
--
ALTER TABLE `tbl_menu_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_non_inventory_items`
--
ALTER TABLE `tbl_non_inventory_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_settings`
--
ALTER TABLE `tbl_payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_productions`
--
ALTER TABLE `tbl_productions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production_history`
--
ALTER TABLE `tbl_production_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_id` (`work_order_id`);

--
-- Indexes for table `tbl_production_noninventory`
--
ALTER TABLE `tbl_production_noninventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production_qc_scheduling`
--
ALTER TABLE `tbl_production_qc_scheduling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production_rmaterials`
--
ALTER TABLE `tbl_production_rmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production_scheduling`
--
ALTER TABLE `tbl_production_scheduling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production_stages`
--
ALTER TABLE `tbl_production_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products_services`
--
ALTER TABLE `tbl_products_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proposal_invoice`
--
ALTER TABLE `tbl_proposal_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proposal_invoice_products_services`
--
ALTER TABLE `tbl_proposal_invoice_products_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proposal_pdf`
--
ALTER TABLE `tbl_proposal_pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proposal_photo`
--
ALTER TABLE `tbl_proposal_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_return`
--
ALTER TABLE `tbl_purchase_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_return_details`
--
ALTER TABLE `tbl_purchase_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_rmaterials`
--
ALTER TABLE `tbl_purchase_rmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_qc_statuses`
--
ALTER TABLE `tbl_qc_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quotations`
--
ALTER TABLE `tbl_quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quotation_details`
--
ALTER TABLE `tbl_quotation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quotation_qc_logs`
--
ALTER TABLE `tbl_quotation_qc_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rawmaterials`
--
ALTER TABLE `tbl_rawmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rmcategory`
--
ALTER TABLE `tbl_rmcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rmunits`
--
ALTER TABLE `tbl_rmunits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_role_permissions`
--
ALTER TABLE `tbl_role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_route_card_entries`
--
ALTER TABLE `tbl_route_card_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sale_consumptions_of_menus`
--
ALTER TABLE `tbl_sale_consumptions_of_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sale_consumptions_of_modifiers_of_menus`
--
ALTER TABLE `tbl_sale_consumptions_of_modifiers_of_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sessions`
--
ALTER TABLE `tbl_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_stock_adjust_logs`
--
ALTER TABLE `tbl_stock_adjust_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_contact_info`
--
ALTER TABLE `tbl_supplier_contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_payments`
--
ALTER TABLE `tbl_supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_taxes`
--
ALTER TABLE `tbl_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tax_items`
--
ALTER TABLE `tbl_tax_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_time_zone`
--
ALTER TABLE `tbl_time_zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tools`
--
ALTER TABLE `tbl_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_units`
--
ALTER TABLE `tbl_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_admins_email_unique` (`email`),
  ADD UNIQUE KEY `tbl_admins_phone_number_unique` (`phone_number`);

--
-- Indexes for table `tbl_users_old`
--
ALTER TABLE `tbl_users_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_menu_access`
--
ALTER TABLE `tbl_user_menu_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wastes`
--
ALTER TABLE `tbl_wastes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_waste_materials`
--
ALTER TABLE `tbl_waste_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_white_label_settings`
--
ALTER TABLE `tbl_white_label_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_withdraw_deposits`
--
ALTER TABLE `tbl_withdraw_deposits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_settings`
--
ALTER TABLE `tbl_admin_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_user_menus`
--
ALTER TABLE `tbl_admin_user_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_attachments`
--
ALTER TABLE `tbl_attachments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_consumables`
--
ALTER TABLE `tbl_consumables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_customer_contact_info`
--
ALTER TABLE `tbl_customer_contact_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_customer_due_receives`
--
ALTER TABLE `tbl_customer_due_receives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer_orders`
--
ALTER TABLE `tbl_customer_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_customer_order_deliveries`
--
ALTER TABLE `tbl_customer_order_deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer_order_details`
--
ALTER TABLE `tbl_customer_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customer_order_invoices`
--
ALTER TABLE `tbl_customer_order_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_deposits`
--
ALTER TABLE `tbl_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_drawers`
--
ALTER TABLE `tbl_drawers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_drawing_parameters`
--
ALTER TABLE `tbl_drawing_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_expense_items`
--
ALTER TABLE `tbl_expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_finished_products_noninventory`
--
ALTER TABLE `tbl_finished_products_noninventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_finished_products_productionstage`
--
ALTER TABLE `tbl_finished_products_productionstage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `tbl_finished_products_rmaterials`
--
ALTER TABLE `tbl_finished_products_rmaterials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_finish_products`
--
ALTER TABLE `tbl_finish_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_fnunits`
--
ALTER TABLE `tbl_fnunits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_fpcategory`
--
ALTER TABLE `tbl_fpcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_fpwastes`
--
ALTER TABLE `tbl_fpwastes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_fpwastes_fp`
--
ALTER TABLE `tbl_fpwastes_fp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_inpection_params`
--
ALTER TABLE `tbl_inpection_params`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tbl_inspections`
--
ALTER TABLE `tbl_inspections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_inspection_approves`
--
ALTER TABLE `tbl_inspection_approves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inspection_observed_dimensions`
--
ALTER TABLE `tbl_inspection_observed_dimensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_inspection_report_files`
--
ALTER TABLE `tbl_inspection_report_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_instruments`
--
ALTER TABLE `tbl_instruments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_instrument_categories`
--
ALTER TABLE `tbl_instrument_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_job_card_entries`
--
ALTER TABLE `tbl_job_card_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mail_settings`
--
ALTER TABLE `tbl_mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_main_modules`
--
ALTER TABLE `tbl_main_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_manufactures`
--
ALTER TABLE `tbl_manufactures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_manufactures_noninventory`
--
ALTER TABLE `tbl_manufactures_noninventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_manufactures_rmaterials`
--
ALTER TABLE `tbl_manufactures_rmaterials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_manufactures_stages`
--
ALTER TABLE `tbl_manufactures_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_manufacture_product`
--
ALTER TABLE `tbl_manufacture_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_material_stocks`
--
ALTER TABLE `tbl_material_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_material_types`
--
ALTER TABLE `tbl_material_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_menu_activities`
--
ALTER TABLE `tbl_menu_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `tbl_non_inventory_items`
--
ALTER TABLE `tbl_non_inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment_settings`
--
ALTER TABLE `tbl_payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_productions`
--
ALTER TABLE `tbl_productions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_production_history`
--
ALTER TABLE `tbl_production_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_production_noninventory`
--
ALTER TABLE `tbl_production_noninventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_production_qc_scheduling`
--
ALTER TABLE `tbl_production_qc_scheduling`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_production_rmaterials`
--
ALTER TABLE `tbl_production_rmaterials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_production_scheduling`
--
ALTER TABLE `tbl_production_scheduling`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_production_stages`
--
ALTER TABLE `tbl_production_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_products_services`
--
ALTER TABLE `tbl_products_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_proposal_invoice`
--
ALTER TABLE `tbl_proposal_invoice`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_proposal_invoice_products_services`
--
ALTER TABLE `tbl_proposal_invoice_products_services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_proposal_pdf`
--
ALTER TABLE `tbl_proposal_pdf`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_proposal_photo`
--
ALTER TABLE `tbl_proposal_photo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_return`
--
ALTER TABLE `tbl_purchase_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_return_details`
--
ALTER TABLE `tbl_purchase_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_rmaterials`
--
ALTER TABLE `tbl_purchase_rmaterials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_qc_statuses`
--
ALTER TABLE `tbl_qc_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_quotations`
--
ALTER TABLE `tbl_quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_quotation_details`
--
ALTER TABLE `tbl_quotation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_quotation_qc_logs`
--
ALTER TABLE `tbl_quotation_qc_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rawmaterials`
--
ALTER TABLE `tbl_rawmaterials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_rmcategory`
--
ALTER TABLE `tbl_rmcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_rmunits`
--
ALTER TABLE `tbl_rmunits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_role_permissions`
--
ALTER TABLE `tbl_role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=713;

--
-- AUTO_INCREMENT for table `tbl_route_card_entries`
--
ALTER TABLE `tbl_route_card_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_salaries`
--
ALTER TABLE `tbl_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sale_consumptions_of_menus`
--
ALTER TABLE `tbl_sale_consumptions_of_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sale_consumptions_of_modifiers_of_menus`
--
ALTER TABLE `tbl_sale_consumptions_of_modifiers_of_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_stock_adjust_logs`
--
ALTER TABLE `tbl_stock_adjust_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_supplier_contact_info`
--
ALTER TABLE `tbl_supplier_contact_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_supplier_payments`
--
ALTER TABLE `tbl_supplier_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_taxes`
--
ALTER TABLE `tbl_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_tax_items`
--
ALTER TABLE `tbl_tax_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_tools`
--
ALTER TABLE `tbl_tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_units`
--
ALTER TABLE `tbl_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users_old`
--
ALTER TABLE `tbl_users_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_wastes`
--
ALTER TABLE `tbl_wastes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_waste_materials`
--
ALTER TABLE `tbl_waste_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_white_label_settings`
--
ALTER TABLE `tbl_white_label_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_withdraw_deposits`
--
ALTER TABLE `tbl_withdraw_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_production_history`
--
ALTER TABLE `tbl_production_history`
  ADD CONSTRAINT `tbl_production_history_ibfk_1` FOREIGN KEY (`work_order_id`) REFERENCES `tbl_customer_orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
