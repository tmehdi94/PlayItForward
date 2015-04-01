-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2015 at 08:09 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `playitforward`
--

-- --------------------------------------------------------

--
-- Table structure for table `levelup`
--

CREATE TABLE IF NOT EXISTS `levelup` (
  `currentLevel` int(11) NOT NULL COMMENT 'current level of user',
  `experienceReqd` int(11) NOT NULL COMMENT 'experience needed to level up'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `uid` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`uid`, `time`) VALUES
(4, '1427251642');

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE IF NOT EXISTS `missions` (
  `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique mission id',
  `title` varchar(255) NOT NULL COMMENT 'display title',
  `desc` varchar(2000) NOT NULL COMMENT 'display description',
  `experience` int(11) NOT NULL COMMENT 'experience rewarded to user on completion',
  `isReusable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'can mission be displayed multiple times to user',
  PRIMARY KEY (`mid`),
  UNIQUE KEY `mid_3` (`mid`),
  KEY `mid` (`mid`),
  KEY `mid_2` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usermissions`
--

CREATE TABLE IF NOT EXISTS `usermissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `uid` int(11) NOT NULL COMMENT 'key to identify user id',
  `mid` int(11) NOT NULL COMMENT 'key to identify mission id',
  `isAccepted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'has user accepted mission',
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'has user completed mission',
  `acceptDate` date DEFAULT NULL COMMENT 'date user accepts mission',
  `completionDate` date DEFAULT NULL COMMENT 'date user completes mission',
  `journalTitle` varchar(5000) DEFAULT NULL COMMENT 'title of user submitted journal',
  `journalText` varchar(5000) DEFAULT NULL COMMENT 'text of user submitted journal',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `uid_2` (`uid`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique user ID',
  `username` varchar(255) NOT NULL COMMENT 'login and display name',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL COMMENT 'hashed password',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'URL to avatar - profile image',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT 'user level',
  `experience` int(11) NOT NULL DEFAULT '0' COMMENT 'user experience',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `password`, `salt`, `avatar`, `level`, `experience`) VALUES
(1, 'test_user', 'test@example.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', 'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef', NULL, 0, 0),
(4, 'testuser', 'testuser@yopmail.com', 'e988b301891fc24d93d1988d8f26e74dfea0f0474c34125be045a9797a6ab0c22762725f0a34a77461644330ee64fdad2c2aaa20fb515f86119135f634d18c48', 'd8628289be723340e47f7eedd53ed7bf1b0e38b79c553e96c27fd685b6f396a0da539515084dfae362c93ef55cfd2aaa8f2a8dcdfcda66d399a4bee1100a23e4', NULL, 0, 0),
(5, 'Testuser2', 'testuser2@yopmail.com', 'c15fa098c152817f8035046b4d5532a268d6ab217aad30c47f7340d6087d0c03c578d7cee0c0e95f0ab1742e01521ec5cf0c646ab3ae531b87d12e02db77cd73', '3b41b34e7ae2a15b83f8b9851b61490aa4335bd23474c9f8a19e4b0fc71d2fb431a06e3ef82c33210dd8233adcf7c9292a7ebcaf505f0770bc90f425cd724d61', NULL, 0, 0),
(6, 'Testuser3', 'Testuser3@test.com', 'c5fe1d3a3678c7d7648feaa721ecff963d07a87c2a058094ff77725ec0b05f837c28a5088083ae7638298e3fd8966cc9eb023c7404987edffe2b55ccbb2526cb', '455a82cec641af88cd4b16807dcc9ba3e8d7ce980e0ce1ee5dc866b9aeeefbeac033a712ae25ff4e61c3ba33fa05806bf541a4ebc81929205b1e2542b45b316d', NULL, 0, 0),
(7, 'HasanIsHasan', 'HasanIsHasan@hasan.com', 'f29e90b7280124c1ff10553f0c0c9884e173a2ca062cc36b039e6a4ad495a15f98aed3e651d8c1ec0fa09fbabd8f9ea98b7b3c672730fdd74c0df633c333f444', '621b190783cde21a9a90c50a39722dda4569ebd1546d72e4d3d9a58cb203ce5348c7339950f3b639d990ad44ac8b831e3d8e746ed19f5ea11e70356329ebf1a5', NULL, 0, 0),
(8, 'Testuser4', 'Testuser4@test.com', 'a3549b1a1519b856f03a5eab9f8d6a157c736c469dc1e938315234b19fefbceb9aa388deac263fe19fb5c91fa0369d88113f5e207631233e29d28ee6494e8f32', '04d4d2c7cc4d83c5fec23139ace8fa8093c45d766a6a78607325895d4ee5ec3575ef574a3b77201afd1c1fdf16d0229845f314e19153489d4ba326ad208f7443', NULL, 0, 0),
(9, 'Testuser5', 'Testuser5@test.com', '46f0d834f500ce62b57909df57d6a959e2e5b55150ffb7f62b7a6c8f8e486a555423230cfcda2d82cab077566af1b728733791af936a4f3a14d4eaf14f9e0933', 'f72f06d9135215ff9059a6d213587cbe5c25e24334a0ae028d41d6ec928a9a24899f68c9ebe35f08eda221d633e2060717dc78d7d21c0e0f7abf399145c60b6b', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usersuggestedmissions`
--

CREATE TABLE IF NOT EXISTS `usersuggestedmissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id',
  `uid` int(11) NOT NULL COMMENT 'key for user id',
  `suggestion` varchar(5000) NOT NULL COMMENT 'suggested mission',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usermissions`
--
ALTER TABLE `usermissions`
  ADD CONSTRAINT `usermissions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `usermissions_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `missions` (`mid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
