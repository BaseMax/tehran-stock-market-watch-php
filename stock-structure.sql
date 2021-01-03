-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2021 at 06:34 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` bigint(50) NOT NULL,
  `symbol_id` bigint(50) NOT NULL,
  `time` bigint(20) NOT NULL,
  `count_all` bigint(11) NOT NULL,
  `volume_all` bigint(11) NOT NULL,
  `price_all` bigint(11) NOT NULL,
  `price_yesterday_last` int(11) NOT NULL,
  `price_today_first` int(11) NOT NULL,
  `price_now` int(11) NOT NULL,
  `price_max` int(11) NOT NULL,
  `price_min` int(11) NOT NULL,
  `price_close` int(20) DEFAULT NULL,
  `eps` float DEFAULT NULL,
  `rsi` float DEFAULT NULL,
  `ao` float DEFAULT NULL,
  `rocr` float DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `symbol`
--

CREATE TABLE `symbol` (
  `id` bigint(50) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(52) NOT NULL,
  `ins` varchar(52) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time` (`time`),
  ADD KEY `price_now` (`price_now`),
  ADD KEY `datetime` (`datetime`);

--
-- Indexes for table `symbol`
--
ALTER TABLE `symbol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `ins` (`ins`),
  ADD KEY `symbol` (`symbol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `symbol`
--
ALTER TABLE `symbol`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
