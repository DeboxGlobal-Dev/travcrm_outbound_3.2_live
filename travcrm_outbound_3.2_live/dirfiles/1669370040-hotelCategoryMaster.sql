-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2022 at 10:14 AM
-- Server version: 5.6.51
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travcrm_dev2_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `hotelCategoryMaster`
--

CREATE TABLE `hotelCategoryMaster` (
  `id` int(11) NOT NULL,
  `hotelCategory` int(11) NOT NULL,
  `uploadKeyword` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `modifyBy` bigint(20) NOT NULL,
  `addedBy` bigint(20) NOT NULL,
  `dateAdded` int(11) NOT NULL,
  `modifyDate` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT '0',
  `name` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hotelCategoryMaster`
--

INSERT INTO `hotelCategoryMaster` (`id`, `hotelCategory`, `uploadKeyword`, `status`, `modifyBy`, `addedBy`, `dateAdded`, `modifyDate`, `deletestatus`, `name`) VALUES
(1, 5, '5Star', 1, 0, 37, 1640339892, 0, 0, 0),
(2, 4, '4Star', 1, 0, 37, 1640339901, 0, 0, 0),
(3, 3, '3Star', 1, 154, 37, 1640339914, 1663828963, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hotelCategoryMaster`
--
ALTER TABLE `hotelCategoryMaster`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotelCategory` (`hotelCategory`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hotelCategoryMaster`
--
ALTER TABLE `hotelCategoryMaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
