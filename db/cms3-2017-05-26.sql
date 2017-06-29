-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2017 at 06:55 PM
-- Server version: 5.6.36
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms3`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(250) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `email_content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `slug`, `subject`, `email_content`, `created`, `modified`) VALUES
(1, 'user_activate', 'User account activated', 'User account activated.', '2017-05-26 12:46:09', '2017-05-26 12:46:09'),
(2, 'user_deactivate', 'User account de-activated', 'User account de-activated', '2017-05-26 12:47:23', '2017-05-26 12:47:23'),
(3, 'change_password', 'User change password', 'User change password', '2017-05-26 12:48:16', '2017-05-26 12:48:16'),
(4, 'forgot_password', 'User forgot password', 'User forgot password', '2017-05-26 12:48:44', '2017-05-26 12:48:44'),
(5, 'reset_password', 'User password reset', 'User password reset', '2017-05-26 12:49:09', '2017-05-26 12:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `status_id` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `slug`, `status_id`) VALUES
(1, 'Admin', 'admin', 1),
(2, 'Sub Admin', 'sub_admin', 1),
(3, 'User', 'user', 1),
(4, 'Public', 'public', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_field` varchar(100) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  `created` datetime NOT NULL ,
  `modified` datetime NOT NULL ,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key_field`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_field`, `key_value`, `created`, `modified`) VALUES
(1, 'site_title', 'CMS3', '2017-05-26 08:26:15', '2017-05-26 16:14:50'),
(2, 'site_email', 'cms3@yopmail.com', '2017-05-26 08:26:33', '2017-05-26 16:14:59'),
(3, 'support_email', 'cms3@yopmail.com', '2017-05-26 10:43:15', '2017-05-26 10:43:15'),
(4, 'admin_page_limit', '10', '2017-05-26 10:44:31', '2017-05-26 11:32:33'),
(5, 'support_phone', '+91-9630214587', '2017-05-26 10:45:37', '2017-05-26 10:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `slug` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `title`, `slug`) VALUES
(1, 'Active', 'active'),
(2, 'Inactive', 'inactive'),
(3, 'Deleted', 'deleted');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(2) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `status_id` int(2) NOT NULL,
  `forgot_password_token` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `status_id`, `forgot_password_token`, `last_login`, `created`, `modified`) VALUES
(1, 1, 'krishan.mohan@yopmail.com', '$2y$10$90hTOIr5ltLLcJ/DSeltx.OsYeT.PfabUWveeVm7jzH35F9IRS.Sq', 'Krishan', 'Mohan', '9630125478', 1, NULL, NULL, '2017-05-01 07:48:48', '2017-05-26 11:58:00'),
(2, 3, 'krishan.kumar@yopmail.com', '$2y$10$ON8HoFXy/Zdj9bSKKggQWe0duWHrkKUl4Lmih9w85OFc.U2CNobpG', 'Krishan', 'Kumar', '8453546354', 2, 'MmZkNDg2YmI2ODU0NWI1NTY4YWRmNjhjOTZjOTJkZmYtYzgxZTcyOGQ5ZDRjMmY2MzZmMDY3Zjg5Y2MxNDg2MmM=', NULL, '2017-05-04 07:40:49', '2017-05-18 14:08:37'),
(3, 3, 'sushil.kumar@yopmail.com', '$2y$10$dOrF1AuHsG7R3Q133Y4EUuy3tIGykEtMuk9kvT9CIRFyzn0BvdM8e', 'Sushil', 'Kumar', '9874563210', 1, '', NULL, '2017-05-04 07:41:27', '2017-05-12 10:41:38'),
(4, 4, 'vishal.raj@yopmail.com', '$2y$10$ag.9pX1P3wCnyIbUgbpqFe9O9AIVB3H4oTENDI5JwaX8gpxMS4/y2', 'Vishal', 'Raj', '9632587410', 1, '', NULL, '2017-05-04 09:32:27', '2017-05-17 14:19:20'),
(5, 2, 'rohit.kumar@yopmail.com', '$2y$10$9qxzSF5uSVDLFiJ3qDEfTuGtNL1UI5VX5XWBSTt26cQSZ.wa.a/ja', 'Rohit', 'Kumar', '9087654132', 2, '', NULL, '2017-05-04 09:39:28', '2017-05-12 10:41:04'),
(6, 4, 'mohan.raj@yopmail.com', '$2y$10$.YetCPokdUvEEk8ThGUxNOryMaGNtyQcNphyrrNMZhzzjvJBKFQWe', 'Mohan', 'Ram', '9630215478', 1, NULL, NULL, '2017-05-16 13:18:11', '2017-05-17 14:18:31');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
