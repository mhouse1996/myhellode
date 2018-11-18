-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Nov 2018 um 00:18
-- Server Version: 5.6.16
-- PHP-Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `myhellode`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `grants` int(2) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `fullname`, `email`, `usertype`, `grants`, `password`) VALUES
(1, 'admin', 'Aria Sabouri', 'admin@daroo.org', 'sales', 3, 'test'),
(2, 'test', 'Max Mustermann', 'test@test', 'sales', 1, 'test'),
(3, 'test2', 'Che Guevara', 'test@test', 'sales', 1, 'test'),
(4, 'test3', 'Karl Marx', 'test@test', 'service', 1, 'test'),
(5, 'test4', 'Johnny Depp', 'test@test', 'service', 1, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `breaktickets`
--

CREATE TABLE IF NOT EXISTS `breaktickets` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) DEFAULT NULL,
  `timeToken` varchar(255) DEFAULT NULL,
  `userType` varchar(255) NOT NULL,
  `estimatedBreakDuration` varchar(255) DEFAULT NULL,
  `beginningTime` varchar(5) NOT NULL,
  `endingTime` varchar(5) NOT NULL,
  `activity` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `breaktickets`
--

INSERT INTO `breaktickets` (`id`, `owner`, `timeToken`, `userType`, `estimatedBreakDuration`, `beginningTime`, `endingTime`, `activity`) VALUES
(10, NULL, NULL, 'sales', NULL, '00:00', '23:00', 1),
(11, NULL, NULL, 'sales', NULL, '00:00', '23:00', 1),
(18, '1', '1542581878', 'sales', 'short', '00:00', '23:59', 1),
(19, '5', '1542582881', 'service', 'long', '00:00', '23:59', 1),
(20, NULL, NULL, 'service', NULL, '00:00', '23:59', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `msgtype` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `msgcode` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Daten für Tabelle `logs`
--

INSERT INTO `logs` (`id`, `time`, `controller`, `msgtype`, `msg`, `user`, `msgcode`) VALUES
(16, 1542575831, 'BreakController', 'INFO', 'User admin(Aria Sabouri) ended break.', 1, 2),
(17, 1542575832, 'BreakController', 'INFO', 'User admin(Aria Sabouri) took break ticket 10', 1, 1),
(18, 1542575944, 'BreakAdminController', 'INFO', 'User admin(Aria Sabouri) released break ticket 10', 1, NULL),
(19, 1542575951, 'BreakController', 'INFO', 'User admin(Aria Sabouri) took break ticket 10', 1, 1),
(20, 1542579879, 'BreakController', 'INFO', 'User test3(Karl Marx) ended break.', 4, 2),
(21, 1542579879, 'BreakController', 'INFO', 'User admin(Aria Sabouri) did not unbreak. Auto-unbreak', 4, 3),
(22, 1542579879, 'BreakController', 'INFO', 'User test4(Johnny Depp) did not unbreak. Auto-unbreak', 4, 3),
(23, 1542579880, 'BreakController', 'INFO', 'User test3(Karl Marx) took break ticket 19', 4, 1),
(24, 1542579978, 'BreakController', 'INFO', 'User test3(Karl Marx) did not unbreak. Auto-unbreak', 5, 3),
(25, 1542579982, 'BreakController', 'INFO', 'User test4(Johnny Depp) took break ticket 19', 5, 1),
(26, 1542580340, 'BreakController', 'INFO', 'User test4(Johnny Depp) did not unbreak. Auto-unbreak', 5, 3),
(27, 1542581095, 'BreakController', 'INFO', 'User admin(Aria Sabouri) took break ticket 18', 1, 1),
(28, 1542581840, 'BreakAdminController', 'INFO', 'User admin(Aria Sabouri) released break ticket 18', 1, NULL),
(29, 1542581878, 'BreakController', 'INFO', 'User admin(Aria Sabouri) took break ticket 18', 1, 1),
(30, 1542582881, 'BreakController', 'INFO', 'User test4(Johnny Depp) took break ticket 19', 5, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navbar`
--

CREATE TABLE IF NOT EXISTS `navbar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `securityLevel` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `navbar`
--

INSERT INTO `navbar` (`id`, `link`, `name`, `securityLevel`) VALUES
(1, 'breaksystem', 'Pausensystem', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
