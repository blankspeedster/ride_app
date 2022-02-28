-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2022 at 01:10 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenhouse_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `position` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `light_on` int(1) NOT NULL,
  `fan_on` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `code`, `position`, `description`, `light_on`, `fan_on`) VALUES
(1, 'TomatoDevice', 'Tomato Pot', 'Tomato Pot Here', 0, 0),
(7, 'Sample Device Code', 'Sample Position', 'Sample Description', 0, 0),
(8, 'Rosemary', 'Rosemary pot', 'Sample rosemary', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `temperature` int(12) DEFAULT NULL,
  `moisture` int(12) DEFAULT NULL,
  `humidity` int(12) DEFAULT NULL,
  `time_log` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `device_id`, `temperature`, `moisture`, `humidity`, `time_log`) VALUES
(8, 1, 100, 1, 50, '2021-12-09 22:03:23'),
(9, 1, 90, 1, 50, '2021-12-09 22:03:35'),
(10, 1, 80, 0, 50, '2021-12-09 22:03:39'),
(11, 1, 0, 0, 89, '2021-12-09 22:03:44'),
(12, 1, 100, 1, 90, '2021-12-09 22:03:48'),
(13, 1, 1, 1, 1, '2022-01-06 23:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `presets`
--

CREATE TABLE `presets` (
  `id` int(12) NOT NULL,
  `name` varchar(128) NOT NULL,
  `from_soil_acidity` varchar(32) DEFAULT NULL,
  `to_soil_acidity` varchar(32) DEFAULT NULL,
  `from_temperature` varchar(32) DEFAULT NULL,
  `to_temperature` varchar(32) DEFAULT NULL,
  `moisture` int(1) NOT NULL DEFAULT 1,
  `from_light` varchar(32) DEFAULT NULL,
  `to_light` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `presets`
--

INSERT INTO `presets` (`id`, `name`, `from_soil_acidity`, `to_soil_acidity`, `from_temperature`, `to_temperature`, `moisture`, `from_light`, `to_light`) VALUES
(2, 'Tomato', '6.2', '6.8', '18.3', '23.8', 1, '6', '8'),
(3, 'Chamomile', '5.6', '7.5', '15', '20', 0, '6', '8'),
(4, 'Carolina Reaper', '6', '6.5', '15', '25', 1, '6', '8'),
(5, 'Strawberry', '5.5', '6.2', '10', '26.6', 1, '6', '8'),
(6, 'Ghost Pepper', '6', '6.8', '15.6', '2', 1, '6', '8'),
(7, 'Saffron', '6', '8', '19', '30', 1, '6', '8'),
(8, 'Lavender', '6.8', '7.5', '20', '30', 1, '6', '8'),
(9, 'Aloe Vera', '5.6', '6.5', '13', '27', 1, '6', '8'),
(10, 'Basil', '6', '7.5', '10', '26.7', 1, '6', '8'),
(11, 'Rosemary', '6', '7', '12.8', '26.7', 0, '6', '6');

-- --------------------------------------------------------

--
-- Table structure for table `presets_device`
--

CREATE TABLE `presets_device` (
  `id` int(12) NOT NULL,
  `from_soil_acidity` varchar(32) DEFAULT NULL,
  `to_soil_acidity` varchar(32) DEFAULT NULL,
  `from_temperature` varchar(32) DEFAULT NULL,
  `to_temperature` varchar(32) DEFAULT NULL,
  `moisture` int(1) NOT NULL DEFAULT 1,
  `from_light` varchar(32) DEFAULT NULL,
  `to_light` varchar(32) DEFAULT NULL,
  `device_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `presets_device`
--

INSERT INTO `presets_device` (`id`, `from_soil_acidity`, `to_soil_acidity`, `from_temperature`, `to_temperature`, `moisture`, `from_light`, `to_light`, `device_id`) VALUES
(3, '6.2', '6.8999', '18.3', '23.8', 1, '6', '8', 1),
(4, '6.22222', '6.8', '18.3', '23.8', 1, '6', '8', 7),
(5, '6', '11111', '12.8', '26.7', 1, '6', '6', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `presets`
--
ALTER TABLE `presets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presets_device`
--
ALTER TABLE `presets_device`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `presets`
--
ALTER TABLE `presets`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `presets_device`
--
ALTER TABLE `presets_device`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
