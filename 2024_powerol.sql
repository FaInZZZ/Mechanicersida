-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 12:22 PM
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
-- Database: `2024_powerol`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_cars`
--

CREATE TABLE `table_cars` (
  `c_id` int(11) NOT NULL,
  `c_brand` varchar(255) NOT NULL,
  `c_model` varchar(255) NOT NULL,
  `c_license` varchar(255) NOT NULL,
  `c_problem` varchar(512) NOT NULL,
  `c_description` varchar(512) NOT NULL,
  `c_product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_customer`
--

CREATE TABLE `table_customer` (
  `cust_id` int(11) NOT NULL,
  `cust_fname` varchar(255) NOT NULL,
  `cust_lname` varchar(255) NOT NULL,
  `cust_epost` varchar(255) NOT NULL,
  `cust_tel` varchar(255) NOT NULL,
  `cust_adress` varchar(255) NOT NULL,
  `cust_postnummer` varchar(255) NOT NULL,
  `cust_ort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_customer`
--

INSERT INTO `table_customer` (`cust_id`, `cust_fname`, `cust_lname`, `cust_epost`, `cust_tel`, `cust_adress`, `cust_postnummer`, `cust_ort`) VALUES
(1, 'eee', 'regre', 'greg@ef.fi', 'gregr', 'ergr', 'fwef', 'fwefwefe');

-- --------------------------------------------------------

--
-- Table structure for table `table_roles`
--

CREATE TABLE `table_roles` (
  `r_id` int(11) NOT NULL,
  `r_name` int(11) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_users`
--

CREATE TABLE `table_users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(256) NOT NULL,
  `u_password` varchar(256) NOT NULL,
  `u_email` varchar(256) NOT NULL,
  `u_role_fk` int(11) NOT NULL,
  `u_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`, `u_status`) VALUES
(1, 'kevinbrandt', '$2y$10$T6cDcLs3NKqFKWQO9m4ZFujQH9lKAEhefbiRPuEuum1Ojq5i0df.K', 'hejpadig@gmail.com', 1, 1),
(2, 'qarlsson', '$2y$10$VD0STfjYgK6XStBCPuPvPul3NzlIPfnFaR63zjIXjZYBmOCXOkC3y', 'kebab@gmail.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_cars`
--
ALTER TABLE `table_cars`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `table_customer`
--
ALTER TABLE `table_customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `table_roles`
--
ALTER TABLE `table_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_cars`
--
ALTER TABLE `table_cars`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_customer`
--
ALTER TABLE `table_customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
