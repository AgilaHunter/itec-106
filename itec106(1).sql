-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 05:15 PM
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
(1, 'admin', 'Original', 'Troy Aguiluz', 'Cads', 'Obligar', 'Blk 25 Lot 1 Richwood Townhomes', 'Navarro', 'General Trias', 'Cavite', 4107, 9270673497, 75000.00, 'admin@09', 'admin@09'),
(2, 'staff', 'Overwork', 'John', 'Herman', 'Done', '59 San Antonio Street', 'SFDM', 'Quezon City', 'n/a', 1105, 9338151854, 24000.00, 'staff@09', 'staff@09'),
(3, 'staff', 'Second', 'Joe', 'Neeman', 'Dane', 'Blk 1 Lot 25 Peninsula Homes', 'Navarro', 'General Trias', 'Cavite', 4107, 9352945986, 25500.50, 'staff@2nd', 'staff@2nd'),
(4, 'staff', 'Joban', 'Jovhan', 'n/a', 'Amamangpang', 'Bisaya Street', 'Bisayawa', 'Davao', 'Mindanao', 8000, 9977609412, 100.00, 'bisakol@1', 'bisakol@1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
