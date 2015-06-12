-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 12:26 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_smifty`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) unsigned NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `address`) VALUES
(1, 1, 'adm1n', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL, NULL, NULL),
(2, 0, 'restaurant', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) unsigned NOT NULL,
  `cityname` varchar(30) DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `cityname`, `order`) VALUES
(1, 'Houston', 1),
(2, 'Austin', 2),
(3, 'Dallas', 3);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(35) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `notes` varchar(30) DEFAULT NULL,
  `address` text,
  `city` varchar(25) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `notes`, `address`, `city`, `state`, `country`, `zip`) VALUES
(1, 'testuser', '5f4dcc3b5aa765d61d8327deb882cf99', 'Shannn', 'Modelam', '245425', 'email@address.com', 'password', '123 Street', NULL, NULL, NULL, NULL),
(2, 'nashsaint', '5f4dcc3b5aa765d61d8327deb882cf99', 'nash', 'delos santos', '254', 'email@email.com', NULL, '', '', '', '', ''),
(3, 'Sample customer', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sample', 'Customer', '78867', 'email@address.com', NULL, '34 fsnto\r\nlh\r\nhk\r\n', '34 fsnto\r\nlh\r\nhk\r\n', 'State', 'country', 'Zip'),
(4, 'test1', '5a105e8b9d40e1329780d62ea2265d8a', 'test1', 'test1', '13', 'test1@test1.test1', NULL, 'test1', 'test1', 'test1', 'test1', '9000'),
(5, '123', '202cb962ac59075b964b07152d234b70', '', '123', '123', '123@1213.12', NULL, '123', '123', '123', '123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) unsigned NOT NULL,
  `foodname` varchar(50) DEFAULT NULL,
  `restaurant` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `vegetarian` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `foodname`, `restaurant`, `amount`, `availability`, `vegetarian`) VALUES
(4, 'Edamame', 2, 9.9, 1, NULL),
(17, 'Katsu', 1, 2, 1, 1),
(18, 'Hero Tuna', 1, 3, 1, 1),
(19, 'Hadok', 8, 4, 0, 0),
(20, 'howdy crow', 6, 2, 0, 0),
(21, 'Sandu', 10, 2, 1, 1),
(22, 'Hamburger', 11, 10.5, 1, 1),
(40, 'Beef Steak', 1, 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) unsigned NOT NULL,
  `orderid` varchar(50) DEFAULT NULL,
  `clientid` int(11) DEFAULT NULL,
  `foodid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `foodname` varchar(35) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `restaurant` varchar(25) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `dateordered` int(20) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=377 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderid`, `clientid`, `foodid`, `quantity`, `foodname`, `amount`, `restaurant`, `restaurant_id`, `dateordered`, `status`) VALUES
(348, '1433951293', 1, 18, 1, 'Hero Tuna', 3, NULL, 1, NULL, 'preparing'),
(349, '1433951293', 1, 17, 1, 'Katsu', 2, NULL, 1, NULL, 'preparing'),
(350, '1433951293', 1, 17, 1, 'Katsu', 2, NULL, 1, NULL, 'preparing'),
(352, '1433953503', 3, 18, 1, 'Hero Tuna', 3, NULL, 1, NULL, NULL),
(353, '1433953503', 3, 17, 1, 'Katsu', 2, NULL, 1, NULL, NULL),
(354, '1433953503', 3, 18, 1, 'Hero Tuna', 3, NULL, 1, NULL, NULL),
(371, '1434100428', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(372, '1434100428', 2, 40, 1, 'Beef Steak', 5, NULL, 1, NULL, NULL),
(373, '1434100428', 2, 18, 1, 'Hero Tuna', 3, NULL, 1, NULL, NULL),
(374, '1434100428', 2, 17, 1, 'Katsu', 2, NULL, 1, NULL, NULL),
(375, '1434100428', 2, 17, 1, 'Katsu', 2, NULL, 1, NULL, NULL),
(376, '1434100428', 2, 18, 1, 'Hero Tuna', 3, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `logo` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `url` varchar(25) DEFAULT NULL,
  `address` text,
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `user_id`, `name`, `city`, `logo`, `status`, `url`, `address`, `phone`, `email`) VALUES
(1, 2, 'Burger King', 1, 'burger-king.jpg', 1, 'burger-king', '123 Street RoadNational City P0ST C0D3', '1234566', 'burger@mail.com'),
(2, 0, 'Deltaco', 1, 'deltaco.jpg', 1, 'deltaco', '34535 building\nstreet number\npostcode\ncountry', '35636345', 'deltaco@mail.com'),
(3, 0, 'El Polo', 2, 'el-polo.jpg', 1, 'el-polo', NULL, NULL, 'elpoco@poco.mail.com'),
(4, 0, 'Hardees', 2, 'hardees.jpg', 1, 'hardees', NULL, NULL, 'mail@hardees.com'),
(5, 0, 'In N Out', 1, 'in-n-out.jpg', 1, 'in-n-out', NULL, NULL, 'innout@gmail.com'),
(6, 0, 'KFC', 1, 'kfc.jpg', 1, 'kfc', NULL, NULL, 'info@kfc.com'),
(7, 0, 'McDonalds', 1, 'mcdonalds.jpg', 1, 'mcdonalds', NULL, NULL, NULL),
(8, 0, 'Popeyes', 2, 'popeyes.jpg', 1, 'popeyes', NULL, NULL, NULL),
(9, 0, 'Sonic', 2, 'sonic.jpg', 1, 'sonic', NULL, NULL, NULL),
(10, 0, 'Subway', 1, 'subway.jpg', 1, 'subway', NULL, NULL, NULL),
(11, 0, 'Taco Bell', 3, 'taco-bell.jpg', 1, 'taco-bell', NULL, NULL, NULL),
(21, 0, 'test', 1, '', 0, '', 'asdfasdf', '234234', 'sdfsdaf@adf.com'),
(22, 0, 'testing', 3, '', 0, '', '234\nasdf\nsafd\nsadf\n', '2455', ''),
(23, 0, 'dfdfdfdfdf', 2, '', 0, '', 'sdfsdf', 'sdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL,
  `fieldname` varchar(25) DEFAULT NULL,
  `value` varchar(25) DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `fieldname`, `value`, `active`) VALUES
(1, 'currency', 'dollar', NULL),
(2, 'fb_url', 'http://facebook.com', 1),
(4, 'twit_url', 'http://twitter.com', 1),
(6, 'pint_url', 'http://pinterest.com', 1),
(8, 'google_url', 'http://plus.google.com', 1),
(10, 'sitename', NULL, NULL),
(11, 'copyright', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=377;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
