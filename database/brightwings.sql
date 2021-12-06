-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2021 at 05:34 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brightwings`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `verification_key` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0 COMMENT '1 for verified',
  `designation` varchar(200) DEFAULT NULL,
  `user_type` varchar(200) NOT NULL DEFAULT 'STAFF',
  `joined_date` date DEFAULT NULL,
  `joined_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `name`, `email`, `phone`, `password`, `verification_key`, `is_verified`, `designation`, `user_type`, `joined_date`, `joined_time`) VALUES
(1, 'Amar Bazar', 'admin@brightwings.com', '8402081401', '00f50be1466d5057d653d867ab8df193a068133aaffc8e68e000a60ef56f8d32634b13a83a47ecac53a1f418e9306a3621f9cc1761121c7cba224fc02b04f7945X363YMTm3xkQ9S/SjWYY+VGfKQYk+GHiHj+z/Y476Q=', '', 1, NULL, 'ADMIN', '2021-04-21', '20:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` text DEFAULT NULL,
  `account_number` varchar(200) NOT NULL,
  `ifsc` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `payee_name` varchar(200) NOT NULL,
  `pan` varchar(200) NOT NULL,
  `pan_proof` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  `last_updated_date` date DEFAULT NULL,
  `last_updated_time` time DEFAULT NULL,
  `last_updated_remote` varchar(200) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(200) DEFAULT NULL,
  `file_name` varchar(200) NOT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1 COMMENT '0 for inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `combos`
--

CREATE TABLE `combos` (
  `combo_id` int(11) NOT NULL,
  `combo_code` varchar(200) NOT NULL,
  `total_price` decimal(55,2) NOT NULL DEFAULT 0.00,
  `added_on` bigint(20) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `combo_products`
--

CREATE TABLE `combo_products` (
  `combo_products_id` int(11) NOT NULL,
  `combo_code` varchar(200) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_on` bigint(20) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_of_users`
--

CREATE TABLE `coupon_of_users` (
  `coupon_id` int(11) NOT NULL,
  `epin` varchar(200) NOT NULL,
  `coupon_code` varchar(200) NOT NULL,
  `amount` decimal(55,2) NOT NULL DEFAULT 100.00,
  `eligible_from` date DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `is_used` int(11) NOT NULL DEFAULT 0,
  `used_on` bigint(20) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `epins`
--

CREATE TABLE `epins` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) DEFAULT NULL,
  `generated_by` varchar(200) DEFAULT NULL,
  `owner` varchar(200) DEFAULT NULL,
  `used` int(11) DEFAULT 0 COMMENT '0 for unused, 1 for used',
  `generated_date` date DEFAULT NULL,
  `generated_time` time DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `epin_transfer_history`
--

CREATE TABLE `epin_transfer_history` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) DEFAULT NULL,
  `transfered_from` varchar(200) DEFAULT NULL,
  `transfered_to` varchar(200) DEFAULT NULL,
  `transfered_date` date DEFAULT NULL,
  `transfered_time` time DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level_pay_history`
--

CREATE TABLE `level_pay_history` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) NOT NULL,
  `amount` decimal(55,2) NOT NULL,
  `for_epin` varchar(200) NOT NULL,
  `for_level` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_role` varchar(200) DEFAULT NULL,
  `os` varchar(200) DEFAULT NULL,
  `browser` varchar(200) DEFAULT NULL,
  `ip` varchar(200) DEFAULT NULL,
  `login_date` date DEFAULT NULL,
  `login_time` time DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `user_role`, `os`, `browser`, `ip`, `login_date`, `login_time`, `status`) VALUES
(27, 1, 'ADMIN', 'Windows 10', 'Chrome', '::1', '2021-07-13', '08:38:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` varchar(200) NOT NULL,
  `show_until` date NOT NULL,
  `added_date` date NOT NULL,
  `added_time` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_epin` varchar(200) NOT NULL,
  `amount` decimal(55,2) NOT NULL,
  `tds` decimal(55,2) NOT NULL,
  `tds_percentage` int(11) NOT NULL,
  `admin_charge` decimal(55,2) NOT NULL DEFAULT 0.00,
  `pan` varchar(200) DEFAULT NULL,
  `paid_amount` decimal(55,2) NOT NULL,
  `transferred_on` bigint(20) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `ifsc` varchar(200) NOT NULL,
  `payee_name` varchar(200) NOT NULL,
  `transaction_status` int(11) NOT NULL DEFAULT 1 COMMENT '1 if success, 2 if failed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `sub_category` varchar(200) NOT NULL,
  `market_price` decimal(55,2) NOT NULL,
  `price` decimal(55,2) NOT NULL,
  `productImage` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `bv` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `added_on` bigint(20) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` text DEFAULT NULL,
  `account_number` varchar(200) NOT NULL,
  `ifsc` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `payee_name` varchar(200) NOT NULL,
  `pan` varchar(200) NOT NULL,
  `pan_proof` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  `last_updated_date` date DEFAULT NULL,
  `last_updated_time` time DEFAULT NULL,
  `last_updated_remote` varchar(200) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_records`
--

CREATE TABLE `stock_records` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `current_stock` int(11) NOT NULL,
  `updated_on` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category` varchar(200) DEFAULT NULL,
  `sub_category` varchar(200) DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1 COMMENT '0 for inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) NOT NULL,
  `narration` varchar(200) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `credit` decimal(55,2) NOT NULL DEFAULT 0.00,
  `debit` decimal(55,2) NOT NULL DEFAULT 0.00,
  `updated_amount` decimal(55,2) NOT NULL,
  `updated_on` bigint(20) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `otp` bigint(20) DEFAULT NULL,
  `epin` varchar(200) DEFAULT NULL,
  `joined_on` bigint(20) NOT NULL,
  `referral_code` varchar(50) DEFAULT NULL,
  `position_under` varchar(200) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1 COMMENT '1 is active, 0 is inactive, 3 for expired, 2 for repurchase needed',
  `avatar` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pan` varchar(50) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `offer_selected` enum('COMBO','COUPON','LATER') NOT NULL,
  `combo_code` varchar(200) DEFAULT NULL,
  `delivery_type` varchar(200) DEFAULT NULL,
  `user_type` varchar(200) NOT NULL DEFAULT 'USER',
  `last_login_ip` varchar(200) DEFAULT NULL,
  `bank_details_given` int(11) NOT NULL DEFAULT 0 COMMENT '0 for not updated, 1 for approved, 2 for pending, 3 for rejected',
  `account_number` varchar(200) DEFAULT NULL,
  `ifsc` varchar(200) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `payee_name` varchar(200) DEFAULT NULL,
  `branch_name` varchar(200) DEFAULT NULL,
  `passbook` varchar(200) DEFAULT NULL,
  `level_from_top` int(11) NOT NULL DEFAULT 0,
  `is_otp_verified` int(11) NOT NULL DEFAULT 0 COMMENT '1 if user verified their account with phone number',
  `is_notification` int(11) NOT NULL DEFAULT 0,
  `is_payment_distributed` int(11) NOT NULL DEFAULT 0,
  `is_admin_unlocked_after_expiration` int(11) NOT NULL DEFAULT 0,
  `pending_started_date` date DEFAULT NULL COMMENT 'started date of pending block of account from which month and amount is calculated',
  `pending_user_total_amount` decimal(55,2) DEFAULT NULL COMMENT 'total amount reached',
  `pending_per_month_purchase` decimal(55,2) DEFAULT NULL COMMENT 'purchase per month, total months * pending_per_month_purchase',
  `pending_unblock_uploaded_file_link` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_epin` varchar(200) NOT NULL,
  `combo_code` varchar(200) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `coupon_used` varchar(200) DEFAULT NULL,
  `coupon_discount` decimal(55,2) DEFAULT 0.00,
  `total_amount` decimal(55,2) NOT NULL,
  `address` varchar(200) NOT NULL,
  `delivery_type` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 for ordered, 1 for delivered, 2 for dispatched, 3 for cancelled',
  `added_on` bigint(20) NOT NULL,
  `delivered_on` bigint(20) DEFAULT NULL,
  `cancelled_on` bigint(20) DEFAULT NULL,
  `shipment_number` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) DEFAULT NULL,
  `available` decimal(55,2) DEFAULT 0.00,
  `total_balance` decimal(55,2) NOT NULL DEFAULT 0.00,
  `lost_balance` decimal(55,2) NOT NULL DEFAULT 0.00,
  `is_active` int(11) DEFAULT 1,
  `last_updated` bigint(20) DEFAULT NULL,
  `created_on` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_credits`
--

CREATE TABLE `weekly_credits` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) NOT NULL,
  `week_no` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_credit` decimal(55,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawl_requests`
--

CREATE TABLE `withdrawl_requests` (
  `id` int(11) NOT NULL,
  `epin` varchar(200) NOT NULL,
  `amount` decimal(55,2) NOT NULL,
  `requested_on` bigint(20) NOT NULL,
  `paid_on` bigint(20) DEFAULT NULL,
  `rejected_on` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 for initial, 1for approved, 2 for rejected'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashier`
--
ALTER TABLE `cashier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`combo_id`);

--
-- Indexes for table `combo_products`
--
ALTER TABLE `combo_products`
  ADD PRIMARY KEY (`combo_products_id`);

--
-- Indexes for table `coupon_of_users`
--
ALTER TABLE `coupon_of_users`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `epins`
--
ALTER TABLE `epins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epin` (`epin`);

--
-- Indexes for table `epin_transfer_history`
--
ALTER TABLE `epin_transfer_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_pay_history`
--
ALTER TABLE `level_pay_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_records`
--
ALTER TABLE `stock_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `epin` (`epin`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epin` (`epin`);

--
-- Indexes for table `weekly_credits`
--
ALTER TABLE `weekly_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawl_requests`
--
ALTER TABLE `withdrawl_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cashier`
--
ALTER TABLE `cashier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `combos`
--
ALTER TABLE `combos`
  MODIFY `combo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `combo_products`
--
ALTER TABLE `combo_products`
  MODIFY `combo_products_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupon_of_users`
--
ALTER TABLE `coupon_of_users`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `epins`
--
ALTER TABLE `epins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `epin_transfer_history`
--
ALTER TABLE `epin_transfer_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `level_pay_history`
--
ALTER TABLE `level_pay_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_records`
--
ALTER TABLE `stock_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `weekly_credits`
--
ALTER TABLE `weekly_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `withdrawl_requests`
--
ALTER TABLE `withdrawl_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
