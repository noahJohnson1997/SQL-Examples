-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2021 at 05:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safecar`
--
CREATE DATABASE IF NOT EXISTS `safecar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `safecar`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `carModelID` varchar(4) NOT NULL,
  `carSafetyRating` int(11) NOT NULL,
  `carSafetyFeatures` varchar(2) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`carModelID`, `carSafetyRating`, `carSafetyFeatures`, `id`) VALUES
('BM01', 3, 'F2', 1),
('CH01', 3, 'F4', 2),
('FO01', 4, 'F1', 3),
('HO01', 5, 'F5', 4);

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `class` varchar(12) NOT NULL,
  `description` text NOT NULL,
  `bonus?` tinyint(1) NOT NULL,
  `carSafetyFeatures` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`class`, `description`, `bonus?`, `carSafetyFeatures`) VALUES
('Plus', 'Vehicle includes basic safety features such as seatbelts and standard airbags as well as door airbags and backup detection.', 1, 'F2'),
('Premium', 'Vehicle includes basic safety features such as seatbelts and standard airbags as well as door airbags and backup detection. Vehicle also possesses lane detection for rear-view mirrors and backup camera.', 1, 'F3'),
('Premium Plus', 'Vehicle includes basic safety features such as seatbelts and standard airbags as well as door airbags and backup detection. Vehicle also possesses lane detection for rear-view mirrors and backup camera. Vehicle also possesses automatic lane control and parallel parking.', 1, 'F4'),
('Stellar', 'Vehicle includes basic safety features such as seatbelts and standard airbags as well as door airbags and backup detection. Vehicle also possesses lane detection for rear-view mirrors and backup camera. Vehicle also possesses automatic lane control and parallel parking. Vehicle also possesses automatic traffic control, auto driving, and windshield bags.', 1, 'F5'),
('Base Plus', 'Slightly better', 1, 'F6'),
('Base', 'Slightly better than base', 1, 'F7');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(100) NOT NULL,
  `modelID` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`name`, `description`, `year`, `price`, `image`, `modelID`) VALUES
('3 Series 325i', 'BMW\'s take on the sedan... while still leaving all of the power and luxury that you would expect from a BMW.', 2001, '3662.00', 'https://th.bing.com/th/id/OIP.xd09zOXUeaT-HlvSI6upDwHaFi?w=270&h=202&c=7&o=5&dpr=1.09&pid=1.7', 'BM01'),
('Malibu LTZ Sedan 4D', 'The perfect all around sedan for families and general commuters around the globe.', 2006, '4299.00', 'https://th.bing.com/th/id/OIP.Xk34MQA63Qwfb0bB8Umh4gHaE6?w=295&h=196&c=7&o=5&dpr=1.09&pid=1.7', 'CH01'),
('Mustang GT', 'The all-American muscle trusted by car enthusiasts for over 40 years. Quick, fast, and loud. It\'s the Mustang GT.', 2020, '34683.00', 'https://th.bing.com/th/id/OIP.yC9A8wHne_drBrJJYSaXHgHaE7?w=261&h=180&c=7&o=5&dpr=1.09&pid=1.7', 'FO01'),
('Civic', 'Great gas mileage, long lasting engine, and all of the durability you would expect out of a Honda. Perfect for the daily commute.', 2019, '20452.00', 'https://th.bing.com/th/id/OIP.Vif0nSh9hzzkhlXVzBC6-gHaEK?w=290&h=180&c=7&o=5&dpr=1.09&pid=1.7', 'HO01'),
('Fit', 'The hybrid to save you thousands. Great commuter vehicle for fast commutes and city driving.', 2020, '16975.00', 'https://static.cargurus.com/images/site/2017/11/19/10/40/2018_honda_fit-pic-7462875011874069684-1600', 'HO02');

-- --------------------------------------------------------

--
-- Table structure for table `safety`
--

CREATE TABLE `safety` (
  `rating` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `safety`
--

INSERT INTO `safety` (`rating`, `description`, `image`) VALUES
(1, 'The lowest vehicle rating possible. Vehicle has performed in the bottom 20% of all vehicle tests. Fatalities occur more often when this vehicle is wrecked than any other vehicle on the road.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/1_stars.svg/535px-1_stars.svg.png'),
(2, 'This vehicle is not the bottom tier as far as safety is concerned, but there are still major concerns about safety during testing. Fatalities are recorded for this vehicle, however it is not certain t', 'https://th.bing.com/th/id/R.09af8e1deafe96ab61e16882d5a82638?rik=ckYx77wjEUXS2Q&pid=ImgRaw'),
(3, 'This vehicle has a fair safety rating. There are moderate concerns about the vehicles safety during crash testing. Fatalities are not likely to occur in this vehicle during a wreck.', 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Star_rating_3_of_5.png'),
(4, 'This vehicle has a good safety rating. No concerns were brought up during crash tests.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/4_stars.svg/1280px-4_stars.svg.png'),
(5, 'This vehicle has an outstanding safety rating. This vehicle contains accident mitigation systems to prevent accidents and enough safety features to prevent major injury during an accident', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/5_stars.svg/1280px-5_stars.svg.png');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user`, `value`, `created_at`, `updated_at`) VALUES
(8, 10002, '05a0eb54509be98243c5fa9adaa384038a2e8171b4214d4cad980d94f9455b955d12cb278763e311b5151eff667d6c96ddf08e59d77e68a298b607c40134b9d1', '2021-07-28 02:54:22', '2021-07-28 02:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` smallint(6) DEFAULT 2,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(10002, 'Nick sanchez', 'nj16@google.com', 'user', '$2y$10$QsReG6d0HPEHzTgqjlER8.RVloULHfIaHD57q9RN2EaDLPDBZgqbO', 1, '2021-07-28 02:01:54', '2021-07-28 02:29:38'),
(10004, 'Noah Johnson', 'nj16@google.com', 'username', '$2y$10$UeX0fDcZSL4Gc.84ddu3puDH2sE6f0gMCOXg98IH5R5qqutO.py7q', 2, '2021-07-28 03:30:11', '2021-07-28 03:30:11'),
(10005, 'Brandon', 'b@b.com', 'user', '$2y$10$A1/aLzShQu71rbH8xmRM..HOd52rCWX1x4G5Wd282F1arMx8HsN1a', 2, '2021-08-03 20:15:55', '2021-08-03 20:15:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modelID` (`carModelID`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`carSafetyFeatures`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`modelID`);

--
-- Indexes for table `safety`
--
ALTER TABLE `safety`
  ADD PRIMARY KEY (`rating`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_uindex` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10006;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
