-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2014 at 02:25 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `animal`
--
CREATE DATABASE IF NOT EXISTS `animal` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `animal`;

-- --------------------------------------------------------

--
-- Table structure for table `adoptionrequest`
--

CREATE TABLE IF NOT EXISTS `adoptionrequest` (
  `adoptionid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `animalid` int(11) NOT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`adoptionid`),
  KEY `userid` (`userid`),
  KEY `animalid` (`animalid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `adoptionrequest`
--

INSERT INTO `adoptionrequest` (`adoptionid`, `userid`, `animalid`, `approved`) VALUES
(1, 3, 1, NULL),
(2, 3, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE IF NOT EXISTS `animal` (
  `animalid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`animalid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animalid`, `name`, `dob`, `description`, `photo`, `available`) VALUES
(1, 'Hammy', '2010-01-05', 'Hammy is a friendly hamster that likes to run around her enclosure', 'hammy.jpg', 0),
(2, 'Star', '2010-01-05', 'Star was born in the same litter as Hammy, but they do not get on. Star squeels a lot when fighting and goads her sister into misbehaving.', 'star.jpg', 0),
(3, 'Peter', '2008-10-01', 'Peter is an awesome bunny, she cannot be allowed with others though as she is allergic to all vaccinations. She will destroy the world given half a chance', 'Peter.jpg', 0),
(4, 'angus', '2013-03-12', 'Angus is the bunny the place is named after, he is a lovely chap, but frightened of his own shadow.', 'angus.jpg', 0),
(5, 'Cottontale', '2012-03-12', 'Cottontale is a bunny mastermind, she knows how to break chicken wire and is not afraid to use it', 'Cottontale.jpg', 1),
(6, 'flopsy', '2012-03-12', 'Flopsy was originally thought to be a girl, but the kittens he produced with Cottontale say otherwise', 'flopsy.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `owns`
--

CREATE TABLE IF NOT EXISTS `owns` (
  `userid` int(11) NOT NULL,
  `animalid` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`animalid`),
  KEY `animalid` (`animalid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owns`
--

INSERT INTO `owns` (`userid`, `animalid`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `staff` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `staff`) VALUES
(1, 'staff', 'test', 'k.samperi@aston.ac.u', 1),
(2, 'user1', 'user1', 'k.samperi@cs.bham.ac', 0),
(3, 'user2', 'user2', 'k.samperi@cs.bham.ac', 0),
(4, 'user3', 'user3', 'k.samperi@cs.bham.ac', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoptionrequest`
--
ALTER TABLE `adoptionrequest`
  ADD CONSTRAINT `adoptionrequest_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `adoptionrequest_ibfk_2` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`);

--
-- Constraints for table `owns`
--
ALTER TABLE `owns`
  ADD CONSTRAINT `owns_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `owns_ibfk_2` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
