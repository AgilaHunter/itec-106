-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 04:06 PM
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
-- Database: `itec106`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(50) NOT NULL,
  `c_fname` varchar(255) NOT NULL,
  `c_mname` varchar(255) NOT NULL,
  `c_lname` varchar(255) NOT NULL,
  `c_street` varchar(255) NOT NULL,
  `c_barangay` varchar(255) NOT NULL,
  `c_city` varchar(255) NOT NULL,
  `c_province` varchar(255) NOT NULL,
  `c_postal` int(10) NOT NULL,
  `c_contact` bigint(20) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_fname`, `c_mname`, `c_lname`, `c_street`, `c_barangay`, `c_city`, `c_province`, `c_postal`, `c_contact`, `date_created`) VALUES
(1, 'Liane', 'Adrielle', 'Amano', 'Carriedo', 'Pole', 'Imus', 'Cavite', 4107, 9458870432, '2025-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `position`) VALUES
('admin', 'admin12345!@#$%', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(50) NOT NULL,
  `position` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postal` int(10) NOT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `salary` decimal(65,2) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `position`, `username`, `fname`, `mname`, `lname`, `street`, `barangay`, `city`, `province`, `postal`, `contact`, `salary`, `password`, `confirm`) VALUES
(1, 'staff', 'sam06', 'Samantha Arabella', 'Redilla', 'Regencia', 'Jordan ', 'Bacao 1', 'General Trias', 'Cavite', 4107, 9198675122, 50000.00, 'Sam19.', 'Sam19.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
