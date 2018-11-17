-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Nov 2018 um 23:34
-- Server-Version: 10.1.16-MariaDB
-- PHP-Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `myhellode`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accounts`
--

CREATE TABLE `accounts` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `grants` int(2) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `fullname`, `email`, `usertype`, `grants`, `password`) VALUES
(1, 'admin', 'Aria Sabouri', 'admin@daroo.org', 'sales', 3, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `breaktickets`
--

CREATE TABLE `breaktickets` (
  `id` int(255) NOT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `timeToken` varchar(255) DEFAULT NULL,
  `userType` varchar(255) NOT NULL,
  `estimatedBreakDuration` varchar(255) DEFAULT NULL,
  `beginningTime` varchar(5) NOT NULL,
  `endingTime` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `breaktickets`
--

INSERT INTO `breaktickets` (`id`, `owner`, `timeToken`, `userType`, `estimatedBreakDuration`, `beginningTime`, `endingTime`) VALUES
(1, NULL, NULL, 'sales', NULL, '20:00', '21:00'),
(2, NULL, NULL, 'sales', NULL, '00:00', '23:59'),
(3, NULL, NULL, 'sales', NULL, '21:15', '22:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `securityLevel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `navbar`
--

INSERT INTO `navbar` (`id`, `link`, `name`, `securityLevel`) VALUES
(1, 'breaksystem', 'Pausensystem', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `breaktickets`
--
ALTER TABLE `breaktickets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `breaktickets`
--
ALTER TABLE `breaktickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
