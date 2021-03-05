-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2021-03-05 10:24:05
-- 服务器版本： 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memo`
--

-- --------------------------------------------------------

--
-- 表的结构 `encrypted`
--

DROP TABLE IF EXISTS `encrypted`;
CREATE TABLE IF NOT EXISTS `encrypted` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `problem` varchar(100) NOT NULL COMMENT '密保问题',
  `answer` varchar(100) NOT NULL COMMENT '密保答案',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `encryption`
--

DROP TABLE IF EXISTS `encryption`;
CREATE TABLE IF NOT EXISTS `encryption` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT '' COMMENT '加密名称',
  `decrypt_name` varchar(50) NOT NULL COMMENT '对应的解密名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `secret`
--

DROP TABLE IF EXISTS `secret`;
CREATE TABLE IF NOT EXISTS `secret` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `describe` varchar(100) NOT NULL COMMENT '描述',
  `account` varchar(100) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '加密后的密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `secret`
--

INSERT INTO `secret` (`id`, `user_id`, `describe`, `account`, `password`) VALUES
(1, 1, '1', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `open_id` varchar(32) NOT NULL,
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱地址',
  `package` varchar(32) DEFAULT NULL COMMENT '加密套餐顺序',
  `command` int(4) DEFAULT NULL COMMENT '口令',
  `session_key` varchar(32) NOT NULL,
  `is_set` varchar(9) DEFAULT NULL COMMENT '.1.2.3.4.。1为口令、2为加密套餐、3为密保、4为邮箱 ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `open_id`, `email`, `package`, `command`, `session_key`, `is_set`) VALUES
(1, '123', NULL, NULL, NULL, '123', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
