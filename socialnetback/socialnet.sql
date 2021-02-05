-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2017 at 01:52 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friends_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_surname` varchar(20) NOT NULL,
  `user_birthday` date DEFAULT NULL,
  `user_gender` varchar(20) NOT NULL,
  `user_avatar` text,
  `user_marital_status` varchar(20) DEFAULT NULL,
  `user_short_bio` text,
  `user_vk` varchar(100) DEFAULT NULL,
  `user_fb` varchar(100) DEFAULT NULL,
  `user_instagram` varchar(100) DEFAULT NULL,
  `user_twitter` varchar(100) DEFAULT NULL,
  `user_youTube` varchar(100) DEFAULT NULL,
  `user_linkedin` varchar(100) DEFAULT NULL,
  `user_google_plus` varchar(100) DEFAULT NULL,
  `user_activity` varchar(500) DEFAULT NULL,
  `user_interests` varchar(500) DEFAULT NULL,
  `user_fav_mus` varchar(500) DEFAULT NULL,
  `user_fav_mov` varchar(500) DEFAULT NULL,
  `user_fav_books` varchar(500) DEFAULT NULL,
  `user_fav_games` varchar(500) DEFAULT NULL,
  `user_rating` int(11) NOT NULL,
  `user_verified` tinyint(1) NOT NULL,
  `user_role_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_name`, `user_surname`, `user_birthday`, `user_gender`, `user_avatar`, `user_marital_status`, `user_short_bio`, `user_vk`, `user_fb`, `user_instagram`, `user_twitter`, `user_youTube`, `user_linkedin`, `user_google_plus`, `user_activity`, `user_interests`, `user_fav_mus`, `user_fav_mov`, `user_fav_books`, `user_fav_games`, `user_rating`, `user_verified`, `user_role_fk`) VALUES
(3, 'emma.watson@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'Emma', 'Watson', NULL, 'Female', 'img/emmawatson.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 2),
(4, 'oleg.makarov@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'Oleg', 'Makarov', NULL, 'Male', 'https://pp.userapi.com/c627617/v627617219/165e3/WVouef1MasY.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2),
(7, 'test@mail.ru', 'qwewqeqwe', 'test', 'test', NULL, 'male', 'https://lh4.ggpht.com/wKrDLLmmxjfRG2-E-k5L5BUuHWpCOe4lWRF7oVs1Gzdn5e5yvr8fj-ORTlBF43U47yI=w300', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 2),
(11, 'artik.shark@i.ua', '3fc0a7acf087f549ac2b266baf94b8b1', 'Artem', 'Bely', '1995-09-18', 'Male', 'https://pp.userapi.com/c628231/v628231613/348ad/YDnpO6TO3vk.jpg', 'Married', 'Chuj!', 'https://vk.com/id96279613', 'https://www.facebook.com/profile.php?id=100001723437843', NULL, NULL, 'https://www.youtube.com/channel/UCq3VRB0QV7SBkkCIBcAhbHw', NULL, NULL, 'Operator of call center', 'Radio bazar', 'Rammstein', 'Sin sity 1,2', 'Stephen King', 'GTA, Fallout, Doom', 2400, 1, 2),
(12, 'jeniL@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'Jeniffer', 'Lawrence', NULL, 'Female', 'http://fanworld.co/wp-content/uploads/2015/12/Jennifer_Lawrence.jpeg', 'In love', 'Fapped by Artem Bely!', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 2),
(13, 'vlad.lyfar@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'Vladyslav', 'Lyfar', NULL, 'Male', 'https://pp.userapi.com/c836530/v836530239/2e427/bxkN9b37CMA.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1),
(14, 'petro@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'Petro', 'Poroshenko', NULL, 'Male', 'https://media.cackle.me/d/34/c35b0037b94c2aebece18dc168cde34d.png', 'Married', 'President of Ukraine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `user_role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `user_role_name`) VALUES
(1, 'admin'),
(2, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role_fk` (`user_role_fk`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_fk`) REFERENCES `user_roles` (`user_role_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
