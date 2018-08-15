-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2018 at 08:55 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wryton`
--

-- --------------------------------------------------------

--
-- Table structure for table `wryton_category`
--

CREATE TABLE `wryton_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_category`
--

INSERT INTO `wryton_category` (`category_id`, `name`, `status`) VALUES
(1, 'College', 1),
(2, 'Horror', 1),
(3, 'Romantic', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wryton_comment`
--

CREATE TABLE `wryton_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_comment`
--

INSERT INTO `wryton_comment` (`comment_id`, `user_id`, `post_id`, `comment`, `datetime`, `status`) VALUES
(1, 5, 8, 'awesome post. i realy liked it', '2017-03-15 00:00:00', 1),
(2, 5, 8, 'nice', '2017-03-03 00:00:00', 1),
(3, 5, 8, 'amazing', '2017-03-08 00:00:00', 1),
(4, 5, 8, 'wooooooooooow', '2017-03-23 18:09:24', 1),
(5, 5, 8, 'you have amazing skill', '2017-03-23 18:11:17', 1),
(6, 5, 8, 'thanx nazish', '2017-03-23 18:12:23', 1),
(7, 5, 7, 'nice thought nazish bro', '2017-03-23 18:18:51', 1),
(8, 5, 7, 'amazing', '2017-03-23 18:20:36', 1),
(9, 5, 8, 'wooooooooooooooooooooooooooooow', '2017-03-23 18:20:54', 1),
(10, 5, 8, 'love you bro', '2017-03-23 18:27:09', 1),
(11, 5, 7, 'Kya baat hai', '2017-03-23 19:09:58', 1),
(12, 5, 8, 'nice bro', '2017-04-02 11:05:20', 1),
(13, 5, 11, 'Bekar pist', '2017-04-14 13:05:57', 1),
(14, 5, 11, 'Nice', '2017-04-14 13:06:04', 1),
(15, 7, 11, 'nice post.', '2017-05-26 15:41:49', 1),
(16, 7, 11, 'woow', '2018-08-15 20:51:03', 1),
(17, 7, 12, 'woow', '2018-08-15 20:54:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wryton_favorite`
--

CREATE TABLE `wryton_favorite` (
  `favorite_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wryton_liked`
--

CREATE TABLE `wryton_liked` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_liked`
--

INSERT INTO `wryton_liked` (`like_id`, `user_id`, `post_id`, `datetime`) VALUES
(1, 5, 8, '2017-03-15 03:16:00');

-- --------------------------------------------------------

--
-- Table structure for table `wryton_post`
--

CREATE TABLE `wryton_post` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `anonymous` tinyint(4) NOT NULL COMMENT '1 for true 0 for show name',
  `title` varchar(100) NOT NULL,
  `post` varchar(1000) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_post`
--

INSERT INTO `wryton_post` (`post_id`, `category_id`, `user_id`, `anonymous`, `title`, `post`, `datetime`, `status`) VALUES
(1, 1, 5, 1, 'hello boy', 'jkfhkjaf kfkhjk ffahfaf\r\naakchdkajnhdcahnfkas\'a\r\nafcabhakshdckjan', '2017-03-07 00:00:00', 1),
(2, 1, 5, 0, 'loooo', 'jshfjshfsjns kjkds ', '2017-03-06 00:00:00', 1),
(3, 2, 5, 1, 'ni pta', 'ksjhfkshfjkjfk', '2017-03-01 00:00:00', 0),
(4, 2, 5, 0, 'lkkkk', 'jhsdjhsjdjhjsdsdfsd', '2017-03-07 07:00:00', 1),
(5, 3, 5, 0, 'hide', 'jsgfjhdfhdfs', '2017-03-05 00:00:00', 1),
(6, 3, 5, 0, 'kajfhhjhkKHKHKJKJHK', 'kjhkhfhfkjhkfjs', '2017-03-07 07:00:00', 0),
(7, 1, 5, 0, 'waah', 'kya baat hain', '2017-03-12 10:00:00', 1),
(8, 1, 5, 0, 'Lyf after college is very borring. want to enjoy ??? its very easy.. hahaha', 'to go all out, <br>to take great leaps, and to take big risks even if you are afraid of failure...especially when you are afraid of failure\r\nto go all out, to take great leaps, and to take big risks even if you are afraid of failure...especially when you are afraid of failure\r\nto go all out, to take great leaps, and to take big risks even if you are afraid of failure...especially when you are afraid of failure\r\nto go all out, to take great leaps, and to take big risks even if you are afraid of failure...especially when you are afraid of failure', '2017-03-12 07:00:00', 1),
(9, 2, 5, 1, 'my last day of clg', 'kya kahe.. kch khne layak nahi h', '2017-04-13 23:25:40', 1),
(10, 1, 7, 0, 'Bekar lyf', 'hai ek bat, par nahi batayge', '2017-04-14 00:08:19', 1),
(11, 2, 5, 1, 'Busy day', 'Kya kahe... Bore ho rahe hqi', '2017-04-14 13:05:30', 1),
(12, 2, 7, 1, 'testing', 'testing', '2018-08-15 20:52:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wryton_user`
--

CREATE TABLE `wryton_user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `security_key` varchar(100) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `registered_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_user`
--

INSERT INTO `wryton_user` (`user_id`, `fname`, `lname`, `email`, `password`, `security_key`, `verified`, `registered_on`, `status`) VALUES
(5, 'Nazish', 'Fraz', 'nfraz007@gmail.com', '123456', 'daa96d9681a21445772454cbddf0cac1', 1, '2017-03-05 18:30:24', 1),
(7, 'N', 'F', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '577fd60255d4bb0f466464849ffe6d8e', 1, '2017-04-14 00:02:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wryton_user_history`
--

CREATE TABLE `wryton_user_history` (
  `history_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wryton_user_history`
--

INSERT INTO `wryton_user_history` (`history_id`, `user_id`, `ip_address`, `datetime`) VALUES
(1, 5, '144.48.225.72', '2017-03-08 00:55:50'),
(2, 5, '47.15.12.44', '2017-03-20 11:15:53'),
(3, 5, '47.29.17.52', '2017-03-23 03:34:30'),
(4, 5, '47.29.3.118', '2017-03-23 11:52:56'),
(5, 5, '47.29.3.118', '2017-03-23 12:34:14'),
(6, 5, '47.29.3.118', '2017-03-23 12:37:00'),
(7, 5, '47.29.22.14', '2017-03-23 18:17:47'),
(8, 5, '47.29.22.14', '2017-03-23 19:07:50'),
(9, 5, '47.29.22.14', '2017-03-23 19:09:25'),
(10, 5, '103.215.226.216', '2017-04-02 11:05:08'),
(11, 5, '144.48.225.82', '2017-04-12 19:41:18'),
(12, 5, '144.48.225.82', '2017-04-13 22:22:05'),
(13, 5, '144.48.225.82', '2017-04-13 22:22:05'),
(14, 5, '144.48.225.82', '2017-04-13 23:45:36'),
(15, 5, '144.48.225.82', '2017-04-13 23:47:13'),
(16, 7, '144.48.225.82', '2017-04-14 00:04:54'),
(17, 5, '47.15.14.67', '2017-04-14 13:04:09'),
(18, 7, '144.48.225.1', '2017-04-19 17:18:54'),
(19, 7, '144.48.225.1', '2017-04-19 17:34:28'),
(20, 7, '144.48.225.1', '2017-04-19 17:43:22'),
(21, 5, '144.48.225.1', '2017-04-19 17:52:51'),
(22, 7, '144.48.225.1', '2017-04-19 17:53:37'),
(23, 7, '144.48.225.17', '2017-05-05 13:41:48'),
(24, 7, '47.15.1.205', '2017-05-26 15:41:39'),
(25, 7, '::1', '2018-08-15 20:50:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wryton_category`
--
ALTER TABLE `wryton_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `wryton_comment`
--
ALTER TABLE `wryton_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `wryton_favorite`
--
ALTER TABLE `wryton_favorite`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `wryton_liked`
--
ALTER TABLE `wryton_liked`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `wryton_post`
--
ALTER TABLE `wryton_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `wryton_user`
--
ALTER TABLE `wryton_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wryton_user_history`
--
ALTER TABLE `wryton_user_history`
  ADD PRIMARY KEY (`history_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wryton_category`
--
ALTER TABLE `wryton_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `wryton_comment`
--
ALTER TABLE `wryton_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `wryton_favorite`
--
ALTER TABLE `wryton_favorite`
  MODIFY `favorite_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wryton_liked`
--
ALTER TABLE `wryton_liked`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wryton_post`
--
ALTER TABLE `wryton_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `wryton_user`
--
ALTER TABLE `wryton_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wryton_user_history`
--
ALTER TABLE `wryton_user_history`
  MODIFY `history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;