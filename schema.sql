-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 12:27 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marina`
--

-- --------------------------------------------------------

--
-- Table structure for table `boat`
--

CREATE TABLE `boat` (
  `id` int(11) NOT NULL,
  `name` varchar(15) DEFAULT NULL,
  `reg_num` varchar(10) DEFAULT NULL,
  `length` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `boat`
--

INSERT INTO `boat` (`id`, `name`, `reg_num`, `length`, `image`, `owner_id`, `created_by`) VALUES
(1, 'Nautilus', '', '10', 'boat1.jpg', 1, 1),
(2, 'Kobayashi Maru', 'LMZ90210', '20', 'boat2.jpg', 2, 1),
(3, 'Bismarck', '3333', '50', 'boat3.jpg', 3, 1),
(4, 'Exxon Valdez', '4444', '100', 'boat4.jpg', 4, 1),
(5, 'test', NULL, '7', '1618912603_607ea55bb7f15.jpg', 5, 5),
(6, 'test', NULL, '7', '1618898555_607e6e7b442d0.png', 5, 5),
(7, 'k', NULL, '55', '1618898620_607e6ebc087aa.png', 12, 5),
(8, 'boat3', NULL, '44', '1618900982_607e77f617026.png', 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `user_type` tinyint(4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `address`, `phone`, `image`, `username`, `password`, `user_type`, `created_by`) VALUES
(1, 'Mark', 'Dutchuk', '111 Street', '(111) 111 1111', '', '', NULL, 1, 1),
(2, 'Dave', 'Croft', '222 Street', '(222) 222 2222', '', '', NULL, 1, 1),
(3, 'Thurston', 'Howell III', '333 Street', '(333) 333 3333', '', '', NULL, 1, 1),
(4, 'Bill', 'Gates', '444 Street', '(444) 444 4444', '', '', NULL, 1, 1),
(5, 'Admin1', 'admin1', NULL, NULL, '1618859026_607dd41218f0a.png', 'admin', '$2y$10$qMXbP8nw/UDZj2dHtA28wOXYPt/7hlRdKK22Zo55T9y0XsZLyloQy', 0, 5),
(12, 'admin2', 'admin2', 'hyd', '98888888', '1618859026_607dd41218f0a.png', 'admin2', '$2y$10$RaMisCvJIIQBJm0iHmhIjuaI5Cqn1b2N3eO2ISaF0x6lh2E6dMzyO', 0, NULL),
(14, NULL, NULL, NULL, NULL, NULL, 'pihu3', '$2y$10$KZoMyjWgZSZY61zlJND7Y.kKdI1F8C7VioJdUuWdrhiinkbPiDqcS', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boat`
--
ALTER TABLE `boat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boat`
--
ALTER TABLE `boat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boat`
--
ALTER TABLE `boat`
  ADD CONSTRAINT `boat_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
