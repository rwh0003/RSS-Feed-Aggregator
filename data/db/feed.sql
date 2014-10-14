-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2014 at 04:25 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zf`
--

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `name` text NOT NULL,
  `url` text NOT NULL,
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `image` text,
  `ttl` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`name`, `url`, `id`, `image`, `ttl`) VALUES
('NYT', 'http://rss.nytimes.com/services/xml/rss/nyt/US.xml', 41, NULL, 600),
('UG', 'http://www.ultimate-guitar.com/modules/rss/all_updates.xml', 45, NULL, 666),
('Pitchfork', 'http://pitchfork.com/rss/reviews/albums/', 46, '', NULL),
('Washington Post', 'http://feeds.washingtonpost.com/rss/rss_fact-checker', 47, '', NULL),
('Nerdist', 'http://nerdist.libsyn.com/rss', 48, NULL, 24);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
