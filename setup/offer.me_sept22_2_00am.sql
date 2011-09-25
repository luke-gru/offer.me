-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2011 at 04:57 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `offer_me_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` int(11) NOT NULL,
  `user_to_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `received` tinyint(1) NOT NULL,
  `regarding_post` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_from_id`, `user_to_id`, `type`, `received`, `regarding_post`) VALUES
(5, 33, 30, 'email', 1, 48),
(6, 33, 30, 'email', 1, 41),
(7, 30, 33, 'email', 1, 49),
(8, 34, 33, 'email', 1, 50),
(9, 33, 30, 'email', 1, 45),
(10, 33, 32, 'email', 0, 44),
(11, 35, 34, 'email', 1, 55);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'FK (users.id)',
  `want` tinyint(1) NOT NULL COMMENT 'bool',
  `title` varchar(150) NOT NULL,
  `content` varchar(900) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `want`, `title`, `content`, `time`) VALUES
(46, 30, 1, 'omg I need a caregiver montreal', 'OMG desperate need of a caregiver for Thursday, March 17th. ', '2011-09-21 18:59:52'),
(40, 30, 1, 'I want home repair!', 'omgomg my home is falling apart', '2011-09-21 12:15:41'),
(41, 30, 1, 'new offer', 'second offer', '2011-09-21 12:24:21'),
(42, 30, 1, 'new post', 'third post', '2011-09-21 12:28:55'),
(43, 30, 1, 'omg antoerht poooost', 'hallo', '2011-09-21 12:57:55'),
(44, 32, 1, 'I need cooking!!!', 'I need a cook. Will trade amazing 2 years of dog-walking experience.', '2011-09-21 13:57:06'),
(45, 30, 1, 'I really need a designer for a project', 'I really need a designer for a project I''m working on that has a lot of stuff.', '2011-09-21 15:06:01'),
(47, 30, 1, 'omg I need a caregiver montreal', 'omg i need one badly MONTREAL', '2011-09-21 19:02:32'),
(48, 30, 1, 'omg I need a caregiver montreal', 'thursday!', '2011-09-21 19:05:21'),
(49, 33, 1, 'need accounting in montreal', 'I need some accounting!!', '2011-09-21 23:47:46'),
(50, 33, 1, 'Need Montreal carpooling', 'I rly need carpooling will offer my great services.', '2011-09-22 04:07:15'),
(51, 33, 1, 'another post on carpooling', 'hey guys this is a repost just making sure my other post got through kthxbye', '2011-09-22 04:10:04'),
(52, 33, 1, 'respost', '2nd repost.', '2011-09-22 04:11:13'),
(53, 33, 1, 'respost', '3rd repost/', '2011-09-22 04:11:42'),
(54, 33, 1, 'need designer', 'in mtl', '2011-09-22 04:15:08'),
(55, 34, 1, 'need gardener in toronto', 'Need someone to do my gardening once a week in Toronto. Just managing the lawn, mowing the grass and making sure the flowers are OK.', '2011-09-22 04:20:36'),
(56, 33, 1, 'need good cook', 'in toronto', '2011-09-22 04:34:34'),
(57, 35, 1, 'need Montreal dogwalker', 'Can trade my amazing gardening experience.', '2011-09-22 04:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `post_details`
--

CREATE TABLE IF NOT EXISTS `post_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL COMMENT 'FK (posts.id)',
  `service_id` int(11) NOT NULL COMMENT 'FK (services.id)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `post_details`
--

INSERT INTO `post_details` (`id`, `post_id`, `service_id`) VALUES
(15, 40, 1),
(14, 39, 5),
(26, 51, 3),
(12, 38, 2),
(25, 50, 3),
(10, 37, 4),
(24, 49, 8),
(27, 52, 3),
(17, 41, 3),
(23, 48, 5),
(19, 42, 6),
(20, 43, 1),
(21, 44, 6),
(22, 45, 7),
(28, 53, 3),
(29, 54, 7),
(30, 55, 2),
(31, 56, 6),
(32, 57, 9);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'service name',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`) VALUES
(1, 'home_repair'),
(2, 'gardening'),
(3, 'carpooling_moving'),
(4, 'teaching'),
(5, 'care_giving'),
(6, 'cooking'),
(7, 'designing'),
(8, 'accounting'),
(9, 'dog_walking');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `country` text NOT NULL,
  `city` varchar(60) NOT NULL,
  `email` varchar(40) NOT NULL,
  `bio` varchar(600) NOT NULL COMMENT '600max',
  `encrypted_password` varchar(45) NOT NULL,
  `date_joined` date NOT NULL COMMENT 'date joined',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `country`, `city`, `email`, `bio`, `encrypted_password`, `date_joined`) VALUES
(28, 'other', 'us', 'philadelphia', 'omg', 'me', 'adccece39a0795801972604c8cf21a22bf45b262', '2011-09-19'),
(29, 'newuser', 'ca', 'montreal', 'new@user.com', 'my name is newuser', 'c2a6b03f190dfb2b4aa91f8af8d477a9bc3401dc', '2011-09-19'),
(30, 'lukedotgru', 'ca', 'montreal', 'luke.gru@gmail.com', 'yayy it''s me and now i can have '''''' apostrophes!', '46e374c930668150423ee1a3028f30fdd8486291', '2011-09-19'),
(32, 'shabbir', 'ca', 'montreal', 'shabloan@yahoo.ca', 'i like digs', '5bf1fd927dfb8679496a2e6cf00cbe50c1c87145', '2011-09-21'),
(33, 'anon', 'ca', 'montreal', 'anon@email.com', 'i''m a rlllly good designer OMGZLOZLJW', '46e374c930668150423ee1a3028f30fdd8486291', '2011-09-21'),
(34, 'demo', 'ca', 'toronto', 'demo@demo.com', 'Great teacher with 2 years of experience working abroad!', '46e374c930668150423ee1a3028f30fdd8486291', '2011-09-22'),
(35, 'amazing_user', 'ca', 'montreal', 'amazing_user@gmail.com', 'I''m a gardener and designer living in Montreal, Canada! I am amazing!', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2011-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `user_services`
--

CREATE TABLE IF NOT EXISTS `user_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'FK (users.id)',
  `service_id` int(11) NOT NULL COMMENT 'FK (services.id)',
  `offer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `user_services`
--

INSERT INTO `user_services` (`id`, `user_id`, `service_id`, `offer`) VALUES
(36, 28, 5, 1),
(37, 29, 2, 1),
(38, 29, 5, 1),
(39, 30, 1, 1),
(40, 30, 5, 1),
(41, 30, 9, 1),
(42, 31, 9, 1),
(43, 32, 9, 1),
(44, 33, 7, 1),
(45, 34, 4, 1),
(46, 35, 2, 1),
(47, 35, 7, 1);
