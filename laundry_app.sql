-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 12:57 AM
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
-- Database: `laundry_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `service_id`, `customer_name`, `weight`, `total_price`, `status`, `created_at`, `quantity`, `phone`, `address`, `latitude`, `longitude`, `payment_proof`) VALUES
(2, 1, 3, 'yaya', NULL, 30000.00, 'done', '2026-04-13 17:11:57', 3, '1234567890', 'Jalan Murti Saphira Raya, RW 24, Muktiharjo Kidul, Pedurungan, Semarang, Central Java, Java, 50197, Indonesia', 0.00000000, 0.00000000, '1776100474_profile.jpg'),
(3, 1, 3, 'yaya', NULL, 50000.00, 'done', '2026-04-14 00:06:15', 5, '1234567890', 'Jalan Murti Saphira Raya, RW 24, Muktiharjo Kidul, Pedurungan, Semarang, Central Java, Java, 50197, Indonesia', -6.97128047, 110.45355527, '1776125973_Screenshot 2026-04-12 135506.png'),
(4, 1, 1, 'yaya', 3.00, 15000.00, 'process', '2026-04-14 06:54:09', NULL, '1234567890', 'SMK Negeri 8 Semarang, Jalan Pandanaran II, RW 01, Mugassari, Semarang Selatan, Semarang, Central Java, Java, 50241, Indonesia', -6.99023087, 110.42038981, '1776149710_TTYAO REII Japanese School Uniform Men JK Outfit 2 Button Blazer Suit Jacket Preppy Style Students Costume for Graduation.jpg'),
(5, 1, 1, 'yaya', 50.00, 500000.00, 'waiting', '2026-04-14 07:57:26', NULL, '1234567890', 'Jalan Brotojoyo VII, RW 03, Panggung Kidul, Semarang Utara, Semarang, Central Java, Java, 50171, Indonesia', -6.96792148, 110.40374176, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price_per_kg` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `input_type` enum('weight','item') DEFAULT 'weight',
  `is_active` tinyint(1) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price_per_kg`, `description`, `icon`, `created_at`, `input_type`, `is_active`, `image`) VALUES
(1, 'Wash', 10000.00, NULL, NULL, '2026-04-12 07:17:54', 'weight', 1, '1776149021_aset_baju_1.png'),
(2, 'Dry Cleaning', 7000.00, NULL, NULL, '2026-04-12 07:17:54', 'weight', 1, '1776149049_dryclean.png'),
(3, 'Duvets', 10000.00, NULL, NULL, '2026-04-12 07:17:54', 'item', 1, '1776149070_duvet.png'),
(5, 'Uniform', 7000.00, NULL, NULL, '2026-04-14 04:31:39', 'weight', 0, '1776149148_TTYAO_REII_Japanese_School_Uniform_Men_JK_Outfit_2_Button_Blazer_Suit_Jacket_Preppy_Style_Students_Costume_for_Graduation.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '0192023a7bbd73250516f069df18b500', 'admin', '2026-04-12 07:17:54'),
(2, 'John', 'user@gmail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-04-12 07:17:54'),
(3, 'darel', 'darrelrabbani4@gmail.com', '87654321', '827ccb0eea8a706c4c34a16891f84e7b', 'user', '2026-04-13 17:26:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
