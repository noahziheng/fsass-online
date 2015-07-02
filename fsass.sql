-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2015 at 03:38 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fsass`
--

-- --------------------------------------------------------

--
-- Table structure for table `fsass_airports`
--

CREATE TABLE IF NOT EXISTS `fsass_airports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `text` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`,`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `fsass_airports`
--

INSERT INTO `fsass_airports` (`id`, `code`, `text`) VALUES
(1, 'ZBAA', '北京 - 首都'),
(2, 'ZSPD', '上海 - 浦东'),
(3, 'ZSSS', '上海 - 虹桥'),
(4, 'ZUGY', '贵阳 - 龙洞堡'),
(5, 'ZUUU', '成都 - 双流'),
(6, 'VHHH', '香港 - 赤腊角'),
(7, 'ZBTJ', '天津 - 滨海'),
(8, 'ZUCK', '重庆 - 江北'),
(9, 'ZSAM', '厦门 - 高崎'),
(10, 'ZYTX', '沈阳 - 桃仙'),
(12, 'ZGGG', '广州 - 白云');

-- --------------------------------------------------------

--
-- Table structure for table `fsass_route`
--

CREATE TABLE IF NOT EXISTS `fsass_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dep` varchar(4) NOT NULL,
  `arr` varchar(4) NOT NULL,
  `route` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `submittime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submittime` (`submittime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `fsass_route`
--

INSERT INTO `fsass_route` (`id`, `dep`, `arr`, `route`, `status`, `submittime`, `uid`) VALUES
(1, 'ZBAA', 'ZSPD', 'LADIX V31 YQG W142 DALIM A593 DPX A470 DALNU W166 ZJ W167 SASAN', 1, '2015-07-01 13:27:47', 1),
(3, 'ZBAA', 'ZSSS', 'LADIX V31 YQG W142 DALIM A593 DPX A470 DALNU W166 ZJ W167 SASAN', 1, '2015-07-01 14:40:11', 1),
(5, 'ZBAA', 'ZUGY', 'RENOB G212 LARAD B458 WXI A461 WHA A581 MEMAG', 1, '2015-07-01 14:43:13', 1),
(6, 'ZSPD', 'ZBAA', 'PIKAS G330 PIMOL A593 VYK', 1, '2015-07-02 02:02:53', 1),
(9, 'ZBAA', 'ZGGG', 'RENOB G212 LARAD B458 WXI A461 LIG R473 BEMAG V5 ATAGA', 1, '2015-07-02 12:33:41', 1),
(11, 'ZGGG', 'ZBAA', 'YIN A461 VYK', 1, '2015-07-02 12:47:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fsass_users`
--

CREATE TABLE IF NOT EXISTS `fsass_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `vatlevel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fsass_users`
--

INSERT INTO `fsass_users` (`id`, `pid`, `name`, `password`, `level`, `vatlevel`) VALUES
(1, 1248613, 'Ziheng Gao', '3dc011d26be0a9d2f2e974eb94ea4113', 1, 'Senior Student'),
(2, 0, 'Chang Ma', '', 0, ''),
(3, 0, 'Mingyu Chang', '', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
