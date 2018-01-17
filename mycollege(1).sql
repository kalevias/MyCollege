-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 17, 2018 at 06:52 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycollege`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcountry`
--

DROP TABLE IF EXISTS `tblcountry`;
CREATE TABLE IF NOT EXISTS `tblcountry` (
  `pkcountryid` int(3) NOT NULL AUTO_INCREMENT,
  `idiso` varchar(2) NOT NULL,
  `nmname` varchar(80) NOT NULL,
  `idphonecode` int(5) NOT NULL,
  PRIMARY KEY (`pkcountryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblnotification`
--

DROP TABLE IF EXISTS `tblnotification`;
CREATE TABLE IF NOT EXISTS `tblnotification` (
  `pknotificationid` int(10) NOT NULL AUTO_INCREMENT,
  `enlevel` enum('Notification','Warning','Error') NOT NULL,
  `txdescription` varchar(50) NOT NULL,
  `fkuserid` int(10) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pknotificationid`),
  KEY `fkuserid` (`fkuserid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblpermission`
--

DROP TABLE IF EXISTS `tblpermission`;
CREATE TABLE IF NOT EXISTS `tblpermission` (
  `pkpermissionid` int(10) NOT NULL AUTO_INCREMENT,
  `nmname` varchar(20) NOT NULL,
  `txdescription` varchar(200) NOT NULL,
  PRIMARY KEY (`pkpermissionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprovince`
--

DROP TABLE IF EXISTS `tblprovince`;
CREATE TABLE IF NOT EXISTS `tblprovince` (
  `pkstateid` int(10) NOT NULL AUTO_INCREMENT,
  `idiso` varchar(2) NOT NULL,
  `nmname` varchar(64) NOT NULL,
  `fkcountryid` int(3) NOT NULL,
  PRIMARY KEY (`pkstateid`),
  KEY `fkcountryid` (`fkcountryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `pkuserid` int(10) NOT NULL AUTO_INCREMENT,
  `nmfirst` varchar(20) NOT NULL,
  `nmlast` varchar(20) NOT NULL,
  `txemail` varchar(40) NOT NULL,
  `txemailalt` varchar(40) DEFAULT NULL,
  `txstreetaddress` varchar(50) NOT NULL,
  `txcity` varchar(20) NOT NULL,
  `fkprovinceid` int(10) NOT NULL,
  `nzip` int(5) NOT NULL,
  `nphone` int(10) NOT NULL,
  `dtgradyear` year(4) NOT NULL,
  `txhash` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pkuserid`),
  KEY `fkprovinceid` (`fkprovinceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbluserpermissions`
--

DROP TABLE IF EXISTS `tbluserpermissions`;
CREATE TABLE IF NOT EXISTS `tbluserpermissions` (
  `fkpermissionid` int(10) NOT NULL,
  `fkuserid` int(10) NOT NULL,
  KEY `fkpermissionid` (`fkpermissionid`),
  KEY `fkuserid` (`fkuserid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblnotification`
--
ALTER TABLE `tblnotification`
  ADD CONSTRAINT `tblnotification_ibfk_1` FOREIGN KEY (`fkuserid`) REFERENCES `tbluser` (`pkuserid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblprovince`
--
ALTER TABLE `tblprovince`
  ADD CONSTRAINT `tblprovince_ibfk_1` FOREIGN KEY (`fkcountryid`) REFERENCES `tblprovince` (`pkstateid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD CONSTRAINT `tbluser_ibfk_1` FOREIGN KEY (`fkprovinceid`) REFERENCES `tblprovince` (`pkstateid`) ON UPDATE CASCADE;

--
-- Constraints for table `tbluserpermissions`
--
ALTER TABLE `tbluserpermissions`
  ADD CONSTRAINT `tbluserpermissions_ibfk_1` FOREIGN KEY (`fkpermissionid`) REFERENCES `tblpermission` (`pkpermissionid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbluserpermissions_ibfk_2` FOREIGN KEY (`fkuserid`) REFERENCES `tbluser` (`pkuserid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
