-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2026 at 08:57 AM
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
-- Database: `vpmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL,
  `exit_time` datetime DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `rate_per_hour` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `booking_id`, `user_id`, `vehicle_no`, `entry_time`, `exit_time`, `total_hours`, `rate_per_hour`, `amount`, `created_at`) VALUES
(7, 6, 4, 'PB081295', '2026-04-27 13:29:02', '2026-04-27 14:57:28', 1.00, 10.00, 10.00, '2026-04-27 09:27:28'),
(8, 7, 5, 'PB081295', '2026-04-28 16:18:25', '2026-04-28 16:18:37', 1.00, 20.00, 20.00, '2026-04-28 10:48:37'),
(9, 11, 6, 'PB081223', '2026-04-30 16:00:30', '2026-04-30 16:19:31', 1.00, 10.00, 10.00, '2026-04-30 10:49:31'),
(10, 10, 6, 'PB083456', '2026-04-30 15:48:40', '2026-04-30 16:19:36', 1.00, 20.00, 20.00, '2026-04-30 10:49:36'),
(11, 9, 6, 'PB081295', '2026-04-30 15:04:34', '2026-04-30 16:19:41', 1.00, 10.00, 10.00, '2026-04-30 10:49:41'),
(12, 8, 4, 'PB081234', '2026-04-29 12:39:30', '2026-04-30 16:27:01', 25.00, 20.00, 500.00, '2026-04-30 10:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL,
  `exit_time` datetime DEFAULT NULL,
  `status` enum('in','out') DEFAULT 'in',
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `slot_id`, `vehicle_no`, `entry_time`, `exit_time`, `status`, `amount`) VALUES
(4, 4, 5, 'PB083456', NULL, '2026-04-24 17:26:18', 'out', 10.00),
(5, 5, 4, 'PB086745', '2026-04-26 23:12:14', '2026-04-26 23:14:21', 'out', 20.00),
(6, 4, 5, 'PB081295', '2026-04-27 13:29:02', '2026-04-27 14:57:28', 'out', 10.00),
(7, 5, 4, 'PB081295', '2026-04-28 16:18:25', '2026-04-28 16:18:37', 'out', 20.00),
(8, 4, 10, 'PB081234', '2026-04-29 12:39:30', '2026-04-30 16:27:01', 'out', 500.00),
(9, 6, 5, 'PB081295', '2026-04-30 15:04:34', '2026-04-30 16:19:41', 'out', 10.00),
(10, 6, 3, 'PB083456', '2026-04-30 15:48:40', '2026-04-30 16:19:36', 'out', 20.00),
(11, 6, 16, 'PB081223', '2026-04-30 16:00:30', '2026-04-30 16:19:31', 'out', 10.00),
(12, 6, 6, 'PB081212', '2026-04-30 16:06:11', '2026-04-30 16:07:56', 'out', 20.00),
(13, 7, 4, 'PB085911', '2026-05-01 11:06:02', '2026-05-01 11:07:42', 'out', 20.00),
(14, 7, 5, 'PB081067', '2026-05-01 11:15:18', '2026-05-01 11:17:17', 'out', 20.00),
(15, 7, 13, 'PB084568', '2026-05-01 11:20:44', '2026-05-01 11:23:47', 'out', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `floor_id` int(11) NOT NULL,
  `floor_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`floor_id`, `floor_name`) VALUES
(1, 'Ground Floor'),
(2, 'First Floor'),
(5, 'Second Floor');

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `slot_id` int(11) NOT NULL,
  `slot_number` varchar(20) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `vehicle_type` enum('Car','Bike') NOT NULL,
  `status` enum('free','occupied') DEFAULT 'free'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`slot_id`, `slot_number`, `floor_id`, `vehicle_type`, `status`) VALUES
(1, 'S1', 5, 'Car', 'free'),
(2, 'G1', 1, 'Car', 'free'),
(3, 'G2', 1, 'Car', 'free'),
(4, 'G3', 1, 'Car', 'free'),
(5, 'G4', 1, 'Bike', 'free'),
(6, 'G5', 1, 'Bike', 'free'),
(7, 'G6', 1, 'Bike', 'free'),
(8, 'F1', 2, 'Car', 'free'),
(9, 'F2', 2, 'Car', 'free'),
(10, 'F3', 2, 'Car', 'free'),
(11, 'F4', 2, 'Bike', 'free'),
(12, 'F5', 2, 'Bike', 'free'),
(13, 'F6', 2, 'Bike', 'free'),
(14, 'S2', 5, 'Car', 'free'),
(15, 'S3', 5, 'Car', 'free'),
(16, 'S4', 5, 'Bike', 'free'),
(17, 'S5', 5, 'Bike', 'free'),
(18, 'S6', 5, 'Bike', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `fullname`, `email`, `password`, `mobile`, `reg_date`) VALUES
(4, 'Mohit', 'mohit@gmail.com', '$2y$10$V865.H0MwXLGDOK0lTNjY.YwVpq7LAOtrI.oY7BOngqVuKZ6iWeNy', '3451234512', '2026-04-24 06:54:15'),
(5, 'Neha', 'neha12@gmail.com', '$2y$10$iiVCHcLD6zbZ/VX7UxDGCunZ1dSyPyuxYh/yETVoRUkjfHxHTbpmC', '5673412345', '2026-04-26 17:34:13'),
(6, 'Neha', 'neha.tech829@gmail.com', '$2y$10$bKqXClW2dpcNsxkIr9zpYuws97Ezb5HFQ9mbJ6saWZLsPIAG.bbhC', '8699846411', '2026-04-30 09:32:28'),
(7, 'Namarta', 'namartabirdi@gmail.com', '$2y$10$elgHLN.VX0mBDvD/HFZTP.OZ6RjCct5QCS1APOhhe0ogpdbq4ix/u', '8989893412', '2026-05-01 05:35:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`floor_id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `slots` (`slot_id`) ON DELETE CASCADE;

--
-- Constraints for table `slots`
--
ALTER TABLE `slots`
  ADD CONSTRAINT `slots_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
