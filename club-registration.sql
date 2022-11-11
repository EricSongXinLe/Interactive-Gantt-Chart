-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2022 at 10:17 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `club-registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int(11) NOT NULL,
  `subTaskName` varchar(255) NOT NULL,
  `startYear` int(255) NOT NULL,
  `startMonth` int(255) NOT NULL,
  `startDate` int(255) NOT NULL,
  `endYear` int(255) NOT NULL,
  `endMonth` int(255) NOT NULL,
  `endDate` int(255) NOT NULL,
  `percent` int(11) NOT NULL,
  `taskid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `subTaskName`, `startYear`, `startMonth`, `startDate`, `endYear`, `endMonth`, `endDate`, `percent`, `taskid`) VALUES
(5, 'Plan First Meeting with Client', 2022, 1, 1, 2022, 1, 10, 100, 57),
(6, 'Plan First Meeting with Advisor', 2022, 1, 1, 2022, 1, 5, 20, 57),
(7, 'Second Meeting with Advisor', 2022, 1, 10, 2022, 1, 20, 50, 57),
(8, 'Learn HTML/PHP/Front End', 2022, 1, 30, 2022, 5, 30, 100, 57),
(9, 'Design GUI', 2022, 2, 15, 2022, 3, 30, 80, 57),
(10, 'Third Meeting with Advisor', 2022, 4, 1, 2022, 4, 10, 100, 57),
(11, 'Second Meeting with Client', 2022, 4, 8, 2022, 4, 13, 100, 57),
(12, 'Program the front end', 2022, 4, 8, 2022, 6, 30, 90, 57),
(13, 'Program the back-end using PHP and mysql', 2022, 5, 3, 2022, 7, 15, 70, 57),
(14, 'Test the Program', 2022, 7, 15, 2022, 8, 15, 80, 57),
(15, 'Make Demo Video', 2022, 8, 30, 2022, 9, 15, 100, 57),
(16, 'Write Evaluation', 2022, 10, 1, 2022, 10, 15, 100, 57),
(18, 'Do Commonapp ', 2022, 3, 1, 2023, 3, 1, 13, 58),
(19, 'Ask for LoR', 2022, 3, 1, 2022, 5, 2, 98, 58),
(21, '2022', 2022, 1, 1, 2022, 3, 1, 13, 58);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `taskName` varchar(255) NOT NULL,
  `startYear` int(11) NOT NULL,
  `startMonth` int(11) NOT NULL,
  `startDate` int(11) NOT NULL,
  `endYear` int(11) NOT NULL,
  `endMonth` int(11) NOT NULL,
  `endDate` int(11) NOT NULL,
  `percent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `taskName`, `startYear`, `startMonth`, `startDate`, `endYear`, `endMonth`, `endDate`, `percent`) VALUES
(57, 'IA', 2022, 5, 1, 2022, 12, 1, 50),
(58, 'US College application', 2022, 8, 1, 2022, 12, 30, 40),
(59, 'Exam Prep', 2023, 1, 1, 2023, 5, 1, 0),
(60, 'Swim For Love Website', 2023, 6, 1, 2023, 8, 1, 80);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(365, 'Mad_Dog Mullan', 'peter.mullan@ykpaoschool.cn', '827ccb0eea8a706c4c34a16891f84e7b'),
(368, 'EricSongS', '123123', 'f5bb0c8de146c67b44babbf4e6584cc0'),
(369, 'EricS', 'xinlesong@126.com', '4297f44b13955235245b2497399d7a93'),
(370, 'EricSong', '/', '4297f44b13955235245b2497399d7a93'),
(371, 'PeterMullan123', 'example@gmail.com', '4297f44b13955235245b2497399d7a93'),
(372, 'Donkey', 'song_xinle@163.com', '4297f44b13955235245b2497399d7a93'),
(373, 'davidma', 'hello@world.cn', 'e10adc3949ba59abbe56e057f20f883e'),
(374, '1111111', '1111111', '351436ef4b279e1811a6c68a2dd58b1b'),
(375, 'EricSong', 'xinlesong@126.com', '25d55ad283aa400af464c76d713c07ad'),
(376, 'xijingping', 'xijingping@8964.com', 'e10adc3949ba59abbe56e057f20f883e'),
(377, 'Maozedong', 'mao.cn@com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `usertask`
--

CREATE TABLE `usertask` (
  `userID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertask`
--

INSERT INTO `usertask` (`userID`, `taskID`) VALUES
(368, 58),
(369, 58),
(370, 58),
(368, 59),
(369, 59),
(370, 59),
(365, 57),
(368, 57),
(369, 57),
(372, 57),
(365, 60),
(368, 60),
(373, 60),
(374, 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtasks_ibfk_1` (`taskid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertask`
--
ALTER TABLE `usertask`
  ADD KEY `taskID` (`taskID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`taskid`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usertask`
--
ALTER TABLE `usertask`
  ADD CONSTRAINT `usertask_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usertask_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
