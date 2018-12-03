-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2018 at 12:09 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_series_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_channels`
--

CREATE TABLE `tbl_channels` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_channels`
--

INSERT INTO `tbl_channels` (`id`, `name`) VALUES
(1, 'Netflix');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_episodes`
--

CREATE TABLE `tbl_episodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `season` tinyint(3) UNSIGNED DEFAULT NULL,
  `episode` tinyint(3) UNSIGNED DEFAULT NULL,
  `airdate` int(11) DEFAULT NULL,
  `rating` decimal(3,1) UNSIGNED DEFAULT NULL,
  `show_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_episodes`
--

INSERT INTO `tbl_episodes` (`id`, `name`, `description`, `season`, `episode`, `airdate`, `rating`, `show_id`) VALUES
(1, 'Tape 1, Side A', 'As the school mourns the death of Hannah Baker, her friend Clay receives a box of tapes with messages she recorded before she committed suicide.', 1, 1, 1490911200, '0.0', 1),
(2, 'Tape 1, Side B', 'Hannah makes friends with Jessica and Alex, two other new students. Justin doesn\'t show up at school, and Hannah\'s mother finds something troubling.', 1, 2, 1490911200, '0.0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shows`
--

CREATE TABLE `tbl_shows` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `airtime` mediumint(6) UNSIGNED NOT NULL,
  `duration` tinyint(3) UNSIGNED NOT NULL,
  `rating` decimal(3,1) UNSIGNED DEFAULT NULL,
  `channel_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_shows`
--

INSERT INTO `tbl_shows` (`id`, `name`, `description`, `airtime`, `duration`, `rating`, `channel_id`) VALUES
(1, '13 Reasons Why', 'Follows teenager Clay Jensen, in his quest to uncover the story behind his classmate and crush, Hannah, and her decision to end her life.', 61200, 60, '7.9', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_channels`
--
ALTER TABLE `tbl_channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_episodes`
--
ALTER TABLE `tbl_episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbl_episodes_tbl_shows_idx` (`show_id`);

--
-- Indexes for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbl_shows_tbl_channel1_idx` (`channel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_channels`
--
ALTER TABLE `tbl_channels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_episodes`
--
ALTER TABLE `tbl_episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_episodes`
--
ALTER TABLE `tbl_episodes`
  ADD CONSTRAINT `fk_tbl_episodes_tbl_shows` FOREIGN KEY (`show_id`) REFERENCES `tbl_shows` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  ADD CONSTRAINT `fk_tbl_shows_tbl_channel1` FOREIGN KEY (`channel_id`) REFERENCES `tbl_channels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
