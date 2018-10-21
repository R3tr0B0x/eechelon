-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 23, 2017 at 04:03 PM
-- Server version: 10.1.24-MariaDB-cll-lve
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myteghiy_eechelon`
--

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `symbol` varchar(1) NOT NULL,
  `represents` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chart`
--

INSERT INTO `chart` (`symbol`, `represents`) VALUES
('', ''),
('b', 'cancelled by poster before someone accepts'),
('', ''),
('a', 'open/just posted'),
('c', 'accepted by deliverer'),
('d', 'timeout after accepting'),
('e', 'item purchased/picked up'),
('f', 'timeout after pickup/purchase'),
('g', 'complete'),
('i', 'd claimed'),
('j', 'f claimed');

-- --------------------------------------------------------

--
-- Table structure for table `device_info`
--

CREATE TABLE `device_info` (
  `deviceID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `type` varchar(1) NOT NULL,
  `imei` varchar(30) NOT NULL,
  `serial` varchar(30) NOT NULL,
  `mac` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_list`
--

CREATE TABLE `job_list` (
  `jobID` int(11) NOT NULL,
  `postedBy` int(11) NOT NULL,
  `job_title` varchar(60) NOT NULL,
  `details` varchar(500) NOT NULL,
  `timeLimit` int(11) NOT NULL,
  `start_coord` varchar(50) DEFAULT NULL,
  `end_coord` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL,
  `pickupCode` varchar(19) NOT NULL,
  `completionCode` varchar(20) NOT NULL,
  `packageWorth` float NOT NULL,
  `deliveryFee` float NOT NULL,
  `dipaCoin` float DEFAULT NULL,
  `startTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endTime` timestamp NULL DEFAULT NULL,
  `acceptedBy` int(11) DEFAULT NULL,
  `jobAcceptTimestamp` timestamp NULL DEFAULT NULL,
  `pickupPackageTimestamp` timestamp NULL DEFAULT NULL,
  `lastPos` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_list`
--

INSERT INTO `job_list` (`jobID`, `postedBy`, `job_title`, `details`, `timeLimit`, `start_coord`, `end_coord`, `status`, `pickupCode`, `completionCode`, `packageWorth`, `deliveryFee`, `dipaCoin`, `startTime`, `endTime`, `acceptedBy`, `jobAcceptTimestamp`, `pickupPackageTimestamp`, `lastPos`) VALUES
(15, 8, 'Hhhjj', 'Ckdqkdk', 100, '(23.823863198375868, 90.36791324615479)', '(23.827867513050602, 90.3642225265503)', 'c', '15hHhWDEPE', '15nkJsXVufp', 1000, 100, NULL, '2017-12-12 10:43:32', NULL, 9, '2017-12-18 21:12:12', NULL, ''),
(16, 9, 'walao', 'abcd', 11, NULL, '(23.80827660118945, 90.41130065917969)', 'c', '168Li3IFaB', '16O61hkpPzL', 20, 20, NULL, '2017-12-18 18:55:30', NULL, 9, '2017-12-18 21:10:22', NULL, ''),
(17, 9, 'ddddddd', 'asdd', 111, NULL, '(23.81879874108438, 90.41662216186523)', 'c', '17yRxeGCOT', '17J533kzO4m', 111, 111, NULL, '2017-12-18 21:19:15', NULL, 9, '2017-12-18 23:44:37', NULL, ''),
(18, 9, 'asd', 'asd', 11, NULL, '(23.818366878992364, 90.42550563812256)', 'c', '18zat1Kag6', '18bpZTPD5JD', 11, 22, NULL, '2017-12-18 21:48:23', NULL, 9, '2017-12-18 23:44:18', NULL, ''),
(19, 9, 'aaa', 'sd', 11, NULL, '(23.815854198320075, 90.43297290802002)', 'c', '19ZZiPPtZf', '19nEIKxoyfM', 111, 12, NULL, '2017-12-18 21:49:44', NULL, 9, '2017-12-18 23:43:46', NULL, ''),
(20, 9, 'asd', 'asd', 11, NULL, '(23.81608976419933, 90.43001174926758)', 'c', '20ilrDJnSs', '20ustiyqJ8e', 12, 12, NULL, '2017-12-18 21:52:11', NULL, 9, '2017-12-18 23:43:39', NULL, ''),
(21, 9, 'asdasd', 'asdad', 11, NULL, '', 'c', '21bvFMXXmh', '21ml8Rg5Stp', 11, 11, NULL, '2017-12-18 22:32:19', NULL, 9, '2017-12-18 23:21:12', NULL, ''),
(22, 9, 'ddddddd', 'asd', 111, NULL, '', 'c', '22rMyBwKcH', '22keFR4KCpO', 111, 111, NULL, '2017-12-18 22:33:10', NULL, 9, '2017-12-18 23:20:22', NULL, ''),
(23, 9, 'asdasd', 'asd', 11, NULL, '(23.81467636251163, 90.43357372283936)', 'c', '23fSuxLgfV', '23xUlyTWGZA', 11, 11, NULL, '2017-12-18 22:40:30', NULL, 9, '2017-12-18 22:59:35', NULL, ''),
(24, 9, 'PandD', 'PandD', 300, NULL, '', 'g', '24FpI68S1n', '24BJF7Ql7oA', 300, 300, NULL, '2017-12-19 05:11:20', '2017-12-19 05:37:50', 9, '2017-12-19 05:12:14', '2017-12-19 05:32:59', ''),
(25, 9, 'Pickup', 'Pickup', 222, '(23.815540109816084, 90.43108463287354)', '(23.81451931692972, 90.41687965393066)', 'e', '25PfGt5ame', '25EzvUBx4TQ', 22, 22, NULL, '2017-12-19 05:43:21', NULL, 9, '2017-12-19 05:43:58', '2017-12-19 06:04:02', ''),
(26, 9, 'Hab u seen Alien pls?', 'Plssss', 30, '(23.82641498181508, 90.37108898162842)', '(23.820840251521336, 90.3636646270752)', 'c', '268pdgySg4', '26hwcRaFHHR', 25, 420, NULL, '2017-12-19 07:54:46', NULL, 9, '2017-12-19 07:59:04', NULL, ''),
(27, 9, 'testX', 'test', 100, NULL, '(23.81336109989597, 90.42724370956421)', 'c', '27FlsY9xF8', '27VVIqPse73', 100, 100, NULL, '2017-12-19 09:07:01', NULL, 9, '2017-12-19 09:09:21', NULL, ''),
(28, 9, 'TestX2', 'hh', 3334, '(23.818092056912917, 90.42481899261475)', '(23.81326294543511, 90.42769432067871)', 'e', '28iSaiK47E', '28UARho3cqh', 1000, 100, NULL, '2017-12-19 09:12:22', NULL, 9, '2017-12-19 09:12:34', '2017-12-19 09:59:42', ''),
(29, 9, 'dhdcjv', 'hhhj', 1111, '(23.822410622312653, 90.362548828125)', '(23.825904629142055, 90.36855697631836)', 'g', '29sls3Zmpe', '294o5YNV72E', 1111, 1111, NULL, '2017-12-19 10:44:21', '2017-12-24 00:49:21', 9, '2017-12-19 10:45:09', '2017-12-19 10:46:04', ''),
(30, 9, '555', 'tt', 100, '(23.814087440599874, 90.43353080749512)', '(23.812674017111572, 90.42730808258057)', 'g', '30exTQhpg3', '300YH7AOtoY', 100, 100, NULL, '2017-12-24 00:39:33', '2017-12-24 00:48:10', 9, '2017-12-24 00:39:55', '2017-12-24 00:40:22', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trxID` int(11) NOT NULL,
  `userIDFrom` int(11) NOT NULL,
  `userIDTo` int(11) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trxID`, `userIDFrom`, `userIDTo`, `amount`, `description`, `timestamp`) VALUES
(1, 9, 9, 600, 'Completed Delivery', '2017-12-19 05:37:50'),
(2, 9, 9, 100, 'Completed Delivery', '2017-12-24 00:48:10'),
(3, 9, 9, 1111, 'Completed Delivery', '2017-12-24 00:49:20'),
(4, 9, 9, 1111, 'Completed Delivery', '2017-12-24 00:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `userID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mob` varchar(14) NOT NULL,
  `balance` float NOT NULL,
  `isEmailVerified` tinyint(1) NOT NULL DEFAULT '0',
  `isMobVerified` tinyint(1) NOT NULL DEFAULT '0',
  `signupIP` varchar(64) NOT NULL,
  `isBlocked` tinyint(1) NOT NULL DEFAULT '0',
  `lastverreq` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emailVC` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`userID`, `email`, `password`, `mob`, `balance`, `isEmailVerified`, `isMobVerified`, `signupIP`, `isBlocked`, `lastverreq`, `emailVC`) VALUES
(2, 'andalib369@gmail.com', '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37', 'A', 7000000, 1, 0, '45.127.49.193', 0, '2017-11-14 04:53:05', '9z9QxJ'),
(3, 'zowinaxob@datum2.com', '$2y$12$We1aL8G.Uz./ln40aw7aJuU9T9ddnpKktwjTaCboHJTH3pmVn97Gy', 'B', 7000000, 1, 0, '45.127.50.247', 0, '2017-11-14 08:27:59', 'AuC0yG'),
(4, 'kivum@zhorachu.com', '$2y$12$zt9w.EjU5vzRkQMdHDnQSu3oHZC3du0KoXef/NeOBNCFeYxA5kISq', 'C', 7000000, 1, 0, '45.64.132.33', 0, '2017-11-14 09:34:14', 'rUibmI'),
(5, 'hfgsdfg@zhorachu.com', '$2y$12$ybvJiq5y5JUoz9xFI/iy2Og5GQOEys62B3jrPXAzGHbjAWU2wT0ui', 'D', 7000000, 1, 0, '45.64.132.33', 0, '2017-11-14 09:36:36', 'SbLo9n'),
(6, 'louden.lyndell@affricca.com', '$2y$12$eu/2XHhut5HIo0kNX8Gncuy2H.V1S65spAGXh6osymQrEGGYIB6SO', '14785223698', 7000000, 1, 0, '45.127.49.60', 0, '2017-12-12 02:35:43', 'ttNsDv'),
(7, 'aariyah.niyana@affricca.com', '$2y$12$9/yue3FM3cRpiqm7SsiTs.xtRLXdgJ45XPLl4HmnyWAgwRYOSYjTW', '14785223658', 7000000, 1, 0, '45.127.49.60', 0, '2017-12-12 03:05:40', 'K9fu1c'),
(8, 'guxek@cobin2hood.com', '$2y$12$2h59d3bjftnEWhH/Nnyam.ZaqlrmdbxjkFNVgKbvZtcX1fz5mres6', '11111111111', 0, 1, 0, '123.108.246.41', 0, '2017-12-12 10:10:21', 's3dOvT'),
(9, 'a@a.com', '$2y$12$MFfzXPdO9jT42n37Zo.44uszEAEeOhTMNeNFMx1XiDVuoNOqAinxS', '11111111112', 1005510, 1, 0, '45.127.50.215', 0, '2017-12-18 18:51:43', 'dY22g4');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `activityID` int(11) NOT NULL,
  `sessionID` int(11) NOT NULL,
  `activity` varchar(30) NOT NULL,
  `deviceID` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `userID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `dp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`userID`, `name`, `dob`, `dp`) VALUES
(0, 'andypandy', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE `user_login_history` (
  `sessionID` int(11) NOT NULL,
  `sessionHash` varchar(20) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_verification`
--

CREATE TABLE `user_verification` (
  `userID` int(11) NOT NULL,
  `emailVC` varchar(6) NOT NULL,
  `mobileVC` varchar(6) NOT NULL,
  `IDDoc` int(11) NOT NULL,
  `IDDocHolding` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device_info`
--
ALTER TABLE `device_info`
  ADD PRIMARY KEY (`deviceID`),
  ADD UNIQUE KEY `imei` (`imei`),
  ADD UNIQUE KEY `serial` (`serial`),
  ADD UNIQUE KEY `mac` (`mac`);

--
-- Indexes for table `job_list`
--
ALTER TABLE `job_list`
  ADD PRIMARY KEY (`jobID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trxID`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mob` (`mob`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `dp` (`dp`);

--
-- Indexes for table `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD PRIMARY KEY (`sessionID`),
  ADD UNIQUE KEY `sessionHash` (`sessionHash`);

--
-- Indexes for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `IDDoc` (`IDDoc`),
  ADD UNIQUE KEY `IDDocHolding` (`IDDocHolding`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_info`
--
ALTER TABLE `device_info`
  MODIFY `deviceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_list`
--
ALTER TABLE `job_list`
  MODIFY `jobID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trxID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_history`
--
ALTER TABLE `user_login_history`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
