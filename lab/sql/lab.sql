-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2022 at 10:32 PM
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
-- Database: `lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `research_children`
--

CREATE TABLE `research_children` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `research_parent_id` int(11) NOT NULL,
  `result` decimal(10,0) NOT NULL,
  `units` varchar(10) NOT NULL,
  `reference_value` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_children`
--

INSERT INTO `research_children` (`id`, `name`, `research_parent_id`, `result`, `units`, `reference_value`) VALUES
(2, 'hemoglobin', 1, '135', 'Ml/u', '150');

-- --------------------------------------------------------

--
-- Table structure for table `research_parents`
--

CREATE TABLE `research_parents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_parents`
--

INSERT INTO `research_parents` (`id`, `name`, `date`, `patient_id`) VALUES
(1, 'Helicobacter Pilory', '2022-01-19', 16),
(2, 'Full blood culture', '2022-01-29', 16);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service`, `price`, `category`) VALUES
(16, 'Complete blood count +5 DIF.DCC', '8', 'hematology'),
(17, 'Reticulocytes', '4', 'hematology'),
(18, 'SUE', '2', 'hematology'),
(19, 'Leukocytes', '3', 'hematology'),
(20, 'Hemoglobin', '7', 'hematology'),
(21, 'PV and INR', '5', 'coagulation'),
(22, 'Fibrinogen', '4', 'coagulation'),
(23, 'aRTT', '5', 'coagulation'),
(24, 'D-Dimer', '25', 'coagulation'),
(25, 'Bleeding time', '2', 'coagulation'),
(26, 'Clotting time', '2', 'coagulation'),
(31, 'Complete blood count', '6', 'hematology');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contract_type` varchar(100) DEFAULT NULL,
  `hiring_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `surname`, `username`, `gender`, `role`, `password`, `contract_type`, `hiring_date`) VALUES
(13, 'Roberta', 'Netzova', 'rety', 'Female', 'patient', '159', NULL, NULL),
(14, NULL, '', 'admin', '', 'admin', 'admin', NULL, NULL),
(15, 'Mishi', 'Mircheva', 'peterhack', 'Female', 'employee', 'peterhack', 'Employment contract', '2022-01-26'),
(16, 'pencho', 'penchov', 'nikola', 'Male', 'patient', 'petpesho', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `research_children`
--
ALTER TABLE `research_children`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `research_parents`
--
ALTER TABLE `research_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `research_children`
--
ALTER TABLE `research_children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `research_parents`
--
ALTER TABLE `research_parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
