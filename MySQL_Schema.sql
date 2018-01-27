# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.1.63)
# Database: lptc
# Generation Time: 2017-12-02 15:40:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Activity`;

CREATE TABLE `Activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` text,
  `UserId` int(11) DEFAULT NULL,
  `Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CorrespondingId` int(11) DEFAULT NULL,
  `Type` tinytext,
  `Action` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table BeattCMSAnalytics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `BeattCMSAnalytics`;

CREATE TABLE `BeattCMSAnalytics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `accessToken` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Email
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Email`;

CREATE TABLE `Email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` tinytext,
  `Message` longtext,
  `Headers` mediumtext,
  `ReceiverId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Emails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Emails`;

CREATE TABLE `Emails` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(120) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Page_Edit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Page_Edit`;

CREATE TABLE `Page_Edit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Pages` mediumtext,
  `canSee` tinyint(1) DEFAULT NULL,
  `rankId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rankId` (`rankId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Pages`;

CREATE TABLE `Pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` tinytext,
  `Template` tinytext,
  `UserId` tinyint(4) DEFAULT NULL,
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Parent` int(11) DEFAULT NULL,
  `PageOrder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`Name`(120))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Posts`;

CREATE TABLE `Posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text,
  `content` longtext,
  `Tags` mediumtext,
  `UserId` tinyint(4) DEFAULT NULL,
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Premissons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Premissons`;

CREATE TABLE `Premissons` (
  `Name` tinytext,
  `Provider` mediumtext,
  `Description` mediumtext,
  `Inherited` tinytext,
  `Dissolves` tinyint(1) DEFAULT NULL,
  `Options` tinyint(1) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Ranks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Ranks`;

CREATE TABLE `Ranks` (
  `Name` varchar(120) NOT NULL DEFAULT '',
  `Premissons` mediumtext,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UserId` tinyint(4) DEFAULT NULL,
  `Enabled` tinyint(1) DEFAULT '1',
  `PreviousPermissons` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Settings`;

CREATE TABLE `Settings` (
  `Title` tinytext,
  `Description` mediumtext,
  `Theme` tinytext,
  `Header` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(256) NOT NULL,
  `Username` text,
  `HashedPassword` text NOT NULL,
  `AuthCode` tinytext,
  `Rank` smallint(6) DEFAULT NULL,
  `Description` longtext,
  `UserId` smallint(6) DEFAULT NULL,
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `RequestedRank` smallint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table Websites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Websites`;

CREATE TABLE `Websites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `URL` tinytext,
  `Description` mediumtext,
  `UserId` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
