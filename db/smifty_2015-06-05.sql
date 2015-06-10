# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.17)
# Database: smifty
# Generation Time: 2015-06-05 06:14:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; 
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin` int(11) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;

INSERT INTO `admin` (`id`, `admin`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `address`)
VALUES
	(1,1,'adm1n','5f4dcc3b5aa765d61d8327deb882cf99',NULL,NULL,NULL,NULL,NULL),
	(2,0,'restaurant','5f4dcc3b5aa765d61d8327deb882cf99',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cityname` varchar(30) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;

INSERT INTO `city` (`id`, `cityname`, `order`)
VALUES
	(1,'Houston',1),
	(2,'Austin',2),
	(3,'Dallas',3);

/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `zip` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;

INSERT INTO `clients` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `notes`, `address`, `city`, `state`, `country`, `zip`)
VALUES
	(1,'testuser','5f4dcc3b5aa765d61d8327deb882cf99','Shannn','Modelam','245425','email@address.com','password','123 Street',NULL,NULL,NULL,NULL),
	(2,'nashsaint','5f4dcc3b5aa765d61d8327deb882cf99','nash','delos santos','254','email@email.com',NULL,'','','','','');

/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table food
# ------------------------------------------------------------

DROP TABLE IF EXISTS `food`;

CREATE TABLE `food` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `foodname` varchar(50) DEFAULT NULL,
  `restaurant` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `vegetarian` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;

INSERT INTO `food` (`id`, `foodname`, `restaurant`, `amount`, `availability`, `vegetarian`)
VALUES
	(4,'Edamame',2,9.9,1,NULL),
	(17,'Katsu',1,2,1,1),
	(18,'Hero Tuna',1,3,1,1),
	(19,'Hadok',8,4,0,0),
	(20,'howdy crow',6,2,0,0),
	(21,'Sandu',10,2,1,1),
	(22,'Hamburger',11,10.5,1,1);

/*!40000 ALTER TABLE `food` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` varchar(50) DEFAULT NULL,
  `clientid` int(11) DEFAULT NULL,
  `foodid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `foodname` varchar(35) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `restaurant` varchar(25) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `dateordered` int(20) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `orderid`, `clientid`, `foodid`, `quantity`, `foodname`, `amount`, `restaurant`, `restaurant_id`, `dateordered`, `status`)
VALUES
	(290,'1433375737',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL),
	(291,'1433375737',NULL,18,NULL,'Hero Tuna',3,NULL,NULL,NULL,NULL),
	(292,'1433375737',NULL,17,NULL,'Katsu',2,NULL,NULL,NULL,NULL),
	(293,'1433378133',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(294,'1433459589',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(295,'1433459589',NULL,18,NULL,'Hero Tuna',3,NULL,NULL,NULL,NULL),
	(296,'1433459589',NULL,17,NULL,'Katsu',2,NULL,NULL,NULL,NULL),
	(297,'1433459589',NULL,18,NULL,'Hero Tuna',3,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table restaurant
# ------------------------------------------------------------

DROP TABLE IF EXISTS `restaurant`;

CREATE TABLE `restaurant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `logo` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `url` varchar(25) DEFAULT NULL,
  `address` text,
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `restaurant` WRITE;
/*!40000 ALTER TABLE `restaurant` DISABLE KEYS */;

INSERT INTO `restaurant` (`id`, `name`, `city`, `logo`, `status`, `url`, `address`, `phone`, `email`)
VALUES
	(1,'Burger King','1','burger-king.jpg',1,'burger-king','123 Street Road\nNational City\nP0ST C0D3','1234566','burger@mail.com'),
	(2,'Deltaco','1','deltaco.jpg',1,'deltaco','34535 building\nstreet number\npostcode\ncountry','35636345','deltaco@mail.com'),
	(3,'El Polo','2','el-polo.jpg',1,'el-polo',NULL,NULL,'elpoco@poco.mail.com'),
	(4,'Hardees','2','hardees.jpg',1,'hardees',NULL,NULL,'mail@hardees.com'),
	(5,'In N Out','1','in-n-out.jpg',1,'in-n-out',NULL,NULL,'innout@gmail.com'),
	(6,'KFC','1','kfc.jpg',1,'kfc',NULL,NULL,'info@kfc.com'),
	(7,'McDonalds','1','mcdonalds.jpg',1,'mcdonalds',NULL,NULL,NULL),
	(8,'Popeyes','2','popeyes.jpg',1,'popeyes',NULL,NULL,NULL),
	(9,'Sonic','2','sonic.jpg',1,'sonic',NULL,NULL,NULL),
	(10,'Subway','1','subway.jpg',1,'subway',NULL,NULL,NULL),
	(11,'Taco Bell','3','taco-bell.jpg',1,'taco-bell',NULL,NULL,NULL),
	(12,'Wendys','3','wendys.jpg',1,'wendys',NULL,NULL,NULL),
	(14,'TEst','tes',NULL,NULL,NULL,'asdf','asdf',NULL),
	(15,'TEst','tes',NULL,NULL,NULL,'asdf','asdf',NULL),
	(16,'TEst','tes',NULL,NULL,NULL,'asdf','asdf',NULL),
	(17,'asdf','asdf',NULL,NULL,NULL,'asdf','sdf',NULL),
	(18,'asdf','asdf',NULL,NULL,NULL,'asdf','sdf',NULL),
	(19,'asdf','asdf',NULL,NULL,NULL,'asdf','sdf',NULL),
	(20,'asdf','asdf',NULL,NULL,NULL,'asdf','sdf',NULL);

/*!40000 ALTER TABLE `restaurant` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldname` varchar(25) DEFAULT NULL,
  `value` varchar(25) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `fieldname`, `value`, `active`)
VALUES
	(1,'currency','&pound;',NULL),
	(2,'fb_url','http://facebook.com',1),
	(4,'twit_url','http://twitter.com',1),
	(6,'pint_url','http://pinterest.com',NULL),
	(8,'google_url','http://plus.google.com',1),
	(10,'sitename',NULL,NULL),
	(11,'copyright',NULL,NULL);

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
