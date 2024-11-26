-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 06:13 AM
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
(14, 'input', 1, 'Input field', 'enter text here', '5', '1', '', ''),
(15, 'textarea', 1, 'textarea', 'this is textarea', '5', '1', '', ''),
(16, 'number', 1, 'Number', 'enter here', '5', '1', '', ''),
(17, 'password', 1, 'password', 'enter here', '5', '1', '', ''),
(18, 'date', 1, 'Date', 'enter here', '5', '1', '', ''),
(19, 'url', 1, 'URl', 'enter text here', '5', '1', '', ''),
(20, 'dropdown', 1, 'dropdown', 'this is dropdown', '5', '1', '', 'option 1,option 2,option 3,option 4'),
(21, 'radio', 1, 'Gender', 'select gender', '5', '1', '', 'Male,Female,Other'),
(22, 'checkbox', 1, 'checkbox label', 'aa', '5', '1', 'Checkbox option 3', 'Checkbox option 1,Checkbox option 2,Checkbox option 3,Checkbox option 4');

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
(7, 10, 'aa', 'aa', '2024-11-01 14:39:26', '2024-11-01 14:39:26'),
(8, 10, 'Hello form', 'this is form description', '2024-11-16 15:40:22', '2024-11-16 15:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `form_id` varchar(255) NOT NULL,
  `field_id` varchar(255) NOT NULL,
  `response_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`response_values`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `form_id`, `field_id`, `response_values`) VALUES
(21, '5', '22_checkbox_2', '{\"14\":\"input field\",\"15\":\"this is textarea\",\"16\":\"123456\",\"17\":\"this is password\",\"18\":\"2024-11-07\",\"19\":\"https://google.com\",\"20\":\"option 4\",\"21\":\"Female\",\"22\":\"Checkbox option 3\"}'),
(24, '5', '22_checkbox_3', '{\"14\":\"Hello\",\"15\":\"hello textarea\",\"16\":\"123\",\"17\":\"password\",\"18\":\"2024-11-22\",\"19\":\"https://google.com\",\"20\":\"option 2\",\"21\":\"Male\",\"22_checkbox_3\":\"Checkbox option 4\",\"22\":\"Checkbox option 3,Checkbox option 4\"}');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
