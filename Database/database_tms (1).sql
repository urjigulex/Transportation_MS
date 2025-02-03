-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 04:27 PM
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
-- Database: `database_tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tms_admin`
--

CREATE TABLE `tms_admin` (
  `a_id` int(20) NOT NULL,
  `a_name` varchar(200) NOT NULL,
  `a_email` varchar(200) NOT NULL,
  `a_pwd` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_admin`
--

INSERT INTO `tms_admin` (`a_id`, `a_name`, `a_email`, `a_pwd`) VALUES
(1, 'Admin', 'thestargulex@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tms_feedback`
--

CREATE TABLE `tms_feedback` (
  `f_id` int(20) NOT NULL,
  `f_uname` varchar(200) NOT NULL,
  `f_content` longtext NOT NULL,
  `f_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tms_pwd_resets`
--

CREATE TABLE `tms_pwd_resets` (
  `r_id` int(20) NOT NULL,
  `r_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_pwd_resets`
--

INSERT INTO `tms_pwd_resets` (`r_id`, `r_email`) VALUES
(2, 'sysadmin@tms.com');

-- --------------------------------------------------------

--
-- Table structure for table `tms_route`
--

CREATE TABLE `tms_route` (
  `route_id` int(11) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `start_point` varchar(100) NOT NULL,
  `end_point` varchar(100) NOT NULL,
  `distance` float NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_route`
--

INSERT INTO `tms_route` (`route_id`, `route_name`, `start_point`, `end_point`, `distance`, `status`) VALUES
(1, 'Route 1', 'Addis Ababa', 'Hawassa', 275.5, 'Active'),
(2, 'Route 2', 'Hawassa', 'Shashamane', 50, 'Active'),
(3, 'Route 3', 'Bahir Dar', 'Gondar', 185.3, 'Active'),
(4, 'Route 4', 'Mekelle', 'Adigrat', 116.4, 'Active'),
(5, 'Route 5', 'Jimma', 'Bedele', 75.2, 'Inactive'),
(6, 'Route 6', 'Haramaya', 'Finfinne', 522, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tms_shipment`
--

CREATE TABLE `tms_shipment` (
  `shipment_id` int(11) NOT NULL,
  `shipment_name` varchar(255) NOT NULL,
  `shipment_description` text NOT NULL,
  `shipment_weight` decimal(10,2) NOT NULL,
  `shipment_origin` varchar(255) NOT NULL,
  `shipment_destination` varchar(255) NOT NULL,
  `status` enum('In Transit','Delivered','Pending','Cancelled') DEFAULT 'Pending',
  `tracking_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_shipment`
--

INSERT INTO `tms_shipment` (`shipment_id`, `shipment_name`, `shipment_description`, `shipment_weight`, `shipment_origin`, `shipment_destination`, `status`, `tracking_number`, `created_at`) VALUES
(1, 'Electronics Shipment', 'Shipment of electronic devices including phones and laptops', 10.50, 'New Delhi ', 'Los Angeles', 'In Transit', NULL, '2025-01-05 06:24:40'),
(2, 'Furniture Shipment', 'Contains various furniture items for a new office setup', 50.20, 'Chicago', 'Houston', 'Pending', NULL, '2025-01-05 06:24:40'),
(3, 'Clothing Shipment', 'Shipment of seasonal clothing including jackets and sweaters', 25.40, 'San Francisco', 'Miami', 'Delivered', NULL, '2025-01-05 06:24:40'),
(6, 'Urjiiaaa', 'aas', 1212.00, '13121', 'fiaaaa', 'In Transit', NULL, '2025-01-05 06:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `tms_syslogs`
--

CREATE TABLE `tms_syslogs` (
  `l_id` int(20) NOT NULL,
  `u_id` varchar(200) NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `u_ip` varbinary(200) NOT NULL,
  `u_city` varchar(200) NOT NULL,
  `u_country` varchar(200) NOT NULL,
  `u_logintime` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tms_user`
--

CREATE TABLE `tms_user` (
  `u_id` int(20) NOT NULL,
  `u_fname` varchar(200) NOT NULL,
  `u_lname` varchar(200) NOT NULL,
  `u_phone` varchar(200) NOT NULL,
  `u_addr` varchar(200) NOT NULL,
  `u_category` varchar(200) NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `u_pwd` varchar(20) NOT NULL,
  `u_car_type` varchar(200) NOT NULL,
  `u_car_regno` varchar(200) NOT NULL,
  `u_car_bookdate` varchar(200) NOT NULL,
  `u_car_book_status` varchar(200) NOT NULL,
  `u_car_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_user`
--

INSERT INTO `tms_user` (`u_id`, `u_fname`, `u_lname`, `u_phone`, `u_addr`, `u_category`, `u_email`, `u_pwd`, `u_car_type`, `u_car_regno`, `u_car_bookdate`, `u_car_book_status`, `u_car_price`) VALUES
(6, 'fayisa', 'kabbede', '0900123456', 'Oromia, Ethiopia', 'User', 'thestargulex@gmail.com', '1234', 'Bus', 'Oro 2312', '', 'Approved', 0.00),
(9, 'Urji', 'Guluma', '0910273351', 'Haramaya', 'User', 'thestargulex@gmail.com', 'admin', 'Oda Bus', 'Oro 2312', '2025-02-17', 'Pending', 234.00),
(10, 'Urji', 'Guluma', '0910273351', 'Haramaya', 'Driver', 'thestargulex@gmail.com', 'admin', '', '', '', '', 0.00),
(11, 'fayisa', 'kabbe', '0971253366', 'Finfinnee', 'Driver', 'fayisa@gmail.com', '1234', '', '', '', '', 0.00),
(13, 'fayisa', 'kabbe', '0900414247', 'Haramaya', 'User', 'fayisa@gmail.com', '1234', 'Bus', 'Oro 2312', '', 'Approved', 0.00),
(14, 'Abraham', 'Alemu', '0930703133', 'Adama', 'User', 'abraham@gmail.com', '1234', '', '', '', '', 0.00),
(16, 'Alemu', 'Dotora', '0930703133', 'Adama', 'User', 'alemu@gmail.com', '1234', 'Bus', 'Oro 2312', '', 'Approved', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tms_vehicle`
--

CREATE TABLE `tms_vehicle` (
  `v_id` int(20) NOT NULL,
  `v_name` varchar(200) NOT NULL,
  `v_reg_no` varchar(200) NOT NULL,
  `v_pass_no` varchar(200) NOT NULL,
  `v_driver` varchar(200) NOT NULL,
  `v_category` varchar(200) NOT NULL,
  `v_dpic` varchar(200) NOT NULL,
  `v_status` varchar(200) NOT NULL,
  `v_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_vehicle`
--

INSERT INTO `tms_vehicle` (`v_id`, `v_name`, `v_reg_no`, `v_pass_no`, `v_driver`, `v_category`, `v_dpic`, `v_status`, `v_price`) VALUES
(9, 'Oda Bus', 'Oro 2312', '50', 'Yaduma Lechisa', 'Oda Bus', '', 'Available', '234'),
(10, 'Star Bus', 'AA 1223', '75', 'Urji Guluma', 'Oda Bus', '', 'Booked', '2333'),
(12, 'Abba Dula', 'DD 1212', '70', 'chemeda Tolcha', 'Oda Bus', '', 'Booked', '34334'),
(13, 'Zemen Bus', 'FF122', '60', 'fayisa kabbe', 'Zemen Bus', '', 'Available', ''),
(14, 'V8', 'OR 2322', '10', 'Urji Guluma', 'Oda Bus', 'Screenshot 2025-01-27 120713.png', 'Booked', '2344');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `log_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_ip` varchar(45) NOT NULL,
  `u_city` varchar(255) DEFAULT 'Unknown',
  `u_country` varchar(255) DEFAULT 'Unknown',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`log_id`, `u_id`, `u_email`, `u_ip`, `u_city`, `u_country`, `log_time`) VALUES
(6, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-05 08:54:51'),
(7, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-08 06:28:05'),
(8, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-13 14:00:48'),
(9, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-13 21:11:43'),
(10, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-13 21:27:04'),
(11, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-13 22:02:27'),
(12, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-13 22:15:32'),
(13, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 10:18:13'),
(14, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 10:55:35'),
(15, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 10:59:40'),
(16, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 11:06:16'),
(17, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 11:08:43'),
(18, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-14 11:12:22'),
(19, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-16 11:19:52'),
(20, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-16 20:03:12'),
(21, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-16 20:06:33'),
(22, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-16 20:22:18'),
(23, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-20 17:10:26'),
(24, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-20 17:18:13'),
(25, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-21 19:13:16'),
(26, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-28 12:43:42'),
(27, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-28 17:53:04'),
(28, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-01-28 17:53:37'),
(29, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 07:04:38'),
(30, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 12:15:11'),
(31, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 12:47:15'),
(32, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:01:08'),
(33, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:02:32'),
(34, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:26:41'),
(35, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:32:07'),
(36, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:54:21'),
(37, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 13:58:45'),
(38, 9, 'thestargulex@gmail.com', '::1', 'Unknown', 'Unknown', '2025-02-02 14:39:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tms_admin`
--
ALTER TABLE `tms_admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tms_pwd_resets`
--
ALTER TABLE `tms_pwd_resets`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `tms_route`
--
ALTER TABLE `tms_route`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `tms_shipment`
--
ALTER TABLE `tms_shipment`
  ADD PRIMARY KEY (`shipment_id`);

--
-- Indexes for table `tms_syslogs`
--
ALTER TABLE `tms_syslogs`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `tms_user`
--
ALTER TABLE `tms_user`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  ADD PRIMARY KEY (`v_id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tms_admin`
--
ALTER TABLE `tms_admin`
  MODIFY `a_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  MODIFY `f_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tms_pwd_resets`
--
ALTER TABLE `tms_pwd_resets`
  MODIFY `r_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tms_route`
--
ALTER TABLE `tms_route`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tms_shipment`
--
ALTER TABLE `tms_shipment`
  MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tms_syslogs`
--
ALTER TABLE `tms_syslogs`
  MODIFY `l_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tms_user`
--
ALTER TABLE `tms_user`
  MODIFY `u_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  MODIFY `v_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
