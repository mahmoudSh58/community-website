-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 05:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `community_website_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `event_name` varchar(400) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `start_date` date NOT NULL,
  `time_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `num_lecture` int(11) NOT NULL,
  `content` text NOT NULL,
  `qualification` text NOT NULL DEFAULT 'Don\'t need',
  `admin_id` varchar(100) NOT NULL,
  `img_url` varchar(400) NOT NULL DEFAULT '../image/events/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `event_name`, `from_date`, `to_date`, `start_date`, `time_create`, `summary`, `description`, `duration`, `num_lecture`, `content`, `qualification`, `admin_id`, `img_url`) VALUES
(1, 'Level 0', '2023-04-01', '2023-07-01', '2023-07-15', '2023-04-30 11:03:55', 'Programming principles and concepts in computer science will be explained to beginners.', 'Programming principles and concepts in computer science will be explained to beginners.', 1, 8, 'binary system\r\n\r\nbasic of computer architecture\r\n\r\nhow compile code?\r\n\r\nwhat is IDE and judge?', 'Don\'t need', '644be552cc420', '../image/events/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `practice`
--

CREATE TABLE `practice` (
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_event` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `practice`
--

INSERT INTO `practice` (`time`, `id_event`, `id_user`) VALUES
('2023-04-30 14:11:15', 1, '123456');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'member',
  `first_name` varchar(100) NOT NULL,
  `second_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `governorate` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `college` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL,
  `birthday` year(4) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `role`, `first_name`, `second_name`, `last_name`, `email`, `password`, `governorate`, `city`, `college`, `level`, `birthday`, `experience`, `block`, `time`) VALUES
('123456', 'member', 'mahmoud', 'sharif', 'mosaad', 'test@gmail.com', '123456', 'kafr-elshekhi', 'kafr-elshekhi', 'Faculty of Engineering', '3', '2001', 'middle', 0, '2023-04-29 13:37:27'),
('644be552cc420', 'admin', 'mahmoud', 'sharif', 'sharif', 'mahmoudsharif915@gmail.com', '123456', 'kafr elshaikh', 'kafr elshaikh', 'Faculty of Engineering', '0', '2001', 'middle', 0, '2023-04-29 14:58:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `practice`
--
ALTER TABLE `practice`
  ADD PRIMARY KEY (`id_event`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `practice`
--
ALTER TABLE `practice`
  ADD CONSTRAINT `practice_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `practice_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
