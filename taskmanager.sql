-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 02:50 PM
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
-- Database: `taskmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `employeeinfo`
--

CREATE TABLE `employeeinfo` (
  `empID` varchar(11) NOT NULL,
  `empName` varchar(100) DEFAULT NULL,
  `empPhone` varchar(15) DEFAULT NULL,
  `empEmail` varchar(100) DEFAULT NULL,
  `empPass` varchar(255) DEFAULT NULL,
  `LeaveStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeeinfo`
--

INSERT INTO `employeeinfo` (`empID`, `empName`, `empPhone`, `empEmail`, `empPass`, `LeaveStatus`) VALUES
('1002', 'Amit Roy', '01766689336', 'f@gmail', '74123', ''),
('1003', 'kanai', '01478523694', 'kanai@gmail.com', '74123', 'Allowed'),
('1007', 'dhanai', '01789633694', 'kanai@gmail.com', '78963', ''),
('1008', 'Mona', '01789675322', 'mona@gmail.com', '456369', 'Allowed'),
('1010', 'panai', '01789637412', 'panai@gmail.com', '852123', ''),
('2001', 'Dhona', '01774562322', 'dhona@gmail.com', '74123', '');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapps`
--

CREATE TABLE `leaveapps` (
  `AppID` int(50) NOT NULL,
  `empID` varchar(50) DEFAULT NULL,
  `empName` varchar(100) NOT NULL,
  `ApplyDate` date DEFAULT NULL,
  `AppTopic` varchar(255) DEFAULT NULL,
  `AppBody` text DEFAULT NULL,
  `Days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `managerinfo`
--

CREATE TABLE `managerinfo` (
  `ManagerID` varchar(11) NOT NULL,
  `ManagerName` varchar(100) DEFAULT NULL,
  `ManagerPhone` varchar(15) DEFAULT NULL,
  `ManagerEmail` varchar(100) DEFAULT NULL,
  `ManagerPass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managerinfo`
--

INSERT INTO `managerinfo` (`ManagerID`, `ManagerName`, `ManagerPhone`, `ManagerEmail`, `ManagerPass`) VALUES
('5002', 'Ganpati', '01745698234', 'b@cvl', '22222'),
('AD 2001', 'Pratap', '01987456321', 'b@gmail.c', 'B@dh@n');

-- --------------------------------------------------------

--
-- Table structure for table `taskinfo`
--

CREATE TABLE `taskinfo` (
  `taskID` varchar(11) NOT NULL,
  `empID` varchar(11) DEFAULT NULL,
  `taskFile` varchar(255) DEFAULT NULL,
  `taskDetails` text DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `SubmitDate` date DEFAULT NULL,
  `CompletedFile` varchar(255) DEFAULT NULL,
  `TaskStatus` varchar(50) DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskinfo`
--

INSERT INTO `taskinfo` (`taskID`, `empID`, `taskFile`, `taskDetails`, `StartDate`, `SubmitDate`, `CompletedFile`, `TaskStatus`) VALUES
('TID 005', '1008', 'dbms lab.jpg', 'Replace the name of the sir with \"Osman Goni\" ', '2024-09-28', '2024-09-29', 'TID 005_1727527236.jpg', 'Completed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employeeinfo`
--
ALTER TABLE `employeeinfo`
  ADD PRIMARY KEY (`empID`);

--
-- Indexes for table `leaveapps`
--
ALTER TABLE `leaveapps`
  ADD PRIMARY KEY (`AppID`);

--
-- Indexes for table `managerinfo`
--
ALTER TABLE `managerinfo`
  ADD PRIMARY KEY (`ManagerID`);

--
-- Indexes for table `taskinfo`
--
ALTER TABLE `taskinfo`
  ADD PRIMARY KEY (`taskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaveapps`
--
ALTER TABLE `leaveapps`
  MODIFY `AppID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
