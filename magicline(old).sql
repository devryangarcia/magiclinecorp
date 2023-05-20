-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 07:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magicline`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_lists`
--

CREATE TABLE `access_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `accesslists` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `access_lists`
--

INSERT INTO `access_lists` (`id`, `user_id`, `accesslists`) VALUES
(1, 1, 'ALL'),
(2, 2, 'ALL'),
(3, 3, 'ALL'),
(4, 4, 'COFRAD'),
(5, 5, 'COFRAD,FRANCE DISPLAY,LOFTNGARDEN,WOLF & SMF'),
(6, 6, 'COFRAD,FRANCE DISPLAY,WOLF & SMF');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `timestamp`) VALUES
(1, '2', 'Logged in', '2023-05-17 03:29:35'),
(2, '4', 'Logged in', '2023-05-17 03:29:50'),
(3, '4', 'Logged out', '2023-05-17 03:34:34'),
(4, '6', 'Logged in', '2023-05-17 03:34:52'),
(5, '6', 'Logged out', '2023-05-17 03:37:01'),
(6, '6', 'Logged in', '2023-05-17 03:37:12'),
(7, '6', 'Logged out', '2023-05-17 03:38:00'),
(8, '6', 'Logged in', '2023-05-17 03:38:10'),
(9, '6', 'Logged out', '2023-05-17 03:38:30'),
(10, '4', 'Logged in', '2023-05-17 03:39:35'),
(11, '4', 'Logged out', '2023-05-17 03:40:11'),
(12, '2', 'Logged out', '2023-05-17 05:08:54'),
(13, '1', 'Logged in', '2023-05-17 05:09:01'),
(14, '6', 'Logged in', '2023-05-17 05:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `avatar`) VALUES
(1, 'avatar 1.png'),
(2, 'avatar 2.png'),
(3, 'avatar 3.png'),
(4, 'avatar 4.png'),
(5, 'avatar 5.png'),
(6, 'avatar 6.png'),
(7, 'avatar 7.png'),
(8, 'avatar 8.png'),
(9, 'avatar 9.png');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_19_013016_create_products_table', 1),
(6, '2023_04_20_005554_create_access_lists_table', 1),
(7, '2023_04_20_011151_create_partners_table', 1),
(8, '2023_04_27_005144_create_temporary_files_table', 1),
(9, '2023_04_28_032054_create_reset_requests_table', 1),
(10, '2023_05_17_081236_create_activity_logs_table', 1),
(11, '2023_05_17_081516_create_prices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `archived` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `company`, `logo`, `archived`) VALUES
(1, 'CLEO', 'CLEO.png', NULL),
(2, 'COFRAD', 'COFRAD.png', NULL),
(3, 'LOFTNGARDEN', 'LOFT&GARDEN.png', NULL),
(4, 'MANEX FRANCE', 'MANEX FRANCE.png', NULL),
(5, 'FRANCE DISPLAY', 'MANEX USA.png', NULL),
(6, 'NUBODY', 'NUBODY.png', NULL),
(7, 'RUNWAY', 'RUNWAY.png', NULL),
(8, 'STOCKMAN PARIS', 'STOCKMAN.png', NULL),
(9, 'WOLF & SMF', 'WOLF&SMF.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `itemref` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `isallowed` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po` varchar(255) DEFAULT NULL,
  `itemref` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` longtext DEFAULT NULL,
  `description` longtext NOT NULL,
  `images` varchar(255) NOT NULL,
  `file` longtext DEFAULT NULL,
  `addedby` varchar(255) NOT NULL,
  `updatedby` varchar(255) DEFAULT NULL,
  `archived` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `po`, `itemref`, `company`, `category`, `type`, `price`, `description`, `images`, `file`, `addedby`, `updatedby`, `archived`) VALUES
(1, '6896LM', 'NY-AS01', 'FRANCE DISPLAY', 'Bust & Torso', 'Standard', NULL, '<p>This is the current infos</p>', 'NY-AS01-1.jpg,NY-AS01-2.jpg,NY-AS01-3.jpg,NY-AS01-4.jpg', NULL, 'christophe', NULL, NULL),
(2, 'CF001671', 'P750-1-AI', 'COFRAD', 'Mannequin', 'Standard', NULL, '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry</span><br></p>', 'P750-1-AI (1).JPG,P750-1-AI (2).JPG,P750-1-AI (3).JPG,P750-1-AI (4).JPG', NULL, 'christophe', NULL, NULL),
(3, 'CF001702', 'SS-B535-36-SC-1038', 'COFRAD', 'Bust & Torso', 'Standard', NULL, '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry</span><br></p>', 'SS-B535-36-SC-1038 (2).JPG,SS-B535-36-SC-1038 (3).JPG,SS-B535-36-SC-1038 (4).JPG,SS-B535-36-SC-1038 (5).JPG', NULL, 'christophe', NULL, NULL),
(4, '80516JD', 'INTIMATE SIZE 34D', 'WOLF & SMF', 'Bust & Torso', 'Standard', NULL, '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry</span><br></p>', 'INTIMATE SIZE 34D (1).JPG,INTIMATE SIZE 34D (2).JPG,INTIMATE SIZE 34D (3).JPG,INTIMATE SIZE 34D (4).JPG', NULL, 'christophe', NULL, NULL),
(5, '80576LM', 'SMF-RL-WDDF-2-RP', 'WOLF & SMF', 'Bust & Torso', 'Standard', NULL, '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry</span><br></p>', 'SMF-RL-WDDF-2-RP (1).JPG,SMF-RL-WDDF-2-RP (2).JPG,SMF-RL-WDDF-2-RP (3).JPG,SMF-RL-WDDF-2-RP (4).JPG', NULL, 'christophe', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reset_requests`
--

CREATE TABLE `reset_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset_requests`
--

INSERT INTO `reset_requests` (`id`, `user_id`, `password`) VALUES
(1, '6', '$2y$10$8wlNw2/871EDlR8s/J.ybemxKmgO9kBhVd65.J8YT2yn7SePQ5Eve');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folder` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `archived` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `email`, `email_verified_at`, `company`, `password`, `role`, `status`, `avatar`, `archived`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Christophe', 'Israel', 'christophe', 'christophe@cofrad.com', NULL, 'MAGIC LINE', '$2y$10$MrCgJDjG7pTEeS84G1vXmeewdHPjllAzpH8/s04DMHCr8iJeN5sWy', 'owner', 'activated', 'avatar 1.png', NULL, NULL, NULL, NULL),
(2, 'Ryan', 'Garcia', 'ryan', 'ryangarcia.dev@gmail.com', NULL, 'MAGIC LINE', '$2y$10$/TG5a/2/Xr9TmZ/BwcrDouw6hJMVTb7XcwFeeckzlyg2xdvO22INC', 'admin1', 'activated', 'avatar 9.png', NULL, NULL, NULL, NULL),
(3, 'Star', 'Esguerra', 'star', 'star@gmail.com', NULL, 'MAGIC LINE', '$2y$10$2tpBmFuImKyQ4mZAlVYNdOi5kfTRbpqLElkRttXdzgDpDZcnQsaAy', 'admin1', 'activated', 'avatar 2.png', NULL, NULL, NULL, NULL),
(4, 'The', 'Viewer', 'viewer', 'viewer@gmail.com', NULL, 'MAGIC LINE', '$2y$10$w7LzbHHHUzQrdehoPDKB4OgyUyCc96wpRLwM9FGqV6pnnh6IWnmGq', 'user', 'activated', 'avatar 2.png', NULL, NULL, NULL, NULL),
(5, 'Viewer', 'Two', 'viewer2', 'viewer2@gmail.com', NULL, 'MAGIC LINE', '$2y$10$MZSqI4F.tsMqSZlQz9nypedGHVBOgGfpjBLHsb6MLIjqK1dnMsjhG', 'user', 'activated', 'avatar 6.png', NULL, NULL, NULL, NULL),
(6, 'Walter', 'Mart', 'walter', 'walter@gmail.com', NULL, 'MAGIC LINE', '$2y$10$Xusy.k95EhH9dFFRdvHWRugfm.UB8pymk.hZ8ABf8c/u.GlMH5wea', 'admin2', 'activated', 'avatar 4.png', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_lists`
--
ALTER TABLE `access_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_lists_user_id_foreign` (`user_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_requests`
--
ALTER TABLE `reset_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_lists`
--
ALTER TABLE `access_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reset_requests`
--
ALTER TABLE `reset_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_lists`
--
ALTER TABLE `access_lists`
  ADD CONSTRAINT `access_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
