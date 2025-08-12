-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2023 at 05:54 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rex_nfc_member_wallet`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `member_id` int(11) UNSIGNED NOT NULL,
  `door_id` int(11) UNSIGNED NOT NULL,
  `center_id` int(11) UNSIGNED NOT NULL,
  `member_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `boss_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `center_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `door_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `direction` int(1) NOT NULL COMMENT '0 - in, 1 - out',
  `status` int(11) NOT NULL COMMENT 'status returned in card api',
  `security_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
PARTITION BY HASH (to_days(`created_at`))
(
PARTITION p0 ENGINE=InnoDB,
PARTITION p1 ENGINE=InnoDB,
PARTITION p2 ENGINE=InnoDB,
PARTITION p3 ENGINE=InnoDB,
PARTITION p4 ENGINE=InnoDB,
PARTITION p5 ENGINE=InnoDB,
PARTITION p6 ENGINE=InnoDB,
PARTITION p7 ENGINE=InnoDB,
PARTITION p8 ENGINE=InnoDB,
PARTITION p9 ENGINE=InnoDB
);

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`member_id`, `door_id`, `center_id`, `member_name`, `boss_id`, `center_name`, `door_name`, `direction`, `status`, `security_name`, `created_at`, `updated_at`, `remark`) VALUES
(1, 13, 6, 'member1', 'BM_002', 'gym floor', 'Door A', 1, 3, 'john', '2023-01-04 01:58:19', '2023-01-04 01:58:19', 'asdfa dfaeawet | Door Denied'),
(1, 12, 7, 'member1', 'BM_002', 'cafe floor', 'Door 806', 0, 3, 'peter', '2023-01-04 01:47:31', '2023-01-04 01:47:31', 'asdfa dfaeawet | Door Denied'),
(1, 12, 7, 'member1', 'BM_002', 'cafe floor', 'Door 806', 1, 1, 'peter', '2023-01-04 01:49:29', '2023-01-04 01:49:29', 'asdfa dfaeawet'),
(1, 12, 7, 'member1', 'BM_002', 'cafe floor', 'Door 806', 1, 3, 'peter', '2023-01-04 01:51:35', '2023-01-04 01:51:35', 'asdfa dfaeawet | Door Denied'),
(2, 13, 6, 'member2', 'BM_001', 'gym floor', 'Door A', 1, 3, 'john', '2023-01-04 01:57:42', '2023-01-04 01:57:42', ' | Door Denied'),
(2, 10, 7, 'member2', 'BM_001', 'cafe floor', 'front door', 1, 1, 'john', '2023-01-04 01:53:30', '2023-01-04 01:53:30', NULL),
(2, 10, 7, 'member2', 'BM_001', 'cafe floor', 'front door', 1, 3, 'john', '2023-01-04 01:54:16', '2023-01-04 01:54:16', ' | Door Denied');

-- --------------------------------------------------------

--
-- Table structure for table `admin_setting`
--

CREATE TABLE `admin_setting` (
  `id` int(11) NOT NULL,
  `phone_no` varchar(20) NOT NULL DEFAULT '+91 21456987',
  `email` varchar(255) NOT NULL DEFAULT 'support@email.com',
  `address` text DEFAULT NULL,
  `pp` text NOT NULL,
  `notification` int(11) NOT NULL DEFAULT 1,
  `currency_symbol` varchar(255) NOT NULL DEFAULT '$',
  `currency` varchar(255) NOT NULL DEFAULT 'USD',
  `time_slot_length` int(11) NOT NULL DEFAULT 60,
  `verification` int(11) NOT NULL DEFAULT 0,
  `sms_gateway` varchar(20) NOT NULL DEFAULT 'twilio',
  `country_code` varchar(4) NOT NULL DEFAULT '+91',
  `offline_payment` int(11) NOT NULL DEFAULT 1,
  `stipe_status` int(11) NOT NULL DEFAULT 0,
  `paypal_status` int(11) NOT NULL DEFAULT 0,
  `razor_status` int(11) NOT NULL DEFAULT 0,
  `ios_version` varchar(255) NOT NULL DEFAULT '1.0.2',
  `android_version` varchar(255) NOT NULL DEFAULT '1.0.5',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bp` text DEFAULT NULL,
  `global_version` int(11) NOT NULL DEFAULT 1,
  `version_alert` varchar(255) NOT NULL,
  `version_alert_en` varchar(255) NOT NULL,
  `version_alert_ch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_setting`
--

INSERT INTO `admin_setting` (`id`, `phone_no`, `email`, `address`, `pp`, `notification`, `currency_symbol`, `currency`, `time_slot_length`, `verification`, `sms_gateway`, `country_code`, `offline_payment`, `stipe_status`, `paypal_status`, `razor_status`, `ios_version`, `android_version`, `created_at`, `updated_at`, `bp`, `global_version`, `version_alert`, `version_alert_en`, `version_alert_ch`) VALUES
(2, '+91 21456987', 'support@email.com', NULL, '<p><span style=\"font-family: &quot;Comic Sans MS&quot;;\">asdfasdf asdfaefawef asdfaef</span></p><h1><span style=\"font-family: &quot;Comic Sans MS&quot;;\">asdfasf asdf</span></h1><p><span style=\"font-family: &quot;Comic Sans MS&quot;;\">asdfasdf aefwer agasdfaefe</span></p>', 1, '$', 'USD', 60, 0, 'twilio', '+91', 1, 0, 0, 0, '1.0.2', '1.0.5', '2023-01-06 18:13:12', '2023-01-07 01:28:35', '<h1>Terms &amp; Conditions</h1><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-weight: 400; font-family: DauphinPlain; font-size: 24px; line-height: 24px; color: rgb(0, 0, 0);\">What is Lorem Ipsum?</h2><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\"><strong style=\"margin: 0px; padding: 0px;\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><br></p>', 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `birthday` date NOT NULL DEFAULT '2001-01-01',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.png',
  `address` text DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `liked_salon` text DEFAULT NULL,
  `OTP` varchar(6) DEFAULT '',
  `otp_create_date` datetime DEFAULT '2001-01-01 00:00:00',
  `noti` int(11) NOT NULL DEFAULT 1,
  `verified` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-woman, 2-men, 0-both',
  `status_1` int(11) NOT NULL DEFAULT 0,
  `status_2` int(11) NOT NULL DEFAULT 0,
  `status_3` int(11) NOT NULL DEFAULT 0,
  `status_4` int(11) NOT NULL DEFAULT 0,
  `status_5` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `tablename` varchar(255) NOT NULL,
  `audittype` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `rid` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `booking_child`
--

CREATE TABLE `booking_child` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `count` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `booking_master`
--

CREATE TABLE `booking_master` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `total` float NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `duration` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = waiting 1 =confirm 2=complate 3=cancel',
  `payment_status` int(11) NOT NULL DEFAULT 0 COMMENT '0= no 1 = yes',
  `payment_token` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'Offline',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ename` varchar(255) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `eaddress` varchar(255) NOT NULL,
  `caddress` varchar(255) NOT NULL,
  `for_who` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `edescription` text NOT NULL,
  `cdescription` text NOT NULL,
  `icon` varchar(50) NOT NULL DEFAULT 'default.png',
  `start_time` time NOT NULL DEFAULT '05:00:00',
  `end_time` time NOT NULL DEFAULT '23:00:00',
  `category` text DEFAULT NULL,
  `manager` text DEFAULT NULL,
  `employee` text DEFAULT NULL,
  `is_featured` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `weekday_time_slot` varchar(150) DEFAULT '1000,1200,1300,1400,1500,1600,1700,1800,1900,2000',
  `weekend_time_slot` varchar(150) DEFAULT '1000,1200,1300,1400,1500,1600,1700',
  `is_open_sunday` tinyint(1) DEFAULT 0,
  `holidays` text DEFAULT NULL,
  `branch_code` varchar(10) NOT NULL DEFAULT '',
  `book_prefix` varchar(10) DEFAULT 'A',
  `view_urls` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `ename`, `cname`, `address`, `eaddress`, `caddress`, `for_who`, `description`, `edescription`, `cdescription`, `icon`, `start_time`, `end_time`, `category`, `manager`, `employee`, `is_featured`, `status`, `created_at`, `updated_at`, `deleted_at`, `weekday_time_slot`, `weekend_time_slot`, `is_open_sunday`, `holidays`, `branch_code`, `book_prefix`, `view_urls`) VALUES
(3, 'branch1', 'branch', 'branch', 'Владивосток, Приморский край, 690014', 'Владивосток, Приморский край, 690014', 'Владивосток, Приморский край, 690014', 0, 'adfaf af', 'adfafaef', 'asdfasdcvs', '639cb238899bf.jpg', '05:00:00', '23:00:00', '15,16', '8,17', NULL, 0, 0, '2022-12-17 02:00:24', '2022-12-17 04:44:49', NULL, '1000,1200,1300,1400,1500,1600,1700,1800,1900,2000', '1000,1200,1300,1400,1500,1600,1700', 0, NULL, 'status_1', 'A', NULL),
(4, 'second branch', 'second branch', 'second branch', 'second branch', 'second branch', 'second branch', 0, 'second branch', 'second branch', 'second branch', '63a3c8581a24f.png', '05:00:00', '23:00:00', NULL, '18', NULL, 0, 0, '2022-12-22 11:00:40', '2022-12-22 11:00:40', NULL, '1000,1200,1300,1400,1500,1600,1700,1800,1900,2000', '1000,1200,1300,1400,1500,1600,1700', 0, NULL, 'status_1', 'A', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `ename` varchar(100) NOT NULL,
  `bookable` tinyint(6) NOT NULL DEFAULT 0,
  `icon` varchar(255) NOT NULL DEFAULT 'default.png',
  `is_trending` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `cname`, `ename`, `bookable`, `icon`, `is_trending`, `branch_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `sort`) VALUES
(15, 'category1', 'category1', 'category1', 0, '639cd72bdd327.webp', 0, 0, 1, '2022-12-17 04:38:03', '2022-12-17 04:38:03', NULL, 0),
(16, 'category2', 'category2', 'category2', 0, '639cd74f9c0b0.jpg', 0, 0, 1, '2022-12-17 04:38:39', '2022-12-17 04:38:39', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(5) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `manager` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `name`, `manager`, `created_at`, `updated_at`) VALUES
(6, 'gym floor', '19', '2022-12-21 23:24:09', '2022-12-22 01:09:47'),
(7, 'cafe floor', '8,17', '2022-12-21 23:51:19', '2022-12-22 11:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doors`
--

CREATE TABLE `doors` (
  `id` int(5) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `center_id` int(5) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doors`
--

INSERT INTO `doors` (`id`, `name`, `center_id`, `description`, `created_at`, `updated_at`) VALUES
(10, 'front door', 7, NULL, '2022-12-21 23:52:42', '2022-12-21 23:52:42'),
(11, 'sidedoor', 7, 'asdfaefefe', '2022-12-21 23:52:57', '2022-12-21 23:56:57'),
(12, 'Door 806', 7, 'kitchen door', '2022-12-21 23:53:39', '2022-12-21 23:58:13'),
(13, 'Door A', 6, NULL, '2022-12-21 23:58:37', '2022-12-21 23:58:37'),
(14, 'Door B1', 6, NULL, '2022-12-22 11:58:23', '2022-12-22 11:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `door_rolelocation`
--

CREATE TABLE `door_rolelocation` (
  `door_id` int(11) UNSIGNED NOT NULL,
  `rolelocation_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `door_rolelocation`
--

INSERT INTO `door_rolelocation` (`door_id`, `rolelocation_id`) VALUES
(10, 4),
(11, 4),
(12, 4),
(10, 5),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(13, 7),
(14, 7);

-- --------------------------------------------------------

--
-- Table structure for table `employee_detail`
--

CREATE TABLE `employee_detail` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `service` text DEFAULT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'default.png',
  `status` int(11) NOT NULL DEFAULT 1,
  `experience` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_detail`
--

INSERT INTO `employee_detail` (`id`, `emp_id`, `address`, `description`, `service`, `icon`, `status`, `experience`, `created_at`, `updated_at`) VALUES
(1, 19, 'ул. Днепровская, 27 ст2, Владивосток, Приморский край, 690062', 'asdfasdf', NULL, '639db4c147e97.jpg', 0, '2', '2022-12-17 20:23:29', '2022-12-17 20:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `machine_uuid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `door_id` int(5) UNSIGNED NOT NULL,
  `direction` tinyint(1) NOT NULL COMMENT '0 - IN, 1 - OUT',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `code`, `machine_uuid`, `password`, `door_id`, `direction`, `created_at`, `updated_at`) VALUES
(1, 'M_1234', 'abce-defa-1234-5678', '$2y$10$1ZnJNCI11sRG6pWsmLpqGetDq2TuLcEp9jsvYy0ux5jDk0rYbwT1G', 13, 1, '2022-12-21 13:05:55', '2023-01-03 23:39:29'),
(3, 'M_1235', 'abce-defa-1234-5679', '$2y$10$I6bD3gAlCDHID2RqKSmpQ.ByXA2memvbPa42QYJN7kxEj5H8n7q4W', 10, 1, '2022-12-21 13:14:32', '2023-01-04 01:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` int(1) NOT NULL COMMENT '(0) not define (1) male (2) female',
  `boss_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `password`, `gender`, `boss_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'user01', '$2y$10$TunwxY0HlIl7AEf9qnlpSO8jBOT4OTUTjkwHH43mEU0oKHmQhjP6m', 1, 'user01', '', '2023-01-13 19:23:16', '2023-01-13 21:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `member_rolelocation`
--

CREATE TABLE `member_rolelocation` (
  `member_id` int(11) UNSIGNED NOT NULL,
  `rolelocation_id` int(11) UNSIGNED NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '(0) - deny, (1) - access, (2) - alert',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_rolelocation`
--

INSERT INTO `member_rolelocation` (`member_id`, `rolelocation_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 5, 1, '2022-12-22 07:52:31', '2022-12-22 07:52:31'),
(5, 6, 1, '2022-12-22 07:52:31', '2022-12-22 07:52:31'),
(6, 5, 0, '2022-12-22 07:52:31', '2022-12-22 06:15:49'),
(7, 5, 1, '2022-12-22 07:52:31', '2022-12-22 07:52:31'),
(3, 4, 2, '2022-12-22 07:52:31', '2022-12-22 06:03:51'),
(3, 5, 1, '2022-12-22 07:52:31', '2022-12-22 06:06:10'),
(10, 7, 2, '2022-12-22 13:59:24', '2022-12-22 12:00:10'),
(11, 5, 1, '2022-12-22 14:10:57', '2022-12-22 14:10:57'),
(1, 4, 1, '2023-01-03 23:22:37', '2023-01-04 01:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(12, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(13, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(14, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(15, '2016_06_01_000004_create_oauth_clients_table', 2),
(16, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(17, '2018_11_06_222923_create_transactions_table', 2),
(18, '2018_11_07_192923_create_transfers_table', 2),
(19, '2018_11_15_124230_create_wallets_table', 2),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(21, '2021_11_02_202021_update_wallets_uuid_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notification_tbl`
--

CREATE TABLE `notification_tbl` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `sub_title` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `branch_id` text CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `how_expire` int(11) DEFAULT 0 COMMENT '0 = date 1 use',
  `expiry_date` date DEFAULT NULL,
  `max_usage` int(11) DEFAULT -1,
  `max_use_user` int(11) DEFAULT -1 COMMENT '-1 = unlimited',
  `min_amount` int(11) DEFAULT -1 COMMENT '-1 = 0',
  `discount_type` int(11) DEFAULT 0 COMMENT '0 = amiount 1 = per',
  `discount` float DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 = deactive 1 active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dashboard', NULL, NULL, NULL),
(2, 'role_access', NULL, NULL, NULL),
(3, 'role_create', NULL, NULL, NULL),
(4, 'role_edit', NULL, NULL, NULL),
(5, 'role_show', NULL, NULL, NULL),
(6, 'role_delete', NULL, NULL, NULL),
(7, 'user_access', NULL, NULL, NULL),
(8, 'user_create', NULL, NULL, NULL),
(9, 'user_edit', NULL, NULL, NULL),
(10, 'user_show', NULL, NULL, NULL),
(11, 'user_delete', NULL, NULL, NULL),
(45, 'setting_access', NULL, NULL, NULL),
(53, 'lang_access', NULL, NULL, NULL),
(54, 'lang_create', NULL, NULL, NULL),
(55, 'lang_edit', NULL, NULL, NULL),
(56, 'lang_show', NULL, NULL, NULL),
(57, 'lang_delete', NULL, NULL, NULL),
(80, 'owner_access', NULL, NULL, NULL),
(81, 'owner_show', NULL, NULL, NULL),
(82, 'owner_edit', NULL, NULL, NULL),
(94, 'appuser_access', NULL, NULL, NULL),
(95, 'appuser_edit', NULL, NULL, NULL),
(98, 'employee_access', NULL, NULL, NULL),
(99, 'employee_create', NULL, NULL, NULL),
(100, 'employee_edit', NULL, NULL, NULL),
(101, 'employee_delete', NULL, NULL, NULL),
(102, 'employee_show', NULL, NULL, NULL),
(113, 'member_access', NULL, NULL, NULL),
(114, 'member_create', NULL, NULL, NULL),
(115, 'member_edit', NULL, NULL, NULL),
(116, 'member_delete', NULL, NULL, NULL),
(117, 'member_show', NULL, NULL, NULL),
(118, 'center_access', NULL, NULL, NULL),
(119, 'center_create', NULL, NULL, NULL),
(120, 'center_edit', NULL, NULL, NULL),
(121, 'center_show', NULL, NULL, NULL),
(122, 'center_delete', NULL, NULL, NULL),
(123, 'center_manager_access', NULL, NULL, NULL),
(129, 'machine_access', NULL, NULL, NULL),
(130, 'machine_create', NULL, NULL, NULL),
(131, 'machine_edit', NULL, NULL, NULL),
(132, 'machine_show', NULL, NULL, NULL),
(133, 'machine_delete', NULL, NULL, NULL),
(134, 'rolelocation_access', NULL, NULL, NULL),
(135, 'rolelocation_create', NULL, NULL, NULL),
(136, 'rolelocation_edit', NULL, NULL, NULL),
(137, 'rolelocation_delete', NULL, NULL, NULL),
(138, 'rolelocation_show', NULL, NULL, NULL),
(139, 'member_card_create', NULL, NULL, NULL),
(140, 'door_access', NULL, NULL, NULL),
(141, 'door_create', NULL, NULL, NULL),
(142, 'door_edit', NULL, NULL, NULL),
(143, 'door_delete', NULL, NULL, NULL),
(144, 'door_show', NULL, NULL, NULL),
(145, 'privacy_access', NULL, NULL, NULL),
(146, 'privacy_edit', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(2, 2),
(2, 4),
(2, 5),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(1, 10),
(1, 11),
(1, 9),
(3, 7),
(1, 7),
(4, 7),
(5, 3),
(1, 45),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 80),
(1, 81),
(1, 82),
(6, 2),
(6, 3),
(6, 4),
(8, 1),
(7, 3),
(7, 5),
(1, 94),
(1, 95),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(9, 104),
(9, 105),
(9, 106),
(9, 107),
(9, 88),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 89),
(10, 90),
(10, 91),
(10, 92),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(1, 121),
(1, 122),
(1, 123),
(1, 129),
(1, 130),
(1, 131),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(11, 113),
(11, 114),
(11, 115),
(11, 116),
(11, 117),
(11, 118),
(11, 121),
(11, 123),
(11, 129),
(11, 130),
(11, 131),
(11, 132),
(11, 133),
(11, 134),
(11, 135),
(11, 136),
(11, 137),
(11, 138),
(11, 139),
(12, 113),
(12, 114),
(12, 115),
(12, 116),
(12, 117),
(12, 118),
(12, 121),
(12, 134),
(12, 135),
(12, 136),
(12, 137),
(12, 138),
(12, 139),
(1, 140),
(1, 141),
(1, 142),
(1, 143),
(1, 144),
(1, 145),
(1, 146);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `star` int(11) NOT NULL DEFAULT 0,
  `cmt` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rolelocations`
--

CREATE TABLE `rolelocations` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rolelocations`
--

INSERT INTO `rolelocations` (`id`, `title`, `created_at`, `updated_at`) VALUES
(4, 'cafe member', '2022-12-21 23:48:18', '2022-12-21 23:48:18'),
(5, 'cafe visitor', '2022-12-21 23:48:33', '2022-12-21 23:48:33'),
(7, 'Gym Member', '2022-12-22 11:58:44', '2022-12-22 11:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, NULL),
(2, 'Wow', '2020-01-22 20:46:34', '2020-01-23 14:00:29', '2020-01-23 14:00:29'),
(3, 'Finase', '2020-01-28 21:34:27', '2020-06-03 01:20:32', '2020-06-03 01:20:32'),
(4, 'Finance Officer', '2020-02-01 18:45:37', '2020-05-19 12:48:58', '2020-05-19 12:48:58'),
(5, 'Super visor 2', '2020-02-09 18:09:56', '2020-06-03 01:20:38', '2020-06-03 01:20:38'),
(6, 'title', '2020-05-19 12:40:44', '2020-06-03 01:20:42', '2020-06-03 01:20:42'),
(7, 'sda', '2020-05-19 12:52:45', '2020-06-03 01:20:49', '2020-06-03 01:20:49'),
(8, 'xcv', '2020-05-19 12:56:25', '2020-06-03 01:20:57', '2020-06-03 01:20:57'),
(9, 'Branch Manager', '2020-05-25 11:28:00', '2022-12-22 01:25:23', '2022-12-22 01:25:23'),
(10, 'Data Entry Oprator', '2020-06-03 01:22:05', '2022-12-22 01:25:28', '2022-12-22 01:25:28'),
(11, 'center manager', '2022-12-22 01:28:58', '2022-12-22 01:28:58', NULL),
(12, 'center staff', '2022-12-22 01:31:07', '2022-12-22 01:31:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 3),
(2, 6),
(2, 5),
(3, 3),
(3, 5),
(3, 7),
(4, 9),
(5, 8),
(6, 8),
(7, 8),
(11, 9),
(12, 9),
(13, 9),
(14, 10),
(18, 12),
(8, 12),
(17, 11),
(17, 12),
(1, 11),
(1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `static_notification`
--

CREATE TABLE `static_notification` (
  `id` int(11) NOT NULL,
  `for_what` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `sub_title` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `for_who` int(11) NOT NULL DEFAULT 0 COMMENT '0 = user 1 = provide 2= both',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cname` varchar(50) DEFAULT NULL,
  `ename` varchar(100) DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'default.png',
  `is_best` int(11) NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 10,
  `description` text DEFAULT NULL,
  `for_who` int(11) NOT NULL DEFAULT 0 COMMENT '0 = both 1 = women 2 = male',
  `duration` int(11) NOT NULL DEFAULT 0,
  `preparation_time` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_upsale` tinyint(1) DEFAULT 0,
  `is_basic` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payable_id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('deposit','withdraw') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(64,0) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `payable_type`, `payable_id`, `wallet_id`, `type`, `amount`, `confirmed`, `meta`, `uuid`, `created_at`, `updated_at`) VALUES
(9, 'App\\Member', 1, 1, 'deposit', '30', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff Deposit\"}', '89e14400-0d1f-4009-a304-bb5fac28a9e8', '2023-01-03 01:45:14', '2023-01-06 01:45:14'),
(10, 'App\\Member', 1, 1, 'withdraw', '-20', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff Withdraw\"}', '5639a230-f776-4ddd-b9a9-f19e7ce51138', '2023-01-04 01:59:33', '2023-01-06 01:59:33'),
(11, 'App\\Member', 1, 1, 'deposit', '10', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff topup\"}', '840eb20a-5b6f-47c2-a536-24f0e6d1cfbc', '2023-01-06 12:21:39', '2023-01-06 12:21:39'),
(12, 'App\\Member', 1, 1, 'withdraw', '-30', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff deduct\"}', '9fcc7011-e825-47fa-9279-290950a6b7ec', '2023-01-06 12:21:47', '2023-01-06 12:21:47'),
(13, 'App\\Member', 1, 1, 'withdraw', '-30', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff deduct\"}', 'e2a4ec56-12d4-4b6c-8a13-7d71de427672', '2023-01-06 12:22:29', '2023-01-06 12:22:29'),
(14, 'App\\Member', 1, 1, 'deposit', '5', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff topup\"}', '3f40e78e-5509-40f0-9a61-b4edb14ced21', '2023-01-06 12:22:36', '2023-01-06 12:22:36'),
(15, 'App\\Member', 1, 1, 'withdraw', '-50', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff deduct\"}', '33762d98-428a-407d-b01a-d90c9a83c52c', '2023-01-06 12:22:43', '2023-01-06 12:22:43'),
(16, 'App\\Member', 1, 1, 'deposit', '15', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff topup\"}', 'dc6ab798-022b-41f0-bc82-ce5911539a9f', '2023-01-07 13:27:12', '2023-01-06 13:27:12'),
(17, 'App\\Member', 2, 2, 'deposit', '20', 1, '{\"staff_id\":1,\"staff_name\":\"Super Admin\",\"remark\":\"CS Staff topup\"}', 'a11e144c-3155-4b75-adfc-e72b96a92172', '2023-01-06 13:29:29', '2023-01-06 13:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL,
  `to_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('exchange','transfer','paid','refund','gift') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `status_last` enum('exchange','transfer','paid','refund','gift') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_id` bigint(20) UNSIGNED NOT NULL,
  `withdraw_id` bigint(20) UNSIGNED NOT NULL,
  `discount` decimal(64,0) NOT NULL DEFAULT 0,
  `fee` decimal(64,0) NOT NULL DEFAULT 0,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@admin.com', '2020-05-18 15:07:15', '$2y$10$tqKuEqlmW1p5FjXG8d03N.wLfJL5hEL2T7M8PDEUOIb3hUWuQ.VxK', 'Y8A4W5GImbwpSevPaPiad0c14LBWlbnVvljcWQbfJuNMbiZP9IetjBZzuvAF', '2023-01-03 20:28:44', '2020-05-18 15:07:15', '2023-01-03 10:28:44'),
(8, 'milkin', 'Paloma@Paloma.com', NULL, '$2y$10$tqKuEqlmW1p5FjXG8d03N.wLfJL5hEL2T7M8PDEUOIb3hUWuQ.VxK', NULL, NULL, '2020-06-03 02:13:08', '2022-12-22 01:57:23'),
(17, 'user1', 'user1@mail.com', NULL, '$2y$10$tqKuEqlmW1p5FjXG8d03N.wLfJL5hEL2T7M8PDEUOIb3hUWuQ.VxK', NULL, NULL, '2022-12-16 18:39:54', '2022-12-16 18:39:54'),
(18, 'user2', 'user2@mail.com', NULL, '$2y$10$tqKuEqlmW1p5FjXG8d03N.wLfJL5hEL2T7M8PDEUOIb3hUWuQ.VxK', NULL, '2022-12-22 11:02:05', '2022-12-16 18:40:15', '2022-12-22 01:02:05'),
(19, 'employee1', 'employee1@user.com', NULL, '$2y$10$tqKuEqlmW1p5FjXG8d03N.wLfJL5hEL2T7M8PDEUOIb3hUWuQ.VxK', NULL, NULL, '2022-12-17 10:23:29', '2022-12-17 10:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `holder_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `balance` decimal(64,0) NOT NULL DEFAULT 0,
  `decimal_places` smallint(5) UNSIGNED NOT NULL DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `holder_type`, `holder_id`, `name`, `slug`, `uuid`, `description`, `meta`, `balance`, `decimal_places`, `created_at`, `updated_at`) VALUES
(1, 'App\\Member', 1, 'Default Wallet', 'default', 'ac840206-8982-4d4b-aab8-f2efda88252d', NULL, '[]', '170', 2, '2023-01-05 02:01:44', '2023-01-06 13:27:12'),
(2, 'App\\Member', 2, 'Default Wallet', 'default', '988dadf3-80e6-4785-87a6-87d0ece77a57', NULL, '[]', '75', 2, '2023-01-05 02:01:44', '2023-01-06 13:29:29'),
(3, 'App\\Member', 3, 'Default Wallet', 'default', 'e5da9560-8471-4c5a-9986-47047a797b86', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(4, 'App\\Member', 5, 'Default Wallet', 'default', 'e1604c4d-2042-48d0-a344-a2945d16f1b8', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(5, 'App\\Member', 6, 'Default Wallet', 'default', '94cef8d2-a14a-4b49-b89d-f04decbe3e8a', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(6, 'App\\Member', 7, 'Default Wallet', 'default', 'c5c669d9-d377-469a-994c-855f609c809d', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(7, 'App\\Member', 8, 'Default Wallet', 'default', 'a9df6358-037b-4bf0-a59c-162a0abd1c42', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(8, 'App\\Member', 10, 'Default Wallet', 'default', 'aa7f978b-c583-419c-80da-e9a707f9c16f', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(9, 'App\\Member', 11, 'Default Wallet', 'default', '8f6dafcc-049c-4425-8513-92b04a78c1b7', NULL, '[]', '0', 2, '2023-01-05 02:01:44', '2023-01-05 02:01:44'),
(10, 'App\\Member', 12, 'Default Wallet', 'default', '16ec31d1-31bf-488d-b7b4-52a7ef0a4035', NULL, '[]', '0', 2, '2023-01-06 10:18:02', '2023-01-06 10:18:02'),
(11, 'App\\Member', 13, 'Default Wallet', 'default', '2e361619-5f85-4133-9a61-2aa1dc592e99', NULL, '[]', '0', 2, '2023-01-06 10:25:11', '2023-01-06 10:25:11'),
(12, 'App\\Member', 14, 'Default Wallet', 'default', '3395e0e9-f00d-4eb0-8187-fd10e59f36a0', NULL, '[]', '0', 2, '2023-01-06 11:19:57', '2023-01-06 11:19:57'),
(13, 'App\\Member', 15, 'Default Wallet', 'default', '4ee6e6a2-44ef-449b-8472-2bfd86d5e0ff', NULL, '[]', '0', 2, '2023-01-06 11:19:57', '2023-01-06 11:19:57'),
(14, 'App\\Member', 19, 'Default Wallet', 'default', '9ab8a082-cb65-42f6-9e71-e624cc809be3', NULL, '[]', '0', 2, '2023-01-10 13:26:01', '2023-01-10 13:26:01'),
(15, 'App\\Member', 20, 'Default Wallet', 'default', 'ce3bb672-335a-4941-abd6-57d0a5c927a7', NULL, '[]', '0', 2, '2023-01-10 13:27:10', '2023-01-10 13:27:10'),
(16, 'App\\Member', 28, 'Default Wallet', 'default', '2f1ffb53-4ad5-4740-b96a-ca97bad25794', NULL, '[]', '0', 2, '2023-01-10 15:50:43', '2023-01-10 15:50:43'),
(17, 'App\\Member', 29, 'Default Wallet', 'default', '7d921807-cf96-486c-b46f-46884291b72c', NULL, '[]', '0', 2, '2023-01-10 16:23:30', '2023-01-10 16:23:30'),
(18, 'App\\Member', 30, 'Default Wallet', 'default', '34f06772-c895-44d8-aba9-99bfe5ea3368', NULL, '[]', '0', 2, '2023-01-10 16:25:08', '2023-01-10 16:25:08'),
(19, 'App\\Member', 31, 'Default Wallet', 'default', '9879f801-4096-4f4f-bed2-64a2f4753463', NULL, '[]', '0', 2, '2023-01-10 16:25:20', '2023-01-10 16:25:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`member_id`,`center_id`,`created_at`);

--
-- Indexes for table `admin_setting`
--
ALTER TABLE `admin_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_child`
--
ALTER TABLE `booking_child`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`,`service_id`,`emp_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `booking_master`
--
ALTER TABLE `booking_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`branch_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doors`
--
ALTER TABLE `doors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fm_door_center` (`center_id`);

--
-- Indexes for table `employee_detail`
--
ALTER TABLE `employee_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_tbl`
--
ALTER TABLE `notification_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_476162` (`role_id`),
  ADD KEY `permission_id_fk_476162` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`booking_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `rolelocations`
--
ALTER TABLE `rolelocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_476171` (`user_id`),
  ADD KEY `role_id_fk_476171` (`role_id`);

--
-- Indexes for table `static_notification`
--
ALTER TABLE `static_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_uuid_unique` (`uuid`),
  ADD KEY `transactions_payable_type_payable_id_index` (`payable_type`,`payable_id`),
  ADD KEY `payable_type_payable_id_ind` (`payable_type`,`payable_id`),
  ADD KEY `payable_type_ind` (`payable_type`,`payable_id`,`type`),
  ADD KEY `payable_confirmed_ind` (`payable_type`,`payable_id`,`confirmed`),
  ADD KEY `payable_type_confirmed_ind` (`payable_type`,`payable_id`,`type`,`confirmed`),
  ADD KEY `transactions_type_index` (`type`),
  ADD KEY `transactions_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transfers_uuid_unique` (`uuid`),
  ADD KEY `transfers_from_type_from_id_index` (`from_type`,`from_id`),
  ADD KEY `transfers_to_type_to_id_index` (`to_type`,`to_id`),
  ADD KEY `transfers_deposit_id_foreign` (`deposit_id`),
  ADD KEY `transfers_withdraw_id_foreign` (`withdraw_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_holder_type_holder_id_slug_unique` (`holder_type`,`holder_id`,`slug`),
  ADD UNIQUE KEY `wallets_uuid_unique` (`uuid`),
  ADD KEY `wallets_holder_type_holder_id_index` (`holder_type`,`holder_id`),
  ADD KEY `wallets_slug_index` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_setting`
--
ALTER TABLE `admin_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1270;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3660;

--
-- AUTO_INCREMENT for table `booking_child`
--
ALTER TABLE `booking_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4951;

--
-- AUTO_INCREMENT for table `booking_master`
--
ALTER TABLE `booking_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1288;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `doors`
--
ALTER TABLE `doors`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee_detail`
--
ALTER TABLE `employee_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notification_tbl`
--
ALTER TABLE `notification_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4677;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rolelocations`
--
ALTER TABLE `rolelocations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `static_notification`
--
ALTER TABLE `static_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_child`
--
ALTER TABLE `booking_child`
  ADD CONSTRAINT `booking_child_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_master` (`id`),
  ADD CONSTRAINT `booking_child_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_master`
--
ALTER TABLE `booking_master`
  ADD CONSTRAINT `booking_master_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`),
  ADD CONSTRAINT `booking_master_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_master_ibfk_3` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doors`
--
ALTER TABLE `doors`
  ADD CONSTRAINT `fm_door_center` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `employee_detail`
--
ALTER TABLE `employee_detail`
  ADD CONSTRAINT `employee_detail_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking_master` (`id`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_deposit_id_foreign` FOREIGN KEY (`deposit_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_withdraw_id_foreign` FOREIGN KEY (`withdraw_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
