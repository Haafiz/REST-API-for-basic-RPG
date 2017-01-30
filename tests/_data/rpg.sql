-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2017 at 04:18 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpg`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(10) UNSIGNED NOT NULL,
  `skilled_in` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `name`, `age`, `skilled_in`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Laila Glover', 80, 'Culpa autem modi maiores dicta laborum voluptates.', NULL, '2017-01-30 23:17:29', '2017-01-30 23:17:29'),
(2, 'Javier Witting', 41, 'Maiores corrupti voluptatem ipsam libero nulla quia minima et.', NULL, '2017-01-30 23:17:29', '2017-01-30 23:17:29'),
(3, 'Dr. Thad McCullough', 55, 'Voluptatem consequuntur labore qui quasi et.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(4, 'Miss Camilla Lockman I', 73, 'Nihil impedit et sunt inventore sapiente.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(5, 'Margaretta Halvorson', 45, 'Quo minus praesentium vitae quasi rerum laborum et et.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(6, 'Kadin McClure', 67, 'Adipisci fugit officiis nam ea vero soluta.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(7, 'Carter Streich', 12, 'Vitae earum et placeat sed distinctio totam sit unde.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(8, 'Dillan Windler', 15, 'Architecto nobis necessitatibus occaecati est in inventore.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(9, 'Vern Leuschke', 15, 'Atque laboriosam similique veniam rerum id quidem.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30'),
(10, 'Margarete Williamson', 61, 'Fuga ea corporis occaecati aut voluptas sed.', NULL, '2017-01-30 23:17:30', '2017-01-30 23:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `fights`
--

CREATE TABLE `fights` (
  `id` int(10) UNSIGNED NOT NULL,
  `opponent_id` int(10) UNSIGNED NOT NULL,
  `character_id` int(10) UNSIGNED NOT NULL,
  `status` enum('won','lost','draw') COLLATE utf8_unicode_ci NOT NULL,
  `experience` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(60, '2016_03_08_164317_create_users_table', 1),
(61, '2016_03_08_164400_create_password_resets_table', 1),
(62, '2017_01_29_085205_create_characters_table', 1),
(63, '2017_01_29_102132_create_fights_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Gerald Medhurst I', 'kaasib@gmail.com', '$2y$10$eO.EAA3CQwKic5SK5U2K2eaLEIQwtT9T7woqKXifJziH5xC9xwHl6', 'r6VpeRZmzq', '2017-01-30 23:17:29', '2017-01-30 23:17:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `characters_user_id_foreign` (`user_id`);

--
-- Indexes for table `fights`
--
ALTER TABLE `fights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fights_opponent_id_foreign` (`opponent_id`),
  ADD KEY `fights_character_id_foreign` (`character_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

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
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fights`
--
ALTER TABLE `fights`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fights`
--
ALTER TABLE `fights`
  ADD CONSTRAINT `fights_character_id_foreign` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `fights_opponent_id_foreign` FOREIGN KEY (`opponent_id`) REFERENCES `characters` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
