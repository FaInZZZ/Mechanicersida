-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 11:34 AM
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
(3, 'dwada', 'dada', 'dada', 'dada@dawd', 'dadad', 'adad', 'adad'),
(4, 'harald', 'Aladin', 'fel siffror i banken', 'Bortstaintetander@gmail.com', 'grotta', 'vet it', 'leksvall gangg'),
(5, 'bra', 'Bränä', '0449574723', 'kevinsepost@gmail.com', 'hemma', '10640', 'sverige'),
(6, 'owad', 'hej', '3', '2@wdwada', '21', '21', '211'),
(7, 'dawd', 'dwad', 'wad', 'wad@awd.com', 'awd', 'dawd', 'adwd'),
(8, 'dwdawd', 'dawdaw', 'dawdawd', 'dawdaw@fe.fiaw', 'dawd', 'dwadw', 'awddawd');

-- --------------------------------------------------------

--
-- Table structure for table `table_parts`
--

CREATE TABLE `table_parts` (
  `id_produkt` int(11) NOT NULL,
  `produkt_namn` varchar(255) NOT NULL,
  `produkt_pris` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_produkter_i_projekt`
--

CREATE TABLE `table_produkter_i_projekt` (
  `projekt_id_fk` int(11) NOT NULL,
  `produkt_id_fk` int(11) NOT NULL
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
  `customer_fk` int(11) NOT NULL,
  `created_by_user_fk` int(11) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_reg` varchar(255) NOT NULL,
  `fk_produkter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_projekt`
--

INSERT INTO `table_projekt` (`id_projekt`, `pt_felbeskrivning`, `pt_arbetsbeskrivning`, `pt_status_fk`, `customer_fk`, `created_by_user_fk`, `car_brand`, `car_model`, `car_reg`, `fk_produkter`) VALUES
(22, 'dwdawd', 'dawdawdwa', 2, 3, 0, 'bil', 'skibidi', '234234324ergreg', NULL),
(23, 'dwdawd', 'dawdawd', 2, 3, 0, 'bil', 'skibidi', '234234324ergreg', NULL),
(24, 'dwdawd', 'dawdawd', 3, 3, 0, 'bil', 'skibidi', '234234324ergreg', NULL),
(25, 'felidi', 'abidi', 4, 3, 0, 'bilidi', 'skibidi', 'ragedi', NULL),
(26, 'fel i hov', 'fis', 2, 4, 0, 'ho', 'liin', 'lindström22', NULL),
(27, 'aburdaburda', 'fix felen ', 1, 4, 0, 'volvo', 'v90', 'NFS-287', NULL);

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
(4, 'Chefen', 300);

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
(3, 'fakturerbar'),
(4, 'fakturerad');

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

--
-- Dumping data for table `table_timmar`
--

INSERT INTO `table_timmar` (`id_timmar`, `date`, `hours`, `user_fk`, `project_fk`) VALUES
(2, '2024-10-09', 2, NULL, 0),
(3, '2024-10-19', 23, NULL, 0),
(4, '2024-10-05', 23232, NULL, 0),
(5, '2024-10-12', 23, NULL, 0),
(6, '2024-10-10', 22, NULL, 0),
(7, '2024-10-29', 333, NULL, 0),
(8, '2024-10-30', 22, NULL, 0),
(9, '2024-10-29', 999, NULL, 27);

-- --------------------------------------------------------

--
-- Table structure for table `table_users`
--

CREATE TABLE `table_users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_role_fk` int(11) NOT NULL,
  `u_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`, `u_status`) VALUES
(22, 'nigga', '$2y$10$Sbhaj5s5.ryrmgiwI2a3VO8UV4oSCyCnISXOAuiR1qauwWN1yPQg6', 'nigga@gmail.com', 1, 1),
(23, 'qarlsson', '$2y$10$Q9Lte2LOBuDPXhB71ZTKy.WcptqfPu89TqfPP2CBTh5eOq5XqkFzu', 'lompa@gmail.com', 1, 1),
(24, 'kevin', '$2y$10$BPRZGEyuU45WJwCKcvOkHuAzgtpYf2xmjMO6wlVKjeOU7Ufl0./oK', 'kepep@gmail.com', 900, 1);

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
  ADD PRIMARY KEY (`id_produkt`);

--
-- Indexes for table `table_produkter_i_projekt`
--
ALTER TABLE `table_produkter_i_projekt`
  ADD PRIMARY KEY (`projekt_id_fk`),
  ADD KEY `produkt_id_fk` (`produkt_id_fk`);

--
-- Indexes for table `table_projekt`
--
ALTER TABLE `table_projekt`
  ADD PRIMARY KEY (`id_projekt`),
  ADD KEY `pt_status_fk` (`pt_status_fk`,`customer_fk`,`created_by_user_fk`),
  ADD KEY `fk3` (`created_by_user_fk`),
  ADD KEY `fk5` (`customer_fk`),
  ADD KEY `car_brand` (`car_brand`,`car_model`,`car_reg`),
  ADD KEY `fk_produkter` (`fk_produkter`);

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
  ADD KEY `link23` (`user_fk`);

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
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `table_parts`
--
ALTER TABLE `table_parts`
  MODIFY `id_produkt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_produkter_i_projekt`
--
ALTER TABLE `table_produkter_i_projekt`
  MODIFY `projekt_id_fk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_projekt`
--
ALTER TABLE `table_projekt`
  MODIFY `id_projekt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_timmar`
--
ALTER TABLE `table_timmar`
  MODIFY `id_timmar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_produkter_i_projekt`
--
ALTER TABLE `table_produkter_i_projekt`
  ADD CONSTRAINT `fk133` FOREIGN KEY (`projekt_id_fk`) REFERENCES `table_parts` (`id_produkt`),
  ADD CONSTRAINT `fk4849453` FOREIGN KEY (`projekt_id_fk`) REFERENCES `table_timmar` (`id_timmar`);

--
-- Constraints for table `table_projekt`
--
ALTER TABLE `table_projekt`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`pt_status_fk`) REFERENCES `table_status` (`id_status`),
  ADD CONSTRAINT `fk2` FOREIGN KEY (`fk_produkter`) REFERENCES `table_produkter_i_projekt` (`projekt_id_fk`),
  ADD CONSTRAINT `fk5` FOREIGN KEY (`customer_fk`) REFERENCES `table_customer` (`id_cust`);

--
-- Constraints for table `table_timmar`
--
ALTER TABLE `table_timmar`
  ADD CONSTRAINT `link23` FOREIGN KEY (`user_fk`) REFERENCES `table_users` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
