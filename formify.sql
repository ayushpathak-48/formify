-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 04:37 AM
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
-- Database: `formify`
--

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `is_required` int(1) NOT NULL,
  `label` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `form_id` varchar(255) NOT NULL,
  `is_active` varchar(1) NOT NULL,
  `default_value` varchar(255) NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `field_type`, `is_required`, `label`, `placeholder`, `form_id`, `is_active`, `default_value`, `options`) VALUES
(1, 'dropdown', 1, 'Select Dropdown', 'placeholder', '5', '1', '', '1,2,3,4,5,6'),
(3, 'input', 1, 'Name', 'Enter name here', '5', '1', '', ''),
(7, 'textarea', 1, 'Textarea label', 'Textarea placeholder', '5', '1', '', ''),
(8, 'number', 1, 'Phone number', 'Enter phone number', '5', '1', '', ''),
(9, 'date', 0, 'Date', 'Enter Date', '5', '1', '', ''),
(10, 'url', 1, 'Enter URL', 'placeholder', '5', '1', '', ''),
(11, 'dropdown', 1, 'Dropdown', 'Select Fruit', '5', '1', '', 'Mango,Banana,Apple,Orange'),
(13, 'radio', 1, 'Radio Label', 'This is radio button', '5', '1', '', 'Male,Female,Value');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `user_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5, 10, 'aa', 'aa', '2024-11-01 14:39:01', '2024-11-01 14:39:01'),
(6, 10, 'aa', 'aa', '2024-11-01 14:39:10', '2024-11-01 14:39:10'),
(7, 10, 'aa', 'aa', '2024-11-01 14:39:26', '2024-11-01 14:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `form_id` varchar(255) NOT NULL,
  `field_id` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `form_id`, `field_id`, `value`) VALUES
(5, '5', '3', 'Aayush'),
(6, '5', '7', 'Textarea'),
(7, '5', '8', '1234567890'),
(8, '5', '10', 'https://google.com'),
(9, '5', '13', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`) VALUES
(10, 'admin', 'ayush010pathak@gmail.com', '$2y$10$cJSCCMPEzlULWP8g18sA/OKPNyOzBJLnzghfKKm9My8MFHvReNdWO', 'Aayush'),
(13, 'ayushpathak-48', 'test@gmail.com', '$2y$10$dgPX8nbiZRn9WPWHIg1xjuIHFp5ZpXmvQ21JPVbYwC8xjtBUbhuSq', 'hello');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
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
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
