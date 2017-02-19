-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2017 at 08:52 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `comment_body` text NOT NULL,
  `comment_image` varchar(50) NOT NULL,
  `commenter_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `thread_id`, `comment_body`, `comment_image`, `commenter_id`, `updated_at`, `inserted_at`, `edited`) VALUES
(5, 4, 'Just a comment by caress', '0', 6, '0000-00-00 00:00:00', '2017-02-18 03:46:33', 0),
(6, 4, 'Just a comment by caress', '0', 6, '0000-00-00 00:00:00', '2017-02-18 04:21:00', 0),
(10, 4, 'Well this one is another nice post', '0', 1, '0000-00-00 00:00:00', '2017-02-18 15:35:01', 0),
(12, 4, '  Just an image comments', '1_18022017175004.png', 1, '2017-02-18 18:53:11', '2017-02-18 16:50:04', 1),
(14, 8, '  test this is working with pdo working', '9_18022017190812.png', 9, '2017-02-18 20:20:47', '2017-02-18 18:08:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `topic_id` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `title`, `body`, `image`, `poster_id`, `topic_id`, `updated_at`, `inserted_at`, `edited`) VALUES
(4, 'HAPPINESS Everywhere', 'This is a test post prvoided by mohammed abdus sattar shohag. Please chek ', '6_17022017144818.jpg', 6, '0', '0000-00-00 00:00:00', '2017-02-17 13:48:18', 0),
(8, 'New post by PDO', 'this is anotherpost by PDO', '9_18022017184449.png', 9, '0', '0000-00-00 00:00:00', '2017-02-18 17:44:49', 0),
(10, 'ryrtytr', 'I can''t do that', '1_18022017194849.jpg', 1, '0', '0000-00-00 00:00:00', '2017-02-18 18:48:49', 0),
(12, 'dfdsfdsfd', 'bhgf Eidtefdffd fgfdg', '1_18022017204500.jpg', 1, 'New topic by shg', '2017-02-18 21:45:00', '2017-02-18 19:14:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `inserted_by` int(11) NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topic_name`, `inserted_by`, `inserted_at`) VALUES
(1, '0', 1, '2017-02-18 19:09:54'),
(2, 'New topic by shg', 1, '2017-02-18 19:14:20'),
(3, 'last new', 1, '2017-02-18 19:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(500) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `inserted_at`) VALUES
(1, 'Mohammed Abdus Sattar', 'shohag_engnr@yahoo.com', 'a152e841783914146e4bcd4f39100686', '2017-02-17 06:55:03'),
(5, 'Mohammed Abdus Sattar', 'shohag.support@gmail.com', 'a152e841783914146e4bcd4f39100686', '2017-02-17 07:01:16'),
(6, 'Caress', 'shohag.cse@hotmail.com', '040b7cf4a55014e185813e0644502ea9', '2017-02-17 13:46:12'),
(9, 'test', 'test@test.com', 'a152e841783914146e4bcd4f39100686', '2017-02-18 17:18:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
