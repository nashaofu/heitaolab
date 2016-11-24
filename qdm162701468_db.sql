-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- 主机: qdm162701468.my3w.com
-- 生成日期: 2016-07-16 16:52:26
-- 服务器版本: 5.1.48-log
-- PHP 版本: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `qdm162701468_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(120) DEFAULT NULL COMMENT '标题',
  `Status` varchar(20) NOT NULL DEFAULT 'draft' COMMENT '文章状态',
  `Input` varchar(120) DEFAULT NULL COMMENT '输入运动',
  `Output` varchar(120) DEFAULT NULL COMMENT '输出运动',
  `Tag` varchar(256) DEFAULT NULL COMMENT '标签',
  `Summary` varchar(500) DEFAULT NULL COMMENT '概述',
  `Example` varchar(5000) DEFAULT NULL COMMENT '实例',
  `Body` mediumtext COMMENT '正文',
  `Comments` mediumtext COMMENT '评论',
  `HitCount` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `Carousel` varchar(256) DEFAULT NULL COMMENT '首页轮播展示',
  `Time` datetime DEFAULT NULL COMMENT '发布时间',
  `Publisher` bigint(15) unsigned DEFAULT NULL COMMENT '发布者',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站文章存储表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`ID`, `Title`, `Status`, `Input`, `Output`, `Tag`, `Summary`, `Example`, `Body`, `Comments`, `HitCount`, `Carousel`, `Time`, `Publisher`) VALUES
(1, '反向双曲柄机构', 'publish', 'R', 'R1,R2', 'R-R1,R-R2', '连杆与机架的长度相等且两曲柄长度相等、曲柄转向相反的双曲柄机构。', '反向双曲柄机构->http://www.heitaolab.com/uploads/image/20160516/121.png', '&lt;h1&gt;反向双曲柄机构&lt;/h1&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;连杆与机架的长度相等且两曲柄长度相等、曲柄转向相反的双曲柄机构为反向双曲柄机构。该机构无死点位置，无急回特性&lt;/span&gt;&lt;br /&gt;\r\n&lt;span style=&quot;font-family:黑体&quot;&gt;运动特点&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;：以长边为机架时，双曲柄的回转方向相反；以短边为机架时，双曲柄回转方向相同，两种情况下曲柄角速度均不等。&lt;/span&gt;&lt;br /&gt;\r\n&lt;span style=&quot;font-family:黑体&quot;&gt;&lt;strong&gt;应用实例&lt;/strong&gt;&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;：汽车门启闭系统&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/121.png&quot; style=&quot;height:530px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输入曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;曲柄角位移&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/1_2.png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输入曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;曲柄角速度&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/2_1.png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输入曲柄角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;输入曲柄角速度&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/3.png&quot; style=&quot;height:240px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输出曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;输出曲柄角位移&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/4.png&quot; style=&quot;height:242px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输出曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;输出曲柄角速度&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/5.png&quot; style=&quot;height:238px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输出曲柄角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;输出曲柄角加速度&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/6.png&quot; style=&quot;height:241px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输出曲柄角位移相对于输入曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/7.png&quot; style=&quot;height:243px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;h1&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;平行四边形机构和反平行四边形机构&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;在双曲柄机构中，若两对边构件长度相等且平行，则称为正平行四边形机构。&lt;br /&gt;\r\n在双曲柄机构你中，连杆与机架的长度相等，两个曲柄的长度相等且转向相反，则称反平行四边形机构。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', NULL, 168, 'http://www.heitaolab.com/uploads/image/20160516/FanPingXingSiBianXing.png', '2016-05-17 08:55:14', 10000),
(2, '曲柄摇杆机构', 'publish', 'R', 'R5', 'R-R5', '具有一个曲柄和一个摇杆的铰链四杆机构称为曲柄摇杆机构。通常，曲柄为主动件且等速转动，而摇杆为从动件作变速往返摆动，连杆作平面复合运动。曲柄摇杆机构中也有用摇杆作为主动构件，摇杆的往复摆动转换成曲柄的转动。曲柄摇杆机构是四杆机构最基本的形式。', '搅拌机->http://www.heitaolab.com/uploads/image/20160516/4c1bc1cc500185eaf5bfa.gif', '&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;中文名称：曲柄摇杆机构；&lt;br /&gt;\r\n英文名称：crankrockermechanism；&lt;br /&gt;\r\n定义：具有一个曲柄和一个摇杆的铰链四杆机构称为曲柄摇杆机构。通常，曲柄为主动件且等速转动，而摇杆为从动件作变速往返摆动，连杆作平面复合运动。曲柄摇杆机构中也有用摇杆作为主动构件，摇杆的往复摆动转换成曲柄的转动。曲柄摇杆机构是四杆机构最基本的形式。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;在本文中主要讲曲柄作为输入摇杆作为输出时的情况。运动形式如下所示。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/1.gif&quot; style=&quot;height:389px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;曲柄摇杆机构如下所示&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/.png&quot; style=&quot;height:508px; width:512px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_1.png&quot; style=&quot;height:225px; width:512px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_2.png&quot; style=&quot;height:241px; width:512px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;曲柄角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_3.png&quot; style=&quot;height:222px; width:512px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;摇杆角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_4.png&quot; style=&quot;height:239px; width:512px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;摇杆角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_5.png&quot; style=&quot;height:237px; width:512px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;摇杆角角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_6.png&quot; style=&quot;height:238px; width:512px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;摇杆相对于曲柄的角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_7.png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;应用举例：牛头刨床进给机构、雷达调整机构、缝纫机脚踏机构、复摆式腭式破碎机、钢材输送机、搅拌机等。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', NULL, 104, 'http://www.heitaolab.com/uploads/image/20160516/1.png', '2016-05-16 09:29:44', 10000),
(3, '平行双曲柄机构', 'publish', 'R', 'R1,R2', 'R-R1,R-R2', '平行双曲柄机构的连杆与机架的长度相等且两曲柄长度相等、曲柄转向相同的双曲柄机构。', '', '&lt;h1&gt;&lt;span style=&quot;font-size:24px&quot;&gt;&lt;span style=&quot;font-family:黑体&quot;&gt;平行双曲柄机构&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;在铰链四杆机构中，若两连架杆均为曲柄，此四连杆机构称为双曲柄机构。&lt;br /&gt;\r\n如连杆与机架的长度相等且两曲柄长度相等、曲柄转向相同的双曲柄机构就为平行双曲柄机构。该机构有2个死点位置，无急回特性，如下图所示&lt;/span&gt;&lt;/span&gt;。&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/20160516093503.png&quot; style=&quot;height:518px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输入曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/_8.png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;输入曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/jiaosudu.png&quot; style=&quot;height:242px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;输入曲柄角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/jjsd.png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;输出曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/1_1.png&quot; style=&quot;height:245px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;输出曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/jsu.png&quot; style=&quot;height:243px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;输出曲柄角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/jiaosudu_1.png&quot; style=&quot;height:242px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;输出曲柄相对输入曲柄的角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/2.png&quot; style=&quot;height:245px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;双曲柄存在条件&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;br /&gt;\r\n&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:14px&quot;&gt;1.最短杆与最长杆的长度之和小于或等于其他两杆长度之和&lt;br /&gt;\r\n2.机架为最短杆&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', NULL, 107, 'http://www.heitaolab.com/uploads/image/20160516/toutu.png', '2016-05-16 09:55:55', 10000),
(4, '双摇杆机构', 'publish', 'R', 'R5,R6', 'R-R5,R-R6', '铰链四杆机构中两两连架杆均为摇杆，称为双摇杆机构。', '码垛机->http://www.heitaolab.com/uploads/image/20160516/201512062343318998.gif,鹤式起重机->http://www.heitaolab.com/uploads/image/20160516/shyg_gkqzhj.png', '&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;铰链四杆机构中两两连架杆均为摇杆，称为双摇杆机构。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;机构中两摇杆可以分别为主动件。当连杆与摇杆共线时，为机构的两个极限位置。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/20160516135118.png&quot; style=&quot;height:524px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;h1&gt;一、双摇杆机构的判别方法：&lt;/h1&gt;\r\n\r\n&lt;h1&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;1.最长杆长度+最短杆长度 &amp;le; 其他两杆长度之和，取最短杆的对边为机架时。&lt;br /&gt;\r\n2. 如果最长杆长度+最短杆长度 &amp;gt;其他两杆长度之和，此时不论以何杆为机架，均为双摇杆机构。&lt;/span&gt;&lt;/span&gt;&lt;br /&gt;\r\n二、有1到2个死点位置，无急回特性&lt;/h1&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;主动件角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan1.png&quot; style=&quot;height:241px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;主动件角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan2.png&quot; style=&quot;height:249px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;主动件角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan3.png&quot; style=&quot;height:242px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;输出杆角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan3 (2).png&quot; style=&quot;height:244px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;输出杆角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan3 (3).png&quot; style=&quot;height:242px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;输出杆角加速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan4.png&quot; style=&quot;height:243px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;输出杆角位移相对于输入杆角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/baigan5.png&quot; style=&quot;height:240px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;strong&gt;双摇杆机构应用实例：&lt;/strong&gt;电风扇摇头机构，起重机机构&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n', NULL, 153, 'http://www.heitaolab.com/uploads/image/20160516/shyg_gkqzhj_1.png', '2016-05-16 14:05:57', 10000),
(5, '曲柄滑块机构', 'undershelf', 'R', 'M2', 'R-M2', '用曲柄和滑块来实现转动和移动相互转换的平面连杆机构，也称曲柄连杆机构。', '', '&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;曲柄滑块机构广泛应用于往复活塞式发动机、压缩机、冲床等的主机构中，把往复移动转换为不整周或整周的回转运动；压缩机、冲床以曲柄为主动件，把整周转动转换为往复移动。偏置曲柄滑块机构的滑块具有急回特性，锯床就是利用这一特性来达到锯条的慢进和空程急回的目的。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;曲柄角位移&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/qubinghuankuai.png&quot; style=&quot;height:243px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;曲柄角速度&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.heitaolab.com/uploads/image/20160516/qubinghuankuai1.png&quot; style=&quot;height:241px; width:520px&quot; /&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', NULL, 3, NULL, '2016-05-16 16:45:05', 10000);

-- --------------------------------------------------------

--
-- 表的结构 `manage`
--

CREATE TABLE IF NOT EXISTS `manage` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `Title` varchar(256) DEFAULT NULL COMMENT '标题',
  `Visibility` tinyint(1) DEFAULT '1' COMMENT '支持可见性',
  `Tag` varchar(20) DEFAULT NULL COMMENT '类别',
  `Body` mediumtext COMMENT '正文文本',
  `HitCount` bigint(15) NOT NULL DEFAULT '0' COMMENT '点击量',
  `Time` datetime DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站支持信息表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `manage`
--

INSERT INTO `manage` (`ID`, `Title`, `Visibility`, `Tag`, `Body`, `HitCount`, `Time`) VALUES
(1, '如何发布机构', 1, 'help', '&lt;p&gt;只要您注册了黑桃Lab的账号就有权发布机构。&lt;/p&gt;\r\n\r\n&lt;p&gt;如果您账号等级为一般用户，那么您发布的机构将要通过网站管理员审核后才能被别人查看。&lt;/p&gt;\r\n\r\n&lt;p&gt;发布机构页面中：标题为必选项，输入运动和输出运动至少选择一个选项，简介和正文都不可留空，实例为可选内容。&lt;/p&gt;\r\n\r\n&lt;p&gt;发布机构地址&lt;a href=&quot;http://www.heitaolab.com/article/publish.php&quot;&gt;http://www.heitaolab.com/article/publish.php&lt;/a&gt;&lt;/p&gt;\r\n', 98, '2016-04-30 10:57:04'),
(2, '如何注册账号', 1, 'help', '&lt;p&gt;黑桃Lab网站使用邮箱账号统一注册，在注册时，您必须使用您自己的邮箱来注册，我们将向您邮箱发送验证码，来证实您是改邮箱的主人。&lt;/p&gt;\r\n\r\n&lt;p&gt;注册地址&lt;a href=&quot;http://www.heitaolab.com/user/register.php&quot;&gt;http://www.heitaolab.com/user/register.php&lt;/a&gt;&lt;/p&gt;\r\n', 79, '2016-04-30 10:50:43'),
(3, '如何找回密码', 1, 'help', '&lt;p&gt;如果您不小心忘记了密码，你可以到&lt;a href=&quot;http://www.heitaolab.com/user/safe.php&quot;&gt;安全中心&lt;/a&gt;，然后按照提示填写表单找回密码。&lt;/p&gt;\r\n\r\n&lt;p&gt;为了提高您账号安全性，我们建议您设置安全问题。&lt;/p&gt;\r\n', 59, '2016-04-30 11:03:44');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` bigint(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '账号ID',
  `Email` char(40) DEFAULT NULL COMMENT '邮箱',
  `Password` varchar(255) DEFAULT NULL COMMENT '密码',
  `Security` char(200) DEFAULT NULL COMMENT '密保问题',
  `Name` char(12) DEFAULT NULL COMMENT '姓名',
  `LV` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '等级',
  `XP` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '经验',
  `Points` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `Role` char(5) NOT NULL DEFAULT 'User' COMMENT '账户角色',
  `Gender` char(2) NOT NULL DEFAULT '保密' COMMENT '性别',
  `Birthday` date DEFAULT '1970-01-01' COMMENT '生日',
  `Area` char(40) NOT NULL DEFAULT '未设置' COMMENT '地区',
  `Avatar` char(30) NOT NULL DEFAULT 'default.jpg' COMMENT '头像',
  `Introduction` varchar(300) NOT NULL DEFAULT '填写个人简介，让更多人了解你！' COMMENT '个人介绍',
  `Focus` mediumtext COMMENT '关注',
  `Fans` mediumtext COMMENT '粉丝',
  `RegTime` datetime DEFAULT NULL COMMENT '注册时间',
  `LogTime` datetime DEFAULT NULL COMMENT '最后访问时间',
  `LogIP` char(40) DEFAULT NULL COMMENT '最后访问IP',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站用户信息表' AUTO_INCREMENT=100001 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`ID`, `Email`, `Password`, `Security`, `Name`, `LV`, `XP`, `Points`, `Role`, `Gender`, `Birthday`, `Area`, `Avatar`, `Introduction`, `Focus`, `Fans`, `RegTime`, `LogTime`, `LogIP`) VALUES
(10000, 'master@heitaolab.com', 'r47UFjOxoWLas9D9vHnsl6RV+ynFO/72OIrU54KFuZiDMw68/WsOiADQU54HxAgoDLIwaE9pgeRaXFrJPIY0cA==', NULL, '管理员', 10, 8, 10, 'Root', '男', '1993-09-27', '直辖市,重庆市', '100001467882664.jpg', 'Night gathers, and now my watch begins. It shall not end until my death. I shall take no wife, hold no lands, father no children. I shall wear no crowns and win no glory. I shall live and die at my post. I am the sword in the darkness. I am the watcher on the walls.', NULL, NULL, '2016-03-14 20:27:54', '2016-07-08 18:43:55', '183.228.17.221'),
(10001, '18883183117@163.com', 'ETitcXO4CFN/Qrj3eA7HqQfsFTrQg6WCB1OpGNncmZ4aQvUtOgYIcOFD7lmBLVDw5l5sf58E5tGpkx+AZmcfEA==', NULL, '18883183117', 10, 8, 10, 'Admin', '男', '1993-09-26', '直辖市,重庆市', '100011467521716.jpg', '填写个人简介，让更多人了解你！', NULL, NULL, '2016-04-30 10:41:40', '2016-07-04 19:27:20', '125.84.181.29'),
(10002, 'diaocheng@outlook.com', 'rkLsTKaObcYMvwov5KQySGRJ+hRprG7N2NXzY3dQ+GK4NYL6cd+70mkCr/QjzYsyDqu5ozf5o0PZCUXVk/Rocg==', NULL, 'diaocheng', 10, 8, 10, 'Admin', '保密', '1970-01-01', '未设置', 'default.jpg', '填写个人简介，让更多人了解你！', NULL, NULL, '2016-04-30 10:45:48', '2016-04-30 10:45:48', '106.80.42.42'),
(10003, '752283320@qq.com', '/XYRWilXG/hEMaKDImjaMnqt/BoQwtDLmBUa6i8u46Lkk3sLDMc9zQ6Z8NYasCVnfEXoAkj+0JGpnLNdmqj9WA==', NULL, '752283320', 10, 8, 10, 'Admin', '男', '1993-09-27', '直辖市,重庆市', 'default.jpg', '填写个人简介，让更多人了解你！', NULL, NULL, '2016-04-30 10:44:57', '2016-05-19 12:00:57', '223.104.25.72'),
(100000, 'service@heitaolab.com', 'B3CDixZ3RZMaSIK6T0Vq081Mz/i4zxl8eTewgbECEXsFFIzNKr5vNXotrjSOemBZ23DbpL4AJohwWIUQN0VFtA==', NULL, '网站客服', 10, 8, 10, 'Admin', '男', '1993-09-27', '直辖市,重庆市', '1000001462886718.jpg', '大家好，我是网站客户服务！', NULL, NULL, '2016-05-10 21:20:35', '2016-06-20 13:13:50', '125.84.180.68');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
