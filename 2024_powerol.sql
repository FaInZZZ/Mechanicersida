-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 05:11 PM
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
-- Table structure for table `table_customer`
--

CREATE TABLE `table_customer` (
  `id_cust` int(11) NOT NULL,
  `cust_fname` varchar(255) NOT NULL,
  `cust_lname` varchar(255) NOT NULL,
  `cust_tel` varchar(255) NOT NULL,
  `cust_epost` varchar(255) NOT NULL,
  `cust_adress` varchar(255) NOT NULL,
  `cust_postnummer` varchar(255) NOT NULL,
  `cust_ort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_customer`
--

INSERT INTO `table_customer` (`id_cust`, `cust_fname`, `cust_lname`, `cust_tel`, `cust_epost`, `cust_adress`, `cust_postnummer`, `cust_ort`) VALUES
(11, 'dw', 'dawda', 'dwadad', 'da@gmail.com', 'dad', 'awda', 'ad');

-- --------------------------------------------------------

--
-- Table structure for table `table_parts`
--

CREATE TABLE `table_parts` (
  `id_produkt` int(11) NOT NULL,
  `produkt_namn` varchar(255) NOT NULL,
  `produkt_pris` decimal(7,2) NOT NULL,
  `project_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_projekt`
--

CREATE TABLE `table_projekt` (
  `id_projekt` int(11) NOT NULL,
  `pt_felbeskrivning` varchar(520) NOT NULL,
  `pt_arbetsbeskrivning` varchar(520) NOT NULL,
  `pt_status_fk` int(11) NOT NULL,
  `customer_fk` int(11) DEFAULT NULL,
  `created_by_user_fk` int(11) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_reg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_roles`
--

CREATE TABLE `table_roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_roles`
--

INSERT INTO `table_roles` (`r_id`, `r_name`, `r_level`) VALUES
(1, 'Mechanicer', 10),
(2, 'Fakturerare', 50),
(3, 'Administrator', 500),
(4, 'Chefen', 300),
(402, 'Disable', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE `table_status` (
  `id_status` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_status`
--

INSERT INTO `table_status` (`id_status`, `status_name`) VALUES
(1, 'active'),
(2, 'inactive'),
(3, 'Billable'),
(4, 'Invoiced');

-- --------------------------------------------------------

--
-- Table structure for table `table_timmar`
--

CREATE TABLE `table_timmar` (
  `id_timmar` int(11) NOT NULL,
  `date` date NOT NULL,
  `hours` decimal(10,0) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `project_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_users`
--

CREATE TABLE `table_users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_role_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`) VALUES
(32, 'kevin', '$2y$10$6foMXwAZtuUWKevg8bH26ODQRZLNj7eQbuA9wikTWDt7sRW8t.3xy', 'apa233@gmail.com', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_customer`
--
ALTER TABLE `table_customer`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `table_parts`
--
ALTER TABLE `table_parts`
  ADD PRIMARY KEY (`id_produkt`),
  ADD KEY `fk32` (`project_fk`);

--
-- Indexes for table `table_projekt`
--
ALTER TABLE `table_projekt`
  ADD PRIMARY KEY (`id_projekt`),
  ADD KEY `pt_status_fk` (`pt_status_fk`,`customer_fk`,`created_by_user_fk`),
  ADD KEY `fk3` (`created_by_user_fk`),
  ADD KEY `fk5` (`customer_fk`),
  ADD KEY `car_brand` (`car_brand`,`car_model`,`car_reg`);

--
-- Indexes for table `table_roles`
--
ALTER TABLE `table_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `table_timmar`
--
ALTER TABLE `table_timmar`
  ADD PRIMARY KEY (`id_timmar`),
  ADD KEY `link23` (`user_fk`),
  ADD KEY `link666` (`project_fk`);

--
-- Indexes for table `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `u_role_fk` (`u_role_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_customer`
--
ALTER TABLE `table_customer`
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `table_parts`
--
ALTER TABLE `table_parts`
  MODIFY `id_produkt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `table_projekt`
--
ALTER TABLE `table_projekt`
  MODIFY `id_projekt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_timmar`
--
ALTER TABLE `table_timmar`
  MODIFY `id_timmar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_parts`
--
ALTER TABLE `table_parts`
  ADD CONSTRAINT `lnik432` FOREIGN KEY (`project_fk`) REFERENCES `table_projekt` (`id_projekt`);

--
-- Constraints for table `table_projekt`
--
ALTER TABLE `table_projekt`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`pt_status_fk`) REFERENCES `table_status` (`id_status`),
  ADD CONSTRAINT `fk3` FOREIGN KEY (`customer_fk`) REFERENCES `table_customer` (`id_cust`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk8855` FOREIGN KEY (`created_by_user_fk`) REFERENCES `table_users` (`u_id`);

--
-- Constraints for table `table_timmar`
--
ALTER TABLE `table_timmar`
  ADD CONSTRAINT `link23` FOREIGN KEY (`user_fk`) REFERENCES `table_users` (`u_id`),
  ADD CONSTRAINT `link666` FOREIGN KEY (`project_fk`) REFERENCES `table_projekt` (`id_projekt`);

--
-- Constraints for table `table_users`
--
ALTER TABLE `table_users`
  ADD CONSTRAINT `fk920` FOREIGN KEY (`u_role_fk`) REFERENCES `table_roles` (`r_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
