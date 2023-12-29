-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2023 at 08:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanage_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasklist`
--

CREATE TABLE `tasklist` (
  `id_task` int NOT NULL,
  `id` int NOT NULL,
  `task` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasklist`
--

INSERT INTO `tasklist` (`id_task`, `id`, `task`, `date`, `time`) VALUES
(1, 1, 'Talk to Dan Heng', '2023-12-29', '16:00:00.000000'),
(2, 1, 'Clean your room', '2023-12-29', '18:00:00.000000'),
(3, 2, 'Talk to March 7th', '2023-12-29', '16:15:00.000000'),
(4, 1, 'Talk to Himeko', '2023-12-29', '20:20:00.000000'),
(5, 1, 'Hang out with Caelus, March 7th and Dan Heng', '2023-12-29', '20:30:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `pass`) VALUES
(1, 'Dzaki Al', 'dzakial@gmail.com', '$2y$10$akob64XE5eXvO8iOIgP6.eoCgjG8t2nf8uu3QTWybsi2T7mUMujRO'),
(2, 'Dan Heng', 'danheng@gmail.com', '$2y$10$p2IxWsPqGiq2eN.1mzDtzOSyDse/TpttJvf44xeSVt4jUXl9XObSe'),
(3, 'March 7th', 'march7th@gmail.com', '$2y$10$7TxOxPtP7YmXf6OCOaqYr.e3TGOa25h6jMA1ca/aubx8tZ87IcsaO'),
(4, 'Caelus', 'caelus@gmail.com', '$2y$10$Vj/LpIH.Fjn0kPaRb8PjiOI9ZsehKLwkfcJe9s6mrAHKdZKFhzy2S'),
(5, 'Himeko', 'himeko@gmail.com', '$2y$10$6MYAENWf0HyJn4MY2Tmfyu0EgXnEVHXp4j2LfqAy2zSXYexcFgd.C'),
(6, 'Welt Yang', 'weltyang@gmail.com', '$2y$10$GPeOmT1UW2lsZXnjQ0IZluRPQyLymAu./i5HkrxDLJPrFJwOqa9J2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasklist`
--
ALTER TABLE `tasklist`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasklist`
--
ALTER TABLE `tasklist`
  MODIFY `id_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasklist`
--
ALTER TABLE `tasklist`
  ADD CONSTRAINT `tasklist_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
