-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 04:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eft_rt`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_deposites`
--

CREATE TABLE `payment_deposites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount1` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `currency1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_1` tinyint(1) NOT NULL DEFAULT 0,
  `order_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount2` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `currency2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `txn_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `apply_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_deposites`
--

INSERT INTO `payment_deposites` (`id`, `user_id`, `buyer_email`, `amount1`, `currency1`, `status_1`, `order_id`, `status_text`, `amount2`, `currency2`, `expire_at`, `txn_id`, `address_1`, `status_url`, `gateway`, `amount`, `status`, `apply_date`, `created_at`, `updated_at`) VALUES
(1, 4, 'pritesh@gmail.com', '1000.00000000', 'usdttrc20', 0, 'oTYoQLBA', 'waiting', '991.48673200', 'usdttrc20', '2025-11-15 03:21:57', '5293599692', 'TGVAbwDDqFrEsg6UovJ61YCUeQY8MA22yP', 'https://api.nowpayments.io/v1/payment/5293599692', 'crypto2crypto', '1000.00000000', 0, '2025-11-15 08:48 am', '2025-11-15 03:18:57', '2025-11-15 03:18:57'),
(2, 4, 'pritesh@gmail.com', '1000.00000000', 'usdttrc20', 0, 'AguEWQO6', 'waiting', '991.48673200', 'usdttrc20', '2025-11-15 03:26:32', '4434146817', 'TAvQjPnexcuctC8xN2W5DfxJoKz9oi5Ktx', 'https://api.nowpayments.io/v1/payment/4434146817', 'crypto2crypto', '1000.00000000', 0, '2025-11-15 08:53 am', '2025-11-15 03:23:32', '2025-11-15 03:23:32'),
(3, 4, 'pritesh@gmail.com', '1000.00000000', 'usdttrc20', 0, 'CtHWWuBg', 'waiting', '991.48673200', 'usdttrc20', '2025-11-15 03:40:37', '6262080500', 'TCcn3uNv3TCYpc6TdpAGR7cNDmF8GUDjVD', 'https://api.nowpayments.io/v1/payment/6262080500', 'crypto2crypto', '1000.00000000', 0, '2025-11-15 09:07 am', '2025-11-15 03:37:37', '2025-11-15 03:37:37');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(11) NOT NULL DEFAULT 1,
  `contact` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(11) NOT NULL DEFAULT 0,
  `total_usdt` decimal(10,2) NOT NULL DEFAULT 0.00,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `contact`, `assign_rate`, `email_verified_at`, `is_deleted`, `total_usdt`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dinesh', 'dineshjangu6363@gmail.com', 1, NULL, '0.00', NULL, 1, '0.00', '$2y$10$w6j5k/4Y/JwYHjy20ufXf.U/wM7RLLYcXKD702k7WIe063/jiGcga', NULL, '2025-11-05 09:38:13', '2025-11-15 05:10:50'),
(2, 'Dinesh', 'dineshjangu0469@gmail.com', 1, NULL, '3.00', NULL, 0, '0.00', '$2y$10$wNSPf0LWJAPoR89dHeEg2Okb4l0tZ9xNvl3fYVs16kGLWqcjSKeAa', NULL, '2025-11-12 13:12:33', '2025-11-15 06:42:44'),
(3, 'Sam Jain', 'sanyamsahalot@gmail.com', 1, NULL, '0.00', NULL, 0, '0.00', '$2y$10$GurLxSRea8VxBmU/UN6dS.FFMEnqzIGrqdeCYgs2l0bzdfo6AzZWS', NULL, '2025-11-12 23:55:23', '2025-11-12 23:55:23'),
(4, 'Pritesh', 'pritesh@gmail.com', 1, '9865258565', '2.00', NULL, 0, '3000.00', '$2y$10$U8MyA1NVcXAeB69tzEsjVudqDkODsFTCqoxPUxfnFQkuOPph3fFde', NULL, '2025-11-15 01:44:00', '2025-11-15 06:48:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_deposites`
--
ALTER TABLE `payment_deposites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_txn_id` (`txn_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_deposites`
--
ALTER TABLE `payment_deposites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
