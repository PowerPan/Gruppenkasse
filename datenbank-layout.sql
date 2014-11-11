-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. November 2014 um 19:29
-- Server Version: 5.1.44
-- PHP-Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `gruppenkasse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE IF NOT EXISTS `benutzer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `vorname` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `passwort_md5` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gruppe`
--

CREATE TABLE IF NOT EXISTS `gruppe` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transaktionen`
--

CREATE TABLE IF NOT EXISTS `transaktionen` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `beschreibung` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `betrag` double NOT NULL,
  `einzelsumme` double NOT NULL,
  `benutzer_id` int(10) NOT NULL,
  `gruppe_id` int(10) NOT NULL,
  `save_datum` datetime NOT NULL,
  `typ` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ver_benutzer_gruppe`
--

CREATE TABLE IF NOT EXISTS `ver_benutzer_gruppe` (
  `benutzer_id` int(10) NOT NULL,
  `gruppe_id` int(10) NOT NULL,
  `von` date DEFAULT NULL,
  `bis` date DEFAULT NULL,
  `kontostand` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ver_transaktion_benutzer`
--

CREATE TABLE IF NOT EXISTS `ver_transaktion_benutzer` (
  `transaktion_id` int(10) NOT NULL,
  `benutzer_id` int(10) NOT NULL,
  PRIMARY KEY (`transaktion_id`,`benutzer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
