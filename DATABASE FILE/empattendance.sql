-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 01:49 AM
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
-- Database: `empattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `attedance`
--

CREATE TABLE `attedance` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `morning_time_in` time DEFAULT NULL,
  `morning_time_out` time DEFAULT NULL,
  `login_date` date NOT NULL,
  `afternoon_time_in` time DEFAULT NULL,
  `afternoon_time_out` time DEFAULT NULL,
  `calculate_hours` float(10,0) NOT NULL,
  `travel_date` date DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attedance`
--

INSERT INTO `attedance` (`id`, `fullname`, `morning_time_in`, `morning_time_out`, `login_date`, `afternoon_time_in`, `afternoon_time_out`, `calculate_hours`, `travel_date`, `destination`, `purpose`, `created_at`) VALUES
(23, 'kathy', '13:44:59', NULL, '2024-10-10', NULL, '13:45:19', 0, NULL, NULL, NULL, '2024-10-10 05:45:19'),
(24, 'xie', '14:48:44', '14:48:52', '2024-10-10', '14:48:54', '14:50:08', 0, NULL, NULL, NULL, '2024-10-10 06:50:08'),
(25, 'xie', NULL, NULL, '0000-00-00', NULL, NULL, 0, '2024-10-11', 'City of batac', 'maki birthday nak apay kadi?\r\n', '2024-10-10 06:53:35'),
(26, 'nelia', NULL, NULL, '2024-10-10', '15:15:54', NULL, 0, NULL, NULL, NULL, '2024-10-10 07:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `travel_orders`
--

CREATE TABLE `travel_orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_orders`
--

INSERT INTO `travel_orders` (`id`, `fullname`, `travel_date`, `destination`, `purpose`, `created_at`) VALUES
(1, 'Jao', NULL, NULL, NULL, '2024-10-10 03:08:57'),
(2, 'Jao', '2024-10-10', 'haha', 'haha', '2024-10-10 03:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `position` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `position`, `password`, `confirm_password`) VALUES
(7, 'Jao', 'Cyrelle Jao Tabios', 'Employee', 'b07c153de98af7e6ecda7ebf6d1a5e25', 'b07c153de98af7e6ecda7ebf6d1a5e25'),
(8, 'Kat', 'Katrina', 'Employee', '202cb962ac59075b964b07152d234b70', '202cb962ac59075b964b07152d234b70'),
(9, 'Lhyn', 'Yvette Bagaoisan', 'Employee', 'de0f2adff7ae7d7d48d373b8c4a126d5', 'de0f2adff7ae7d7d48d373b8c4a126d5'),
(10, 'kathy', 'Katrina Mae Lagua', 'Employee', '202cb962ac59075b964b07152d234b70', '202cb962ac59075b964b07152d234b70'),
(11, 'xie', 'Trexie Gaudia', 'Employee', '698d51a19d8a121ce581499d7b701668', '698d51a19d8a121ce581499d7b701668'),
(12, 'nelia', 'Ma. Nelia Fiesta', 'Employee', 'bcbe3365e6ac95ea2c0343a2395834dd', 'bcbe3365e6ac95ea2c0343a2395834dd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `attedance`
--
ALTER TABLE `attedance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_orders`
--
ALTER TABLE `travel_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attedance`
--
ALTER TABLE `attedance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `travel_orders`
--
ALTER TABLE `travel_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
