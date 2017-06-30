-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2017 at 03:27 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `print`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `idnum` varchar(7) NOT NULL,
  `name` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `tokens` int(11) NOT NULL,
  `type` enum('undergraduate','graduate','others') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`idnum`, `name`, `uid`, `tokens`, `type`) VALUES
('0123456', 'sample student', 3, 450, 'undergraduate'),
('0123457', 'student sample', 4, 750, 'graduate'),
('0123458', 'sample1, sample1', 25, 500, 'undergraduate');

-- --------------------------------------------------------

--
-- Table structure for table `closed_request`
--

CREATE TABLE `closed_request` (
  `request_no` int(11) NOT NULL,
  `date` date NOT NULL,
  `idnum` varchar(7) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `status` enum('printed','declined') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `closed_request`
--

INSERT INTO `closed_request` (`request_no`, `date`, `idnum`, `filename`, `status`) VALUES
(7, '2017-06-29', '0123456', 'Payroll-SIA.doc', 'printed'),
(8, '2017-06-29', '0123456', 'Payroll-SIA.doc', 'printed'),
(10, '2017-06-29', '0123458', 'Payroll-SIA.doc', 'declined'),
(11, '2017-06-29', '0123457', 'GrpActdetails.docx', 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `prnt_request`
--

CREATE TABLE `prnt_request` (
  `request_no` int(11) NOT NULL,
  `date` date NOT NULL,
  `idnum` varchar(7) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filetype` varchar(150) NOT NULL,
  `filesize` int(11) NOT NULL,
  `content` mediumblob NOT NULL,
  `status` enum('pending','assessed','printed','declined','failed') NOT NULL,
  `pending_deduction` int(11) DEFAULT NULL,
  `laboratory` enum('S326','S422') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_num` int(11) NOT NULL,
  `date` date NOT NULL,
  `details` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_num`, `date`, `details`) VALUES
(1, '2017-06-30', 'tokens were reset'),
(2, '2017-06-30', 'tokens were reset for user 0123456'),
(3, '2017-06-30', 'user account admin password was changed'),
(4, '2017-06-30', 'user account admin password was changed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `auth` enum('admin','printing staff','client') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `auth`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'staff', '1253208465b1efa876f982d8a9e73eef', 'printing staff'),
(3, '0123456', '124bd1296bec0d9d93c7b52a71ad8d5b', 'client'),
(4, '0123457', 'ac19e4c062b3c5c72a38d2972fba7005', 'client'),
(25, '0123458', '7b5b772c01e23fa3293512759f5f1f94', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idnum`),
  ADD KEY `uid_fk` (`uid`);

--
-- Indexes for table `closed_request`
--
ALTER TABLE `closed_request`
  ADD PRIMARY KEY (`request_no`);

--
-- Indexes for table `prnt_request`
--
ALTER TABLE `prnt_request`
  ADD PRIMARY KEY (`request_no`),
  ADD KEY `idum fk` (`idnum`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prnt_request`
--
ALTER TABLE `prnt_request`
  MODIFY `request_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON UPDATE CASCADE;

--
-- Constraints for table `prnt_request`
--
ALTER TABLE `prnt_request`
  ADD CONSTRAINT `idum fk` FOREIGN KEY (`idnum`) REFERENCES `clients` (`idnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
