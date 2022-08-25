-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2021 at 08:36 PM
-- Server version: 10.3.30-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nj16_3_db`
--
CREATE DATABASE IF NOT EXISTS `nj16_3_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `nj16_3_db`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerId` int(11) NOT NULL,
  `lastName` varchar(35) DEFAULT NULL,
  `firstName` varchar(35) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `email` varchar(65) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `paymentInfo` varchar(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerId`, `lastName`, `firstName`, `phone`, `email`, `address`, `paymentInfo`) VALUES
(1, 'Becks', 'Charlie', '317-317-3117', 'cbecks@hotmail.com', '8267 N West St, Indianapolis IN 46251', '1111222233334444'),
(5, 'Jackson', 'Amelia', '123-456-7890', 'jacksona1234@gmail.com', '1234 E South St, Greenwood IN 46221', '1234567891022354'),
(6, 'Dickerson', 'Andrew', '555-666-4444', 'andydickerson@yahoo.com', '1111 Main St, Plainfield IN 46123', '1111222255556666'),
(7, 'Noah', 'Daniel', '645-645-6451', 'dannoah@aol.com', '123 S Maple St, Greenfield IN 46000', '9999888877774444'),
(8, 'Smith', 'John', '314-314-3145', 'smithy63@khols.com', '21 Ash Rd, Fort Wayne IN 46789', '5555666644441111');

-- --------------------------------------------------------

--
-- Stand-in structure for view `CustomerTransactions`
-- (See below for the actual view)
--
CREATE TABLE `CustomerTransactions` (
`Customer Name` varchar(71)
,`Service Offered` varchar(100)
,`Total Price` decimal(6,2)
,`Payment Method` varchar(19)
,`Customer Email` varchar(65)
,`Service Start Date` timestamp
,`Service End Date` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeId` int(11) NOT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `email` varchar(65) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `servSpec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeId`, `lastName`, `firstName`, `phone`, `email`, `location`, `servSpec`) VALUES
(1, 'Johnson', 'Noah', '317-800-4861', 'nj16@iu.edu', 'Hamilton', 2),
(2, 'Jackson', 'Bill', '564-897-2315', 'bjack@aol.com', 'Hendricks', 4),
(3, 'Willis', 'Ana', '555-444-6666', 'wutupwillis@gmail.com', 'Johnson', 3),
(4, 'Hanson', 'Hank', '231-656-6565', 'hh@hotmail.com', 'Boone', 1),
(5, 'Unger', 'Joe', '999-888-7777', 'josephu@yahoo.com', 'Marion', 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `EmployeeVisits`
-- (See below for the actual view)
--
CREATE TABLE `EmployeeVisits` (
`Employee Name` varchar(91)
,`Visit ID` int(11)
,`Service Offered` varchar(100)
,`Visit Description` varchar(200)
,`Notes for future visits` varchar(200)
,`Customer Name` varchar(71)
);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchaseId` int(5) NOT NULL,
  `customerId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `numVisits` int(11) NOT NULL,
  `dateBegin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `totalPrice` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchaseId`, `customerId`, `serviceId`, `numVisits`, `dateBegin`, `dateEnd`, `totalPrice`) VALUES
(1, 1, 4, 2, '2021-08-06 06:21:41', '2021-08-30 06:17:17', '350.00'),
(2, 5, 3, 3, '2021-08-06 23:20:01', '2021-08-27 06:17:17', '500.00'),
(3, 6, 5, 1, '2021-08-06 23:18:46', '2021-08-18 06:17:17', '120.00'),
(4, 7, 2, 1, '2021-08-06 23:18:57', '2021-08-11 06:17:17', '120.00'),
(5, 8, 1, 2, '2021-08-06 23:19:05', '2021-08-07 06:17:17', '250.00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `serviceId` int(11) NOT NULL,
  `servName` varchar(100) DEFAULT NULL,
  `servDesc` varchar(250) DEFAULT NULL,
  `servPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceId`, `servName`, `servDesc`, `servPrice`) VALUES
(1, 'Bat Removal', 'The removal of bats from attics, barns, sheds, and garages. ', '250.00'),
(2, 'Raccoon Relocation', 'Catching Raccoons and moving them from one property to a safe location where they will not be a nuisance.', '120.00'),
(3, 'Nuisance Geese Relocation', 'Catching geese and relocating them to rural areas away from populated cities.', '500.00'),
(4, 'Skunk Removal', 'Catching skunks and moving them from the property to a safe location where they will not be a nuisance.', '350.00'),
(5, 'Small Rodent', 'Removal of small rodents from inside of houses, barns, and offices. Includes but is not limited to Mice, Rats, Squirrels, and Cockroaches', '120.00');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `visitId` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `purchaseId` int(11) NOT NULL,
  `visitDesc` varchar(200) DEFAULT NULL,
  `futureNotes` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`visitId`, `employeeId`, `serviceId`, `customerId`, `purchaseId`, `visitDesc`, `futureNotes`) VALUES
(1, 2, 4, 1, 1, 'Cage trap set by shed', 'May have to move shed'),
(2, 2, 4, 1, 1, 'Skunk removed from the premises', 'Job complete'),
(3, 3, 3, 2, 2, 'Initial harassment.', 'May need a roundup. Check in future if harassment was successful.'),
(4, 3, 3, 2, 2, 'Secondary harassment. Schedule roundup', 'Initial harassment did not succeed. Need to schedule a roundup'),
(5, 3, 3, 2, 2, 'Roundup flock of geese', 'Job complete'),
(6, 1, 2, 4, 4, 'Cage Traps set early morning. Raccoon caught by midday and relocated.', 'Job Complete'),
(7, 4, 1, 5, 5, 'Bat netting placed on all inlets to the house. Bat house placed in back yard.', 'Check that all signs have dissipated.'),
(8, 4, 1, 5, 5, 'All signs have dissiapated.', 'Job Complete.');

-- --------------------------------------------------------

--
-- Structure for view `CustomerTransactions`
--
DROP TABLE IF EXISTS `CustomerTransactions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`nj16`@`localhost` SQL SECURITY DEFINER VIEW `CustomerTransactions`  AS  select concat(`customers`.`firstName`,' ',`customers`.`lastName`) AS `Customer Name`,`services`.`servName` AS `Service Offered`,`purchases`.`totalPrice` AS `Total Price`,`customers`.`paymentInfo` AS `Payment Method`,`customers`.`email` AS `Customer Email`,`purchases`.`dateBegin` AS `Service Start Date`,`purchases`.`dateEnd` AS `Service End Date` from ((`purchases` left join `customers` on(`customers`.`customerId` = `purchases`.`customerId`)) left join `services` on(`purchases`.`serviceId` = `services`.`serviceId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `EmployeeVisits`
--
DROP TABLE IF EXISTS `EmployeeVisits`;

CREATE ALGORITHM=UNDEFINED DEFINER=`nj16`@`localhost` SQL SECURITY DEFINER VIEW `EmployeeVisits`  AS  select concat(`employees`.`firstName`,' ',`employees`.`lastName`) AS `Employee Name`,`visits`.`visitId` AS `Visit ID`,`services`.`servName` AS `Service Offered`,`visits`.`visitDesc` AS `Visit Description`,`visits`.`futureNotes` AS `Notes for future visits`,concat(`customers`.`firstName`,' ',`customers`.`lastName`) AS `Customer Name` from (((`visits` left join `employees` on(`employees`.`employeeId` = `visits`.`employeeId`)) left join `customers` on(`customers`.`customerId` = `visits`.`customerId`)) left join `services` on(`services`.`serviceId` - `visits`.`serviceId`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeId`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchaseId`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`serviceId`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visitId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchaseId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `serviceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `visitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
