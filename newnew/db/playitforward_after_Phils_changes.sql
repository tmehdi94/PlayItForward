-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2015 at 04:28 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(4, '1427251642'),
(10, '1428517006'),
(10, '1428966009');

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE IF NOT EXISTS `missions` (
`mid` int(11) NOT NULL COMMENT 'unique mission id',
  `title` varchar(255) NOT NULL COMMENT 'display title',
  `description` varchar(2000) NOT NULL COMMENT 'display description',
  `level` int(11) NOT NULL COMMENT 'Level of mission, which determines experience gain',
  `isReusable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'can mission be displayed multiple times to user. 1 for reusable. 0 for not reusable.'
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`mid`, `title`, `description`, `level`, `isReusable`) VALUES
(1, 'Reflect', 'Read this awesome article about how your body language can impact your personality. <a target=''_blank'' href=''http://www.askmen.com/grooming/project/top-10-ways-to-show-confidence-with-body-language.html''>Body Language</a>', 1, 0),
(2, 'Reflect', 'Read this cool article about the interaction between self-confidence and self-awareness! <a target=''_blank'' href=''http://www.counselingcenter.illinois.edu/self-help-brochures/self-awarenessself-care/self-confidence/''>Confidence</a>', 1, 0),
(3, 'Reflect Bonus', 'Find an interesting article about techniques for boosting confidence in social interactions', 2, 1),
(4, 'Say Cheese', 'Take a picture of yourself and name three physical features you like about yourself.', 2, 0),
(5, 'Reflect', 'Take a look at this article and see how you can be successful <a target=''_blank'' href=''http://www.mindtools.com/selfconf.html''>Prepare for Success</a>', 1, 0),
(6, 'Pat On The Back', 'Write down a list of things you like about yourself', 3, 0),
(7, 'Tough Crowd', 'Make a (good or bad) joke in front of at least one person', 5, 1),
(8, 'Lend a Hand', 'Help one of your friends with homework or a simple task', 6, 1),
(9, 'Show Off Those Pearly Whites', 'Smile at someone passing by', 4, 1),
(10, 'Connect', 'Make eye contact with someone passing by', 3, 1),
(11, 'Everyone''s Favorite', 'Cook or bake something to share', 7, 1),
(12, 'Power Pose', 'Ever heard of a power pose? Read this article about how they can change your life! <a target=''_blank'' href=''http://online.wsj.com/news/articles/SB10001424127887323608504579022942032641408''> Power Pose</a>', 2, 0),
(13, 'Pass It On', 'Compliment someone (make it genuine!)', 5, 1),
(14, 'Kick Back', 'Treat yourself to something', 4, 1),
(15, 'Narcissist', 'Look at yourself in a mirror for 3 minutes straight (and accept your flaws)', 2, 1),
(16, 'Meet and Greet', 'Say "hello"Â to a stranger', 5, 1),
(17, 'Master of Trades', 'Try out something new! Spend at least 2 hours working on a hobby you''ve never tried before!', 6, 1),
(18, 'New Horizons', 'Go to a meeting for a club or organization that you''re interested in', 8, 1),
(19, 'Strut', 'Walk around your neighborhood with your head up', 2, 1),
(20, 'Heart of Gold', 'Give change to a homeless person', 5, 1),
(21, 'Besties', 'Invite someone to do something with you and follow through', 8, 1),
(22, 'Leap of Faith', 'Do something you''ve been afraid to do', 9, 1),
(23, 'Class Act', 'Dress fancy for no reason', 3, 1),
(24, 'Stylist', 'Try something new with your hair', 5, 0),
(25, 'Give Back', 'Volunteer for something', 8, 1),
(26, 'Master of Creativity', 'Craft, make or build something', 4, 1),
(27, 'Green Thumb', 'Take care of a plant or plant a seed and help it grow', 3, 1),
(28, 'Date Night', 'Go for a night out (eat, watch a movie, etc.)', 5, 1),
(29, 'Step Up', 'Give food to a homeless person', 6, 1),
(30, 'Book Worm', 'Read a book recommended by someone and talk to them about it', 7, 1),
(31, 'Socialite', 'Call and talk to someone on the phone for at least 30 seconds', 6, 1),
(32, 'Smooth Talker', 'Start a conversation while waiting in line for something', 8, 1),
(33, 'Helping Hand', 'Offer to help a stranger in need', 7, 1),
(34, 'Branch Out', 'Speak in front of a group of people', 10, 1),
(35, 'Comedian', 'Make a purposely bad joke in front of at least 3 people', 9, 1),
(36, 'What Friends Are For', 'Talk to someone you trust about your insecurities', 10, 1),
(37, 'Practice Makes Person', 'Try your hardest not to compare yourself to others all day', 6, 1),
(38, 'Sharpen Your Skills', 'Take a class (exercise, cooking, drawing, etc.) for any length of time', 8, 0),
(39, 'Escape', 'Take a day trip and get a change of scenery for a day', 9, 1),
(40, 'Hermit', 'Don''t go on social media for 24 hours', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suggestedmissions`
--

CREATE TABLE IF NOT EXISTS `suggestedmissions` (
`id` int(11) NOT NULL COMMENT 'unique id',
  `uid` int(11) NOT NULL COMMENT 'key for user id',
  `suggestion` varchar(5000) NOT NULL COMMENT 'suggested mission'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`uid` int(11) NOT NULL COMMENT 'unique user ID',
  `username` varchar(255) NOT NULL COMMENT 'login and display name',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL COMMENT 'hashed password',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'URL to avatar - profile image',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT 'user level',
  `experience` int(11) NOT NULL DEFAULT '0' COMMENT 'user experience'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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
(9, 'Testuser5', 'Testuser5@test.com', '46f0d834f500ce62b57909df57d6a959e2e5b55150ffb7f62b7a6c8f8e486a555423230cfcda2d82cab077566af1b728733791af936a4f3a14d4eaf14f9e0933', 'f72f06d9135215ff9059a6d213587cbe5c25e24334a0ae028d41d6ec928a9a24899f68c9ebe35f08eda221d633e2060717dc78d7d21c0e0f7abf399145c60b6b', NULL, 0, 0),
(10, 'wattep', 'watterspm@gmail.com', '0014d151275e2e5502d7c092598d9351d76a908b16728760cc86da69ad8fe40baa09da6635b71b5180d4b2a459f9ec518c22fa5251f89b33f599acefb84b38dd', '4d00ea142ffe3421078974c37fc378f410657621d9f9b7a3db2d3ca1e6f2fcf4404263349cc2b9c2ffeed5fbb814e92e23dcf59e0320fd626f8416181c797536', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_assignedmissions`
--

CREATE TABLE IF NOT EXISTS `user_assignedmissions` (
`id` int(11) NOT NULL COMMENT 'unique identifier',
  `uid` int(11) NOT NULL COMMENT 'key to identify user id',
  `mid` int(11) NOT NULL COMMENT 'key to identify mission id',
  `assignDate` datetime DEFAULT NULL COMMENT 'date user is assigned mission'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_assignedmissions`
--

INSERT INTO `user_assignedmissions` (`id`, `uid`, `mid`, `assignDate`) VALUES
(4, 10, 1, '2015-04-13 20:37:56'),
(5, 10, 2, '2015-04-13 20:37:56'),
(6, 10, 3, '2015-04-13 20:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_completedmissions`
--

CREATE TABLE IF NOT EXISTS `user_completedmissions` (
`id` int(11) NOT NULL COMMENT 'unique identifier',
  `uid` int(11) NOT NULL COMMENT 'key to identify user id',
  `mid` int(11) NOT NULL COMMENT 'key to identify mission id',
  `assignDate` datetime DEFAULT NULL COMMENT 'date user is assigned mission',
  `completionDate` datetime DEFAULT NULL COMMENT 'datetime user completes mission',
  `journalTitle` varchar(5000) DEFAULT NULL COMMENT 'title of user submitted journal',
  `journalText` varchar(5000) DEFAULT NULL COMMENT 'text of user submitted journal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
 ADD PRIMARY KEY (`mid`), ADD UNIQUE KEY `mid_3` (`mid`), ADD KEY `mid` (`mid`), ADD KEY `mid_2` (`mid`);

--
-- Indexes for table `suggestedmissions`
--
ALTER TABLE `suggestedmissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`uid`), ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `user_assignedmissions`
--
ALTER TABLE `user_assignedmissions`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`), ADD KEY `uid_2` (`uid`), ADD KEY `mid` (`mid`);

--
-- Indexes for table `user_completedmissions`
--
ALTER TABLE `user_completedmissions`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`), ADD KEY `uid_2` (`uid`), ADD KEY `mid` (`mid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique mission id',AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `suggestedmissions`
--
ALTER TABLE `suggestedmissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique user ID',AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_assignedmissions`
--
ALTER TABLE `user_assignedmissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_completedmissions`
--
ALTER TABLE `user_completedmissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_completedmissions`
--
ALTER TABLE `user_completedmissions`
ADD CONSTRAINT `user_completedmissions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
ADD CONSTRAINT `user_completedmissions_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `missions` (`mid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
