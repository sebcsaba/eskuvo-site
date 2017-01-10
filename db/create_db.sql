-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Hoszt: 10.0.0.27
-- Létrehozás ideje: 2017. jan. 10. 18:54
-- Szerver verzió: 5.5.31-0+wheezy1
-- PHP verzió: 5.4.45-0+deb7u3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `clusterone_hu_sebcsaba`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `wedding_list`
--

CREATE TABLE IF NOT EXISTS `wedding_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(160) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `verification_code` varchar(16) COLLATE utf8_hungarian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
